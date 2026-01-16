<?php
	include_once "includes/constant.php";
	include_once "control.php";
	
if(!isset($_REQUEST['action']))
{
	$action='';
	view();
	exit;
}

if(!isset($flag))
{
	$flag='';
}

if($_GET['action']=='active')
{
	$query="update prod_manufacturer set status='inactive' where sno='$_GET[sno]'";
	$rs=mysql_query($query);
	
	if($rs)
	{
		echo "<script>location.href='manufacturer.php?display=status'</script>";	
	}
	else
	{
		echo "<script>location.href='manufacturer.php?error=incorrect'</script>";	
	}
}

if($_GET['action']=='inactive')
{

	$query="update prod_manufacturer set status='active' where sno='$_GET[sno]'";
	$rs=mysql_query($query);

	if($rs)
	{
		echo "<script>location.href='manufacturer.php?display=update'</script>";	
	}
	else
	{
		echo "<script>location.href='manufacturer.php?error=incorrect'</script>";	
	}
}

if($_GET['action']=='yes')
{
	$query="update prod_manufacturer set home='no' where sno='$_GET[sno]'";
	$rs=mysql_query($query);
	
	if($rs)
	{
		echo "<script>location.href='manufacturer.php?display=update'</script>";	
	}
	else
	{
		echo "<script>location.href='manufacturer.php?error=incorrect'</script>";	
	}
}

if($_GET['action']=='no')
{
	$query="update prod_manufacturer set home='yes' where sno='$_GET[sno]'";
	$rs=mysql_query($query);
	
	if($rs)
	{
		echo "<script>location.href='manufacturer.php?display=update'</script>";	
	}
	else
	{
		echo "<script>location.href='manufacturer.php?error=incorrect'</script>";	
	}	
}

if($_POST['flag']==1)
{

	$query="insert into prod_manufacturer(name,status,otherurl,target) values('$_POST[name]','active','$_POST[url]','$_POST[target]')";

	$rs=mysql_query($query);
	if($rs)
	{
		echo "<script>location.href='manufacturer.php?display=add'</script>";
	}
	else
	{
		echo "<script>location.href='manufacturer.php?error=incorrect'</script>";
	}
}

if($_GET['action']=='delete_prod_manufacturer')
{
	$query="delete from prod_manufacturer where sno='$_GET[sno]'";
	$rs=mysql_query($query);
	
	if($rs)
	{
		echo "<script>location.href='manufacturer.php?display=delete'</script>";
	}
	else
	{
		echo "<script>location.href='manufacturer.php?error=incorrect'</script>";
	}
}

if($_GET['action']=='edit_prod_manufacturer')
{
	edit();
	exit;
}

if($_POST['action']=='edit1')
{

	$query="update prod_manufacturer set name='$_POST[name]',otherurl='$_POST[url]',target='$_POST[target]' where sno='$_POST[sno]'";

	$rs=mysql_query($query);

	if($rs)
	{
		echo "<script>location.href='manufacturer.php?display=update'</script>";
	}
	else
	{
		echo "<script>location.href='manufacturer.php?error=incorrect'</script>";
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
							Product Manufacturers
							<small>Add Manufacturers</small>
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="mainmenu.php">Home</a> 
								<span class="icon-angle-right"></span>
							</li>
							<li>
								<a href="#">Products & Orders</a>
								<span class="icon-angle-right"></span>
							</li>
							<li><a href="#">Manage Manufacturers</a></li>
						</ul>
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->			
				
				
				
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN SAMPLE TABLE PORTLET-->
						<?php
					     if(isset($_GET['error']) && !empty($_GET['error']) && $_GET['error']=='incorrect')
					     {
					    ?>
						<div class="alert alert-error">
							<button class="close" data-dismiss="alert"></button>
							Some Error Occurred. Please try again!!
						</div>
						<?php
						}
					     if(isset($_GET['display']) && !empty($_GET['display']))
					     {					     
						?>
						<div class="alert alert-success">
							<button class="close" data-dismiss="alert"></button>
						<?php
							 if($_GET['display']=='add')
					        {
					        	echo "Record Saved Successfully..";
					        }
					        if($_GET['display']=='update')
					     	{
					     		echo "Record Updated Successfully..";
					     	}
					     	if($_GET['display']=='delete')
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
								<div class="caption"><i class="icon-cogs"></i>Main Menu's</div>
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
											<th>Manufacturer Name</th>
											<th class="hidden-480">Website URL</th>
											<th>Status</th>
											<th colspan="2">Action</th>
										</tr>
									</thead>
									<tbody>
									<?php
									$res_mainmenu=mysql_query("select * from prod_manufacturer order by sno");
									while($row_mainmenu=mysql_fetch_array($res_mainmenu))
									{
										$sno=$sno+1;
									?>
										<tr>
											<td><?php echo $sno; ?></td>
											<td><?php echo $row_mainmenu['name'];?></td>
											<td class="hidden-480">
											<?php 
											if($row_mainmenu['otherurl']!='')
												echo $row_mainmenu['otherurl'];
											else if($row_mainmenu['home']=='no')
												echo "details.php?pgID=mn_".$row_mainmenu['sno'];
											else
												echo "N.A.";
												
											?>
											</td>
											<td>
											<a href="manufacturer.php?action=<?php echo $row_mainmenu['status']?>&sno=<?php echo $row_mainmenu['sno']?>">
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
											<a href="manufacturer.php?sno=<?php echo $row_mainmenu['sno'];?>&action=<?php echo 'edit_prod_manufacturer'?>">
											<img border="0" src="images/edit.png" width="20" height="20" alt="Edit" name="Edit"></a></td>
											<td><input type="image" img border="0" src="images/delete.png" width="20" height="20" onclick="var a=confirm('Are You sure delete this record from database ?');if(a==true){location.href='manufacturer.php?sno=<?php echo $row_mainmenu[sno]?>&action=<?php echo 'delete_prod_manufacturer'?>';}" alt="Delete" name="delete"></td>
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
								<form action="manufacturer.php?action=category" id="form_main_menu" class="form-horizontal" method="post">
									<div class="alert alert-error hide">
										<button class="close" data-dismiss="alert"></button>
										You have some form errors. Please check below.
									</div>
									<div class="alert alert-success hide">
										<button class="close" data-dismiss="alert"></button>
										Your form validation is successful!
									</div>
									
									<div class="control-group">
										<label class="control-label">Manufacturer Name<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="name" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>								
									
									<div class="control-group">
										<label class="control-label">Website URL&nbsp;&nbsp;</label>
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
									
									<div class="form-actions">
										<button type="submit" class="btn purple">Save</button>
										<button type="button" class="btn">Cancel</button>
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
	if(isset($_GET['sno']) && !empty($_GET['sno']))
	{	
		$menuid=preg_replace('/[^0-9]/', '', trim($_GET['sno']));
		$query=mysql_query("select * from prod_manufacturer where sno='$menuid'");
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
			
			<!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid">
				<!-- BEGIN PAGE HEADER-->   
				<div class="row-fluid">
					<div class="span12">
						     
						<h3 class="page-title">
							Product Manufacturers
							<small>Add Manufacturers</small>
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="mainmenu.php">Home</a> 
								<span class="icon-angle-right"></span>
							</li>
							<li>
								<a href="#">Products & Orders</a>
								<span class="icon-angle-right"></span>
							</li>
							<li><a href="#">Manage Manufacturers</a></li>
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
									Manufacturer - <b>"<?php echo $row_mainmenu['name'];?>"</b></div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<!--a href="#portlet-config" data-toggle="modal" class="config"></a-->
									<a href="javascript:;" class="reload"></a>
									<!--a href="javascript:;" class="remove"></a-->
								</div>
							</div>
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
								<form action="manufacturer.php" id="form_main_menu" class="form-horizontal" method="post">									
									
									<div class="control-group">
										<label class="control-label">Manufacturer Name<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="name" value="<?php echo $row_mainmenu['name'];?>" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>								
									
									<div class="control-group">
										<label class="control-label">Website URL&nbsp;&nbsp;</label>
										<div class="controls">
											<input name="url" value="<?php echo $row_mainmenu['otherurl'];?>" type="text" class="span6 m-wrap"/>
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
																	
									
									<div class="form-actions">
										<button type="submit" class="btn purple">Save</button>
										<button type="button" class="btn">Cancel</button>
										<input type="hidden" name="action" size="20" value="edit1">
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
	else
	{
		echo "<script>location.href='manufacturer.php';</script>";
	}
}
?>