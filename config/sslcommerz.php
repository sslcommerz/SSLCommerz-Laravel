<?php

// SSLCommerz configuration

return [
    'projectPath' => env('PROJECT_PATH'), // its your web address. you can use you localhost also
    // For Sandbox, use "https://sandbox.sslcommerz.com"
    // For Live, use "https://securepay.sslcommerz.com"
  
    'apiDomain' => env("API_DOMAIN_URL", "https://sandbox.sslcommerz.com"), // use any link from above

    'apiCredentials' => [
        'store_id' => env("STORE_ID"), // use store_id from given credentials
        'store_password' => env("STORE_PASSWORD"), // use store_password from given credentials
    ],
    'apiUrl' => [
        'make_payment' => "/gwprocess/v4/api.php", // check given credentials from email
        'transaction_status' => "/validator/api/merchantTransIDvalidationAPI.php", // check given credentials from email
        'order_validate' => "/validator/api/validationserverAPI.php",// check given credentials from email
        'refund_payment' => "/validator/api/merchantTransIDvalidationAPI.php",// check given credentials from email
        'refund_status' => "/validator/api/merchantTransIDvalidationAPI.php",// check given credentials from email
    ],
    'connect_from_localhost' => env("IS_LOCALHOST", true), // For Sandbox, use "true", For Live, use "false"
    'success_url' => '/success',
    'failed_url' => '/fail',
    'cancel_url' => '/cancel',
    'ipn_url' => '/ipn',
];
