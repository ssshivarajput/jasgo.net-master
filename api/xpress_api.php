<?php

date_default_timezone_set('Asia/Kolkata');
$dd = date('d/m/Y');
$dt = date('h:i A');
$ipa = $_SERVER['REMOTE_ADDR'];
$newrd = date('Y-m-d H:i:s');

$con = mysqli_connect('p:localhost', 'sanatanworld', 'U7ZYJV2iTh2TFqP', 'sanatanworld');
if (!$con) {
    // Connection failed, handle the error
    exit('Connection failed: '.mysqli_connect_error());
} else {
    mysqli_query($con, 'SET character_set_results=utf8');
    mysqli_query($con, 'SET names=utf8');
    mysqli_query($con, 'SET character_set_client=utf8');
    mysqli_query($con, 'SET character_set_connection=utf8');
    mysqli_query($con, 'SET collation_connection=utf8_general_ci');
    mysqli_query($con, "SET SESSION sql_mode = ''");
    mysqli_query($con, "SET GLOBAL sql_mode=''");
}

$whatsappurl = 'https://apiauto.in/api/send.php';
$wapitoken = 'e56c2df5a42de4c79a9b219d42c586a1';
$wapiinstanceid = '660669CD6CBBF';

// Get JSON data from the request body
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

$response = [];
$tbl_name = 'users';
$otp = rand(1000, 9999);
$search = ['+91', ' '];
$replace = ['', ''];
$hide = '';
$is_deleted = '';
$limit = 6;

if (isset($data['case']) && $data['case'] == 'otpsignin') {
    if (isset($data['contact']) && $data['contact'] != '') {
        $mmobile = preg_replace('/^0+/', '', str_replace('+91', '', $data['contact']));
        // $mmobile = ltrim(str_replace(["+91", "0"], "",$data['contact']));
        // $mmobile = ltrim($mmobile, "0");

        if ($mmobile == '1111111111') {
            $response['status'] = '1';
            $response['otp'] = '1111';
            $response['message'] = 'OTP sent successfully';
        } else {
            $resultdata = mysqli_query($con, "SELECT * FROM `$tbl_name` WHERE mobile_no!='' AND (
    (mobile_no='$mmobile' OR mobile_no='".$data['contact']."') OR 
    (RIGHT(mobile_no, 10) = '$mmobile') OR 
    (RIGHT(mobile_no, 10) = '0$mmobile')
)");

            while ($rowdata = mysqli_fetch_array($resultdata)) {
                $hide = $rowdata['hide'];
                $is_deleted = $rowdata['is_deleted'];
            }

            if ($hide == '0' && $is_deleted == 'Live') {
                $messagexx = "$otp is your One Time verification code to login to Sanatan World and it's valid for next 10 mins - Sanatan World";
                $otpmessage = "$otp is your One Time verification code to login to Sanatan World App and it's valid for next 10 mins - Vedashram Trust";
                // $url = "$whatsappurl?number=91$mmobile&instance_id=$wapiinstanceid&type=text&access_token=$wapitoken&message=" . urlencode($messagexx);
                // $newCurl = curl_init();
                // curl_setopt($newCurl, CURLOPT_URL, $url);
                // curl_setopt($newCurl, CURLOPT_RETURNTRANSFER, true);
                // $output = curl_exec($newCurl);

                $msg = "<#> $otp is your OTP for Sign In at Sanatan World - Admin";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://www.textguru.in/api/v22.0/?');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, "username=info.sanatanworld&password=39055865&source=VEDSRM&dmobile=91$mmobile&dlttempid=1707171342545633231&message=$otpmessage");
                $output = curl_exec($ch);
                curl_close($ch);

                $response['status'] = '1';
                $response['otp'] = $otp;
                $response['contact'] = $data['contact'];
                $response['message'] = 'OTP sent successfully';
            } else {
                $response['status'] = '0';
                $response['message'] = 'Sorry! This number is not registered';
            }
        }
    } else {
        $response['status'] = '0';
        $response['message'] = 'Sorry! Mobile number is blank..';
    }
} elseif (isset($data['case']) && $data['case'] == 'signin' && isset($data['otp1']) && $data['otp1'] != '') {
    $mmobile = ltrim(str_replace(['+91', '0'], '', $data['contact']));
    // $mmobile = ltrim($mmobile, "0");

    if ($mmobile == '1111111111' && $data['otp2'] == $data['otp1']) {
        $resultdata = mysqli_query($con, "SELECT * FROM `$tbl_name` WHERE mobile_no!='' AND (mobile_no='$mmobile' OR mobile_no='".$data['contact']."')");
        if ($row = mysqli_fetch_array($resultdata)) {
            $response['status'] = '1';
            $response['message'] = 'Login successfully';
            $response['ccontactid'] = $row['id'];
            $response['user'] = $row;
        }
    } else {
        if ($data['otp2'] == $data['otp1']) {
            $resultdata = mysqli_query($con, "SELECT * FROM `$tbl_name` WHERE mobile_no!='' AND (
    (mobile_no='$mmobile' OR mobile_no='".$data['contact']."') OR 
    (RIGHT(mobile_no, 10) = '$mmobile') OR 
    (RIGHT(mobile_no, 10) = '0$mmobile')
)");

            if ($row = mysqli_fetch_array($resultdata)) {
                /*$sqlup = "UPDATE `$tbl_name` SET token='" . $data['token'] . "' WHERE id='$row[id]'";
                if (!mysqli_query($con, $sqlup)) {
                    die('Error: ' . mysqli_error());
                }*/
                $response['status'] = '1';
                $response['message'] = 'Login successfully';
                $response['ccontactid'] = $row['id'];
                $response['user'] = $row;
            }
        } else {
            $response['status'] = '0';
            $response['message'] = 'Sorry! OTP Mismatch';
            $response['ccontactid'] = '';
        }
    }
} elseif (isset($data['case']) && $data['case'] == 'otpsignup') {
    if (isset($data['contact']) && $data['contact'] != '') {
        // $mmobile = ltrim(str_replace(["+91", "0"], "", $data['contact']));
        $mmobile = preg_replace('/^0+/', '', str_replace('+91', '', $data['contact']));

        // Construct the SQL query
        $query = "SELECT * FROM `$tbl_name` WHERE mobile_no!='' AND (
            (mobile_no='$mmobile' OR mobile_no='".$data['contact']."') OR 
            (RIGHT(mobile_no, 10) = '$mmobile') OR 
            (RIGHT(mobile_no, 10) = '0$mmobile')
        )";

        $resultdata = mysqli_query($con, $query);

        if ($resultdata) {
            if (mysqli_num_rows($resultdata) > 0) {
                // Existing mobile number found in the database
                $row = mysqli_fetch_assoc($resultdata);
                if ($row['is_deleted'] == 'Deleted') {
                    // Mobile number exists and is marked as 'Deleted', proceed with OTP sending
                    // Code for sending OTP
                    $messagexx = "$otp is your One Time verification code to login to Sanatan World and it's valid for next 10 mins - Sanatan World";
                    $otpmessage = "$otp is your One Time verification code to login to Sanatan World App and it's valid for next 10 mins - Vedashram Trust";
                    // $url = "$whatsappurl?number=91$mmobile&instance_id=$wapiinstanceid&type=text&access_token=$wapitoken&message=" . urlencode($messagexx);
                    // $newCurl = curl_init();
                    // curl_setopt($newCurl, CURLOPT_URL, $url);
                    // curl_setopt($newCurl, CURLOPT_RETURNTRANSFER, true);
                    // $output = curl_exec($newCurl);

                    $msg = "<#> $otp is your OTP for Sign In at Sanatan World - Admin";
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://www.textguru.in/api/v22.0/?');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, "username=info.sanatanworld&password=39055865&source=VEDSRM&dmobile=91$mmobile&dlttempid=1707171342545633231&message=$otpmessage");
                    $output = curl_exec($ch);
                    curl_close($ch);
                    $response['status'] = '1';
                    $response['otp'] = $otp;
                    $response['contact'] = $data['contact'];
                    $response['message'] = 'OTP sent successfully';
                } else {
                    // Mobile number exists but is not marked as 'Deleted', return message
                    $response['status'] = '0';
                    $response['message'] = 'Mobile number is already registered.';
                }
            } else {
                // No existing mobile number found in the database
                // Proceed with sending OTP
                // Code for sending OTP
                $messagexx = "$otp is your One Time verification code to login to Sanatan World and it's valid for next 10 mins - Sanatan World";
                $otpmessage = "$otp is your One Time verification code to login to Sanatan World App and it's valid for next 10 mins - Vedashram Trust";
                // $url = "$whatsappurl?number=91$mmobile&instance_id=$wapiinstanceid&type=text&access_token=$wapitoken&message=" . urlencode($messagexx);
                // $newCurl = curl_init();
                // curl_setopt($newCurl, CURLOPT_URL, $url);
                // curl_setopt($newCurl, CURLOPT_RETURNTRANSFER, true);
                // $output = curl_exec($newCurl);

                $msg = "<#> $otp is your OTP for Sign In at Sanatan World - Admin";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://www.textguru.in/api/v22.0/?');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, "username=info.sanatanworld&password=39055865&source=VEDSRM&dmobile=91$mmobile&dlttempid=1707171342545633231&message=$otpmessage");
                $output = curl_exec($ch);
                curl_close($ch);
                $response['status'] = '1';
                $response['otp'] = $otp;
                $response['contact'] = $data['contact'];
                $response['message'] = 'OTP sent successfully';
            }
        } else {
            // Error in executing the query
            $response['status'] = '0';
            $response['message'] = 'Error executing database query: '.mysqli_error($con);
        }
    } else {
        // Mobile number is blank
        $response['status'] = '0';
        $response['message'] = 'Sorry! Mobile number is blank.';
    }
} elseif (isset($data['case']) && $data['case'] == 'signup' && isset($data['otp1']) && $data['otp2'] != '') {
    $mmobile = ltrim(str_replace(['+91', '0'], '', $data['contact']));
    // $mmobile = ltrim($mmobile, "0");

    if ($mmobile == '1111111111') {
        $response['status'] = '1';
        $response['message'] = 'Login successfully';
        $response['updatep'] = '1';
        $response['ccontactid'] = '2194';
    } else {
        if ($data['otp2'] == $data['otp1']) {
            $resultdata = mysqli_query($con, "SELECT * FROM `$tbl_name` WHERE mobile_no!='' AND (
    (mobile_no='$mmobile' OR mobile_no='".$data['contact']."') OR 
    (RIGHT(mobile_no, 10) = '$mmobile') OR 
    (RIGHT(mobile_no, 10) = '0$mmobile')
)");
            $rowdata = mysqli_fetch_assoc($resultdata); // Fetching a single row, assuming it's unique

            if ($rowdata) {
                $hide = $rowdata['hide'];
                $is_deleted = $rowdata['is_deleted'];

                if ($hide == '1' && $is_deleted == 'Deleted') {
                    // Update the record
                    $sqlup = "UPDATE `$tbl_name` SET is_deleted='Live', hide='0' WHERE id='{$rowdata['id']}'";
                    if (mysqli_query($con, $sqlup)) {
                        // Update successful
                        $response['status'] = '1';
                        $response['message'] = 'OTP verify successfully';
                        $response['ccontactid'] = $rowdata['id'];
                        $response['user'] = $rowdata;
                    } else {
                        // Update failed
                        $response['status'] = '0';
                        $response['message'] = 'Failed to update record';
                    }
                } else {
                    // Condition not met
                    $response['status'] = '0';
                    $response['message'] = 'Condition not met for update';
                }
            } else {
                $role = $data['role']; // Ensure that 'role' is properly sanitized
                $sql = "INSERT INTO `$tbl_name` (`is_active`, `mobile_no`, `is_deleted`, `created_at`, `user_type`) VALUES ('1', '$mmobile', 'Live', '$newrd', '$role')";
                if (!mysqli_query($con, $sql)) {
                    exit('Error: '.mysqli_error($con));
                }
                $last_id = mysqli_insert_id($con);
                $select_query = "SELECT * FROM `$tbl_name` WHERE id = '$last_id'";
                $result = mysqli_query($con, $select_query);

                if ($result && mysqli_num_rows($result) > 0) {
                    // User data fetched successfully
                    $row = mysqli_fetch_assoc($result);

                    // Prepare response
                    $response['status'] = '1';
                    $response['message'] = 'OTP verified successfully';
                    $response['ccontactid'] = "$last_id";
                    $response['user'] = $row; // Include user data in the response
                } else {
                    // Unable to fetch user data
                    $response['status'] = '0';
                    $response['message'] = 'Failed to fetch user data after insertion';
                }
            }
        } else {
            $response['status'] = '0';
            $response['message'] = 'Sorry! OTP Mismatch';
            $response['ccontactid'] = '';
        }
    }
} elseif (isset($data['case']) && $data['case'] == 'notitoken') {
    $userid = $con->real_escape_string($data['userid']);
    $token = $con->real_escape_string($data['token']);

    $sqlup = "INSERT INTO `notification_token` (`userid`, `token`, `created_at`) VALUES ('$userid', '$token', '$newrd')";
    if (!mysqli_query($con, $sqlup)) {
        exit('Error: '.mysqli_error($con));
    }
    $response['status'] = '1';
    $response['message'] = 'Notification token successfully..';
} elseif (isset($data['case']) && $data['case'] == 'updateprofile') {
    $full_name = $con->real_escape_string($data['fullName']);
    $guru_name = $con->real_escape_string($data['guruName']);
    $date_of_birth = $con->real_escape_string($data['dob']);
    $padvi = $con->real_escape_string($data['padvi']);
    $madhi = $con->real_escape_string($data['madhi']);
    $akhada = $con->real_escape_string($data['akhada']);
    $sampraday = $con->real_escape_string($data['sampraday']);
    $user_type = $con->real_escape_string($data['role']);
    $gotra = $con->real_escape_string($data['gautra']);
    $profession = $con->real_escape_string($data['profession']);
    $sqlup = "UPDATE `$tbl_name` SET full_name='$full_name', guru_name='$guru_name', date_of_birth='$date_of_birth', sampraday='$sampraday', padvi='$padvi', madhi='$madhi', akhada='$akhada', user_type='$user_type', gotra='$gotra', profession='$profession' WHERE id='$data[ccontactid]'";
    if (!mysqli_query($con, $sqlup)) {
        exit('Error: '.mysqli_error());
    }
    $response['status'] = '1';
    $response['ccontactid'] = $data['ccontactid'];
    $response['message'] = 'Update profile successfully..';
} elseif (isset($data['case']) && $data['case'] == 'updateaddress') {
    $zip = $con->real_escape_string($data['pincode']);
    $city = $con->real_escape_string($data['district']);
    $state = $con->real_escape_string($data['state']);
    $street_address = $con->real_escape_string($data['addressLine1']);
    $sqlup = "UPDATE `$tbl_name` SET  city='$city', state='$state', street_address='$street_address',zip='$zip' WHERE id='$data[ccontactid]'";
    if (!mysqli_query($con, $sqlup)) {
        exit('Error: '.mysqli_error());
    }
    $response['status'] = '1';
    $response['ccontactid'] = $data['ccontactid'];
    $response['message'] = 'Update address successfully..';
} elseif (isset($data['case']) && $data['case'] == 'delete') {
    $sqlup = "UPDATE `$tbl_name` SET is_deleted='Deleted', hide='1' WHERE id='{$data['ccontactid']}'";
    if (!mysqli_query($con, $sqlup)) {
        exit('Error: '.mysqli_error());
    }
    $response['status'] = '1';
    $response['ccontactid'] = $data['ccontactid'];
    $response['message'] = 'Profile deleted successfully..';
} elseif (isset($data['case']) && $data['case'] == 'getprofiledetails') {
    $resultdata = mysqli_query($con, "SELECT * FROM `$tbl_name` WHERE id = '{$data['ccontactid']}' ");
    if ($row = mysqli_fetch_array($resultdata)) {
        /*$sqlup = "UPDATE `$tbl_name` SET token='" . $data['token'] . "' WHERE id='$row[id]'";
        if (!mysqli_query($con, $sqlup)) {
            die('Error: ' . mysqli_error());
        }*/
        $response['status'] = '1';
        $response['message'] = 'Login successfully';
        $response['ccontactid'] = $row['id'];
        $response['user'] = $row;
    } else {
        $response['status'] = '0';
        $response['message'] = 'No user found';
        $response['ccontactid'] = '';
    }
} elseif (isset($data['case']) && $data['case'] == 'getdata') {
    if ($data['more'] == '1') {
        $offset = $data['offset'];
        $newoffset = $offset + $limit;
        $response['offset'] = "$newoffset";
        $resultf = mysqli_query($con, "SELECT * FROM `$tbl_name` WHERE is_deleted='Live' AND user_type='$data[role]' AND full_name!='' AND full_name!='Demo User' AND profile_pic!='' ORDER BY id DESC LIMIT $limit OFFSET $offset");
    } else {
        $response['offset'] = '6';
        $resultf = mysqli_query($con, "SELECT * FROM `$tbl_name` WHERE is_deleted='Live' AND user_type='$data[role]' AND full_name!='' AND full_name!='Demo User' AND profile_pic!='' ORDER BY id DESC LIMIT 10");
    }
    if (mysqli_num_rows($resultf) < 1) {
        $response['status'] = '0';
        $response['message'] = 'No data found';
    } else {
        $response['status'] = '1';
        while ($rowf = mysqli_fetch_array($resultf)) {
            $json_array[] = $rowf;
        }
        $response['Data'] = $json_array;
        $response['message'] = 'Data displayed';
    }
} elseif (isset($data['case']) && $data['case'] == 'getpost') {
    if ($data['more'] == '1') {
        $offset = isset($data['offset']) ? intval($data['offset']) : 0;
        $newoffset = $offset + $limit;
        $response['offset'] = "$newoffset";
        $query = "SELECT post.*, users.* 
                  FROM post 
                  INNER JOIN users ON post.userid = users.id 
                  WHERE users.hide='0' 
                  ORDER BY post.postid DESC  
                  LIMIT $limit OFFSET $offset";
    } else {
        $response['offset'] = '6';
        $query = "SELECT post.*, users.* 
                  FROM post 
                  INNER JOIN users ON post.userid = users.id 
                  WHERE users.hide='0' 
                  ORDER BY post.postid DESC 
                  LIMIT 6";
    }

    $resultf = mysqli_query($con, $query);

    if (!$resultf) {
        $response['status'] = '0';
        $response['message'] = 'Query failed: '.mysqli_error($con);
    } elseif (mysqli_num_rows($resultf) < 1) {
        $response['status'] = '0';
        $response['message'] = 'No data found';
    } else {
        $response['status'] = '1';
        $json_array = [];
        while ($rowf = mysqli_fetch_assoc($resultf)) {
            $json_array[] = $rowf;
        }
        $response['Data'] = $json_array;
        $response['message'] = 'Data displayed';
    }
} elseif (isset($data['case']) && $data['case'] == 'gettemple') {
    if ($data['more'] == '1') {
        $offset = $data['offset'];
        $newoffset = $offset + $limit;
        $response['offset'] = "$newoffset";
        $resultf = mysqli_query($con, "SELECT * FROM `entity` WHERE is_deleted='Live' ORDER BY id ASC LIMIT $limit OFFSET $offset");
    } else {
        $response['offset'] = '6';
        $resultf = mysqli_query($con, "SELECT * FROM `entity` WHERE is_deleted='Live' ORDER BY id ASC LIMIT 6");
    }
    if (mysqli_num_rows($resultf) < 1) {
        $response['status'] = '0';
        $response['message'] = 'No data found';
    } else {
        $response['status'] = '1';
        while ($rowf = mysqli_fetch_array($resultf)) {
            $json_array[] = $rowf;
        }
        $response['Data'] = $json_array;
        $response['message'] = 'Data displayed';
    }
} elseif (isset($data['case']) && $data['case'] == 'profilepic') {
    $path = '../storageassets/user';
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }

    if ((!empty($_FILES['picname'])) && ($_FILES['picname']['error'] == 0)) {
        $filename = strtolower(basename($_FILES['picname']['name']));
        $ext = substr($filename, strrpos($filename, '.') + 1);
        $namefile = str_replace(".$ext", '', $filename);
        $newfilename = date('ymdHis');
        // Determine the path to which we want to save this file
        $ext = '.'.$ext;
        $newname = $path.'/'.$newfilename.$ext;
        move_uploaded_file($_FILES['picname']['tmp_name'], $newname);
    }
    if ($ext != '') {
        $ipic = "$newfilename$ext";

        $sqlx = "UPDATE `$tbl_name` SET profile_pic='$ipic' WHERE id= '$data[ccontactid]'";
        if (!mysqli_query($con, $sqlx)) {
            exit('Error: '.mysqli_error($con));
        }
        $response['status'] = '1';
        $response['message'] = 'Profile pic updated';
    } else {
        $response['status'] = '0';
        $response['message'] = 'No Image Found';
    }
} elseif (isset($data['case']) && $data['case'] == 'paynow') {
    $merchantKey = 'O5U4PW160I';
    $baseUrl = 'https://pay.easebuzz.in'; // Change this to production URL when you go live

    // Generate a unique transaction ID
    $txnid = uniqid(); // Using PHP's uniqid function

    // Data to be sent in the request
    $data = [
        'key' => $merchantKey,
        'txnid' => $txnid, // Use the generated transaction ID
        'amount' => $_POST['amount'], // Use the amount passed from the client
        'productinfo' => $_POST['productinfo'], // Use the product info passed from the client
        'firstname' => $_POST['firstname'], // Use the customer's first name passed from the client
        'email' => $_POST['email'], // Use the customer's email passed from the client
        'phone' => $_POST['phone'], // Replace with customer's phone number
        'surl' => 'https://www.sanatanworld.org/success.php', // Replace with your success URL
        'furl' => 'https://www.sanatanworld.org/failure.php', // Replace with your failure URL
        'address1' => $_POST['address1'], // Use the customer's address passed from the client
        'city' => $_POST['city'], // Use the customer's city passed from the client
        'state' => $_POST['state'], // Use the customer's state passed from the client
        'country' => $_POST['country'], // Use the customer's country passed from the client
        'zipcode' => $_POST['zipcode'], // Use the customer's zipcode passed from the client
        'hash' => '', // Calculate and set hash below
    ];

    // Generate hash
    $hashSequence = implode('|', [
        $merchantKey,
        $data['txnid'],
        $data['amount'],
        $data['productinfo'],
        $data['firstname'],
        $data['email'],
        $data['address1'], // Include address1 in hash sequence
        $data['city'], // Include city in hash sequence
        $data['state'], // Include state in hash sequence
        $data['country'], // Include country in hash sequence
        $data['zipcode'], // Include zipcode in hash sequence
        'FXR5OJ7VM6', // Replace with your salt
    ]);
    $data['hash'] = hash('sha512', $hashSequence);

    // Initialize cURL
    $ch = curl_init();

    // Set the URL
    curl_setopt($ch, CURLOPT_URL, $baseUrl.'/payment/initiateLink');

    // Set the request method
    curl_setopt($ch, CURLOPT_POST, true);

    // Set the request data
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    // Return the response instead of outputting it
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the request
    $response = curl_exec($ch);

    // Close cURL resource
    curl_close($ch);

    // $response['message']=$response;

    // Decode the JSON response
    $responseData = json_decode($response, true);

    // Check if request was successful
    if ($responseData && isset($responseData['status']) && $responseData['status'] === 1) {
        // Get access key from response data
        $accessKey = $responseData['data'];
        // Return JSON response with success status
        echo json_encode(['status' => '1', 'access_key' => $accessKey]);
    } else {
        // Request failed
        // Return JSON response with failure status
        echo json_encode(['status' => '0', 'message' => 'Failed to initiate payment.']);
    }
} else {
    $response['message'] = 'No case found';
}

header('Content-Type: application/json');
echo json_encode($response);
mysqli_close($con);
