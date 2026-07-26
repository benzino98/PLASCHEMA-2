@extends('layouts.app')

@section('title', 'Home')

@section('content')
    {{-- Hero --}}
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-primary/90 via-primary to-secondary/80"></div>
        @if (!empty($hero['background_image']))
            <div class="absolute inset-0 bg-cover bg-center opacity-20 mix-blend-overlay" style="background-image: url('{{ $hero['background_image'] }}')"></div>
        @endif
        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 sm:py-28 lg:px-8 lg:py-32">
            <div class="mx-auto max-w-3xl text-center">
                <p class="text-sm font-semibold uppercase tracking-wider text-white/80">{{ $hero['eyebrow'] }}</p>
                <h1 class="mt-4 text-4xl font-bold tracking-tight text-white sm:text-5xl lg:text-6xl">
                    {{ $hero['title'] }}
                </h1>
                <p class="mt-6 text-lg leading-relaxed text-white/90">
                    {{ $hero['description'] }}
                </p>
                <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
                    <a href="{{ $services[0]['url'] }}" class="inline-flex items-center gap-2 rounded-[var(--radius-button)] bg-white px-6 py-3 text-sm font-semibold text-primary shadow-lg transition hover:bg-slate-50" target="_blank" rel="noopener noreferrer">
                        <i data-lucide="user-plus" class="h-4 w-4"></i> Enroll Now
                    </a>
                    <a href="{{ $services[1]['url'] }}" class="inline-flex items-center gap-2 rounded-[var(--radius-button)] border-2 border-white/40 px-6 py-3 text-sm font-semibold text-white transition hover:border-white hover:bg-white/10" target="_blank" rel="noopener noreferrer">
                        <i data-lucide="shield-check" class="h-4 w-4"></i> Verify Enrollment
                    </a>
                    <a href="{{ route('providers') }}" class="inline-flex items-center gap-2 rounded-[var(--radius-button)] border-2 border-white/40 px-6 py-3 text-sm font-semibold text-white transition hover:border-white hover:bg-white/10">
                        <i data-lucide="map-pin" class="h-4 w-4"></i> Find Hospital
                    </a>
                    <a href="{{ $services[2]['url'] }}" class="inline-flex items-center gap-2 rounded-[var(--radius-button)] border-2 border-white/40 px-6 py-3 text-sm font-semibold text-white transition hover:border-white hover:bg-white/10" target="_blank" rel="noopener noreferrer">
                        <i data-lucide="credit-card" class="h-4 w-4"></i> Renew Membership
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Digital Services Hub --}}
    <x-section title="Access Digital Services" subtitle="Do More Online" centered class="bg-surface">
        <x-service-grid :services="$services" :compact="true" />
        <div class="mt-10 text-center"><a href="{{ route('services') }}" class="btn-outline">Explore All Digital Services <i data-lucide="arrow-right" class="h-4 w-4"></i></a></div>
    </x-section>

    {{-- Statistics --}}
    <x-section title="PLASCHEMA at a Glance" subtitle="Impact" centered class="bg-white">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($stats as $stat)
                <x-stat-card :value="$stat['value']" :label="$stat['label']" :icon="$stat['icon'] ?? null" />
            @endforeach
        </div>
        <div class="mt-10 card">
            <h3 class="text-lg font-semibold text-slate-900">Enrollment Growth</h3>
            <p class="mt-1 text-sm text-slate-500">Total enrolled citizens over time</p>
            <div id="enrollment-chart" class="mt-6" style="min-height: 320px;"></div>
        </div>
    </x-section>

    {{-- Why PLASCHEMA --}}
    <x-section title="Why Choose PLASCHEMA" subtitle="Our Promise" centered class="bg-surface">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($whyPlaschema as $item)
                <div class="card-hover text-center">
                    <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-primary-50 text-primary">
                        <i data-lucide="{{ $item['icon'] }}" class="h-6 w-6"></i>
                    </div>
                    <h3 class="font-semibold text-slate-900">{{ $item['title'] }}</h3>
                    <p class="mt-2 text-sm text-slate-500">{{ $item['description'] }}</p>
                </div>
            @endforeach
        </div>
    </x-section>

    {{-- Health Plans teaser --}}
    <x-section title="Health Insurance Plans" subtitle="Coverage Options" centered class="bg-white">
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($plans as $plan)
                <x-plan-card
                    :name="$plan->name"
                    :price="$plan->price_label"
                    :description="$plan->description"
                    :highlighted="$plan->is_featured"
                />
            @endforeach
        </div>
        <div class="mt-10 text-center">
            <a href="{{ route('health-plans') }}" class="btn-outline">View All Plans &amp; Benefits</a>
        </div>
    </x-section>

    {{-- Success Stories --}}
  @if ($stories->isNotEmpty())
        <x-section title="Success Stories" subtitle="Real Impact" centered class="bg-surface">
            <div class="grid gap-6 md:grid-cols-3">
                @foreach ($stories as $story)
                    <x-story-card :story="$story" />
                @endforeach
            </div>
        </x-section>
    @endif

    {{-- News preview --}}
    @if ($latestNews->isNotEmpty())
        <x-section title="Latest News" subtitle="Updates" centered class="bg-white">
            <div class="grid gap-6 md:grid-cols-3">
                @foreach ($latestNews as $article)
                    <x-news-card :article="$article" />
                @endforeach
            </div>
            <div class="mt-10 text-center">
                <a href="{{ route('news') }}" class="btn-outline">View All News</a>
            </div>
        </x-section>
    @endif

    {{-- FAQ preview --}}
    <x-section title="Frequently Asked Questions" subtitle="Help Center" centered class="bg-surface">
        <div class="mx-auto max-w-3xl">
            <x-accordion :items="$faqs->map(fn ($f) => ['question' => $f->question, 'answer' => $f->answer])->values()->all()" />
            <div class="mt-8 text-center">
                <a href="{{ route('faqs') }}" class="text-sm font-semibold text-primary hover:text-primary-700">View all FAQs &rarr;</a>
            </div>
        </div>
    </x-section>

    <x-cta
        title="Ready to Get Covered?"
        description="Join thousands of Plateau citizens already enjoying affordable, quality healthcare through PLASCHEMA."
        primary-label="Start Enrollment"
        :primary-url="config('plaschema.services.enrollment')"
        :primary-external="true"
        secondary-label="Contact Us"
        :secondary-url="route('contact')"
        variant="gradient"
    />
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const chartData = @json($chartData);
        if (chartData.labels && document.querySelector('#enrollment-chart')) {
            new ApexCharts(document.querySelector('#enrollment-chart'), {
                chart: { type: 'area', height: 320, toolbar: { show: false }, fontFamily: 'Inter, sans-serif' },
                series: [{ name: 'Enrolled Citizens', data: chartData.series }],
                xaxis: { categories: chartData.labels },
                colors: ['#0B8F4D'],
                fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05 } },
                stroke: { curve: 'smooth', width: 2 },
                dataLabels: { enabled: false },
                grid: { borderColor: '#f1f5f9' },
                yaxis: { labels: { formatter: (v) => v >= 1000 ? (v/1000) + 'K' : v } },
            }).render();
        }
    });
</script>
@endpush
