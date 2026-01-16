<?php
ob_start();
session_start();
error_reporting(0);
include_once "includes/classes.php";
$titlesub="";
$pageh = "";
date_default_timezone_set('Asia/Calcutta');
$crdate=date("Y-m-d");

$query="select * from tenders where status='active' and deltype='no' and (lastdate<'$crdate') order by startdate desc, sorder asc";
	
$imgpath="uploads/tenders/";
$quicklink.=" <font color='#554722'> Tenders</font>";
$pagehead="Tenders";

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
	<title>Tenders</title>
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
						<h1>Tenders</h1>
					</div>					
					<div class="row">
					    <div class="col-md-12">
                    	<table border="0" width="99%" cellspacing="0" cellpadding="6" id="table30">
																	<tr>
																		<td>
																		<table border="1" class="tenders" width="100%" cellpadding="4" id="table94" style="border-collapse: collapse" bordercolor="#003F00">
								<tr>
									<td align="center" width="168"><b>
									<font size="2" face="Trebuchet MS">Tender 
									Reference</font></b></td>
									<td align="center" width="310"><b>
									<font size="2" face="Trebuchet MS">Download 
									Tender Document</font></b></td>
									<td align="center" width="110"><b>
									<font size="2" face="Trebuchet MS">Start 
									Date</font></b></td>
									<td align="center" width="152"><b>
									<font size="2" face="Trebuchet MS">Last Date</font></b></td>
									<td align="center"><b>
									<font size="2" face="Trebuchet MS">Opening Date</font></b></td>
									<td align="center" width="153"><b>
									<font size="2" face="Trebuchet MS">Related 
									Links</font></b></td>
								</tr>
								<?php
							$res_query=mysql_query($query);
							$sno=0;
							while($row_details=mysql_fetch_array($res_query))
							{
								$colspan=2;
								$sno++;
								$link="details.php?tenderID=".$row_details['ser'];
								$target="";
								if($row_details['extension']!='' && file_exists("uploads/tenders/".$row_details['extension']))
								{
									$link="uploads/tenders/".$row_details['extension'];
									$target="_blank";
								}
								else if($row_details['link']!='')
								{
									$link=$row_details['link'];
									$target="_blank";
								}
							?>
								<tr>
									<td width="168"><font size="2" face="Trebuchet MS" color="#000000"><?php echo $row_details['reference_no'];?></font></td>
									<td width="310"><a href="<?php echo $link;?>" target="<?php echo $target;?>">
									<font size="2" face="Trebuchet MS" color="#037672"><?php echo $row_details['title'];?></font></a></td>
									<td align="center" width="110"><font size="2" face="Trebuchet MS"><?php echo date("d-m-Y",strtotime($row_details['startdate']));?></font></td>
									<td align="center" width="152"><font size="2" face="Trebuchet MS"><?php echo date("d-m-Y",strtotime($row_details['lastdate']));?></font></td>
									<td align="center"><font size="2" face="Trebuchet MS"><?php echo date("d-m-Y",strtotime($row_details['openingdate']));?></font></td>
									<td width="153">
									<?php 
										$tender_doc=mysql_query("select * from tender_document where deltype='no' and tender_no='$row_details[ser]' order by sorder");
									?>									
									<table width="100%">	
									<?php
										$count=0;
										while($row_tender_doc=mysql_fetch_array($tender_doc))
										{
											$doclink="";
											$doctarget="";
											$count++;
											if($row_tender_doc['filename']!='' && file_exists("uploads/tenders/documents/".$row_tender_doc['filename']))
											{
												$doclink="uploads/tenders/documents/".$row_tender_doc['filename'];
												$doctarget="_blank";
											}
									?>								
									<tr>
									<td>
									<?php
									if($doclink!="")
									{
									?>
										<a href="<?php echo $doclink;?>" target="<?php echo $doctarget;?>">
									<?php 
									}
									?>
									<font size="2" face="Trebuchet MS" color="#037672">									
										<?php echo $count.'. '.$row_tender_doc['keywords'];?>
									</font>
									</a>
									</td>
									</tr>
									<?php
									}
									?>
									</table>

									</font></td>
								</tr>
							<?php
							}
							?>
							</table></td>
																	</tr>
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
