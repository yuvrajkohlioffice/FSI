<?php
	include_once "control.php";
	include "rmail.php";

	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_POST['log']));
	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		// set from Name 
		$response = 0;

		if($_POST['state']!='all')
		{
			
			include_once "class.phpmailer.php";
			
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = "ssl";
			$mail->Host = "wipl.net.in";
			$mail->Port = "465";
			$mail->Username = "fsi_mail@wipl.net.in";
			$mail->Password = "fsiwipl@2014!";
			$mail->From = "forestfiremonitoring@gmail.com";
			$mail->FromName = "Forest Fire Monitoring";				
			
			$kml_date = date("Y-m-d",strtotime($_POST['fdate1']));
			
			$chk="select ser,extension,date from upload_kml where state='".$_POST['state']."' and date='".$kml_date."' and status='active'";
			$row_chk=mysql_fetch_array(mysql_query($chk));
			$attach="../uploads/kmlfiles/".$row_chk['extension'];
			$ftype=filetype($attach);
			 
			$f_type = mime_content_type($attach);
			
			if(mysql_num_rows(mysql_query($chk))==0)
			{
				echo "<script>alert('KML File of this date not found!!!');location.href='send-kml.php';</script>";	
			}
			
			$sta="select name from state where sno='".$_POST['state']."' and status='active'";
			$row_state=mysql_fetch_array(mysql_query($sta));
		
			//$mail->Subject="Forest Fire alert for ".date('d-M-Y',strtotime($row_chk[date]))." of ".$row_state['name'];
			
			$subject = "Forest Fire alert for ".date('d-M-Y',strtotime($row_chk[date]))." of ".$row_state['name'];

			$em_fetch=mysql_query("select * from registration where status='active' and state='".$_POST['state']."'");
			while($row_em=mysql_fetch_array($em_fetch))
			{
		
$msg="
Dear Sir,

Please find enclosed fire points as a kml file attachment. Download the file & double click on downloaded file, it would be uploaded automatically on google earth.(Google Earth should be installed on your Computer System)";
if($row_em['feedbacklink']=='yes')
{

$msg.='For the feedback, click or copy and paste the following link on any browser:

http://www.fsi.org.in/feedback_state.php?state='.$row_em[state] .'&emailtype='.md5("email").'';
}
$msg.='

FSI
Fire Monitoring Team
0-135-2757158, 2752901';


					//$mail->AddAddress("forestfiremonitoring@gmail.com", "Forest Fire Monitoring"); // to Address
					$mail->Subject="Forest Fire alert for ".date('d-M-Y',strtotime($row_chk[date]))." of ".$row_state['name'];

					$mail->AddAddress("shoaib@weblineinfosoft.com", "Test"); // to Address
					//$mail->AddAddress("$row_em[email]", "$row_em[username]"); // to Address
					$mail->AddBCC("weblineservices@yahoo.co.in", "Forest Fire Monitoring");
					$mail->AddReplyTo("forestfiremonitoring@gmail.com", "Forest Fire Monitoring");
	
					$mail->Body = $msg;
					
					echo $mail->AddAttachment($attach);
			
					if(!$mail->Send())
					{
					   $response = 0;
					}
					else
					{
					   $response = 1;
					}
		
					/*$m = new TMail;
				
					$m->From("forestfiremonitoring@gmail.com");*/
				
					//$m->To($row_em['email']);
					
					/*$m->To("shoaib@weblineinfosoft.com");
				
					$m->Subject($subject);
				
					$m->Body($msg);		
					
					$m->Bcc("rajmathurrules@gmail.com, weblineservices@yahoo.co.in");	
					
					$m->Attach($attach, $f_type);	
				
					$m->Priority(1);
				
					$response = $m->Send();	*/				
			
					//$mail->set('X-Priority', '4'); //Priority 1 = High, 3 = Normal, 5 = low	
			}
			if($response)
			{
				echo "<script>alert('Mail send sucessfully!!');location.href='send-kml.php?status=success';</script>";
			}
			else
			{
				echo "<script>alert('Error!! Unable to send email!');location.href='send-kml.php?status=error';</script>";
			}
		}
		else if(filter_xss($_POST['state'])=='all')
		{
			$state=mysql_query("select name,sno from state where status='active' order by name");
		
			while($row_state=mysql_fetch_array($state))
			{
				$kml_date = date("Y-m-d",strtotime($_POST['fdate1']));

				$chk="select ser,extension,date from upload_kml where state='".$row_state['sno']."' and date='".$kml_date."' and status='active'";
				$row_chk=mysql_fetch_array(mysql_query($chk));
				$attach="../uploads/kmlfiles/".$row_chk['extension'];
				$ftype=filetype($attach);
				
				$sta="select name from state where sno='".$_POST['state']."' and status='active'";
				$row_state=mysql_fetch_array(mysql_query($sta));
		
				$mail->Subject="Forest Fire alert for ".date('d-M-Y',strtotime($row_chk[date]))." of ".$row_state['name'];
				
				$em_fetch=mysql_query("select * from registration where status='active' and state='$row_state[sno]'");
				while($row_em=mysql_fetch_array($em_fetch))
				{
			
$msg="
Dear Sir,

Please find enclosed fire points as a kml file attachment. Download the file & double click on downloaded file, it would be uploaded automatically on google earth.(Google Earth should be installed on your Computer System)";
if($row_em['feedbacklink']=='yes')
{

$msg.='For the feedback, click or copy and paste the following link on any browser:

http://www.fsi.org.in/feedback_state.php?state='.$row_em[state] .'&emailtype='.md5("email").'';
}
$msg.='

FSI
Fire Monitoring Team
0-135-2757158, 2752901';  
					
					$m = new TMail;
				
					$m->From("forestfiremonitoring@gmail.com");
				
					$m->To($row_em['email']);
					//$m->To("shoaib@weblineinfosoft.com");
				
					$m->Subject($subject);
				
					$m->Body($msg);		
					
					$m->Bcc("rajmathurrules@gmail.com, weblineservices@yahoo.co.in");		
					
					$m->Attach($attach, $f_type);	
				
					$m->Priority(1);
				
					$response = $m->Send();		
				}
			}
			if($response)
			{
				echo "<script>alert('Mail send sucessfully!!');location.href='send-kml.php?status=success';</script>";
			}
			else
			{
				echo "<script>alert('Error!! Unable to send email!');location.href='send-kml.php?status=error';</script>";
			}	
		}	
	}	
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='send-kml.php?status=codeinvalid'</script>";
	}

?> 