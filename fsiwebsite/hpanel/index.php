<?php
ini_set( 'session.cookie_httponly', 1 );
//ini_set('session.cookie_secure', 1);
session_start();
include_once "includes/constant.php";
/*include "database.php";
db_connect();
$sql_user="select * from admin where uname = 'admin'";
$result = mysql_query($sql_user);
$row_user = mysql_fetch_array($result);
print_r($row_user);
mysql_query("UPDATE `admin` SET `password` = MD5('n5NV@75Gcx') WHERE `admin`.`sno` = 1;");
echo "<br/><hr/>";
$sql_user="select * from admin where uname = 'admin'";
$result = mysql_query($sql_user);
$row_user = mysql_fetch_array($result);
print_r($row_user);*/
// echo 1;
protect_session_id();
generate_salted_key();
$captcha_used = generate_captcha();
$sessname=session_name();
$sess_ID=session_id();

$md5_hash = md5(rand(0,999)); 
$security_code = substr($md5_hash, 15, 6); 
$_SESSION['capture_code']=$security_code;

$md5_hash = md5(rand(0,999)); 
$login_authentication = substr($md5_hash, 16, 16); 
$_SESSION['authToken'] = md5($login_authentication);

//header("Set-Cookie: TokenCustom=$_SESSION[authToken]; httpOnly");

header("Set-Cookie: $sessname=$sess_ID; httpOnly");
$_SESSION['log_capture_code'] = $captcha_used;
$_SESSION['php_session_id'] = $_COOKIE['PHPSESSID'];
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
	<script type='text/javascript'>
	
	(function()
	{
	  localStorage.removeItem('firstLoad2');

	  if( window.localStorage )
	  {
	    if( !localStorage.getItem('firstLoad') )
	    {
	      localStorage['firstLoad'] = true;
	      window.location.reload();
	    }  
	    else
	      localStorage.removeItem('firstLoad');
	  }
	})();
	
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

	<script language="javascript">
	function performvalid(theform)
	{

		if(theform.txtusername.value.replace(/^\s+|\s+$/g,"")=="")
		{
			 alert("Please Enter User Name");
			 theform.txtusername.focus();
			 return(false);
		}
		   
		if(theform.txtpassword.value.replace(/^\s+|\s+$/g,"")=="")
		{
			 alert("Please Enter Password");
			 theform.txtpassword.focus();
			 return(false);
		}

		if(theform.security_code.value.replace(/^\s+|\s+$/g,"")=="")
		{
			alert('Please Enter Security Code!!');
			theform.txtpassword.value ="";
			theform.security_code.focus();
			return false;
		}

		if(theform.security_code.value!="<?php echo $captcha_used?>")
		{
			alert("Please Type Correct Security Code!!");
			theform.security_code.value="";
			theform.txtpassword.value ="";			
			theform.security_code.focus();
			return(false);
		}	  
		return true;
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
		<form class="form-vertical login-form" onsubmit="return performvalid(this)" name="log" action="mainmenu.php" method="post" autocomplete="off">
			<h3 class="form-title">Login to your account</h3>
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
					<span>We've sent Password reset link to your registered E-Mail ID.</span>
				</div>
				<?php
				}
				if($return_msg == "update")
				{
				?>
				<div class="alert alert-success">
					<button class="close" data-dismiss="alert"></button>
					<span>Password changed Successfully.</span>
				</div>
				<?php
				}
				if($return_msg == "error")
				{
				?>
				<div class="alert alert-error">
					<button class="close" data-dismiss="alert"></button>
					<span>Error! Try again</span>
				</div>
				<?php
				}
				if($return_msg == "cerror")
				{
				?>
				<div class="alert alert-error">
					<button class="close" data-dismiss="alert"></button>
					<span>Unable to Change Password.</span>
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
				if($return_msg == "previouspwd")
				{
				?>
				<div class="alert alert-error">
					<button class="close" data-dismiss="alert"></button>
					<span>You cannot use previously used last five password. Please choose different password.</span>
				</div>
				<?php
				}
				if($return_msg == "usedexp")
				{
				?>
				<div class="alert alert-error">
					<button class="close" data-dismiss="alert"></button>
					<span>Either password reset link is already used or link expired.</span>
				</div>
				<?php
				}
				if($return_msg == "codeinvalid")
				{
				?>
				<div class="alert alert-error">
					<button class="close" data-dismiss="alert"></button>
					<span>Your Security Code is Invalid.</span>
				</div>
				<?php
				}

			}
			?>
			<div class="control-group">
				<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
				<label class="control-label visible-ie8 visible-ie9">Username</label>
				<div class="controls">
					<div class="input-icon left">
						<i class="icon-user"></i>
						<input class="m-wrap placeholder-no-fix" type="text" tabindex="1" autocomplete="off" placeholder="Username" name="txtusername"/>
					</div>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label visible-ie8 visible-ie9">Password</label>
				<div class="controls">
					<div class="input-icon left">
						<i class="icon-lock"></i>
						<input class="m-wrap placeholder-no-fix" type="password" tabindex="2" autocomplete="off" placeholder="Password" name="txtpassword"/>
					</div>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label visible-ie8 visible-ie9">Enter Code as shown in Image</label>
				<div class="controls">
					<div class="input-icon left">
						<i class="icon-lock"></i>
						<input type="text" id="security_code" style="width: 80px" tabindex="3" placeholder="Enter code"; class="m-wrap placeholder-no-fix" name="security_code" autocomplete="off" tabindex="3" oncopy="return false;" onpaste="return false;" oncut="return false;"/>	<img id="imgCaptcha" src="includes/create_image.php?scode=<?php echo $captcha_used; ?>" style="width:80px; height: 30px;"/>	
					</div>
				</div>
			</div>
			<div class="form-actions">
				<label class="checkbox">
				<input type="checkbox" name="remember" value="1" tabindex="3"/> Remember me
				</label>
				<button type="submit" class="btn green pull-right" tabindex="4" onclick="filtered_func(log.txtusername.value,log.txtpassword.value);">
				Login <i class="m-icon-swapright m-icon-white"></i>
				</button>            
			</div>
			<div class="forget-password">
				<h4>Forgot your password ?</h4>
				<p>
					no worries, click <a href="javascript:;"  id="forget-password">here</a>
					to reset your password.
				</p>
			</div>
			<input type="hidden" name="phpsession" value="<?php echo $_COOKIE['PHPSESSID'];?>">
			<input type="hidden" name="loginauthentication" value="<?php echo md5($login_authentication);?>">			
		</form>
		<!-- END LOGIN FORM -->        
		<!-- BEGIN FORGOT PASSWORD FORM -->
		<form class="form-vertical forget-form" action="forget.php" method="post">
			<h3 >Forget Password ?</h3>
			<p>Enter your registered e-mail address below to reset your password. We will send you your New Password in next 24 hours.</p>
			<div class="control-group">
				<div class="controls">
					<div class="input-icon left">
						<i class="icon-envelope"></i>
						<input class="m-wrap placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" />
					</div>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label visible-ie8 visible-ie9">Enter Code as shown in Image</label>
				<div class="controls">
					<div class="input-icon left">
						<i class="icon-lock"></i>
						<input type="text" id="security_code" style="width: 80px" tabindex="3" placeholder="Enter code"; class="m-wrap placeholder-no-fix" name="security_code" autocomplete="off" tabindex="3" oncopy="return false;" onpaste="return false;" oncut="return false;"/>	<img id="imgCaptcha" src="includes/create_image.php?scode=<?php echo $captcha_used; ?>" style="width:80px; height: 30px;"/>	
					</div>
				</div>
			</div>
			<div class="form-actions">
				<button type="button" id="back-btn" class="btn">
				<i class="m-icon-swapleft"></i> Back
				</button>
				<button type="submit" name="forgetSubmit" class="btn green pull-right">
				Submit <i class="m-icon-swapright m-icon-white"></i>
				</button>            
			</div>
			<input type="hidden" value="<?php echo $_SESSION['capture_code'];?>" name="log">
		</form>		<!-- END FORGOT PASSWORD FORM -->
		<!-- BEGIN REGISTRATION FORM -->
		<!-- END REGISTRATION FORM -->
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
?>
