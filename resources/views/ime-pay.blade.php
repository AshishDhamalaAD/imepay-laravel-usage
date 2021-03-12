<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>IME Pay</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="h-screen w-screen flex flex-col items-center justify-center">
        @if(session('message'))
            <div class="mb-32 px-6 py-4 bg-gray-700 text-white rounded">
                {{ session('message') }}
            </div>
        @endif

        <h1 class="text-4xl text-gray-400">This page can be your product detail or order checkout page.</h1>
        <form action=" {{ config('imepay.base_url') }}/WebCheckout/Checkout "method="post" class="mt-8" id="payment-form">
            <input type="hidden" name="TokenId" value="{{ $imePayResponse->tokenId() }}">
            <input type="hidden" name="MerchantCode" value="{{ config('imepay.merchant_code') }}">
            <input type="hidden" name="RefId" value="{{ $imePayResponse->refId() }}">
            <input type="hidden" name="TranAmount" value="{{ $imePayResponse->amount() }}">
            <input type="hidden" name="Method" value="POST">

            {{-- make sure that you add these urls to the $except array of App\Http\Middleware\VerifyCsrfToken class and also these should not be under authentication --}}
            <input type="hidden" name="RespUrl" value="{{ route('ime-pay.response') }}">
            <input type="hidden" name="CancelUrl" value="{{ route('ime-pay.cancel') }}">

            <button class="px-8 py-4 rounded bg-purple-500 text-white text-xl" id="payment-button">Pay With IME Pay</button>
        </form>
    </div>
</body>

<script>
    let paymentForm = document.getElementById("payment-form");
    let paymentButton = document.getElementById("payment-button");

    paymentForm.addEventListener("submit", function (event) {
        paymentButton.innerHTML = "Something awesome is hapenning...";
        paymentButton.setAttribute("disabled", true);
    });
</script>
</html>