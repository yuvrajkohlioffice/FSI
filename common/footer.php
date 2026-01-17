<?php
include "includes/classes.php";
?>
<style>
	#bottom-bar.gardener .social li:hover a {
		color:white
	}
</style>
    <?php
	    $sub_query=mysql_query("select title, package_heading, description, link, extension, image, target  from isfr_data where primeArea = 1 and status='active' order by sorder, postdate limit 0, 1");
        while( $isfrData = mysql_fetch_array($sub_query))
        {
            $link = "";
			$target  = "";
			
			if($isfrData['extension']!='' && file_exists("uploads/documents/".$isfrData['extension']))
			{
				$link = "uploads/documents/".$isfrData['extension'];
				$target  = "_blank";
			}
			else if( $isfrData['link'] != '' )
			{
				$link = $isfrData['link'];
				$target  = $isfrData['target'];						
			}
    ?>
    <section id="great-gardener-team" <?php if( $dataServices['image'] && file_exists( "uploads/images/banner/".$dataServices['image'])) { ?> style="background: url('uploads/images/banner/<?php echo $isfrData['image'];?>');" <?php } ?>>
		<div class="container">
			<div class="row">
				<div class="col-md-8 pull-right has-skew">
					<h2><?php echo $isfrData['title'];?></h2>
					<p><?php echo $isfrData['description'];?></p>
					<?php if( $link ) { ?>
                    <a class="contact-button" href="<?php echo $link;?>" target="<?php echo $target;?>">
                    	<div class="contact-us-button">Download Now</div>
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
						<h3>Important Links</h3>
						<ul class="quick-links">
						    <?php
    						$count=0;						
    						$res_menu = mysql_query("select * from bottom_menu where status='active' and websiteType = 'English' order by position,name limit 0,5");
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
						<h3>Quick Links</h3>
						<ul class="quick-links">
						<?php
    						$count=0;						
    						$res_menu = mysql_query("select * from bottom_menu where status='active' and websiteType = 'English' order by position,name limit 5,5");
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
						<h3>Get in Touch</h3>
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
							<?php if( $common->facebook ) { ?><li class=""><a href="<?php echo $common->facebook;?>" target="_blank" aria-label="facebook"><i class="fa fa-facebook"></i></a></li><?php } ?>
							<?php if( $common->twitter ) { ?><li class=""><a href="<?php echo $common->twitter;?>" target="_blank" aria-label="twitter"><i class="fa fa-twitter"></i></a></li><?php } ?>
							<?php if( $common->youtube ) { ?><li class=""><a href="<?php echo $common->youtube;?>" target="_blank" aria-label="youtube"><i class="fa fa-youtube"></i></a></li><?php } ?>
						    <?php if( $common->linkedin ) { ?><li class=""><a href="<?php echo $common->linkedin;?>" target="_blank" aria-label="qoo"><img src="images/qoo.png" alt="qoo"></a></li><?php } ?>
							<li class=""><a href="https://www.instagram.com/bhartiyavansarvekshan/" target="_blank" aria-label="instagram"><i class="fa fa-instagram"></i></a></li>

						</ul>
						<p>Developed by: <a href="https://digitalprefixmedia.com/" target="_blank" style="color: #fff;">Digital Prefix Media</a></p>
					</div> <!-- /.copyright -->
					<!-- .credit -->
					<div class="credit pull-right">
						<p><?php echo htmlentities($common->footer_note);?> </p>
					</div> <!-- /.credit -->
				</div>
			</div> 
		</section>
			<!-- #bottom-bar -->
		<section id="bottom-bar" class="gardener">
    <div class="container">
        <div class="row">
            <div class="credit" style="text-align: center; width: 100%;">
                
                <p style="margin-top: 5px; font-size: 0.9em;">
                    Last updated at: <?php echo date("d F Y", getlastmod()); ?>
                </p>

            </div> </div>
    </div> 
</section><!-- /#bottom-bar -->
    </section>
