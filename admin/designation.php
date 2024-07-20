<?php
include 'check.php';
$pageurl = 'designation';
$tbl_name = 'designation';
$mintablewidth = '950px';
$pagename = 'Designation Details';

$page = @$_GET['page'];

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $studentchapter1 = '';

    if (!empty($_POST['ids'])) {
        $ids = implode(', ', $_POST['ids']);
        $companyasend = str_replace(', ', "' or id = '", $ids);

        if ($action == 'Delete') {
            $sql = "UPDATE `$tbl_name` SET is_deleted='Deleted' WHERE id='$companyasend'";
        } elseif ($action == 'ON') {
            $sql = "UPDATE `$tbl_name` SET is_active ='1' WHERE id='$companyasend'";
        } elseif ($action == 'OFF') {
            $sql = "UPDATE `$tbl_name` SET is_active ='0' WHERE id='$companyasend'";
        }

        if (!mysqli_query($con, $sql)) {
            exit('Error: '.mysqli_error($con));
        }
        mysqli_close($con);
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='0; URL=$pageurl?page=$_GET[page]&message=$pagename updated..'>";
        exit(0);
    }
} else { ?>
<!DOCTYPE html>
<html>
<head>  
    <meta charset="UTF-8">
    <title><?php echo $pagename; ?></title>
    <?php include 'bootstrap.php'; ?>
    <style type="text/css">
        #printable { display: none; }
        @media print {
            #non-printable { display: none; }
            #printable { display: block; }
        }
        .mywidth1 { width:100%; font-size:14px; }
        @media (max-width: 799px) {
            .hidem { display: none; visibility:hidden; }
            .mywidth1 { width:600px; }
        } 
        .boxw { width:200px; } 
        @media (max-width: 480px) { 
            .boxw { width:200px; } 
        } 
    </style>
</head>
<body class="<?php echo $skincolor; ?>">
<div id="non-printable">
    <div class="wrapper">
        <?php include 'header1.php'; ?> 
        <?php include 'leftmenu.php'; ?>     
        <div class="content-wrapper">
            <section class="content-header">          
                <ol class="breadcrumb">
                    <li style="text-transform:uppercase;color:#EC0000;"><i class="fa fa-list"></i> <?php echo $institute; ?></a></li>
                    <li class="active"><a href="<?php echo $pageurl; ?>" style="color:#0000FF;"><?php echo $pagename; ?></a></li>
                </ol>
            </section>
            <div class="hidem"><br/></div>
            <section class="content">
                <div class='row'>
                    <div class='col-xs-12'>
                        <div class="nav-tabs-custom">
                            <div class="tab-content">
                                <?php if (@$_GET['message'] != '') {?>
                                    <div style="height:4px;">&nbsp;</div>
                                    <div style="height:40px; background:#FFDDCC; color:#000000; border:1px solid #FF5C0F; font-size:14px; padding-top:7px; padding-left:10px;">
                                        <b style="color:#BB0000;"><i class="icon fa fa-warning"></i> ALERT :</b> <?php echo $_GET['message']; ?>.. 
                                    </div>
                                    <div style="height:4px;">&nbsp;</div>
                                <?php } ?>    
                                <form name="find" action="" method="get">
                                    <div class="box-header with-border" style="background-color:#ECF0F5; text-transform:uppercase;">
                                        <table width="100%" border="0">
                                            <tr>
                                                <td>
                                                    <a onClick="popupCenter('adddesignation<?php echo $extn; ?>', 'myPop1',520,730);" href="javascript:void(0);" style="color:#0000FF; text-transform:uppercase">
                                                        <button type="button" class="btn btn-success btn-sm"><i class='fa fa-plus-square'></i> CREATE<span class="hidem"> NEW <?php echo strtoupper('designation'); ?></span></button>
                                                    </a> 
                                                </td>
                                                <td align="right">
                                                    <input type="text" name="search" id="search" style="width:200px; height:32px;border-radius:0px; border:1px solid #CCC; padding-left:5px;background: #FFF url('images/searchbg.gif') right no-repeat;" placeholder="Search" onKeyDown="if (event.keyCode == 13) { this.form.submit(); return false; }" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"/>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </form>
                                <div style="height:5px;">&nbsp;</div>
                                <div class="row">
                                    <a href="<?php echo $pageurl; ?>">
                                        <div class="col-lg-3 col-xs-6">
                                            <div class="small-box bg-blue-gradient">
                                                <div class="inner">Total <?php echo 'Designation'; ?> : <b style="font-size:15px;">
                                                <?php
                                                $querym = "SELECT COUNT(*) as num FROM `$tbl_name` where is_deleted='Live' ";
    $querymc = mysqli_fetch_array(mysqli_query($con, $querym));
    $totalquery = $querymc['num'];
    echo $totalquery;
    ?></b>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div style='overflow-x: auto;'>
                                            <?php
                                            $search = @$_GET['search'];
    $adjacents = 10;

    $fields = ['is_active', 'is_deleted'];
    $conditions = [];

    foreach ($fields as $field) {
        if (@$_GET[$field] != '') {
            $conditions[] = "$field='$_GET[$field]'";
        }
    }

    $query = "SELECT COUNT(*) as num FROM `$tbl_name` WHERE is_deleted='Live'";
    // $sqlx = "SELECT d.*, s.name,s.designation FROM `$tbl_name` d LEFT JOIN `states` s ON s.stateid = d.id  WHERE s.is_deleted='Live'";
    $sqlx = "SELECT d.*, s.name AS state_name FROM `$tbl_name` d LEFT JOIN `states` s ON d.stateid = s.id WHERE d.is_deleted='Live'";

    if (count($conditions) > 0) {
        $query .= ' and '.implode(' and ', $conditions);
        $sqlx .= ' and '.implode(' and ', $conditions);
    }

    $total_pages = mysqli_fetch_array(mysqli_query($con, $query));
    $total_pages = $total_pages['num'];
    $tnum = $total_pages;

    $targetpage = "$pageurl?";
    $limit = 50;
    $page = @$_GET['page'];
    if ($page == '' || $page == '0' || $page == '1') {
        $in = 0;
        $tnum = $total_pages;
    } else {
        $in = $limit * ($page - 1);
        $tnum = $total_pages - ($limit * ($page - 1));
    }
    if ($page) {
        $start = ($page - 1) * $limit;
    } else {
        $start = 0;
    }

    $sql = $sqlx." ORDER BY d.id ASC LIMIT $start, $limit";
    $result = mysqli_query($con, $sql);

    if ($page == 0 || $page == '') {
        $page = 1;
    }
    $prev = $page - 1;
    $next = $page + 1;
    $lastpage = ceil($total_pages / $limit);
    $lpm1 = $lastpage - 1;

    $pagination = '';
    if ($lastpage > 1) {
        $pagination .= '<div class="pagination">';
        if ($page > 1) {
            $pagination .= "<a href=\"$targetpage&page=$prev\">&laquo;</a>";
        } else {
            $pagination .= '<span class="disabled">&laquo;</span>';
        }

        if ($lastpage < 7 + ($adjacents * 2)) {
            for ($counter = 1; $counter <= $lastpage; ++$counter) {
                if ($counter == $page) {
                    $pagination .= "<span class=\"current\">$counter</span>";
                } else {
                    $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                }
            }
        } elseif ($lastpage > 5 + ($adjacents * 2)) {
            if ($page < 1 + ($adjacents * 2)) {
                for ($counter = 1; $counter < 4 + ($adjacents * 2); ++$counter) {
                    if ($counter == $page) {
                        $pagination .= "<span class=\"current\">$counter</span>";
                    } else {
                        $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                    }
                }
                $pagination .= '...';
                $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
                $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
            } elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
                $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
                $pagination .= '...';
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; ++$counter) {
                    if ($counter == $page) {
                        $pagination .= "<span class=\"current\">$counter</span>";
                    } else {
                        $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                    }
                }
                $pagination .= '...';
                $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
                $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
            } else {
                $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
                $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
                $pagination .= '...';
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; ++$counter) {
                    if ($counter == $page) {
                        $pagination .= "<span class=\"current\">$counter</span>";
                    } else {
                        $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                    }
                }
            }
        }

        if ($page < $counter - 1) {
            $pagination .= "<a href=\"$targetpage&page=$next\">&raquo;</a>";
        } else {
            $pagination .= '<span class="disabled">&raquo;</span>';
        }
        $pagination .= "</div>\n";
    }
    ?>
                                            <form method="post" action="">
                                                <div class="box-header with-border">
                                                    <table width="100%" border="0" style="border:1px solid #E2E0E0; border-bottom:0px;">
                                                        <tr>
                                                            <td>
                                                                <input type="submit" value="Delete" class="btn btn-danger btn-sm" name="action" id="Delete" title="Delete" onClick="return confirm('Are you sure you want to delete the selected records?');"/>
                                                                <input type="submit" value="ON" class="btn btn-primary btn-sm" name="action" id="ON" title="Activate" onClick="return confirm('Are you sure you want to activate the selected records?');"/>
                                                                <input type="submit" value="OFF" class="btn btn-primary btn-sm" name="action" id="OFF" title="Deactivate" onClick="return confirm('Are you sure you want to deactivate the selected records?');"/>
                                                            </td>
                                                            <td align="right"><?php echo $pagination; ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div style="height:5px;">&nbsp;</div>
                                                <table border="1" width="100%" style="border:1px solid #E2E0E0;" cellpadding="5" cellspacing="0">
                                                    <tr style="background:#EFEFEF; color:#000000;">
                                                        <th width="3%">
                                                            <input name="chkAll" type="checkbox" id="chkAll" onClick="checkAll(this)"/>
                                                        </th>
                                                        <th width="4%">S.No</th>
                                                        <th width="8%">State</th>
                                                        <th width="10%">Name</th>
                                                        <th width="11%">Designation</th>
                                                        <th width="6%">Is Active</th>
                                        
                                                        <th width="8%">Action</th>
                                                    </tr>
                                                    <?php
            $j = 0;
    ++$in;
    while ($row = mysqli_fetch_assoc($result)) {
        $is_active = $row['is_active'];
        if ($is_active == 1) {
            $active = '<span style="color:green;">Active</span>';
        } else {
            $active = '<span style="color:red;">Inactive</span>';
        }
        ++$j;
        --$tnum;
        ?>
                                                    <tr class="tr<?php echo $j % 2; ?>">
                                                        <td align="center">
                                                            <input name="ids[]" type="checkbox" value="<?php echo $row['id']; ?>" class="chk"/>
                                                        </td>
                                                        <td align="center"><?php echo $in; ?></td>
                                                        <td align="center"><?php echo $row['state_name']; ?></td>
                                                        <td align="center"><?php echo $row['name']; ?></td>
                                                        <td align="center"><?php echo $row['designation']; ?></td>
                                                        <td align="center"><?php echo $active; ?></td>
                                                       
                                                        <td align="center">
    <a onClick="popupCenter('adddesignation?id=<?= $row['id']; ?>', 'myPop1', 520, 600);" href="javascript:void(0);" style="text-decoration:none;color:#00F; cursor:pointer;">
        <img src='images/edit.png' title='Edit'>
    </a>
    <br />
</td>

                                                    </tr>
                                                    <?php ++$in;
    } ?>
                                                </table>
                                                <div style="height:5px;">&nbsp;</div>
                                                <table width="100%" border="0" style="border:1px solid #E2E0E0; border-top:0px;">
                                                    <tr>
                                                        <td align="left">
                                                            <input type="submit" value="Delete" class="btn btn-danger btn-sm" name="action" id="Delete" title="Delete" onClick="return confirm('Are you sure you want to delete the selected records?');"/>
                                                            <input type="submit" value="ON" class="btn btn-primary btn-sm" name="action" id="ON" title="Activate" onClick="return confirm('Are you sure you want to activate the selected records?');"/>
                                                            <input type="submit" value="OFF" class="btn btn-primary btn-sm" name="action" id="OFF" title="Deactivate" onClick="return confirm('Are you sure you want to deactivate the selected records?');"/>
                                                        </td>
                                                        <td align="right"><?php echo $pagination; ?></td>
                                                    </tr>
                                                </table>
                                            </form>
                                            <div style="height:10px;">&nbsp;</div>
                                        </div>
                                    </div>
                                </div>
                                <?php include 'paginationfooter.php'; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include 'footer.php'; ?>
    </div>
</div>
<div id="printable">
    <h1><?php echo $pagename; ?></h1>
    <div style="height:10px;">&nbsp;</div>
    <table width="100%" border="1" cellpadding="5" cellspacing="0" style="border:1px solid #E2E0E0;">
        <tr style="background:#EFEFEF; color:#000000;">
            <th width="3%">S.No</th>
            <th width="8%">State</th>
            <th width="10%">Name</th>
            <th width="11%">Designation</th>
            <th width="6%">Is Active</th>
        </tr>
        <?php
        $result = mysqli_query($con, $sqlx);
    $j = 0;
    $in = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $is_active = $row['is_active'];
        if ($is_active == 1) {
            $active = '<span style="color:green;">Active</span>';
        } else {
            $active = '<span style="color:red;">Inactive</span>';
        }
        ++$j;
        ?>
        <tr class="tr<?php echo $j % 2; ?>">
            <td align="center"><?php echo $in; ?></td>
            <td align="center"><?php echo $row['stateid']; ?></td>
            <td align="center"><?php echo $row['name']; ?></td>
            <td align="center"><?php echo $row['designation']; ?></td>
            <td align="center"><?php echo $active; ?></td>
            
        </tr>
        <?php ++$in;
    } ?>
    </table>
</div>
<?php include 'includes/footer.php'; ?>
</body>
</html>

<?php 
mysqli_close($con);}  ?>