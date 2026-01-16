<?php
	include_once "includes/constant.php";
	include_once "control.php";
	$crdate=date("Y-m-d");
	
if(!isset($_REQUEST['action']))
{
	$action='';
	$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 15, 6); 
	$_SESSION['capture_code']=$security_code;
	view();
	exit;
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='delete_heading')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_POST['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));
	
	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
	
		$query="delete from welcome_sec where sno='$unid_id'";
		$rs=mysql_query($query);
			$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 15, 6); 
	$_SESSION['capture_code']=$security_code;
		if($rs)
		{
			echo "<script>location.href='welcome_hindi_2.php?display=delete'</script>";
		}
		else
		{
			echo "<script>location.href='welcome_hindi_2.php?error=incorrect'</script>";
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='welcome_hindi_2.php?status=codeinvalid'</script>";
	}
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='edit_heading')
{
	edit();
	exit;
}
	
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=='edit1')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_POST['log']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		$sql_off="select * from welcome_sec where websitetype='hindi'";
		
		$row = mysql_num_rows(mysql_query($sql_off));
		
		
		$ran = rand(1,9999);
				
		$img_response = sh_upload_file("txtbanner", "image", "../uploads/banner/", "banner_".$ran);
		if($img_response)
		{
			$fname = $img_response;
		}
		else
		{
			$attacherror=1;
			$errormsg="Unable to Upload Image!";
		}		
		
		$desc=mysql_real_escape_string(filter_xss($_POST['txtdescription']));
		//$desc=$_POST['txtdescription'];
		$desc1=mysql_real_escape_string(filter_xss($_REQUEST['readmore']));
		//$desc1=$_POST['readmore'];
		
		if($row==0)
		{
		
			if($img_response)
			{
				$query="insert into welcome_sec(websitetype,front,detail,friendly_url, otherurl,target,crdate,ipaddress,userid,heading,banner) values('hindi','$desc','$desc1','".filter_xss($_POST['friendlyurl'])."','".filter_xss($_POST['url'])."','$_POST[target]','$pdate','$_SESSION[REMOTE_ADDR]','$_SESSION[uname]','".filter_xss($_POST['txtheading'])."','$fname')";
			}
			else
			{
				$query="insert into welcome_sec(websitetype,front,detail,friendly_url, otherurl,target,crdate,ipaddress,userid,heading) values('hindi','$desc','$desc1','".filter_xss($_POST['friendlyurl'])."','".filter_xss($_POST['url'])."','$_POST[target]','$pdate','$_SESSION[REMOTE_ADDR]','$_SESSION[uname]','".filter_xss($_POST['txtheading'])."')";
			}
			
			$sq3="update update_tab set crdate='$pdate' ";
			mysql_query($sq3);
		}
		else
		{
			if($img_response)
			{
				$query="update welcome_sec set websitetype='hindi',front='$desc',detail='$desc1',friendly_url='".filter_xss($_POST['friendlyurl'])."',otherurl='".filter_xss($_POST['url'])."',target='$_POST[target]',modifyby='$_SESSION[uname]',heading='".filter_xss($_POST['txtheading'])."',modifydate='$pdate',ipaddress='$_SERVER[REMOTE_ADDR]',banner='$fname' ";
			}
			else
			{
				$query="update welcome_sec set websitetype='hindi',front='$desc',detail='$desc1',friendly_url='".filter_xss($_POST['friendlyurl'])."',otherurl='".filter_xss($_POST['url'])."',target='$_POST[target]',modifyby='$_SESSION[uname]',heading='".filter_xss($_POST['txtheading'])."',modifydate='$pdate',ipaddress='$_SERVER[REMOTE_ADDR]' ";
			}
		}
	
		$rs=mysql_query($query);
			$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 15, 6); 
	$_SESSION['capture_code']=$security_code;
		mysql_query("update update_tab set crdate='$pdate'");
		if($rs)
		{
			echo "<script>location.href='welcome_hindi_2.php?display=update'</script>";	
		}
		else
		{
			echo "<script>location.href='welcome_hindi_2.php?error=incorrect'</script>";	
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='welcome_hindi_2.php?status=codeinvalid'</script>";
	}
}


function view()
{
	$res_details=mysql_query("select * from welcome_sec");
	$row_details=mysql_fetch_array($res_details);	
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
							Website Content Management
							<small>Add/Edit Website Content</small>
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="mainmenu.php">Home</a> 
								<span class="icon-angle-right"></span>
							</li>
							<li>
								<a href="#">Home Page Content</a>
								<span class="icon-angle-right"></span>
							</li>
							<li><a href="#">Welcome Message</a></li>
						</ul>
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->	
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN SAMPLE TABLE PORTLET-->
						<?php
					     if(isset($_GET['error']) && !empty($_GET['error']))
					     {
					     	 $return_msg = preg_replace('/[^a-z]/', '', trim($_GET['error']));

					     	 if($return_msg == "incorrect")
					     	 {
					    ?>
						<div class="alert alert-error">
							<button class="close" data-dismiss="alert"></button>
							Some Error Occurred. Please try again!!
						</div>
						<?php
							}
						}
						else if(isset($_GET['status']) && !empty($_GET['status']))
					    {
					     	 $return_msg = preg_replace('/[^a-z]/', '', trim($_GET['status']));

					     	 if($return_msg == "codeinvalid")
					     	 {
					    ?>
						<div class="alert alert-error">
							<button class="close" data-dismiss="alert"></button>
							Unauthroize Access.
						</div>
						<?php
							}
						}
					    else if(isset($_GET['display']) && !empty($_GET['display']))
					    {	
					    	$return_msg = preg_replace('/[^a-z]/', '', trim($_GET['display']));
						?>
						<div class="alert alert-success">
							<button class="close" data-dismiss="alert"></button>
						<?php
							 if($return_msg == 'add')
					        {
					        	echo "Record Saved Successfully..";
					        	if(isset($_GET['msg']))
					        	{
					        		$err_msg = preg_replace('/[^a-zA-Z !]/', '', trim($_GET['msg']));
						        	if($err_msg)
						        	{
						        		echo " <span style = 'color:#FF0000'>".$err_msg."</span>";
						        	}
						        }
					        }
					        if($return_msg == 'update' || $return_msg == 'status')
					     	{
					     		echo "Record Updated Successfully..";
								if(isset($_GET['msg']))
					        	{
					        		$err_msg = preg_replace('/[^a-zA-Z !]/', '', trim($_GET['msg']));
						        	if($err_msg)
						        	{
						        		echo " <span style = 'color:#FF0000'>".$err_msg."</span>";
						        	}
						        }					     	
						    }
					     	if($return_msg == 'delete')
					     	{
					     		echo "Record Deleted Successfully..";
					     	}
					     ?>
						</div>
						<?php
							}
						?>
						<!-- END SAMPLE TABLE PORTLET-->
					</div>					
				</div>
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN VALIDATION STATES-->
						<div class="portlet box purple">
							<div class="portlet-title">
								<div class="caption"><i class="icon-reorder"></i>Welcome Message</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<!--a href="#portlet-config" data-toggle="modal" class="config"></a-->
									<a href="javascript:;" class="reload"></a>
									<!--a href="javascript:;" class="remove"></a-->
								</div>
							</div>
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
								<form action="welcome_hindi_2.php" enctype="multipart/form-data" id="form_page" name="form_page" class="form-horizontal" method="post">
									
									<div class="control-group">
										<label class="control-label">Website Type<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="language">
												<option value="">Select...</option>
												<option value="hindi" <?php if($row_details['websitetype']=='hindi'){ echo 'selected';}?>>Hindi</option>
											</select>											
										</div>
									</div>


									<div class="control-group">
										<label class="control-label">Page Heading<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="txtheading" value="<?php echo $row_details['heading'];?>" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>								
									
									<div class="control-group">
										<label class="control-label">Upload Banner&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="file" name="txtbanner" size="10" style="font-family: Verdana; font-size: 9pt">
											<?php
												if(file_exists("../uploads/banner/".$row_details['banner']) && $row_details['banner']!='')
												{
											?>
													<font face="Trebuchet MS"><b><a target="_blank" href="../uploads/banner/<?php echo $row_details['banner']?>">
															<font size="2">view attachment</font></a><font size="2">
											<?php
												}
												if(file_exists("../uploads/banner/".$row_details['banner']) && $row_details['banner']!='')
												{
											?></font></b></font>
																						&nbsp;&nbsp;&nbsp;<b>
																						<a href="#" onclick="return false;">
																						<label onClick="var a=confirm('Are You sure delete this from database ?');if(a==true){location.href='welcome_hindi_2.php?action=remove_banner&ID=about';}"><font size="2" face="Trebuchet MS" color="#FF0000">
																						Remove Attachment</font></label></a></b>
																						<?php
																						}
																						?>
</td>

											<span class="help-block">e.g: only jpg,png,gif are allowed - optional field</span>
										</div>
									</div>																	
									
									<div class="control-group">
										<label class="control-label">Menu Slug / Friendly URL&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="text" name="friendlyurl" value="<?php echo $row_details['friendly_url'];?>" data-required="1" class="span6 m-wrap"/>
											<span class="help-block">e.g: </span>
										</div>
									</div>	
									<div class="control-group">
										<label class="control-label">Front Page Description<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 ckeditor m-wrap" id="em1" name="txtdescription" rows="6" data-error-container="#editor2_error">
											<?php echo $row_details['front'];?></textarea>
											<div id="editor2_error"></div>
										</div>
									</div>								
									<div class="control-group">
										<label class="control-label">Read More Page Description<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 ckeditor m-wrap" id="em1" name="readmore" rows="6" data-error-container="#editor2_error">
											<?php echo $row_details['detail'];?></textarea>
											<div id="editor2_error"></div>
										</div>
									</div>	
									<div class="control-group">
										<label class="control-label">URL&nbsp;&nbsp;</label>
										<div class="controls">
											<input name="url" type="text" value="<?php echo $row_details['otherurl'];?>" class="span6 m-wrap"/>
											<span class="help-block">e.g: http://www.demo.com or http://demo.com - optional field</span>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Target<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="target">
												<option value="">Select...</option>
												<option value="_blank" <?php if($row_details['target']=='_blank'){ echo 'selected';}?>>Open in New Window</option>
												<option value="_self" <?php if($row_details['target']=='_self'){ echo 'selected';}?>>Open in Same Window</option>
											</select>
											<span class="help-block">applicable only if you enter any other link</span>
										</div>
									</div>	
									<div class="form-actions">
										<button type="submit" class="btn purple">Save</button>
										<button type="button" class="btn">Cancel</button>									
										<input type="hidden" name="action" size="5" value="edit1">
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
</body>
<!-- END BODY -->
</html>
<?php
}
?>
