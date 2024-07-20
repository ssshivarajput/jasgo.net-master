<?php

date_default_timezone_set('Asia/Kolkata');
$tbl_name = 'post';
$ipa = $_SERVER['REMOTE_ADDR'];
$newrd = date('Y-m-d H:i:s');

// Database Connection
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

// Debug: Log the incoming request method and payload
file_put_contents('debug.log', "Request Method: " . $_SERVER['REQUEST_METHOD'] . "\n", FILE_APPEND);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['case']) && $_POST['case'] === 'addpost') {
        // Handle multipart form data for addpost
        handleAddPost($con, $_POST, $_FILES);
    } else if (isset($_POST['case']) && $_POST['case'] === 'addpostvideo') {
        // Handle multipart form data for addpost
        handleAddPostVideo($con, $_POST, $_FILES);
    } else {
        // Handle other cases with JSON payload
        $requestPayload = file_get_contents('php://input');
        $requestData = json_decode($requestPayload, true);
        file_put_contents('debug.log', "JSON Payload: " . print_r($requestData, true) . "\n", FILE_APPEND);

        if (isset($requestData['case'])) {
            switch ($requestData['case']) {
                case 'deletepost':
                    handleDeletePost($con, $requestData);
                    break;
                case 'editpost':
                    handleEditPost($con, $requestData);
                    break;
                case 'getpost':
                    handleGetPost($con, $requestData);
                    break;
                case 'getuserpost':
                    handleGetUserPost($con, $requestData);
                    break;
                default:
                    $response['status'] = '0';
                    $response['message'] = 'Invalid Request';
                    sendResponse($response);
            }
        } else {
            $response['status'] = '0';
            $response['message'] = 'Invalid Request';
            sendResponse($response);
        }
    }
} else {
    $response['status'] = '0';
    $response['message'] = 'Invalid Request';
    sendResponse($response);
}
mysqli_close($con);

function handleAddPost($con, $postData, $filesData)
{
    global $tbl_name, $newrd;
    $path = '../storageassets/post';
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }

    $userid = $postData['userid'];
    $postdesc = $postData['postdesc'];

    if (isset($filesData['picname']) && $filesData['picname']['error'] == 0) {
        $filename = strtolower(basename($filesData['picname']['name']));
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $newfilename = date('ymdHis').'.'.$ext;
        $newname = $path.'/'.$newfilename;

        if (move_uploaded_file($filesData['picname']['tmp_name'], $newname)) {
            $sqlx = "INSERT INTO `$tbl_name` (`userid`, `post_desc`, `post_img1`, `created_att`) VALUES ('$userid', '$postdesc', '$newfilename', '$newrd')";
            if (!mysqli_query($con, $sqlx)) {
                $response['status'] = '0';
                $response['message'] = 'Error uploading post';
            } else {
                $response['status'] = '1';
                $response['message'] = 'Post uploaded successfully';
            }
        } else {
            $response['status'] = '0';
            $response['message'] = 'Error uploading post';
        }
    } else {
        $response['status'] = '0';
        $response['message'] = 'No Image Found';
    }

    sendResponse($response);
}

function handleAddPostVideo($con, $postData, $filesData)
{
    global $tbl_name, $newrd;
    $path = '../storageassets/post';
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }

    $userid = $postData['userid'];
    $postdesc = $postData['postdesc'];

    if (isset($filesData['picname']) && $filesData['picname']['error'] == 0) {
        $filename = strtolower(basename($filesData['picname']['name']));
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $newfilename = date('ymdHis').'.'.$ext;
        $newname = $path.'/'.$newfilename;

        if (move_uploaded_file($filesData['picname']['tmp_name'], $newname)) {
            $sqlx = "INSERT INTO `$tbl_name` (`userid`, `post_desc`, `post_video`, `created_att`) VALUES ('$userid', '$postdesc', '$newfilename', '$newrd')";
            if (!mysqli_query($con, $sqlx)) {
                $response['status'] = '0';
                $response['message'] = 'Error uploading post';
            } else {
                $response['status'] = '1';
                $response['message'] = 'Post uploaded successfully';
            }
        } else {
            $response['status'] = '0';
            $response['message'] = 'Error uploading post';
        }
    } else {
        $response['status'] = '0';
        $response['message'] = 'No Image Found';
    }

    sendResponse($response);
}




function handleDeletePost($con, $requestData)
{
    $postid = $requestData['postid'];

    $sql = "SELECT `post_img1` FROM `post` WHERE `postid` = '$postid'";
    $result = mysqli_query($con, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $postImage = $row['post_img1'];

        if (!empty($postImage)) {
            $filePath = '../storageassets/post/'.$postImage;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $deleteSql = "DELETE FROM `post` WHERE `postid` = '$postid'";
        if (mysqli_query($con, $deleteSql)) {
            $response['status'] = '1';
            $response['message'] = 'Post deleted successfully';
        } else {
            $response['status'] = '0';
            $response['message'] = 'Error deleting post';
        }
    } else {
        $response['status'] = '0';
        $response['message'] = 'Post not found';
    }

    sendResponse($response);
}

function handleEditPost($con, $requestData)
{
    $postid = $requestData['postid'];
    $postdesc = $requestData['postdesc'];

    $sql = "UPDATE `post` SET `post_desc` = '$postdesc' WHERE `postid` = '$postid'";
    if (mysqli_query($con, $sql)) {
        $response['status'] = '1';
        $response['message'] = 'Post updated successfully';
    } else {
        $response['status'] = '0';
        $response['message'] = 'Error updating post';
    }

    sendResponse($response);
}

function handleGetPost($con, $requestData)
{
    $limit = 6; // Default limit
    $offset = isset($requestData['offset']) ? intval($requestData['offset']) : 0;

    if ($requestData['more'] == '1') {
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

    sendResponse($response);
}

function handleGetUserPost($con, $requestData)
{
    $userid = $requestData['userid'];
    $limit = 6; // Default limit
    $offset = isset($requestData['offset']) ? intval($requestData['offset']) : 0;

    if ($requestData['more'] == '1') {
        $newoffset = $offset + $limit;
        $response['offset'] = "$newoffset";
        $query = "SELECT post.*, users.* 
                  FROM post 
                  INNER JOIN users ON post.userid = users.id 
                  WHERE users.hide='0' AND post.userid = '$userid'
                  ORDER BY post.postid DESC  
                  LIMIT $limit OFFSET $offset";
    } else {
        $response['offset'] = '6';
        $query = "SELECT post.*, users.* 
                  FROM post 
                  INNER JOIN users ON post.userid = users.id 
                  WHERE users.hide='0' AND post.userid = '$userid'
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

    sendResponse($response);
}

function sendResponse($response)
{
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
