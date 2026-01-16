<?php
include "../hpanel/database.php";
db_connect();
if( isset($_GET['cu']) && $_GET['cu'] != '' )
{
	$d = date('d');
	$m = date('m');
	$y = date('Y');
	
	$pdate = $m ."-".$d ;

	$firepoint_id = preg_replace('/[^a-zA-Z0-9 \-]/', '', trim($_GET['cu']));
	
	if( !empty($firepoint_id) )
	{
	
		$sql1 = "select distinct(district) from firepoint where state like '%$firepoint_id%' order by district asc";
	
		$result1 = mysql_query($sql1);
		if( mysql_num_rows($result1) > 0 )
		{
?>
<p align="left">
<select name="district[]" size="1" width= "4" style="font-family: Verdana; font-size: 8pt; color: #000000">
<option value="-">Select District</option>
<?php
while($row1=mysql_fetch_array($result1))
{
?>
<option value="<?php echo urlencode($row1[0]);?>"><?php echo $row1[0];?></option>
<?
}
?>
</select></p>
<?php
		}
		else
		{
			echo "No Records found.";
		}
	}
	else
	{	
		header ("Location:../index.php");
		exit;
	}
}
else
{
		header ("Location:../index.php");
		exit;
}
?>