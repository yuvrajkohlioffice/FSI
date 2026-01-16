<?php
include "database.php";
db_connect();
$d=date('d');
$m =date('m');
$y =date('Y');

$pdate =$m ."-".$d ;
if(isset($_GET["cu"]))
$q=$_GET["cu"];
if(isset($_GET["cu1"]))
$q1=$_GET["cu1"];


$sql1="select distinct(district) from firepoint where state like '%$q%' order by district asc";


$result1=mysql_query($sql1);
?>
<p align="left">
<select name="district[]" size="1" width= "4" style="font-family: Verdana; font-size: 8pt; color: #000000">
<option value="-">Select District</option>
<?
while($row1=mysql_fetch_array($result1))
{
?>
<option value="<?echo $row1[0]?>"><?echo $row1[0]?></option>
<?
}
?>
</select></p>
