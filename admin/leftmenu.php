  <?php include 'config7.php' ;  $break_d1 = explode('?',$_SERVER['REQUEST_URI']);  $url = $break_d1[0]; $url2 = isset($break_d1[1]) ? $break_d1[1] : null; ?> 		
   
 <aside class="main-sidebar">
        <section class="sidebar">
		<div class="user-panel">
            <div class="pull-left image">              
			  <img src="images/user/<?php echo $pic ?>" width="75" height="75" class="img-circle" />
            </div>
            <div class="pull-left info">
              <p><?php echo $username ?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> <?php echo $type ?> Account</a>
            </div>
          </div>
		  <ul class="sidebar-menu">
   
	   	 
 <?php 
 if($url=="/dashboard$extn" || $_SERVER['REQUEST_URI']=="/dashboard$extn" || $url=="/home$extn" || $_SERVER['REQUEST_URI']=="/home$extn"){ ?>
       <li class="active"><?php } else { ?> <li><?php } ?>
       <a href="dashboard<?php echo $extn ?>"><i class="fa fa-dashboard"></i> <span> Dashboard</span></a></li>
       
        <?php if($url=="/donation-details$extn") { ?>
       <li class="active"><?php } else { ?><li><?php } ?>
	   <a href="donation-details<?php echo $extn ?>"><i class="fa fa-money"></i> Donation</a></li>
	   
		   <?php if($url=="/profile$extn" || $_SERVER['REQUEST_URI']=="/profile$extn" || $url=="/editprofile$extn" || $_SERVER['REQUEST_URI']=="/editprofile$extn") { ?>
       <li class="active"><?php } else { ?><li><?php } ?>
	   <a href="notification<?php echo $extn ?>"><i class="fa fa-bell"></i> Notification</a></li>

     <?php if($url=="/profile$extn" || $_SERVER['REQUEST_URI']=="/profile$extn" || $url=="/editprofile$extn" || $_SERVER['REQUEST_URI']=="/editprofile$extn") { ?>
       <li class="active"><?php } else { ?><li><?php } ?>
	   <a href="user_admin<?php echo $extn ?>"><i class="fa fa-user"></i>Manage Admin</a></li>

     <?php if($url=="/profile$extn" || $_SERVER['REQUEST_URI']=="/profile$extn" || $url=="/editprofile$extn" || $_SERVER['REQUEST_URI']=="/editprofile$extn") { ?>
       <li class="active"><?php } else { ?><li><?php } ?>
	   <a href="ashram<?php echo $extn ?>"><i class="fa fa-home"></i> Ashram/Temple</a></li>
     

     <?php if($url=="/profile$extn" || $_SERVER['REQUEST_URI']=="/profile$extn" || $url=="/editprofile$extn" || $_SERVER['REQUEST_URI']=="/editprofile$extn") { ?>
       <li class="active"><?php } else { ?><li><?php } ?>
	   <a href="unknown_user<?php echo $extn ?>"><i class="fa fa-users"></i>Unknown Users</a></li>

     <?php if($url=="/profile$extn" || $_SERVER['REQUEST_URI']=="/profile$extn" || $url=="/editprofile$extn" || $_SERVER['REQUEST_URI']=="/editprofile$extn") { ?>
       <li class="active"><?php } else { ?><li><?php } ?>
	   <a href="sant<?php echo $extn ?>"><i class="fa fa-users"></i> Sant Management</a></li>
     
     <?php if ($url == "/profile$extn" || $_SERVER['REQUEST_URI'] == "/profile$extn" || $url == "/editprofile$extn" || $_SERVER['REQUEST_URI'] == "/editprofile$extn") { ?>
    <li class="active"><?php } else { ?><li><?php } ?>
    <a href="post<?php echo $extn ?>"><i><img src="images/post_icon.png" alt="Icon" height="18" width="18"></i> Post Management</a></li>


     <?php if($url=="/profile$extn" || $_SERVER['REQUEST_URI']=="/profile$extn" || $url=="/editprofile$extn" || $_SERVER['REQUEST_URI']=="/editprofile$extn") { ?>
       <li class="active"><?php } else { ?><li><?php } ?>
	   <a href="volunteer<?php echo $extn ?>"><i class="fa fa-users"></i> Volunteer Details</a></li>

     <?php if($url=="/designation$extn" || $_SERVER['REQUEST_URI']=="/designation$extn") { ?>
       <li class="active"><?php } else { ?><li><?php } ?>
	   <a href="designation<?php echo $extn ?>"><i class="fa fa-users"></i> Designation</a></li>							
	   
     
	   <?php if($url=="/changepassword$extn" || $_SERVER['REQUEST_URI']=="/changepassword$extn") { ?>
       <li class="active"><?php } else { ?><li><?php } ?>
	   <a href="changepassword<?php echo $extn ?>"><i class="fa fa-key"></i> Change Password</a></li>							
	   <li><a href="logout<?php echo $extn ?>"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
		  
          
         </ul>
        </section>
        <!-- /.sidebar -->
      </aside>