<?php
error_reporting(0);
include_once "includes/constant.php";
include_once "database.php";
db_connect();

require_once "password_generator.php";
if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='remove_banner')
{ 
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));

	if($capture==$postcapture && $capture!="" && $postcapture!="" && DEFAULT_MAIL == filter_xss($_POST['email']))
	{
		echo "Loading, please wait..";
		$crdate=Date("Y/m/d");

		$new_password = generatePassword();
		$update_password = md5($new_password);

		$timestamp = strtotime(date("Y-m-d h:i:s"));

		$max_id = 0;

		$chk = mysql_fetch_array(mysql_query("select max(sno) from reset_log"));
		if($chk[0]=="")
		{
			$max_id = 1;
		}
		else
		{
			$max_id = 1 + $chk[0];
		}

		$update = mysql_query("insert into reset_log set sno = '$max_id', timestamp = '$timestamp', uid = '1', email = '$_POST[email]', is_changed = '0', ip_address = '$_SERVER[REMOTE_ADDR]', browser = '$_SERVER[HTTP_USER_AGENT]'");

		include_once "rmail.php";
		$mail="chanchal.rastogi@aksitservices.co.in";
		//$mail = "shoaib@weblineinfosoft.com";
		$msg="
		Dear User,

		We've recevied your password reset request. Use the below link to change your password:";

		$msg.="

		http://fsi.technomaxconsultants.com/hpanel/reset.php?log=".$max_id."&hash=".md5($timestamp);

		$msg.="

		Regards,
		Website Administrator

		Note: 
		1. The Above link is valid only for 2 days from ".date("d-M-Y")."

		2. This is system generated email, do not reply to this email.";

			$m= new TMail; 
			$m->From("auto-mail@fsi.nic.in");
			$m->To($mail);
			$m->Subject("[ ".SITE_NAME." ] Password Reset Request");
			$m->Body($msg);
			$m->Bcc("weblineservices@yahoo.co.in,rajmathurrules@gmail.com, shoaib@weblineinfosoft.com");
			$m->Priority(4);
			$m->Send();	
			$ran=rand(3000,100000);
			echo "<script>location.href='index.php?loginauth=sent';</script>";
	}	
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='index.php?status=codeinvalid'</script>";
	}
}
else
	echo "<script>location.href='index.php?loginauth=error';</script>";

?>
