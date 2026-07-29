@props(['article'])

<a href="{{ route('news.show', $article->slug) }}" class="group flex flex-col rounded-2xl border border-slate-200 bg-white shadow-sm transition-all hover:-translate-y-1 hover:shadow-md overflow-hidden">
    <div class="relative aspect-[16/9] w-full overflow-hidden bg-slate-100">
        @if ($article->featured_image)
            <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-110" loading="lazy">
        @else
            <div class="absolute inset-0 bg-gradient-to-br from-primary-50 to-secondary-50 flex items-center justify-center transition duration-500 group-hover:scale-110">
                <i data-lucide="newspaper" class="h-12 w-12 text-primary/20"></i>
            </div>
        @endif
        <div class="absolute top-3 left-3">
            <span class="inline-flex items-center rounded-full bg-white/95 backdrop-blur px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-primary shadow-sm">
                {{ $article->categoryLabel() }}
            </span>
        </div>
    </div>
    <div class="flex flex-col flex-1 p-5">
        <div class="flex items-center gap-4 text-[11px] font-medium uppercase tracking-wider text-slate-500 mb-3">
            <span class="flex items-center gap-1.5"><i data-lucide="calendar" class="h-3.5 w-3.5"></i> {{ $article->published_at->format('M j, Y') }}</span>
            <span class="flex items-center gap-1.5"><i data-lucide="clock" class="h-3.5 w-3.5"></i> {{ $article->reading_time }} min read</span>
        </div>
        <h3 class="text-lg font-bold text-slate-900 transition group-hover:text-primary leading-snug line-clamp-2 mb-2" title="{{ $article->title }}">{{ $article->title }}</h3>
        <p class="text-sm text-slate-600 line-clamp-3 mb-4 flex-1">{{ $article->excerpt }}</p>
        <div class="mt-auto border-t border-slate-100 pt-4">
            <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-primary">
                Read article <i data-lucide="arrow-right" class="h-4 w-4 transition-transform group-hover:translate-x-1"></i>
            </span>
        </div>
    </div>
</a>
