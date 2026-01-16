<?php
session_start();
include_once "includes/functions.php";
include_once "database.php";
db_connect();

protect_session_id();

$timestamp = strtotime(date("Y-m-d H:i:s"));
$sessID=session_id();


$insert="insert into admin_log set ipaddress='$_SERVER[REMOTE_ADDR]', userid='$_SESSION[uname]', browseragent='$_SERVER[HTTP_USER_AGENT]', accesthrough='$path', session_id='$sessID' ,type='logout'";

save_details($insert, "query");

$details = "<strong>admin</strong> successfully logout";

$query = "insert into activity_log set details ='$details', type= 'backend', purpose = 'Successfully logout', userid = '$_SESSION[uniqueid]', ip_address = '$_SERVER[REMOTE_ADDR]', browser = '$_SERVER[HTTP_USER_AGENT]', createdon = '$timestamp', crdate = '$crdate'";
		
$response = save_details($query, "true");
unset($_SESSION['post_log_codes']);

session_destroy();
session_unset();
session_regenerate_id();

echo "<script>location.href='index.php?loginauth=logout'</script>";
?>