<?php
$pagename=$_SERVER['PHP_SELF'];
$page2=explode('/', $pagename);
$current_page=$page2[count($page2) - 1];
?>
<div class="page-sidebar nav-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->        
			<ul class="page-sidebar-menu">
				<li>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler hidden-phone"></div>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				</li>
				<li>
					<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
					<form class="sidebar-search">
						<div class="input-box">
							<a href="javascript:;" class="remove"></a>
							<input type="text" placeholder="Search..." />
							<input type="button" class="submit" value=" " />
						</div>
					</form>
					<!-- END RESPONSIVE QUICK SEARCH FORM -->
				</li>
				<li class="start <?php if($current_page=='mainmenu.php') { ?> active <?php } ?>">
					<a href="mainmenu.php">
					<i class="icon-home"></i> 
					<span class="title">Dashboard</span>
					<span class="selected"></span>
					</a>
				</li>
				<li <?php if($current_page=="main-menu.php" || $current_page=="bottom-menu.php" || $current_page=="sub-menu.php" || $current_page=="sub-sub-menu.php" || $current_page=="quick-menu.php" || $current_page=="sub-sub-sub-menu.php"  || $current_page=="top-quick-menu.php" )  { ?> class="active" <?php } ?> >
					<a href="javascript:;">
					<i class="icon-cogs"></i> 
					<span class="title">Menu Master's</span>
					<span class="arrow "></span>
					<span class="selected"></span>

					</a>
					<ul class="sub-menu">
						<li <?php if($current_page=="main-menu.php") { ?> class="active" <?php } ?>>
							<a href="main-menu.php">
							<span class="badge badge-info"><?php echo mysql_num_rows(mysql_query("select sno from heading")); ?></span>Manage Main Menu's
							
							</a>
						</li>
						<li <?php if($current_page=="sub-menu.php") { ?> class="active" <?php } ?>>
							<a href="sub-menu.php">
							<span class="badge badge-info"><?php echo mysql_num_rows(mysql_query("select sno from sub_heading")); ?></span>Manage Sub Menu's
							</a>
						</li>
						<li <?php if($current_page=="sub-sub-menu.php") { ?> class="active" <?php } ?>>
							<a href="sub-sub-menu.php">
							<span class="badge badge-info"><?php echo mysql_num_rows(mysql_query("select sno from sub_sub_heading")); ?></span>Manage Sub-Sub Menu's</a>
						</li>						
						<li <?php if($current_page=="bottom-menu.php") { ?> class="active" <?php } ?>>
							<a href="bottom-menu.php">
							<span class="badge badge-info"><?php echo mysql_num_rows(mysql_query("select sno from bottom_menu")); ?></span>Manage Bottom Menu's							
							</a>
						</li>
						<li <?php if($current_page=="quick-menu.php") { ?> class="active" <?php } ?>>
							<a href="quick-menu.php">
							<span class="badge badge-info"><?php echo mysql_num_rows(mysql_query("select sno from quick_menu")); ?></span>Manage Quick Navigation</a>
						</li>
						<li <?php if($current_page=="top-quick-menu.php") { ?> class="active" <?php } ?>>
							<a href="top-quick-menu.php">
							<span class="badge badge-info"><?php echo mysql_num_rows(mysql_query("select sno from top_quick_menu")); ?></span>Manage Quick Menu's		
							</a>
						</li>							
					</ul>
				</li>						
				<li <?php if($current_page=="upload-map.php" || $current_page=="pages.php" || $current_page=="news-desk.php" || $current_page=="event-desk.php"  || $current_page=="page-sliders.php"  || $current_page=="tab.php" )  { ?> class="active" <?php } ?>>
					<a href="javascript:;">
					<i class="icon-briefcase"></i> 
					<span class="title">Pages</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<li <?php if($current_page=="pages.php")  { ?> class="active" <?php } ?>>
							<a href="pages.php">
							<i class="icon-time"></i>
							<span class="badge badge-info"><?php echo mysql_num_rows(mysql_query("select sno from link_page")); ?></span>Website Pages</a>
						</li>						
						<li <?php if($current_page=="news-desk.php")  { ?> class="active" <?php } ?>>
							<a href="news-desk.php">
							<i class="icon-comments"></i>
							<span class="badge badge-info"><?php echo mysql_num_rows(mysql_query("select ser from news")); ?></span>Latest News</a>
						</li>	
						<li <?php if($current_page=="page-sliders.php")  { ?> class="active" <?php } ?> >
							<a href="page-sliders.php">
							<i class="icon-time"></i>
							Manage Slide Show</a>
						</li>
						<li <?php if($current_page=="tab.php")  { ?> class="active" <?php } ?> >
							<a href="tab.php">
							<i class="icon-time"></i>
							Manage Tab Content</a>
						</li>
						<li <?php if($current_page=="isfr.php")  { ?> class="active" <?php } ?>>
							<a href="isfr.php">
							<i class="icon-time"></i>
							<span class="badge badge-info"><?php echo mysql_num_rows(mysql_query("select ser from isfr_data")); ?></span>ISFR</a>
						</li>
						<li <?php if($current_page=="services.php")  { ?> class="active" <?php } ?>>
							<a href="services.php">
							<i class="icon-time"></i>
							<span class="badge badge-info"><?php echo mysql_num_rows(mysql_query("select ser from services")); ?></span>Services</a>
						</li>
					</ul>
				</li>
				<li <?php if($current_page=="welcome.php" || $current_page=="welcome_2.php" || $current_page=="welcome_hindi.php" || $current_page=="welcome_hindi_2.php" || $current_page=="sliders.php" || $current_page=="manage_projects.php" || $current_page=="manage-index-banner.php" )  { ?> class="active" <?php } ?>>
					<a href="javascript:;">
					<i class="icon-briefcase"></i> 
					<span class="title">Home Page Content</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<li <?php if($current_page=="welcome.php")  { ?> class="active" <?php } ?> >
							<a href="welcome.php">
							<i class="icon-time"></i>
							Welcome Message</a>
						</li>
						<li <?php if($current_page=="welcome_2.php")  { ?> class="active" <?php } ?> >
							<a href="welcome_2.php">
							<i class="icon-cogs"></i>
							DG's Message</a>
						</li>
						<li <?php if($current_page=="welcome_hindi.php")  { ?> class="active" <?php } ?> >
							<a href="welcome_hindi.php">
							<i class="icon-time"></i>
							Welcome Message (Hindi)</a>
						</li>
						<li <?php if($current_page=="welcome_hindi_2.php")  { ?> class="active" <?php } ?> >
							<a href="welcome_hindi_2.php">
							<i class="icon-cogs"></i>
							DG's Message (Hindi)</a>
						</li>						
						<li <?php if($current_page=="sliders.php")  { ?> class="active" <?php } ?> >
							<a href="sliders.php">
							<i class="icon-time"></i>
							Manage Slide Show</a>
						</li>
						<li <?php if($current_page=="manage_projects.php")  { ?> class="active" <?php } ?> >
							<a href="manage_projects.php">
							<i class="icon-time"></i>
							Manage Projects</a>
						</li>
						<li <?php if($current_page=="manage-index-banner.php")  { ?> class="active" <?php } ?> >
							<a href="manage-index-banner.php">
							<i class="icon-time"></i>
							Manage Banner</a>
						</li>	
											
					</ul>
				</li>
				<li <?php if($current_page=="tenders.php" || $current_page=="tenders-news-desk.php" || $current_page=="tender-document.php" )  { ?> class="active" <?php } ?>>
					<a href="javascript:;">
					<i class="icon-briefcase"></i> 
					<span class="title">Tenders</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<li <?php if($current_page=="tenders.php")  { ?> class="active" <?php } ?>>
							<a href="tenders.php">
							<i class="icon-time"></i>
							<span class="badge badge-info"><?php echo mysql_num_rows(mysql_query("select ser from tenders")); ?></span>Manage Tenders</a>
						</li>						
						<li <?php if($current_page=="tenders-news-desk.php")  { ?> class="active" <?php } ?>>
							<a href="tenders-news-desk.php">
							<i class="icon-comments"></i>
							<span class="badge badge-info"><?php echo mysql_num_rows(mysql_query("select ser from tender_news")); ?></span>Tender Notice</a>
						</li>	
						<li <?php if($current_page=="tender-document.php")  { ?> class="active" <?php } ?> >
							<a href="tender-document.php">
							<i class="icon-time"></i><span class="badge badge-info"><?php echo mysql_num_rows(mysql_query("select sno from tender_document")); ?></span>
							 Tender Documents</a>
						</li>			
					</ul>
				</li>
				<li <?php if($current_page=="recruitments.php" || $current_page=="recruitment-news-desk.php" || $current_page=="recruitment-document.php" )  { ?> class="active" <?php } ?>>
					<a href="javascript:;">
					<i class="icon-briefcase"></i> 
					<span class="title">Recruitments</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<li <?php if($current_page=="recruitments.php")  { ?> class="active" <?php } ?>>
							<a href="recruitments.php">
							<i class="icon-time"></i>
							<span class="badge badge-info"><?php echo mysql_num_rows(mysql_query("select ser from recruitments")); ?></span>Recruitments</a>
						</li>						
						<li <?php if($current_page=="recruitment-news-desk.php")  { ?> class="active" <?php } ?>>
							<a href="recruitment-news-desk.php">
							<i class="icon-comments"></i>
							<span class="badge badge-info"><?php echo mysql_num_rows(mysql_query("select ser from recruitment_news")); ?></span>Recruitment Notice</a>
						</li>	
						<li <?php if($current_page=="recruitment-document.php")  { ?> class="active" <?php } ?> >
							<a href="recruitment-document.php">
							<i class="icon-time"></i><span class="badge badge-info"><?php echo mysql_num_rows(mysql_query("select sno from recruitment_document")); ?></span>
							 Documents</a>
						</li>			
					</ul>
				</li>
				<li <?php if($current_page=="settings.php" || $current_page=="upload-files.php" || $current_page=="photo-cate.php" || $current_page=="maintenance-mode.php" || $current_page=="photo-gallery.php" || $current_page=="ip_address.php" || $current_page=="circulars.php")  { ?> class="active" <?php } ?>>
					<a href="javascript:;">
					<i class="icon-gift"></i> 
					<span class="title">Extra</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<li <?php if($current_page=="circulars.php")  { ?> class="active" <?php } ?>>
							<a href="circulars.php">
							Upload Circulars</a>
						</li>						
						<li <?php if($current_page=="upload-files.php")  { ?> class="active" <?php } ?>>
							<a href="upload-files.php">
							<span class="badge badge-info"><?php echo mysql_num_rows(mysql_query("select sno from uploads")); ?></span>Upload Files</a>
						</li>
						<li <?php if($current_page=="settings.php")  { ?> class="active" <?php } ?>>
							<a href="settings.php">
							Theme Settings</a>
						</li>
						<!--
li <?php if($current_page=="maintenance-mode.php")  { ?> class="active" <?php } ?>>
							<a href="maintenance-mode.php">
							Maintenance Mode</a>  
						</li>
						<li <?php if($current_page=="ip_address.php")  { ?> class="active" <?php } ?>>
							<a href="ip_address.php">
							<span class="badge badge-info"><?php echo mysql_num_rows(mysql_query("select sno from ip_address")); ?></span>IP Address Whitelist</a>
						</li-->	
						<li <?php if($current_page=="photo-cate.php")  { ?> class="active" <?php } ?>>
							<a href="photo-cate.php">
							<span class="badge badge-info"><?php echo mysql_num_rows(mysql_query("select parentid from photo_cate")); ?></span>Photo Category</a>
						</li>	
						<li <?php if($current_page=="photo-gallery.php")  { ?> class="active" <?php } ?>>
							<a href="photo-gallery.php">
							<span class="badge badge-info"><?php echo mysql_num_rows(mysql_query("select parentid from photo_subcate")); ?></span>Manage Photo's</a>
						</li>
						<!--li <?php if($current_page=="audit-trail.php")  { ?> class="active" <?php } ?>>
							<a href="audit-trail.php">
							Audit Trail</a>
						</li-->	
					</ul>
				</li>	
				<li class="last ">
					<a href="logout.php">
					<i class="icon-bar-chart"></i> 
					<span class="title">Logout</span>
					</a>
				</li>
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
