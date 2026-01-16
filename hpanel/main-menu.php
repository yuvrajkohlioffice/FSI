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

		$query="update heading set status='inactive' where sno='$unid_id'";
		$rs=mysql_query($query);
	
		$md5_hash = md5(rand(0,999)); 
		$security_code = substr($md5_hash, 16, 16); 
		$_SESSION['capture_code']=$security_code;

		if($rs)
		{
			echo "<script>location.href='main-menu.php?display=status'</script>";	
		}
		else
		{
			echo "<script>location.href='main-menu.php?error=incorrect'</script>";	
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='main-menu.php?status=codeinvalid'</script>";
	}
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='inactive')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
	
		$query="update heading set status='active' where sno='$unid_id'";
		$rs=mysql_query($query);
		
		$md5_hash = md5(rand(0,999)); 
		$security_code = substr($md5_hash, 16, 16); 
		$_SESSION['capture_code']=$security_code;

		if($rs)
		{
			echo "<script>location.href='main-menu.php?display=update'</script>";	
		}
		else
		{
			echo "<script>location.href='main-menu.php?error=incorrect'</script>";	
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='main-menu.php?status=codeinvalid'</script>";
	}
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='yes')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
	
		$query="update heading set home='no' where sno='$unid_id'";
		$rs=mysql_query($query);
			
		$md5_hash = md5(rand(0,999)); 
		$security_code = substr($md5_hash, 16, 16); 
		$_SESSION['capture_code']=$security_code;

		if($rs)
		{
			echo "<script>location.href='main-menu.php?display=update'</script>";	
		}
		else
		{
			echo "<script>location.href='main-menu.php?error=incorrect'</script>";	
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='main-menu.php?status=codeinvalid'</script>";
	}
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='no')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
	
		$query="update heading set home='yes' where sno='$unid_id'";
		$rs=mysql_query($query);
			
		$md5_hash = md5(rand(0,999)); 
		$security_code = substr($md5_hash, 16, 16); 
		$_SESSION['capture_code']=$security_code;

		if($rs)
		{
			echo "<script>location.href='main-menu.php?display=update'</script>";	
		}
		else
		{
			echo "<script>location.href='main-menu.php?error=incorrect'</script>";	
		}
	}	
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='main-menu.php?status=codeinvalid'</script>";
	}
}

if(isset($_POST['flag']) && !empty($_POST['flag']) && $_POST['flag']==1)
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_POST['log']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
    	$title = preg_replace('/[^a-zA-Z \-.]/', '', trim($_POST['txtheading']));
    	$menuid = preg_replace('/[^a-zA-Z \-.]/', '', trim($_POST['menu_id']));
    	$subHeading = preg_replace('/[^a-zA-Z \-.]/', '', trim($_POST['txt_subheading']));
		$seoURL = "";
		$position = preg_replace('/[^0-9]/', '', trim($_POST['txtposition']));
		$description = preg_replace('/[^a-zA-Z ]/', '', trim($_POST['description']));
		$width = preg_replace('/[^0-9]/', '', trim($_POST['width']));
		$height = preg_replace('/[^0-9]/', '', trim($_POST['height']));
		$position = preg_replace('/[^0-9]/', '', trim($_POST['txtposition']));
		$seoURL = preg_replace('/[^a-zA-Z0-9 \-]/', '', trim($_POST['seo_url']));
		$url = "";
		if (!filter_var($_POST['url'], FILTER_VALIDATE_URL) === false) {
			$url = filter_xss($_POST['url']);
		}
    	
    	/*$ran = rand(1,1000);
    	$size = $_FILES['txtbanner'][size];
    	$fname = "ico_".$ran."_".$_FILES['txtbanner'][name];
    	$source = $_FILES['txtbanner'][tmp_name];
    	
    	if( $size <= 0 )
    	{
    		$fname = "";
    	}
    	
    	$uploadedpath = "../uploads/images/icons/";	
    	$dest = $uploadedpath.$fname;*/
    	
    	$img_response = sh_upload_file("txtbanner", "image", "../uploads/images/icons/", "ico_".$ran);
		if($img_response)
		{
			$fname = $img_response;
		}
		else
		{
			$attacherror=1;
			$errormsg="Unable to Upload Image!";
		}
    
    	$query="insert into heading(name, mini_heading, class_id, websitetype, description, display_area, width, height, status, position, seo_url, otherurl, home, target, icon) values('$title', '$subHeading','$menuid', '$_POST[websitetype]', '$description', '$_POST[display_area]','$width', '$height', 'active', '$position', '$seoURL', '$url', '$_POST[home]', '$_POST[target]', '$fname')";
    
    	$rs=mysql_query($query);
    		
	$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 16, 16); 
	$_SESSION['capture_code']=$security_code;	

    	if($rs)
    	{
    		echo "<script>location.href='main-menu.php?display=add'</script>";
    	}
    	else
    	{
    		echo "<script>location.href='main-menu.php?error=incorrect'</script>";
    	}
    }
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='main-menu.php?status=codeinvalid'</script>";
	}
}


if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='delete_heading')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		$query="delete from heading where sno='$unid_id'";
		$rs=mysql_query($query);
			
		$md5_hash = md5(rand(0,999)); 
		$security_code = substr($md5_hash, 16, 16); 
		$_SESSION['capture_code']=$security_code;


		if($rs)
		{
			echo "<script>location.href='main-menu.php?display=delete'</script>";
		}
		else
		{
			echo "<script>location.href='main-menu.php?error=incorrect'</script>";
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='main-menu.php?status=codeinvalid'</script>";
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
    	/*$ran = rand(1,1000);
    	$size = $_FILES['txtbanner'][size];
    	$fname = "ico_".$ran."_".$_FILES['txtbanner'][name];
    	$source = $_FILES['txtbanner'][tmp_name];
    	
    	if( $size <= 0 )
    	{
    		$fname = "";
    	}
    	
    	$uploadedpath = "../uploads/images/icons/";	
    	$dest = $uploadedpath.$fname;*/
    	
    	$title = preg_replace('/[^a-zA-Z \-.]/', '', trim($_POST['txtheading']));
    	$menuid = preg_replace('/[^a-zA-Z \-.]/', '', trim($_POST['menu_id']));
    	$subHeading = preg_replace('/[^a-zA-Z \-.]/', '', trim($_POST['txt_subheading']));
		$seoURL = "";
		$position = preg_replace('/[^0-9]/', '', trim($_POST['txtposition']));
		$description = preg_replace('/[^a-zA-Z ]/', '', trim($_POST['description']));
		$width = preg_replace('/[^0-9]/', '', trim($_POST['width']));
		$height = preg_replace('/[^0-9]/', '', trim($_POST['height']));
		$position = preg_replace('/[^0-9]/', '', trim($_POST['txtposition']));
		$seoURL = preg_replace('/[^a-zA-Z0-9 \-]/', '', trim($_POST['seo_url']));
		$url = "";
		if (!filter_var($_POST['url'], FILTER_VALIDATE_URL) === false) {
			$url = filter_xss($_POST['url']);
		}
		
    	$update_query = "update heading set websitetype = '$_POST[websitetype]', name='$title', mini_heading = '$subHeading', class_id = '$menuid', description = '$description', display_area='$_POST[display_area]', width='$width',height = '$height', seo_url = '$seoURL', otherurl='$url',target='$_POST[target]',home='$_POST[home]', position='$position'";
    	if( $_FILES['txtbanner'][name] )
    	{
        	$img_response = sh_upload_file("txtbanner", "image", "../uploads/images/icons/", "ico_".$ran);
    		if($img_response)
    		{
    			$fname = $img_response;
    			$update_query .= ", icon = '$fname'";
    		}
    		else
    		{
    			$attacherror=1;
    			$errormsg="Unable to Upload Image!";
    		}
    	}
    	
    	$update_query .= "where sno='$unid_id'";
    
    	$rs = mysql_query( $update_query );
    	
	$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 16, 16); 
	$_SESSION['capture_code']=$security_code;

    	if($rs)
    	{
    		echo "<script>location.href='main-menu.php?display=update'</script>";
    	}
    	else
    	{
    		echo "<script>location.href='main-menu.php?error=incorrect'</script>";
    	}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='main-menu.php?status=codeinvalid'</script>";
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
<body class="page-header-fixed">
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
							Website Main Menu
							<small>Add Website Main Menu</small>
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
							<li><a href="#">Manage Main Menu's</a></li>
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
											<th>Display Website</th>
											<th>Menu Name</th>
											<th>Website Position</th>
											<th class="hidden-480">URL</th>
											<th>Show on Home Page</th>
											<th>Status</th>
											<th colspan="2">Action</th>
										</tr>
									</thead>
									<tbody>
									<?php
									$sno = 0;
									$res_mainmenu=mysql_query("select * from heading order by websitetype, position asc");
									while($row_mainmenu=mysql_fetch_array($res_mainmenu))
									{
										$sno=$sno+1;
									?>
										<tr>
											<td><?php echo $sno; ?></td>
											<td><?php echo ucwords($row_mainmenu['websitetype']); ?></td>
											<td>
											<?php echo $row_mainmenu['name'];
											?>
											<p style="font-size:8pt"><strong>Displaying in <?php 
											if($row_mainmenu['display_area']=="main")
												echo "Main Navigation";
											else if($row_mainmenu['display_area']=="bottom")
												echo "Bottom Menu";
											else if($row_mainmenu['display_area']=="leftbar")
												echo "Left Sidebar";
											else if($row_mainmenu['display_area']=="both")
												echo "In Both Area";
											else
												echo "Not Defined";	
												?></p></strong>
											</td>
											
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
											<a href="main-menu.php?action=<?php echo $row_mainmenu['home']?>&sno=<?php echo $row_mainmenu['sno']?>&log=<?php echo $_SESSION['capture_code'];?>">
											<?php
											if($row_mainmenu['home']=='yes')
											{
												echo "<img border=0 src='images/home.png' alt=Yes width='20' height='20'>";
											}
											else
											{
												echo "<img border=0 src='images/home1.jpg' alt=No width='20' height='20'>";
											}
											?>
											</a></td>
											<td>
											<a href="main-menu.php?action=<?php echo $row_mainmenu['status']?>&sno=<?php echo $row_mainmenu['sno']?>&log=<?php echo $_SESSION['capture_code'];?>">
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
											<a href="main-menu.php?sno=<?php echo $row_mainmenu['sno'];?>&action=<?php echo 'edit_heading'?>&log=<?php echo $_SESSION['capture_code'];?>">
											<img border="0" src="images/edit.png" width="20" height="20" alt="Edit" name="Edit"></a></td>
											<td><input type="image" img border="0" src="images/delete.png" width="20" height="20" onclick="var a=confirm('Are You sure delete this record from database ?');if(a==true){location.href='main-menu.php?sno=<?php echo $row_mainmenu['sno']?>&action=<?php echo 'delete_heading'?>&log=<?php echo $_SESSION['capture_code'];?>';}" alt="Delete" name="delete"></td>
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
								<form action="main-menu.php?action=category" id="form_main_menu" enctype="multipart/form-data" class="form-horizontal" method="post">
									<div class="alert alert-error hide">
										<button class="close" data-dismiss="alert"></button>
										You have some form errors. Please check below.
									</div>
									<div class="alert alert-success hide">
										<button class="close" data-dismiss="alert"></button>
										Your form validation is successful!
									</div>
									<div class="control-group">
										<label class="control-label">Show on Which Website?<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="websitetype">
												<option value="">Select...</option>
												<option value="english">English Website</option>
												<option value="hindi">Hindi Website</option>
											</select>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label">Display on Home Page<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="home">
												<option value="">Select...</option>
												<option value="yes">Yes</option>
												<option value="no">No</option>
											</select>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Show year Wise Data?<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="yearwisedata">
												<option value="">Select...</option>
												<option value="1">Yes</option>
												<option value="0">No</option>
											</select>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label">Display Area / Region<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="display_area">
												<option value="main" selected>Main Navigation</option>												
												<option value="top">Top Menu</option>
												<option value="quick">Quick Navigation</option>
												<option value="bottom">Bottom Menu</option>
												<option value="topbottom">Top & Bottom Both</option>
											</select>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Menu Name<span class="required">*</span></label>
										<div class="controls">
											<textarea name="txtheading" data-required="1" class="span6 m-wrap"/></textarea>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Sub Heading Name<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="txt_subheading" value="" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Menu ID<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="menu_id" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>	
									<div class="control-group">
										<label class="control-label">Menu Mini Description<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 m-wrap" id="em1" name="description" rows="6" data-error-container="#editor2_error"></textarea>
											<div id="editor2_error"></div>
										</div>
									</div>	
									<div class="control-group">
										<label class="control-label">Margin Left / Cell Width<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="width" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>	
									<div class="control-group">
										<label class="control-label">Cell Height<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="height" data-required="1" class="span6 m-wrap"/>
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
										<label class="control-label">URL&nbsp;&nbsp;</label>
										<div class="controls">
											<input name="url" type="text" class="span6 m-wrap"/>
											<span class="help-block">e.g: http://www.demo.com or http://demo.com - optional field</span>
										</div>
									</div>							
									
									<div class="control-group">
										<label class="control-label">Upload Icon / Banner&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="file" name="txtbanner" size="10" style="font-family: Verdana; font-size: 9pt">
											<span class="help-block">e.g: only jpg,png,gif are allowed - optional field</span>
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
	if(isset($_GET['sno']) && !empty($_GET['sno']))
	{	
		$menuid=preg_replace('/[^0-9]/', '', trim($_GET['sno']));
		$query=mysql_query("select * from heading where sno='$menuid'");
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
<body class="page-header-fixed">
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
							Website Main Menu
							<small>Add Website Main Menu</small>
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="mainmenu.php">Home</a> 
								<span class="icon-angle-right"></span>
							</li>
							<li>
								<a href="main-menu.php">Menu Master's</a>
								<span class="icon-angle-right"></span>
							</li>
							<li><a href="#">Edit Main Menu's</a></li>
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
								<div class="caption"><i class="icon-reorder"></i>Edit Main Menu - <b>"<?php echo $row_mainmenu['name'];?>"</b></div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<!--a href="#portlet-config" data-toggle="modal" class="config"></a-->
									<a href="javascript:;" class="reload"></a>
									<!--a href="javascript:;" class="remove"></a-->
								</div>
							</div>
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
								<form action="main-menu.php" id="form_main_menu" class="form-horizontal" enctype="multipart/form-data" method="post">									

									<div class="control-group">
										<label class="control-label">Show on Which Website?<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="websitetype">
												<option value="">Select...</option>
												<option value="english" <?php if($row_mainmenu['websitetype']=="english") { echo 'selected'; } ?>>English Website</option>
												<option value="hindi" <?php if($row_mainmenu['websitetype']=="hindi") { echo 'selected'; } ?>>Hindi Website</option>
											</select>
										</div>
									</div>

									<div class="control-group">
										<label class="control-label">Display on Home Page<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="home">
												<option value="">Select...</option>
												<option value="yes" <?php if($row_mainmenu['home']=="yes") { echo 'selected'; } ?>>Yes</option>
												<option value="no" <?php if($row_mainmenu['home']=="no") { echo 'selected'; } ?>>No</option>
											</select>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Show year Wise Data?<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="yearwisedata">
												<option value="">Select...</option>
												<option value="1" <?php if($row_mainmenu['yearwisedata']=="1") { echo 'selected'; } ?>>Yes</option>
												<option value="0" <?php if($row_mainmenu['yearwisedata']=="0") { echo 'selected'; } ?>>No</option>
											</select>
										</div>
									</div>
									

										<div class="control-group">
										<label class="control-label">Display Area / Region<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="display_area">
												<option value="main" <?php if($row_mainmenu['display_area']=="main") { echo 'selected'; } ?>>Main Navigation</option>
												<option value="top" <?php if($row_mainmenu['display_area']=="top") { echo 'selected'; } ?>>Top Menu</option>
												<option value="quick" <?php if($row_mainmenu['display_area']=="quick") { echo 'selected'; } ?>>Quick Navigation</option>
												<option value="bottom" <?php if($row_mainmenu['display_area']=="bottom") { echo 'selected'; } ?>>Bottom Menu</option>
												<option value="topbottom" <?php if($row_mainmenu['display_area']=="topbottom") { echo 'selected'; } ?>>Top & Bottom Both</option>
											</select>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Menu Name<span class="required">*</span></label>
										<div class="controls">
											<textarea name="txtheading" data-required="1" class="span6 m-wrap"/><?php echo $row_mainmenu['name'];?></textarea>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Sub Heading Name<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="txt_subheading" value="<?php echo $row_mainmenu['mini_heading'];?>" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>	
									<div class="control-group">
										<label class="control-label">Menu ID<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="menu_id" value="<?php echo $row_mainmenu['class_id'];?>" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>		
									<div class="control-group">
										<label class="control-label">Menu Mini Description<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 m-wrap" id="em1" name="description" rows="6" data-error-container="#editor2_error"><?php echo $row_mainmenu['description'];?></textarea>
											<div id="editor2_error"></div>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Margin Left / Cell Width<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="width" value="<?php echo $row_mainmenu['width'];?>" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>						
									<div class="control-group">
										<label class="control-label">Cell Height<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="height" value="<?php echo $row_mainmenu['height'];?>" data-required="1" class="span6 m-wrap"/>
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
										<label class="control-label">URL&nbsp;&nbsp;</label>
										<div class="controls">
											<input name="url" value="<?php echo $row_mainmenu['otherurl'];?>" type="text" class="span6 m-wrap"/>
											<span class="help-block">e.g: http://www.demo.com or http://demo.com - optional field</span>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label">Upload Banner&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="file" name="txtbanner" size="10" style="font-family: Verdana; font-size: 9pt">
																						
											<?php
											if($row_mainmenu['icon']!='' && file_exists("../uploads/images/icons/".$row_mainmenu['icon']))
											{
											?>
											<a target="_blank" href="../uploads/images/icons/<?php echo $row_mainmenu['icon']?>">
											<img border=0 src="images/down.jpg" title="<?php echo $row_mainmenu['icon']?>"></a>
											<?php
											}
											?>

											<span class="help-block">e.g: only jpg,png,gif are allowed - optional field</span>
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
	else
	{
		echo "<script>location.href='main-menu.php';</script>";
	}
}
?>
