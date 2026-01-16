<?php
	session_start();
	include "../includes/classes.php";
	
	$md5_hash = md5(rand(0,999)); 
	$_SESSION['salted_hash'] = substr($md5_hash, 15, 6); 	
	
	$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 15, 6); 
	$_SESSION['capture_code'] = $security_code;
	
	
?>
<html>
<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Fire Registration</title>
<meta name="keywords" content="Administrative Panel">
<meta name="description" content="Administrative Panel">
<style>
A:active { color:#000000; text-decoration; }
A:hover { color:#ff0000; text-decoration: none; }
a
{
text-decoration:none
}
a:hover
{
text-decoration:underline;
text-weight:bold;
}
a:link
{
color:Green;
}
</style>

<SCRIPT src="cal/urchin.js" type=text/javascript></SCRIPT>
<SCRIPT src="cal/dhtmlgoodies_calendar.js" type=text/javascript></SCRIPT>
<LINK media=screen href="cal/dhtmlgoodies_calendar.css" 
type=text/css rel=stylesheet></LINK>

<script>
function uppop(url,a,c,b,d,w)
{
newwindow = open(url,'name', "width ="+a+", height = "+c+",top="+b+",left="+d+",scrollbars = "+w+"");
if(window.focus)
{
newwindow.focus()
} 
return false;
}
</script>
<style>
.error_box
{
	font-family: 'Arial';
	font-size: 10pt;
	background: #FF0000;
	color: #FFFFFF !important;
	padding: 6px;
	width: 70%;
	margin-bottom: 8px;
	border-radius: 8px;
}
</style>
<script type="text/javascript">
function isCharacterKey(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode == 32 || charCode == 8 || charCode == 44 || charCode == 46 || charCode == 45 || (charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122))
	return true;
	return false;
}
function isNumberKey(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 32 && (charCode < 40 || charCode > 57))
	return false;
	return true;
}
</script>
<script type="text/javascript">
 var whitespace = " \t\n\r";
function isEmpty(s) {
	return ((s == null) || (s.length == 0));
}
          
          function isWhitespace (s) {

		var i;

		// Is s empty?
		if (isEmpty(s)) return true;

		// Search through string's characters one by one
		// until we find a non-whitespace character.
		// When we do, return false; if we don't, return true.
		for (i = 0; i < s.length; i++)
		{
				// Check that current character isnt whitespace.
				var c = s.charAt(i);

				if (whitespace.indexOf(c) == -1) return false;
		}

		// All characters are whitespace.
		return true;
}
function isEmail (s) {

		// is s whitespace?
		if (isWhitespace(s)) return false;

		// there must be >= 1 character before @, so we
		// start looking at character position 1
		// (i.e. second character)
		var i = 1;
		var sLength = s.length;

		// look for @
		while ((i < sLength) && (s.charAt(i) != "@"))
		{ i++
		}

		if ((i >= sLength) || (s.charAt(i) != "@")) return false;
		else i += 2;

		// look for .
		while ((i < sLength) && (s.charAt(i) != "."))
		{ i++
		}

		// there must be at least one character after the .
		if ((i >= sLength - 1) || (s.charAt(i) != ".")) return false;
		else return true;
}
function Validateform(theform)
{
	if(theform.txtname.value.replace(/^\s+|\s+$/g,"")=="")
	{
		alert("Please enter Name!");
		theform.txtname.focus();
		theform.password.value = "";
		return (false);
	}
	if(theform.designation.value.replace(/^\s+|\s+$/g,"")=="")
	{
		alert("Please enter Designation!");
		theform.designation.focus();
		theform.password.value = "";		
		return (false);
	}
	if(theform.organization.value.replace(/^\s+|\s+$/g,"")=="")
	{
		alert("Please enter Organization!");
		theform.organization.focus();
		theform.password.value = "";		
		return (false);
	}
	if(theform.address.value.replace(/^\s+|\s+$/g,"")=="")
	{
		alert("Please enter Address!");
		theform.address.focus();
		theform.password.value = "";
		return (false);
	}	
	if(theform.country.value.replace(/^\s+|\s+$/g,"")=="")
	{
		alert("Please enter Country!");
		theform.country.focus();
		theform.password.value = "";
		return (false);
	}	
	if(theform.pin.value.replace(/^\s+|\s+$/g,"")=="")
	{
		alert("Please enter Pin Code!");
		theform.pin.focus();
		theform.password.value = "";
		return (false);
	}
	if(theform.phone.value.replace(/^\s+|\s+$/g,"")=="")
	{
		alert("Please enter Office Phone!");
		theform.phone.focus();
		theform.password.value = "";
		return (false);
	}		
	if(theform.mobile.value.replace(/^\s+|\s+$/g,"")=="")
	{
		alert("Please enter Mobile No.!");
		theform.mobile.focus();
		theform.password.value = "";
		return (false);
	}	
	if(!isEmail(theform.email.value)) 
	{
		alert("Please enter correct e-mail address");
		theform.email.value='';
		theform.password.value = "";
		theform.email.focus();
		return (false);
	}
	if(theform.password.value.replace(/^\s+|\s+$/g,"")=="")
	{
		alert("Please enter Password!");
		theform.password.focus();
		theform.password.value = "";
		return (false);
	}
    if(theform.security_code.value.replace(/^\s+|\s+$/g,"")=="")
	{
		alert('Please Enter Security Code!!');
		theform.security_code.focus();
		theform.password.value = "";
		return false;
	}
	if(theform.security_code.value!="<?php echo $security_code; ?>")
	{
		alert("Please Type Correct Security Code!!");
		theform.security_code.value="";
		theform.password.value = "";
	    theform.security_code.focus();
	    return(false);
	}
}
</script>
<script src="state.js"></script>
<script src="../js/md5.js"></script>
<script>
function filtered_func(theval)
{
	if(theval.replace(/^\s+|\s+$/g,"")!="")
	{
		theform.password.value = hex_md5(theval);
	}
}
</script>
</head>
<body topmargin="3" leftmargin="0" rightmargin="0" bottommargin="3">

<div align="center">

<table border="0" cellpadding="0" cellspacing="0" bordercolorlight="#000000" bordercolordark="#000000" id="table1" height="100%" style="border: 1px solid #193A01; ">
	<tr>
		<td valign="top" height="19">
	<div align="center">
	<table border="0" cellpadding="0" cellspacing="0" bordercolorlight="#000000" bordercolordark="#000000" id="table2">
		<tr>
			<td width="100%" style="border-left-width: 1px; border-right-width: 1px; border-top-width: 1px; border-bottom: 1px solid #800000" colspan="3">
			<p align="center">
			<img border="0" src="../images/head5.jpg" hspace="0" width="769" height="136"></td>
		</tr>
		<tr>
			<td width="45%" style="border-left-width: 1px; border-right-width: 1px; border-top-width: 1px; border-bottom: 1px solid #800000" height="20">
			<p align="left">
			<font color="#193A01" face="Verdana" style="font-size: 8pt; font-weight: 700">&nbsp;<font face="Verdana" size="1"><? echo date("g:i a F j, Y");?></font>&nbsp;&nbsp;&nbsp;&nbsp;
			</font></td>
			<td width="45%" style="border-left-width: 1px; border-right-width: 1px; border-top-width: 1px; border-bottom: 1px solid #800000" height="20">
			&nbsp;</td>
			<td width="10%" style="border-left-width: 1px; border-right-width: 1px; border-top-width: 1px; border-bottom: 1px solid #800000" height="20">
			&nbsp;</td>
		</tr>
	</table>
	</div>
</td>
	</tr>
	<tr>
		<td align="center" height="29">

<b><font face="Verdana" color="#800000">Registration Form</font></b></td>
	</tr>
	<tr>
		<td align="center">
		<?php
		if(isset($_GET['status']) && !empty($_GET['status']))
		{
			$token=preg_replace('/[^a-z]/', '', trim($_GET['status']));
			if($token=="error")
			{
				echo "<div class='error_box' id='divid'><font color='#FFFFFF'>Error Occured while updating your details.<br>Please try again.</font><br><br></div>";	
			}
			else if($token=="duplicate")
			{
				echo "<div class='error_box' id='divid'><font color='#FFFFFF'>Username with same name already exists.</font><br><br></div>";	
			}
			else if($token=="unauthorize")
			{
				echo "<div class='error_box' id='divid'><font color='#FFFFFF'>Unauthorize Access.</font><br><br></div>";	
			}
		}
		?>
<form name="theform" method="post" action="registration.php?action=<?echo 'save'?>" onsubmit="return Validateform(this)" autocomplete="off">
	<table border="1" width="74%" id="table3" cellpadding="4" bordercolor="#008000" style="border-collapse: collapse">
		<tr>
			<td colspan="2">
			<div align="center">
				<table border="0" cellpadding="0" style="border-collapse: collapse" width="100%" id="table4">
					<tr>
						<td>
			<font color="#FF0000" face="Verdana" style="font-size: 8pt">* 
						Mandatory field</font></td>
						<td>
			<p align="right">
			<font color="#FF0000" face="Verdana" style="font-size: 9pt; font-weight: 700">
			<a href="javascript:history.back(-1)">
			<span style="text-decoration: none">&lt;&lt; back</span></a></font></td>
					</tr>
				</table>
			</div>
			</td>
		</tr>
		<tr>
			<td width="215"><font face="Verdana" style="font-size: 8pt">Name
			<font color="#FF0000">*</font></font></td>
			<td width="334">
			<input type="text" name="txtname" size="34" style="border-style:solid; border-width:1px; font-family: Verdana; font-size: 8pt; padding-left:4px; padding-right:4px; padding-top:1px; padding-bottom:1px" onkeypress="return  isCharacterKey(event);"></td>
		</tr>
		<tr>
			<td width="215" height="31">
			<font style="font-size: 8pt" face="Verdana">Designation
			<font color="#FF0000">*</font></font></td>
			<td width="334" height="31">
			<input type="text" name="designation" size="34" style="border-style:solid; border-width:1px; font-family: Verdana; font-size: 8pt; padding-left:4px; padding-right:4px; padding-top:1px; padding-bottom:1px" onkeypress="return  isCharacterKey(event);"></td>
		</tr>
		<tr>
			<td width="215"><font face="Verdana" style="font-size: 8pt">
			Organization
			<font color="#FF0000">*</font></font></td>
			<td width="334">
										<input type="text" name="organization" size="34" style="border-style:solid; border-width:1px; font-family: Verdana; font-size: 8pt; padding-left:4px; padding-right:4px; padding-top:1px; padding-bottom:1px" onkeypress="return  isCharacterKey(event);"></td>
		</tr>
		<tr>
			<td width="215"><font face="Verdana" style="font-size: 8pt">Address
			<font color="#FF0000">*</font></font></td>
			<td width="334">
			<textarea rows="3" name="address" cols="33" style="border-style:solid; border-width:1px; font-family: Verdana; font-size: 8pt; padding-left:4px; padding-right:4px; padding-top:1px; padding-bottom:1px"></textarea></td>
		</tr>
		<tr>
			<td width="559" colspan="2" bgcolor="#F0FFF0">
			<p align="center">
			<font face="Verdana" style="font-size: 8pt; font-weight: 700">Select 
			State of your choice for which you want Fire Point Spots in your SMS</font></td>
			</tr>
		<tr>
			<td width="215"><font face="Verdana" style="font-size: 8pt">State</font></td>
			<td width="334">
<select size="1" name="state" style="font-family: Verdana; font-size: 10px" onchange="showclass(this.value);">
<option selected value="-">Select State</option>
<?
$sql12="select distinct(state) from firepoint order by state asc";
$result12=mysql_query($sql12) or die(mysql_error());
while($row12=mysql_fetch_array($result12))
{
?>
<option value="<?echo urlencode($row12[0])?>"><?echo $row12[0]?></option>
<?
}
?>
</select>
			</td>
		</tr>
		<tr>
			<td width="559" colspan="2" bgcolor="#F0FFF0">
			<p align="center">
			<font face="Verdana" style="font-size: 8pt; font-weight: 700">Select 
			District(s) of your choice for which you want Fire Point Spots in 
			your SMS</font></td>
		</tr>
		<tr>
			<td width="215" bgcolor="#E2EBED">
			<font face="Verdana" style="font-size: 8pt">District 
			1</font></td>
			<td width="334" bgcolor="#E2EBED">

<div align="center" id="classHint">
<p align="left">
<select size="1" name="district[]" style="font-family: Verdana; font-size: 10px" >
<option selected value="-">Select District1</option>
</select>
</div>

</td>
		</tr>
		<tr>
			<td width="215" bgcolor="#E2EBED"><font face="Verdana" style="font-size: 8pt">District 
			2</font></td>
			<td width="334" bgcolor="#E2EBED">
<div align="center" id="classHint1">
<p align="left">
<select size="1" name="district[]" style="font-family: Verdana; font-size: 10px" >
<option selected value="-">Select District2</option>
</select>
</div>
</td>
		</tr>
		<tr>
			<td width="215" bgcolor="#E2EBED"><font face="Verdana" style="font-size: 8pt">District 
			3</font></td>
			<td width="334" bgcolor="#E2EBED">
<div align="center" id="classHint2">
<p align="left">
<select size="1" name="district[]" style="font-family: Verdana; font-size: 10px" >
<option selected value="-">Select District3</option>
</select>
</div>
			</td>
		</tr>
		<tr>
			<td width="215" bgcolor="#E2EBED"><font face="Verdana" style="font-size: 8pt">District 
			4</font></td>
			<td width="334" bgcolor="#E2EBED">
<div align="center" id="classHint3">
<p align="left">
<select size="1" name="district[]" style="font-family: Verdana; font-size: 10px" >
<option selected value="-">Select District4</option>
</select>
</div>
</td>
		</tr>
		<tr>
			<td width="215"><font face="Verdana" style="font-size: 8pt">Country
			<font color="#FF0000">*</font></font></td>
			<td width="334">
			<input type="text" name="country" size="34" style="border-style:solid; border-width:1px; font-family: Verdana; font-size: 8pt; padding-left:4px; padding-right:4px; padding-top:1px; padding-bottom:1px" value="India" onkeypress="return  isCharacterKey(event);"></td>
		</tr>
		<tr>
			<td width="215"><font face="Verdana" style="font-size: 8pt">Pin
			<font color="#FF0000">*</font></font></td>
			<td width="334">
			<input type="text" name="pin" size="34" style="border-style:solid; border-width:1px; font-family: Verdana; font-size: 8pt; padding-left:4px; padding-right:4px; padding-top:1px; padding-bottom:1px" onkeypress="return  isNumberKey(event);" maxlength="10"></td>
		</tr>
		<tr>
			<td width="215"><font style="font-size: 8pt" face="Verdana">Office 
			Phone
			<font color="#FF0000">*</font></font></td>
			<td width="334">
			<input type="text" name="phone" maxlength="12" size="34" style="border-style:solid; border-width:1px; font-family: Verdana; font-size: 8pt; padding-left:4px; padding-right:4px; padding-top:1px; padding-bottom:1px" onkeypress="return  isNumberKey(event);" maxlength="14"></td>
		</tr>
		<tr>
			<td width="215"><font style="font-size: 8pt" face="Verdana">Mobile
			<font color="#FF0000">*</font></font></td>
			<td width="334">
			<input type="text" name="mobile" maxlength="10" size="34" style="border-style:solid; border-width:1px; font-family: Verdana; font-size: 8pt; padding-left:4px; padding-right:4px; padding-top:1px; padding-bottom:1px" onkeypress="return  isNumberKey(event);" maxlength="10"></td>
		</tr>
		<tr>
			<td width="215"><font face="Verdana" style="font-size: 8pt">Email
			<font color="#FF0000">(Will be used as User Name) *</font></font></td>
			<td width="334">
			<input type="text" name="email" size="34" style="border-style:solid; border-width:1px; font-family: Verdana; font-size: 8pt; padding-left:4px; padding-right:4px; padding-top:1px; padding-bottom:1px"></td>
		</tr>
		<tr>
			<td width="215"><font style="font-size: 8pt" face="Verdana">Password
			<font color="#FF0000">*</font></font></td>
			<td width="334">
			<input type="password" name="password" size="34" style="border-style:solid; border-width:1px; font-family: Verdana; font-size: 8pt; padding-left:4px; padding-right:4px; padding-top:1px; padding-bottom:1px"></td>
		</tr>
		<tr>
			<td width="215" height="32">
			<font style="font-size: 8pt" face="Verdana">Zero Alert</font></td>
			<td width="334" height="32">
			<select size="1" name="zeroalert" style="border-style:solid; border-width:1px; font-family: Verdana; font-size: 8pt; padding-left:4px; padding-right:4px; padding-top:1px; padding-bottom:1px">
		<option value="Yes" selected>Yes</option>
		<option value="No">No</option>
		</select></td>
		</tr>
		<tr>
			<td width="559" height="40" colspan="2" bgcolor="#004A4A">
			<p align="center" style="line-height: 150%; margin-top: 0; margin-bottom: 0">
			<font face="Verdana" style="font-size: 9pt; font-weight: 700" color="#FFFFD5">
			What is Zero Alert :- In case of No Forest Fire Spots being detected 
			a sms/email stating zero(0) Forest Fire Spots detected is send. This 
			is called a zero(0) alert.</font></td>
		</tr>
		<tr>
			<td width="215" height="28">
			<font style="font-size: 8pt" face="Verdana">SMS/E-mail Alerts for</font></td>
			<td width="334" height="28">
			<select size="1" name="alert" style="border-style:solid; border-width:1px; font-family: Verdana; font-size: 8pt; padding-left:4px; padding-right:4px; padding-top:1px; padding-bottom:1px">
		<option value="All" selected>Country</option>
		<option value="State">State</option>
		<option value="District">District</option>
		</select></td>
		</tr>
		<tr>
			<td width="215" height="28">
			<font face="Verdana" style="font-size: 8pt">Enter Code as shown in 
			Image</font></td>
			<td width="334" height="28">
			<input type="text" id="security_code" Placeholder="Type Security Code" name="security_code" style="float: left" autocomplete="off" oncopy="return false;" onpaste="return false;" oncut="return false;" size="20" />&nbsp;<img id="imgCaptcha" src="../includes/create_image.php?scode=<?php echo $security_code; ?>" align="texttop" width="80" height="30" />
</td>
		</tr>
		<tr>
			<td width="559" colspan="2">
			<p align="center">
			<input type="submit" value="Submit" name="submit" style="font-family: Verdana; font-size: 8pt" onclick="filtered_func(theform.password.value);">
			<input type="reset" value="Reset" name="cancel" style="font-family: Verdana; font-size: 8pt">
			</td>
		</tr></form>
	</table>
</td>
	</tr>
	<tr>
		<td align="center">
&nbsp;</td>
	</tr>
</table>

</div>

</body>

</html>