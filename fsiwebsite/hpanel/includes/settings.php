<?php

	include_once "hpanel/database.php";
	db_connect();
	
	$row_settings=mysql_fetch_array(mysql_query("select website_name,website_url from settings"));
	
	$website_name=$row_settings['website_name'];

	$row_settings=mysql_fetch_array(mysql_query("select message from maintenance"));
	
	$message=$row_settings['message'];
	
	$ip_checking_maintenance=mysql_query("select ip_address from ip_address where status='active' and ip_address='$_SERVER[REMOTE_ADDR]'");
	
	$checking_maintenance=mysql_query("select sno from maintenance where status=1");
	if(mysql_num_rows($checking_maintenance)==0 || mysql_num_rows($ip_checking_maintenance)>0)
	{
		$maintenance=0;
		echo "<script>location.href='index.php';</script>";
	}
?>