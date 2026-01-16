<?php
session_start();
include "../includes/classes.php";
echo "Loading, please wait..";
if(isset($_GET['action']) && $_GET['action'] == 'save')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_POST['security_code']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		$pdate=date("Y-m-d");
		
		$txtname= preg_replace('/[^a-zA-Z0-9- ]/','',$_POST['txtname']);
		$designation= preg_replace('/[^a-zA-Z0-9- ]/','',$_POST['designation']);
		$organization= preg_replace('/[^a-zA-Z0-9- ]/','',$_POST['organization']);
		$address= preg_replace('/[^a-zA-Z0-9- ]/','',$_POST['address']);
		$country= preg_replace('/[^a-zA-Z0-9- ]/','',$_POST['country']);
		$pin= preg_replace('/[^a-zA-Z0-9- ]/','',$_POST['pin']);
		$phone= preg_replace('/[^a-zA-Z0-9- ]/','',$_POST['phone']);
		$mobile= preg_replace('/[^a-zA-Z0-9- ]/','',$_POST['mobile']);
		$email= preg_replace('/[^a-zA-Z0-9-@._ ]/','',$_POST['email']);
		$password= preg_replace('/[^a-zA-Z0-9-@._ ]/','',$_POST['password']);
		
		$sql1="select * from registration where email='$email'";
		$cou=mysql_num_rows(mysql_query($sql1));
	
		if($cou==0)
		{		
			$state = urldecode($_POST['state']);
			$district[0] = urldecode($_POST['district'][0]);
			$district[1] = urldecode($_POST['district'][1]);
			$district[2] = urldecode($_POST['district'][2]);
			$district[3] = urldecode($_POST['district'][3]);
			
			$sql="insert into registration(name,designation,organization,address,state,district1,district2,district3,district4,country,pin,phone,mobile,email,password,status,crdate,alert,zeroalert) values('$txtname','$designation','$organization','$address','$state','$district[0]','$district[1]','$district[2]','$district[3]','$country','$pin','$phone','$mobile','$email','$password','active','$pdate','$alert','$zeroalert')";
			
			$rs = mysql_query($sql);
			
			if($rs)
				echo "<script>alert('Successfully Registered!!');location.href='../forest-fire.php'</script>";
			else
				echo "<script>location.href='add_student.php?status=error'</script>";
		}
		else
		{
				echo "<script>location.href='add_student.php?status=duplicate'</script>";
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='add_student.php?status=unauthorize'</script>";
	}
}
else
{
	echo "<script>alert('Unauthorize Access!!');location.href='add_student.php?status=unauthorize'</script>";
}
