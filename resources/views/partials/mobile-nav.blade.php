{{-- Mobile navigation panel --}}
<div
    id="mobile-nav"
    x-show="mobileNavOpen"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 lg:hidden"
    x-cloak
>
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-slate-900/50" @click="mobileNavOpen = false"></div>

    {{-- Slide-in panel --}}
    <nav
        class="absolute inset-y-0 right-0 flex w-full max-w-sm flex-col bg-white shadow-2xl"
        aria-label="Mobile navigation"
        x-show="mobileNavOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        @click.outside="mobileNavOpen = false"
    >
        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
            <p class="font-semibold text-slate-900">Menu</p>
            <button type="button" class="rounded-lg p-2 text-slate-500 hover:bg-slate-100" @click="mobileNavOpen = false" aria-label="Close menu">
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto px-4 py-4">
            <ul class="space-y-1">
                @foreach (config('navigation.main') as $item)
                    <li>
                        <x-nav-link :item="$item" :mobile="true" />
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="space-y-3 border-t border-slate-200 p-6">
            <a href="{{ config('plaschema.services.enrollment') }}" class="btn-primary w-full" target="_blank" rel="noopener noreferrer">
                Enroll Now
            </a>
            <a href="{{ config('plaschema.services.verification') }}" class="btn-outline w-full" target="_blank" rel="noopener noreferrer">
                Verify Enrollment
            </a>
        </div>
    </nav>
</div>
