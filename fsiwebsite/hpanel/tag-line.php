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
	$query="update tag_line set status='inactive' where sno='$_GET[sno]'";
	$rs=mysql_query($query);
	
	if($rs)
	{
		echo "<script>location.href='tag-line.php?display=status'</script>";	
	}
	else
	{
		echo "<script>location.href='tag-line.php?error=incorrect'</script>";	
	}
}

if($_GET['action']=='inactive')
{

	$query="update tag_line set status='active' where sno='$_GET[sno]'";
	$rs=mysql_query($query);

	if($rs)
	{
		echo "<script>location.href='tag-line.php?display=update'</script>";	
	}
	else
	{
		echo "<script>location.href='tag-line.php?error=incorrect'</script>";	
	}
}

if($_GET['action']=='yes')
{
	$query="update tag_line set home='no' where sno='$_GET[sno]'";
	$rs=mysql_query($query);
	
	if($rs)
	{
		echo "<script>location.href='tag-line.php?display=update'</script>";	
	}
	else
	{
		echo "<script>location.href='tag-line.php?error=incorrect'</script>";	
	}
}

if($_GET['action']=='no')
{
	$query="update tag_line set home='yes' where sno='$_GET[sno]'";
	$rs=mysql_query($query);
	
	if($rs)
	{
		echo "<script>location.href='tag-line.php?display=update'</script>";	
	}
	else
	{
		echo "<script>location.href='tag-line.php?error=incorrect'</script>";	
	}	
}

if($_POST['flag']==1)
{

	$query="insert into tag_line(name,description,width,status,position,otherurl,home,target) values('$_POST[txttag_line]','$_POST[description]','$_POST[width]','active','$_POST[txtposition]','$_POST[url]','$_POST[home]','$_POST[target]')";

	$rs=mysql_query($query);
	if($rs)
	{
		echo "<script>location.href='tag-line.php?display=add'</script>";
	}
	else
	{
		echo "<script>location.href='tag-line.php?error=incorrect'</script>";
	}
}

if($_GET['action']=='delete_tag_line')
{
	$query="delete from tag_line where sno='$_GET[sno]'";
	$rs=mysql_query($query);
	
	if($rs)
	{
		echo "<script>location.href='tag-line.php?display=delete'</script>";
	}
	else
	{
		echo "<script>location.href='tag-line.php?error=incorrect'</script>";
	}
}

if($_GET['action']=='edit_tag_line')
{
	edit();
	exit;
}

if($_POST['action']=='edit1')
{

	$query="update tag_line set name='$_POST[txttag_line]',description = '$_POST[description]', width='$_POST[width]',otherurl='$_POST[url]',target='$_POST[target]',home='$_POST[home]', position='$_POST[txtposition]' where sno='$_POST[sno]'";

	$rs=mysql_query($query);

	if($rs)
	{
		echo "<script>location.href='tag-line.php?display=update'</script>";
	}
	else
	{
		echo "<script>location.href='tag-line.php?error=incorrect'</script>";
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
							Website Tag Line
							<small>Add Website Tag Line</small>
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
							<li><a href="#">Manage Tag Line</a></li>
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
								<div class="caption"><i class="icon-cogs"></i>Tag Line</div>
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
											<th>Tag Line</th>
											<th>Website Position</th>
											<th class="hidden-480">URL</th>
											<th>Status</th>
											<th colspan="2">Action</th>
										</tr>
									</thead>
									<tbody>
									<?php
									$res_mainmenu=mysql_query("select * from tag_line order by position asc");
									while($row_mainmenu=mysql_fetch_array($res_mainmenu))
									{
										$sno=$sno+1;
									?>
										<tr>
											<td><?php echo $sno; ?></td>
											<td><?php echo $row_mainmenu['name'];?></td>
											<td><?php echo $row_mainmenu['position'];?></td>
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
											<a href="tag-line.php?action=<?php echo $row_mainmenu['status']?>&sno=<?php echo $row_mainmenu['sno']?>">
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
											<a href="tag-line.php?sno=<?php echo $row_mainmenu['sno'];?>&action=<?php echo 'edit_tag_line'?>">
											<img border="0" src="images/edit.png" width="20" height="20" alt="Edit" name="Edit"></a></td>
											<td><input type="image" img border="0" src="images/delete.png" width="20" height="20" onclick="var a=confirm('Are You sure delete this record from database ?');if(a==true){location.href='tag-line.php?sno=<?php echo $row_mainmenu[sno]?>&action=<?php echo 'delete_tag_line'?>';}" alt="Delete" name="delete"></td>
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
								<div class="caption"><i class="icon-reorder"></i>Add New Tag Line</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<!--a href="#portlet-config" data-toggle="modal" class="config"></a-->
									<a href="javascript:;" class="reload"></a>
									<!--a href="javascript:;" class="remove"></a-->
								</div>
							</div>
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
								<form action="tag-line.php?action=category" id="form_main_menu" class="form-horizontal" method="post">
									<div class="alert alert-error hide">
										<button class="close" data-dismiss="alert"></button>
										You have some form errors. Please check below.
									</div>
									<div class="alert alert-success hide">
										<button class="close" data-dismiss="alert"></button>
										Your form validation is successful!
									</div>
									
									<div class="control-group">
										<label class="control-label">Tag Line<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="txttag_line" data-required="1" class="span6 m-wrap"/>
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
											<input name="txtposition" type="text" class="span6 m-wrap"/>
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
		$query=mysql_query("select * from tag_line where sno='$menuid'");
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
							Website Tag Line
							<small>Add Website Tag Line</small>
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
							<li><a href="#">Manage Tag Line</a></li>
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
								<div class="caption"><i class="icon-reorder"></i>Edit Tag Line - <b>"<?php echo $row_mainmenu['name'];?>"</b></div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<!--a href="#portlet-config" data-toggle="modal" class="config"></a-->
									<a href="javascript:;" class="reload"></a>
									<!--a href="javascript:;" class="remove"></a-->
								</div>
							</div>
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
								<form action="tag-line.php" id="form_main_menu" class="form-horizontal" method="post">									
									<div class="control-group">
										<label class="control-label">Tag Line<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="txttag_line" value="<?php echo $row_mainmenu['name'];?>" data-required="1" class="span6 m-wrap"/>
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
		echo "<script>location.href='tag-line.php';</script>";
	}
}
?>