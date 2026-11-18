<?php

return [

    'main' => [
        ['label' => 'Home', 'route' => 'home'],
        ['label' => 'About', 'route' => 'about'],
        ['label' => 'Health Plans', 'route' => 'health-plans'],
        ['label' => 'Services', 'route' => 'services'],
        ['label' => 'Providers', 'route' => 'providers'],
        ['label' => 'News', 'route' => 'news'],
        ['label' => 'Resources', 'route' => 'resources'],
        ['label' => 'Contact', 'route' => 'contact'],
    ],

    'footer_quick' => [
        ['label' => 'About Us', 'route' => 'about'],
        ['label' => 'Digital Services', 'route' => 'services'],
        ['label' => 'Health Plans', 'route' => 'health-plans'],
        ['label' => 'Find a Provider', 'route' => 'providers'],
        ['label' => 'News & Updates', 'route' => 'news'],
        ['label' => 'Downloads', 'route' => 'resources'],
        ['label' => 'FAQs', 'route' => 'faqs'],
        ['label' => 'Contact', 'route' => 'contact'],
    ],

    'footer_services' => [
        ['label' => 'Enroll Online', 'url' => 'plaschema.services.enrollment', 'external' => true],
        ['label' => 'Verify Membership', 'url' => 'plaschema.services.verification', 'external' => true],
        ['label' => 'Pay Premium', 'url' => 'plaschema.services.payment', 'external' => true],
        ['label' => 'Get Support', 'url' => 'plaschema.services.support', 'external' => true],
    ],

    'emergency_numbers' => [
        ['label' => 'PLASCHEMA Hotline', 'number' => '0800-000-0000'],
        ['label' => 'Ambulance', 'number' => '112'],
        ['label' => 'Emergency', 'number' => '199'],
    ],

    'social' => [
        ['label' => 'Facebook', 'url' => '#', 'svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-full w-full"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>'],
        ['label' => 'X (Twitter)', 'url' => '#', 'svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-full w-full"><path d="M4 4l11.733 16h4.267l-11.733 -16z"></path><path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772"></path></svg>'],
        ['label' => 'Instagram', 'url' => '#', 'svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-full w-full"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line></svg>'],
        ['label' => 'LinkedIn', 'url' => '#', 'svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-full w-full"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect width="4" height="12" x="2" y="9"></rect><circle cx="4" cy="4" r="2"></circle></svg>'],
    ],

];
