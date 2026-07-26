@extends('layouts.admin')

@section('title', 'Message — ' . $message->subject)
@section('page_heading', 'Message Details')

@section('content')
    {{-- Back Button --}}
    <a href="{{ route('admin.messages.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-primary mb-6 transition">
        <i data-lucide="arrow-left" class="h-4 w-4"></i>
        Back to Messages
    </a>

    <div class="grid gap-6 lg:grid-cols-3">
        {{-- Message Content --}}
        <div class="card lg:col-span-2">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-slate-900">{{ $message->subject }}</h2>
                <div class="flex items-center gap-2">
                    @if($message->read_at)
                        <form method="POST" action="{{ route('admin.messages.unread', $message) }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-1 rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-50">
                                <i data-lucide="mail" class="h-3 w-3"></i>
                                Mark Unread
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.messages.read', $message) }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-1 rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:bg-primary-50 hover:text-primary">
                                <i data-lucide="mail-open" class="h-3 w-3"></i>
                                Mark Read
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <div class="rounded-lg bg-slate-50 p-6">
                <p class="whitespace-pre-wrap text-sm leading-relaxed text-slate-700">{{ $message->message }}</p>
            </div>

            <div class="mt-6 border-t border-slate-100 pt-6">
                <p class="text-xs text-slate-400">
                    <span class="font-medium text-slate-600">Sent:</span>
                    {{ $message->created_at->format('l, F j, Y \\a\\t g:i A') }}
                    @if($message->read_at)
                        &middot;
                        <span class="font-medium text-slate-600">Read:</span>
                        {{ $message->read_at->format('l, F j, Y \\a\\t g:i A') }}
                    @endif
                </p>
            </div>

            {{-- Delete --}}
            <div class="mt-6 border-t border-slate-100 pt-6">
                <form
                    method="POST"
                    action="{{ route('admin.messages.destroy', $message) }}"
                    onsubmit="return confirm('Are you sure you want to permanently delete this message?')"
                >
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-2 text-sm font-semibold text-red-600 transition hover:text-red-700">
                        <i data-lucide="trash-2" class="h-4 w-4"></i>
                        Delete Message
                    </button>
                </form>
            </div>
        </div>

        {{-- Sender Info Sidebar --}}
        <div class="card h-fit">
            <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-500 mb-4">Sender Information</h3>

            <div class="space-y-5">
                <div>
                    <p class="text-xs font-medium uppercase tracking-wider text-slate-400 mb-1">Name</p>
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary-50 text-sm font-bold text-primary">
                            {{ strtoupper(substr($message->name, 0, 1)) }}
                        </div>
                        <p class="text-sm font-semibold text-slate-900">{{ $message->name }}</p>
                    </div>
                </div>

                <div>
                    <p class="text-xs font-medium uppercase tracking-wider text-slate-400 mb-1">Email</p>
                    <a href="mailto:{{ $message->email }}" class="text-sm font-semibold text-primary hover:text-primary-700 transition">
                        {{ $message->email }}
                    </a>
                </div>

                <div>
                    <p class="text-xs font-medium uppercase tracking-wider text-slate-400 mb-1">Subject</p>
                    <p class="text-sm text-slate-900">{{ $message->subject }}</p>
                </div>

                <div>
                    <p class="text-xs font-medium uppercase tracking-wider text-slate-400 mb-1">Status</p>
                    @if($message->read_at)
                        <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">
                            <i data-lucide="mail-open" class="h-3 w-3"></i>
                            Read
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 rounded-full bg-accent-100 px-2.5 py-1 text-xs font-medium text-accent-700">
                            <i data-lucide="mail" class="h-3 w-3"></i>
                            Unread
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
