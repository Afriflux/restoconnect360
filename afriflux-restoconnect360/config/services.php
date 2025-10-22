<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CinetPay Configuration
    |--------------------------------------------------------------------------
    */
    'cinetpay' => [
        'api_key' => env('CINETPAY_API_KEY'),
        'site_id' => env('CINETPAY_SITE_ID'),
        'environment' => env('CINETPAY_ENVIRONMENT', 'sandbox'),
        'notify_url' => env('CINETPAY_NOTIFY_URL', env('APP_URL') . '/api/payments/cinetpay/webhook'),
        'return_url' => env('CINETPAY_RETURN_URL', env('APP_URL') . '/payments/success'),
        'cancel_url' => env('CINETPAY_CANCEL_URL', env('APP_URL') . '/payments/cancel'),
    ],

    /*
    |--------------------------------------------------------------------------
    | PayTech Configuration
    |--------------------------------------------------------------------------
    */
    'paytech' => [
        'api_key' => env('PAYTECH_API_KEY'),
        'merchant_id' => env('PAYTECH_MERCHANT_ID'),
        'environment' => env('PAYTECH_ENVIRONMENT', 'sandbox'),
        'notify_url' => env('PAYTECH_NOTIFY_URL', env('APP_URL') . '/api/payments/paytech/webhook'),
        'success_url' => env('PAYTECH_SUCCESS_URL', env('APP_URL') . '/payments/success'),
        'cancel_url' => env('PAYTECH_CANCEL_URL', env('APP_URL') . '/payments/cancel'),
    ],

    /*
    |--------------------------------------------------------------------------
    | WhatsApp Business API Configuration
    |--------------------------------------------------------------------------
    */
    'whatsapp' => [
        'token' => env('WHATSAPP_TOKEN'),
        'phone_number_id' => env('WHATSAPP_PHONE_NUMBER_ID'),
        'business_account_id' => env('WHATSAPP_BUSINESS_ACCOUNT_ID'),
        'verify_token' => env('WHATSAPP_VERIFY_TOKEN', 'restoconnect360_verify'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Google Maps API Configuration
    |--------------------------------------------------------------------------
    */
    'google_maps' => [
        'api_key' => env('GOOGLE_MAPS_API_KEY'),
        'places_api_key' => env('GOOGLE_PLACES_API_KEY', env('GOOGLE_MAPS_API_KEY')),
    ],

    /*
    |--------------------------------------------------------------------------
    | Twilio Configuration (SMS)
    |--------------------------------------------------------------------------
    */
    'twilio' => [
        'sid' => env('TWILIO_SID'),
        'token' => env('TWILIO_TOKEN'),
        'from' => env('TWILIO_FROM'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Stripe Configuration
    |--------------------------------------------------------------------------
    */
    'stripe' => [
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
    ],

    /*
    |--------------------------------------------------------------------------
    | PayPal Configuration
    |--------------------------------------------------------------------------
    */
    'paypal' => [
        'client_id' => env('PAYPAL_CLIENT_ID'),
        'secret' => env('PAYPAL_SECRET'),
        'mode' => env('PAYPAL_MODE', 'sandbox'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Firebase Configuration (Push Notifications)
    |--------------------------------------------------------------------------
    */
    'firebase' => [
        'api_key' => env('FIREBASE_API_KEY'),
        'auth_domain' => env('FIREBASE_AUTH_DOMAIN'),
        'project_id' => env('FIREBASE_PROJECT_ID'),
        'storage_bucket' => env('FIREBASE_STORAGE_BUCKET'),
        'messaging_sender_id' => env('FIREBASE_MESSAGING_SENDER_ID'),
        'app_id' => env('FIREBASE_APP_ID'),
        'measurement_id' => env('FIREBASE_MEASUREMENT_ID'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Delivery Configuration
    |--------------------------------------------------------------------------
    */
    'delivery' => [
        'base_price' => env('DELIVERY_BASE_PRICE', 1000),
        'price_per_km' => env('DELIVERY_PRICE_PER_KM', 500),
        'max_distance_km' => env('MAX_DELIVERY_DISTANCE_KM', 20),
        'tax_rate' => env('DELIVERY_TAX_RATE', 0.18),
    ],

    /*
    |--------------------------------------------------------------------------
    | PWA Configuration
    |--------------------------------------------------------------------------
    */
    'pwa' => [
        'name' => env('PWA_NAME', 'RestoConnect360'),
        'short_name' => env('PWA_SHORT_NAME', 'RestoConnect360'),
        'description' => env('PWA_DESCRIPTION', 'Plateforme SaaS Multi-Restaurant avec Paiements Africains'),
        'theme_color' => env('PWA_THEME_COLOR', '#667eea'),
        'background_color' => env('PWA_BACKGROUND_COLOR', '#ffffff'),
        'display' => env('PWA_DISPLAY', 'standalone'),
        'orientation' => env('PWA_ORIENTATION', 'portrait'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Google Analytics Configuration
    |--------------------------------------------------------------------------
    */
    'google_analytics' => [
        'tracking_id' => env('GOOGLE_ANALYTICS_ID'),
    ],

];
