<?php include'check.php'; $pageurl="dashboard"; ?>	
<!DOCTYPE html>
<html>
 <head>
     <meta charset="UTF-8">
	 <title><?php echo $institute ?></title>
     <?php include 'bootstrap.php' ; ?>
   
<style type="text/css">
.cbox{width:100px; height:30px; border:1px solid #CCC; padding-left:5px;}
.w3-btn,.w3-button{border:none;display:inline-block;outline:0;padding:8px 16px;vertical-align:middle;overflow:hidden;text-decoration:none;color:inherit;background-color:inherit;text-align:center;cursor:pointer;white-space:nowrap}
.w3-display-topright{position:absolute;right:0;top:0}
.w3-modal-content{margin:auto;background-color:#fff;position:relative;padding:0;outline:0;width:90%; max-width:500px;}
.w3-modal{z-index:999;display:block;padding-top:100px;position:fixed;left:0;top:0;width:100%;height:100%;overflow:auto;background-color:rgb(0,0,0);background-color:rgba(0,0,0,0.4)}
	.ndesign { padding: 40px 70px; background-color:#FFFFFF; border: solid 1px #EEEEEE;}
	.buttonaction:hover{ background:#FF9900;}
	@media (max-width: 480px) {
    .ndesign{ padding:10px; } }
	</style>
  </head>
  <body class="<?php echo $skincolor ?>">
    <div class="wrapper">
		<?php include 'header1.php'; ?>  
		<?php include 'leftmenu.php'; ?>     
     <div class="content-wrapper">
		 <section class="content-header">          
          <ol class="breadcrumb">
             <li style="text-transform:uppercase;color:#EC0000;"><i class="fa fa-list"></i> <?php echo $institute ?></a></li>
			<li class="active"><a href="<?php echo $pageurl ?>" style="color:#0000FF;">DASHBOARD</a></li>
          </ol>
        </section><div class="hidem"><br/></div>
    
	<section class="content">
          <div class='row'>
            <div class='col-xs-12'>
            <div class="nav-tabs-custom">        
		    <div class="tab-content">
			
 
 <div class="row">
  <div class="col-lg-8 col-md-8">
      
<span style="font-size:24px; color:#0073AA;">Hey <b><?php echo ucwords($username) ?>!</b></span><br />
<span style="font-size:16px; color: #000;">Welcome to <b style="color:#CC0000; text-transform:uppercase;"><?php echo $institute ?></b> Its your dashboard for your latest lead operation.</span><br />
<div style="height:20px;">&nbsp;</div>


<!-- <a href="batch-course-report">BATCH WISE COURSE REPORT</a><br />
<a href="course-tracker">COURSE TRACKER</a><br />
<a href="student-attendance-report">STUDENT WISE ATTENDANCE REPORT</a> -->



</div>
		
		
            <div class="col-lg-4 col-md-4" style="vertical-align:top; border-left:1px solid #F9F9F9;">
           </div>
		   
		   
		  
			
			</div>

		    <div style="height:5px;">&nbsp;</div>
			               <!-- Small boxes (Stat box) -->
    
		  
		  <br/>
		  
	  
		  
		           <div class="small-box  bg-green">
              </div><!-- /.nav-tabs-custom -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      
    <?php include 'footer.php'; ?>   
    </div><!-- ./wrapper -->
	
<?php include 'plugin.php' ; ?>

	
  </body>
</html>