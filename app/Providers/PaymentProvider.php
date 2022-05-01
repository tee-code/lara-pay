<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use App\Repositories\PaystackRepository;
use App\Repositories\FlutterwaveRepository;
use App\Interfaces\PaymentInterface;


class PaymentProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(PaymentInterface::class, PaystackRepository::class);
        $this->app->bind(PaymentInterface::class, FlutterwaveRepository::class);

    }

    public function boot()
    {

    }
}