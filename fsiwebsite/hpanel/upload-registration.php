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
if(isset($_GET['status']) && !empty($_GET['status']) && $_GET['status']=='upload2')
{
	upload_csv();
	exit;
}

if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=='upload')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_POST['log']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		$default_size = 20 * 1024 * 1024;

		$size=$_FILES['upload']['size'];
		$fname=$_FILES['upload']['name'];
		$source=$_FILES['upload']['tmp_name'];
		$type=$_FILES['upload']['type'];
		
		$original_extension = (false === $pos = strrpos($fname, '.')) ? '' : substr($fname, $pos);

		//if($_FILES['upload']['name']!='' && $type=='application/vnd.ms-excel' && $original_extension == ".csv" && $size <= $default_size)
		{
			$ext = ".csv";
				
			$uploadedpath = "../uploads/registration/";
			$dest = $uploadedpath.'reg'.$ext;
		
			if( move_uploaded_file($source,$dest) )
			{
				rename($dest,$dest);
				echo "<script>alert('File successfully uploaded');location.href='upload-registration2.php?status=upload2';</script>";
			}
		}
		/*else
		{			
			echo "<script>alert('Please Upload CSV file only');location.href='upload-registration.php';</script>";
		}*/
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='firepoint.php?status=codeinvalid'</script>";
	}
}	

if(isset($_POST['flag']) && !empty($_POST['flag']) && $_POST['flag']==2)
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_POST['log']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		
		$columns ="fdate,longitude,latitude,soi,city,district,state,status,crdate";
		
		//$row = 1;
		$handle = fopen("../uploads/registration/reg.csv", "r");
		
		while (($data = fgetcsv($handle, 4096, ',')) !=FALSE)
		{ 
			$a = addslashes($data['0']);
			$b=addslashes($data['1']);
			$c=addslashes($data['2']); 
			$d=addslashes($data['3']);
			$e=addslashes($data['4']);
			$f=addslashes($data['5']); 
			$g=addslashes($data['6']);
			$h=addslashes($data['1']);
			$i=addslashes($data['2']); 
			$j=addslashes($data['3']);
			$k=addslashes($data['4']);
			$l=addslashes($data['5']); 
			$m=addslashes($data['6']);
			
			$n=addslashes($data['1']);
			$o=addslashes($data['2']); 
			$p=addslashes($data['3']);
			$q=addslashes($data['4']);
			$r=addslashes($data['5']); 
			
			$s=active;
			$t= date("Y-m-d");
			
			
			 $sql = "INSERT INTO firepoint( name, designation, organization, address, state, city, district1, district2, district3, district4, country, pin, phone, mobile, email, password, alert, zeroalert, status, crdate ) VALUES('$a','$b','$c','$d','$e','$f','$g','$i','$j','$k','$l','$m','$n','$o','$p','$q','$r','$s','$t')";
			  
			mysql_query($sql) or $reset='SQL ERROR:';			
		  
		}
		
		if($reset=='')
		{
			echo "<script>alert('Data Inserted successfuly into Database');location.href='upload-registration.php';</script>";
		}
		else
		{
			echo "<script>alert('Query Failed: Data Was not Inserted');location.href='upload-registration.php';</script>";
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='firepoint.php?status=codeinvalid'</script>";
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
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.css"/>

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
							Upload Firepoints
							<small>Upload Firepoints using CSV file</small>
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="mainmenu.php">Home</a> 
								<span class="icon-angle-right"></span>
							</li>
							<li>
								<a href="#">Forest Fire</a>
								<span class="icon-angle-right"></span>
							</li>
							<li><a href="#">Upload Firepoints</a></li>
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
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN VALIDATION STATES-->
						<div class="portlet box purple">
							<div class="portlet-title">
								<div class="caption"><i class="icon-reorder"></i>Upload CSV File</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<!--a href="#portlet-config" data-toggle="modal" class="config"></a-->
									<a href="javascript:;" class="reload"></a>
									<!--a href="javascript:;" class="remove"></a-->
								</div>
							</div>
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
									<div align="center">

<?php
if(!isset($_GET['flag']))
{
?>

	<table border="0" cellpadding="5" cellspacing="3" style="border:1px solid #800000; border-collapse: collapse" width="100%" bordercolor="#000000" id="table5">
		<tr>
			<td>
			<p align="center"><b>
			<font face="Verdana" size="2" color="#800000">Please Upload </font>
			<font face="Verdana" size="2" color="#0000FF">CSV file</font><font face="Verdana" size="2" color="#800000"> with following heading's.</font></b></p>
			<div align="center">
				<table border="0" cellpadding="3" style="border-collapse: collapse" width="100%" bordercolor="#000000" id="table6" cellspacing="1">
					<tr>
						<td align="center" bgcolor="#E9E9E9">
						<span style="font-weight: 700">
						<font face="Verdana" size="2">Name</font></span></td>
						<td align="center" bgcolor="#E9E9E9">
						<span style="font-weight: 700">
						<font face="Verdana" size="2">Designation</font></span></td>
						<td align="center" bgcolor="#E9E9E9">
						<span style="font-weight: 700">
						<font face="Verdana" size="2">Organization</font></span></td>
						<td align="center" bgcolor="#E9E9E9">
						<span style="font-weight: 700">
						<font face="Verdana" size="2">Address</font></span></td>
						<td align="center" bgcolor="#E9E9E9">
						<span style="font-weight: 700">
						<font face="Verdana" size="2">State</font></span></td>
						<td align="center" bgcolor="#E9E9E9">
						<span style="font-weight: 700">
						<font face="Verdana" size="2">City</font></span></td>
						<td align="center" bgcolor="#E9E9E9">
						<span style="font-weight: 700">
						<font face="Verdana" size="2">District I</font></span></td>
					</tr>
					<tr>
						<td align="center" bgcolor="#E9E9E9">
						<span style="font-weight: 700">
						<font face="Verdana" size="2">District II</font></span></td>
						<td align="center" bgcolor="#E9E9E9">
						<span style="font-weight: 700">
						<font face="Verdana" size="2">District III</font></span></td>
						<td align="center" bgcolor="#E9E9E9">
						<span style="font-weight: 700">
						<font face="Verdana" size="2">District IV</font></span></td>
						<td align="center" bgcolor="#E9E9E9">
						<span style="font-weight: 700">
						<font face="Verdana" size="2">Country</font></span></td>
						<td align="center" bgcolor="#E9E9E9">
						<span style="font-weight: 700">
						<font face="Verdana" size="2">Pin Code</font></span></td>
						<td align="center" bgcolor="#E9E9E9">
						<span style="font-weight: 700">
						<font face="Verdana" size="2">Phone</font></span></td>
						<td align="center" bgcolor="#E9E9E9">
						<span style="font-weight: 700">
						<font face="Verdana" size="2">Mobile</font></span></td>
					</tr>
					<tr>
						<td align="center" bgcolor="#E9E9E9">
						<span style="font-weight: 700">
						<font face="Verdana" size="2">Email ID</font></span></td>
						<td align="center" bgcolor="#E9E9E9">
						<span style="font-weight: 700">
						<font face="Verdana" size="2">Password</font></span></td>
						<td align="center" bgcolor="#E9E9E9">
						<span style="font-weight: 700">
						<font face="Verdana" size="2">Alert</font></span></td>
						<td align="center" bgcolor="#E9E9E9">
						<span style="font-weight: 700">
						<font face="Verdana" size="2">Zero Alert</font></span></td>
						<td align="center" bgcolor="#E9E9E9">
						<span style="font-weight: 700">
						<font face="Verdana" size="2">Status</font></span></td>
						<td align="center" bgcolor="#E9E9E9">
						<span style="font-weight: 700">
						<font face="Verdana" size="2">Crdate</font></span></td>
						<td align="center" bgcolor="#E9E9E9">
						&nbsp;</td>
					</tr>
					</table>
				<p><b><font face="Verdana" size="2">Date Format Should be 
				YYYY-mm-dd</font></b></div>
			</td>
		</tr>
		<tr>
			<td>
			<form method="POST" enctype="multipart/form-data" action="upload-registration.php">
				
				<p align="center"><font face="Verdana"><font size="2">Upload 
				<b>&quot;CSV&quot;</b> file</font> :-&nbsp; </font>
				<input type="file" name="upload" size="73" style="font-family: Verdana; font-size: 10px; color: #193A01"><font face="Verdana"><br>
				</font><br>
				<input type="submit" value="Submit" name="B1" style="font-family: Verdana; font-size: 8pt; color: #193A01; text-transform: uppercase; font-weight: bold">
				<input type="reset" value="Reset" name="B2" style="font-family: Verdana; font-size: 8pt; color: #193A01; text-transform: uppercase; font-weight: bold">
				<input type="hidden" name="action" value="upload">
				<input type="hidden" value="<?php echo $_SESSION['capture_code'];?>" name="log">

				</p>
			</form>
			</td>
		</tr>
		</table>
<?
}
?>
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
	<script src="assets/scripts/ui-jqueryui.js"></script>     
	<!-- END PAGE LEVEL SCRIPTS -->
	<script>
		jQuery(document).ready(function() {       
		   // initiate layout and plugins
		   App.init();
		   UIJQueryUI.init();
		});
	</script>
</body>
<!-- END BODY -->
</html>
<?php
}
function upload_csv()
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
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.css"/>

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
							Upload Firepoints
							<small>Upload Firepoints using CSV file</small>
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="mainmenu.php">Home</a> 
								<span class="icon-angle-right"></span>
							</li>
							<li>
								<a href="#">Forest Fire</a>
								<span class="icon-angle-right"></span>
							</li>
							<li><a href="#">Upload Firepoints</a></li>
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
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN VALIDATION STATES-->
						<div class="portlet box purple">
							<div class="portlet-title">
								<div class="caption"><i class="icon-reorder"></i>Click on button below to insert data</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<!--a href="#portlet-config" data-toggle="modal" class="config"></a-->
									<a href="javascript:;" class="reload"></a>
									<!--a href="javascript:;" class="remove"></a-->
								</div>
							</div>
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
									<div align="center">

								<form name="f1" method="post" action="upload-registration.php">
								<table border="0" cellpadding="2" style="border-collapse: collapse" width="100%" bordercolor="#800000" id="table1">
									<tr>
										<td>
										<p align="center"><b><font color="#800000" face="Verdana">Please Click 
										on Button to Insert Data in to the Database </font></b></td>
									</tr>
									<tr>
										<td>
										<p align="center">&nbsp;</p>
										<p align="center">
												<input type="submit" value="Insert Data in to Database" name="B1" style="font-family: Arial; font-size: 12pt; color: #193A01; text-transform: uppercase; font-weight: bold"><input type="hidden" name="flag" size="20" value="2"></p>
																						<input type="hidden" value="<?php echo $_SESSION['capture_code'];?>" name="log">
								
										<p align="center">&nbsp;</td>
									</tr>
								</table></form>
</div>
									
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
	<script src="assets/scripts/ui-jqueryui.js"></script>     
	<!-- END PAGE LEVEL SCRIPTS -->
	<script>
		jQuery(document).ready(function() {       
		   // initiate layout and plugins
		   App.init();
		   UIJQueryUI.init();
		});
	</script>
</body>
<!-- END BODY -->
</html>
<?php
}
?>
