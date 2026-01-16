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
		
		include_once "rmail.php";
		$data = mysql_fetch_array( mysql_query( "select * from grievance where otp_send = '$_POST[otpcode]' and phone = '$_POST[phone]'"));
		mysql_query("update grievance set otp_entered = '$_POST[otpcode]', otp_entered_date = '$crdate', otp_status= 'numberverified', status = 'pending' where  otp_send = '$_POST[otpcode]' and phone = '$_POST[phone]'");
		
		$grievanceid = $data['uniqueid'];
		
		$mail = $data['email'];
		
$msg="Dear ".ucwords(strtolower($data['name'])).",

Thank you for using Forest Survey of India Complaint/ Grievance Registration service. Your Complaint is now registered successfully.

Your Grievance ID is ".$grievanceid.". You can use this Unique ID to track your complaint.

To track your complaint, use following link

http://webline.co.in/fsinewwebb/track-complaint.php?grievance=".$grievanceid."

You Provide us following details
----------------------------------------------
\nName :- ".$data['name']."		
\nAddress : - ".$data['address']."
\nPhone Number :- ".$data['phone']."		
\nEmail ID : - ".$data['email']."

\nGrievance Type :- ".$grievanceType."
\nComplaint Details :- ".$data['complaint']."
Complaint Registered on :- ".date('d-M-Y')."

Regards,
Forest Survey of India";
		
	    $remarks = "Application registered successfully on ".$crdate;
		
		$sendMsg = "Your complaint in Forest Survey of India Portal is now registered. Your Complaint ID is ".$grievanceid.". You will be updated soon.";
		$common->send_sms( $data['phone'], $sendMsg );	
			
		$m= new TMail; 
		$m->From( "no-reply@fsi.nic.in" );
		$m->To($mail);
		$m->Subject("[Forest Survey of India] Complaint registered Successfully!!");
		$m->Body($msg);
		$m->Bcc("weblineservices@yahoo.co.in, manish@webline.in, shoaib@webline.in");
		$m->Priority(4);
		$m->Send();
		ob_flush();
		echo "<script type='text/javascript'>location.href='contact-us&action=done&grievanceid=$grievanceid' </script> ";
					
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