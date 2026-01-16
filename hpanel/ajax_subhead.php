<?php
include "control.php";
$d=date('d');
$m =date('m');
$y =date('Y');

$pdate =$y ."/".$m ."/".$d ;

$sql_f="select * from sub_heading where heading='$_GET[cu]' and status='active'";

?>

<select name="subheading" onchange="subheadchange(this.value)" size="1">
		<?php
		if(mysql_num_rows(mysql_query($sql_f))>0)
		{
		?>
		<option value="">Select Sub Heading</option>
		<?
		}
			$rsff=mysql_query($sql_f);
			while($row_m=mysql_fetch_array($rsff))
			{
		?>
		<option value="<?echo $row_m['sno']?>"><?echo $row_m['subhead']?></option><?
			}
			
		if(mysql_num_rows(mysql_query($sql_f))==0)
		{
		?>
		<option value="">No Records Found</option>
		<?
		}
		?></select>
