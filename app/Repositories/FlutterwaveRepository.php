<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use App\Interfaces\PaymentInterface;
use App\Http\Traits\PaymentTrait;

class FlutterwaveRepository implements PaymentInterface
{
    use PaymentTrait;

    public function redirect($fields)
    {
        $gateway = $fields['gateway'];
        $fields['currency'] = 'NGN';
        $fields['tx_ref'] = time();
        $fields['redirect_url'] = route('verify', $gateway);
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
        CURLOPT_URL => $this->getRedirectUrl($gateway),
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
            'Authorization: Bearer ' . $this->getSecretKey($gateway),
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

    public function verify($gateway)
    {
        if(isset($_GET['status']))
        {
            //* check payment status
            if($_GET['status'] == 'cancelled')
            {
                // echo 'YOu cancel the payment';
                return [
                    "status" => false,
                    "message" => "Transaction Cancelled",
                
                ];
            }
            elseif($_GET['status'] == 'successful')
            {
                $id = $_GET['transaction_id'];

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "{$this->getVerifyUrl("flutterwave-basic")}/{$id}/verify",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "Authorization: Bearer " . $this->getSecretKey($gateway)
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
                        return [
                            "status" => $res->status,
                            "data" => $res->data,
                            "ref" => $id,
                            "message" => $res->message
                        ];

                    }
                    else
                    {
                        return [
                            "status" => false,
                            "message" => "Fraud detected",
                            "ref" => $id
                        ];
                        
                    }
                }
                else
                {
                    return [
                        "status" => false,
                        "message" => "Can not process your payment.",
                        "ref" > $id
                    ];

                }
            }
        }
    }
}
