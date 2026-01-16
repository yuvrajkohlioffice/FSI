<?php
include "includes/classes.php";
?>
    <?php
	    $sub_query=mysql_query("select title, package_heading, description, link, extension, image, target  from isfr_data where primeArea = 1 and status='active' and websitetype='hindi' order by sorder, postdate limit 0, 1");
        while( $isfrData = mysql_fetch_array($sub_query))
        {
            $link = "";
			$target  = "";
			
			if($isfrData['extension']!='' && file_exists("../uploads/documents/".$isfrData['extension']))
			{
				$link = "../uploads/documents/".$isfrData['extension'];
				$target  = "_blank";
			}
			else if( $isfrData['link'] != '' )
			{
				$link = $isfrData['link'];
				$target  = $isfrData['target'];						
			}
    ?>
    <section id="great-gardener-team" <?php if( $dataServices['image'] && file_exists( "../uploads/images/banner/".$dataServices['image'])) { ?> style="background: url('../uploads/images/banner/<?php echo $isfrData['image'];?>');" <?php } ?>>
		<div class="container">
			<div class="row">
				<div class="col-md-8 pull-right has-skew">
					<h2 class="home_ifsr_title"><?php echo $isfrData['title'];?></h2>
					<p><?php echo $isfrData['description'];?></p>
					<?php if( $link ) { ?>
                    <a class="contact-button" href="<?php echo $link;?>" target="<?php echo $target;?>">
                    	<div class="contact-us-button">डाउनलोड लिंक </div>
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                    <?php } ?>
				</div>
			</div>
		</div>
	</section>
	<?php
        }
    ?>
	<section id="footer-bg">
		<!-- footer -->
		<footer class="gardener">
			<div class="container">
				<div class="row">
					<!-- .widget -->
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 widget">
						<h3>महत्वपूर्ण लिंक्स</h3>
						<ul class="quick-links">
						    <?php
    						$count=0;						
    						$res_menu = mysql_query("select * from bottom_menu where status='active'  and websitetype='hindi' order by position,name limit 0,5");
    						$total_fields = mysql_num_rows($res_menu);
    						while($row_heading= mysql_fetch_array($res_menu))
    						{
    							$count++;
    							$target="_self";
    							$link="details.php?pgID=bo_".$row_heading['sno'];
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
    						?>
                            <li><a href="<?php echo $link;?>" target="<?php echo $target;?>" class="white"><?php echo htmlentities($row_heading['name']);?></a></li>
                            <?php } ?>
						</ul>
					</div> <!-- /.widget -->
					<!-- .widget -->
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 widget">
						<h3>&nbsp;</h3>
						<ul class="quick-links">
						<?php
    						$count=0;						
    						$res_menu = mysql_query("select * from bottom_menu where status='active'  and websitetype='hindi' order by position,name limit 5,5");
    						$total_fields = mysql_num_rows($res_menu);
    						while($row_heading= mysql_fetch_array($res_menu))
    						{
    							$count++;
    							$target="_self";
    							$link="details.php?pgID=bo_".$row_heading['sno'];
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
    						?>
                            <li><a href="<?php echo $link;?>" target="<?php echo $target;?>" class="white"><?php echo htmlentities($row_heading['name']);?></a></li>
                            <?php } ?>
						</ul>
					</div> <!-- /.widget -->
					<!-- .widget -->
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 widget">
						<h3>संपर्क करें </h3>
						<ul class="contact-info">
							<li>
								<div class="icon-box">
									<i class="fa fa-map-marker"></i>
								</div>
								<div class="content">
									<p><?php echo html_entity_decode($common->default_address);?></p>
								</div>
							</li>
							<li>
								<div class="icon-box">
									<i class="fa fa-phone"></i>
								</div>
								<div class="content phone">
									<p><?php echo htmlentities($common->default_phone);?></p>
								</div>
							</li>
							<li>
								<div class="icon-box">
									<i class="fa fa-envelope-o"></i>
								</div>
								<div class="content">
									<p><?php echo htmlentities($common->default_email);?></p>
								</div>
							</li>
						</ul>
					</div> <!-- /.widget -->
					<!-- .widget -->
					 <!-- /.widget -->
				</div>
			</div>
		</footer> <!-- /footer -->
		
		<!-- #bottom-bar -->
		<section id="bottom-bar" class="gardener">
			<div class="container">
				<div class="row">
					<!-- .copyright -->
					<div class="copyright pull-left">
						<ul class="social">
							<?php if( $common->facebook ) { ?><li class=""><a href="<?php echo $common->facebook;?>" target="_blank"><i class="fa fa-facebook"></i></a></li><?php } ?>
							<?php if( $common->twitter ) { ?><li class=""><a href="<?php echo $common->twitter;?>" target="_blank"><i class="fa fa-twitter"></i></a></li><?php } ?>
							<?php if( $common->youtube ) { ?><li class=""><a href="<?php echo $common->youtube;?>" target="_blank"><i class="fa fa-youtube"></i></a></li><?php } ?>
						    <?php if( $common->linkedin ) { ?><li class=""><a href="<?php echo $common->linkedin;?>" target="_blank"><img src="../images/qoo.png"></a></li><?php } ?>
							<li class=""><a href="https://www.instagram.com/bhartiyavansarvekshan/" target="_blank"><i class="fa fa-instagram"></i></a></li>

						</ul>
						<p>द्वारा विकसित: : <a href="http://webline.in/" target="_blank">वेबलाइन</a></p>
					</div> <!-- /.copyright -->
					<!-- .credit -->
					<div class="credit pull-right">
						<p><?php echo htmlentities($common->footer_note);?> </p>
					</div> <!-- /.credit -->
				</div>
			</div> 
		</section><!-- /#bottom-bar -->
    </section>