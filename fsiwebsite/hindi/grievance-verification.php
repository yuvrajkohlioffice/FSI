<?php
ob_start();
session_start();
error_reporting(0);
include_once "includes/classes.php";
$titlesub="";
$pageh = "";
$meta_title = $common->site_name;

$meta_desc = "";

$meta_keywords = "";

if(!empty($row_details['meta_title']))
	$meta_title = strip_tags($row_details['meta_title']);
if(!empty($row_details['meta_key']))
	$meta_keywords = strip_tags($row_details['meta_key']);
if(!empty($row_details['meta_desc']))
	$meta_desc = strip_tags($row_details['meta_desc']);	
		
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Grievance Verification</title>
	<?php
	if(!empty($meta_desc))
	{
	?>
	<meta name="description" content="<?php echo $meta_desc;?>">
	<?php
	}
	if(!empty($meta_keywords))
	{
	?>
	<meta name="keywords" content="<?php echo $meta_keywords;?>">
	<?php
	}
	?>
	<meta name="author" content="Webline Infosoft Pvt. Ltd., Dehradun">
	<?php
		$common->get_common_head();
	?>
	<style>
	
	#formdata .text-box, #formdata .text-area, #formdata select {
    margin: 0px;
    padding: 8px 10px;
    border: 1px solid #999;
    background-color: #fff;
    text-decoration: none;
    font-weight: bold;
    color: #111;
    font-size: 12px;
    float: left;
    width: 300px;
    border-radius: 3px;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    -o-border-radius: 3px;
}
			
			#formdata .overview {
				background: #FFEC9D;
				padding: 10px;
				width: 90%;
				border: 1px solid #CCCCCC;
			}
			
			#formdata .originalTextareaInfo {
				font-size: 12px;
				color: green;
				font-family: Tahoma, sans-serif;
				text-align: right;
				margin-top: 238px;
			}
			
			#formdata .warningTextareaInfo {
				font-size: 12px;
				color: #FF0000;
				font-family: Tahoma, sans-serif;
				text-align: right
			}
			
			#formdata #showData {
				height: 70px;
				width: 200px;
				border: 1px solid #CCCCCC;
				padding: 10px;
				margin: 10px;
			}
		</style>

<script>
function showOther(val) {
	if( val == "other" )
	{
		document.getElementById('other_grievance').style.display="block" 	
	}
	else{
		document.getElementById('other_grievance').style.display="none" 				
	}
}
</script>

<script language="javascript">

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
	if (charCode > 31 && (charCode < 40 || charCode > 57))
	return false;
	return true;
}


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


function validate(theform)
{
	
	var errorMessage = "";
	var errorCount = 0;
	if(theform.name.value.replace(/^\s+|\s+$/g,"")=="")
	{
		errorCount++;
		errorMessage = errorMessage + errorCount + ". Enter Name.\n";
	}	
	if(theform.security_code.value.replace(/^\s+|\s+$/g,"")=="")
    {
		errorCount++;
		errorMessage = errorMessage + errorCount + ". Enter Security Code.\n";
	}	
	if(theform.security_code.value!="<?php echo $security_code ;?>")
	{
		errorCount++;
		theform.security_code.value="";
		errorMessage = errorMessage + errorCount + ". Please Type Correct Security Code.\n";
	}
	if( errorMessage == "" )
		return true;
	else
	{
		alert( "Error: Please rectify following errors:\n" + errorMessage );
		return false;				
	}     
}
</script>
<style>
    td{ padding: 8px; }
</style>
<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
    <?php
		$common->get_header();
	?>

	<section id="breadcrumb-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="breadcrumb-title text-center">
                    	<h1>&nbsp;</h1>
						
					</div> <!-- /.page-breadcumb -->
				</div>
			</div>
		</div>
	</section>

	<!-- #promotional-text -->
	<section id="promotional-text" class="gardener">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-12">
					<p><marquee dir="ltr" width="100%">
					<?php 
					$sno=0;
					$sql_news="select * from news where status='active' and primeArea = 1 order by newsdate asc";
					$result_news=mysql_query($sql_news);
					while($row_news=mysql_fetch_array($result_news))
					{
						$sno++;
						$iconimage="";
						$size=1;
						if($row_news['size']!="")
						{
							$size=$row_news['size'];
						}	
					
						if($row_news['extension']!='' && file_exists("news/".$row_news['extension']))
						{
							$primeLink = "news/".$row_news['extension'];
							$target  = "_blank";
						}
						else if( $row_news['link'] != '' )
						{
							$primeLink = $row_news['link'];
							$target  = $row_news['target'];						
						}
					?>
					<?php echo $row_news['title'];?>
					<?php
					}
					?>
					</marquee></p>
				</div>
                <?php if( $primeLink ) { ?><div class="col-lg-4 col-md-12"><a class="contact-button" href="<?php echo $primeLink;?>" target="<?php echo $target;?>"><div class="contact-us-button">Learn More</div><i class="fa fa-arrow-circle-right"></i></a></div><?php } ?>
			</div>
		</div>
	</section> 
    <!-- /#promotional-text -->


	
<section id="landscaping-design-gardener">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 shop-page-content">
					
                    <div class="section-title-style-2">
						<h1>Verify your Phone Number</h1>
					</div>					
					<div class="row">
					    <div class="col-md-12" id="formdata">
                    	<table border="0" width="100%" cellspacing="0" cellpadding="5" id="table4">
						<tbody><tr>
							<td valign="top">
							<table border="0" width="100%" cellspacing="0" cellpadding="10" id="table5">
								<tbody><tr>
											<td bgcolor="#0A6D98" width="95%">
											<b>
											<font face="Trebuchet MS" color="#FFFFFF">
											Enter Code send to your mail id</font></b></td>
										</tr>
								<tr>
											<td bgcolor="#FFFFFF">
											<table border="0" width="100%" cellspacing="0" cellpadding="5" id="table26">
												<tbody><tr>
													<td>
													<div class="page-content">
													<form name="registration_form" action="process-verify.php" method="post" onsubmit="return validate(this);" enctype="multipart/form-data">													
								<table width="100%" id="table52" cellpadding="4"><tbody>
								<tr>
										<td width="33%">
								<font size="2"><b>Enter Phone Number</b></font><b><font size="2"> <font color="#FF0000">
								*</font></font></b></td>
								<script src="amount.js"></script>
										<td width="66%">
								<input type="text" name="phone" required="" placeholder="Enter Phone Number" class="text-box" size="20"></td>
										</tr>
								<tr>
										<td width="33%">
								<font size="2"><b>Enter OTP send to your mail id</b></font><b><font size="2"> <font color="#FF0000">
								*</font></font></b></td>
								<script src="amount.js"></script>
										<td width="66%">
								<input type="text" name="otpcode" required="" placeholder="Enter OTP Code" class="text-box" size="20"></td>
										</tr>
	<tr>
										<td width="33%">
								<font size="2"><b>Captcha</b></font><b><font size="2">
								<font color="#FF0000">*</font></font></b></td>
										<td width="66%">
								<div class="g-recaptcha" data-sitekey="6LdPdT4UAAAAAP6ey21tJ8K4y1FxReh1ZV0NjmfY"></div>
</td>
										</tr>
								<tr>
										<td width="99%" colspan="2">
								<p align="center">
								<input type="submit" value="Submit" name="registration_submit" class="btn"></p></td>
										</tr>
								</tbody></table>								
								</form>
						
													</div>
</td>
												</tr>
											</tbody></table>
											</td>
										</tr>
								</tbody></table>
							</td>
						</tr>
					</tbody></table>
						</div>
					</div>	
				</div> 

			</div>
		</div>
	</section>

	<?php
		$common->get_footer();
	?>
	<?php
		$common->get_footer_scripts();
	?>
</body>
</html>