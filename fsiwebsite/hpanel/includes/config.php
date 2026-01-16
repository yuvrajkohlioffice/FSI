<?php

	include_once "hpanel/database.php";
	db_connect();
	
	$maintenance=0;
	
	$row_settings=mysql_fetch_array(mysql_query("select website_name from settings"));
	
	$website_name=$row_settings['website_name'];
	
	$checking_maintenance=mysql_query("select sno from maintenance where status=1");
	
	$ip_checking_maintenance=mysql_query("select ip_address from ip_address where status='active' and ip_address='$_SERVER[REMOTE_ADDR]'");
	
	if(mysql_num_rows($checking_maintenance)>0 && mysql_num_rows($ip_checking_maintenance)==0)
	{
		$maintenance=1;
		echo "<script>location.href='maintenance-mode.php';</script>";
	}
	
	$today_date = date("Y-m-d");
	
	include_once "constant.php";

?>