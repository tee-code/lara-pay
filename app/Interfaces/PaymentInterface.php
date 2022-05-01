<?php

namespace App\Interfaces;

interface PaymentInterface
{

    public function redirect($fields);
    public function getRedirectUrl();
    public function getVerifyUrl();
    public function verify();
    
}