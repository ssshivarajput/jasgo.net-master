<?php 
date_default_timezone_set('Asia/Kolkata'); 
$dd = date("d/m/Y"); 
$dt = date("h:i A"); 
$ipa = $_SERVER['REMOTE_ADDR']; 
$newrd = date("Y-m-d"); 

$con = mysqli_connect("p:localhost", "sanatanworld", "U7ZYJV2iTh2TFqP", "sanatanworld");
if (!$con) {
    // Connection failed, handle the error
    die("Connection failed: " . mysqli_connect_error()); 
} else {
    mysqli_query($con, 'SET character_set_results=utf8');        
    mysqli_query($con, 'SET names=utf8');
    mysqli_query($con, 'SET character_set_client=utf8');        
    mysqli_query($con, 'SET character_set_connection=utf8');
    mysqli_query($con, 'SET collation_connection=utf8_general_ci');
    mysqli_query($con, "SET SESSION sql_mode = ''"); 
    mysqli_query($con, "SET GLOBAL sql_mode=''");
}

// Get JSON data from the request body
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

$response = array(); 
$tbl_name = "donation_details"; 

if(isset($data['case']) && $data['case'] == "paysuccess") {
    $first_name = $con->real_escape_string($data['firstname']);
    $productinfo = $con->real_escape_string($data['productinfo']);
    $amount = $con->real_escape_string($data['amount']);
    $email = $con->real_escape_string($data['email']);
    $phone = $con->real_escape_string($data['phone']);
    $address1 = $con->real_escape_string($data['address1']);
    $city = $con->real_escape_string($data['city']);
	$state = $con->real_escape_string($data['state']);
	$zipcode = $con->real_escape_string($data['zipcode']);
	$txnid = $con->real_escape_string($data['txnid']); 
	$sql = "INSERT INTO `$tbl_name`(`donor_name`, `product_info`,`amount`,`donor_email`,`mobile_number`,`street_address`,`city`,`state`,`zipcode`,`is_active`, `is_deleted`, `is_paid`, `payment_status`, `txnid`, `created_at`) 
	                        VALUES ('$first_name', '$productinfo', '$amount','$email','$phone','$address1','$city','$state','$zipcode','1','Live','1','Success','$txnid','$newrd')";
     
    if (!mysqli_query($con, $sql)) {
        $response['status'] = '0'; 
        $response['message'] = 'Payment updation failed'; 
        echo json_encode($response);
        exit();
    } 

    $response['status'] = '1'; 
    $response['message'] = 'Payment updated successfully'; 
} else { 
    $response['status'] = '0'; 
    $response['message'] = 'Payment updation failed'; 
}

// Output JSON response
echo json_encode($response);
mysqli_close($con);
?>
