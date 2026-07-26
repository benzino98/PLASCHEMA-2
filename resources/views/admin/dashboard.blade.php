@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_heading', 'Dashboard')

@section('content')
    {{-- Welcome Message --}}
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-900">Welcome back, {{ auth()->user()->name }}! 👋</h2>
        <p class="mt-1 text-sm text-slate-600">Here's what's happening with PLASCHEMA today.</p>
    </div>

    {{-- Stats Grid --}}
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <div class="card hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Healthcare Providers</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $stats['providers'] }}</p>
                    <p class="mt-1 text-xs text-slate-500">{{ $stats['accreditedProviders'] }} accredited</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-primary-50">
                    <i data-lucide="building-2" class="h-6 w-6 text-primary"></i>
                </div>
            </div>
        </div>

        <div class="card hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">News Articles</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $stats['news'] }}</p>
                    <p class="mt-1 text-xs text-slate-500">{{ $stats['publishedNews'] }} published</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-secondary-50">
                    <i data-lucide="newspaper" class="h-6 w-6 text-secondary"></i>
                </div>
            </div>
        </div>

        <div class="card hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Contact Messages</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $stats['messages'] }}</p>
                    <p class="mt-1 text-xs text-slate-500">{{ $stats['unreadMessages'] }} unread</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-accent-50">
                    <i data-lucide="mail" class="h-6 w-6 text-accent-600"></i>
                </div>
            </div>
        </div>

        <div class="card hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">FAQs</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $stats['faqs'] }}</p>
                    <p class="mt-1 text-xs text-slate-500">{{ $stats['healthPlans'] }} health plans</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-primary-50">
                    <i data-lucide="help-circle" class="h-6 w-6 text-primary"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2 mb-8">
        {{-- Enrollment Growth Chart --}}
        <div class="card">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Enrollment Growth</h3>
            <div id="enrollmentChart" style="min-height: 300px;"></div>
        </div>

        {{-- Quick Actions --}}
        <div class="card">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.providers.create') }}" class="flex items-center gap-3 rounded-lg border border-slate-200 p-4 transition hover:border-primary hover:bg-primary-50">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary text-white">
                        <i data-lucide="plus" class="h-5 w-5"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-900">Add New Provider</p>
                        <p class="text-xs text-slate-500">Register a healthcare facility</p>
                    </div>
                </a>
                <a href="#" class="flex items-center gap-3 rounded-lg border border-slate-200 p-4 transition hover:border-secondary hover:bg-secondary-50">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-secondary text-white">
                        <i data-lucide="file-text" class="h-5 w-5"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-900">Create News Article</p>
                        <p class="text-xs text-slate-500">Publish updates and announcements</p>
                    </div>
                </a>
                <a href="#" class="flex items-center gap-3 rounded-lg border border-slate-200 p-4 transition hover:border-accent hover:bg-accent-50">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-accent text-white">
                        <i data-lucide="inbox" class="h-5 w-5"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-900">View Messages</p>
                        <p class="text-xs text-slate-500">Review contact form submissions</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    {{-- Recent Activity --}}
    <div class="grid gap-6 lg:grid-cols-3">
        {{-- Recent News --}}
        <div class="card">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Recent News</h3>
            <div class="space-y-3">
                @forelse($recentNews as $article)
                    <div class="flex items-start gap-3 pb-3 border-b border-slate-100 last:border-0">
                        <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-secondary-50">
                            <i data-lucide="newspaper" class="h-4 w-4 text-secondary"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium text-slate-900 truncate">{{ $article->title }}</p>
                            <p class="text-xs text-slate-500">{{ $article->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">No news articles yet</p>
                @endforelse
            </div>
        </div>

        {{-- Recent Messages --}}
        <div class="card">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Recent Messages</h3>
            <div class="space-y-3">
                @forelse($recentMessages as $message)
                    <div class="flex items-start gap-3 pb-3 border-b border-slate-100 last:border-0">
                        <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-accent-50">
                            <i data-lucide="mail" class="h-4 w-4 text-accent-600"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium text-slate-900 truncate">{{ $message->name }}</p>
                            <p class="text-xs text-slate-500 truncate">{{ $message->subject }}</p>
                            <p class="text-xs text-slate-400">{{ $message->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">No messages yet</p>
                @endforelse
            </div>
        </div>

        {{-- Recent Providers --}}
        <div class="card">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Recent Providers</h3>
            <div class="space-y-3">
                @forelse($recentProviders as $provider)
                    <div class="flex items-start gap-3 pb-3 border-b border-slate-100 last:border-0">
                        <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-primary-50">
                            <i data-lucide="building-2" class="h-4 w-4 text-primary"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium text-slate-900 truncate">{{ $provider->name }}</p>
                            <p class="text-xs text-slate-500">{{ $provider->lga }}</p>
                            <p class="text-xs text-slate-400">{{ $provider->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">No providers yet</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartData = @json($enrollmentChart);
    
    const options = {
        chart: {
            type: 'area',
            height: 300,
            toolbar: { show: false },
            fontFamily: 'Inter, sans-serif',
        },
        series: [{
            name: 'Enrollees',
            data: chartData.series
        }],
        xaxis: {
            categories: chartData.labels,
        },
        colors: ['#0B8F4D'],
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.2,
            }
        },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 3 },
        grid: { borderColor: '#f1f5f9' },
        tooltip: {
            y: {
                formatter: function(value) {
                    return value.toLocaleString() + ' citizens';
                }
            }
        }
    };
    
    const chart = new ApexCharts(document.querySelector("#enrollmentChart"), options);
    chart.render();
});
</script>
@endpush
