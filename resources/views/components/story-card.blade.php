@props(['story'])

<div class="card-hover flex flex-col">
    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-primary-50">
        <i data-lucide="quote" class="h-5 w-5 text-primary"></i>
    </div>
    <p class="flex-1 text-sm leading-relaxed text-slate-600">&ldquo;{{ $story->excerpt }}&rdquo;</p>
    <div class="mt-4 border-t border-slate-100 pt-4">
        <p class="text-sm font-semibold text-slate-900">{{ $story->author_name }}</p>
        @if ($story->author_location)
            <p class="text-xs text-slate-500">{{ $story->author_location }}</p>
        @endif
    </div>
</div>
