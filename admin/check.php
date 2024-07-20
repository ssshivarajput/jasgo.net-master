<?php include 'config7.php'; 
if(!isset($_COOKIE['scontactid'])) {header("Location: index?message=Login to continue.."); exit(0); }

$result1 = mysqli_query($con,"SELECT * FROM `user_information` WHERE user_id='$_COOKIE[scontactid]' and role='superadmin' and del_status='Live'");
if($row1 = mysqli_fetch_array($result1)) { $userid= $row1['user_id']; 
$username=$row1['user_name']; 
$usercontact=$row1['mobile'];
$type=$row1['role']; 
$expassword=$row1['password']; 
$useremail=$row1['user_email'];
} else { header("Location: login?message=Sorry!, something went wrong.."); exit(0); }


$skincolor="skin-purple";
$greencolor="#00875F"; //$checkpermissions = explode(',',$permissions);  if($pic==""){$pic="default.jpg";} ?>

 