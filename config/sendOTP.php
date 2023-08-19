<?php

require_once '../vendor/autoload.php';

$email = $_GET['email'];
$otp = generateOtp();
$subject = "Japanese Online Ticketing System";
$message = "This is your OTP Code: " . $otp; 


try {
    $client = new \GuzzleHttp\Client([
        //the url endpoint
        'base_uri' => 'https://prod-18.southeastasia.logic.azure.com:443/workflows/1ec3891e67a24e3eaf68476a41e6971b/triggers/manual/paths/invoke?api-version=2016-06-01&sp=%2Ftriggers%2Fmanual%2Frun&sv=1.0&sig=G00tefHU3CDIo5Fu1gnla_KMQVvXek9XyDIY9OD7KBE',
        'headers' => [
            'Accept' => 'application/json'
        ]
    ]);

    //the content of the email & it message
    $body = json_encode([
        'email' => $email,
        'subject' => $subject,
        'message' => $message
    ]);

    //send the POST request to the base URI
    //header is the content type, which is json
    $response = $client->post('', [
        'body' => $body,
        'headers' => [
            'Content-Type' => 'application/json'
        ]
    ]);
    
    
   
// the email is passed successfully from js to here 
    echo $otp;
} catch (Exception $e) {
    echo $e->getMessage();
    throw new Exception();
}


function generateOtp() {
    $numbers = '0123456789';
    $otp = '';
    for ($i = 0; $i < 6; $i++) {
        $otp .= $numbers[rand(0, strlen($numbers) - 1)];
    }
    return $otp;
}


