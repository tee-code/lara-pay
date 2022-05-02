<?php

namespace App\Interfaces;

interface PaymentInterface
{

    public function redirect($fields);
    
    public function verify($gateway);
    
}