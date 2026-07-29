@php
    $analyticsId = config('services.analytics.id');
    $analyticsDomain = config('services.analytics.domain');
    $provider = config('services.analytics.provider');
@endphp

@push('scripts')
@if ($provider === 'plausible' && $analyticsDomain)
<script defer src="https://plausible.io/js/script.js" data-domain="{{ $analyticsDomain }}"></script>
@endif

@if ($provider === 'google' && $analyticsId)
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $analyticsId }}"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', '{{ $analyticsId }}');
</script>
@endif

@if ($provider === 'umami' && $analyticsDomain && $analyticsId)
<script defer src="{{ config('services.analytics.script_url', 'https://cloud.umami.is/script.js') }}"
    data-website-id="{{ $analyticsId }}"
    data-domains="{{ $analyticsDomain }}"></script>
@endif
@endpush
