<?php

$url = "https://ea2064596629378a-PaymentsMadeEasy-checkout-live.adyenpayments.com/checkout/v69/payments";

$payments_data = $_POST;

//echo $payments_data;

$additional_data = [
    //'reference' => 'KenjiW001',
    'reference' => date("Ymt").'livetransaction_PaymentsAPI_v69_'.time(),
    'merchantAccount' => 'PME_ECOM_JP',
    //'countryCode' => 'DK',
    'amount' => [
        'value' => 10000,
        'currency' => 'KRW'
    ],
    'returnUrl' => '/return.php',
    'channel' => 'Web',
    'additionalData' => [
        //'allow3DS2' => 'false'
        'allow3DS2' => 'true'

    ],
    "threeDS2RequestData"=> [
      "threeDSCompInd"=> "Y",
      "threeDSRequestorChallengeInd"=> "04"

    ],
    //'origin' => 'http://127.0.0.1:8080',
    'origin' => 'https://bcmccomp.herokuapp.com/',
    'billingAddress' => '123 Eastgate, San Diego, USA, 92121',
    //'paymentMethod' => $payments_data->PaymentMethod,
    /*
    'lineItems' => array(
                 'quantity' =>'1',
                 'taxPercentage' =>'2100',
                 'description' =>'Shoes',
                 'id' =>'Item #1',
                 'amountIncludingTax' =>'400',
                 'productUrl' => 'URL_TO_PURCHASED_ITEM',
                 'imageUrl' => 'URL_TO_PICTURE_OF_PURCHASED_ITEM'
                ),


    'deliveryAddress' => array(
                'city' => 'Singapore',
                'country' => 'SG',
                'houseNumberOrName' => '109',
                'postalCode' => '179097',
                'street' => 'North Bridge Road'
            ),*/
/*
    'storePaymentMethod'=> true,
    'shopperInteraction'=> 'ContAuth',
    'recurringProcessingModel'=> 'CardOnFile',
    'shopperReference'=> 'Shopper_02222022_1'


    'browserInfo' => [
      'userAgent' => 'Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/70.0.3538.110 Safari\/537.36',
      'acceptHeader' => "text\/html,application\/xhtml+xml,application\/xml;q=0.9,image\/webp,image\/apng,*\/*;q=0.8",
      "language" => "en-US",
      "colorDepth" => 24,
        "screenHeight" => 723,
        "screenWidth" => 1536,
        "timeZoneOffset" => 0,
      "javaEnabled" => true
    ]*/
];

$final_payment_data = array_merge($payments_data, $additional_data);

$curl_http_header = array(
    "X-API-Key: AQEyhmfxJovIYhRKw0m/n3Q5qf3VeIpUAJZETHZ7x3yuu2dYh5cnvT60e4XlLQ+yKZra3zQQwV1bDb7kfNy1WIxIIkxgBw==-S39eP06SsENH4R51dJB5yBqeyOmH4j6ELiJp/Ga97nw=-d(^TtKg6z&m(5DHK",
    "Content-Type: application/json"
);

$curl = curl_init();

curl_setopt_array(
    $curl,
    [
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST  => 'POST',
        CURLOPT_POSTFIELDS     => json_encode($final_payment_data),
        CURLOPT_HTTPHEADER     => $curl_http_header,
        CURLOPT_VERBOSE        => true
    ]
);

$payments_response = curl_exec($curl);
$file = 'paymentsCallResponse.txt';
$current = $payments_response;
file_put_contents($file, $current);

header('Content-Type: application/json');
echo $payments_response;

curl_close($curl);

//header("location:index.php");
