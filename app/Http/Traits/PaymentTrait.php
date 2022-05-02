<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Config;

trait PaymentTrait{

    public function getPaymentGateways()
    {
        return Config::get('paymentgateways');
    }

    public function getPaymentGatewayByCode($code)
    {
        return $this->getPaymentGateways()[$code];
    }

    public function getSecretKey($gateway)
    {
        return Config::get('paymentgateways.' . $gateway . '.secret_key');
    }

    public function getPublicKey($gateway)
    {
        return Config::get('paymentgateways.' . $gateway . '.public_key');
    }

    public function getVerifyUrl($gateway)
    {
        return Config::get('paymentgateways.' . $gateway . '.verify_url');
    }

    public function getRedirectUrl($gateway)
    {
        return Config::get('paymentgateways.' . $gateway . '.redirect_url');
    }
}