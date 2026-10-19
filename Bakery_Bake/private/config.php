<?php
declare(strict_types=1);

/**
 * Server-side configuration. Keep this directory outside the public web root.
 * Never expose this file or commit it to a public repository.
 */
return [
    'site_name' => 'Bakery Bake',
    'base_url' => '', // e.g. https://bakerybakestore.com
    'timezone' => 'Africa/Lagos',
    'currency' => 'NGN',
    'business_email' => 'bakerybakestore@gmail.com',
    'business_phone' => '+234 800 000 0000',
    'whatsapp_notifications_enabled' => false,
    'address' => 'No. 12 Aminu Kano Crescent, Wuse 2, Abuja, FCT, Nigeria',
    'instagram_url' => 'https://www.instagram.com/bakerybake_/',
    'paystack_public_key' => 'pk_test_f038f735dab0bbecfc8b5032cecf90d3ec502d74',
    'paystack_secret_key' => 'sk_test_665761985bdcf97b1c6d8370d3e11f8a9ddbeeca',
    'paystack_mode' => 'test',
    'web3forms_access_key' => '0f8994ef-50ba-419f-9bf9-69598d9babe8',
    'smtp_host' => '',
    'smtp_port' => 587,
    'smtp_username' => '',
    'smtp_app_password' => '', // Use a Gmail App Password, never the Gmail login password.
    'smtp_encryption' => 'tls',
    'mail_from_name' => 'Bakery Bake',
    'mail_from_email' => 'bakerybakestore@gmail.com',
    'min_lead_hours' => 48,
    'opening_hours' => 'Monday–Saturday, 9:00 AM–6:00 PM',
    'admin_initial_password' => '', // Admin is created using install.php.
];
