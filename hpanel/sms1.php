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

$sms_date = date("Y-m-d",strtotime($_POST['fdate1']));

$dt=explode('-',$sms_date);


$sed=$dt[2].'.'.$dt[1].'.'.$dt[0];


if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=='send')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_POST['log']));
	//if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		
		$sql="select * from registration where status='active'";
		$result=mysql_query($sql);
		
		$sms_date = date('Y-m-d',strtotime($_POST['fdate1']));
		
		while($row=mysql_fetch_array($result))
		{
			if($row['alert']=='All')
			{
				$sql12 = "select * from firepoint where fdate='$sms_date'";
				$firepoint[] = mysql_num_rows(mysql_query($sql12));
			}
			
			if($row['alert']=='State')
			{
				$sql13 = "select * from firepoint where fdate='$sms_date' and state like '%$row[state]%'";
				$firepoint13 = mysql_num_rows(mysql_query($sql13));
			}
			
			if($row['alert']=='District')
			{
				$sql_d1="select * from firepoint where fdate='$sms_date' and district ='$row[district1]' ";
				$firepoint_d1=mysql_num_rows(mysql_query($sql_d1));
				
				$sql_d2="select * from firepoint where fdate='$sms_date' and district ='$row[district2]' ";
				$firepoint_d2=mysql_num_rows(mysql_query($sql_d2));
				
				$sql_d3="select * from firepoint where fdate='$sms_date' and district ='$row[district3]' ";
				$firepoint_d3=mysql_num_rows(mysql_query($sql_d3));
				
				$sql_d4="select * from firepoint where fdate='$sms_date' and district ='$row[district4]' ";
				$firepoint_d4=mysql_num_rows(mysql_query($sql_d4));
			}
			
			
			if($row['alert']=='State')
			{
			
				if($row['zeroalert']=='No')
				{
					if($firepoint13!=0)
					{
						$msg[]="$firepoint13 forest fire spots detected in $row[state] by Forest Survey of India on $sed.Pl visit www.fsi.nic.in for details.";
						$mobile[]=$row['mobile'].',';
					}	
				}
				if($row['zeroalert']=='Yes')
				{
					$msg[]="$firepoint13 forest fire spots detected in $row[state] by Forest Survey of India on $sed.Pl visit www.fsi.nic.in for details.";
					$mobile[]=$row['mobile'].',';
				}
			}
			
			if($row['alert']=='District')
			{
			
				if($row['district1']!='-')
				{
				
					if($row['zeroalert']=='No')
					{
						if($firepoint_d1!=0)
						{
							$msg[]="$firepoint_d1 forest fire spots detected in $row[district1] by Forest Survey of India on $sed.Pl visit www.fsi.nic.in for details.";
							$mobile[]=$row['mobile'].',';
						}
					}
					if($row['zeroalert']=='Yes')
					{
						$msg[]="$firepoint_d1 forest fire spots detected in $row[district1] by Forest Survey of India on $sed.Pl visit www.fsi.nic.in for details.";
						$mobile[]=$row['mobile'].',';
					}
				}
			
			
				if($row['district2']!='-')
				{
			
					if($row['zeroalert']=='No')
					{
						if($firepoint_d2!=0)
						{
							$msg[]="$firepoint_d2 forest fire spots detected in $row[district2] by Forest Survey of India on $sed.Pl visit www.fsi.nic.in for details.";
							$mobile[]=$row['mobile'].',';
						}
					}
					if($row['zeroalert']=='Yes')
					{
						$msg[]="$firepoint_d2 forest fire spots detected in $row[district2] by Forest Survey of India on $sed.Pl visit www.fsi.nic.in for details.";
						$mobile[]=$row['mobile'].',';
					}
				}
			
				if($row['district3']!='-')
				{
				
					if($row['zeroalert']=='No')
					{
						if($firepoint_d3!=0)
						{
							$msg[]="$firepoint_d3 forest fire spots detected in $row[district3] by Forest Survey of India on $sed.Pl visit www.fsi.nic.in for details.";
							$mobile[]=$row['mobile'].',';
						}
					}
					if($row['zeroalert']=='Yes')
					{
						$msg[]="$firepoint_d3 forest fire spots detected in $row[district3] by Forest Survey of India on $sed.Pl visit www.fsi.nic.in for details.";
						$mobile[]=$row['mobile'].',';
					}
				}
			
				if($row['district4']!='-')
				{
				
					if($row['zeroalert']=='No')
					{
						if($firepoint_d4!=0)
						{
							$msg[]="$firepoint_d4 forest fire spots detected in $row[district4] by Forest Survey of India on $sed.Pl visit www.fsi.nic.in for details.";
							$mobile[]=$row['mobile'].',';
					
						}
					}
					if($row['zeroalert']=='Yes')
					{
						$msg[]="$firepoint_d4 forest fire spots detected in $row[district4] by Forest Survey of India on $sed.Pl visit www.fsi.nic.in for details.";
						$mobile[]=$row['mobile'].',';
					}
				}
			
			//echo $mobile;
			}
			if($row['alert']=='All')
			{
				$msg[]="$firepoint[0] forest fire spots detected in India by Forest Survey of India on $sed.Pl visit www.fsi.nic.in for details.";
				$mobile[]=$row['mobile'].',';
			
			//echo $mobile;
			
			}
		}
	}
	/*else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='sms.php?status=codeinvalid'</script>";
	}*/
}	



//"http://www.cssteap.org/sms/sms_php_function.php";


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
							Send Forest Fire SMS
							<small>Send SMS to regsitered Users</small>
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
							<li><a href="#">Send SMS</a></li>
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
								<div class="caption"><i class="icon-reorder"></i>Select Options to Send SMS</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<!--a href="#portlet-config" data-toggle="modal" class="config"></a-->
									<a href="javascript:;" class="reload"></a>
									<!--a href="javascript:;" class="remove"></a-->
								</div>
							</div>
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
								<form name="f1" method="POST" action="http://thebookinghouse.com/sms/sms_php_function.php" id="form_page" name="form_page" class="form-horizontal" style="background-color: #F0F0E1; width:300">
								<p align="left">
								<input type="submit" value="Send SMS Alert" name="B1" style="font-family: Verdana; font-size: 14pt; color: #0000FF; font-weight: bold; width:187; height:59">
								<br><br>
								<?php
								/*if(!isset($msg))
								{
									echo "<script>location.href='send-sms.php?error=empty'</script>";
								}
								else
								{*/
								$a=count($msg);
								
								
								for($i=0;$i<$a;$i++)
								{
								?>
								<input name="mobile[]" value="<?echo $mobile[$i]?>" style="font-family: Arial; font-size: 10px; border: 1px solid #800000; padding: 1px; float:left" size="31"><br>
								
								<textarea name="msg[]" cols="51" rows="2" style="font-family: Arial; font-size: 10px; border: 1px solid #800000; padding: 1px; background-color: #EFEFEF" ><?echo $msg[$i]?></textarea><?echo strlen($msg[$i])?><br>
								
								
								<?
								}
								//}
								?>
								<input name="mobile[]" value="<?echo $mobile[$i]?>" style="font-family: Arial; font-size: 10px; border: 1px solid #800000; padding: 1px; float:left" size="31"><br>
								
								<textarea name="msg[]" cols="51" rows="2" style="font-family: Arial; font-size: 10px; border: 1px solid #800000; padding: 1px; background-color: #EFEFEF" ><?echo $msg[$i]?></textarea><?echo strlen($msg[$i])?><br>

								<br><br>
								</p>
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
