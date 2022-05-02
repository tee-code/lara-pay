<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;

use Illuminate\Support\Facades\Config;

use App\Models\Transaction;

use App\Http\Traits\PaymentTrait;

class PaymentController extends Controller
{

    use PaymentTrait;

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
        $gateway = $request['gateway'];

        $request['email'] = auth()->user()->email;

        $paymentRepository = $this->getPaymentRepository($gateway);

        return $paymentRepository->redirect($request);

    }

    public function verify($gateway)
    {
        
        $paymentRepository = $this->getPaymentRepository($gateway);

        $response = $paymentRepository->verify($gateway);

        if($response['status']){

            Transaction::create([
                "gateway" => $gateway,
                "user_id" =>auth()->user()->id,
                "reference" => $response['ref'],
                "amount" => $response['data']->amount
            ]);

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

}