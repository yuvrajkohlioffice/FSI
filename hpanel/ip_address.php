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
		
		$query="update ip_address set status='inactive' where sno='$unid_id'";
		$rs=mysql_query($query);
			$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 15, 6); 
	$_SESSION['capture_code']=$security_code;
		if($rs)
		{
			echo "<script>location.href='ip_address.php?display=status'</script>";	
		}
		else
		{
			echo "<script>location.href='ip_address.php?error=incorrect'</script>";	
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='ip_address.php?status=codeinvalid'</script>";
	}
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='inactive')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));
	
	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
	
		$query="update ip_address set status='active' where sno='$unid_id'";
		$rs=mysql_query($query);
		$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 15, 6); 
	$_SESSION['capture_code']=$security_code;
		if($rs)
		{
			echo "<script>location.href='ip_address.php?display=update'</script>";	
		}
		else
		{
			echo "<script>location.href='ip_address.php?error=incorrect'</script>";	
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='ip_address.php?status=codeinvalid'</script>";
	}
}

if(isset($_POST['flag']) && !empty($_POST['flag']) && $_POST['flag']==1)
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_POST['log']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{

		$query="insert into ip_address set ip_address='".filter_xss($_POST['ip'])."',status='active', crdate='$today_date'";
	
		$rs=mysql_query($query);
	$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 15, 6); 
	$_SESSION['capture_code']=$security_code;
		if($rs)
		{
			echo "<script>location.href='ip_address.php?display=add'</script>";
		}
		else
		{
			echo "<script>location.href='ip_address.php?error=incorrect'</script>";
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='ip_address.php?status=codeinvalid'</script>";
	}
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='delete_heading')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));
	
	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{

		$query="delete from ip_address where sno='$unid_id'";
		$rs=mysql_query($query);
			$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 15, 6); 
	$_SESSION['capture_code']=$security_code;
		if($rs)
		{
			echo "<script>location.href='ip_address.php?display=delete'</script>";
		}
		else
		{
			echo "<script>location.href='ip_address.php?error=incorrect'</script>";
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='ip_address.php?status=codeinvalid'</script>";
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

		$query="update ip_address set ip_address='".filter_xss($_POST['ip'])."' where sno='$unid_id'";
	
		$rs=mysql_query($query);
				$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 15, 6); 
	$_SESSION['capture_code']=$security_code;
		if($rs)
		{
			echo "<script>location.href='ip_address.php?display=update'</script>";
		}
		else
		{
			echo "<script>location.href='ip_address.php?error=incorrect'</script>";
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='ip_address.php?status=codeinvalid'</script>";
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
							Manage IP Address
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
							<li><a href="#">Manage IP Address</a></li>
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
								<div class="caption"><i class="icon-cogs"></i>IP Address's</div>
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
											<th>IP Address</th>
											<th>Status</th>
											<th colspan="2">Action</th>
										</tr>
									</thead>
									<tbody>
									<?php
									$sno = 0;
									$res_content=mysql_query("select * from ip_address order by sno");
									while($row_content=mysql_fetch_array($res_content))
									{
										$sno=$sno+1;
									?>
										<tr>
											<td><?php echo $sno; ?></td>
											<td><?php echo $row_content['ip_address'];?></td>
											<td>
											<a href="ip_address.php?action=<?php echo $row_content['status']?>&sno=<?php echo $row_content['sno']?>&log=<?php echo $_SESSION['capture_code'];?>">
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
											<a href="ip_address.php?sno=<?php echo $row_content['sno'];?>&action=<?php echo 'edit_heading'?>&log=<?php echo $_SESSION['capture_code'];?>">
											<img border="0" src="images/edit.gif" width="18" height="17" alt="Edit" name="Edit"></a></td>
											<td><input type="image" img border="0" src="images/delete.gif" width="18" height="17" onclick="var a=confirm('Are You sure delete this record from database ?');if(a==true){location.href='ip_address.php?sno=<?php echo $row_content['sno']?>&action=<?php echo 'delete_heading'?>&log=<?php echo $_SESSION['capture_code'];?>';}" alt="Delete" name="delete"></td>
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
								<form action="ip_address.php?action=category" id="form_main_menu" class="form-horizontal" method="post">
																		<div class="control-group">
										<label class="control-label">IP Address<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="ip" value="<?php echo $row_content['ip_address'];?>" data-required="1" class="span6 m-wrap"/>
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
		$query=mysql_query("select * from ip_address where sno='$contentid'");
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
			
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid">
				<!-- BEGIN PAGE HEADER-->   
				<div class="row-fluid">
					<div class="span12">
						     
						<h3 class="page-title">
							Manage IP Address
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
							<li><a href="#">Manage IP Address</a></li>
						</ul>					</div>
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
								<div class="caption"><i class="icon-reorder"></i>Edit IP Address - <b>"<?php echo $row_content['ip_address'];?>"</b></div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<!--a href="#portlet-config" data-toggle="modal" class="config"></a-->
									<a href="javascript:;" class="reload"></a>
									<!--a href="javascript:;" class="remove"></a-->
								</div>
							</div>
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
								<form action="ip_address.php" id="form_main_menu" class="form-horizontal" method="post">									
									
									<div class="control-group">
										<label class="control-label">IP Address<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="ip" value="<?php echo $row_content['ip_address'];?>" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>								
																	
									
									<div class="form-actions">
										<button type="submit" class="btn purple">Save</button>
										<button type="button" class="btn">Cancel</button>
										<input type="hidden" name="action" size="20" value="edit1">
										<input type="hidden" name="sno" size="20" value="<?php echo $contentid; ?>">
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
		echo "<script>location.href='ip_address.php';</script>";
	}
}
?>
