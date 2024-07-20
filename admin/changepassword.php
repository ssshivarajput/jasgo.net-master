<?php include'check.php'; $pageurl="changepassword"; $pagename="CHANGE/UPDATE SETTINGs ";
if(@$_GET['mode'] =="changepassword" && $_POST['password']!=""){ 
$sql1="UPDATE `settings` SET password ='$_POST[password]' WHERE ID='$userid'";
if (!mysqli_query($con,$sql1)){die('Error: ' . mysqli_error());  }
echo"<META HTTP-EQUIV='REFRESH' CONTENT='0; URL=changepassword?message=Password updated..'>"; exit(0);

} else { ?>	
<!DOCTYPE html>
<html>
 <head>
     <meta charset="UTF-8">
	 <title><?php echo $institute ?></title>
     <?php include 'bootstrap.php' ; ?>
    <style>
      .color-palette {
        height: 50px;
        line-height: 50px;
        text-align: center;

      }
      .color-palette-set {
        margin-bottom: 15px;
      }
      .color-palette span {
        display: none;
      }
      .color-palette:hover span {
        display: block;
      }
	  .blink_me {
  animation: blinker 1s linear infinite;
}

@keyframes blinker {
  50% {
    opacity: 0;
  }
}
    </style>
<SCRIPT language=javascript src="js/FieldValidation.js" type=text/javascript></SCRIPT>
	      <SCRIPT language="javascript" type="text/javascript">
 function goforpassword()
        {
          if(isblank(document.getElementById("ppassword")))
            {
               alert("Error! You must enter your current password..."); 
			  			    document.getElementById("ppassword").focus();
                return false;
            }
			 if(document.getElementById("ppassword").value != document.getElementById("expassword1").value )
            {
               alert("Error! You must enter a valid current password..."); 
			  			    document.getElementById("ppassword").focus();
                return false;
            }
			
			          if(isblank(document.getElementById("password")))
            {
               alert("Error! You must enter new password..."); 
			  			    document.getElementById("password").focus();
                return false;
            }
						          if(isblank(document.getElementById("cppassword")))
            {
               alert("Error! You must enter confirm password..."); 
			  			    document.getElementById("cppassword").focus();
                return false;
            }
			 if(document.getElementById("cppassword").value != document.getElementById("password").value )
            {
               alert("Error! You must enter same password..."); 
			  			    document.getElementById("cppassword").focus();
                return false;
            }

}
 </SCRIPT>
  </head>
  <body class="<?php echo $skincolor ?>">
    <div class="wrapper">
		<?php include 'header1.php'; ?>  
		<?php include 'leftmenu.php'; ?>     
   
     <div class="content-wrapper">
		 <section class="content-header hidem">          
          <ol class="breadcrumb">
         <li style="color:#EC0000;"><i class="fa fa-list"></i> <?php echo $headertext ?></a></li>
			<li class="active"><a href="<?php echo $pageurl ?>" style="color:#0000FF; text-transform:uppercase;"><?php echo $pagename ?></a></li>
          </ol>
        </section><div class="hidem"><br/></div>
    
	<section class="content">
          <div class='row'>
            <div class='col-xs-12'>
            <div class="nav-tabs-custom">        
		    
			<div class="tab-content">
			<?php if ($_GET['message']!=""){?><div style="height:4px;">&nbsp;</div>
<div style="height:40px; background:#FFDDCC; color:#000000; border:1px solid #FF5C0F; font-size:14px; padding-top:7px; padding-left:10px;">
<b style="color:#BB0000;"><i class="icon fa fa-warning"></i> ALERT :</b> <?php echo $_GET['message'] ?>.. </div>
<div style="height:4px;">&nbsp;</div>
   <?php } ?>	
                  <!-- Font Awesome icons -->
                  <div class="tab-pane active" id="changepassword" >
				   
                    <section id="new">
							
				
				<div style="padding-left:10px; font-weight:bold; color:#EC0000;">CHANGE PASSWORD</div>
				 <form name="form1" id="form1" method="post" action="changepassword?mode=changepassword">
		
		 <icon class="btn bg-white margin"><label>Current Password</label>
            <input type="hidden" name="expassword1" id="expassword1" value="<?php echo $expassword ?>" /><input type="password" class="form-control" name="ppassword" id="ppassword" style="width:250px;" /></icon>
           
          
		   <icon class="btn bg-white margin"><label>New Password</label>
           <input type="password" class="form-control"   name="password" id="password" style="width:250px;" /></icon>
           
          
          <icon class="btn bg-white margin"><label>Confirm Password</label>
            <input type="text"  class="form-control"  name="cppassword" id="cppassword" style="width:250px;" style="width:220px;" /></icon>          
  			  
		     <div align="right" style="padding-right:30px;">
              <button type="submit" class="btn btn-primary" onClick="return goforpassword();"><i class="fa fa-fw fa-save"></i>&nbsp;Save</button>
         </div>
        </form>     
	
		
		 

                    </section>
                    
                  </div><!-- /#organization -->         
				 			 

              
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      
    <?php include 'footer.php'; ?>   
    </div><!-- ./wrapper -->
	
<?php include 'plugin.php' ; ?>
		
  </body>
</html>
<?php 
    mysqli_close($con);
} ?>