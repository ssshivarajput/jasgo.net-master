<?php include 'check.php';  

$pageurl = "addashram"; 
$tbl_name = "entity"; 
$sessionid = date("ymdHis"); 
$pagename = isset($_GET['pagename']) ? $_GET['pagename'] : '';

if(isset($_GET['mode']) && $_GET['mode'] == "create_new"){
    $entity_name = $con->real_escape_string($_POST['entity_name']);
    $email_id = $con->real_escape_string($_POST['email_id']);
    $website = $con->real_escape_string($_POST['website']);
    $foundation_date = $con->real_escape_string($_POST['foundation_date']);
    $description = $con->real_escape_string($_POST['description']);
    $live_darshan_link = $con->real_escape_string($_POST['live_darshan_link']);
    $opening_time = $con->real_escape_string($_POST['opening_time']);
    $closing_time = $con->real_escape_string($_POST['closing_time']);

    $city = $con->real_escape_string($_POST['city']);
    $state = $con->real_escape_string($_POST['state']);
    $zip= $con->real_escape_string($_POST['zip']);
    $country = $con->real_escape_string($_POST['country']);
    $street_address = $con->real_escape_string($_POST['street_address']);
    $whatsapp = $con->real_escape_string($_POST['whatsapp']);
    $facebook = $con->real_escape_string($_POST['facebook']);
    $instagram = $con->real_escape_string($_POST['instagram']);
    if (!empty($tbl_name)) {
        $sql = "INSERT INTO `$tbl_name`(`is_active`, `entity_name`,`email_id`,`website`,`foundation_date`, `description`,`live_darshan_link`,`opening_time`,`closing_time`,`city`,`state`,`zip`,`country`,`street_address`,`whatsapp`,`facebook`,`instagram`, `is_deleted`, `created_at`) 
                                   VALUES ('1', '$entity_name','$email_id','$website','$foundation_date','$description','$live_darshan_link','$opening_time','$closing_time','$city','$state','$zip','$country','$street_address','$whatsapp','$facebook','$instagram', 'Live', '$created_at')";
        if (!mysqli_query($con, $sql)) {
            die('Error: ' . mysqli_error($con)); 
        }     
        mysqli_close($con);            
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='0; URL=$pageurl?Axy=1'>";  
        exit(0);   
    } else {
        die('Error: Incorrect table name');
    }
} else if(isset($_GET['mode']) && $_GET['mode'] == "update" && isset($_GET['id']) && $_GET['id'] != "") {
    $entity_name = $con->real_escape_string($_POST['entity_name']);  
    $email_id = $con->real_escape_string($_POST['email_id']); 
    $website = $con->real_escape_string($_POST['website']); 
    $foundation_date = $con->real_escape_string($_POST['foundation_date']); 
    $description = $con->real_escape_string($_POST['description']); 
    $live_darshan_link = $con->real_escape_string($_POST['live_darshan_link']); 
    $opening_time = $con->real_escape_string($_POST['opening_time']); 
    $closing_time = $con->real_escape_string($_POST['closing_timek']); 
    $city = $con->real_escape_string($_POST['city']); 
    $state = $con->real_escape_string($_POST['state']); 
    $zip = $con->real_escape_string($_POST['zip']); 
    $country = $con->real_escape_string($_POST['country']); 
    $street_address = $con->real_escape_string($_POST['street_address']); 
    $whatsapp = $con->real_escape_string($_POST['whatsapp']); 
    $facebook = $con->real_escape_string($_POST['facebook']); 
    $instagram = $con->real_escape_string($_POST['instagram']);
  
    $sql = "UPDATE `$tbl_name` SET entity_name='$entity_name',email_id='$email_id',website='$website',foundation_date='$foundation_date',description='$description',live_darshan_link='$live_darshan_link',opening_time='$opening_time',closing_time='$closing_time',city='$city',state='$state',zip='$zip',country='$country',street_address='$street_address',whatsapp='$whatsapp',facebook='$facebook',instagram='$instagram' WHERE id ='".$_GET['id']."'";
  
    if (!mysqli_query($con, $sql)) {
        die('Error: ' . mysqli_error($con));
    }
    mysqli_close($con);              
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0; URL=$pageurl?Axy=1'>";
    exit(0);
} else { 
?>
<!DOCTYPE html>
<html>
 <head>
    <meta charset="UTF-8">
    <title>Add/Edit <?php echo $pagename ?></title>
    <?php include 'bootstrap.php' ; ?>
    <?php if(isset($_GET['Axy']) && $_GET['Axy'] != "") { ?>
        <script type="text/javascript">
            window.opener.location.reload(true);
            window.close();
        </script>
    <?php } ?>
 </head>
 <body class="<?php echo $skincolor ?>">
    <div class="box-header with-border" style="background-color: #E6E6E6; font-size:14PX; font-family:Arial, Helvetica, sans-serif; color:#1515FF; font-weight:bold; text-transform:uppercase;">Add/Edit <?php echo $pagename ?></div>

    <?php if (isset($_GET['message']) && $_GET['message'] != "") { ?>
        <div style="height:4px;">&nbsp;</div>
        <div style="height:40px; background:#FFDDCC; color:#000000; border:1px solid #FF5C0F; font-size:14px; padding-top:7px; padding-left:10px;">
            <b style="color:#BB0000;"><i class="icon fa fa-warning"></i> ALERT :</b> <?php echo $_GET['message'] ?>.. 
        </div>
        <div style="height:4px;">&nbsp;</div>
    <?php } ?>
   
    <?php 
    if(isset($_GET['id']) && $_GET['id'] != "") {
        $result = mysqli_query($con, "SELECT * FROM `$tbl_name` WHERE id='".$_GET['id']."'"); 
        while($row = mysqli_fetch_array($result)) { 
            $entity_name = $row['entity_name']; 
            $email_id = $row['email_id'];  
            $website = $row['website'];  
            $foundation_date = $row['foundation_date'];  
            $description = $row['description'];  
            $live_darshan_link = $row['live_darshan_link'];  
            $opening_time = $row['opening_time'];  
            $closing_time = $row['closing_time'];  
            $city = $row['city'];  
            $state = $row['state'];  
            $zip = $row['zip'];  
            $country = $row['country'];  
            $street_address = $row['street_address'];  
            $whatsapp = $row['whatsapp'];  
            $facebook = $row['facebook'];          
            $instagram = $row['instagram'];  
        } 
    } 
    ?>	
  <form name="form1" id="form1" action="<?php echo $pageurl ?>?mode=<?php echo isset($_GET['id']) ? 'update' : 'create_new' ?>&pagename=<?php echo $pagename ?>&id=<?php echo @$_GET['id'] ?>&tbl_name=<?php echo $tbl_name ?>" method="post">
    <div align="center">
        <icon class="btn bg-white margin">
                <label>Temple/Ashram Name<span style="color:#FF0000"></span></label>
                <input type="text" name="entity_name" value="<?php echo $entity_name ?>" class="form-control"style="width:200px;" />
            </icon>	
            <icon class="btn bg-white margin">
                <label>Email<span style="color:#FF0000"></span></label>
                <input type="text" name="email_id" value="<?php echo $email_id ?>" class="form-control"style="width:200px;" />
            </icon>	

            <icon class="btn bg-white margin">
                <label>Website<span style="color:#FF0000"></span></label>
                <input type="text" name="website" value="<?php echo $website ?>" class="form-control" style="width:200px;" />
            </icon>	
            <icon class="btn bg-white margin">
                <label>Foundation Date<span style="color:#FF0000"></span></label>
                <input type="text" name="foundation_date" value="<?php echo $foundation_date ?>" class="form-control" style="width:200px;" />
            </icon>	  
            <icon class="btn bg-white margin">
                <label>Description<span style="color:#FF0000"></span></label>
                <input type="text" name="description" value="<?php echo $description ?>" class="form-control" style="width:200px;" />
            </icon>	
            <icon class="btn bg-white margin">
                <label>Live Darshan Link<span style="color:#FF0000"></span></label>
                <input type="text" name="live_darshan_link" value="<?php echo $live_darshan_link ?>" class="form-control" style="width:200px;" />
            </icon>	
            <icon class="btn bg-white margin">
                <label>Opening Time<span style="color:#FF0000"></span></label>
                <input type="text" name="opening_time" value="<?php echo $opening_time ?>" class="form-control" style="width:200px;" />
            </icon>	
            <icon class="btn bg-white margin">
                <label>Closing Time<span style="color:#FF0000"></span></label>
                <input type="text" name="closing_time" value="<?php echo $closing_time ?>" class="form-control" style="width:200px;" />
            </icon>	
        <icon class="btn bg-white margin">
                <label>City<span style="color:#FF0000"></span></label>
                <input type="text" name="city" value="<?php echo $city ?>" class="form-control"style="width:200px;" />
            </icon>	
             <icon class="btn bg-white margin">
                <label>State<span style="color:#FF0000"></span></label>
                <input type="text" name="state" value="<?php echo $state ?>" class="form-control" style="width:200px;" />
            </icon>	
             <icon class="btn bg-white margin">
                <label>zip<span style="color:#FF0000"></span></label>
                <input type="text" name="zip" value="<?php echo $zip ?>" class="form-control" style="width:200px;" />
            </icon>	  
               <icon class="btn bg-white margin">
                <label>Country<span style="color:#FF0000"></span></label>
                <input type="text" name="country" value="<?php echo $country ?>" class="form-control" style="width:200px;" />
            </icon>	                       
            <icon class="btn bg-white margin">
                <label>Address<span style="color:#FF0000"></span></label>
                <input type="text" name="street_address" value="<?php echo $street_address ?>" class="form-control"  style="width:200px;" />
            </icon>
           
            <icon class="btn bg-white margin">
                <label>whatsapp<span style="color:#FF0000"></span></label>
                <input type="text" name="whatsapp" value="<?php echo $whatsapp ?>" class="form-control" style="width:200px;" />
            </icon>	
             <icon class="btn bg-white margin">
                <label>facebook<span style="color:#FF0000"></span></label>
                <input type="text" name="facebook" value="<?php echo $facebook ?>" class="form-control" style="width:200px;" />
            </icon>	 
            <icon class="btn bg-white margin">
                <label>Instagram<span style="color:#FF0000"></span></label>
                <input type="text" name="instagram" value="<?php echo $instagram ?>" class="form-control" style="width:200px;" />
            </icon>	
            <input type="submit" name="action" value="<?php echo isset($_GET['id']) ? 'Update' : 'Create' ?> <?php echo $pagename ?>" class="btn btn-primary" />
        </div>
</form>

    <br />
 </body>
</html>
<?php  
mysqli_close($con); 
}  
?>
