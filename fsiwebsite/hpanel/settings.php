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
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));
	
	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
	
		$query="delete from settings where sno='$unid_id'";
		$rs=mysql_query($query);
					$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 15, 6); 
	$_SESSION['capture_code']=$security_code;
		if($rs)
		{
			echo "<script>location.href='settings.php?display=delete'</script>";
		}
		else
		{
			echo "<script>location.href='settings.php?error=incorrect'</script>";
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='settings.php?status=codeinvalid'</script>";
	}
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='remove_banner')
{ 
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	
	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{

		$sql="update settings set logo=''";
			
		mysql_query($sql);
			$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 15, 6); 
	$_SESSION['capture_code']=$security_code;
		echo "<p align='center'>Please Wait..</p>";
		
		echo "<script>location.href='settings.php'</script>";
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='settings.php?status=codeinvalid'</script>";
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
		$ran = rand(1,9999);
				
		$img_response = sh_upload_file("logo", "image", "../uploads/logo/", "logo_".$ran);
		if($img_response)
		{
			$fname = $img_response;
		}
		else
		{
			$attacherror=1;
			$errormsg="Unable to Upload Image!";
		}		
		
		$chk=mysql_query("select sno from settings");
		$phone = preg_replace('/[^0-9]/', '', trim(filter_xss($_POST['phone1'])));
		$mobile = preg_replace('/[^0-9]/', '', trim(filter_xss($_POST['phone2'])));
		if(mysql_num_rows($chk)==0)
		{
	
			$query="insert into settings website_name='".filter_xss($_POST['name'])."', logo='$fname', phone='".$phone."', mobile='".$mobile."', address='".filter_xss($_POST['address'])."', twitter='".filter_xss($_POST['twitter'])."', facebook='".filter_xss($_POST['facebook'])."', linkedin='".filter_xss($_POST['linkedin'])."', youtube='".filter_xss($_POST['youtube'])."', footer_note='".filter_xss($_POST['footer_note'])."', website_url ='".filter_xss($_POST['website_url'])."'";
				
			$sq3="update update_tab set crdate='$pdate'";
			mysql_query($sq3);
	
		}
		else
		{
	
			$query="update settings set website_name='".filter_xss($_POST['name'])."', phone='".$phone."', mobile='".$mobile."', address='".filter_xss($_POST['address'])."', twitter='".filter_xss($_POST['twitter'])."', facebook='".filter_xss($_POST['facebook'])."', linkedin='".filter_xss($_POST['linkedin'])."', youtube='".filter_xss($_POST['youtube'])."', footer_note='".filter_xss($_POST['footer_note'])."', website_url ='".filter_xss($_POST['website_url'])."'";
			if($img_response)
			{
				$query.=", logo='$fname'";
			}			
		}
		
		$rs=mysql_query($query);
					$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 15, 6); 
	$_SESSION['capture_code']=$security_code;
		mysql_query("update update_tab set crdate='$pdate'");
		
		if($rs)
		{
			echo "<script>location.href='settings.php?display=update'</script>";	
		}
		else
		{
			echo "<script>location.href='settings.php?error=incorrect'</script>";	
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='settings.php?status=codeinvalid'</script>";
	}
}


function view()
{
	$res_details=mysql_query("select * from settings");
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
							Theme Settings						
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="mainmenu.php">Home</a> 
								<span class="icon-angle-right"></span>
							</li>
							<li>
								<a href="#">Extra's</a>
								<span class="icon-angle-right"></span>
							</li>
							<li><a href="#">Theme Settings</a></li>
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
								<div class="caption"><i class="icon-reorder"></i>Theme Settings</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<!--a href="#portlet-config" data-toggle="modal" class="config"></a-->
									<a href="javascript:;" class="reload"></a>
									<!--a href="javascript:;" class="remove"></a-->
								</div>
							</div>
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
								<form action="settings.php" enctype="multipart/form-data" id="form_page" name="form_page" class="form-horizontal" method="post">
									
									
									<div class="control-group">
										<label class="control-label">Website Name<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="name" value="<?php echo $row_details['website_name'];?>" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>								
									
									<div class="control-group">
										<label class="control-label">Upload Logo&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="file" name="logo" size="10" style="font-family: Verdana; font-size: 9pt">
											<?php
												if(isset($row_details['logo']) && $row_details['logo']!='' && file_exists("../uploads/logo/".$row_details['logo']))
												{
											?>
													<font face="Trebuchet MS"><b><a target="_blank" href="../uploads/logo/<?php echo $row_details['logo']?>">
															<font size="2">view attachment</font></a><font size="2">
											<?php
												}
												if(isset($row_details['logo']) && $row_details['logo']!='' && file_exists("../uploads/logo/".$row_details['logo']))
												{
											?></font></b></font>
																						&nbsp;&nbsp;&nbsp;<b>
																						<a href="#" onclick="return false;">
																						<label onClick="var a=confirm('Are You sure delete this from database ?');if(a==true){location.href='settings.php?action=remove_banner&log=<?php echo $_SESSION[capture_code];?>';}"><font size="2" face="Trebuchet MS" color="#FF0000">
																						Remove Attachment</font></label></a></b>
																						<?php
																						}
																						?>

											<span class="help-block">e.g: only jpg,png,gif are allowed - optional field</span>
										</div>
									</div>																	
									
									<div class="control-group">
										<label class="control-label">Phone &nbsp;&nbsp;</label>
										<div class="controls">
											<input type="text" name="phone1" value="<?php echo $row_details['phone'];?>" data-required="1" class="span6 m-wrap"/>
											<span class="help-block">e.g: </span>
										</div>
									</div>	
									<div class="control-group">
										<label class="control-label">Mobile&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="text" name="phone2" value="<?php echo $row_details['mobile'];?>" data-required="1" class="span6 m-wrap"/>
											<span class="help-block">e.g: </span>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Address<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 ckeditor m-wrap" id="em1" name="address" rows="6" data-error-container="#editor2_error">
											<?php echo $row_details['address'];?></textarea>
											<div id="editor2_error"></div>
										</div>
									</div>								
									<div class="control-group">
										<label class="control-label">Twitter URL&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="text" name="twitter" value="<?php echo $row_details['twitter'];?>" data-required="1" class="span6 m-wrap"/>
											<span class="help-block">e.g: </span>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Facebook URL&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="text" name="facebook" value="<?php echo $row_details['facebook'];?>" data-required="1" class="span6 m-wrap"/>
											<span class="help-block">e.g: </span>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">QOO App URL&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="text" name="linkedin" value="<?php echo $row_details['linkedin'];?>" data-required="1" class="span6 m-wrap"/>
											<span class="help-block">e.g: </span>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Youtube URL&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="text" name="youtube" value="<?php echo $row_details['youtube'];?>" data-required="1" class="span6 m-wrap"/>
											<span class="help-block">e.g: </span>
										</div>
									</div>	
									<div class="control-group">
										<label class="control-label">Footer Note&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="text" name="footer_note" value="<?php echo $row_details['footer_note'];?>" data-required="1" class="span6 m-wrap"/>
											<span class="help-block">e.g: </span>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Website URL&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="text" name="website_url" value="<?php echo $row_details['website_url'];?>" data-required="1" class="span6 m-wrap"/>
											<span class="help-block">e.g: </span>
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
