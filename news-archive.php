<?php
ob_start();
include_once "includes/classes.php";
$meta_title = $common->site_name;
$meta_desc = "";
$meta_keywords = "";

if(!empty($common->site_title))
	$meta_title = strip_tags($common->site_title);
if(!empty($common->site_key))
	$meta_keywords = strip_tags($common->site_key);
if(!empty($common->site_key))
	$meta_desc = strip_tags($common->site_key);	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $meta_title; ?></title>
	<?php
	if(!empty($meta_desc))
	{
	?>
	<meta name="description" content="<?php echo $meta_desc;?>">
	<?php
	}
	if(!empty($meta_keywords))
	{
	?>
	<meta name="keywords" content="<?php echo $meta_keywords;?>">
	<?php
	}
	?>
	<meta name="author" content="Webline Infosoft Pvt. Ltd., Dehradun">
	<?php
		$common->get_common_head();
	?>
	
	<style>
	.rev_slider_wrapper #slider1 .banner-btn {
		padding:0px !important;
		
	}
	.img-responsive{
	   max-width:100% !important;
	   height:auto !important;
	}
	
	</style>
</head>
<body>
	<?php
		$common->get_header();
	?>

	<section class="rev_slider_wrapper gardener-banner" style="height:400px;">
		<div id="slider1" class="rev_slider"  data-version="5.0" style="height:400px;">
			<ul>
			    <?php
        			$count = 0;
        			$slider = mysql_query( "select name, banner, teaser, details, otherurl,target from sliders where type = '_home' and status = 'active' order by sorder, name"  );
        			while( $row_sliders = mysql_fetch_array( $slider ))
        			{
						$target="";
        				if( !empty($row_sliders['banner']) && file_exists( "uploads/images/slides/".$row_sliders['banner']))
        				{	
        					$style = "";
        					$count++;	
                            $target=$row_sliders['target'];							
        		?>
				<li data-transition="parallaxvertical">
				    <a href="<?php echo $row_sliders['otherurl'];?>" class="banner-btn" target="<?php echo $target; ?>">
					<img src="uploads/images/slides/<?php echo $row_sliders[banner];?>"  alt="" width="1920" height="575" data-bgposition="top center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="1" class="img-responsive" style="width:100%;">
					
					<div class="tp-caption sfb tp-resizeme" 
				        data-x="left" data-hoffset="0" 
				        data-y="top" data-voffset="455" 
				        data-whitespace="nowrap"
				        data-transform_idle="o:1;" 
				        data-transform_in="o:0" 
				        data-transform_out="o:0" 
				        data-start="2000">
						</div>
					</a>
				</li>
				<?php
        		}
        		}
        		?>
			</ul>
		</div>
	</section>

	<!-- #promotional-text -->
	<section id="promotional-text" class="gardener">
		<div class="container-fluid">
			<div class="row">				
				<div class="col-lg-3 col-md-12">    
					<a class="contact-button" href=""><div class="contact-us-button">Important Links</div>
					<i class="fa fa-arrow-circle-right"></i></a>
				</div>
				<div class="col-lg-9 col-md-12 pt">
					<?php
						$count=0;						
						$res_menu = mysql_query("select * from top_quick_menu where status='active' order by position,name limit 0,15");
						$total_fields = mysql_num_rows($res_menu);
						while($row_heading= mysql_fetch_array($res_menu))
						{
							$count++;
							$target="_self";
							$link="details.php?pgID=tp_".$row_heading['sno'];
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
							
					?>
						<a class="tt" href="<?php echo $link;?>" target="<?php echo $target;?>" title="<?php echo $row_heading['name'];?>"><?php echo $row_heading['name'];?></a>
					<?php
						}
					?>
				</div>
			</div>
		</div>
	</section> 
    <!-- /#promotional-text -->
	<section class="mq-sec">
	<div class="container">
		<div class="row mq-content">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<?php
		$sno=0;
		$sql_news="select * from news where status='active' and areaSection IN('marquee','both') order by newsdate desc limit 0, 10";
		$result_news=mysql_query($sql_news);
		?>
		<marquee behavior="scroll" direction="left" scrollamount="5" onmouseover="this.stop();" onmouseout="this.start();" >
		<?php
		while($row_news=mysql_fetch_array($result_news))
		{
			$sno++;
			$iconimage="";
			$size=1;
			if($row_news['size']!="")
			{
				$size=$row_news['size'];
			}	
			$link = "news-details&topic=".$row_news['ser'];
			$target  = "_self";
			if($row_news['extension']!='' && file_exists("uploads/news/".$row_news['extension']))
			{
				$link = "uploads/news/".$row_news['extension'];
				$target  = "_blank";
			}
			else if( $row_news['link'] != '' )
			{
				$link = $row_news['link'];
				$target  = $row_news['target'];						
			}
		?><a href="<?php echo $link;?>" target="<?php echo $target;?>"><?php echo $row_news['title'];?></a>
		<?php } ?>
		</marquee>
		<!--marquee behavior="scroll" direction="left" scrollamount="5" onmouseover="this.stop();" onmouseout="this.start();" ><a href="http://fsi.nic.in/uploads/news/news_1467_tender-document-29-10-2018.pdf"><strong>The revised tender document for server based Web GIS Platform for NFI has been uploaded after duly considering suggestions given by the firm in pre-bid conference held at FSI on 25th October 2018.<strong></a--><!--a href="https://unccdcop14india.gov.in/" target="_blank">United Nations Convention to CombatDesertification - https://unccdcop14india.gov.in/</a></marquee-->
	</div>
	</div>
	</div>
	</section>
	
	<section id="landscaping-design-gardener" style="padding-top:7px;">
		<div class="container">			
			<div class="row">	
				<!--div class="col-md-12" style="margin-bottom: 10px;">
					<h2 style="text-align:center;"><b>Live Release of ISFR 2019</b></h2><br>
					<iframe width="100%" height="515" src="https://www.youtube.com/embed/vr8qqH243EU" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div-->
<!--marquee behavior="alternate" direction="left" scrollamount="5" onmouseover="this.stop();" onmouseout="this.start();" style="color:#ff0000;font-size:16px;margin-top:-6px;">Due to some technical snag at NRSC, the dissemination of SNPP-VIIRS base Forest Fire alerts have been suspended till the problem is resolved.</marquee-->			
							<div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
					<div id="sp_vertical_megamenu" class="sp-vertical-megamenu clearfix">
                    <h2 class="cat-title" style="font-size: 20px;">FSI NEWS</h2>
                    <div class="bd">						
						<marquee id="externalmarquee4" direction="up" scrollamount="1" style="width:204;height:250px;border:0px solid black;padding:1px" onmouseover="this.scrollAmount=0" onmouseout="this.scrollAmount=1" scrolldelay="91">												
						<table id="newsTable" width="100%" cellspacing="2" style="padding: 4px;" cellpadding="2" border="0">
							<tbody>
								<?php
								date_default_timezone_set('Asia/Calcutta');
								$past_date = date("Y-m-d", strtotime("-1 months"));
								
								$sno=0;
								$sql_news="select * from news where status='active' and areaSection IN('news','both') and (newsdate<'$past_date') order by newsdate desc limit 0, 10";
								$result_news=mysql_query($sql_news);
								while($row_news=mysql_fetch_array($result_news))
								{
									$sno++;
									$iconimage="";
									$size=1;
									if($row_news['size']!="")
									{
										$size=$row_news['size'];
									}	
									$link = "news-details&topic=".$row_news['ser'];
									$target  = "_self";
									if($row_news['extension']!='' && file_exists("uploads/news/".$row_news['extension']))
									{
										$link = "uploads/news/".$row_news['extension'];
										$target  = "_blank";
									}
									else if( $row_news['link'] != '' )
									{
										$link = $row_news['link'];
										$target  = $row_news['target'];						
									}
								?>
								<tr>
									<td style="padding: 4px;">
										<strong> <?php echo date("d-M-Y", strtotime( $row_news['newsdate']));?></strong><br>
										<a href="<?php echo $link;?>" target="<?php echo $target;?>"><p><?php echo $row_news['title'];?></p></a>
									</td>
								</tr>
								<?php } ?>							
								</tbody>
							</table>													
						</marquee>
					</div>					
					</div>
				</div>
				<div class="col-lg-5 col-md-8 col-sm-12 col-xs-12">
					<h2>Forest Survey of India<b><br> 
					<?php 
						$row_welcome = mysql_fetch_array(mysql_query("select sno, front, heading, detail, otherurl, target, banner from welcome")); 
						echo $row_welcome['heading'];
						$bannerExists = 0;
						if( $row_welcome['banner'] != "" && file_exists( "uploads/images/banner/".$row_welcome['banner'])) { 
							$bannerExists = 1;
						}
					?></b></h2>
					<?php echo $row_welcome['front'];?>
                    <?php if( $row_welcome['otherurl']!= "" ) { ?><div><a class="contact-button" href="<?php echo $row_welcome['otherurl']; ?>" target="<?php echo $row_welcome['target']; ?>"><div class="contact-us-button">Learn More</div><i class="fa fa-arrow-circle-right"></i></a></div><?php } ?>
				</div>
				<div class="col-lg-4 col-md-9 col-sm-12 col-xs-12 ">
               
                
                <div class="mg">
                <h3>
                <?php 
					$row_welcome = mysql_fetch_array(mysql_query("select sno, front, heading, detail, otherurl, target, banner from welcome_sec")); 
					echo $row_welcome['heading'];
					$bannerExists = 0;
					if( $row_welcome['banner'] != "" && file_exists( "uploads/images/banner/".$row_welcome['banner'])) { 
						$bannerExists = 1;
					}
				?>
				</h3>
                        <p><?php echo $row_welcome['front'];?></p>
                        <div class="list-box clearfix">
    						<ul>
    							<li><i class="fa fa-envelope"></i><a href="dg-message">View Message</a></li>
    							
    						</ul>
    						<ul>
    							<li><i class="fa fa-user"></i><a href="director-general">View profile</a></li>
    							
    						</ul>
    					</div>
                    </div>
				</div>
			</div>
		</div>
	</section>

	<section id="our-services-gardener">
		<div class="container">
			<div class="section-title2">
            	<p>We offer different services</p>
				<h1><span>FSI Activities  &amp; Services</span></h1>
			</div>
			<div class="row">
			    <?php
				$sno=0;
				$query = "select title, package_heading, description, link, extension, image, target from services where status='active' and primeArea = 1 order by sorder, postdate asc";
				$response = mysql_query($query);
				while($dataServices = mysql_fetch_array($response))
				{
					$sno++;
					
					$link = "";
					$target  = "";
					
					if($dataServices['extension']!='' && file_exists("uploads/documents/".$dataServices['extension']))
					{
						$link = "uploads/documents/".$dataServices['extension'];
						$target  = "_blank";
					}
					else if( $dataServices['link'] != '' )
					{
						$link = $dataServices['link'];
						$target  = $dataServices['target'];						
					}
				?>
            	<!--Start single service icon-->
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                	<div class="single-service-item">
                    	<div class="service-left-bg"></div>
                        <?php if( $dataServices['image'] && file_exists( "uploads/images/banner/".$dataServices['image'])) { ?>
                        <div class="service-icon">
                        	<img src="uploads/images/banner/<?php echo $dataServices['image'];?>" alt="<?php echo $dataServices['image'];?>">
                        </div>
                        <?php } ?>
                        <div class="service-text">
                        	<a href="<?php echo $link;?>" target="<?php echo $target;?>"><h4><?php echo $dataServices['title'];?></h4></a>
                            <p><?php echo strip_tags($dataServices['description']);?>..</p>
                        </div>
                    </div>
                </div>
                <!--End single service icon-->
                <?php
				}
				?>
			</div>
		</div>
	</section>

	<section id="latest-project-gardener">
		<div class="container">
			<div class="section-title2">
            	<p><?php $eventGallery = mysql_fetch_array( mysql_query( "select parentid, category from photo_cate where status = 'active' order by parentid desc limit 0,1" )); echo $eventGallery['category']; ?></p>
				<h1><span>Our Recent Events</span></h1>
			</div>
			<div class="row">
			    <?php
			    $sub_query=mysql_query("select extraClass, image, subcate from photo_subcate where parentid='$eventGallery[parentid]' and status='active' order by sorder limit 0, 6");
                while($row_subcate=mysql_fetch_array($sub_query))
                {
                ?>
				<div class="<?php if( $row_subcate['extraClass'] != '' ) { echo $row_subcate['extraClass']; } else { echo 'col-lg-4 col-md-4 col-sm-6'; } ?>">
					<div class="single-latest-project-gardener">
						<img src="uploads/images/subcate/<?php echo $row_subcate['image'];?>" alt="<?php echo ucfirst($row_subcate['subcate']);?>">
						<div class="overlay">
							<div class="box-holder">
								<div class="content-box">
									<ul>
										<li><a href="uploads/images/subcate/<?php echo $row_subcate['image'];?>" class="fancybox" data-fancybox-group="home-gallery" title="<?php echo ucfirst($row_subcate['subcate']);?>"><i class="fa fa-camera"></i></a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
				}
				?>
                
                <div class="col-lg-12">    <a class="contact-button" href="photo-gallery">
                    	<div class="contact-us-button">View  More Events</div>
                        <i class="fa fa-arrow-circle-right"></i>
                    </a></div>
			</div>
		</div>
	</section><br>
<br>


	<?php
		$common->get_footer();
	?>
	<?php
		$common->get_footer_scripts();
	?>	
	<script type="text/javascript"> 
    jQuery(document).ready(function() {
 
        jQuery('#slider1').show().revolution({
            navigation: {
				arrows: {
                    enable: true,
                    style: 'hesperiden',
                    hide_onleave: false
                },
                bullets: {
                    enable: true,
                    style: 'hesperiden',
                    hide_onleave: false,
                    h_align: 'center',
                    v_align: 'bottom',
                    h_offset: 0,
                    v_offset: 20,
                    space: 5
                }
            }
        });
    });
 
</script>
</body>
</html>
