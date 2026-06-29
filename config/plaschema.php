<?php

return [

  /*
  |--------------------------------------------------------------------------
  | External Digital Service URLs
  |--------------------------------------------------------------------------
  */

  'services' => [
    'enrollment' => env('PLASCHEMA_ENROLLMENT_URL', 'https://enrollments.plaschema.app'),
    'verification' => env('PLASCHEMA_VERIFICATION_URL', 'https://enrollments.plaschema.app/beneficiary-lookup'),
    'payment' => env('PLASCHEMA_PAYMENT_URL', 'https://enrollments.plaschema.app/pay/informal'),
    'support' => env('PLASCHEMA_SUPPORT_URL', 'https://support.plaschema.app/support'),
  ],

  /*
  |--------------------------------------------------------------------------
  | Google Maps
  |--------------------------------------------------------------------------
  */

  'google_maps_api_key' => env('GOOGLE_MAPS_API_KEY'),

  /*
  |--------------------------------------------------------------------------
  | Contact & Social (defaults — overridden by CMS in later phases)
  |--------------------------------------------------------------------------
  */

  'contact' => [
    'email' => env('PLASCHEMA_CONTACT_EMAIL', 'info@plaschema.gov.ng'),
    'phone' => env('PLASCHEMA_CONTACT_PHONE', ''),
    'address' => env('PLASCHEMA_CONTACT_ADDRESS', 'Jos, Plateau State, Nigeria'),
  ],

];
