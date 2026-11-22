<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class DeployController extends Controller
{
    /**
     * Verify that the request has the correct DEPLOY_KEY.
     */
    private function verifyKey(Request $request): string
    {
        $configuredKey = (string) config('plaschema.deploy_key');

        if (trim($configuredKey) === '') {
            abort(403, 'Deployment console is disabled. Set DEPLOY_KEY in your server .env file.');
        }

        $providedKey = (string) (
            $request->header('X-Deploy-Key')
            ?? $request->bearerToken()
            ?? $request->query('key')
            ?? $request->input('key')
            ?? ''
        );

        if (! hash_equals($configuredKey, $providedKey)) {
            abort(403, 'Unauthorized: Invalid or missing deployment key.');
        }

        return $configuredKey;
    }

    /**
     * Display the deployment dashboard.
     */
    public function index(Request $request): Response
    {
        $key = $this->verifyKey($request);
        $status = $this->gatherSystemStatus();

        return response()->view('deploy.index', [
            'key' => $key,
            'status' => $status,
            'output' => session('deploy_output', 'Select an action above to execute on the server.'),
            'lastAction' => session('deploy_action', 'status'),
        ]);
    }

    /**
     * Execute an Artisan maintenance action.
     */
    public function run(Request $request): JsonResponse|Response
    {
        $key = $this->verifyKey($request);
        $action = (string) $request->input('action', $request->query('action', 'status'));

        $output = '';
        $success = true;

        try {
            switch ($action) {
                case 'migrate':
                    Artisan::call('migrate', ['--force' => true]);
                    $output = Artisan::output();
                    break;

                case 'seed':
                    Artisan::call('db:seed', ['--force' => true]);
                    $output = Artisan::output();
                    break;

                case 'storage_link':
                    $output = $this->ensureStorageLink();
                    break;

                case 'optimize':
                    Artisan::call('optimize');
                    $output = Artisan::output();
                    break;

                case 'clear':
                    Artisan::call('optimize:clear');
                    $output = Artisan::output();
                    break;

                case 'all':
                    Artisan::call('migrate', ['--force' => true]);
                    $output = "=== 1. DATABASE MIGRATIONS ===\n".Artisan::output()."\n";

                    $output .= "=== 2. STORAGE SYMLINK ===\n".$this->ensureStorageLink()."\n";

                    Artisan::call('optimize');
                    $output .= "=== 3. CACHE & OPTIMIZATION ===\n".Artisan::output();
                    break;

                case 'status':
                default:
                    $action = 'status';
                    Artisan::call('migrate:status');
                    $output = "=== MIGRATION STATUS ===\n".Artisan::output();
                    break;
            }
        } catch (\Throwable $e) {
            $success = false;
            $output .= "\n[EXCEPTION OCCURRED]: ".$e->getMessage()."\n".$e->getFile().':'.$e->getLine();
        }

        if ($request->wantsJson() || $request->hasHeader('X-Deploy-Key')) {
            return response()->json([
                'success' => $success,
                'action' => $action,
                'output' => $output,
                'timestamp' => now()->toIso8601String(),
            ], $success ? 200 : 500);
        }

        $systemStatus = $this->gatherSystemStatus();

        return response()->view('deploy.index', [
            'key' => $key,
            'status' => $systemStatus,
            'output' => $output,
            'lastAction' => $action,
            'success' => $success,
        ]);
    }

    /**
     * Gather system health and connectivity details.
     *
     * @return array<string, mixed>
     */
    private function gatherSystemStatus(): array
    {
        $dbConnected = false;
        $dbError = null;

        try {
            DB::connection()->getPdo();
            $dbConnected = true;
        } catch (\Throwable $e) {
            $dbError = $e->getMessage();
        }

        $publicStorage = public_path('storage');
        $hasStorageLink = is_link($publicStorage) || file_exists($publicStorage);

        return [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'app_env' => config('app.env'),
            'app_debug' => config('app.debug'),
            'db_connected' => $dbConnected,
            'db_error' => $dbError,
            'db_name' => config('database.connections.'.config('database.default').'.database'),
            'storage_linked' => $hasStorageLink,
            'public_path' => public_path(),
            'base_path' => base_path(),
        ];
    }

    /**
     * Create public storage link with fallback to native symlink.
     */
    private function ensureStorageLink(): string
    {
        $publicStorage = public_path('storage');
        $appPublic = storage_path('app/public');

        if (is_link($publicStorage) || file_exists($publicStorage)) {
            return "Storage link already exists at: {$publicStorage}\n";
        }

        try {
            Artisan::call('storage:link');

            return Artisan::output();
        } catch (\Throwable $e) {
            if (function_exists('symlink')) {
                if (@symlink($appPublic, $publicStorage)) {
                    return "Created storage symlink via PHP symlink():\n{$publicStorage} -> {$appPublic}\n";
                }
            }

            return "Could not create storage link: {$e->getMessage()}\nTarget: {$appPublic}\nLink: {$publicStorage}\n";
        }
    }
}
