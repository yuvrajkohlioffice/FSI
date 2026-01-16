<?php
	include_once "includes/constant.php";
	include_once "control.php";
	$crdate=date("Y-m-d");

?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<meta charset="utf-8" />
	<?php
		include_once "head.php";
	?>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.css"/>

</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body onload="burstCache();" class="page-header-fixed">
	<!-- BEGIN HEADER -->   
	<?php
		include_once "header.php";
	?>

	<!-- END HEADER -->
	<!-- BEGIN CONTAINER -->
	<div class="page-container row-fluid">
		<!-- BEGIN SIDEBAR -->
		<?php
			include_once "side_bar.php";
		?>
		<!-- END SIDEBAR -->
		<!-- BEGIN PAGE -->  
		<div class="page-content">
			<!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid">
				<!-- BEGIN PAGE HEADER-->   
				<div class="row-fluid">
					<div class="span12">						     
						<h3 class="page-title">
							Send KML Files to Users
							<small>Send KMl Files to Emails</small>
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="mainmenu.php">Home</a> 
								<span class="icon-angle-right"></span>
							</li>
							<li>
								<a href="#">KML Database</a>
								<span class="icon-angle-right"></span>
							</li>
							<li><a href="#">Send KML Files</a></li>
						</ul>
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->	
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN VALIDATION STATES-->
						<div class="portlet box purple">
							<div class="portlet-title">
								<div class="caption"><i class="icon-reorder"></i>Click on Send to Send KML Files</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<!--a href="#portlet-config" data-toggle="modal" class="config"></a-->
									<a href="javascript:;" class="reload"></a>
									<!--a href="javascript:;" class="remove"></a-->
								</div>
							</div>
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
								<form action="http://webline.co.in/sms/email_php_function.php" enctype="multipart/form-data" id="form_page" name="form_page" class="form-horizontal" method="post">
									
									<div class="control-group">
										<label class="control-label">Users List&nbsp;&nbsp;</label>
										<div class="controls">
										<?php
											$kml_date = date("Y-m-d",strtotime($_POST[fdate1]));
											
											$chk="select ser,extension,date from upload_kml where state='$_POST[state]' and date='$kml_date' and status='active'";
											$row_chk=mysql_fetch_array(mysql_query($chk));
											
											if(mysql_num_rows(mysql_query($chk))==0)
											{
												echo "<script>alert('KML File of this date not found!!!');location.href='send-kml.php';</script>";	
											}
											else
											{
											
												$attach="http://fsi.nic.in/uploads/kmlfiles/".$row_chk['extension'];
												$ftype=filetype($attach);
											 
												$f_type = mime_content_type($attach);
											
											
												$sta="select name from state_master where sno='$_POST[state]' and status='active'";
												$row_state=mysql_fetch_array(mysql_query($sta));
										
												$subject = "Forest Fire alert for ".date('d-M-Y',strtotime($row_chk[date]))." of ".$row_state['name'];
												$count = 0;
												$em_fetch=mysql_query("select * from fire_user where status='active' and state='$_POST[state]'");
												while($row_em=mysql_fetch_array($em_fetch))
												{
													$msg = "";
													$count++;
													echo "<strong>".$count.". ".$row_em['username']."</strong> - [".$row_em['email']."]<br/>";
													$email_id[] = $row_em['email'];
												?>
													<input type="hidden" name="user_list[]" size="20" value="<?php echo $row_em['email'];?>">
												<?php
													$msg = "Dear Sir,<br/><br/>
													
													Please find the download link of kml file for fire points below. Download the file & double click on downloaded file, it would be uploaded automatically on google earth.(Google Earth should be installed on your Computer System)<br/><br/>";
													
													$encrypt = md5("true");
													$file_id = base64_encode($row_chk['ser']);
													$user = base64_encode($row_em['ser']);
													
													$msg .= "<a href='http://fsi.nic.in/download.php?authorize=$encrypt&file=$file_id&user=$user'>http://fsi.nic.in/download.php?authorize=$encrypt&file=$file_id&user=$user</a><br/><br/>";
													
													if($row_em['feedbacklink']=='yes')
													{
													
													$msg .= "For the feedback, click or copy and paste the following link on any browser:<br/><br/>
													
													http://www.fsi.nic.in/feedback_state.php?state=".$row_em[state]."&emailtype=".md5("email");
													}
													$msg .= "<br/><br/>
													FSI<br/>
													Fire Monitoring Team<br/>
													0-135-2757158, 2752901";
													
													$mail_msg[] = $msg;
													$attachment[] = $attach;
												?>
												<input type="hidden" name="message_to_send[]" size="20" value="<?php echo $msg;?>">
												<input type="hidden" name="file_to_attach[]" size="20" value="<?php echo $attach;?>">
												<?php
													
												}
											}
										?>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Subject</label>
										<div class="controls">											
											<strong><?php echo $subject;?></strong>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Message</label>
										<div class="controls">
											<textarea class="span12 ckeditor m-wrap" id="em1" readonly name="message" rows="6" data-error-container="#editor2_error">
											<?php echo $msg;?></textarea>
										</div>
									</div>

									<div class="form-actions">
										<button type="submit" class="btn purple">Send</button>										
										<input type="hidden" name="subject" size="20" value="<?php echo $subject;?>">																		
										<input type="hidden" name="action" size="5" value="save">
										<input type="hidden" value="<?php echo $_SESSION['capture_code'];?>" name="log">
									</div>
									
								</form>
								<!-- END FORM-->
							</div>
						</div>
						<!-- END VALIDATION STATES-->
					</div>
				</div>				
				<!-- END PAGE CONTENT-->         
			</div>
			<!-- END PAGE CONTAINER-->
		</div>
		<!-- END PAGE -->  
	</div>
	<!-- END CONTAINER -->
	<?php
		include_once "footer_form.php";
	?> 	
	<script src="assets/scripts/ui-jqueryui.js"></script>     
	<!-- END PAGE LEVEL SCRIPTS -->
	<script>
		jQuery(document).ready(function() {       
		   // initiate layout and plugins
		   App.init();
		   UIJQueryUI.init();
		});
	</script>
</body>
<!-- END BODY -->
</html>
