<?php
include 'check.php';

$pageurl = 'addvolunteer';
$tbl_name = 'users';
$sessionid = date('ymdHis');
$pagename = isset($_GET['pagename']) ? $_GET['pagename'] : '';
$conditions = [];
$queryd = "SELECT COUNT(*) as num FROM `designation` WHERE is_deleted='Live'";

// Join query with conditions
$sqlxd = "SELECT d.*, s.name AS state_name FROM `designation` d 
          LEFT JOIN `states` s ON d.stateid = s.id WHERE d.is_deleted='Live'";

if (count($conditions) > 0) {
    $condition_str = ' and '.implode(' and ', $conditions);
    $queryd .= $condition_str;
    $sqlxd .= $condition_str;
}

$sqld = $sqlxd.' ORDER BY d.id ASC';
$resultdesignation = mysqli_query($con, $sqld);
$designation = [];
while ($row = mysqli_fetch_assoc($resultdesignation)) {
    $designation[$row['id']] = $row;
}

if (isset($_GET['mode']) && $_GET['mode'] == 'create_new') {
    // Assign variables properly
    $full_name = $con->real_escape_string($_POST['full_name']);
    $email = $con->real_escape_string($_POST['email']);
    $mobile_no = $con->real_escape_string($_POST['mobile_no']);
    $gotra = $con->real_escape_string($_POST['gotra']);
    $profession = $con->real_escape_string($_POST['profession']);
    $city = $con->real_escape_string($_POST['city']);
    $state = $con->real_escape_string($_POST['state']);
    $country = $con->real_escape_string($_POST['country']);
    $street_address = $con->real_escape_string($_POST['street_address']);
    $whatsapp = $con->real_escape_string($_POST['whatsapp']);
    $facebook = $con->real_escape_string($_POST['facebook']);
    $instagram = $con->real_escape_string($_POST['instagram']);
    $zip = $con->real_escape_string($_POST['zip']);
    $memtype = $con->real_escape_string($_POST['memtype']);
    $memamount = $con->real_escape_string($_POST['memamount']);
    $mempaystatus = $con->real_escape_string($_POST['mempaystatus']);
    $mempad = $con->real_escape_string($_POST['mempad']);
    $inchargename = $con->real_escape_string($_POST['inchargename']);
    $inchargedesignation = $con->real_escape_string($_POST['inchargedesignation']);
    $inchargestate = $con->real_escape_string($_POST['inchargestate']);
    $memvalidfrom_timestamp = strtotime($_POST['memvalidfrom']);
    $memvalidto_timestamp = strtotime($_POST['memvalidto']);
    $memvalidfrom_mysql = date('d F Y', $memvalidfrom_timestamp);
    $memvalidto_mysql = date('d F Y', $memvalidto_timestamp);
    $date_of_birth_timestamp = strtotime($_POST['date_of_birth']);
    $date_of_birth_formatted = date('d F Y', $date_of_birth_timestamp);
    if (!empty($tbl_name)) {
        $sql = "INSERT INTO `$tbl_name`(`is_active`, `full_name`, `date_of_birth`, `email`, `mobile_no`,`gotra`,`profession`, `city`, `state`, `country`, `street_address`, `whatsapp`, `facebook`, `instagram`, `zip`, `is_deleted`, `created_at`, `memtype`, `memamount`, `mempaystatus`, `mempad`,`niyukti_designation`, `niyukti_state`, `niyukti_head`, `memvalidfrom`, `memvalidto`) 
            VALUES ('1', '$full_name', '$date_of_birth_formatted', '$email', '$mobile_no','$gotra','$profession', '$city', '$state', '$country', '$street_address', '$whatsapp', '$facebook', '$instagram', '$zip', 'Live', NOW(), '$memtype', '$memamount', '$mempaystatus', '$mempad', '$inchargedesignation', '$inchargestate', '$inchargename', '$memvalidfrom_mysql', '$memvalidto_mysql')";

        if (!mysqli_query($con, $sql)) {
            exit('Error: '.mysqli_error($con));
        }
        mysqli_close($con);
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='0; URL=$pageurl?Axy=1'>";
        exit(0);
    } else {
        exit('Error: Incorrect table name');
    }
} elseif (isset($_GET['mode']) && $_GET['mode'] == 'update' && isset($_GET['id']) && $_GET['id'] != '') {
    // Assign variables properly
    $full_name = $con->real_escape_string($_POST['full_name']);
    $email = $con->real_escape_string($_POST['email']);
    $mobile_no = $con->real_escape_string($_POST['mobile_no']);
    $gotra = $con->real_escape_string($_POST['gotra']);
    $profession = $con->real_escape_string($_POST['profession']);
    $city = $con->real_escape_string($_POST['city']);
    $state = $con->real_escape_string($_POST['state']);
    $country = $con->real_escape_string($_POST['country']);
    $street_address = $con->real_escape_string($_POST['street_address']);
    $whatsapp = $con->real_escape_string($_POST['whatsapp']);
    $facebook = $con->real_escape_string($_POST['facebook']);
    $instagram = $con->real_escape_string($_POST['instagram']);
    $zip = $con->real_escape_string($_POST['zip']);
    $memtype = $con->real_escape_string($_POST['memtype']);
    $memamount = $con->real_escape_string($_POST['memamount']);
    $mempaystatus = $con->real_escape_string($_POST['mempaystatus']);
    $mempad = $con->real_escape_string($_POST['mempad']);
    $inchargename = $con->real_escape_string($_POST['inchargename']);
        $inchargedesignation = $con->real_escape_string($_POST['inchargedesignation']);
        $inchargestate = $con->real_escape_string($_POST['inchargestate']);
    $memvalidfrom_timestamp = strtotime($_POST['memvalidfrom']);
    $memvalidto_timestamp = strtotime($_POST['memvalidto']);
    $memvalidfrom_mysql = date('d F Y', $memvalidfrom_timestamp);
    $memvalidto_mysql = date('d F Y', $memvalidto_timestamp);
    $date_of_birth_timestamp = strtotime($_POST['date_of_birth']);
    $date_of_birth_formatted = date('d F Y', $date_of_birth_timestamp);
    // Perform update
    $sql = "UPDATE `$tbl_name` SET full_name='$full_name', date_of_birth='$date_of_birth_formatted', email='$email', mobile_no='$mobile_no',gotra='$gotra', profession='$profession', city='$city', state='$state', country='$country', street_address='$street_address', whatsapp='$whatsapp', facebook='$facebook', instagram='$instagram', zip='$zip', memtype='$memtype', memamount='$memamount', mempaystatus='$mempaystatus', mempad='$mempad',niyukti_designation='$inchargedesignation', niyukti_state='$inchargestate', niyukti_head='$inchargename', memvalidfrom='$memvalidfrom_mysql', memvalidto='$memvalidto_mysql' WHERE id ='".$_GET['id']."'";

    if (!mysqli_query($con, $sql)) {
        exit('Error: '.mysqli_error($con));
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
    <title>Add/Edit <?php echo $pagename; ?></title>
    <?php include 'bootstrap.php'; ?>
    <?php if (isset($_GET['Axy']) && $_GET['Axy'] != '') { ?>
        <script type="text/javascript">
            window.opener.location.reload(true);
            window.close();
        </script>
    <?php } ?>
 </head>
 <body class="<?php echo $skincolor; ?>">
    <div class="box-header with-border" style="background-color: #E6E6E6; font-size:14PX; font-family:Arial, Helvetica, sans-serif; color:#1515FF; font-weight:bold; text-transform:uppercase;">Add/Edit <?php echo $pagename; ?></div>

    <?php if (isset($_GET['message']) && $_GET['message'] != '') { ?>
        <div style="height:4px;">&nbsp;</div>
        <div style="height:40px; background:#FFDDCC; color:#000000; border:1px solid #FF5C0F; font-size:14px; padding-top:7px; padding-left:10px;">
            <b style="color:#BB0000;"><i class="icon fa fa-warning"></i> ALERT :</b> <?php echo $_GET['message']; ?>.. 
        </div>
        <div style="height:4px;">&nbsp;</div>
    <?php } ?>
   
   
    <?php
        if (isset($_GET['id']) && $_GET['id'] != '') {
            $result = mysqli_query($con, "SELECT * FROM `$tbl_name` WHERE id='".$_GET['id']."'");
            while ($row = mysqli_fetch_array($result)) {
                $full_name = $row['full_name'];
                $date_of_birth = $row['date_of_birth'];
                $email = $row['email'];
                $mobile_no = $row['mobile_no'];
                $gotra = $row['gotra'];
                $profession = $row['profession'];
                $city = $row['city'];
                $state = $row['state'];
                $country = $row['country'];
                $street_address = $row['street_address'];
                $whatsapp = $row['whatsapp'];
                $facebook = $row['facebook'];
                $instagram = $row['instagram'];
                $zip = $row['zip'];
                $memtype = $row['memtype'];
                $inchargedesignation = $row['niyukti_designation'];
                $inchargestate = $row['niyukti_state'];
                $inchargename = $row['niyukti_head'];
                $memamount = $row['memamount'];
                $mempaystatus = $row['mempaystatus'];
                $mempad = $row['mempad'];
                $memvalidfrom = $row['memvalidfrom'];
                $memvalidto = $row['memvalidto'];
                $date_of_birth = date('Y-m-d', strtotime($date_of_birth));
                $memvalidfrom = date('Y-m-d', strtotime($memvalidfrom));
                $memvalidto = date('Y-m-d', strtotime($memvalidto));
            }
        }
    ?>	 
   <form name="form1" id="form1" action="<?php echo $pageurl; ?>?mode=<?php echo isset($_GET['id']) ? 'update' : 'create_new'; ?>&pagename=<?php echo $pagename; ?>&id=<?php echo @$_GET['id']; ?>&tbl_name=<?php echo $tbl_name; ?>" method="post">
        <div align="center">
            <icon class="btn bg-white margin">
                <label>Name<span style="color:#FF0000"></span></label>
                <input type="text" name="full_name" value="<?php echo $full_name; ?>" class="form-control" style="width:200px;" />
            </icon>	
            <icon class="btn bg-white margin">
                <label>Date of birth<span style="color:#FF0000"></span></label>
                <input type="date" name="date_of_birth" value="<?php echo $date_of_birth; ?>" class="form-control" style="width:200px;" />
            </icon>	
            <icon class="btn bg-white margin">
                <label>Email<span style="color:#FF0000"></span></label>
                <input type="text" name="email" value="<?php echo $email; ?>" class="form-control"  style="width:200px;" />
            </icon>	
            <icon class="btn bg-white margin">
                <label>Mobile number<span style="color:#FF0000"></span></label>
                <input type="text" name="mobile_no" value="<?php echo $mobile_no; ?>" class="form-control" style="width:200px;" />
            </icon>
            <icon class="btn bg-white margin">
                <label>Gotra<span style="color:#FF0000"></span></label>
                <input type="text" name="gotra" value="<?php echo $gotra; ?>" class="form-control"  style="width:200px;" />
            </icon>	 
              <icon class="btn bg-white margin">
                <label>Profession<span style="color:#FF0000"></span></label>
                <input type="text" name="profession" value="<?php echo $profession; ?>" class="form-control"  style="width:200px;" />
            </icon>	
            <icon class="btn bg-white margin">
                <label>City<span style="color:#FF0000"></span></label>
                <input type="text" name="city" value="<?php echo $city; ?>" class="form-control"style="width:200px;" />
            </icon>	
             <icon class="btn bg-white margin">
                <label>State<span style="color:#FF0000"></span></label>
                <input type="text" name="state" value="<?php echo $state; ?>" class="form-control" style="width:200px;" />
            </icon>	
             <icon class="btn bg-white margin">
                <label>Country<span style="color:#FF0000"></span></label>
                <input type="text" name="country" value="<?php echo $country; ?>" class="form-control" style="width:200px;" />
            </icon>	
            <icon class="btn bg-white margin">
                <label>Address<span style="color:#FF0000"></span></label>
                <input type="text" name="street_address" value="<?php echo $street_address; ?>" class="form-control"  style="width:200px;" />
            </icon>
            
            <icon class="btn bg-white margin">
                <label>zip<span style="color:#FF0000"></span></label>
                <input type="text" name="zip" value="<?php echo $zip; ?>" class="form-control"  style="width:200px;" />
            </icon>	
            <icon class="btn bg-white margin">
                <label>whatsapp<span style="color:#FF0000"></span></label>
                <input type="text" name="whatsapp" value="<?php echo $whatsapp; ?>" class="form-control" style="width:200px;" />
            </icon>	
             <icon class="btn bg-white margin">
                <label>facebook<span style="color:#FF0000"></span></label>
                <input type="text" name="facebook" value="<?php echo $facebook; ?>" class="form-control" style="width:200px;" />
            </icon>	 
            <icon class="btn bg-white margin">
                <label>Instagram<span style="color:#FF0000"></span></label>
                <input type="text" name="instagram" value="<?php echo $instagram; ?>" class="form-control" style="width:200px;" />
            </icon>	
              <icon class="btn bg-white margin">
                <label>Membership Type<span style="color:#FF0000"></span></label>
                <input type="text" name="memtype" value="<?php echo $memtype; ?>" class="form-control" style="width:200px;" />
            </icon>	 
            <icon class="btn bg-white margin">
                <label>Membership Amount<span style="color:#FF0000"></span></label>
                <input type="text" name="memamount" value="<?php echo $memamount; ?>" class="form-control" style="width:200px;" />
            </icon>	
            <icon class="btn bg-white margin">
                <label>Payment Status<span style="color:#FF0000"></span></label>
                <input type="text" name="mempaystatus" value="<?php echo $mempaystatus; ?>" class="form-control" style="width:200px;" />
            </icon>	 
            <icon class="btn bg-white margin">
                <label>Member's Pad<span style="color:#FF0000"></span></label>
                <input type="text" name="mempad" value="<?php echo $mempad; ?>" class="form-control" style="width:200px;" />
            </icon>	 
            <icon class="btn bg-white margin">
    <label>Niyukti Incharge Name<span style="color:#FF0000"></span></label>
    <select  name="inchargename" class="form-control" style="width:200px;">
    <option value="">Select Incharge Name</option>
    <?php
    foreach ($designation as $key => $value) { ?>
        <option value="<?php echo $value['name']; ?>" <?php if ($value['name'] == $inchargename) echo 'selected'; ?>>
            <?php echo $value['name']; ?>
        </option>
    <?php } ?>
</select>

</icon>

            <icon class="btn bg-white margin">
                <label>Incharge Designation<span style="color:#FF0000"></span></label>
                <select class="form-control" name="inchargedesignation" style="width:200px;>
                        <option value="">Select Designation</option>
                        <?php foreach ($designation as $key => $value) { ?>
                            <option value="<?php echo $value['designation']; ?>" <?php if ($value['designation'] == $inchargedesignation) echo 'selected'; ?>>
                                <?php echo $value['designation']; ?>
                            </option>
                        <?php } ?>
                    </select>
            </icon>
            <icon class="btn bg-white margin">
                <label>Niyukti Incharge State<span style="color:#FF0000"></span></label>
                <select class="form-control" name="inchargestate" style="width:200px;>
                        <option value="">Select State</option>
                        <?php foreach ($designation as $key => $value) { ?>
                            <option value="<?php echo $value['state_name']; ?>" <?php if ($value['state_name'] == $inchargestate) echo 'selected'; ?>>
                                <?php echo $value['state_name']; ?>
                            </option>
                        <?php } ?>
                    </select>
            </icon>
            <icon class="btn bg-white margin">
             <label>Membership Valid From<span style="color:#FF0000"></span></label>
              <input type="date" name="memvalidfrom" value="<?php echo $memvalidfrom; ?>" class="form-control" style="width:200px;" />
            </icon>
            <icon class="btn bg-white margin">
            <label>Membership Valid To<span style="color:#FF0000"></span></label>
            <input type="date" name="memvalidto" value="<?php echo $memvalidto; ?>" class="form-control" style="width:200px;" />
            </icon>

            <input type="submit" name="action" value="<?php echo isset($_GET['id']) ? 'Update' : 'Create'; ?> <?php echo $pagename; ?>" class="btn btn-primary" />
        </div>
    </form>
    <br />
 </body>
 <script>
document.addEventListener("DOMContentLoaded", function() {
    const inchargeNameSelect = document.querySelector('[name="inchargename"]');
    const designationSelect = document.querySelector('[name="inchargedesignation"]');
    const stateSelect = document.querySelector('[name="inchargestate"]');
    
    const designationData = <?php echo json_encode($designation); ?>;
    
    inchargeNameSelect.addEventListener('change', function() {
        const selectedInchargeName = this.value;
        const selectedIncharge = Object.values(designationData).find(item => item.name === selectedInchargeName);
        
        if (selectedIncharge) {
            designationSelect.value = selectedIncharge.designation;
            stateSelect.value = selectedIncharge.state_name;
        } else {
            designationSelect.value = '';
            stateSelect.value = '';
        }
    });
});
</script>

</html>
<?php
mysqli_close($con);
}
?>
