<?php

// Include the PHP integration kit
include_once('../paymentgateway/easebuzz/easebuzz-lib/easebuzz_payment_gateway.php');

// Get JSON data from the request body
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

// Check if required data is present
if (!isset($data['amount'], $data['productinfo'], $data['firstname'], $data['email'], $data['phone'], $data['address1'], $data['city'], $data['state'], $data['country'], $data['zipcode'])) {
    // Required data is missing, return error response
    $response = array('error' => 'Missing required data');
    echo json_encode($response);
    exit;
}
// Replace "+91" with ""
$data['phone'] = str_replace("+91", "", $data['phone']);
// Initialize Easebuzz object with your merchant key, salt, and environment
$MERCHANT_KEY = "O5U4PW160I";
$SALT = "FXR5OJ7VM6";
$ENV = "prod"; // Set to "test" or "prod" based on your environment
$easebuzzObj = new Easebuzz($MERCHANT_KEY, $SALT, $ENV);
// Generate a unique transaction ID
$txnid = uniqid();
$amount = number_format((float)$data['amount'], 2, '.', '');

// Construct the data array for initiating payment
$postData = array(
    "txnid" => $txnid, // Include the transaction ID
    "amount" => $amount,
    "productinfo" => $data['productinfo'],
    "firstname" => $data['firstname'],
    "email" => $data['email'],
    "phone" => $data['phone'],
    "address1" => $data['address1'],
    "city" => $data['city'],
    "state" => $data['state'],
    "country" => $data['country'],
    "zipcode" => $data['zipcode'],
     "surl" => "https://sanatanworld.org/paymentgateway/easebuzz/response.php", // Replace with your success URL
    "furl" => "https://sanatanworld.org/paymentgateway/easebuzz/response.php"  // Replace with your failure URL
);

// Call the initiatePaymentAPI method
$response = $easebuzzObj->initiatePaymentAPI($postData,false);

// Return the response as JSON
// echo json_encode($response);
// echo $response;

// Manually inject "status":"1" if "status":1 or "status":"0" if "status":0
$response = str_replace(['"status":1', '"status":0'], ['"status":"1"', '"status":"0"'], $response);

// Return the response
echo $response;
