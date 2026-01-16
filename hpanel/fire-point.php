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
	$chk_status = preg_replace('/[^a-z]/', '', trim($_GET['status']));

	if($chk_status == "upload")
	{
		view();
		exit;
	}
	else
	{
		echo "<script>location.href='firepoint.php?status=codeinvalid'</script>";
	}	
}

if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']==2)
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_POST['log']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		
		$columns ="fdate,longitude,latitude,soi,city,district,state,status,crdate";
		
		//$row = 1;
		$handle = fopen("../uploads/firepoints/firepoints.csv", "r");
		
		while (($data = fgetcsv($handle, 4096, ',')) !=FALSE)
		{ 
			$a11=addslashes($data['0']);
			
			$a12=explode('/',$a11);
			
			$a = date("Y-m-d",strtotime(addslashes($data['0'])));

			$b=addslashes($data['1']);
			$c=addslashes($data['2']); 
			$d=addslashes($data['3']);
			$e=addslashes($data['4']);
			$f=addslashes($data['5']); 
			$g=addslashes($data['6']);
			$i=active;
			$j=$pdate;
			
			
			 $sql = "INSERT INTO firepoint( $columns ) VALUES('$a','$b','$c','$d','$e','$f','$g','$i','$j')";
			  
			mysql_query($sql) or $reset='SQL ERROR:';
			
			 $sql = "INSERT INTO firepoint_report( $columns ) VALUES('$a','$b','$c','$d','$e','$f','$g','$i','$j')";
			  
			mysql_query($sql) or $reset='SQL ERROR:';
		  
		}
		
		if($reset=='')
		{
			echo "<script>alert('Data Inserted successfuly into Database');location.href='firepoint.php';</script>";
		}
		else
		{
			echo "<script>alert('Query Failed: Data Was not Inserted');location.href='firepoint.php';</script>";
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


	<table border="0" cellpadding="5" cellspacing="3" style="border:1px solid #800000; border-collapse: collapse" width="100%" bordercolor="#000000" id="table5">
		<tr>
			<td>
			<p align="center"><b>
			<font face="Verdana" size="2" color="#800000">Please Upload </font>
			<font face="Verdana" size="2" color="#0000FF">CSV file</font><font face="Verdana" size="2" color="#800000"> with following heading's.</font></b></p>
			
			</td>
		</tr>
		<tr>
			<td>
			<form name="f1" method="post" action="fire-point.php?status=upload">
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
										<input type="submit" value="Insert Data in to Database" name="B1" style="font-family: Arial; font-size: 12pt; color: #193A01; text-transform: uppercase; font-weight: bold"><input type="hidden" name="action" size="20" value="2"></p>
										<input type="hidden" value="<?php echo $_SESSION['capture_code'];?>" name="log">
								
										<p align="center">&nbsp;</td>
									</tr>
								</table></form>
			</td>
		</tr>
		</table>
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
?>