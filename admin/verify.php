<?php ob_start();  include 'config7.php';   $year = time() + (365 * 24 * 60 * 60); // One year in the future

$user_name1 =$_POST['username'];
$password1 =md5($_POST['password']); 
$tbl_name="user_information";   

//start verifying login details 

if($user_name1 !="" or $password1!=""){
$result = mysqli_query($con,"SELECT * FROM `$tbl_name` WHERE user_email!='' and user_email='$user_name1' and role='superadmin' and del_status='Live'"); 
if($row = mysqli_fetch_array($result)) {	
if ($row['password'] =="$password1") { 
setcookie('scontactid', $row['user_id'], $year); 
setcookie('spassword', $_POST['password'], $year); 
if (isset($_POST['suserid']) && $_POST['suserid'] !== "") {
    // Set cookies if suserid is present in the POST request
   
    setcookie('suserid', $_POST['username'], $year);
    setcookie('suserp', $_POST['password'], $year);
} elseif (!isset($_POST['suserid']) || $_POST['suserid'] === "") {
    // Unset cookies if suserid is not present in the POST request
    setcookie('suserid', '', time() - 3600); // Set expiration time to the past
    setcookie('suserp', '', time() - 3600);
}

echo"<META HTTP-EQUIV='REFRESH' CONTENT='0; URL=dashboard?message=Login successfully..'>"; exit(0);

} else if ($row['password']!= "$password1" ) { 
echo"<META HTTP-EQUIV='REFRESH' CONTENT='0; URL=login?message=Sorry! Password mismatch..'>"; exit(0); }

} else { echo"<META HTTP-EQUIV='REFRESH' CONTENT='0; URL=login?message=Sorry! Invalid contact number or password..'>"; exit(0); }
	
} else { echo"<META HTTP-EQUIV='REFRESH' CONTENT='0; URL=login?message=Fill all entry carefully..'>"; exit(0); } 
mysqli_close($con);?>
