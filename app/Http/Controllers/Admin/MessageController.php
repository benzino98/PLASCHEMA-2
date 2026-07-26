<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(Request $request): View
    {
        $messages = ContactMessage::query()
            ->when($request->filled('status'), function ($query) use ($request) {
                if ($request->status === 'unread') {
                    $query->whereNull('read_at');
                } elseif ($request->status === 'read') {
                    $query->whereNotNull('read_at');
                }
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = '%'.$request->search.'%';
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', $search)
                        ->orWhere('email', 'like', $search)
                        ->orWhere('subject', 'like', $search)
                        ->orWhere('message', 'like', $search);
                });
            })
            ->latest('created_at')
            ->paginate(20);

        return view('admin.messages.index', [
            'messages' => $messages,
            'filters' => $request->only(['status', 'search']),
        ]);
    }

    public function show(ContactMessage $message): View
    {
        // Mark as read when viewed
        if (! $message->read_at) {
            $message->update(['read_at' => now()]);
        }

        return view('admin.messages.show', compact('message'));
    }

    public function destroy(ContactMessage $message): RedirectResponse
    {
        $message->delete();

        return redirect()->route('admin.messages.index')
            ->with('success', 'Message deleted successfully.');
    }

    public function markAsRead(ContactMessage $message): RedirectResponse
    {
        $message->update(['read_at' => now()]);

        return redirect()->back()
            ->with('success', 'Message marked as read.');
    }

    public function markAsUnread(ContactMessage $message): RedirectResponse
    {
        $message->update(['read_at' => null]);

        return redirect()->back()
            ->with('success', 'Message marked as unread.');
    }
}
