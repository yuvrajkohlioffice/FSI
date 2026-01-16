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


if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='remove_banner')
{ 
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		
		$banner_query=mysql_query("select * from banner_image where ser='$_GET[ID]'");
		$row_banner=mysql_fetch_array($banner_query);
		$bannerpath="../uploads/banner/".$row_banner['image'];
		if(isset($row_banner['image']) && $row_banner['image']!="" && file_exists($bannerpath))
		{
			unlink($bannerpath);
		}
		
		$sql="update banner_image set image='' where ser='$_GET[ID]'";
		
		mysql_query($sql);
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='manage-index-banner.php'</script>";
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='manage-index-banner.php?status=codeinvalid'</script>";
	}
}


if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='active')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));
	
	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		
		$query="update banner_image set status='inactive' where ser='$unid_id'";
		$rs=mysql_query($query);
			$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 15, 6); 
	$_SESSION['capture_code']=$security_code;
		if($rs)
		{
			echo "<script>location.href='manage-index-banner.php?display=status'</script>";	
		}
		else
		{
			echo "<script>location.href='manage-index-banner.php?error=incorrect'</script>";	
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='manage-index-banner.php?status=codeinvalid'</script>";
	}
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='inactive')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));
	
	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		
		$query="update banner_image set status='active' where ser='$unid_id'";
		$rs=mysql_query($query);
		$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 15, 6); 
	$_SESSION['capture_code']=$security_code;
		if($rs)
		{
			echo "<script>location.href='manage-index-banner.php?display=update'</script>";	
		}
		else
		{
			echo "<script>location.href='manage-index-banner.php?error=incorrect'</script>";	
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='manage-index-banner.php?status=codeinvalid'</script>";
	}
}

if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['flag']==1)
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_POST['log']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		
		$crdate=date("Y-m-d");
		
		$max=rand(5000,60000);
		
		$img_response = sh_upload_file("txtbanner", "image", "../uploads/banner/", "banner_".$max);
		
		if($img_response)
		{
			$fname = $img_response;
		}
		
		$query="insert into banner_image(title,link,target,status,image,crdate,sorder,ipaddress)values('".filter_xss($_POST['txtheading'])."','".filter_xss($_POST['otherurl'])."','$_POST[target]','active','$fname','$crdate','".filter_xss($_POST['txtposition'])."','$_SERVER[REMOTE_ADDR]')";
		
		$rs=mysql_query($query);
			$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 15, 6); 
	$_SESSION['capture_code']=$security_code;
		if($rs)
		{
			echo "<script>location.href='manage-index-banner.php?display=add'</script>";
		}
		else
		{
			echo "<script>location.href='manage-index-banner.php?error=incorrect'</script>";
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='manage-index-banner.php?status=codeinvalid'</script>";
	}
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='delete_heading')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));
	
	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		$query="delete from banner_image where ser='$unid_id'";
		$rs=mysql_query($query);
			$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 15, 6); 
	$_SESSION['capture_code']=$security_code;
		if($rs)
		{
			echo "<script>location.href='manage-index-banner.php?display=delete'</script>";
		}
		else
		{
			echo "<script>location.href='manage-index-banner.php?error=incorrect'</script>";
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='manage-index-banner.php?status=codeinvalid'</script>";
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
		$max=rand(5000,60000);
		
		$img_response = sh_upload_file("txtbanner", "image", "../uploads/banner/", "banner_".$max);
		
		if($img_response)
		{
			$fname = $img_response;
		}
	
	   if($img_response)
	   {
	   $sql="update banner_image set title='".filter_xss($_POST['txtheading'])."',link = '".filter_xss($_POST['otherurl'])."',target = '$_POST[target]', status = 'active', image='$fname',sorder='".filter_xss($_POST['txtposition'])."' where ser='$unid_id'";    
	   }
	   else 
	   {
		$sql="update banner_image set title='".filter_xss($_POST['txtheading'])."',link = '".filter_xss($_POST['otherurl'])."',target = '$_POST[target]',status = 'active', sorder='".filter_xss($_POST['txtposition'])."' where ser='$unid_id'";
	   }	
		$rs=mysql_query($sql);
	  	$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 15, 6); 
	$_SESSION['capture_code']=$security_code;
		if($rs)
		{
			echo "<script>location.href='manage-index-banner.php?display=update'</script>";
		}
		else
		{
			echo "<script>location.href='manage-index-banner.php?error=incorrect'</script>";
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='manage-index-banner.php?status=codeinvalid'</script>";
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
							Home Page Banner
							<small>Add Banner</small>
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
							<li><a href="#">Manage banner</a></li>
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
						?>							<div class="portlet box blue">
							<div class="portlet-title">
								<div class="caption"><i class="icon-cogs"></i>Manage Index banner</div>
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
											<th>Banner Title</th>
											<th>Website Position</th>
											<th class="hidden-480">Banner</th>											
											<th>Status</th>
											<th colspan="2">Action</th>
										</tr>
									</thead>
									<tbody>
									<?php
									$sno=0;
									$res_mainmenu=mysql_query("select * from banner_image order by sorder asc");
									while($row_mainmenu=mysql_fetch_array($res_mainmenu))
									{
										$sno=$sno+1;
									?>
										<tr>
											<td><?php echo $sno; ?></td>
											<td><?php echo $row_mainmenu['title'];?></td>
											<td><?php echo $row_mainmenu['sorder'];?></td>
											<td class="hidden-480">
											<?php 
											$imgpath="../uploads/banner/$row_mainmenu[image]";
											if($row_mainmenu['image']!="" && file_exists($imgpath))
											{
											?>												
											<img src="../uploads/banner/<?php echo $row_mainmenu['image'];?>" width="56" height="50">											
											<?php
											}
											else
											{
											echo 'N.A';
											}
											?>
											</td>											
											<td>
											<a href="manage-index-banner.php?action=<?php echo $row_mainmenu['status']?>&sno=<?php echo $row_mainmenu['ser']?>&log=<?php echo $_SESSION['capture_code'];?>">
											<?php
											if($row_mainmenu['status']=='active')
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
											<a href="manage-index-banner.php?sno=<?php echo $row_mainmenu['ser'];?>&action=<?php echo 'edit_heading'?>&log=<?php echo $_SESSION['capture_code'];?>">
											<img border="0" src="images/edit.png" width="20" height="20" alt="Edit" name="Edit"></a></td>
											<td><input type="image" img border="0" src="images/delete.png" width="20" height="20" onclick="var a=confirm('Are You sure delete this record from database ?');if(a==true){location.href='manage-index-banner.php?sno=<?php echo $row_mainmenu['ser']?>&action=<?php echo 'delete_heading'?>&log=<?php echo $_SESSION['capture_code'];?>';}" alt="Delete" name="delete"></td>
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
								<div class="caption"><i class="icon-reorder"></i>Add Banner</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<!--a href="#portlet-config" data-toggle="modal" class="config"></a-->
									<a href="javascript:;" class="reload"></a>
									<!--a href="javascript:;" class="remove"></a-->
								</div>
							</div>
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
								<form action="manage-index-banner.php?action=category"  enctype="multipart/form-data" id="form_main_menu" class="form-horizontal" method="post">
									<div class="alert alert-error hide">
										<button class="close" data-dismiss="alert"></button>
										You have some form errors. Please check below.
									</div>
									<div class="alert alert-success hide">
										<button class="close" data-dismiss="alert"></button>
										Your form validation is successful!
									</div>									
									<div class="control-group">
										<label class="control-label">Title<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="txtheading" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Upload Banner&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="file" name="txtbanner" size="10" style="font-family: Verdana; font-size: 9pt">
											</font></b></font>										
										</div>
									</div>		
												
									<div class="control-group">
										<label class="control-label">URL&nbsp;&nbsp;</label>
										<div class="controls">
											<input name="otherurl" type="text" class="span6 m-wrap"/>
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
											<input name="txtposition" type="text" class="span6 m-wrap"/>
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
		$menuid=preg_replace('/[^0-9]/', '', trim($_GET['sno']));
		$query=mysql_query("select * from banner_image where ser='$menuid'");
		$row_mainmenu=mysql_fetch_array($query);
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
							Home Page Banner
							<small>Add Banner</small>
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
							<li><a href="#">Manage banner</a></li>
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
								<div class="caption"><i class="icon-reorder"></i>Edit Banner</b></div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<!--a href="#portlet-config" data-toggle="modal" class="config"></a-->
									<a href="javascript:;" class="reload"></a>
									<!--a href="javascript:;" class="remove"></a-->
								</div>
							</div>
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
								<form action="manage-index-banner.php"  enctype="multipart/form-data"  id="form_main_menu" class="form-horizontal" method="post">					
									
									<div class="control-group">
										<label class="control-label">Title<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="txtheading" value="<?php echo $row_mainmenu['title'];?>" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>		
									<div class="control-group">
										<label class="control-label">Upload Banner&nbsp;&nbsp;</label>
										<div class="controls">										    
											<input type="file" name="txtbanner" size="10" style="font-family: Verdana; font-size: 9pt">
											<!--img src="../banner/<?php echo $row_mainmenu['image'];?>"-->
											<?php											     
												if(isset($row_mainmenu['image']) && $row_mainmenu['image']!='' && file_exists("../uploads/banner/".$row_mainmenu['image']))
												{
											?>
													<font face="Trebuchet MS"><b><a target="_blank" href="../uploads/banner/<?php echo $row_mainmenu['image']?>">
															<font size="2">view attachment</font></a><font size="2">
											<?php
												}
												if(isset($row_mainmenu['image']) && $row_mainmenu['image']!='' && file_exists("../uploads/banner/".$row_mainmenu['image']))
												{
											?></font></b></font>
																						&nbsp;&nbsp;&nbsp;<b>
																						<a href="#" onclick="return false;">
																						<label onClick="var a=confirm('Are You sure delete this from database ?');if(a==true){location.href='manage-index-banner.php?action=remove_banner&ID=<?php echo $row_mainmenu['ser'];?>&log=<?php echo $_SESSION['capture_code'];?>'}"><font size="2" face="Trebuchet MS" color="#FF0000">
																						Remove Attachment</font></label></a></b>
																						<?php
																						}
																						?>
										</div>
									</div>		
									
									<div class="control-group">
										<label class="control-label">URL&nbsp;&nbsp;</label>
										<div class="controls">
											<input name="otherurl" value="<?php echo $row_mainmenu['link'];?>" type="text" class="span6 m-wrap"/>
											<span class="help-block">e.g: http://www.demo.com or http://demo.com - optional field</span>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Target<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="target">
												<option value="">Select...</option>
												<option value="_blank" <?php if($row_mainmenu['target']=="_blank") { echo 'selected'; } ?>>Open in New Window</option>
												<option value="_self" <?php if($row_mainmenu['target']=="_self") { echo 'selected'; } ?>>Open in Same Window</option>
											</select>
											<span class="help-block">applicable only if you enter any other link</span>
										</div>
									</div>						
									<div class="control-group">
										<label class="control-label">Website Position<span class="required">*</span></label>
										<div class="controls">
											<input name="txtposition" type="text" value="<?php echo $row_mainmenu['sorder'];?>" class="span6 m-wrap"/>
										</div>
									</div>									
									
									<div class="form-actions">
										<button type="submit" class="btn purple">Save</button>
										<button type="button" class="btn">Cancel</button>
										<input type="hidden" name="action" size="20" value="edit1">
										<input type="hidden" name="sno" size="20" value="<?php echo $_GET['sno']; ?>">
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
