<?php

namespace Tests\Feature;

use Tests\TestCase;
use Asdh\ImePay\ImePay;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $imePay = new ImePay();
        $response = $imePay->verify([
            "RefId" => "a460c09b-7783-47b6-b3a6-2d15cab71ed7",
            "Msisdn" => "9840594104",
            "TokenId" => "202103091150034061",
            "TranAmount" => "20.0000",
            "ResponseCode" => "0",
            "TransactionId" => "202103091150349847",
            "ResponseDescription" => "Success"
        ]);

        dd($response->isVerified(), $response->responseDescription(), $response->raw());
    }
}
