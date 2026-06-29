<div class="divide-y divide-slate-100 rounded-[var(--radius-card)] border border-slate-200 bg-white" style="box-shadow: var(--shadow-card)">
    @foreach ($items as $download)
        <div class="flex flex-col gap-4 p-4 sm:flex-row sm:items-center sm:justify-between sm:px-6 sm:py-4">
            <div class="flex items-start gap-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-50">
                    <i data-lucide="file-text" class="h-5 w-5 text-red-500"></i>
                </div>
                <div>
                    <h3 class="font-medium text-slate-900">{{ $download->title }}</h3>
                    @if ($download->description)
                        <p class="mt-0.5 text-sm text-slate-500">{{ $download->description }}</p>
                    @endif
                    <p class="mt-1 text-xs text-slate-400">
                        {{ $download->categoryLabel() }} &middot; {{ $download->formattedSize() }}
                        @if ($download->published_at)
                            &middot; {{ $download->published_at->format('M j, Y') }}
                        @endif
                    </p>
                </div>
            </div>
            <a href="{{ route('downloads.download', $download) }}" class="btn-outline shrink-0 !px-4 !py-2 text-xs">
                <i data-lucide="download" class="h-4 w-4"></i>
                Download
            </a>
        </div>
    @endforeach
</div>
