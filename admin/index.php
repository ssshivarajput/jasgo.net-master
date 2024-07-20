<?php include 'config7.php'; ?>	
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ADMIN PANEL</title>
     <?php include 'bootstrap.php' ; ?>
<script type="text/javascript" src="fancybox/jquery-1.4.2.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://kit.fontawesome.com/f169c3e811.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-zxP/8cFatxC8iduKEyAKl6QMDvxkCDD64m1L+R0mjEuYvVIdNllEMYY0g1pTqyd8IUHsdojH3+eZuW6xflsZvQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script language="javascript" type="text/javascript">
   function ajaxFunction(value){
	
 var ajaxRequest;  // The variable that makes Ajax possible!
 
 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
 // Create a function that will receive data 
 // sent from the server and will update
 // div section in the same page.
 ajaxRequest.onreadystatechange = function(){
   if(ajaxRequest.readyState == 4){
      var ajaxDisplay = document.getElementById('sresponce');
      ajaxDisplay.innerHTML = ajaxRequest.responseText;
   }
 }
 // Now get the value from user and pass it to
 // server script.

 var mode ='news';
 var forget = document.getElementById('forget').value;
  var usertype = document.querySelector('input[name="usertype"]:checked').value; //document.getElementById('usertype').value; 
  //alert(usertype);
 var queryString = "?mode=" + mode ; 
 queryString +=  "&forget=" + forget + "&usertype=" + usertype;
 ajaxRequest.open("GET", "forget.php" + 
                              queryString, true);
 ajaxRequest.send(null); 

}
</script> 
<style type="text/css">
   html, body{width:100%; height:100%; font-family: 'Varela Round', sans-serif; }
	.form-control {
		box-shadow: none;		
		font-weight: normal;
		font-size: 13px;
	}
	.form-control:focus {
		border-color: #33cabb;
		box-shadow: 0 0 8px rgba(0,0,0,0.1);
	}

	.navbar {
		background:none;
		padding-left: 16px;
		padding-right: 16px;
		border-bottom: 0px solid #dfe3e8;
		border-radius: 0;
	}


	.navbar .btn-primary, .navbar .nav .btn-primary:active {
		color: #fff;
		background: #33cabb;
		padding-top: 8px;
		padding-bottom: 6px;
		vertical-align: middle;
		border: none;
	}	
	.navbar .btn-primary:hover, .navbar .nav .btn-primary:focus {		
		color: #fff;
		outline: none;
		background: #31bfb1;
	}


	.navbar .nav .get-started-btn {
		min-width: 120px;
		margin-top: 8px;
		margin-bottom: 8px;
	}

	.navbar .form-wrapper {
		width: 96%; max-width:300px;
		padding: 20px;
        font-size: 14px;
		margin:auto; 
		background:#FFFFFF;
	}

	.navbar .form-wrapper a:hover{
		text-decoration: underline;
	}
	.navbar .form-wrapper .hint-text {
		text-align: center;
		margin-bottom: 15px;
		font-size: 13px;
	}
	.navbar .form-wrapper .social-btn .btn, .navbar .form-wrapper .social-btn .btn:hover {
		color: #fff;
        margin: 0;
		padding: 0 !important;
		font-size: 13px;
		border: none;
		transition: all 0.4s;
		text-align: center;
		line-height: 34px;
		width: 47%;
		text-decoration: none;
    }	
	.navbar .social-btn .btn-primary {
		background: #507cc0;
	}
	.navbar .social-btn .btn-primary:hover {
		background: #4676bd;
	}
	.navbar .social-btn .btn-info {
		background: #64ccf1;
	}
	.navbar .social-btn .btn-info:hover {
		background: #4ec7ef;
	}
	.navbar .social-btn .btn i {
		margin-right: 5px;
		font-size: 16px;
		position: relative;
		top: 2px;
	}
	.navbar .form-wrapper .form-footer {
		text-align: center;
		padding-top: 10px;
		font-size: 13px;
	}
	.navbar .form-wrapper .form-footer a:hover{
		text-decoration: underline;
	}
	.navbar .form-wrapper .checkbox-inline input {
		margin-top: 3px;
	}
	.or-seperator {
        margin-top: 32px;
		text-align: center;
		border-top: 1px solid #e0e0e0;
    }
    .or-seperator b {
		color: #666;
        padding: 0 8px;
		width: 30px;
		height: 30px;
		font-size: 13px;
		text-align: center;
		line-height: 26px;
		background: #fff;
		display: inline-block;
		border: 1px solid #e0e0e0;
		border-radius: 50%;
		position: relative;
		top: -15px;
		z-index: 1;
    }
    .navbar .checkbox-inline {
		font-size: 13px;
	}
	.navbar .navbar-right .dropdown-toggle::after {
		display: none;
	}
	@media (min-width: 1200px){
		.form-inline .input-group {
			width: 300px;
			margin-left: 30px;
		}
	}
	@media (max-width: 768px){
		.navbar form-wrapper {
			width: 100%;
			padding: 10px 15px;
			background: #FFFFFF; 
			border: none;
		}
		.navbar .form-inline {
			display: block;
		}
		.navbar .input-group {
			width: 100%;
		}
		.navbar .nav .btn-primary, .navbar .nav .btn-primary:active {
			display: block;
		}
	}
	.w3-btn,.w3-button{border:none;display:inline-block;outline:0;padding:8px 16px;vertical-align:middle;overflow:hidden;text-decoration:none;color:inherit;background-color:inherit;text-align:center;cursor:pointer;white-space:nowrap}
.w3-display-topright{position:absolute;right:0;top:0}
.w3-modal-content{margin:auto;background-color:#fff;position:relative;padding:0;outline:0;width:90%; max-width:500px;}
.w3-modal{z-index:999;display:block;padding-top:100px;position:fixed;left:0;top:0;width:100%;height:100%;overflow:auto;background-color:rgb(0,0,0);background-color:rgba(0,0,0,0.4)}

.form-group input[type="password"],
.form-group input[type="text"] {
    padding: 10px;
    font-size: 14px;
    border: solid 2px #f0f0f0;
    border-radius: 5px;
    outline: none;
    width: 100%;
}

.form-group input[type="password"]:focus,
.form-group input[type="text"]:focus {
    border: solid 2px #f0f0f0;
    box-shadow: 0 0 5px #f0f0f0;
}

.form-group i {
    margin-left: -30px;
    cursor: pointer;
}

.fa, .far, .fas {
    display: inline;
}
.radio{ height:17px; width:17px;}
</style>

</head> 
<body style="background: #EEEEEE url(images/site-bannerx.jpg) center;">

<div class="navbar">
<?php if (isset($_GET['message']) && $_GET['message']!=="") {?><script>
setTimeout(function() {
    $('#mydiv').fadeOut('slow');
}, 4000);</script><script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<div id="mydiv" style="padding:4px 0px;">
<div style="height:40px; background:#FFDDCC; color:#000000; border:1px solid #FF5C0F; font-size:14px; padding-top:7px;" align="center">
<b style="color:#BB0000;"><i class="icon fa fa-warning"></i> ALERT :</b> <?php echo $_GET['message'] ?>.. </div></div> <?php } ?>
   
<div style="margin-top:50px;" align="center">
				<div class="form-wrapper" id="signin">	
				<img src="images/cover-pic.jpg" style="width:100%"/>				
						<form name="form1" action="verify.php" method="post">
							<p class="hint-text"><b style="color:#00875F">ADMIN CONTROL PANEL</b></p>
							<div class="form-group social-btn clearfix">
							</div>
							<!--<div class="or-seperator"><b>or</b></div>-->
							<div class="form-group">
							<input type="text" class="form-control" name="username" placeholder="Email Id" value="<?php echo @$_COOKIE['suserid'] ?? ''; ?>" required="required">
							</div>
							<div class="form-group">
								<input type="password" id="password" class="form-control" name="password" placeholder="Password" value="<?php echo @$_COOKIE['suserp'] ?? ''; ?>" required="required"> 
								
							</div>
							
							<div class="form-group" align="left">
								<input type="checkbox" name="suserid" value="Y" <?php if(isset($_COOKIE['suserid'])) {?>checked="checked"<?php } ?>  style="padding-top:5px;"> Stay Login
							</div>
							
							<input type="submit" class="btn btn-primary btn-block" value="Login">
							<div class="form-footer">
								<a onClick="toggle_visibility('list');" style="cursor:pointer;">Forgot Your password?</a>
							</div>
							
							<div id="list" style="display:none;">
							<div id="sresponce"></div>
							<div class="form-footer">
							<input type="text" class="form-control" name="forget" id="forget" placeholder="Contact number" /></div>
							
						    <div class="form-footer">
						     <input type="button" class="btn btn-primary btn-block" value="Submit" onClick="ajaxFunction();"></div>
							</div>
							
						</form>
						<div style="height:10px;">&nbsp;</div>
						
				
			</div>
		</div>
     </div>
</body>
</html>    
                                                                              