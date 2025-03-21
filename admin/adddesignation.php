<?php
include 'check.php';

$pageurl = "adddesignation";
$tbl_name = "designation";
$sessionid = date("ymdHis");
$pagename = isset($_GET['pagename']) ? $_GET['pagename'] : '';

// Fetch states list
$states = [];
$result = mysqli_query($con, "SELECT id, name FROM states ORDER BY name");
while ($row = mysqli_fetch_assoc($result)) {
    $states[] = $row;
}

if (isset($_GET['mode']) && $_GET['mode'] == "create_new") {
    // Assign variables properly
    $name = $con->real_escape_string($_POST['name']);
    $designation = $con->real_escape_string($_POST['designation']);
    $stateid = $con->real_escape_string($_POST['stateid']);
    if (!empty($tbl_name)) {
        $sql = "INSERT INTO `$tbl_name`(`is_active`, `name`, `designation`, `stateid`,  `is_deleted`, `created_at`) 
            VALUES ('1', '$name', '$designation', '$stateid',  'Live', NOW())";

        if (!mysqli_query($con, $sql)) {
            die('Error: ' . mysqli_error($con));
        }
        mysqli_close($con);
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='0; URL=$pageurl?Axy=1'>";
        exit(0);
    } else {
        die('Error: Incorrect table name');
    }
} else if (isset($_GET['mode']) && $_GET['mode'] == "update" && isset($_GET['id']) && $_GET['id'] != "") {
    // Assign variables properly
    $name = $con->real_escape_string($_POST['name']);
    $designation = $con->real_escape_string($_POST['designation']);
    $stateid = $con->real_escape_string($_POST['stateid']);

    // Perform update
    $sql = "UPDATE `$tbl_name` SET name='$name', designation='$designation', stateid='$stateid' WHERE id ='".$_GET['id']."'";

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
    <?php include 'bootstrap.php'; ?>
    <?php if (isset($_GET['Axy']) && $_GET['Axy'] != "") { ?>
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
    $name = $designation = $stateid = '';
    if (isset($_GET['id']) && $_GET['id'] != "") {
        $result = mysqli_query($con, "SELECT * FROM `$tbl_name` WHERE id='" . $_GET['id'] . "'");
        while ($row = mysqli_fetch_array($result)) {
            $name = $row['name'];
            $designation = $row['designation'];
            $stateid = $row['stateid'];
        }
    }
    ?>

    <form name="form1" id="form1" action="<?php echo $pageurl ?>?mode=<?php echo isset($_GET['id']) ? 'update' : 'create_new' ?>&pagename=<?php echo $pagename ?>&id=<?php echo @$_GET['id'] ?>&tbl_name=<?php echo $tbl_name ?>" method="post">
        <div align="center">
            <icon class="btn bg-white margin">
                <label>Name<span style="color:#FF0000"></span></label>
                <input type="text" name="name" value="<?php echo $name ?>" class="form-control" style="width:200px;" />
            </icon>
            <icon class="btn bg-white margin">
                <label>Designation<span style="color:#FF0000"></span></label>
                <input type="text" name="designation" value="<?php echo $designation ?>" class="form-control" style="width:200px;" />
            </icon>
            <icon class="btn bg-white margin">
                <label>Select State<span style="color:#FF0000"></span></label>
                <select name="stateid" class="form-control" style="width:200px;">
                    <option value="">Select State</option>
                    <?php foreach ($states as $state) { ?>
                        <option value="<?php echo $state['id']; ?>" <?php echo ($state['id'] == $stateid) ? 'selected' : ''; ?>><?php echo $state['name']; ?></option>
                    <?php } ?>
                </select>
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
