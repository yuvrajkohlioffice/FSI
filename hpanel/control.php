<?php
ob_start();
if(session_status() === PHP_SESSION_NONE)
{
	session_start();
}
error_reporting(1);

$msie    = strpos($_SERVER["HTTP_USER_AGENT"], 'MSIE') ? true : false;
$firefox = strpos($_SERVER["HTTP_USER_AGENT"], 'Firefox') ? true : false;
$safari  = strpos($_SERVER["HTTP_USER_AGENT"], 'Safari') ? true : false;
$chrome  = strpos($_SERVER["HTTP_USER_AGENT"], 'Chrome') ? true : false;

if (!ini_get('register_globals')) {
    $superglobals = array($_SERVER, $_ENV,
        $_FILES, $_COOKIE, $_POST, $_GET);
    if (isset($_SESSION)) {
        array_unshift($superglobals, $_SESSION);
    }
    foreach ($superglobals as $superglobal) {
        extract($superglobal, EXTR_SKIP);
    }
}

$sessname=session_name();
$sess_ID=session_id();
header("Set-Cookie: $sessname=$sess_ID; httpOnly");
header("Set-Cookie: intro_show=$_COOKIE[intro_show]; httpOnly");

include("database.php");
db_connect();

$crdate = date("Y-m-d");
$timestamp = strtotime(date("Y-m-d H:i:s"));

//******************************** AUTOMATED LOGOUT *************************//

$inactive = 900; // Set timeout period in seconds

if (isset($_SESSION['timeout'])) {
    $session_life = time() - $_SESSION['timeout'];
    if ($session_life > $inactive) {
        session_destroy();
		unset($_SESSION['post_log_codes']);
		echo "<script>location.href='logout.php?loginauth=auto'</script>";
    }
}
$_SESSION['timeout'] = time();
if(!isset($_SESSION['post_log_codes']))
	$_SESSION['post_log_codes'] = $_POST['security_code'];

//******************************** AUTOMATED LOGOUT *************************//
	if (isset($_COOKIE['login_authentication'])) 
	{
		$md5_hash = md5(rand(0,999)); 
		$login_authentication = substr($md5_hash, 16, 16); 
		$_SESSION['authToken'] = md5($login_authentication);
		$_POST['loginauthentication'] = md5($login_authentication);
		
	    setcookie('login_authentication', '', time() - 3600, '/hpanel'); // empty value and old timestamp
	    setcookie('login_authentication', '', time() - 3600, '/'); 
		setcookie("login_authentication", $_POST[loginauthentication], null, '/hpanel', null, null, true);
		
		$postAuthToken = $_POST['loginauthentication'];
		$sessionAuthToken = $_SESSION['authToken'];
	}
	else
	{
		$postAuthToken = $_POST['loginauthentication'];
		$sessionAuthToken = $_SESSION['authToken'];
	}
	
	if(empty($_SESSION['uname']))
	{
		$capture = preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['log_capture_code']));
		$postcapture = preg_replace('/[^a-zA-Z0-9]/', '', trim($_POST['security_code']));
		if( $capture!= $postcapture || $capture=="" || $postcapture=="")
		{
			session_destroy();
			session_regenerate_id(true);
			header("location:index.php?loginauth=incorrect");
		}
		$txtusername = $_POST['txtusername'];
		$txtpassword = $_POST['txtpassword'];
		$security_code = $_POST['security_code'];
		$phpsession = $_POST['phpsession']; 
	}
	
	
	if(!empty($_SESSION['uname']))
	{	
		$txtusername = $_SESSION['uname'];
		$txtpassword = $_SESSION['pwd'];
		$security_code = $_SESSION['post_log_codes'];
		$phpsession = $_SESSION['phpsession']; 
	}
	
	if(empty($_SESSION['uname']))
	{
		$_SESSION['uname'] = $_POST['txtusername'];
		$_SESSION['pwd']= $_POST['txtpassword'];
		$_SESSION['post_log_codes'] = $_POST['security_code'];
		$_SESSION['phpsession'] = $_POST['phpsession']; 		
	}
	
	if(!isset($txtusername))
	{
		header("location:index.php?loginauth=incorrect");
		exit;
	}
	if (!isset($_SESSION['HTTP_USER_AGENT']))
	{
	    $_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
	}
	if (isset($_SESSION['HTTP_USER_AGENT']))
	{
	    if ($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT']))
	    {
			unset($_SESSION['post_log_codes']);
			echo "<script>location.href='index.php?loginauth=unauthorize'</script>";
	    }
	}
//********************** FUNCTION TO MAKE LOGIN SECURE *******************************//
	$capture = preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['log_capture_code']));
	$postcapture = preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['post_log_codes']));
	
	$cookie_capture = preg_replace('/[^a-zA-Z0-9]/', '', trim($_COOKIE['PHPSESSID']));
	$post_cookie_capture = preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['php_session_id'])); 
	
	$csrfpostAuthToken = preg_replace('/[^a-zA-Z0-9]/', '', trim($postAuthToken));
	$csrfsessionAuthToken = preg_replace('/[^a-zA-Z0-9]/', '', trim($sessionAuthToken )); 
	
	if($capture==$postcapture && $capture!="" && $postcapture!="" && $cookie_capture == $post_cookie_capture && $cookie_capture !="" && $post_cookie_capture !="" && $csrfpostAuthToken == $csrfsessionAuthToken && $csrfpostAuthToken !="" && $csrfsessionAuthToken !="")
	{
		function secure_login($webusername)
		{
			$webusername=mysql_real_escape_string(trim($webusername));
			return $webusername;
		}
		
		function filter_xss_login($data)
		{
			// Fix &entity\n;
			$data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
			$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
			$data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
			$data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');
			
			// Remove any attribute starting with "on" or xmlns
			$data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);
			
			// Remove javascript: and vbscript: protocols
			$data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
			$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
			$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);
			
			// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
			$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
			$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
			$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);
			
			// Remove namespaced elements (we do not need them)
			$data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);
			
			do
			{
				// Remove really unwanted tags
				$old_data = $data;
				$data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
			}
			while ($old_data !== $data);
			
			// we are done...
			return $data;
		}
				
		$webname1 = filter_xss_login(secure_login($_SESSION['uname']));
		$webpass1 = filter_xss_login(secure_login($_SESSION['pwd'])); // CONVERTING USER ENTERED STRING IN ENCRYPTED FORMAT
		//echo "<br/>2";
		$sql_user="select * from admin where uname = '$webname1' and status = 'active'";
	
		$result = mysql_query($sql_user);
		
		$row_user = mysql_fetch_array($result);

		$converted = md5($_SESSION['salted_hash'].$row_user['password']);
		//die();
		$currentSessID = session_id();	
		
		$currentDate = strtotime( date("Y-m-d"));
		if( $row_user['is_login'] == 1 && $row_user['last_login'] < $currentDate )
			$query = mysql_query( "update admin set is_login = 0 , session_id = ''" );	
		
		if($webpass1!=$converted)
		{
			unset($_SESSION['uname']);
			unset($_SESSION['pwd']);
			
			$details = "Invalid attempt to login with username <strong>admin</strong>";
			
			$query = "insert into activity_log set details ='$details', type= 'backend', purpose = 'Failed Login Attempted', userid = '0', ip_address = '$_SERVER[REMOTE_ADDR]', browser = '$_SERVER[HTTP_USER_AGENT]', createdon = '$timestamp', crdate = '$crdate'";
			
			$response = save_details($query, "true");
			unset($_SESSION['post_log_codes']);

			echo "<script>location.href='index.php?loginauth=incorrect'</script>";
			exit;
		}
		else if($webpass1==$converted)
		{	
			$_SESSION['uniqueid'] = $row_user['uid'];
			if(isset($_SERVER['HTTP_REFERER']))
			{			
				$path=$_SERVER['HTTP_REFERER'];
				$urlparse = parse_url($path);			
				
				$sessID=session_id();
				if($urlparse['path'] == "/hpanel/index.php" || $urlparse['path'] == "/hpanel/")
				{				
						session_regenerate_id(true); 
						$sessname=session_name();
						$sessID=session_id();
						
						if (isset($_COOKIE['PHPSESSID'])) {
						    unset($_COOKIE['PHPSESSID']);
						    if (isset($_SERVER['HTTP_USER_AGENT']) && strlen(strstr($_SERVER['HTTP_USER_AGENT'], 'Firefox')) > 0 )
						    {
						    	setcookie('PHPSESSID', '', time() - 3600, '/hpanel/'); // empty value and old timestamp
						    }
						    else
						    {
						    	setcookie('PHPSESSID', '', time() - 3600, '/hpanel'); // empty value and old timestamp
						    }    
						   
						    setcookie('PHPSESSID', '', time() - 3600, '/'); 
						    $_SESSION['php_session_id'] = $sessID;
						}
						if (!isset($_COOKIE['login_authentication'])) 
						{
							$md5_hash = md5(rand(0,999)); 
							$login_authentication = substr($md5_hash, 16, 16); 
							$_SESSION['authToken'] = md5($login_authentication);
							$_POST['loginauthentication'] = md5($login_authentication);
					
							setcookie("login_authentication", $_POST[loginauthentication], null, '/hpanel', null, null, true);
							
						}	
						
						setcookie($sessname, session_id(), null, '/hpanel', null, null, true);						
						$details = "Login Successful with Username <strong>admin</strong>";
			
						$query = "insert into activity_log set details ='$details', type= 'backend', purpose = 'Successful Login Attempted', userid = '".$row_user['uid']."', ip_address = '$_SERVER[REMOTE_ADDR]', browser = '$_SERVER[HTTP_USER_AGENT]', createdon = '$timestamp', crdate = '$crdate'";
						
						$response = save_details($query, "true");
						
						$insert="insert into admin_log set ipaddress='$_SERVER[REMOTE_ADDR]', userid='$row_user[uid]', browseragent='$_SERVER[HTTP_USER_AGENT]', accesthrough='$path', type='login', session_id='$sessID'";
						$response = save_details($insert, "true");	
						$lastLogin = strtotime(date("Y-m-d"));
						if( $row_user['is_login'] == 0 )
							$query = mysql_query( "update admin set is_login = 1 , session_id = '$sessID', last_login = '$lastLogin'" );	
	
						$update = mysql_query("update admin set last_login = '$timestamp'");
						
				}
			}
				
		}
	}
	else
	{
			unset($_SESSION['post_log_codes']);
			echo "<script>location.href='index.php?loginauth=unauthorize'</script>";
	}
?>	

<?php

	ob_end_flush();
?>
