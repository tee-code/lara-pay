<?php 
return [
    "paystack-basic" => [
        "code" => "paystack-basic",
        "name" => "Paystack Basic",
        "description" => "A basic paystack integration.",
        "active" => true,
        "class" => 'App\Repositories\PaystackRepository',
        "merchant_email" => "ooluwatobialao@gmail.com",
        "redirect_url" => "https://api.paystack.co/transaction/initialize",
        "verify_url" => "https://api.paystack.co/transaction/verify/",
        "secret_key" => env('PAYSTACK_SECRET_KEY'),
        "public_key" => env('PAYSTACK_PUBLIC_KEY')
    ],
    "flutterwave-basic" => [
        "code" => "flutterwave-basic",
        "name" => "Flutterwave Basic",
        "description" => "A basic flutterwave integration.",
        "active" => true,
        "class" => 'App\Repositories\FlutterwaveRepository',
        "merchant_email" => "ooluwatobialao@gmail.com",
        "redirect_url" => "https://api.flutterwave.com/v3/payments",
        "verify_url" => "https://api.flutterwave.com/v3/transactions",
        "secret_key" => env('FLUTTERWAVE_SECRET_KEY'),
        "public_key" => env('FLUTTERWAVE_PUBLIC_KEY')
    ]
];