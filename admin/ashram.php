<?php include 'check.php'; $pageurl="ashram"; $tbl_name="entity"; $mintablewidth="950px";  $utype="Ashram"; $pagename="$utype Details";

if (isset($_POST['action']) && $_POST['action'] =="Delete") {
	for ($i=0; $i < count($_POST['ids']);$i++) {
  	$studentchapter1 =$_POST['ids'][$i].", ".$studentchapter1;  }
	$ids = substr($studentchapter1, 0, -2);
$companyasend = str_replace(", ","' or id = '", $ids);
	
$sql="UPDATE `$tbl_name` SET is_deleted='Deleted' WHERE id='$companyasend'"; 
if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error()); }  mysqli_close($con);
echo"<META HTTP-EQUIV='REFRESH' CONTENT='0; URL=$pageurl?page=$_GET[page]&message=$pagename deletd..'>";  exit(0);


} elseif (isset($_POST['action']) && $_POST['action'] =="ON") {
   	for ($i=0; $i < count($_POST['ids']);$i++) {
  	$studentchapter1 =$_POST['ids'][$i].", ".$studentchapter1;   }
	$ids = substr($studentchapter1, 0, -2);

$companyasend = str_replace(", ","' or id = '", $ids);
$sql="UPDATE `$tbl_name` SET is_active ='1' WHERE id='$companyasend'";
if (!mysqli_query($con,$sql)) {die('Error: ' . mysqli_error()); }  mysqli_close($con);
echo"<META HTTP-EQUIV='REFRESH' CONTENT='0; URL=$pageurl?page=$_GET[page]&message=$pagename updated..'>";  exit(0);
	   
} elseif (isset($_POST['action']) && $_POST['action'] =="OFF") {
   	for ($i=0; $i < count($_POST['ids']);$i++) {
  	$studentchapter1 =$_POST['ids'][$i].", ".$studentchapter1;   }
	
	$ids = substr($studentchapter1, 0, -2);

$companyasend = str_replace(", ","' or id = '", $ids);
$sql="UPDATE `$tbl_name` SET is_active ='0' WHERE id='$companyasend'";
if (!mysqli_query($con,$sql)) {die('Error: ' . mysqli_error()); }  mysqli_close($con);
echo"<META HTTP-EQUIV='REFRESH' CONTENT='0; URL=$pageurl?page=$_GET[page]&message=$pagename updated..'>";  exit(0);

} else { ?>
	  
 <!DOCTYPE html>
<html>
  <head>  
    <meta charset="UTF-8">
	<title><?php echo $pagename ?></title>
		<?php include 'bootstrap.php' ; ?>

<style type="text/css">
 #printable { display: none; }
 @media print {
 #non-printable { display: none; }
 #printable { display: block; }  }
</style>
<style type="text/css">.mywidth1{width:100%; font-size:14px;}  @media (max-width: 799px) {.hidem{ display: none; visibility:hidden; } .mywidth1{width:600px;} } 
 .boxw {width:200px;} 
 @media (max-width: 480px) { .boxw{ width:200px; } } 
 </style>	
</head>
  <body class="<?php echo $skincolor ?>">
  <div id="non-printable">
    <div class="wrapper">
	<?php include 'header1.php'; ?> 
	<?php include 'leftmenu.php'; ?>     
     
      <div class="content-wrapper">
		 <section class="content-header">          
          <ol class="breadcrumb">
            <li style="text-transform:uppercase;color:#EC0000;"><i class="fa fa-list"></i> <?php echo $institute ?></a></li>
			<li class="active"><a href="<?php echo $pageurl ?>" style="color:#0000FF;"><?php echo $pagename ?></a></li>
          </ol>
        </section><div class="hidem"><br/></div>

	<section class="content">
          <div class='row'>
            <div class='col-xs-12'>
              <div class="nav-tabs-custom">
              	<div class="tab-content">
				
				<?php if (@$_GET['message']!=""){?><div style="height:4px;">&nbsp;</div>
<div style="height:40px; background:#FFDDCC; color:#000000; border:1px solid #FF5C0F; font-size:14px; padding-top:7px; padding-left:10px;">
<b style="color:#BB0000;"><i class="icon fa fa-warning"></i> ALERT :</b> <?php echo $_GET['message'] ?>.. </div>
<div style="height:4px;">&nbsp;</div>
   <?php } ?>	
				<form name="find" action="" method="get">
<div class="box-header with-border" style="background-color:#ECF0F5; text-transform:uppercase;">
<table width="100%" border="0">
  <tr>
    <td><a onClick="popupCenter('addashram<?php echo $extn ?>', 'myPop1',520,730);" href="javascript:void(0);" style="color:#0000FF; text-transform:uppercase"><button type="button" class="btn btn-success btn-sm"><i class='fa fa-plus-square'></i> CREATE<span class="hidem"> NEW <?php echo strtoupper($utype) ?></span></button></a> </td>
   
   
  <td align="right"><input type="text" name="search" id="search" style="width:200px; height:32px;border-radius:0px; border:1px solid #CCC; padding-left:5px;background: #FFF url('images/searchbg.gif') right no-repeat;" placeholder="Search" onKeyDown="if (event.keyCode == 13) { this.form.submit(); return false; }" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
 /></td>
   
  </tr>
</table>
</div></form>

<div style="height:5px;">&nbsp;</div>
<div class="row">
<a href="<?php echo $pageurl ?>">
<div class="col-lg-3 col-xs-6">
<!-- small box -->
<div class="small-box bg-blue-gradient"><div class="inner">Total <?php echo $utype ?> : <b style="font-size:15px;">
<?php $querym = "SELECT COUNT(*) as num FROM `$tbl_name` where is_deleted='Live'"; $querymc = mysqli_fetch_array(mysqli_query($con,$querym)); $totalquery= $querymc['num']; echo $totalquery ?></b></div>
</div></div><!-- ./col --></a>   
</div>	
<div class="row">
<div class="col-md-12">
<div style='overflow-x: auto;'>
		 <?php 
	 	$search = @$_GET['search']; 
	// How many adjacent pages should be shown on each side?
	$adjacents =10;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/

	// define the list of fields
    $fields = array('is_active', 'is_deleted');
    $conditions = array();

    // loop through the defined fields
    foreach($fields as $field){
        // if the field is set and not empty
        if(@$_GET[$field]!="") {
            // create a new condition while escaping the value inputed by the user (SQL Injection)
            $conditions[] = "$field='$_GET[$field]'";  // lhs side is column name of table while right side is get value from form..
			 //"find_in_set(`$field`,'".mysqli_real_escape_string($_GET[$field])."') > 0" 
        }
}

    // builds the query

	$query = "SELECT COUNT(*) as num FROM `$tbl_name` WHERE is_deleted='Live'";	
    $sqlx = "SELECT * FROM `$tbl_name` WHERE is_deleted='Live'"; 
    // if there are conditions defined
    if(count($conditions) > 0) {
        // append the conditions
        $query .= " and ". implode (' and ', $conditions); // you can change to 'OR', but I suggest to apply the filters cumulative
		$sqlx .= " and ". implode (' and ', $conditions); // you can change to 'OR', but I suggest to apply the filters cumulative
    }
	
	$total_pages = mysqli_fetch_array(mysqli_query($con,$query));
	$total_pages = $total_pages['num'];
    $tnum = $total_pages;

/*	Setup vars for query. */
    $targetpage = "$pageurl?"; 	//your file name  (the name of this file)	
	$limit = 50; 								//how many items to show per page
	$page = @$_GET['page']; 
	if ($page=="" || $page=="0" || $page=="1") {
	$in=0; $tnum = $total_pages;} else {$in=$limit*($page-1); $tnum = $total_pages-($limit*($page-1));}
	if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0

	/* Get data. */
    $sql=$sqlx." ORDER BY id ASC LIMIT $start, $limit"; 		
    $result = mysqli_query($con,$sql);									//if no page var is given, set start to 0

	/* Setup page vars for display. */
	if ($page == 0 || $page=="") $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit); //lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$pagination = ""; 
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		//previous button
		if ($page > 1) 
			$pagination.= "<a href=\"$targetpage&page=$prev\">&laquo;</a>";
		else
			$pagination.= "<span class=\"disabled\">&laquo;</span>";	

		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
			}
		}
		else if($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"$targetpage&page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage&page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a href=\"$targetpage&page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage&page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
				}
			}
		}

		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a href=\"$targetpage&page=$next\">&raquo;</font></a>";
		else
			$pagination.= "<span class=\"disabled\">&raquo;</span>";
		$pagination.= "</div>\n";	
	}
?>			 
	
	<?php if ($total_pages>="1"){?> 
		<form name="form2" id="frmCompare" class="frmCompare" action="<?php echo $pageurl ?>?page=<?php echo $page ?>" method="post"> 
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:11px; font-family:Verdana, Geneva, sans-serif; min-width:<?php echo $mintablewidth ?>;" align="center">
    <tr height="35">
	 	  <td width="125" align="right" style="font-size:11px; font-family:Helvetica, sans-serif; color:#666666; padding-right:10px;"><?php echo "Record = ".@$total_pages; ?></td>
		  
	  <td><div class="nextpage"><?=$pagination?></div></td>
     </tr>
</table>         
    





<?php
/////////// Now let us print the table headers ////////////////
echo "<TABLE width='100%' border=1 cellpadding=1 cellspacing=1 bgcolor='#CCC' align='center' id='tblData' style='min-width:$mintablewidth; border:1px solid #CCC; border-collapse:collapse;'>
<tr height='33' align='center' class='theader' bgcolor='#CCC' style='font-weight:bold;'>";
// echo "<td width='60'><input type='checkbox' id='selectall' title='Select All' style='cursor:pointer;'/></td>";
echo "<td width='60'>SN</td>";
echo "<td style='padding-left:10px; '>Image</td>";

echo "<td align='left' style='padding-left:10px; '>Temple/Ashram Name</td>";
echo "<td align='left' style='padding-left:10px; '>City</td>";
echo "<td align='left' style='padding-left:10px; '>State</td>";

echo "<td style='padding-left:10px;'>Pin Code</td>";
echo "<td style='padding-left:10px; width: 175px;'>More Details</td>";

echo "</tr>";

 while($row = mysqli_fetch_array($result)) {$rdx=date("d/m/Y", strtotime($row['schedule_date_time'])); 
 			
$in=$in+1;	
if($bgcolor=='#F8F8FF'){$bgcolor='#ffffff';} else{$bgcolor='#F8F8FF';} 
echo "<tr bgcolor = '$bgcolor' class='tcontent' align='center' height='32' style='padding:10px;' >";
// echo "<td <div style='height:6px;' width: 20px;'valign='top'></div><input type='checkbox' class='td' name =ids[] value='$row[id]' style='cursor:pointer;'</td>";
echo "<td valign='top' style='padding:5px;'><b>$in</b></td>";
echo "<td style='padding:5px;  width:157px;'>";?><a onClick="popupCenter('projectimage.php?folder=entity&column=entity_images&table=<?php echo $tbl_name ?>&w=500&h=500&id=<?php echo $row['id'] ?>', 'myPop1',450,500);" href="javascript:void(0);" style="text-decoration:none;color:#00F; cursor:pointer;"><img src="<?php echo $baseurl ?>/storageassets/entity/<?php echo $row['entity_images'] ?>" width="80" /></a><?php echo "</td>";

echo "<td align='left' style='padding:5px;line-height:20px;' valign='top'><b>$row[entity_name]</b>"; ?> <?php echo "</td>";

echo "</td>";
echo "<td align='left' style='padding:5px;line-height:20px;' valign='top'>$row[city]</td>";
echo "<td align='left' style='padding:5px;line-height:20px;' valign='top'>$row[state]</td>";

echo "<td style='padding:5px;line-height:20px;' valign='top'>$row[zip]</td>";
echo "</td>";
echo "<td style='padding:5px;line-height:20px;width:230px;' valign='top'>";
echo "<a onClick=\"popupCenter('addashram?id={$row['id']}', 'myPop1',520,730);\" href=\"javascript:void(0);\" style=\"text-decoration:none;color:#00F; cursor:pointer;\">View more</a>";
echo "<a onClick=\"popupCenter('addashram?id={$row['id']}', 'myPop1',520,730);\" href=\"javascript:void(0);\" style=\"text-decoration:none;color:#00F; cursor:pointer;\"><img src='images/edit.png' title='Edit'></a>";
echo "</td>";


echo "</tr>";
$tnum=$tnum-1; 	 
}
echo "</table>";  mysqli_close($con);
?>
</form>
 <script type='text/javascript'>//<![CDATA[ 
var selected = $('#frmCompare :checkbox:checked').length;
function verifCompare() {
var agree=confirm("Are you sure to take the action...");	
	if (agree)
	return true ; else	
	return false ;  }

$(document).ready(function () {
$('#frmCompare :checkbox').change(function(){
  //update selected variable
  selected = $('#frmCompare :checkbox:checked').length

  if (selected >= 1) {
	  $('div#btnCompare').show(); }   else {
        $('div#btnCompare').hide();  }
});
});
</script> 
<br /><br />
 <?php } else { ?>
 <div align="center" class="nodata" style="padding-top:100px; padding-bottom:50px;"><img src="images/nodata.gif" /></div>
 <?php } ?>  
 		 
</div></div></div>				 
				 
				 
				
              </div> <!-- /.tab-content -->
              </div><!-- /.nav-tabs-custom -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      
    <?php include 'footer.php'; ?>   
    </div><!-- ./wrapper -->
	</div>




	
	
	
<?php include 'plugin.php' ; ?>
	
	<script type="text/javascript">
$(document).ready(function()
{
$('#search').keyup(function()
{
searchdiv($(this).val());
});
});
function searchdiv(inputVal)
{
var table = $('#tblData');
table.find('tr').each(function(index, row)
{
var allCells = $(row).find('td');
if(allCells.length > 0)
{
var found = false;
allCells.each(function(index, td)
{
var regExp = new RegExp(inputVal, 'i');
if(regExp.test($(td).text()))
{
found = true;
return false;
}
});
if(found == true)$(row).show();else $(row).hide();
}
});
}
</script>	
  </body>
</html>
mysqli_close($con);
<?php 
mysqli_close($con);}  ?>