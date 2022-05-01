<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;

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

    public function getPaymentRepository($gateway)
    {
        return app($this->getPaymentGatewayByCode($gateway)['class']);
    }

    public function redirectToGateway(PaymentRequest $request)
    {
        $request = $request->validated();

        $request['email'] = auth()->user()->email;


        $paymentRepository = $this->getPaymentRepository($request['gateway']);

        return $paymentRepository->redirect($request);

    }

    public function verify($gateway)
    {
        
        $paymentRepository = $this->getPaymentRepository($gateway);

        $response = $paymentRepository->verify();

        if($response['status']){

            return redirect()->route('success', $response['ref'])->with("msg", $response['message']);
            
        }else{
            return redirect()->route('cancel', $response['ref'])->with("msg", $response['message']);
        }
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