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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'brevo' => [
        'api_key' => env('BREVO_API_KEY'),
    ],

    // Toggle the donation-form reCAPTCHA server-side verification. Set to false
    // only as a temporary measure (e.g. while migrating a deprecated Google key);
    // keep true in production for bot protection.
    'recaptcha_enabled' => env('RECAPTCHA_ENABLED', true),

    // "checkbox" — reCAPTCHA v2 checkbox widget (visible, user must tick).
    // "score"    — reCAPTCHA v3 invisible (no user interaction, risk score based).
    // Each type requires its own site/secret key pair from console.recaptcha.google.com.
    'recaptcha_type'            => env('RECAPTCHA_TYPE', 'score'),
    'recaptcha_score_threshold' => (float) env('RECAPTCHA_SCORE_THRESHOLD', 0.5),
    'recaptcha_project_id'      => env('RECAPTCHA_PROJECT_ID', ''),
    // Google Cloud API key — used to authenticate Enterprise Assessment API calls.
    // Reads RECAPTCHA_API_KEY first; falls back to legacy RECAPTCHA_SECRET_KEY name.
    'recaptcha_api_key'         => env('RECAPTCHA_API_KEY', env('RECAPTCHA_SECRET_KEY', '')),

    'xendit' => [
        'webhook_token' => env('XENDIT_WEBHOOK_TOKEN'),
    ],

    // BisaTopup (mitra.bisatopup.co.id) — Payment Gateway for Celengan Syahid donations.
    // base_url is the API host (confirm exact value from the API reference); the
    // dashboard itself lives at mitra.bisatopup.co.id.
    // BisaTopup (Bisabiller backend) — Payment Gateway for Celengan Syahid donations.
    'bisatopup' => [
        'username'        => env('BISATOPUP_USERNAME'),
        'password_api'    => env('BISATOPUP_PASSWORD_API'),
        'widget_key'      => env('BISATOPUP_WIDGET_KEY'),
        'env'             => env('BISATOPUP_ENV', 'dev'), // 'dev' | 'live'
        'base_url_live'   => env('BISATOPUP_BASE_URL_LIVE', 'https://api.bisabiller.com'),
        'base_url_dev'    => env('BISATOPUP_BASE_URL_DEV', 'https://api-sandbox.bisabiller.com'),
        'qris_payment_id' => env('BISATOPUP_QRIS_PAYMENT_ID', 33),
        'admin_fee'       => env('BISATOPUP_ADMIN_FEE', 0),
        // Enforce callback signature check (keep false in DEV until the exact
        // signature formula is confirmed, then set true for production).
        'enforce_callback_signature' => env('BISATOPUP_ENFORCE_CALLBACK_SIGNATURE', false),
    ],

    'two_fa' => [
        'allowed_users'          => array_filter(array_map('trim', explode(',', env('TWO_FA_ALLOWED_USERS', '')))),
        'app_name'               => env('TWO_FA_APP_NAME', 'LDK Syahid Admin'),
        'discrepancy_threshold'  => (int) env('TWO_FA_DISCREPANCY_THRESHOLD', 50000),
    ],

    'google' => [
        'client_id'     => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect'      => env('GOOGLE_REDIRECT_URI'),
    ],

];
