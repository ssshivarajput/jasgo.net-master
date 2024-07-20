<?php
date_default_timezone_set('Asia/Kolkata');
$tbl_name = "users"; 
// Database Connection
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

// Handle multipart request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['case']) && $_POST['case'] == "profilepic") {
    $path = "../storageassets/user";
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }

    // Check if file is uploaded successfully
    if (isset($_FILES["picname"]) && $_FILES['picname']['error'] == 0) {
        $filename = strtolower(basename($_FILES['picname']['name']));
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $newfilename = date("ymdHis") . '.' . $ext;

        // Determine the path to which we want to save this file
        $newname = $path . '/' . $newfilename;

        // Move uploaded file to destination directory
        if (move_uploaded_file($_FILES['picname']['tmp_name'], $newname)) {
            // Update database with the new profile picture
            $sqlx = "UPDATE `$tbl_name` SET profile_pic='$newfilename' WHERE id= '{$_POST['ccontactid']}'";
            if (!mysqli_query($con, $sqlx)) {
                $response['status'] = '0';
                $response['message'] = 'Error updating profile pic';
            } else {
                $response['status'] = '1';
                $response['message'] = 'Profile pic updated';
            }
        } else {
            $response['status'] = '0';
            $response['message'] = 'Error moving uploaded file';
        }
    } else {
        $response['status'] = '0';
        $response['message'] = 'No Image Found';
    }
} else {
    $response['status'] = '0';
    $response['message'] = 'Invalid Request';
}

// Send response back as JSON
header('Content-Type: application/json');
echo json_encode($response);
mysqli_close($con);
?>
