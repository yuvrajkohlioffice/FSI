<?php
ob_start();
session_start();
error_reporting(0);
include_once "includes/classes.php";
$titlesub="";
$pageh = "";

$today_date=date("Y-m-d");

	$query="select * from recruitments where status='active' and lastdate>='$today_date' and deltype='no' order by startdate desc, sorder asc";
		
	$imgpath="recruitments/";
	$quicklink.=" <font color='#554722'> Job Advertisements</font>";
	$pagehead="Job Advertisement";

$meta_title = $common->site_name;

$meta_desc = "";

$meta_keywords = "";

if(!empty($row_details['meta_title']))
	$meta_title = strip_tags($row_details['meta_title']);
if(!empty($row_details['meta_key']))
	$meta_keywords = strip_tags($row_details['meta_key']);
if(!empty($row_details['meta_desc']))
	$meta_desc = strip_tags($row_details['meta_desc']);	
		
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Job Advertisements</title>
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
</head>
<body>
    <?php
		$common->get_header();
	?>

	<section id="breadcrumb-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="breadcrumb-title text-center">
                    	<h1>&nbsp;</h1>
						
					</div> <!-- /.page-breadcumb -->
				</div>
			</div>
		</div>
	</section>

	<!-- #promotional-text -->
	<section id="promotional-text" class="gardener">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-12">
					<p></p>
				</div>
                <?php if( $primeLink ) { ?><div class="col-lg-4 col-md-12"><a class="contact-button" href="<?php echo $primeLink;?>" target="<?php echo $target;?>"><div class="contact-us-button">Learn More</div><i class="fa fa-arrow-circle-right"></i></a></div><?php } ?>
			</div>
		</div>
	</section> 
    <!-- /#promotional-text -->


	
<section id="landscaping-design-gardener">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 shop-page-content">
					
                    <div class="section-title-style-2">
						<h1>Job Advertisements</h1>
					</div>					
					<div class="row">
					    <div class="col-md-12">
                    	
                    	<table border="1" width="100%" class="recruitment" cellpadding="4" id="table94" style="border-collapse: collapse" bordercolor="#003F00">
								<tr>
									<td align="center" width="55">
									<font size="2" face="Trebuchet MS"><b>S. No.</b></font></td>
									<td align="center" width="235">
									<font size="2"><b>Advertisement</b></font></td>
									<td align="center" width="118">
									<font size="2"><b>Date of Adv. / Date of 
									Opening</b></font></td>
									<td align="center"><font size="2"><b>Last 
									Date</b></font></td>
									<td align="center" width="137">
									<font size="2" face="Trebuchet MS"><b>Application</b></font></td>
									<td align="center" width="121">
												<font size="2" face="Trebuchet MS"><b>
												Important Notices</b></font></td>
									<td align="center" width="88">
												<font face="Trebuchet MS" size="2">
												<b>Result</b></font></td>
								</tr>
								<?php
							$res_query=mysql_query($query);
							$sno=0;
							while($row_details=mysql_fetch_array($res_query))
							{
								$colspan=2;
								$sno++;
								
								$link="details.php?recruitment=".$row_details['ser'];
								$target="_self";
								
								if($row_details['extension']!='' && file_exists("uploads/recruitments/".$row_details['extension']))
								{
									$link="uploads/recruitments/".$row_details['extension'];
									$target="_blank";
								}
								else if($row_details['link']!='')
								{
									$link=$row_details['link'];
									$target=$row_details['target'];
								}
							?>
								<tr>
									<td width="55" align="center"><font size="2" face="Trebuchet MS" color="#000000"><?php echo $sno;?>.</font></td>
									<td width="235"><a href="<?php echo $link;?>" target="<?php echo $target;?>">
									<font size="2" face="Trebuchet MS" color="#037672"><?php 
									
									echo $row_details['title'];
									$iconimage="";
									if($row_details['imageicon']!="")
									{
										$sql_image="select filename from uploads_photo where status='active' and sno='$row_details[imageicon]'";
										$row_image=mysql_fetch_array(mysql_query($sql_image));
										$iconimage="uploads/icons/".$row_image['filename'];									
									?>
									<img src="<?php echo $iconimage;?>" border="0"> <?php } ?></font></a><font size="2" face="Trebuchet MS" color="#037672"> </font></td>
									<td align="center" width="118"><font size="2" face="Trebuchet MS">
									<?php 
									if($row_details['startdate']!="0000-00-00" && $row_details['startdate']!="1970-01-01")
									echo date("d-m-Y",strtotime($row_details['startdate']));?></font></td>
									<td align="center"><font size="2" face="Trebuchet MS"><?php 
									if($row_details['lastdate']!="0000-00-00" && $row_details['lastdate']!="1970-01-01")
									echo date("d-m-Y",strtotime($row_details['lastdate']));?></font></td>
									<td width="137">									
									<?php 
										$tender_doc=mysql_query("select * from recruitment_document where deltype='no' and job_no='$row_details[ser]' and doc_type='application' order by sorder");
									?>									
									<table width="100%">	
									<?php
										$count=0;
										while($row_tender_doc=mysql_fetch_array($tender_doc))
										{
											$doclink="";
											$doctarget="";
											$count++;
											if(!empty($row_tender_doc['otherurl']))
											{
												$doclink = $row_tender_doc['otherurl'];
												$doctarget = "_blank";
											}
											else if($row_tender_doc['filename']!='' && file_exists("uploads/recruitments/documents/".$row_tender_doc['filename']))
											{
												$doclink="uploads/recruitments/documents/".$row_tender_doc['filename'];
												$doctarget="_blank";
											}											
									?>								
									<tr>
									<td><font size="2" face="Trebuchet MS" color="#037672">
									<?php
									echo $count;
									if($doclink!="")
									{
									?>
										<a href="<?php echo $doclink;?>" target="<?php echo $doctarget;?>">
									<?php 
									}
									?>
									<font size="2" face="Trebuchet MS" color="#037672">									
										<?php echo $row_tender_doc['keywords'];?>
									</font>
									</a>
									</font>
									</td>
									</tr>
									<?php
									}
									?>
									</table>

									</font>
									</td>
									<td width="121">
									<?php 
										$tender_doc=mysql_query("select * from recruitment_document where deltype='no' and job_no='$row_details[ser]' and doc_type='notice' order by sorder");
									?>									
									<table width="100%">	
									<?php
										$count=0;
										while($row_tender_doc=mysql_fetch_array($tender_doc))
										{
											$doclink="";
											$doctarget="";
											$count++;
											if(!empty($row_tender_doc['otherurl']))
											{
												$doclink = $row_tender_doc['otherurl'];
												$doctarget = "_blank";
											}
											else if($row_tender_doc['filename']!='' && file_exists("uploads/recruitments/documents/".$row_tender_doc['filename']))
											{
												$doclink="uploads/recruitments/documents/".$row_tender_doc['filename'];
												$doctarget="_blank";
											}									?>								
									<tr>
									<td><font size="2" face="Trebuchet MS" color="#037672">
									<?php
									echo $count;
									if($doclink!="")
									{
									?>
										<a href="<?php echo $doclink;?>" target="<?php echo $doctarget;?>">
									<?php 
									}
									?>
									<font size="2" face="Trebuchet MS" color="#037672">									
										<?php echo $row_tender_doc['keywords'];?>
									</font>
									</a>
									</font>
									</td>
									</tr>
									<?php
									}
									?>
									</table>
									</font>
									</td>
									<td width="88">
									<?php 
										$tender_doc=mysql_query("select * from recruitment_document where deltype='no' and job_no='$row_details[ser]' and doc_type='result' order by sorder");
									?>									
									<table width="100%">	
									<?php
										$count=0;
										while($row_tender_doc=mysql_fetch_array($tender_doc))
										{
											$doclink="";
											$doctarget="";
											$count++;
											if(!empty($row_tender_doc['otherurl']))
											{
												$doclink = $row_tender_doc['otherurl'];
												$doctarget = "_blank";
											}
											else if($row_tender_doc['filename']!='' && file_exists("uploads/recruitments/documents/".$row_tender_doc['filename']))
											{
												$doclink="uploads/recruitments/documents/".$row_tender_doc['filename'];
												$doctarget="_blank";
											}
									?>								
									<tr>
									<td><font size="2" face="Trebuchet MS" color="#037672">
									<?php
									echo $count;

									if($doclink!="")
									{
									?>
										<a href="<?php echo $doclink;?>" target="<?php echo $doctarget;?>">
									<?php 
									}
									?>
									<font size="2" face="Trebuchet MS" color="#037672">									
										<?php echo $row_tender_doc['keywords'];?>
									</font>
									</a>
									</font>
									</td>
									</tr>
									<?php
									}
									?>
									</table>

									</font>
									</td>
								</tr>
							<?php
							}
							?>
							</table>
                    	
						</div>
					</div>	
				</div> 

			</div>
		</div>
	</section>

	<?php
		$common->get_footer();
	?>
	<?php
		$common->get_footer_scripts();
	?>
</body>
</html>
