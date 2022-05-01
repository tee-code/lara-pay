<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;


class FlutterwaveController extends Controller
{

    public function redirect($fields)
    {

        $url = $this->getFlutterwaveUrl();

        $fields['currency'] = 'NGN';
        $fields['tx_ref'] = time();
        $fields['redirect_url'] = route('flutterwave.verify');
        $fields['customer'] = array(
            "name" => Auth::user()->name,
            "phone_number" => $fields['phone'],
            "email" => $fields['email']
        );

        $fields['meta'] = array(
            "reason" => $fields['reason'],
            "price" => $fields['amount']
        );

        $fields_string = json_encode($fields);

        //open connection
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->getFlutterwaveUrl(),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $fields_string,
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . env('FLUTTERWAVE_SECRET_KEY'),
            'Content-Type: application/json'
        ),
        ));
        
        //execute post
        $result = curl_exec($curl);

        curl_close($curl);

        $transaction = json_decode($result);

        if($transaction->status == 'success')
        {
            $link = $transaction->data->link;
            header('Location: '.$link, true);
        }
        else
        {
            return redirect()->route('cancel');
        }

    }

    public function getFlutterwaveUrl()
    {
        return Config::get('paymentgateways.flutterwave-basic.redirect_url');
    }

    public function getFlutterwaveVerifyUrl()
    {
        return Config::get('paymentgateways.flutterwave-basic.verify_url');
    }

    public function verify()
    {
        if(isset($_GET['status']))
        {
            //* check payment status
            if($_GET['status'] == 'cancelled')
            {
                // echo 'YOu cancel the payment';
                header('Location: ' . route('cancel'));
            }
            elseif($_GET['status'] == 'successful')
            {
                $id = $_GET['transaction_id'];

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "{$this->getFlutterwaveVerifyUrl()}/{$id}/verify",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "Authorization: Bearer " . env('FLUTTERWAVE_SECRET_KEY')
                    ),
                ));
                
                $response = curl_exec($curl);
                
                curl_close($curl);
                
                $res = json_decode($response);
                
                if($res->status)
                {
                    $amountPaid = $res->data->charged_amount;
                    $amountToPay = $res->data->meta->price;
                    if($amountPaid >= $amountToPay)
                    {
                        return redirect()->route('success', $id);
                    }
                    else
                    {
                        return redirect()->route('cancel', $id)->with('msg', 'Fraud detected.');
                    }
                }
                else
                {
                    return redirect()->route('cancel', $id)->with('msg', 'Can not process your payment.');
                }
            }
        }
    }
}
