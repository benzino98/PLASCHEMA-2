@extends('layouts.admin')

@section('title', 'Contact Messages')
@section('page_heading', 'Contact Messages')

@section('content')
    {{-- Header with Actions --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-slate-600">
                {{ $messages->total() }} total messages
                @if($messages->where('read_at', null)->count() > 0)
                    • <span class="font-semibold text-accent-600">{{ $messages->where('read_at', null)->count() }} unread</span>
                @endif
            </p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card mb-6">
        <form method="GET" action="{{ route('admin.messages.index') }}" class="flex flex-col gap-4 sm:flex-row">
            <div class="flex-1">
                <label for="search" class="sr-only">Search messages</label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <i data-lucide="search" class="h-5 w-5 text-slate-400"></i>
                    </div>
                    <input
                        type="text"
                        name="search"
                        id="search"
                        value="{{ $filters['search'] ?? '' }}"
                        placeholder="Search by name, email, subject..."
                        class="block w-full rounded-lg border border-slate-200 py-2 pl-10 pr-3 text-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                    >
                </div>
            </div>
            <div class="flex gap-2">
                <select
                    name="status"
                    class="rounded-lg border border-slate-200 px-4 py-2 text-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                >
                    <option value="">All Messages</option>
                    <option value="unread" {{ ($filters['status'] ?? '') === 'unread' ? 'selected' : '' }}>Unread</option>
                    <option value="read" {{ ($filters['status'] ?? '') === 'read' ? 'selected' : '' }}>Read</option>
                </select>
                <button type="submit" class="btn-primary">
                    <i data-lucide="filter" class="h-4 w-4"></i>
                    Filter
                </button>
                @if(!empty($filters['search']) || !empty($filters['status']))
                    <a href="{{ route('admin.messages.index') }}" class="btn-outline">
                        <i data-lucide="x" class="h-4 w-4"></i>
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Messages Table --}}
    <div class="card overflow-hidden p-0">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="border-b border-slate-200 bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">
                            From
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">
                            Subject
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">
                            Date
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-600">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($messages as $message)
                        <tr class="transition hover:bg-slate-50 {{ $message->read_at ? '' : 'bg-primary-50/30' }}">
                            <td class="whitespace-nowrap px-6 py-4">
                                @if($message->read_at)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2 py-1 text-xs font-medium text-slate-600">
                                        <i data-lucide="mail-open" class="h-3 w-3"></i>
                                        Read
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-accent-100 px-2 py-1 text-xs font-medium text-accent-700">
                                        <i data-lucide="mail" class="h-3 w-3"></i>
                                        Unread
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <p class="text-sm font-semibold text-slate-900 {{ $message->read_at ? '' : 'font-bold' }}">
                                        {{ $message->name }}
                                    </p>
                                    <p class="text-xs text-slate-500">{{ $message->email }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-slate-900 {{ $message->read_at ? '' : 'font-semibold' }}">
                                    {{ Str::limit($message->subject, 60) }}
                                </p>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500">
                                {{ $message->created_at->format('M d, Y') }}
                                <br>
                                <span class="text-xs text-slate-400">{{ $message->created_at->format('g:i A') }}</span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                                <div class="flex items-center justify-end gap-2">
                                    <a
                                        href="{{ route('admin.messages.show', $message) }}"
                                        class="inline-flex items-center gap-1 rounded-lg bg-primary px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-primary-700"
                                    >
                                        <i data-lucide="eye" class="h-3 w-3"></i>
                                        View
                                    </a>
                                    <form
                                        method="POST"
                                        action="{{ route('admin.messages.destroy', $message) }}"
                                        onsubmit="return confirm('Are you sure you want to delete this message?')"
                                        class="inline"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="inline-flex items-center gap-1 rounded-lg bg-red-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-red-700"
                                        >
                                            <i data-lucide="trash-2" class="h-3 w-3"></i>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-slate-100">
                                        <i data-lucide="inbox" class="h-8 w-8 text-slate-400"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900">No messages found</p>
                                        <p class="text-xs text-slate-500">Messages from the contact form will appear here</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($messages->hasPages())
            <div class="border-t border-slate-200 px-6 py-4">
                {{ $messages->links() }}
            </div>
        @endif
    </div>
@endsection
