<?php

return [

    'main' => [
        ['label' => 'Home', 'route' => 'home'],
        ['label' => 'About', 'route' => 'about'],
        ['label' => 'Health Plans', 'route' => 'health-plans'],
        ['label' => 'Enroll', 'url' => 'plaschema.services.enrollment', 'external' => true],
        ['label' => 'Providers', 'route' => 'providers'],
        ['label' => 'News', 'route' => 'news'],
        ['label' => 'Resources', 'route' => 'resources'],
        ['label' => 'Contact', 'route' => 'contact'],
    ],

    'footer_quick' => [
        ['label' => 'About Us', 'route' => 'about'],
        ['label' => 'Health Plans', 'route' => 'health-plans'],
        ['label' => 'Find a Provider', 'route' => 'providers'],
        ['label' => 'News & Updates', 'route' => 'news'],
        ['label' => 'Downloads', 'route' => 'resources'],
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
        ['label' => 'Facebook', 'url' => '#', 'icon' => 'facebook'],
        ['label' => 'X (Twitter)', 'url' => '#', 'icon' => 'twitter'],
        ['label' => 'Instagram', 'url' => '#', 'icon' => 'instagram'],
        ['label' => 'LinkedIn', 'url' => '#', 'icon' => 'linkedin'],
    ],

];
