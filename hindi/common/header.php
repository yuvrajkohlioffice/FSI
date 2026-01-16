<?php
include "includes/classes.php";
?>
<style>
.social li{
	display:inline-block !important;
}
</style>
<div class="mainmenu-gradient-bg">
    <div class="container">
        <div class="col-lg-6">
            <a href="screen-reader-access" class="tt1">स्क्रीन रीडर एक्सेस</a> |
            <a href="#maincontent" class="tt1">मुख्य विषयवस्तु में जाएं </a> |
            <a href="#navigation" class="tt1">नेविगेशन पर जाएं</a>
        </div>        
		<div class="col-lg-6 text-right">
		  <ul class="social">
				<?php if( $common->facebook ) { ?><li class=""><a href="<?php echo $common->facebook;?>" target="_blank"><i class="fa fa-facebook"></i></a></li><?php } ?>
				<?php if( $common->twitter ) { ?><li class=""><a href="<?php echo $common->twitter;?>" target="_blank"><i class="fa fa-twitter"></i></a></li><?php } ?>
				<?php if( $common->youtube ) { ?><li class=""><a href="<?php echo $common->youtube;?>" target="_blank"><i class="fa fa-youtube"></i></a></li><?php } ?>
				<?php if( $common->linkedin ) { ?><li class=""><a href="<?php echo $common->linkedin;?>" target="_blank"><img src="../images/qoo.png"></a></li><?php } ?>
				<li class=""><a href="https://www.instagram.com/bhartiyavansarvekshan/" target="_blank"><i class="fa fa-instagram"></i></a></li>
				<li>|</li>
				<li><a href="https://fsi.nic.in/indexx.php" class="tt1" target="_blank">English</a></li>
		  </ul>
		</div>
    </div>
</div>
	<!-- start header -->
	<header>
		<div class="container">
			<div class="logo pull-left">
				<a href="index.php">
					<img src="../img/resources/logo-hindi.png" alt="FSI"/>
				</a>
			</div>
			<div class="top-info pull-right">
				<div class="info-box">
					<div class="search-wrapper pull-right ct1">
						<ul>
							<li>						
								<ul class="search-box">
									<li>
										<form action="result.php" method="get">
											<input type="text" name="q" placeholder="खोजें ">
											<button type="submit"><i class="icon icon-Search"></i></button>
										</form>
									</li>
								</ul>
							</li>							
						</ul>
					</div>
					<div class="clearfix"></div>
					<div class="text-box">
						<p><a href="contact-us"><span class="highlighted"><i class="fa fa-phone"></i> संपर्क करें</span></a></p>						
					</div>                    
                    <div class="text-box">
						<p><span class="highlighted"><i class="fa fa-envelope"></i> <?php $emailValues = explode(",", htmlentities($common->default_email)); echo htmlentities($emailValues[0]);?></span></p>						
					</div>
				</div>			
			
				<div class="info-box">
					
					<div class="text-box">
						<p><span class="highlighted"><img src="../img/gov-logo.jpg"></p>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- end header -->
	<!-- start mainmenu -->
	<nav class="mainmenu-navigation stricky">
		<div class="container mainmenu-gradient-bg">
			<div class="navigation pull-left">
				<div class="nav-header">
					<button><i class="fa fa-bars"></i></button>
				</div>
				<div class="nav-footer"><a name="navigation"></a>
					<ul class="nav hindi_menu">
						<?php
						$count=0;						
						$res_menu = mysql_query("select * from heading where status='active' and home='yes' and (display_area='main' || display_area='topbottom') and websitetype='hindi' order by position,name limit 0,15");
						$total_fields = mysql_num_rows($res_menu);
						while($row_heading= mysql_fetch_array($res_menu))
						{
							$count++;
							$target="_self";
							$link="details.php?pgID=mn_".$row_heading['sno'];
							if($row_heading['otherurl']!="")
							{
								$target=$row_heading['target'];
								$link=$row_heading['otherurl'];
							}
							if( $common->use_friendly_urls && $row_heading['seo_url'] != "" )
							{						
								$target=$row_heading['target'];
								$link=$row_heading['seo_url'];
							}
							
							$active_link = 0;
							
							$res_submenu = mysql_query("select * from sub_heading where status='active' and heading='$row_heading[sno]' and websitetype='hindi' order by position,subhead limit 0,15");	
							$total_sub_fields = mysql_num_rows($res_submenu );
							
							$other_attribute = $class = "";
							$class = "propClone";
							$other_attribute = 'class="inner-link"';
							if( $total_sub_fields > 0 )
							{
								$link = "javascript:void(0)";
								$target = "_self";
								$class ="dropdown";
								$other_attribute = 'class="dropdown-toggle" data-toggle="dropdown"';
							}
						?>
						
						<li class="<?php echo $class;?>">
							<a href="<?php echo htmlentities($link);?>" target="<?php echo $target;?>" <?php echo $other_attribute;?>><?php echo htmlentities($row_heading['name']); ?><?php if( $total_sub_fields > 0 ) { ?><b class="caret"></b><?php } ?></a>
							<?php if( $total_sub_fields > 0 ) { ?>
							<div class="sub-menu">
								<ul>
								  <?php
        							while($row_sub_heading= mysql_fetch_array($res_submenu))
        							{
        								$count1++;
        								$target="_self";
        								$link="details.php?pgID=sb_".$row_sub_heading['sno'];
        								if($row_sub_heading['otherurl']!="")
        								{
        									$target=$row_sub_heading['target'];
        									$link=$row_sub_heading['otherurl'];
        								}
        								if( $common->use_friendly_urls && $row_sub_heading['seo_url'] != "" )
        								{						
        									$target=$row_sub_heading['target'];
        									$link=$row_sub_heading['seo_url'];
        								}
        						    ?>
									<li><a href="<?php echo htmlentities($link);?>" target="<?php echo $target;?>"> <?php echo htmlentities($row_sub_heading['subhead']);?></a></li>
									<?php
        							}
        							?>
								</ul>
							</div>
							<?php } ?>
						</li>
                        <?php
    						}
    					?>
                    </ul>
				</div>
			</div>			
		</div>
	</nav>
