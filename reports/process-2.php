<?php
//error_reporting(0);
session_start();
include_once "includes/classes.php";
require('../../vendor/autoload.php');
$secret = '6LdPdT4UAAAAAE2MNzkkrZqTxXUnzj4diGqLGMvU';
$recaptcha = new \ReCaptcha\ReCaptcha($secret);
$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
if ($resp->isSuccess())
{
    if( isset($_POST['registration_submit']) )
    {	
    	$crdate = date( "Y-m-d" );
    	
    	if( $_POST['other_grievance'] != "" )
    		$grievanceType = $_POST['other_grievance'];
    	else
    		$grievanceType = $_POST['grievance_type'];
    	
    	include_once "rmail.php";
    	
    	$grievanceid = date("ymdhi").rand( 100, 9999 );
    	
    	$mail = $_POST['email'];
    	
    	$otp = rand( 1000, 10000);
    	
    	$rs = mysql_query("insert into grievance set uniqueid = '$grievanceid', name = '$_POST[name]', address = '$_POST[address]', email = '$_POST[email]', phone = '$_POST[mobile]', grievanceType = '$grievanceType', details = '$_POST[complaint]', ip_address = '$_SERVER[REMOTE_ADDR]', browser = '$_SERVER[HTTP_USER_AGENT]', crdate = '$crdate', status = 'verification', otp_send = '$otp', otp_send_date = '$crdate', otp_status = 'verificationpending', last_remarks = '$remarks'");
    	
    	if( $rs )
    	{
    		$sendMsg = "Please enter the OTP code to verify your Phone number for registering complaint in Forest Survey of India Portal. OTP Code ".$otp;
    		$common->send_sms( $_POST['mobile'], $sendMsg );			
    		echo "<script type='text/javascript'>location.href='grievance-verification.php?action=verificationpending'</script> ";
    	}		
    	else
    	{		
    		echo "<script type='text/javascript'>location.href='grievance.php?status=error' </script> ";
    	}			
	}
	else
	{
			ob_flush();			
			echo "<script type='text/javascript'>location.href='grievance.php?status=error' </script> ";
	}
}
else
{
	ob_flush();
	echo "<script type='text/javascript'>location.href='grievance.php?status=invalid' </script> ";	
}
?>