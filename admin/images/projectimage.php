<?php include 'check.php'; $tbl_name=$_GET['table']; $column=$_GET['column']; $pagename="$_GET[folder] Images"; 
function findGCD($a, $b) {
    while ($b != 0) {
        $temp = $a;
        $a = $b;
        $b = $temp % $b;
    }
    return $a;
}

$numerator = $_GET['w']; $denominator = $_GET['h'];

$gcd = findGCD($numerator, $denominator);
$simplifiedNumerator = $numerator / $gcd;
$simplifiedDenominator = $denominator / $gcd; ?>
<html>
 <head>
    <meta charset="UTF-8">
     <title> <?php echo $pagename ?></title>
	<?php include 'bootstrap.php' ; ?>
<?php if($_GET['Axy']!=""){?>
<script type="text/javascript">
            window.opener.location.reload(true);
            window.close();
</script>
<?php } ?>
	
  <?php
if($_GET['id']!="") {$result = mysqli_query($con,"SELECT * FROM `$tbl_name` WHERE id='$_GET[id]'"); 
while($row = mysqli_fetch_array($result)) { $imagetype=$column;
$imagetype1 = $row[$imagetype]; } }  ?>
<link rel="stylesheet" href="croper/css/slim.min.css">

  </head>
  <body class="<?php echo $skincolor ?>">
  
  	<div class="box-header with-border" style="background-color: #E6E6E6; font-size:14PX; font-family:Arial, Helvetica, sans-serif; color:#1515FF; font-weight:bold; text-transform:uppercase;"><?php echo $pagename ?> [Size : <?php echo $numerator ?> x <?php echo $denominator ?> px]</div>

	<div align="center">
		<div class="slim" data-ratio="<?php echo $simplifiedNumerator ?>:<?php echo $simplifiedDenominator ?>" data-size="<?php echo $numerator ?>,<?php echo $denominator ?>" data-service="croper/asyncprofile.php?folder=<?php echo $_GET['folder'] ?>&column=<?php echo $_GET['column'] ?>&table=<?php echo $_GET['table'] ?>&id=<?php echo $_GET['id'] ?>">
		<input type="file" /></div><br />
		<b>EXISTING IMAGE</b><br />
		<?php if($imagetype1!=""){?>
		<img src="<?php echo $baseurl ?>/assets/uploads/<?php echo $_GET['folder'] ?>/<?php echo $imagetype1 ?>" style="width:300px;" /><?php } else { ?>No Image Found<?php } ?>
    </div>				 


  <br />
 
  <script src="croper/js/slim.kickstart.min.js"></script>  
  </body>
</html>