<?php

namespace App\Http\Controllers;

use Asdh\ImePay\Exceptions\ImePayException;
use Asdh\ImePay\ImePay;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ImePayController extends Controller
{
    public function form(Request $request, ImePay $imePay)
    {
        // You can add a unique value here($refId). It can be the uuid column of
        // orders or products table if you have that in your project
        $refId = Str::uuid();
        $amount = 10;

        try {
            $response = $imePay->getToken($refId, $amount);
        } catch (ImePayException $exception) {
            // If something goes wrong, you can handle it here
        }

        return view('ime-pay', [
            'imePayResponse' => $response,
        ]);
    }

    public function cancel(Request $request)
    {
        // This is the example of what we get in the request when the user cancels the payment
        // Save this data to the database for reference

        // [
        //     'ResponseCode' => '3',
        //     'ResponseDescription' => 'Operation Cancelled By User',
        //     'RefId' => '2fb8315e-240f-4696-b3f8-9c2028533256',
        //     'TranAmount' => '10.0000',
        //     'TokenId' => '202103121151184221',
        //     'Msisdn' => '000',
        //     'TransactionId' => '000',
        // ];

        // Do your stuffs...

        // redirect the user to your desired location
        return redirect()->route('ime-pay.form')
            ->with('message', 'You have cancelled the payment.');
    }

    public function response(Request $request, ImePay $imePay)
    {
        // This is the example of what we get in the request when the user pays using IME Pay
        // Save this data to the database for reference
        // [
        //     'ResponseCode' => '0',
        //     'ResponseDescription' => 'Success',
        //     'RefId' => '673f26bb-223b-4ba3-8f55-81b2b72d5c98',
        //     'TranAmount' => '10.0000',
        //     'Msisdn' => '9840594104',
        //     'TransactionId' => '202103121200350850',
        //     'TokenId' => '202103121200044222',
        // ]

        try {
            $payment = $imePay->verify($request->all());
        } catch (ImePayException $exception) {
            // If something goes wrong during validation, you can handle it here
        }

        if ($payment->isNotVerified()) {
            // Do your stuffs...
            // Save the response from the payment in your database

            // redirect the user to your desired location
            return redirect()->route('ime-pay.form')
                ->with('message', 'Your payment is not verified. Please contact support.');
        }

        // You will reach here if the payment is verified

        // Do your stuffs...
        // Save the response from the payment in your database

        // redirect the user to your desired location
        return redirect()->route('ime-pay.form')
            ->with('message', 'Your payment is successful.');
    }
}
