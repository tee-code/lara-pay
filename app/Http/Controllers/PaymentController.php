<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class PaymentController extends Controller
{

    public function __construct()
    {
        $this->middleware("auth");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gateways = Config::get('paymentgateways');

        return view('pay', compact('gateways'));
    }

    public function redirectToGateway(PaymentRequest $request)
    {
        $request = $request->validated();

        $request['email'] = auth()->user()->email;

        $payment = app($this->getPaymentGatewayByCode($request['gateway'])['class']);

        return $payment->redirect($request);

    }

    public function verify()
    {
    }

    public function success($ref = null)
    {
    
        $ref = $ref != null ? $ref : null;

        if(!$ref){
            return redirect()->route('home');
        }
        return view('success', compact("ref"));
    }

    public function cancel($ref = null)
    {
        $ref = $ref != null ? $ref : null;

        if(!$ref){
            return redirect()->route('payment');
        }
        return view('error', compact("ref"));
    }

    public function getPaymentGateways()
    {
        return Config::get('paymentgateways');
    }

    public function getPaymentGatewayByCode($code)
    {
        return $this->getPaymentGateways()[$code];
    }
}