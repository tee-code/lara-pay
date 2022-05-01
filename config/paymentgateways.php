<?php 
return [
    "paystack-basic" => [
        "code" => "paystack-basic",
        "name" => "Paystack Basic",
        "description" => "A basic paystack integration.",
        "active" => true,
        "class" => 'App\Http\Controllers\PaystackController',
        "merchant_email" => "ooluwatobialao@gmail.com",
        "redirect_url" => "https://api.paystack.co/transaction/initialize",
        "verify_url" => "https://api.paystack.co/transaction/verify/"
    ],
    "flutterwave-basic" => [
        "code" => "flutterwave-basic",
        "name" => "Flutterwave Basic",
        "description" => "A basic flutterwave integration.",
        "active" => true,
        "class" => 'App\Http\Controllers\FlutterwaveController',
        "merchant_email" => "ooluwatobialao@gmail.com",
        "redirect_url" => "https://api.flutterwave.com/v3/payments",
        "verify_url" => "https://api.flutterwave.com/v3/transactions"
    ]
];