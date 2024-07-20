<?php include 'check.php';  $pageurl="editcolumn"; $tbl_name=$_GET['tbl_name']; $sessionid=date("ymdHis"); $pagename=$_GET['pagename'];

if(@$_GET['mode']=="create_new"){

$name = $con -> real_escape_string($_POST['name']);

$sql="INSERT INTO `$tbl_name`(`is_active`, `name`, `is_deleted`, `created_at`) VALUES ('1', '$name', 'Live', '$created_at')";
if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con)); }     mysqli_close($con);            
echo"<META HTTP-EQUIV='REFRESH' CONTENT='0; URL=$pageurl?Axy=1'>";  exit(0);   

} else if(@$_GET['mode']=="update" && $_GET['id']!=""){
$name = $con -> real_escape_string($_POST['name']);	
$sql="UPDATE `$tbl_name` SET name='$name' WHERE id ='$_GET[id]'";
if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con)); }  mysqli_close($con);              
echo"<META HTTP-EQUIV='REFRESH' CONTENT='0; URL=$pageurl?Axy=1'>";  exit(0);

} else { ?>

<!DOCTYPE html>
<html>
 <head>
    <meta charset="UTF-8">
     <title>Add/Edit <?php echo $pagename ?></title>
	<?php include 'bootstrap.php' ; ?>
<?php if(@$_GET['Axy']!=""){?>
<script type="text/javascript">
            window.opener.location.reload(true);
            window.close();
</script>
<?php } ?>
	
  <?php
if(@$_GET['id']!="") {$result = mysqli_query($con,"SELECT * FROM `$tbl_name` WHERE id='$_GET[id]'"); 
while($row = mysqli_fetch_array($result)) { $name1 = $row['name'];  }   } ?>	
<style type="text/css">
.radio{ height:15px; width:15px;}
 </style>
  </head>
  <body class="<?php echo $skincolor ?>">
  	<div class="box-header with-border" style="background-color: #E6E6E6; font-size:14PX; font-family:Arial, Helvetica, sans-serif; color:#1515FF; font-weight:bold; text-transform:uppercase;">Add/Edit <?php echo $pagename ?></div>
	
<?php if (@$_GET['message']!=""){?><div style="height:4px;">&nbsp;</div>
<div style="height:40px; background:#FFDDCC; color:#000000; border:1px solid #FF5C0F; font-size:14px; padding-top:7px; padding-left:10px;">
<b style="color:#BB0000;"><i class="icon fa fa-warning"></i> ALERT :</b> <?php echo $_GET['message'] ?>.. </div>
<div style="height:4px;">&nbsp;</div>
   <?php } ?>
   
 	              
	  
 <?php if(@$_GET['id']!="") { ?>
	<form name="form1" id="form1" action="<?php echo $pageurl ?>?mode=update&pagename=<?php echo $pagename ?>&id=<?php echo @$_GET['id'] ?>&tbl_name=<?php echo $tbl_name ?>" method="post"><?php } else { ?>
	<form name="form1" id="form1" action="<?php echo $pageurl ?>?mode=create_new&pagename=<?php echo $pagename ?>&tbl_name=<?php echo $tbl_name ?>" method="post"><?php } ?>
	   <div align="center">


		<icon class="btn bg-white margin"><label><?php echo $pagename ?><span style="color:#FF0000">*</span></label><input type="text" name="name" value="<?php echo $name1 ?>" class="form-control" required="required" style="width:200px;" /></icon>	
		<div style="height:15px;"></div>

<?php if(@$_GET['id']!=""){?><input type="submit" name="action" value="Update <?php echo $pagename ?>" class="btn btn-primary" /><?php } else { ?>
<input type="submit" name="action" value="Create <?php echo $pagename ?>" class="btn btn-primary" /><?php } ?></div>


         </div>				 

</form>

  <br />
 
  
  </body>
</html>
<?php  mysqli_close($con); }  ?>