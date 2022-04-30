<?php 
return [
    "paystack-basic" => [
        "code" => "paystack-basic",
        "name" => "Paystack Basic",
        "description" => "A basic paystack integration.",
        "active" => true,
        "class" => 'App\Http\Controllers\PaystackController',
        "merchant_email" => "ooluwatobialao@gmail.com",
        "redirect_url" => "https://api.paystack.co/transaction/initialize"
    ],
    "paystack-unicode" => [
        "code" => "paystack-unicode",
        "name" => "Unicode Paystack",
        "description" => "Unicode Developer paystack laravel integration.",
        "active" => false,
        "class" => 'App\Http\Controllers\UnicodePaystackController',
        "merchant_email" => "ooluwatobialao@gmail.com",
        "redirect_url" => "https://api.paystack.co/transaction/initialize"
    ],
    "flutterwave-basic" => [
        "code" => "flutterwave-basic",
        "name" => "Flutterwave Basic",
        "description" => "A basic flutterwave integration.",
        "active" => false,
        "class" => 'App\Http\Controllers\FlutterwaveController',
        "merchant_email" => "ooluwatobialao@gmail.com",
        "redirect_url" => "https://api.paystack.co/transaction/initialize"
    ]
];