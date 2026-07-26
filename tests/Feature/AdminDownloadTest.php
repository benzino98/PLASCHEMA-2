<?php

namespace Tests\Feature;

use App\Models\Download;
use App\Models\User;
use Database\Seeders\ContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminDownloadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ContentSeeder::class);
        Storage::fake('public');
    }

    public function test_admin_can_upload_valid_document(): void
    {
        $admin = User::where('role', 'admin')->firstOrFail();
        $file = UploadedFile::fake()->create('enrollment-form.pdf', 512, 'application/pdf');

        $this->actingAs($admin)->post(route('admin.downloads.store'), [
            'title' => 'Enrollment Form 2026', 'category' => 'form',
            'description' => 'Official enrollment form.', 'file' => $file, 'is_published' => 1,
        ])->assertRedirect(route('admin.downloads.index'));

        $download = Download::where('slug', 'enrollment-form-2026')->firstOrFail();
        $this->assertSame('application/pdf', $download->mime_type);
        $this->assertGreaterThan(0, $download->file_size);
        Storage::disk('public')->assertExists($download->file_path);
    }

    public function test_executable_upload_is_rejected(): void
    {
        $admin = User::where('role', 'admin')->firstOrFail();

        $this->actingAs($admin)->post(route('admin.downloads.store'), [
            'title' => 'Unsafe File', 'category' => 'form',
            'file' => UploadedFile::fake()->create('malware.exe', 10, 'application/x-msdownload'),
        ])->assertSessionHasErrors('file');

        $this->assertDatabaseMissing('downloads', ['title' => 'Unsafe File']);
    }

    public function test_replacement_and_deletion_remove_old_files(): void
    {
        $admin = User::where('role', 'admin')->firstOrFail();
        $oldPath = UploadedFile::fake()->create('old.pdf', 100, 'application/pdf')->store('downloads', 'public');
        $download = Download::create([
            'title' => 'Old Report', 'slug' => 'old-report', 'category' => 'report', 'file_path' => $oldPath,
            'file_size' => 100, 'mime_type' => 'application/pdf', 'is_published' => true,
        ]);

        $this->actingAs($admin)->put(route('admin.downloads.update', $download), [
            'title' => 'New Report', 'category' => 'report', 'file' => UploadedFile::fake()->create('new.pdf', 200, 'application/pdf'), 'is_published' => 1,
        ])->assertRedirect(route('admin.downloads.index'));

        $download->refresh();
        Storage::disk('public')->assertMissing($oldPath);
        Storage::disk('public')->assertExists($download->file_path);

        $this->actingAs($admin)->delete(route('admin.downloads.destroy', $download));
        Storage::disk('public')->assertMissing($download->file_path);
    }
}
