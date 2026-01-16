<?php
error_reporting(0);
ob_start();
session_start();

include_once "includes/constant.php";

if(isset($_POST['action']))
{
	echo "Loading, please wait..";
	
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_POST['log']));

	if($capture==$postcapture && $capture!="" && postcapture!="")
	{
		include_once "database.php";
		db_connect();
		
		$uniqid = preg_replace('/[^0-9]/', '', trim($_POST['uniqueid']));
		
		$timestamp = strtotime(date("Y-m-d h:i:s"));
		
		$chk = mysql_num_rows(mysql_query("select sno from reset_log where sno = '$uniqid' and is_changed = '0'"));
		
		if($chk == 1)
		{		
			$update = mysql_query("update admin set password = '$_POST[newpassword]' where uid = '1'");
			
			$up = mysql_query("update reset_log set is_changed = '1', changed_on = '$timestamp', changed_ip = '$_SERVER[REMOTE_ADDR]' where sno = '$uniqid'");
			
			if($update)
				echo "<script>location.href='index.php?loginauth=update';</script>";
			else
				echo "<script>location.href='index.php?loginauth=cerror';</script>";		
		}
		else
			echo "<script>location.href='index.php?loginauth=cerror';</script>";		
	}	
	else
	{
		echo "<script>location.href='index.php?loginauth=unauthorize';</script>";
	}
}

protect_session_id();
generate_salted_key();
$captcha_used = generate_captcha();
$_SESSION['capture_code'] = $captcha_used;


$capture = preg_replace('/[^0-9]/', '', trim($_GET['log']));
$postcapture = preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['hash']));

if($capture!="" && postcapture!="")
{
	include_once "database.php";
	db_connect();
	$is_exists = 0;
	
	$allowed_days = 2;
	
	$chk = mysql_query("select sno,timestamp from reset_log where sno = '$capture' and is_changed = '0'");

	$is_exists = mysql_num_rows($chk);

	$row_exists = mysql_fetch_array($chk);
	
	$difference = $row_exists['timestamp'] - strtotime(date("Y-m-d h:i:s"));
	
	$days = abs( floor( $difference / ( 60*60*24 ) ) );
	
	if($is_exists >= 1 && md5($row_exists['timestamp']) == $postcapture && $days <= $allowed_days)
	{
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<script type = "text/javascript" >
	      function burstCache() {
	        if (!navigator.onLine) {
	            document.body.innerHTML = 'Loading...';
	            window.location = '403.html';
	        }
	    }
	</script>
	<meta charset="utf-8" />
	<title><?php echo SITE_NAME;?> | Authentication Required</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<meta http-equiv="cache-control" content="max-age=0" />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="expires" content="0" />
	<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
	<meta http-equiv="pragma" content="no-cache" />
	<script type="text/javascript" src="js/md5.js"></script>
	<script>
	function filtered_func(theval,theval1)
	{
		if(theval.replace(/^\s+|\s+$/g,"")!="" && theval1.replace(/^\s+|\s+$/g,"")!="")
		{
			//log.txtusername.value=hex_md5(theval);
			log.txtpassword.value=hex_md5("<?php echo $_SESSION['salted_hash'];?>"+hex_md5(theval1));
		}
	}
	</script>

<script type="text/javascript" src="js/md5.js"></script>
 
<script language="javascript">

function performvalid(theform)
{
	
	if(theform.newpassword.value.replace(/^\s+|\s+$/g,"")=="")
    {
         alert("Please enter new Password");
         theform.newpassword.focus();
         return(false);
    }
    else if (!/^(?=.*[\W])(?=[a-zA-Z0-9])[\w\W]{8,}$/.test(theform.newpassword.value))
	{
		alert('Please read the Password Changing instructions carefully. Your New Password should fullfil all required parameters.');
		theform.newpassword.focus();
		theform.newpassword.value="";
        return(false);
	}

	else if(theform.security_code.value.replace(/^\s+|\s+$/g,"")=="")
	{
		alert('Please Enter Security Code!!');
		theform.newpassword.value ="";
		theform.security_code.focus();
		return false;
	}

	else if(theform.security_code.value!="<?php echo $captcha_used; ?>")
	{
		alert("Please Type Correct Security Code!!");
		theform.security_code.value="";
		theform.newpassword.value ="";			
		theform.security_code.focus();
		return(false);
	}	 
	else
	{
		theform.newpassword.value = hex_md5(theform.newpassword.value);	
		return true;
	}


  return(true);
     
}
</script>
	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="assets/plugins/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
	<link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
	<link href="assets/css/style-metro.css" rel="stylesheet" type="text/css"/>
	<link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
	<link href="assets/css/style-responsive.css" rel="stylesheet" type="text/css"/>
	<link href="assets/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
	<link href="assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" type="text/css" href="assets/plugins/select2/select2_metro.css" />
	<!-- END GLOBAL MANDATORY STYLES -->
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link href="assets/css/pages/login.css" rel="stylesheet" type="text/css"/>
	<!-- END PAGE LEVEL STYLES -->
	<link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login" onload="burstCache();">
	<!-- BEGIN LOGO -->
	<div class="logo">
		<img src="images/logo.png" alt="" /> 
	</div>
	<!-- END LOGO -->
	<!-- BEGIN LOGIN -->
	<div class="content">
		<!-- BEGIN LOGIN FORM -->
			<h3 class="form-title">Reset your Password</h3>
			<?php
			if(isset($_GET['loginauth']) && !empty($_GET['loginauth']))
			{
				$return_msg = preg_replace('/[^a-z]/', '', trim($_GET['loginauth']));

				if($return_msg == "incorrect")
				{
				?>
				<div class="alert alert-error">
					<button class="close" data-dismiss="alert"></button>
					<span>Either username or password you entered is in-correct.</span>
				</div>
				<?php
				}
				if($return_msg == "logout")
				{
				?>
				<div class="alert alert-success">
					<button class="close" data-dismiss="alert"></button>
					<span>Logout Successfully</span>
				</div>
				<?php
				}
				if($return_msg == "sent")
				{
				?>
				<div class="alert alert-success">
					<button class="close" data-dismiss="alert"></button>
					<span>We've sent Password reset link to your registered EMail ID.</span>
				</div>
				<?php
				}
				if($return_msg == "error")
				{
				?>
				<div class="alert alert-error">
					<button class="close" data-dismiss="alert"></button>
					<span>Not a registered Email ID.</span>
				</div>
				<?php
				}
				if($return_msg == "unauthorize")
				{
				?>
				<div class="alert alert-error">
					<button class="close" data-dismiss="alert"></button>
					<span>Unauthorize Access.</span>
				</div>
				<?php
				}
			}
			?>			      
		<form class="form-vertical" action="" method="post" onsubmit="return performvalid(this)" autocomplete="off">
			<p><strong>Password Instructions</strong><br/>1. Password length must be minimum 8 characters.<br/> 2. Password must contain characters from of the following categories:<br/>
2.a. At least one Alphabet or Number or combination of both: (A - Z or a-z  or 0-9)<br/>
2.b. At least one Special Characters: ! " # $ % & ' ( ) * + , - . / : ; < = > ? @ [ \ ] ^ _ `{ | }~
</p>
			<div class="control-group">
				<div class="controls">
					<div class="input-icon left">
						<i class="icon-lock"></i>
						<input class="m-wrap placeholder-no-fix" type="password" autocomplete="off" tabindex="1" placeholder="Password" name="newpassword" />
					</div>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label visible-ie8 visible-ie9">Enter Code as shown in Image</label>
				<div class="controls">
					<div class="input-icon left">
						<i class="icon-lock"></i>
						<input type="text" id="security_code" style="width: 80px" tabindex="2" placeholder="Enter code"; class="m-wrap placeholder-no-fix" name="security_code" autocomplete="off" tabindex="3" oncopy="return false;" onpaste="return false;" oncut="return false;"/>	<img id="imgCaptcha" src="includes/create_image.php?scode=<?php echo $captcha_used; ?>" style="width:80px; height: 30px;"/>	
					</div>
				</div>
			</div>

			<div class="form-actions">
				<button type="submit" class="btn green pull-right" tabindex="3">
				Save <i class="m-icon-swapright m-icon-white"></i>
				</button>            
			</div>
			<input type="hidden" value="<?php echo $_SESSION['capture_code'];?>" name="log">
			<input type="hidden" name="action" value="1">
			<input type="hidden" name="uniqueid" value="<?php echo $capture;?>">
		</form>
		<!-- END FORGOT PASSWORD FORM -->
	</div>
	<!-- END LOGIN -->
	<!-- BEGIN COPYRIGHT -->
	<div class="copyright">
		<?php echo date("Y");?> &copy; <?php echo SITE_NAME; ?>.
	</div>
	<!-- END COPYRIGHT -->
	<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
	<!-- BEGIN CORE PLUGINS -->   <script src="assets/plugins/jquery-1.10.1.min.js" type="text/javascript"></script>
	<script src="assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
	<script src="assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>      
	<script src="assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js" type="text/javascript" ></script>
	<!--[if lt IE 9]>
	<script src="assets/plugins/excanvas.min.js"></script>
	<script src="assets/plugins/respond.min.js"></script>  
	<![endif]-->   
	<script src="assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
	<script src="assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>  
	<script src="assets/plugins/jquery.cookie.min.js" type="text/javascript"></script>
	<script src="assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>
	<!-- END CORE PLUGINS -->
	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script src="assets/plugins/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>	
	<script type="text/javascript" src="assets/plugins/select2/select2.min.js"></script>     
	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="assets/scripts/app.js" type="text/javascript"></script>
	<script src="assets/scripts/login-forget.js" type="text/javascript"></script> 
	<!-- END PAGE LEVEL SCRIPTS --> 
	<script>
		jQuery(document).ready(function() {     
		  App.init();
		  Login.init();
		
		 
		
		});
	</script>
	<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
<?php
	}
	else
	{
		echo "<script>location.href='index.php?loginauth=unauthorize';</script>";
	}
}
else
{
	echo "<script>location.href='index.php?loginauth=unauthorize';</script>";
}
ob_flush();
?>