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


if($_GET['action']=="details")
{
  view_details();
  exit;
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='active')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		
		$query="update fire_user set status='inactive' where ser='$unid_id'";
		$rs=mysql_query($query);
		
		if($rs)
		{
			echo "<script>location.href='kml-registration.php?display=status'</script>";	
		}
		else
		{
			echo "<script>location.href='kml-registration.php?error=incorrect'</script>";	
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='kml-registration.php?status=codeinvalid'</script>";
	}
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='inactive')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		
		$query="update fire_user set status='active' where ser='$unid_id'";
		$rs=mysql_query($query);
	
		if($rs)
		{
			echo "<script>location.href='kml-registration.php?display=update'</script>";	
		}
		else
		{
			echo "<script>location.href='kml-registration.php?error=incorrect'</script>";	
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='kml-registration.php?status=codeinvalid'</script>";
	}
}

if(isset($_POST['flag']) && !empty($_POST['flag']) && $_POST['flag']==1)
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_POST['log']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		
		$sql1="select ser from fire_user where email='$_POST[email]'";
		$cou=mysql_num_rows(mysql_query($sql1));
		
		if($cou==0)
		{
			$mdpwd=md5($_POST['kmlpassword']);

			$sql="insert into fire_user set state = '$_POST[txtstate]', feedbacklink = '$_POST[yesno]' ,username = '".filter_xss($_POST['username'])."', password = '$_POST[kmlpassword]', email = '$_POST[email]', enctypepwd = '$mdpwd',status = 'active', crdate = '$crdate'";
			
			$rs = mysql_query($sql);
			if($rs)
			{
				echo "<script>location.href='kml-registration.php?display=add'</script>";
			}
		}
		else
		{
			echo "<script>alert('User Name Already Exists in Database. Please choose another User Name.');location.href='kml-registration.php';</script>";
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='kml-registration.php?status=codeinvalid'</script>";
	}
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='delete_heading')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		
	    $rs = mysql_query("delete from fire_user where ser='$unid_id'");    
		if($rs)
		{
			echo "<script>location.href='kml-registration.php?display=delete'</script>";
		}
		else
		{
			echo "<script>location.href='kml-registration.php?error=incorrect'</script>";
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='kml-registration.php?status=codeinvalid'</script>";
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
	
		$mdpwd=md5($_POST['password']);

		$sql = "update fire_user set state='$_POST[txtstate]',feedbacklink='$_POST[yesno]',username='$_POST[username]',password='$_POST[kmlpassword]',email='$_POST[email]',enctypepwd='$mdpwd' where ser='$unid_id'";
		$rs = mysql_query($sql);
		
		if($rs)
		{
			echo "<script>location.href='kml-registration.php?display=update'</script>";
		}
		else
		{
			echo "<script>location.href='kml-registration.php?error=incorrect'</script>";
		}
	}	
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='kml-registration.php?status=codeinvalid'</script>";
	}
}


function view()
{

	$tbl_name="fire_user";		//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = 3;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	$query = "SELECT COUNT(*) as num FROM $tbl_name";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages['num'];
	//$total_pages=$max;
	/* Setup vars for query. */
	$targetpage = "kml-registration.php"; 	//your file name  (the name of this file)
	$limit = 50; 								//how many items to show per page
	$page = 0;
	if(isset($_GET['page']))	
	{						//how many items to show per page
		$pages = preg_replace('/[^0-9]/', '', trim($_GET['page']));
		$page = $pages;	
	}
	if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0
	/* Get data. */
	
	$sql = "select * from $tbl_name order by state LIMIT $start, $limit";
	$result=mysql_query($sql);
	/* Setup page vars for display. */
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		//previous button
		if ($page > 1) 
			$pagination.= "<a href=\"$targetpage?page=$prev\"><< previous</a>";
		else
			$pagination.= "<span class=\"disabled\"><< previous</span>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a href=\"$targetpage?page=$next\">next >></a>";
		else
			$pagination.= "<span class=\"disabled\">next >></span>";
		$pagination.= "</div>\n";		
	}
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
							KML Registration
							<small>Add New User</small>
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
							<li><a href="#">Manage Registration</a></li>
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
								<div class="caption"><i class="icon-cogs"></i>Manage Registration</div>
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
											<th>State</th>
											<th>Username</th>
											<th>Password</th>
											<th>Status</th>
											<th colspan="2">Action</th>
										</tr>
									</thead>
									<tbody>
									<?php
									$sno=$start;
									
									while($row_mainmenu=mysql_fetch_array($result))
									{
										$sno=$sno+1;
									?>
										<tr>
											<td><?php echo $sno; ?></td>
											<td><?php
											$state="select name from state_master where sno='$row_mainmenu[state]'";
											$row_state=mysql_fetch_array(mysql_query($state));
											echo $row_state['name'];
											?>
											</td>
											<td><?php echo $row_mainmenu['username'];
											echo "<br/><strong>Feedback Link: </strong>".$row_mainmenu['feedbacklink'];
											?></td>
											<td><?php echo $row_mainmenu['password'];?></td>
											<td>
											<a href="kml-registration.php?action=<?php echo $row_mainmenu['status']?>&sno=<?php echo $row_mainmenu['sno']?>&log=<?php echo $_SESSION['capture_code'];?>">
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
											<td width="15">
											<a href="kml-registration.php?sno=<?php echo $row_mainmenu['ser'];?>&action=<?php echo 'edit_heading'?>&log=<?php echo $_SESSION['capture_code'];?>">
											<img border="0" src="images/edit.png" width="20" height="20" alt="Edit" name="Edit"></a></td>
											<td width="15"><input type="image" img border="0" src="images/delete.png" width="20" height="20" onclick="var a=confirm('Are You sure delete this record from database ?');if(a==true){location.href='kml-registration.php?sno=<?php echo $row_mainmenu['ser']?>&action=<?php echo 'delete_heading'?>&log=<?php echo $_SESSION['capture_code'];?>';}" alt="Delete" name="delete"></td>										   
										</tr>
										<?php
										}
										?>
									</tbody>
								</table>
								<table align="left">
						<tr>
						<td>
							<div class="pagination">
					        <?=$pagination?>
					        </div> 
						
						</td>
						</tr>
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
								<div class="caption"><i class="icon-reorder"></i>Add New Member</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<!--a href="#portlet-config" data-toggle="modal" class="config"></a-->
									<a href="javascript:;" class="reload"></a>
									<!--a href="javascript:;" class="remove"></a-->
								</div>
							</div>
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
								<form action="kml-registration.php?action=category"  enctype="multipart/form-data" id="form_main_menu" class="form-horizontal" method="post" autocomplete="off" onsubmit="return Validateform(this)">
									<div class="alert alert-error hide">
										<button class="close" data-dismiss="alert"></button>
										You have some form errors. Please check below.
									</div>
									<div class="alert alert-success hide">
										<button class="close" data-dismiss="alert"></button>
										Your form validation is successful!
									</div>	
									<div class="control-group">
										<label class="control-label">State<span class="required"></span></label>
										<div class="controls">
										<select class="span6 m-wrap" name="txtstate" size="1" required>
											<option value="">-- Select State --</option>											
											<?php
											$state=mysql_query("select name,sno from state_master where status='active' order by name");
											while($row_state=mysql_fetch_array($state))
											{
											?>
											<option value="<?php echo $row_state['sno'];?>"><?php echo $row_state['name'];?></option>
											<?php
											}
											?>
											</select>										
										</div>
									</div>
								<div class="control-group">
										<label class="control-label">Whether to Send Feedback Link?<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="yesno">
												<option value="yes">Yes</option>
												<option value="no">no</option>
											</select>
										</div>
									</div>

									<div class="control-group">
										<label class="control-label">User Name<span class="required">*</span></label>
										<div class="controls">
											<input type="text" required name="username" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Password<span class="required">*</span></label>
										<div class="controls">
											<input type="password" required name="kmlpassword" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Email ID<span class="required">*</span></label>
										<div class="controls">
											<input type="email" required name="email" data-required="1" class="span6 m-wrap"/>
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
	if(isset($_GET['sno']) && !empty($_GET['sno']))
	{	
		$menuid=preg_replace('/[^0-9]/', '', trim($_GET['sno']));
		$query=mysql_query("select * from  fire_user where ser='$menuid'");
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
							KML Registration
							<small>Add New User</small>
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
							<li><a href="#">Manage Registration</a></li>
						</ul>
					</div>
				</div>				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->	
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN SAMPLE TABLE PORTLET-->
					<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN VALIDATION STATES-->
						<div class="portlet box purple">
							<div class="portlet-title">
								<div class="caption"><i class="icon-reorder"></i>Edit KML Registration - <b>"<?php echo $row_mainmenu['username'];?>"</b></div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<!--a href="#portlet-config" data-toggle="modal" class="config"></a-->
									<a href="javascript:;" class="reload"></a>
									<!--a href="javascript:;" class="remove"></a-->
								</div>
							</div>
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
								<form action="kml-registration.php"  enctype="multipart/form-data"  id="form_main_menu" class="form-horizontal" method="post" autocomplete="off" onsubmit="return Validateform(this)">					
									
									<div class="control-group">
										<label class="control-label">State<span class="required"></span></label>
										<div class="controls">
										<select class="span6 m-wrap" required name="txtstate" size="1">
											<option value="">-- Select State --</option>											
											<?php
											$state=mysql_query("select name,sno from state_master where status='active' order by name");
											while($row_state=mysql_fetch_array($state))
											{
											?>
											<option value="<?php echo $row_state['sno'];?>" <?php if( $row_mainmenu['state']==$row_state['sno']) { echo 'selected'; }?>><?php echo $row_state['name'];?></option>
											<?php
											}
											?>
											</select>										
										</div>
									</div>
								<div class="control-group">
										<label class="control-label">Whether to Send Feedback Link?<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="yesno">
												<option value="yes" <?php if($row_mainmenu['feedbacklink']=='yes') { echo 'selected'; } ?>>Yes</option>
												<option value="no" <?php if($row_mainmenu['feedbacklink']=='no') { echo 'selected'; } ?>>no</option>
											</select>
										</div>
									</div>

									<div class="control-group">
										<label class="control-label">User Name<span class="required">*</span></label>
										<div class="controls">
											<input type="text" required name="username" value="<?php echo $row_mainmenu['username'];?>" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Password<span class="required">*</span></label>
										<div class="controls">
											<input type="password" required value="<?php echo $row_mainmenu['password'];?>" name="kmlpassword" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Email ID<span class="required">*</span></label>
										<div class="controls">
											<input type="email" required value="<?php echo $row_mainmenu['email'];?>" name="email" data-required="1" class="span6 m-wrap"/>
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
	
	}
	function view_details()
    {
	if(isset($_GET['id']) && !empty($_GET['id']))
	{	
		$menuid=preg_replace('/[^0-9]/', '', trim($_GET['id']));		
		$query=mysql_query("select * from  registration where sno='$menuid'");
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
							KML Registration
							<small>Add New User</small>
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
							<li><a href="#">Manage Registration</a></li>
						</ul>
					</div>
				</div>				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->          
				<div class="row-fluid">
					<div class="span12">
						
						<!-- BEGIN SAMPLE TABLE PORTLET-->
						<div class="portlet box green">
							<div class="portlet-title">
								<div class="caption"><i class="icon-cogs"></i>KML Registration Details</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="#portlet-config" data-toggle="modal" class="config"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body flip-scroll">								
								<div class="control-group">
										<label class="control-label">User Name&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['username'];?></b> 
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">Email ID&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['email'];?></b> 
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">Password&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['password'];?></b> 
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">Designation &nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['designation'];?></b> 
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">
										Organization Name&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['organization'];?></b> 
										</div>
								</div>
								<hr size="1">
								<div class="control-group">
										<label class="control-label">Address&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['address'];?></b> 
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">State.&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['state'];?></b> 
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">District 1&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['district1'];?></b> 
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">District 2&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['district2'];?></b> 
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">District 3&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['district3'];?></b> 
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">District 4&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['district4'];?></b> 
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">Country&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['country'];?> </b>
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">Pin Code&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['pin'];?> </b>
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">Office Phone&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['phone'];?> </b>
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">Mobile&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['mobile'];?></b> 
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">alert&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php 											
												echo $row_content['alert'];											
											?> </b>
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">Zero Alert.&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['zeroalert'];?> </b>
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">Create Date .&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo date("d-m-Y",strtotime($row_content['crdate']));?></b> 
										</div>
								</div>								
							</div>
						</div>
						<!-- END SAMPLE TABLE PORTLET-->
						<!-- BEGIN SAMPLE TABLE PORTLET-->
						
						<!-- END SAMPLE TABLE PORTLET-->
					</div>
				</div>
				<!-- END PAGE CONTENT-->
			</div>
			<!-- END PAGE CONTAINER-->
		</div>
		<!-- END PAGE -->
	</div>
	<!-- END CONTAINER -->
	<!-- BEGIN FOOTER -->
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