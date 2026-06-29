<header class="sticky top-0 z-40 border-b border-slate-200/80 bg-white/95 backdrop-blur supports-[backdrop-filter]:bg-white/80">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8">
        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-[var(--radius-card)] bg-primary text-sm font-bold text-white shadow-sm">
                P
            </div>
            <div class="hidden sm:block">
                <p class="text-sm font-bold leading-tight text-slate-900">PLASCHEMA</p>
                <p class="text-xs text-slate-500">Plateau State Healthcare</p>
            </div>
        </a>

        {{-- Desktop navigation --}}
        <nav class="hidden items-center gap-1 lg:flex" aria-label="Main navigation">
            @foreach (config('navigation.main') as $item)
                <x-nav-link :item="$item" />
            @endforeach
        </nav>

        {{-- Desktop CTA --}}
        <div class="hidden items-center gap-3 lg:flex">
            <a href="{{ config('plaschema.services.verification') }}" class="text-sm font-medium text-slate-600 transition hover:text-primary" target="_blank" rel="noopener noreferrer">
                Verify
            </a>
            <a href="{{ config('plaschema.services.enrollment') }}" class="btn-primary !px-4 !py-2 text-xs" target="_blank" rel="noopener noreferrer">
                Enroll Now
            </a>
        </div>

        {{-- Mobile menu button --}}
        <button
            type="button"
            class="rounded-lg p-2 text-slate-600 transition hover:bg-slate-100 lg:hidden"
            @click="mobileNavOpen = !mobileNavOpen"
            :aria-expanded="mobileNavOpen"
            aria-controls="mobile-nav"
            aria-label="Toggle navigation menu"
        >
            <i data-lucide="menu" class="h-6 w-6" x-show="!mobileNavOpen"></i>
            <i data-lucide="x" class="h-6 w-6" x-show="mobileNavOpen" x-cloak></i>
        </button>
    </div>
</header>
