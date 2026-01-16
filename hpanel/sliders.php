<?php
	include_once "includes/constant.php";
	include_once "control.php";
	
if(!isset($_REQUEST['action']))
{
	$action='';
	$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 15, 6); 
	$_SESSION['capture_code']=$security_code;
	view();
	exit;
}

if(!isset($_POST['flag']))
{
	$flag='';
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='active')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));
	
	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{	
		
		$query="update sliders set status='inactive' where sno='$unid_id'";
		$rs=mysql_query($query);
			$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 15, 6); 
	$_SESSION['capture_code']=$security_code;
		if($rs)
		{
			echo "<script>location.href='sliders.php?display=status'</script>";	
		}
		else
		{
			echo "<script>location.href='sliders.php?error=incorrect'</script>";	
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='sliders.php?status=codeinvalid'</script>";
	}
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='inactive')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));
	
	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{	
		$query="update sliders set status='active' where sno='$unid_id'";
		$rs=mysql_query($query);
		$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 15, 6); 
	$_SESSION['capture_code']=$security_code;
		if($rs)
		{
			echo "<script>location.href='sliders.php?display=update'</script>";	
		}
		else
		{
			echo "<script>location.href='sliders.php?error=incorrect'</script>";	
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='sliders.php?status=codeinvalid'</script>";
	}
}

if(isset($_POST['flag']) && !empty($_POST['flag']) && $_POST['flag']==1)
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_POST['log']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{	
		$max=rand(1000,60000);
		$fname="";

		$img_response = sh_upload_file("txtbanner", "image", "../uploads/images/slides/", "slider_".$max);
		if($img_response)
		{
			$row_max=mysql_fetch_assoc(mysql_query("select max(sno) as sno from sliders limit 1"));
	        $start=$row_max['sno'];
 	        $start=$start+1;
	
			$fname = $img_response;
	
			$query="insert into sliders set sno='$start',name='".filter_xss($_POST['name'])."', teaser='".filter_xss($_POST['teaser'])."', banner='$fname', details='".filter_xss($_POST['description'])."',type='_home', otherurl='".filter_xss($_POST['url'])."',target = '$_POST[target]', sorder='".filter_xss($_POST['position'])."', ipaddress='$_SERVER[REMOTE_ADDR]', userid='$_SESSION[userid]', crdate='$today_date'";
				
			$rs=mysql_query($query);
				$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 15, 6); 
	$_SESSION['capture_code']=$security_code;
			
		}
		if($rs)
		{
			echo "<script>location.href='sliders.php?display=add'</script>";
		}
		else
		{
			echo "<script>location.href='sliders.php?error=incorrect'</script>";
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='sliders.php?status=codeinvalid'</script>";
	}
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='delete_heading')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));
	
	if($capture==$postcapture && $capture!="" && $postcapture!="")
		{	
		$query="delete from sliders where sno='$unid_id'";
		$rs=mysql_query($query);
			$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 15, 6); 
	$_SESSION['capture_code']=$security_code;
		if($rs)
		{
			echo "<script>location.href='sliders.php?display=delete'</script>";
		}
		else
		{
			echo "<script>location.href='sliders.php?error=incorrect'</script>";
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='sliders.php?status=codeinvalid'</script>";
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
	$unid_id = preg_replace('/[^0-9]/', '', trim($_POST['sno']));
	
	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{	
		$max=rand(1000,60000);
				
		$img_response = sh_upload_file("txtbanner", "image", "../uploads/images/slides/", "slider_".$max);
	
		$query="update sliders set name='".filter_xss($_POST['name'])."', teaser='".filter_xss($_POST['teaser'])."', details='".filter_xss($_POST['description'])."',type='_home', otherurl='".filter_xss($_POST['url'])."',target = '$_POST[target]', sorder='".filter_xss($_POST['position'])."', modifyby='$_SESSION[userid]', modifydate='$today_date'";
		
		if($img_response)
		{
			$query.=", banner='$img_response'";
		}
		
		$query.=" where sno='$unid_id'";
		
		
		
		$rs=mysql_query($query) or die(mysql_error());
		$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 15, 6); 
	$_SESSION['capture_code']=$security_code;
		if($rs)
		{
			echo "<script>location.href='sliders.php?display=update'</script>";
		}
		else
		{
			echo "<script>location.href='sliders.php?error=incorrect'</script>";
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='sliders.php?status=codeinvalid'</script>";
	}
}


function view()
{

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
							Website Home Page Sliders
							<small>Add New Slide</small>
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
							<li><a href="#">Manage Slide's</a></li>
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
						<div class="portlet box blue">
							<div class="portlet-title">
								<div class="caption"><i class="icon-cogs"></i>Manage Slider's</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<!--a href="#portlet-config" data-toggle="modal" class="config"></a-->
									<a href="javascript:;" class="reload"></a>
									<!--a href="javascript:;" class="remove"></a-->
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-hover">
									<thead>
										<tr>
											<th>#</th>
											<th>Name</th>
											<th>Website Position</th>
											<th class="hidden-480">URL</th>
											<th>Image</th>
											<th>Status</th>
											<th colspan="2">Action</th>
										</tr>
									</thead>
									<tbody>
									<?php
									$sno = 0;
									$res_content=mysql_query("select * from sliders where type='_home' order by sorder");
									while($row_content=mysql_fetch_array($res_content))
									{
										$sno=$sno+1;
									?>
										<tr>
											<td><?php echo $sno; ?></td>
											<td><?php echo $row_content['name'];?></td>
											<td><?php echo $row_content['sorder'];?></td>
											<td class="hidden-480">
											<?php 
											if($row_content['otherurl']!='')
												echo $row_content['otherurl'];
											else
												echo "N.A.";
												
											?>
											</td>
											<td>
											<?php
											if(isset($row_content['banner']) && $row_content['banner']!='' && file_exists("../uploads/images/slides/".$row_content['banner']))
											{
											?>
											<a target="_blank" href="../uploads/images/slides/<?php echo $row_content['banner']?>">
											<img src="../uploads/images/slides/<?php echo $row_content['banner'];?>" alt="<?php echo $row_content['name'];?>" title="Click to open" width="50" height="50"></a>
											<?
											}
											?></td>
											<td>
											<a href="sliders.php?action=<?php echo $row_content['status']?>&sno=<?php echo $row_content['sno']?>&log=<?php echo $_SESSION['capture_code'];?>">
											<?php
											if($row_content['status']=='active')
											{
												echo "<img border=0 src='images/on.gif' alt=Active>";
											}
											else
											{
												echo "<img border=0 src='images/off.gif' alt=Inactive>";
											}
											?>
											</a></td>
											<td>
											<a href="sliders.php?sno=<?php echo $row_content['sno'];?>&action=<?php echo 'edit_heading'?>&log=<?php echo $_SESSION['capture_code'];?>">
											<img border="0" src="images/edit.gif" width="18" height="17" alt="Edit" name="Edit"></a></td>
											<td><input type="image" img border="0" src="images/delete.gif" width="18" height="17" onclick="var a=confirm('Are You sure delete this record from database ?');if(a==true){location.href='sliders.php?sno=<?php echo $row_content['sno']?>&action=<?php echo 'delete_heading'?>&log=<?php echo $_SESSION['capture_code'];?>';}" alt="Delete" name="delete"></td>
										</tr>
										<?php
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
						<!-- END SAMPLE TABLE PORTLET-->
					</div>					
				</div>


			
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN VALIDATION STATES-->
						<div class="portlet box purple">
							<div class="portlet-title">
								<div class="caption"><i class="icon-reorder"></i>Add New Slide</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<!--a href="#portlet-config" data-toggle="modal" class="config"></a-->
									<a href="javascript:;" class="reload"></a>
									<!--a href="javascript:;" class="remove"></a-->
								</div>
							</div>
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
								<form enctype="multipart/form-data" action="sliders.php?action=category" id="form_main_menu" class="form-horizontal" method="post">
									<div class="alert alert-error hide">
										<button class="close" data-dismiss="alert"></button>
										You have some form errors. Please check below.
									</div>
									<div class="alert alert-success hide">
										<button class="close" data-dismiss="alert"></button>
										Your form validation is successful!
									</div>									
									<div class="control-group">
										<label class="control-label">Slide Name<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="name" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>	
									<div class="control-group">
										<label class="control-label">Teaser Text<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="teaser" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>	
									<div class="control-group">
										<label class="control-label">Details<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 m-wrap" id="em1" name="description" rows="6" data-error-container="#editor2_error">
											</textarea>
											<div id="editor2_error"></div>
										</div>
									</div>								
									<div class="control-group">
										<label class="control-label">Upload Banner&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="file" name="txtbanner" size="10" style="font-family: Verdana; font-size: 9pt">																			<span class="help-block">e.g: only jpg,png,gif are allowed - optional field</span>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">URL&nbsp;&nbsp;</label>
										<div class="controls">
											<input name="url" type="text" class="span6 m-wrap"/>
											<span class="help-block">e.g: http://www.demo.com or http://demo.com - optional field</span>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Target<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="target">
												<option value="">Select...</option>
												<option value="_blank">Open in New Window</option>
												<option value="_self">Open in Same Window</option>
											</select>
											<span class="help-block">applicable only if you enter any other link</span>
										</div>
									</div>									
									<div class="control-group">
										<label class="control-label">Website Position<span class="required">*</span></label>
										<div class="controls">
											<input name="position" type="text" class="span6 m-wrap"/>
										</div>
									</div>									
									
									<div class="form-actions">
										<button type="submit" class="btn purple">Save</button>
										<button type="button" class="btn">Cancel</button>
										<input type="hidden" name="flag" size="20" value="1">
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
function edit()
{
	if(isset($_GET['sno']) && !empty($_GET['sno']))
	{	
		$contentid=preg_replace('/[^0-9]/', '', trim($_GET['sno']));
		$query=mysql_query("select * from sliders where sno='$contentid'");
		$row_content=mysql_fetch_array($query);
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
			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<div id="portlet-config" class="modal hide">
				<div class="modal-header">
					<button data-dismiss="modal" class="close" type="button"></button>
					<h3>portlet Settings</h3>
				</div>
				<div class="modal-body">
					<p>Here will be a configuration form</p>
				</div>
			</div>
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid">
				<!-- BEGIN PAGE HEADER-->   
				<div class="row-fluid">
					<div class="span12">
						     
						<h3 class="page-title">
							Website Home Page Sliders
							<small>Add New Slide</small>
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
							<li><a href="#">Manage Slide's</a></li>
						</ul>
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->	
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN SAMPLE TABLE PORTLET-->
					<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN VALIDATION STATES-->
						<div class="portlet box purple">
							<div class="portlet-title">
								<div class="caption"><i class="icon-reorder"></i>Edit Slide - <b>"<?php echo $row_content['name'];?>"</b></div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<!--a href="#portlet-config" data-toggle="modal" class="config"></a-->
									<a href="javascript:;" class="reload"></a>
									<!--a href="javascript:;" class="remove"></a-->
								</div>
							</div>
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
								<form action="sliders.php" id="form_main_menu" class="form-horizontal" method="post">									
									<div class="control-group">
										<label class="control-label">Slide Name<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="name" value="<?php echo $row_content['name'];?>" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Teaser Text<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="teaser" value="<?php echo $row_content['teaser'];?>" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>		
									<div class="control-group">
										<label class="control-label">Details<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 m-wrap" id="em1" name="description" rows="6" data-error-container="#editor2_error">
											<?php echo $row_content['details'];?></textarea>
											<div id="editor2_error"></div>
										</div>
									</div>							
									<div class="control-group">
										<label class="control-label">Upload Banner&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="file" name="txtbanner" size="10" style="font-family: Verdana; font-size: 9pt">																			<span class="help-block">e.g: only jpg,png,gif are allowed - optional field
											<?php
												if(file_exists("../uploads/images/slides/".$row_content['banner']) && $row_content['banner']!='')
												{
											?>
													<font face="Trebuchet MS"><b><a target="_blank" href="../uploads/images/slides/<?php echo $row_content['banner']?>">
															<font size="2">view attachment</font></a><font size="2">
											<?php
												}
												if(file_exists("../uploads/images/slides/".$row_content['banner']) && $row_content['banner']!='')
												{
											?></font></b></font>
																						&nbsp;&nbsp;&nbsp;<b>
																						<a href="#" onclick="return false;">
																						<label onClick="var a=confirm('Are You sure delete this from database ?');if(a==true){location.href='sliders.php?action=remove_banner&ID=about';}"><font size="2" face="Trebuchet MS" color="#FF0000">
																						Remove Attachment</font></label></a></b>
																						<?php
																						}
																						?>
											</span>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">URL&nbsp;&nbsp;</label>
										<div class="controls">
											<input name="url" type="text" value="<?php echo $row_content['otherurl'];?>" class="span6 m-wrap"/>
											<span class="help-block">e.g: http://www.demo.com or http://demo.com - optional field</span>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Target<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="target">
												<option value="">Select...</option>
												<option value="_blank" <?php if($row_content['target']=="_blank") { echo 'selected'; } ?>>Open in New Window</option>
												<option value="_self" <?php if($row_content['target']=="_self") { echo 'selected'; } ?>>Open in Same Window</option>
											</select>
											<span class="help-block">applicable only if you enter any other link</span>
										</div>
									</div>										
									<div class="control-group">
										<label class="control-label">Website Position<span class="required">*</span></label>
										<div class="controls">
											<input name="position" type="text" value="<?php echo $row_content['sorder'];?>" class="span6 m-wrap"/>
										</div>
									</div>															
																		
									
									<div class="form-actions">
										<button type="submit" class="btn purple">Save</button>
										<button type="button" class="btn">Cancel</button>
										<input type="hidden" name="action" value="edit1">
										<input type="hidden" name="sno" value="<?php echo $contentid; ?>">
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
	else
	{
		echo "<script>location.href='main-menu.php';</script>";
	}
}
?>
