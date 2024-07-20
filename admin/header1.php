 <header class="main-header">	
        <!-- Logo -->
       <a href="/" class="logo" target="_blank"><div style="height:5px;"></div><?php echo $institute ?></a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
		  
            <ul class="nav navbar-nav">
			 <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-fw fa-cogs"></i>
                  <span>&nbsp;</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header"><b>Manage Sanatan World</b></li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
					  <li><a href="padvi.php"><i class="fa fa-fw fa-globe text-aqua"></i> Padvi</a>
          </li>				  
          <li><a href="akhada.php"><i class="fa fa-fw fa-globe text-aqua"></i> Akhada</a>
          </li>	
          <li><a href="sampradya.php"><i class="fa fa-fw fa-globe text-aqua"></i> Sampradya</a>
          </li>	
          <li><a href="madhi.php"><i class="fa fa-fw fa-globe text-aqua"></i> Madhi</a>
          </li>	
          <li><a href="education.php"><i class="fa fa-fw fa-globe text-aqua"></i> Education</a>
          </li>	
          <li><a href="gotra.php"><i class="fa fa-fw fa-globe text-aqua"></i> Gotra</a>
          </li>	
          <li><a href="facility.php"><i class="fa fa-fw fa-globe text-aqua"></i> Facility</a>
          </li>	
          <li><a href="countries.php"><i class="fa fa-fw fa-globe text-aqua"></i> Countries</a>
          </li>	
          <li><a href="states.php"><i class="fa fa-fw fa-globe text-aqua"></i> States</a>
          </li>	
          <li><a href="features.php"><i class="fa fa-fw fa-globe text-aqua"></i> Features</a>
          </li>	
          <li><a href="banners.php"><i class="fa fa-fw fa-globe text-aqua"></i> Banners</a>
          </li>	
          <li><a href="news.php"><i class="fa fa-fw fa-globe text-aqua"></i> News</a>
          </li>	
                    </ul>
                  </li>
                  <li class="footer"><a href="org.php">View all</a></li>
                </ul>
              </li>
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <span class="">Welcome <?php echo $username ?>!</span>
                </a>
                
              </li>
		<?php if(isset($_COOKIE['sadminid'])){?><li><a href="forceverify?id=<?php echo $_COOKIE['sadminid'] ?>"><img src="images/vendor-admin.png" height="20" title="Super Admin Panel" /></a></li><?php } ?>
            </ul>
          </div>
        </nav>
      </header>  