<?php  session_start(); date_default_timezone_set('Asia/Kolkata'); 
$dd= date("d/m/Y"); $dt= date("h:i:s A"); $now = date("d/m/Y, h:i:s A"); $ipa = $_SERVER['REMOTE_ADDR']; $newrd=date("Y-m-d"); $year = time() + 31536000;
    $con = mysqli_connect("p:localhost","sanatanworld","U7ZYJV2iTh2TFqP","sanatanworld");
		if (!$con) {
    // Connection failed, handle the error
    die("Connection failed: " . mysqli_connect_error()); } else {
    mysqli_query($con,'SET character_set_results=utf8');        
    mysqli_query($con,'SET names=utf8');
    mysqli_query($con,'SET character_set_client=utf8');        
    mysqli_query($con,'SET character_set_connection=utf8');
    mysqli_query($con,'SET collation_connection=utf8_general_ci');
    mysqli_query($con,"SET SESSION sql_mode = ''"); 
	mysqli_query($con,"SET GLOBAL sql_mode=''"); }
	
	// $baseurl="https://sanatanworld.dghub.online";
  $baseurl="https://sanatanworld.org";
	$institute="Sanatan World";
	$extn=""; 
  $username="Sanatan World";
