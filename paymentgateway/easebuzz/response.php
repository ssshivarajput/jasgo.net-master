<?php
    // include file
    include_once('easebuzz-lib/easebuzz_payment_gateway.php');

    // salt for testing env
    $SALT = "FXR5OJ7VM6";

    /*
    * Get the API response and verify response is correct or not.
    *
    * params string $easebuzzObj - holds the object of Easebuzz class.
    * params array $_POST - holds the API response array.
    * params string $SALT - holds the merchant salt key.
    * params array $result - holds the API response array after valification of API response.
    *
    * ##Return values
    *
    * - return array $result - hoids API response after varification.
    * 
    * @params string $easebuzzObj - holds the object of Easebuzz class.
    * @params array $_POST - holds the API response array.
    * @params string $SALT - holds the merchant salt key.
    * @params array $result - holds the API response array after valification of API response.
    *
    * @return array $result - hoids API response after varification.
    *
    */
    $easebuzzObj = new Easebuzz($MERCHANT_KEY = null, $SALT, $ENV = null);
    
    $result = $easebuzzObj->easebuzzResponse( $_POST );
 
    print_r($result);
    // Check Payment Status
if ($result->status === 1) {
    // Payment successful, store user data in session
    $_SESSION['donation_data'] = $_POST;

    // Redirect to success page
    header('Location: https://www.sanatanworld.org/donationsuccess.php');
    exit();
} else {
    // Payment failed, redirect to failure page
    header('Location: https://www.sanatanworld.org/donationfailed.php');
    exit();
}
?>

