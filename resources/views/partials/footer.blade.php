<footer class="border-t border-slate-200 bg-slate-900 text-slate-300">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
        <div class="grid gap-10 lg:grid-cols-12">
            {{-- Brand & newsletter --}}
            <div class="lg:col-span-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-[var(--radius-card)] bg-primary text-sm font-bold text-white">P</div>
                    <div>
                        <p class="font-bold text-white">PLASCHEMA</p>
                        <p class="text-xs text-slate-400">Affordable Healthcare For All</p>
                    </div>
                </div>
                <p class="mt-4 text-sm leading-relaxed text-slate-400">
                    Plateau State Contributory Healthcare Management Agency — ensuring accessible, quality healthcare for every citizen.
                </p>

                {{-- Newsletter --}}
                <div class="mt-6" x-data="{ email: '' }">
                    <p class="text-sm font-semibold text-white">Newsletter</p>
                    <p class="mt-1 text-xs text-slate-400">Stay updated on health campaigns and news.</p>
                    <form class="mt-3 flex gap-2" @submit.prevent="window.notyf.success('Subscribed! We will keep you updated.'); email = ''">
                        <label for="newsletter-email" class="sr-only">Email address</label>
                        <input
                            id="newsletter-email"
                            type="email"
                            x-model="email"
                            required
                            placeholder="your@email.com"
                            class="min-w-0 flex-1 rounded-[var(--radius-button)] border border-slate-700 bg-slate-800 px-3 py-2 text-sm text-white placeholder:text-slate-500 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                        >
                        <button type="submit" class="shrink-0 rounded-[var(--radius-button)] bg-primary px-4 py-2 text-sm font-semibold text-white transition hover:bg-primary-700">
                            Join
                        </button>
                    </form>
                </div>
            </div>

            {{-- Quick links --}}
            <div class="lg:col-span-2">
                <p class="text-sm font-semibold text-white">Quick Links</p>
                <ul class="mt-4 space-y-2">
                    @foreach (config('navigation.footer_quick') as $link)
                        <li>
                            <a href="{{ route($link['route']) }}" class="text-sm text-slate-400 transition hover:text-white">
                                {{ $link['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Digital services --}}
            <div class="lg:col-span-2">
                <p class="text-sm font-semibold text-white">Digital Services</p>
                <ul class="mt-4 space-y-2">
                    @foreach (\App\Support\DigitalServices::all() as $service)
                        <li>
                            <a href="{{ $service['url'] }}" class="text-sm text-slate-400 transition hover:text-white" target="_blank" rel="noopener noreferrer">
                                {{ $service['title'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Contact & emergency --}}
            <div class="lg:col-span-4">
                <p class="text-sm font-semibold text-white">Contact</p>
                <ul class="mt-4 space-y-3 text-sm text-slate-400">
                    <li class="flex items-start gap-2">
                        <i data-lucide="map-pin" class="mt-0.5 h-4 w-4 shrink-0 text-primary"></i>
                        {{ config('plaschema.contact.address') }}
                    </li>
                    <li class="flex items-center gap-2">
                        <i data-lucide="mail" class="h-4 w-4 shrink-0 text-primary"></i>
                        <a href="mailto:{{ config('plaschema.contact.email') }}" class="transition hover:text-white">
                            {{ config('plaschema.contact.email') }}
                        </a>
                    </li>
                    @if (config('plaschema.contact.phone'))
                        <li class="flex items-center gap-2">
                            <i data-lucide="phone" class="h-4 w-4 shrink-0 text-primary"></i>
                            {{ config('plaschema.contact.phone') }}
                        </li>
                    @endif
                </ul>

                <p class="mt-6 text-sm font-semibold text-white">Emergency Numbers</p>
                <ul class="mt-3 space-y-2">
                    @foreach (config('navigation.emergency_numbers') as $emergency)
                        <li class="flex items-center justify-between rounded-lg bg-slate-800/60 px-3 py-2 text-sm">
                            <span class="text-slate-400">{{ $emergency['label'] }}</span>
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $emergency['number']) }}" class="font-semibold text-accent">
                                {{ $emergency['number'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                {{-- Social --}}
                <div class="mt-6 flex gap-3">
                    @foreach (config('navigation.social') as $social)
                        <a
                            href="{{ $social['url'] }}"
                            class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-800 text-slate-400 transition hover:bg-primary hover:text-white"
                            aria-label="{{ $social['label'] }}"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            <i data-lucide="{{ $social['icon'] }}" class="h-4 w-4"></i>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mt-12 flex flex-col items-center justify-between gap-4 border-t border-slate-800 pt-8 sm:flex-row">
            <p class="text-xs text-slate-500">
                &copy; {{ date('Y') }} PLASCHEMA — Plateau State Contributory Healthcare Management Agency. All rights reserved.
            </p>
            <p class="text-xs text-slate-500">
                A government of Plateau State initiative
            </p>
        </div>
    </div>
</footer>
