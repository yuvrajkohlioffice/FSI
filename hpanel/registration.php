<?php
	include_once "includes/constant.php";
	include_once "control.php";
	$crdate=date("Y-m-d");
	
if(!isset($_REQUEST['action']))
{
	$action='';
	$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 15, 6); 
	$_SESSION['capture_code']=$security_code;
	view();
	exit;
}

if(!isset($_POST['flag']))
{
	$flag='';
}


if($_GET['action']=="details")
{
  view_details();
  exit;
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='active')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		
		$query="update  registration set status='inactive' where sno='$unid_id'";
		$rs=mysql_query($query);
		
		if($rs)
		{
			echo "<script>location.href='registration.php?display=status'</script>";	
		}
		else
		{
			echo "<script>location.href='registration.php?error=incorrect'</script>";	
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='registration.php?status=codeinvalid'</script>";
	}
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='inactive')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		
		$query="update registration set status='active' where sno='$unid_id'";
		$rs=mysql_query($query);
	
		if($rs)
		{
			echo "<script>location.href='registration.php?display=update'</script>";	
		}
		else
		{
			echo "<script>location.href='registration.php?error=incorrect'</script>";	
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='registration.php?status=codeinvalid'</script>";
	}
}

if(isset($_POST['flag']) && !empty($_POST['flag']) && $_POST['flag']==1)
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_POST['log']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		$pdate = date("Y-m-d");
			
		$txtname= preg_replace('/[^a-zA-Z0-9 \- ]/','',$_POST['txtname']);
		$designation= preg_replace('/[^a-zA-Z0-9 \- ]/','',$_POST['txtdesignation']);
		$organization= preg_replace('/[^a-zA-Z0-9 \- ]/','',$_POST['txtorganization']);
		$address= preg_replace('/[^a-zA-Z0-9 \- ]/','',$_POST['txtaddress']);
		$country= preg_replace('/[^a-zA-Z0-9 \- ]/','',$_POST['txtcountry']);
		$pin= preg_replace('/[^a-zA-Z0-9 \- ]/','',$_POST['txtpin']);
		$phone= preg_replace('/[^a-zA-Z0-9 \- ]/','',$_POST['txtphone']);
		$mobile= preg_replace('/[^a-zA-Z0-9 \- ]/','',$_POST['txtmobile']);
		$email= preg_replace('/[^a-zA-Z0-9 \-@._ ]/','',$_POST['txtemail']);
		$password= preg_replace('/[^a-zA-Z0-9 \-@._ ]/','',$_POST['txtpassword']);
		$alert= preg_replace('/[^a-zA-Z]/','',$_POST['txtsmsalert']);
		$zeroalert= preg_replace('/[^a-zA-Z]/','',$_POST['txtalert']);

		$sql1="select sno from registration where email='$email'";
		$cou=mysql_num_rows(mysql_query($sql1));
		
		if($cou==0)
		{
			//$sql="insert into registration(name,designation,organization,address,state,district1,district2,country,pin,phone,mobile,email,password,status,crdate,zeroalert) values('$txtname','$designation','$organization','$address','$state','$district','$district1','$country','$pin','$phone','$mobile','$email','$password','active','$pdate','$zeroalert')";
			
			
			$state=urldecode($_POST['txtstate']);
			$district[0]=urldecode($_POST['district'][0]);
			$district[1]=urldecode($_POST['district'][1]);
			$district[2]=urldecode($_POST['district'][2]);
			$district[3]=urldecode($_POST['district'][3]);
			
			$sql="insert into registration(name,designation,organization,address,state,district1,district2,district3,district4,country,pin,phone,mobile,email,password,status,crdate,alert,zeroalert) values('$txtname','$designation','$organization','$address','$state','$district[0]','$district[1]','$district[2]','$district[3]','$country','$pin','$phone','$mobile','$email','$password','active','$pdate','$alert','$zeroalert')";
			
			
			//echo $sql;
			
			$rs = mysql_query($sql);
			if($rs)
			{
				echo "<script>location.href='registration.php?display=add'</script>";
			}
		}
		else
		{
			echo "<script>alert('User Name Already Exists in Database. Please choose another User Name.');location.href='registration.php';</script>";
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='registration.php?status=codeinvalid'</script>";
	}
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='delete_heading')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		
	    $rs = mysql_query("delete from registration where sno='$unid_id'");    
		if($rs)
		{
			echo "<script>location.href='registration.php?display=delete'</script>";
		}
		else
		{
			echo "<script>location.href='registration.php?error=incorrect'</script>";
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='registration.php?status=codeinvalid'</script>";
	}
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='edit_heading')
{
	edit();
	exit;
}

if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action']=='edit1')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_POST['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_POST['sno']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		//$sql="update registration set name='".filter_xss($_POST['txtname'])."',designation='".filter_xss($_POST['txtdesignation'])."',organization='".filter_xss($_POST['txtorganization'])."',address='".filter_xss($_POST['txtaddress'])."', state='".$_POST['txtstate']."',district1='".filter_xss($_POST['district1'])."',district2='".filter_xss($_POST['district2'])."',district3='".filter_xss($_POST['district3'])."',district4='".filter_xss($_POST['district4'])."',country='".filter_xss($_POST['txtcountry'])."', pin='".filter_xss($_POST['txtpin'])."',phone='".filter_xss($_POST['txtphone'])."',mobile='".filter_xss($_POST['txtmobile'])."',email='".filter_xss($_POST['txtemail'])."',password='".filter_xss($_POST['txtpassword'])."',alert='".filter_xss($_POST['txtalert'])."',zeroalert='".filter_xss($_POST['txtsmsalert'])."' where sno='$unid_id'";
		
		$sql="update registration set name='".filter_xss($_POST['txtname'])."',designation='".filter_xss($_POST['txtdesignation'])."',organization='".filter_xss($_POST['txtorganization'])."',address='".filter_xss($_POST['txtaddress'])."', state='".$_POST['txtstate']."',district1='".filter_xss($_POST['district1'])."',district2='".filter_xss($_POST['district2'])."',district3='".filter_xss($_POST['district3'])."',district4='".filter_xss($_POST['district4'])."',country='".filter_xss($_POST['txtcountry'])."', pin='".filter_xss($_POST['txtpin'])."',phone='".filter_xss($_POST['txtphone'])."',mobile='".filter_xss($_POST['txtmobile'])."',email='".filter_xss($_POST['txtemail'])."',password='".filter_xss($_POST['txtpassword'])."',alert='".filter_xss($_POST['txtsmsalert'])."',zeroalert='".filter_xss($_POST['txtalert'])."' where sno='$unid_id'";

	    	
		$rs=mysql_query($sql); 
		
		if($rs)
		{
			echo "<script>location.href='registration.php?display=update'</script>";
		}
		else
		{
			echo "<script>location.href='registration.php?error=incorrect'</script>";
		}
	}	
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='registration.php?status=codeinvalid'</script>";
	}
}


function view()
{

	$tbl_name="registration";		//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = 3;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	
	if(isset($_GET['q']) && !empty($_GET['q']))
	{
		$query = "SELECT COUNT(*) as num FROM $tbl_name where (name like '%$_GET[q]%' || mobile like '%$_GET[q]%' || email like '%$_GET[q]%')";
	}
	else
	{
		$query = "SELECT COUNT(*) as num FROM $tbl_name";
	}
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages['num'];
	//$total_pages=$max;
	/* Setup vars for query. */
	$targetpage = "registration.php"; 	//your file name  (the name of this file)
	$limit = 50; 								//how many items to show per page
	$page = 0;
	if(isset($_GET['page']))	
	{						//how many items to show per page
		$pages = preg_replace('/[^0-9]/', '', trim($_GET['page']));
		$page = $pages;	
	}
	if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0
	/* Get data. */
	if(isset($_GET['q']) && !empty($_GET['q']))
	{
		$sql = "select * from $tbl_name where (name like '%$_GET[q]%' || mobile like '%$_GET[q]%' || email like '%$_GET[q]%') order by name LIMIT $start, $limit";
	}
	else
	{
		$sql = "select * from $tbl_name order by name LIMIT $start, $limit";
	}
	 
	$result=mysql_query($sql);
	/* Setup page vars for display. */
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		//previous button
		if ($page > 1) 
			$pagination.= "<a href=\"$targetpage?page=$prev\"><< previous</a>";
		else
			$pagination.= "<span class=\"disabled\"><< previous</span>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a href=\"$targetpage?page=$next\">next >></a>";
		else
			$pagination.= "<span class=\"disabled\">next >></span>";
		$pagination.= "</div>\n";		
	}
?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<meta charset="utf-8" />
	<?php
		include_once "head.php";
	?>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
<script src="state1.js"></script>
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
   return (false);
   }
   if(theform.txtdesignation.value.replace(/^\s+|\s+$/g,"")=="")
   {
   alert("Please enter Designation!");
   theform.txtdesignation.focus();
   return (false);
   } 
   if(theform.txtorganization.value.replace(/^\s+|\s+$/g,"")=="")
   {
   alert("Please enter Organization!");
   theform.txtorganization.focus();
   return (false);
   }  
   if(theform.txtaddress.value.replace(/^\s+|\s+$/g,"")=="")
   {
   alert("Please enter Address!");
   theform.txtaddress.focus();
   return (false);
   }       
   if(theform.txtstate.value.replace(/^\s+|\s+$/g,"")=="")
   {
   alert("Please Select State!");
   theform.txtstate.focus();
   return (false);
   }  
   if(!isEmail(theform.txtemail.value)) 
   {
		alert("Please enter correct e-mail address");
		theform.txtemail.value='';
		theform.txtemail.focus();
		return (false);
	}
  
   if(theform.txtpassword.value.replace(/^\s+|\s+$/g,"")=="")
   {
	   alert("Please enter Password!");
	   theform.txtpassword.focus();
	   return (false);
   }
   return true;
}
</script>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body onload="burstCache();" class="page-header-fixed">
	<!-- BEGIN HEADER -->   
	<?php
		include_once "header.php";
	?>

	<!-- END HEADER -->
	<!-- BEGIN CONTAINER -->
	<div class="page-container row-fluid">
		<!-- BEGIN SIDEBAR -->
		<?php
			include_once "side_bar.php";
		?>
		<!-- END SIDEBAR -->
		<!-- BEGIN PAGE -->  
		<div class="page-content">
			<!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid">
				<!-- BEGIN PAGE HEADER-->   
				<div class="row-fluid">
					<div class="span12">						     
						<h3 class="page-title">
							Firespots Registration
							<small>Add New User</small>
						</h3>
						<div style="float: right;">
						<form name="Search" action="registration.php" method="get">
						<input type="text" placeholder="name/phone/email" value="<?php if(isset($_GET['q']) && !empty($_GET['q'])) { echo $_GET['q']; } ?>" required name="q">
						<input type="submit" value="Search" name="search">
						</form>
						</div>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="mainmenu.php">Home</a> 
								<span class="icon-angle-right"></span>
							</li>
							<li>
								<a href="#">Forest Fire</a>
								<span class="icon-angle-right"></span>
							</li>
							<li><a href="#">Manage Registration</a></li>
						</ul>
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->			
				
				
				
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN SAMPLE TABLE PORTLET-->
						<?php
					     if(isset($_GET['error']) && !empty($_GET['error']))
					     {
					     	 $return_msg = preg_replace('/[^a-z]/', '', trim($_GET['error']));

					     	 if($return_msg == "incorrect")
					     	 {
					    ?>
						<div class="alert alert-error">
							<button class="close" data-dismiss="alert"></button>
							Some Error Occurred. Please try again!!
						</div>
						<?php
							}
						}
						else if(isset($_GET['status']) && !empty($_GET['status']))
					    {
					     	 $return_msg = preg_replace('/[^a-z]/', '', trim($_GET['status']));

					     	 if($return_msg == "codeinvalid")
					     	 {
					    ?>
						<div class="alert alert-error">
							<button class="close" data-dismiss="alert"></button>
							Unauthroize Access.
						</div>
						<?php
							}
						}
					    else if(isset($_GET['display']) && !empty($_GET['display']))
					    {	
					    	$return_msg = preg_replace('/[^a-z]/', '', trim($_GET['display']));
						?>
						<div class="alert alert-success">
							<button class="close" data-dismiss="alert"></button>
						<?php
							 if($return_msg == 'add')
					        {
					        	echo "Record Saved Successfully..";
					        	if(isset($_GET['msg']))
					        	{
					        		$err_msg = preg_replace('/[^a-zA-Z !]/', '', trim($_GET['msg']));
						        	if($err_msg)
						        	{
						        		echo " <span style = 'color:#FF0000'>".$err_msg."</span>";
						        	}
						        }
					        }
					        if($return_msg == 'update' || $return_msg == 'status')
					     	{
					     		echo "Record Updated Successfully..";
								if(isset($_GET['msg']))
					        	{
					        		$err_msg = preg_replace('/[^a-zA-Z !]/', '', trim($_GET['msg']));
						        	if($err_msg)
						        	{
						        		echo " <span style = 'color:#FF0000'>".$err_msg."</span>";
						        	}
						        }					     	
						    }
					     	if($return_msg == 'delete')
					     	{
					     		echo "Record Deleted Successfully..";
					     	}
					     ?>
						</div>
						<?php
							}
						?>
						<div class="portlet box blue">
							<div class="portlet-title">
								<div class="caption"><i class="icon-cogs"></i>Manage Registration</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<!--a href="#portlet-config" data-toggle="modal" class="config"></a-->
									<a href="javascript:;" class="reload"></a>
									<!--a href="javascript:;" class="remove"></a-->
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-hover">
									<thead>
										<tr>
											<th>#</th>
											<th>Name</th>
											<th>Alert For</th>
											<th>District 1</th>
											<th>District 2</th>
											<th>District 3</th>
											<th>District 4</th>
											<th>State</th>																					
											<th>Status</th>
											<th colspan="2">Action</th>
										</tr>
									</thead>
									<tbody>
									<?php
									$sno=$start;
									
									while($row_mainmenu=mysql_fetch_array($result))
									{
										$sno=$sno+1;
									?>
										<tr>
											<td><?php echo $sno; ?></td>
											<td><?php echo $row_mainmenu['name'];
											echo "<p><strong>Mobile: </strong>".$row_mainmenu['mobile']."</p>";
											echo "<p><strong>Email: </strong>".$row_mainmenu['email']."</p>";
											?></td>
											<td><?php echo $row_mainmenu['alert'];?></td>
											<td><?php echo $row_mainmenu['district1'];?></td>
											<td><?php echo $row_mainmenu['district2'];?></td>
											<td><?php echo $row_mainmenu['district3'];?></td>
											<td><?php echo $row_mainmenu['district4'];?></td>
											<td><?php echo $row_mainmenu['state'];?></td>														
											<td>
											<a href="registration.php?action=<?php echo $row_mainmenu['status']?>&sno=<?php echo $row_mainmenu['sno']?>&log=<?php echo $_SESSION['capture_code'];?>">
											<?php
											if($row_mainmenu['status']=='active')
											{
												echo "<img border=0 src='images/on.gif' alt=Active>";
											}
											else
											{
												echo "<img border=0 src='images/off.gif' alt=Inactive>";
											}
											?>
											</a></td>
											<td width="15">
											<a href="registration.php?sno=<?php echo $row_mainmenu['sno'];?>&action=<?php echo 'edit_heading'?>&log=<?php echo $_SESSION['capture_code'];?>">
											<img border="0" src="images/edit.png" width="20" height="20" alt="Edit" name="Edit"></a></td>
											<td width="15"><input type="image" img border="0" src="images/delete.png" width="20" height="20" onclick="var a=confirm('Are You sure delete this record from database ?');if(a==true){location.href='registration.php?sno=<?php echo $row_mainmenu['sno']?>&action=<?php echo 'delete_heading'?>&log=<?php echo $_SESSION['capture_code'];?>';}" alt="Delete" name="delete"></td>
										    <td align="center" width="15"><a href="registration.php?action=details&id=<?php echo $row_mainmenu['sno'];?>&log=<?php echo $_SESSION['capture_code'];?>"><img src="images/detail1.gif" alt="Details"></a></td>
										</tr>
										<?php
										}
										?>
									</tbody>
								</table>
								<table align="left">
						<tr>
						<td>
							<div class="pagination">
					        <?=$pagination?>
					        </div> 
						
						</td>
						</tr>
						</table>
							</div>
						</div>
						<!-- END SAMPLE TABLE PORTLET-->
					</div>					
				</div>


			
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN VALIDATION STATES-->
						<div class="portlet box purple">
							<div class="portlet-title">
								<div class="caption"><i class="icon-reorder"></i>Add New Member</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<!--a href="#portlet-config" data-toggle="modal" class="config"></a-->
									<a href="javascript:;" class="reload"></a>
									<!--a href="javascript:;" class="remove"></a-->
								</div>
							</div>
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
								<form action="registration.php?action=category"  enctype="multipart/form-data" id="form_main_menu" class="form-horizontal" method="post" autocomplete="off" onsubmit="return Validateform(this)">
									<div class="alert alert-error hide">
										<button class="close" data-dismiss="alert"></button>
										You have some form errors. Please check below.
									</div>
									<div class="alert alert-success hide">
										<button class="close" data-dismiss="alert"></button>
										Your form validation is successful!
									</div>									
									<div class="control-group">
										<label class="control-label">Name<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="txtname" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Designation<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="txtdesignation" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Organization<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="txtorganization" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Address<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="txtaddress" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>
									<div style="background:#193A01; color:#FFFFFF; padding: 10px;">Select State of your choice for which you want Fire Point Spots in your SMS</div><br>
									<div class="control-group">
										<label class="control-label">State<span class="required"></span></label>
										<div class="controls">
										<!--select class="span6 m-wrap" name="txtstate" size="1">
											<option value="">-- Select State --</option>
											<option value="all">-- All --</option>
											<?php
											$state=mysql_query("select name,sno from state_master where status='active' order by name");
											while($row_state=mysql_fetch_array($state))
											{
											?>
											<option value="<?php echo $row_state['sno'];?>"><?php echo $row_state['name'];?></option>
											<?php
											}
											?>
											</select-->

										<select class="span6 m-wrap" name="txtstate" onchange="showclass(this.value);">
										<option value="">Select  State</option>
											<?php
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
										</div>
									</div>
									<div style="background:#193A01; color:#FFFFFF; padding: 10px;">Select District(s) of your choice for which you want Fire Point Spots in your SMS
</div><br>
									<div class="control-group">
										<label class="control-label">District 1<span class="required"></span></label>
										<div class="controls">
										<div id="classHint">
										<select class="span6 m-wrap" name="district[]">
										<option value="">Select  District</option>
											<?php
											$district_query=mysql_query("select * from district_master where status='active' order by sorder");
											while($row_district=mysql_fetch_array($district_query))
											{
											?>									
												<option value="<?php echo $row_district['name'];?>"><?php echo $row_district['name'];?></option>
											<?php
											}
											?>
											</select>
										</div>											
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">District 2<span class="required"></span></label>
										<div class="controls">
										<div id="classHint1">
										<p align="left">
										<select size="1" name="district[]" style="font-family: Verdana; font-size: 10px" >
										<option selected value="-">Select District2</option>
										</select>
										</div>											
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">District 3<span class="required"></span></label>
										<div class="controls">
										<div id="classHint2">
										<p align="left">
										<select size="1" name="district[]" style="font-family: Verdana; font-size: 10px" >
										<option selected value="-">Select District3</option>
										</select>
										</div>										
										</div>
									</div>	
									<div class="control-group">
										<label class="control-label">District 4<span class="required"></span></label>
										<div class="controls">
										<div id="classHint3">
										<p align="left">
										<select size="1" name="district[]" style="font-family: Verdana; font-size: 10px" >
										<option selected value="-">Select District4</option>
										</select>
										</div>										
										</div>
									</div>							
									<div class="control-group">
										<label class="control-label">Country<span class="required"></span></label>
										<div class="controls">
											<input name="txtcountry" type="text" class="span6 m-wrap"/>
										</div>
										</div>	
									<div class="control-group">
										<label class="control-label">Pin<span class="required"></span></label>
										<div class="controls">
											<input name="txtpin" type="text" class="span6 m-wrap"/>
										</div>
										</div>

                                       <div class="control-group">
										<label class="control-label">Office Phone<span class="required"></span></label>
										<div class="controls">
											<input name="txtphone" type="text" class="span6 m-wrap"/>
										</div>
										</div>
										
                                       <div class="control-group">
										<label class="control-label">Mobile<span class="required"></span></label>
										<div class="controls">
											<input name="txtmobile" type="text" class="span6 m-wrap"/>
										</div>
										</div>
										
										<div class="control-group">
										<label class="control-label">Email Id<span class="required"></span></label>
										<div class="controls">
											<input name="txtemail" type="text" class="span6 m-wrap"/>
											<span class="help-block">will be used as User Name</span>
										</div>										
										</div>
										
										<div class="control-group">
										<label class="control-label">Password<span class="required"></span></label>
										<div class="controls">
											<input name="txtpassword" type="password" class="span6 m-wrap"/>											
										</div>										
										</div>
										
										<div class="control-group">
										<label class="control-label">Zero Alert<span class="required"></span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="txtalert">
												<option value="">Select...</option>
												<option value="yes">Yes</option>
												<option value="no">No</option>
											</select>											
										</div>										
										</div>
										<div style="background:#193A01; color:#FFFFFF; padding: 10px;">What is Zero Alert :- In case of No Forest Fire Spots being detected a sms/email stating zero(0) Forest Fire Spots detected is send. This is called a zero(0) alert.
</div><br>
										<div class="control-group">
										<label class="control-label">SMS/E-mail Alert for<span class="required"></span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="txtsmsalert">
												<option value="">Select...</option>
												<option value="All" selected>Country</option>
												<option value="State">State</option>
												<option value="District">District</option>
											</select>											
										</div>										
										</div>				
									<div class="form-actions">
										<button type="submit" class="btn purple">Save</button>
										<button type="button" class="btn">Cancel</button>
										<input type="hidden" value="<?php echo $_SESSION['capture_code'];?>" name="log">
										<input type="hidden" name="flag" size="20" value="1">
									</div>
								</form>
								<!-- END FORM-->
							</div>
						</div>
						<!-- END VALIDATION STATES-->
					</div>
				</div>				
				<!-- END PAGE CONTENT-->         
			</div>
			<!-- END PAGE CONTAINER-->
		</div>
		<!-- END PAGE -->  
	</div>
	<!-- END CONTAINER -->
	<?php
		include_once "footer_form.php";
	?> 
</body>
<!-- END BODY -->
</html>
<?php
}
function edit()
{
	if(isset($_GET['sno']) && !empty($_GET['sno']))
	{	
		$menuid=preg_replace('/[^0-9]/', '', trim($_GET['sno']));
		$query=mysql_query("select * from  registration where sno='$menuid'");
		$row_mainmenu=mysql_fetch_array($query);
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<meta charset="utf-8" />
	<?php
		include_once "head.php";
	?>
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
   return (false);
   }
   if(theform.txtdesignation.value.replace(/^\s+|\s+$/g,"")=="")
   {
   alert("Please enter Designation!");
   theform.txtdesignation.focus();
   return (false);
   } 
   if(theform.txtorganization.value.replace(/^\s+|\s+$/g,"")=="")
   {
   alert("Please enter Organization!");
   theform.txtorganization.focus();
   return (false);
   }  
   if(theform.txtaddress.value.replace(/^\s+|\s+$/g,"")=="")
   {
   alert("Please enter Address!");
   theform.txtaddress.focus();
   return (false);
   }       
   if(theform.txtstate.value.replace(/^\s+|\s+$/g,"")=="")
   {
   alert("Please Select State!");
   theform.txtstate.focus();
   return (false);
   }  
   if(!isEmail(theform.txtemail.value)) 
   {
		alert("Please enter correct e-mail address");
		theform.txtemail.value='';
		theform.txtemail.focus();
		return (false);
	}
  
   if(theform.txtpassword.value.replace(/^\s+|\s+$/g,"")=="")
   {
	   alert("Please enter Password!");
	   theform.txtpassword.focus();
	   return (false);
   }
   return true;
}
</script>	
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body onload="burstCache();" class="page-header-fixed">
	<!-- BEGIN HEADER -->   
	<?php
		include_once "header.php";
	?>

	<!-- END HEADER -->
	<!-- BEGIN CONTAINER -->
	<div class="page-container row-fluid">
		<!-- BEGIN SIDEBAR -->
		<?php
			include_once "side_bar.php";
		?>
		<!-- END SIDEBAR -->
		<!-- BEGIN PAGE -->  
		<div class="page-content">
			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<div id="portlet-config" class="modal hide">
				<div class="modal-header">
					<button data-dismiss="modal" class="close" type="button"></button>
					<h3>portlet Settings</h3>
				</div>
				<div class="modal-body">
					<p>Here will be a configuration form</p>
				</div>
			</div>
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid">
				<!-- BEGIN PAGE HEADER-->   
				<div class="row-fluid">
					<div class="span12">						     
						<h3 class="page-title">
							Firespots Registration
							<small>Add New User</small>
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="mainmenu.php">Home</a> 
								<span class="icon-angle-right"></span>
							</li>
							<li>
								<a href="#">Forest Fire</a>
								<span class="icon-angle-right"></span>
							</li>
							<li><a href="#">Manage Registration</a></li>
						</ul>
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->	
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN SAMPLE TABLE PORTLET-->
					<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN VALIDATION STATES-->
						<div class="portlet box purple">
							<div class="portlet-title">
								<div class="caption"><i class="icon-reorder"></i>Edit Manage Registration - <b>"<?php echo $row_mainmenu['name'];?>"</b></div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<!--a href="#portlet-config" data-toggle="modal" class="config"></a-->
									<a href="javascript:;" class="reload"></a>
									<!--a href="javascript:;" class="remove"></a-->
								</div>
							</div>
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
								<form action="registration.php"  enctype="multipart/form-data"  id="form_main_menu" class="form-horizontal" method="post" autocomplete="off" onsubmit="return Validateform(this)">					
									
									<div class="control-group">
										<label class="control-label">Name<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="txtname" value="<?php echo $row_mainmenu['name'];?>" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Designation<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="txtdesignation" value="<?php echo $row_mainmenu['designation'];?>" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Organization<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="txtorganization" value="<?php echo $row_mainmenu['organization'];?>" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Address<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="txtaddress" value="<?php echo $row_mainmenu['address'];?>" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>
									<script src="state1.js"></script>

									<div class="control-group">
										<label class="control-label">State<span class="required"></span></label>
										<div class="controls">
										<!--select class="span6 m-wrap" name="txtstate" size="1">
											<option value="">-- Select State --</option>
											<option value="all">-- All --</option>
											<?php
											$state=mysql_query("select name,sno from state_master where status='active' order by name");
											while($row_state=mysql_fetch_array($state))
											{
											?>
											<option value="<?php echo $row_state['sno'];?>"><?php echo $row_state['name'];?></option>
											<?php
											}
											?>
											</select-->

										<select class="span6 m-wrap" name="txtstate" onchange="showclass(this.value);">
										<option value="">Select State</option>
											<?php
											$sql12="select distinct(state) from firepoint order by state asc";
											$result12=mysql_query($sql12) or die(mysql_error());
											while($row12=mysql_fetch_array($result12))
											{
											?>
											<option value="<?echo urlencode($row12[0])?>" <?php if($row12[0]==$row_mainmenu['state']) { echo 'selected';}?>><?echo $row12[0]?></option>
											<?
											}
											?>
											</select>											
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">District 1<span class="required"></span></label>
										<div id="classHint">
										<div class="controls">
										<select class="span6 m-wrap" name="district1">
										<option value="">Select  District</option>
											<?php
											$district_query=mysql_query("select distinct(district) as name from firepoint where state like '%$row_mainmenu[state]%' order by district asc");
											while($row_district=mysql_fetch_array($district_query))
											{
											?>									
												<option value="<?php echo $row_district['name'];?>" <?php if($row_mainmenu['district1']==$row_district['name']){ echo 'Selected';};?>><?php echo $row_district['name'];?></option>
											<?php
											}
											?>
											</select>											
										</div>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">District 2<span class="required"></span></label>
										<div class="controls">
										<div id="classHint1">
										<select class="span6 m-wrap" name="district2">
										<option value="">Select  District</option>
											<?php
											$district_query=mysql_query("select distinct(district) as name  from firepoint where state like '%$row_mainmenu[state]%' order by district asc");
											while($row_district=mysql_fetch_array($district_query))
											{
											?>									
												<option value="<?php echo $row_district['name'];?>" <?php if($row_mainmenu['district2']==$row_district['name']){ echo 'Selected';};?>><?php echo $row_district['name'];?></option>
											<?php
											}
											?>
											</select>											
										</div>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">District 3<span class="required"></span></label>
										<div class="controls">
										<div id="classHint2">
										<select class="span6 m-wrap" name="district3">
										<option value="">Select  District</option>
											<?php
											$district_query=mysql_query("select distinct(district) as name  from firepoint where state like '%$row_mainmenu[state]%' order by district asc");
											while($row_district=mysql_fetch_array($district_query))
											{
											?>									
												<option value="<?php echo $row_district['name'];?>" <?php if($row_mainmenu['district3']==$row_district['name']){ echo 'Selected';};?> ><?php echo $row_district['name'];?></option>
											<?php
											}
											?>
											</select>											
										</div>
										</div>
									</div>	
									<div class="control-group">
										<label class="control-label">District 4<span class="required"></span></label>
										<div class="controls">
										<div id="classHint4">
										<select class="span6 m-wrap" name="district4">
										<option value="">Select  District</option>
											<?php
											$district_query=mysql_query("select distinct(district) as name  from firepoint where state like '%$row_mainmenu[state]%' order by district asc");
											while($row_district=mysql_fetch_array($district_query))
											{
											?>									
												<option value="<?php echo $row_district['name'];?>" <?php if($row_mainmenu['district4']==$row_district['name']){ echo 'Selected';};?> ><?php echo $row_district['name'];?></option>
											<?php
											}
											?>
											</select>											
										</div>
										</div>
									</div>							
									<div class="control-group">
										<label class="control-label">Country<span class="required"></span></label>
										<div class="controls">
											<input name="txtcountry" type="text" value="<?php echo $row_mainmenu['country'];?>" class="span6 m-wrap"/>
										</div>
										</div>	
									<div class="control-group">
										<label class="control-label">Pin<span class="required"></span></label>
										<div class="controls">
											<input name="txtpin" type="text"  value="<?php echo $row_mainmenu['pin'];?>" class="span6 m-wrap"/>
										</div>
										</div>

                                       <div class="control-group">
										<label class="control-label">Office Phone<span class="required"></span></label>
										<div class="controls">
											<input name="txtphone"  value="<?php echo $row_mainmenu['phone'];?>" type="text" class="span6 m-wrap"/>
										</div>
										</div>
										
                                       <div class="control-group">
										<label class="control-label">Mobile<span class="required"></span></label>
										<div class="controls">
											<input name="txtmobile" value="<?php echo $row_mainmenu['mobile'];?>" type="text" class="span6 m-wrap"/>
										</div>
										</div>
										
										<div class="control-group">
										<label class="control-label">Email Id<span class="required"></span></label>
										<div class="controls">
											<input name="txtemail" type="text" value="<?php echo $row_mainmenu['email'];?>"  class="span6 m-wrap"/>
											<span class="help-block">will be used as User Name</span>
										</div>										
										</div>
										
										<div class="control-group">
										<label class="control-label">Password<span class="required"></span></label>
										<div class="controls">
											<input name="txtpassword" value="<?php echo $row_mainmenu['password'];?>" type="password" class="span6 m-wrap"/>											
										</div>										
										</div>
										
										<div class="control-group">
										<label class="control-label">Zero Alert<span class="required"></span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="txtalert">
												<option value="">Select...</option>
												<option value="yes" <?php if($row_mainmenu['alert']=="yes"){ echo 'selected';};?>>Yes</option>
												<option value="no" <?php if($row_mainmenu['alert']=="no"){ echo 'selected';};?>>No</option>
											</select>											
										</div>										
										</div>
										
										<div class="control-group">
										<label class="control-label">SMS/E-mail Alert for<span class="required"></span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="txtsmsalert">
												<option value="">Select...</option>
												<option value="All" selected <?php if($row_mainmenu['zeroalert']=="All"){ echo 'selected';};?>>Country</option>
												<option value="State" <?php if($row_mainmenu['zeroalert']=="State"){ echo 'selected';};?>>State</option>
												<option value="District" <?php if($row_mainmenu['district']=="District"){ echo 'selected';};?>>District</option>
											</select>											
										</div>										
										</div>		
									
									<div class="form-actions">
										<button type="submit" class="btn purple">Save</button>
										<button type="button" class="btn">Cancel</button>
										<input type="hidden" name="action" size="20" value="edit1">
										<input type="hidden" name="sno" size="20" value="<?php echo $_GET['sno']; ?>">
										<input type="hidden" value="<?php echo $_SESSION['capture_code'];?>" name="log">
									</div>
								</form>
								<!-- END FORM-->
							</div>
						</div>
						<!-- END VALIDATION STATES-->
					</div>
				</div>				
				<!-- END PAGE CONTENT-->         
			</div>
			<!-- END PAGE CONTAINER-->
		</div>
		<!-- END PAGE -->  
	</div>
	<!-- END CONTAINER -->
	<?php
		include_once "footer_form.php";
	?> 
</body>
<!-- END BODY -->
</html>
<?php
	}
	
	}
	function view_details()
    {
	if(isset($_GET['id']) && !empty($_GET['id']))
	{	
		$menuid=preg_replace('/[^0-9]/', '', trim($_GET['id']));		
		$query=mysql_query("select * from  registration where sno='$menuid'");
		$row_content=mysql_fetch_array($query);
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<meta charset="utf-8" />
	<?php
		include_once "head.php";
	?>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body onload="burstCache();" class="page-header-fixed">
	<!-- BEGIN HEADER -->   
	<?php
		include_once "header.php";
	?>
	<!-- END HEADER -->
	<!-- BEGIN CONTAINER -->
	<div class="page-container row-fluid">
		<!-- BEGIN SIDEBAR -->
		<?php
			include_once "side_bar.php";
		?>
		<!-- END SIDEBAR -->
		<!-- BEGIN PAGE -->
		<div class="page-content">
			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
		
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<!-- BEGIN PAGE CONTAINER-->        
			<div class="container-fluid">
				<!-- BEGIN PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">						     
						<h3 class="page-title">
							Firespots Registration
							<small>Add New User</small>
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="mainmenu.php">Home</a> 
								<span class="icon-angle-right"></span>
							</li>
							<li>
								<a href="#">Forest Fire</a>
								<span class="icon-angle-right"></span>
							</li>
							<li><a href="#">Manage Registration</a></li>
						</ul>
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->          
				<div class="row-fluid">
					<div class="span12">
						<!--div class="alert alert-success">
							<button class="close" data-dismiss="alert"></button>
							Please try to re-size your browser window in order to see the tables in responsive mode.<br>
							<span class="label label-important">NOTE:</span>&nbsp;This feature is supported by Internet Explorer 10, Latest Firefox, Chrome, Opera and Safari
						</div-->
						<!-- BEGIN SAMPLE TABLE PORTLET-->
						<div class="portlet box green">
							<div class="portlet-title">
								<div class="caption"><i class="icon-cogs"></i>Registration Details</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="#portlet-config" data-toggle="modal" class="config"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body flip-scroll">								
								<div class="control-group">
										<label class="control-label">Name&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['name'];?></b> 
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">Email ID&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['email'];?></b> 
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">Password&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['password'];?></b> 
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">Designation &nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['designation'];?></b> 
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">
										Organization Name&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['organization'];?></b> 
										</div>
								</div>
								<hr size="1">
								<div class="control-group">
										<label class="control-label">Address&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['address'];?></b> 
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">State.&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['state'];?></b> 
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">District 1&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['district1'];?></b> 
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">District 2&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['district2'];?></b> 
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">District 3&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['district3'];?></b> 
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">District 4&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['district4'];?></b> 
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">Country&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['country'];?> </b>
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">Pin Code&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['pin'];?> </b>
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">Office Phone&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['phone'];?> </b>
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">Mobile&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['mobile'];?></b> 
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">alert&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php 											
												echo $row_content['alert'];											
											?> </b>
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">Zero Alert.&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['zeroalert'];?> </b>
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">Create Date .&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo date("d-m-Y",strtotime($row_content['crdate']));?></b> 
										</div>
								</div>								
							</div>
						</div>
						<!-- END SAMPLE TABLE PORTLET-->
						<!-- BEGIN SAMPLE TABLE PORTLET-->
						
						<!-- END SAMPLE TABLE PORTLET-->
					</div>
				</div>
				<!-- END PAGE CONTENT-->
			</div>
			<!-- END PAGE CONTAINER-->
		</div>
		<!-- END PAGE -->
	</div>
	<!-- END CONTAINER -->
	<!-- BEGIN FOOTER -->
	<?php
		include_once "footer_form.php";
	?> 
</body>
<!-- END BODY -->
</html>
<?php
	} 	
	else
	{
		echo "<script>location.href='main-menu.php';</script>";
	}
}	
?>