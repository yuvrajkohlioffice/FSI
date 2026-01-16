<?php
ob_start();
include_once "control.php"; 
$pdate=date("Y-m-d");
echo "Loading, please wait..";

if(isset($_POST['deleteval']))
{
	if(count($_POST['selectval'])>0)
	{
	 foreach($_POST['selectval'] as $valdelete)
	 {
		$rs = mysql_query("delete from firepoint where sno='$valdelete'");		
	 }
	}
}
else
{
	echo "<script>alert('No value selected.');</script>";
	echo "<script>location.href='firepoint-database.php?page=$_POST[delpage]';</script>";
}
if($rs)
	echo "<script>location.href='firepoint-database.php?display=delete&page=$_POST[delpage]';</script>";
else
	echo "<script>location.href='firepoint-database.php?error=incorrect&page=$_POST[delpage]';</script>";
exit;
ob_flush(); 
?> 