<?php
//error_reporting(0);
session_start();
include_once "includes/classes.php";
require('../../vendor/autoload.php');
$secret = '6LdPdT4UAAAAAE2MNzkkrZqTxXUnzj4diGqLGMvU';
$recaptcha = new \ReCaptcha\ReCaptcha($secret);
$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
if ($resp->isSuccess())
{
    if( isset($_POST['registration_submit']) )
    {
	$uniqueid = preg_replace('/[^0-9]/', '', trim($_POST['grievanceid']));
	$resultComplaint = "select sno, grievance_state, crdate, uniqueid, name, address, email, phone, grievanceType, details from grievance where uniqueid = '$uniqueid' and email = '$_POST[email]'";

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
	<title>Check Grievance Status</title>
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
	
	#formdata .text-box, #formdata .text-area, #formdata select {
    margin: 0px;
    padding: 8px 10px;
    border: 1px solid #999;
    background-color: #fff;
    text-decoration: none;
    font-weight: bold;
    color: #111;
    font-size: 12px;
    float: left;
    width: 300px;
    border-radius: 3px;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    -o-border-radius: 3px;
}
			
			#formdata .overview {
				background: #FFEC9D;
				padding: 10px;
				width: 90%;
				border: 1px solid #CCCCCC;
			}
			
			#formdata .originalTextareaInfo {
				font-size: 12px;
				color: green;
				font-family: Tahoma, sans-serif;
				text-align: right;
				margin-top: 238px;
			}
			
			#formdata .warningTextareaInfo {
				font-size: 12px;
				color: #FF0000;
				font-family: Tahoma, sans-serif;
				text-align: right
			}
			
			#formdata #showData {
				height: 70px;
				width: 200px;
				border: 1px solid #CCCCCC;
				padding: 10px;
				margin: 10px;
			}
		</style>

<style>
    td{ padding: 8px; }
</style>
<script src='https://www.google.com/recaptcha/api.js'></script>
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
					<p><marquee dir="ltr" width="100%">
					<?php 
					$sno=0;
					$sql_news="select * from news where status='active' and primeArea = 1 order by newsdate asc";
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
					
						if($row_news['extension']!='' && file_exists("news/".$row_news['extension']))
						{
							$primeLink = "news/".$row_news['extension'];
							$target  = "_blank";
						}
						else if( $row_news['link'] != '' )
						{
							$primeLink = $row_news['link'];
							$target  = $row_news['target'];						
						}
					?>
					<?php echo $row_news['title'];?>
					<?php
					}
					?>
					</marquee></p>
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
						<h1>Check Grievance Status</h1>
					</div>					
					<div class="row">
					    <div class="col-md-12" id="formdata">
                    	<table border="0" width="100%" cellspacing="0" cellpadding="10" id="table5">
								<tbody><tr>
											<td bgcolor="#0A6D98" width="95%">
											<b>
											<font face="Trebuchet MS" color="#FFFFFF">
											See details below</font></b></td>
										</tr>
								<tr>
											<td  bgcolor="#FFFFFF">
											<table border="0" width="100%" cellspacing="0" cellpadding="5" id="table26">
												<tbody><tr>
													<td>
													<div class="page-content">
													<table border="0" width="100%" cellspacing="0" cellpadding="4" id="table25" bgcolor="#FFFCF0">
								<?php
								if(mysql_num_rows(mysql_query($resultComplaint))==0)
								{
								?>
								<tr>
									<td align="center" colspan="4" style="border-bottom: 1px solid #FF9900">
									<b>
									<font face="Trebuchet MS" style="font-size: 11pt" color="#A80000">
									Your Complaint ID is not found. <br>
									Please Enter correct&nbsp; Complaint ID.</font></b></td>
								</tr>
																<?
								}
								else
								{
								$rows=mysql_fetch_array(mysql_query($resultComplaint));
								?>
								<tr>
									<td align="center" bgcolor="#FFF9E1" colspan="4" style="border-bottom: 1px solid #FF9900">
									<b>
									<font face="Trebuchet MS" color="#054A98">
									Complaint Description</font></b></td>
								</tr>
									
								<tr>
									<td align="left" height="41" style="border: 1px solid #FFF1BB">
									<b>
									<font face="Trebuchet MS" size="2">
									Date of Complaint :</font></b></td>
									<td align="left" height="41" style="border: 1px solid #FFF1BB">
									<font face="Trebuchet MS" size="2" color="#054A98">
									<?php
									if($rows['crdate']!="" && $rows['crdate']!="0000-00-00")
									{
										$date=strtotime($rows['crdate']);
										echo $date=Date("j F, Y",$date);
									}
									?>
									</font></td>
<td align="left" height="41" style="border: 1px solid #FFF1BB">
									<b>
									<font face="Trebuchet MS" size="2">
									Complaint Type :</font></b></td>
									<td align="left" height="41" style="border: 1px solid #FFF1BB" colspan="3">
									<font face="Trebuchet MS" size="2" color="#054A98">
									<?php
									echo $rows['grievanceType'];
									?>
									</font></td>
								</tr>
									
								<tr>
									<td align="left" height="34" style="border: 1px solid #FFF1BB">
									<b>
									<font face="Trebuchet MS" size="2">
									Your Name :</b></font></td>
									<td align="left" height="34" style="border: 1px solid #FFF1BB">
									<font face="Trebuchet MS" size="2" color="#054A98">
									<?echo $rows[name]?></font></td>
									<td align="left" height="34" style="border: 1px solid #FFF1BB">
									<b>
									<font face="Trebuchet MS" size="2">Address :</font></b></td>
									<td align="left" style="border: 1px solid #FFF1BB">
									<font face="Trebuchet MS" size="2" color="#054A98">
									<?echo $rows[address]?></font></td>
								</tr>
									
								<tr>
									<td width="21%" align="left" style="border: 1px solid #FFF1BB">
																		
									<b>
									<font face="Trebuchet MS" size="2">E-mail ID 
									:</font></b></td>
									<td width="28%" align="left" style="border: 1px solid #FFF1BB">
									<font face="Trebuchet MS" size="2" color="#054A98">
									<?echo $rows[email]?></font>
									</td>
									<td width="19%" align="left" style="border: 1px solid #FFF1BB">
																		
									<b>
									<font face="Trebuchet MS" size="2">Phone no. 
									:</font></b></td>
									<td align="left" style="border: 1px solid #FFF1BB">
									<font face="Trebuchet MS" size="2" color="#054A98">
									<?echo $rows[mobile]?></font></td>
								</tr>
									
								<tr>
									<td width="21%" align="left" height="33" style="border: 1px solid #FFF1BB">
									
									<b>
									<font face="Trebuchet MS" size="2">Complaint ID 
									:</font></b></td>
									<td width="28%" align="left" height="33" style="border: 1px solid #FFF1BB">
									<font face="Trebuchet MS" size="2" color="#054A98">
									<?echo $rows[uniqueid]?></font></td>
									<td width="19%" align="left" height="33" style="border: 1px solid #FFF1BB">
									
									<b>
									<font face="Trebuchet MS" size="2">
									Complaint Status 
									:</font></b></td>
									<td width="27%" align="left" height="33" style="border: 1px solid #FFF1BB">
									<font face="Trebuchet MS" size="2" color="#054A98">
									<?php
									echo str_replace("_"," ",$rows[grievance_state]);
									?>
									</font></td>
								</tr>
									
								<tr>
									<td width="21%" align="left" height="33" style="border: 1px solid #FFF1BB">
									
									<b>
									<font face="Trebuchet MS" size="2">Your Complaint :</font></b></td>
									<td width="76%" align="left" height="33" colspan="3" style="border: 1px solid #FFF1BB">
									<font face="Trebuchet MS" size="2" color="#054A98">
									<?echo $rows[details]?></font></td>
								</tr>
									
											
									<tr>
									<td colspan=4 rowspan=2 style="border: 1px solid #FFF1BB; border-top: 1px solid #FF9900">
									<font face="Trebuchet MS" size="2">
									<b>
									Log</b>
									
									<ul>
										<?php
										$queryLog = mysql_query("select * from grievanceLog where grievancetableid = '$rows[sno]'");
										while( $dataLog = mysql_fetch_array( $queryLog ))
										{
											if( $dataLog['notifyUser'] == 1 )
											{
												$usernotify = 1;
											}
											else
											{
												$usernotify = 0;
											}
											
										?>
											<li><?php echo $dataLog['timestamp']." - ".$dataLog['details']; if( $usernotify == 1 ) { ?> - <strong>User Notify through Email</strong><?php } ?></li>
										<?php
										}
										?>
										</ul>
									
									</font>
									</td>
									</tr>
								<?php
								
								}
								?>

							</table>
						
													</div>
</td>
												</tr>
											</tbody></table>
											</td>
										</tr>
								</tbody></table>
                    	
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


<?php
}
else
{
	echo "<script>location.href='track-complaint.php';</script>";
}
}
else
{
	ob_flush();
	echo "<script type='text/javascript'>location.href='track-complaint.php?status=invalid' </script> ";	
}
?>
