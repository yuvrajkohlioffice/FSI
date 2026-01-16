<?php
	include_once "includes/constant.php";
	include_once "control.php";
	
error_reporting(0);
header("Cache-Control: must-revalidate");
header("Cache-Control: no-store");
header("Cache-Control: private");
session_start();

if(!isset($_POST['change_pwd']))
{
	$_SESSION['capture_code'] = generate_captcha();
}

if(isset($_POST['change_pwd']))
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_POST['log']));

	if($capture==$postcapture && $capture!="" && postcapture!="")
	{
	$webopass1=secure_login($_POST['oldpassword']);
	$npwd=secure_login($_POST['newpassword1']);
	$webnpass1=$npwd;
	$blankchk=md5(" ");
	$blankchk2=md5("");
	if($blankchk!=$webnpass1 && $blankchk2!=$webnpass1 && $webnpass1!="" && $webnpass1!=" ")
	{

		$sql_chk="select * from admin where uname='$_SESSION[uname]' and password='$webopass1'";
		
		$npwd=secure_login($_POST['newpassword1']);
		
		if(mysql_num_rows(mysql_query($sql_chk))>0 && $npwd!="" && $webnpass1!="" && $webnpass1!=" ")
		{

			$sql="update admin set password='$npwd' where uname='$_SESSION[uname]'";
			$rs=mysql_query($sql);
			if($rs)
			{
				session_unset();
				session_destroy();
				$type=md5("password");
				$details = "<strong>".$webname1."</strong> changes password on ".date("d-M-Y")." at ".date("H:i:s");
		
				$query = "insert into activity_log set details ='$details', type= 'backend', purpose = 'Password Changed', userid = '$row_user[sno]', ip_address = '$_SERVER[REMOTE_ADDR]', browser = '$_SERVER[HTTP_USER_AGENT]', createdon = '$timestamp', crdate = '$crdate'";
					
				$response = save_details($query, "true");

				echo "<script>location.href='index.php?action=$type';</script>";
			}
			else
			{
				echo "<script>alert('Unable to Change Password');</script>";
				echo "<script>location.href='change-password.php';</script>";
			}
		}
		else
		{
				echo "<script>alert('Your old password does not match.');</script>";
				echo "<script>location.href='change-password.php';</script>";
		}
	}
	}
	else
	{
			echo "<script>location.href='mainmenu.php';</script>";
	}
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
<script type="text/javascript" src="js/md5.js"></script>
 
<script language="javascript">

function performvalid(theform)
{
	
    if(theform.oldpassword.value.replace(/^\s+|\s+$/g,"")=="")
    {
         alert("Please enter Old Password");
         theform.oldpassword.focus();
         return(false);
    }
	if(theform.newpassword1.value.replace(/^\s+|\s+$/g,"")=="")
    {
         alert("Please enter new Password");
         theform.newpassword1.focus();
         return(false);
    }
    if (!/^(?=.*[\W])(?=[a-zA-Z0-9])[\w\W]{8,}$/.test(theform.newpassword1.value))
	{
		alert('Please read the Password Changing instructions carefully. Your New Password should fullfil all required parameters.');
		theform.oldpassword.focus();
		theform.newpassword1.value="";
		theform.newpassword2.value="";
        theform.oldpassword.value="";
        return(false);
	}

    if(theform.newpassword2.value.replace(/^\s+|\s+$/g,"")=="")
    {
         alert("Please enter new Password");
         theform.newpassword2.focus();
         return(false);
    }

	if(theform.newpassword1.value.replace(/^\s+|\s+$/g,"")!=theform.newpassword2.value.replace(/^\s+|\s+$/g,""))
	{
         alert("Password do not match please type correct password !!!!");
         theform.newpassword1.value="";
         theform.newpassword2.value="";
         theform.newpassword1.focus();
         return(false);
	}
	if(theform.oldpassword.value.replace(/^\s+|\s+$/g,"")!="" && theform.newpassword1.value.replace(/^\s+|\s+$/g,"")!="" && theform.newpassword2.value.replace(/^\s+|\s+$/g,"")!="")
    {
		theform.oldpassword.value=hex_md5(theform.oldpassword.value);
		theform.newpassword1.value=hex_md5(theform.newpassword1.value);
		theform.newpassword2.value=hex_md5(theform.newpassword2.value);
	}
	
  return(true);
     
}
</script>
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
							Change Password
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="mainmenu.php">Home</a> 
								<span class="icon-angle-right"></span>
							</li>
							<li>
								<a href="#">Change Password</a>
								<span class="icon-angle-right"></span>
							</li>
						</ul>
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->	
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN SAMPLE TABLE PORTLET-->						
						

						<!-- END SAMPLE TABLE PORTLET-->
					</div>					
				</div>
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN VALIDATION STATES-->
						<div class="portlet box purple">
							<div class="portlet-title">
								<div class="caption"><i class="icon-reorder"></i>Change Password</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<!--a href="#portlet-config" data-toggle="modal" class="config"></a-->
									<a href="javascript:;" class="reload"></a>
									<!--a href="javascript:;" class="remove"></a-->
								</div>
							</div>
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
								<form action="change-password.php" enctype="multipart/form-data" onsubmit="return performvalid(this)" id="form_page" name="form_page" class="form-horizontal" method="post">
									
									<div class="control-group">
										<label class="control-label">Old Password<span class="required">*</span></label>
										<div class="controls">
											<input type="password" name="oldpassword" data-required="1" class="span6 m-wrap"/>											
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label">New Password<span class="required">*</span></label>
										<div class="controls">
											<input type="password" name="newpassword1" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>								
									
									<div class="control-group">
										<label class="control-label">Confirm Password</label>
										<div class="controls">
											<input type="password" name="newpassword2" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>																	
									
									<div class="form-actions">
										<button type="submit" name="change_pwd" class="btn purple">Save</button>
										<button type="button" class="btn">Cancel</button>									
										<input type="hidden" name="action" size="5" value="edit1">
										<input type="hidden" value="<?php echo $_SESSION['capture_code'];?>" name="log">
									</div>
									
								</form>
								<!-- END FORM-->
								<table border="0" width="100%" cellpadding="4">
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td><b><font face="Arial" size="2">Password 
					Instructions</font></b></td>
				</tr>
				<tr>
					<td width="51%">
					<font face="Arial" style="font-size: 9pt" color="#FF0000">1. Password length must be minimum 8 characters
					</font></td>
				</tr>
				<tr>
					<td width="51%">
					<font face="Arial" style="font-size: 9pt" color="#FF0000">2. 
					Password must contain characters from of the following categories:&nbsp;
					</font></td>
				</tr>
				<tr>
					<td width="51%">
					<font face="Arial" style="font-size: 9pt" color="#FF0000">
					2.a. At least one Alphabet or Number or combination of both: (A 
					- Z or a-z&nbsp; 
					or 0-9)
					</font></td>
				</tr>
				<tr>
					<td width="51%" valign="top">
					<font face="Arial" style="font-size: 9pt" color="#FF0000">
					2.b. At least one Special Characters: ! " # $ % & ' ( ) * +  , - . / : ; < = > ? @ [ \ ] ^ _ `{ | }~</font></td>
				</tr>
			</table>
								
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
