<?php
	include_once "includes/constant.php";
	include_once "control.php";
	
if(!isset($_REQUEST['action']))
{
	$action='';
	$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 16, 16); 
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
	
		$query="update sub_heading set status='inactive' where sno='$unid_id'";
		$rs=mysql_query($query);
	
		$md5_hash = md5(rand(0,999)); 
		$security_code = substr($md5_hash, 16, 16); 
		$_SESSION['capture_code']=$security_code;

		if($rs)
		{
			echo "<script>location.href='sub-menu.php?display=update'</script>";	
		}
		else
		{
			echo "<script>location.href='sub-menu.php?error=incorrect'</script>";	
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='sub-menu.php?status=codeinvalid'</script>";
	}
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='inactive')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{	
		$query="update sub_heading set status='active' where sno='$unid_id'";
		$rs=mysql_query($query);

		$md5_hash = md5(rand(0,999)); 
		$security_code = substr($md5_hash, 16, 16); 
		$_SESSION['capture_code']=$security_code;

		if($rs)
		{
			echo "<script>location.href='sub-menu.php?display=update'</script>";	
		}
		else
		{
			echo "<script>location.href='sub-menu.php?error=incorrect'</script>";	
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='sub-menu.php?status=codeinvalid'</script>";
	}
}

if(isset($_POST['flag']) && !empty($_POST['flag']) && $_POST['flag']==1)
{

	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_POST['log']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		$title = preg_replace('/[^a-zA-Z0-9 \-.]/', '', trim($_POST['txtheading']));
		//$title = $_POST['txtheading'];
		$position = preg_replace('/[^0-9]/', '', trim($_POST['txtposition']));
		$seoURL = preg_replace('/[^a-zA-Z0-9 \-]/', '', trim($_POST['seo_url']));

		$url = "";
		if (!filter_var($_POST['url'], FILTER_VALIDATE_URL) === false) {
			$url = filter_xss($_POST['url']);
		}

		$query="insert into sub_heading(heading, websitetype, subhead,status,position,otherurl,target,seo_url) values('$_POST[parent]', '$_POST[website_type]' ,'$title','active','$position','".$url."','$_POST[target]','$seoURL')";
	
		$rs=mysql_query($query);
		$md5_hash = md5(rand(0,999)); 
		$security_code = substr($md5_hash, 16, 16); 
		$_SESSION['capture_code']=$security_code;
		if($rs)
		{
			echo "<script>location.href='sub-menu.php?display=add'</script>";
		}
		else
		{
			echo "<script>location.href='sub-menu.php?error=incorrect'</script>";
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='sub-menu.php?status=codeinvalid'</script>";
	}
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='delete_heading')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{	
		$query="delete from sub_heading where sno='$unid_id'";
		$rs=mysql_query($query);

		$md5_hash = md5(rand(0,999)); 
		$security_code = substr($md5_hash, 16, 16); 
		$_SESSION['capture_code']=$security_code;

		if($rs)
		{
			echo "<script>location.href='sub-menu.php?display=delete'</script>";
		}
		else
		{
			echo "<script>location.href='sub-menu.php?error=incorrect'</script>";
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='sub-menu.php?status=codeinvalid'</script>";
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
	
		$title = preg_replace('/[^a-zA-Z0-9 \-.]/', '', trim($_POST['txtheading']));
		
		//$title = preg_replace('/\\\\/','',$_POST['txtheading']);
		
		//$title = strip_tags($_POST['txtheading']);
		
		$position = preg_replace('/[^0-9]/', '', trim($_POST['txtposition']));
		$seoURL = preg_replace('/[^a-zA-Z0-9 \-]/', '', trim($_POST['seo_url']));
		
		$url = "";
		if (!filter_var($_POST['url'], FILTER_VALIDATE_URL) === false) {
			$url = filter_xss($_POST['url']);
		}

		$query="update sub_heading set heading='$_POST[parent]',websitetype='$_POST[website_type]',seo_url = '$seoURL', subhead='$title',otherurl='".$url."',target='$_POST[target]', position='$position' where sno='$unid_id'";
		   
		$rs=mysql_query($query);

		$md5_hash = md5(rand(0,999)); 
		$security_code = substr($md5_hash, 16, 16); 
		$_SESSION['capture_code']=$security_code;

		if($rs)
		{
			echo "<script>location.href='sub-menu.php?display=update'</script>";
		}
		else
		{
			echo "<script>location.href='sub-menu.php?error=incorrect'</script>";
		}
		
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='sub-menu.php?status=codeinvalid'</script>";
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
							Website Sub Menu
							<small>Add Website Sub Menu</small>
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="mainmenu.php">Home</a> 
								<span class="icon-angle-right"></span>
							</li>
							<li>
								<a href="#">Menu Master's</a>
								<span class="icon-angle-right"></span>
							</li>
							<li><a href="#">Manage Sub Menu's</a></li>
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
					        }
					        if($return_msg == 'update' || $return_msg == 'status')
					     	{
					     		echo "Record Updated Successfully..";
					     	}
					     	if($return_msg == 'delete')
					     	{
					     		echo "Record Deleted Successfully..";
					     	}
					     ?>
						</div>
						<?php
							}
						?>						<div class="portlet box blue">
							<div class="portlet-title">
								<div class="caption"><i class="icon-cogs"></i>Sub Menu's</div>
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
											<th>Parent Name</th>
											<th>Menu Name</th>
											<th>&nbsp;</th>
											<th align="right">Action</th>
										</tr>
									</thead>
									<tbody>
									<?php
									$sno = 0;
									$res_mainmenu=mysql_query("select name,sno from heading order by position asc");
									while($row_mainmenu=mysql_fetch_array($res_mainmenu))
									{
										$sno=$sno+1;
									?>										
										<tr>
											<td><?php echo $sno; ?></td>
											<td><b><?php echo $row_mainmenu['name'];?></b></td>
											<td colspan="3">
											<table border="0" width="100%" cellpadding="2" id="table1">
											<?php
												$count=0;
												$res_submenu=mysql_query("select sno,heading,subhead,otherurl,target,status from sub_heading where heading='$row_mainmenu[sno]' order by position asc");
												while($row_submenu=mysql_fetch_array($res_submenu))
												{
													$count++;
													
											?>
												<tr>
													<td><?php echo "<b>".$count.".</b>  ".$row_submenu['subhead'];?></td>
													<td width="36">
													<a href="sub-menu.php?action=<?php echo $row_submenu['status']?>&sno=<?php echo $row_submenu['sno']?>&log=<?php echo $_SESSION['capture_code'];?>">
													<?php
													if($row_submenu['status']=='active')
													{
														echo "<img border=0 src='images/on.gif' alt=Active>";
													}
													else
													{
														echo "<img border=0 src='images/off.gif' alt=Inactive>";
													}
													?>
													</a></td>
													<td width="19">
													<a href="sub-menu.php?sno=<?php echo $row_submenu['sno'];?>&action=<?php echo 'edit_heading'?>&log=<?php echo $_SESSION['capture_code'];?>">
													<img border="0" src="images/edit.png" width="20" height="20" alt="Edit" name="Edit"></a></td>
													<td width="18"><input type="image" img border="0" src="images/delete.png" width="20" height="20" onclick="var a=confirm('Are You sure delete this record from database ?');if(a==true){location.href='sub-menu.php?sno=<?php echo $row_submenu['sno']?>&action=<?php echo 'delete_heading'?>&log=<?php echo $_SESSION['capture_code'];?>';}" alt="Delete" name="delete"></td>
												</tr>
											<?php
												}
											?>
											</table>
											</td>
											
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
								<div class="caption"><i class="icon-reorder"></i>Add New Menu</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<!--a href="#portlet-config" data-toggle="modal" class="config"></a-->
									<a href="javascript:;" class="reload"></a>
									<!--a href="javascript:;" class="remove"></a-->
								</div>
							</div>
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
								<form action="sub-menu.php?action=category" id="form_main_menu" class="form-horizontal" method="post">
									<div class="alert alert-error hide">
										<button class="close" data-dismiss="alert"></button>
										You have some form errors. Please check below.
									</div>
									<div class="alert alert-success hide">
										<button class="close" data-dismiss="alert"></button>
										Your form validation is successful!
									</div>
									<div class="control-group">
										<label class="control-label">Select Parent Category<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="parent" size="1">
												<option value="">Select...</option>
												<?php
													$res_main=mysql_query("select name,sno from heading where status='active'");
													while($row_main=mysql_fetch_array($res_main))
													{
												?>
													<option value="<?php echo $row_main['sno'];?>"><?php echo $row_main['name'];?></option>
												<?php
													}
												?>
											</select>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Display in Which Website?<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="website_type">
												<option value="english" selected>English</option>
												<option value="hindi">Hindi</option>
											</select>
										</div>
									</div>

									<div class="control-group">
										<label class="control-label">Menu Name<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="txtheading" data-required="1" class="span6 m-wrap"/>
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
										<label class="control-label">SEO URL&nbsp;&nbsp;</label>
										<div class="controls">
											<input name="seo_url" type="text" class="span6 m-wrap"/>
											<span class="help-block">e.g: about-us - optional field</span>
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
										<input type="hidden" value="<?php echo $_SESSION['capture_code'];?>" name="log">
										<input type="hidden" name="flag" size="20" value="1">
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
		$menuid=preg_replace('/[^0-9]/', '', trim($_GET['sno']));
		$query=mysql_query("select * from sub_heading where sno='$menuid'") or die(mysql_error());
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
			
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid">
				<!-- BEGIN PAGE HEADER-->   
				<div class="row-fluid">
					<div class="span12">
						     
						<h3 class="page-title">
							Website Sub Menu
							<small>Add Website Sub Menu</small>
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="mainmenu.php">Home</a> 
								<span class="icon-angle-right"></span>
							</li>
							<li>
								<a href="sub-menu.php">Menu Master's</a>
								<span class="icon-angle-right"></span>
							</li>
							<li><a href="#">Edit Sub Menu's</a></li>
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
								<div class="caption"><i class="icon-reorder"></i>Edit 
									Sub Menu - <b>"<?php echo $row_mainmenu['subhead'];?>"</b></div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<!--a href="#portlet-config" data-toggle="modal" class="config"></a-->
									<a href="javascript:;" class="reload"></a>
									<!--a href="javascript:;" class="remove"></a-->
								</div>
							</div>
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
								<form action="sub-menu.php" id="form_main_menu" class="form-horizontal" method="post">									
									<div class="control-group">
										<label class="control-label">Select 
										Parent Category<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="parent" size="1">
												<option value="">Select...</option>
												<?php
													$res_main=mysql_query("select name,sno from heading where status='active'");
													while($row_main=mysql_fetch_array($res_main))
													{
												?>
													<option value="<?php echo $row_main['sno'];?>" <?php if($row_mainmenu['heading']==$row_main['sno']) { echo 'selected';}?>><?php echo $row_main['name'];?></option>
												<?php
													}
												?>
											</select>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Display in Which Website?<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="website_type">
												<option value="english" <?php if($row_mainmenu['websitetype']=="english") { echo 'selected'; } ?>>English</option>
												<option value="hindi" <?php if($row_mainmenu['websitetype']=="hindi") { echo 'selected'; } ?>>Hindi</option>
											</select>
										</div>
									</div>

									<div class="control-group">
										<label class="control-label">Menu Name<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="txtheading" value="<?php echo $row_mainmenu['subhead'];?>" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>								
									
									<div class="control-group">
										<label class="control-label">URL&nbsp;&nbsp;</label>
										<div class="controls">
											<input name="url" value="<?php echo $row_mainmenu['otherurl'];?>" type="text" class="span6 m-wrap"/>
											<span class="help-block">e.g: http://www.demo.com or http://demo.com - optional field</span>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">SEO URL&nbsp;&nbsp;</label>
										<div class="controls">
											<input name="seo_url" value="<?php echo $row_mainmenu['seo_url'];?>" type="text" class="span6 m-wrap"/>
											<span class="help-block">e.g: about-us - optional field</span>
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
											<input name="txtposition" type="text" value="<?php echo $row_mainmenu['position'];?>" class="span6 m-wrap"/>
										</div>
									</div>									
									
									<div class="form-actions">
										<button type="submit" class="btn purple">Save</button>
										<button type="button" class="btn">Cancel</button>
										<input type="hidden" name="action" size="20" value="edit1">
										<input type="hidden" value="<?php echo $_SESSION['capture_code'];?>" name="log">
										<input type="hidden" name="sno" size="20" value="<?php echo $menuid; ?>">
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
