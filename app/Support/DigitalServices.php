<?php

namespace App\Support;

use App\Models\SiteSetting;

class DigitalServices
{
    public static function all(): array
    {
        return [
            [
                'key' => 'enrollment',
                'title' => 'Online Enrollment',
                'eyebrow' => 'Get Covered',
                'description' => 'Register yourself and your dependants for affordable, quality healthcare coverage.',
                'icon' => 'user-plus',
                'action' => 'Start Enrollment',
                'url' => self::url('enrollment'),
                'accent' => 'primary',
            ],
            [
                'key' => 'verification',
                'title' => 'Membership Verification',
                'eyebrow' => 'Check Your Status',
                'description' => 'Confirm your PLASCHEMA membership and verify your beneficiary information securely.',
                'icon' => 'shield-check',
                'action' => 'Verify Membership',
                'url' => self::url('verification'),
                'accent' => 'secondary',
            ],
            [
                'key' => 'payment',
                'title' => 'Premium Payment',
                'eyebrow' => 'Stay Protected',
                'description' => 'Pay or renew your health insurance premium online through the secure payment portal.',
                'icon' => 'credit-card',
                'action' => 'Pay Premium',
                'url' => self::url('payment'),
                'accent' => 'amber',
            ],
            [
                'key' => 'support',
                'title' => 'PLASCHEMA Support',
                'eyebrow' => 'We Are Here',
                'description' => 'Get help with enrollment, payments, benefits, providers, or any PLASCHEMA service.',
                'icon' => 'headphones',
                'action' => 'Get Support',
                'url' => self::url('support'),
                'accent' => 'rose',
            ],
        ];
    }

    public static function url(string $service): string
    {
        return SiteSetting::get(
            'services',
            $service.'_url',
            config('plaschema.services.'.$service),
        );
    }
}
