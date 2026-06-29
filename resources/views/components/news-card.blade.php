@props(['article'])

<a href="{{ route('news.show', $article->slug) }}" class="card-hover group flex flex-col">
    <div class="mb-4 flex h-40 items-center justify-center rounded-lg bg-gradient-to-br from-primary-50 to-secondary-50">
        <i data-lucide="newspaper" class="h-10 w-10 text-primary/40"></i>
    </div>
    <span class="text-xs font-semibold uppercase tracking-wider text-primary">{{ $article->categoryLabel() }}</span>
    <h3 class="mt-2 text-lg font-semibold text-slate-900 transition group-hover:text-primary">{{ $article->title }}</h3>
    <p class="mt-2 flex-1 text-sm text-slate-500 line-clamp-2">{{ $article->excerpt }}</p>
    <p class="mt-4 text-xs text-slate-400">{{ $article->published_at->format('M j, Y') }}</p>
</a>
