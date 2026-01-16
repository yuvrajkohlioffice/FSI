<?php
	include_once "includes/constant.php";
	include_once "control.php";
	
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

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='active')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		$query="update tab_content set status='inactive' where sno='$unid_id'";
		$rs=mysql_query($query);
		
		if($rs)
		{
			echo "<script>location.href='tab.php?display=status'</script>";	
		}
		else
		{
			echo "<script>location.href='tab.php?error=incorrect'</script>";	
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='tab.php?status=codeinvalid'</script>";
	}
}
if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='inactive')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		$query="update tab_content set status='active' where sno='$unid_id'";
		$rs=mysql_query($query);
	
		if($rs)
		{
			echo "<script>location.href='tab.php?display=update'</script>";	
		}
		else
		{
			echo "<script>location.href='tab.php?error=incorrect'</script>";	
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='tab.php?status=codeinvalid'</script>";
	}
}

if(isset($_POST['flag']) && !empty($_POST['flag']) && $_POST['flag']==1)
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_POST['log']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{

	$sql2="select max(sno) as sno from tab_content";
	$rs2=mysql_query($sql2);
	$data2=mysql_fetch_array($rs2);
	$sno_max=$data2['sno'];
	
	
	if($sno_max=="")
	{
		$start=1;
	}
	else
	{
		$start=$sno_max+1;
	}
	
	$desc=mysql_real_escape_string($_REQUEST['description']);
	//$desc=$_REQUEST['description'];
	$count=0;
	
	$query="insert into tab_content(sno,heading,page_heading,teaser_text, detail,status,crdate,ipaddress,userid,pagehead) values('$start','$_POST[sno]','".filter_xss($_POST['txtheading'])."','".filter_xss($_POST['teaser'])."','$desc','active','$pdate','$_SERVER[REMOTE_ADDR]','$_SESSION[uname]','$_POST[typeval]')";
	
	$rs=mysql_query($query);
	
	mysql_query("update update_tab set crdate='$pdate'");
	
		if($rs)
		{
			echo "<script>location.href='tab.php?display=add'</script>";
		}
		else
		{
			echo "<script>location.href='tab.php?error=incorrect'</script>";
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='tab.php?status=codeinvalid'</script>";
	}
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='delete_heading')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		$query="delete from tab_content where sno='$unid_id'";
		$rs=mysql_query($query);
		
		if($rs)
		{
			echo "<script>location.href='tab.php?display=delete'</script>";
		}
		else
		{
			echo "<script>location.href='tab.php?error=incorrect'</script>";
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='tab.php?status=codeinvalid'</script>";
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
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		
		$desc=mysql_real_escape_string($_REQUEST['description']);
		//$desc=$_REQUEST['description'];
		
		$query="update tab_content set heading='$_POST[sno1]',page_heading='".filter_xss($_POST[page_heading])."',teaser_text='".filter_xss($_POST[teaser])."', detail='$desc', pagehead='$_POST[typeval]', ipaddress=' $_SERVER[REMOTE_ADDR]',modifydate='$pdate',modifyby='$_SESSION[uname]' where sno='$unid_id'";
		
		$rs=mysql_query($query);
		if($rs)
		{
			echo "<script>location.href='tab.php?display=update&page=$_POST[page]'</script>";
		}
		else
		{
			echo "<script>location.href='tab.php?error=incorrect&page=$_POST[page]'</script>";
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='tab.php?status=codeinvalid'</script>";
	}
}

function view()
{
	
	$tbl_name="tab_content";		//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = 3;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	$query = "SELECT COUNT(*) as num FROM $tbl_name";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages['num'];
	//$total_pages=$max;
	/* Setup vars for query. */
	$targetpage = "tab.php"; 	//your file name  (the name of this file)
	$limit = 10; 	
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
	
	$sql = "select * from tab_content order by sno desc LIMIT $start, $limit";
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
<script type="text/javascript" src="js/jquery.js"></script>

<script type="text/javascript">
$(document).ready(function(){
$("#google_map_code").hide();
});
function show_maps(theval)
{
	if(theval=="1")
	{
		$("#google_map_code").show(200);
	}
	else
	{
		$("#google_map_code").hide(200);
	}
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
							Website Tab Content Management
							<small>Add/Edit Tab Content</small>
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="mainmenu.php">Home</a> 
								<span class="icon-angle-right"></span>
							</li>
							<li>
								<a href="#">Page's</a>
								<span class="icon-angle-right"></span>
							</li>
							<li><a href="#">Website Tab Page's</a></li>
						</ul>
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->	
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN SAMPLE TABLE PORTLET-->
						<?php
					     if(isset($_GET['error']) && !empty($_GET['error']) && $_GET['error']=='incorrect')
					     {
					    ?>
						<div class="alert alert-error">
							<button class="close" data-dismiss="alert"></button>
							Some Error Occurred. Please try again!!
						</div>
						<?php
						}
					     if(isset($_GET['display']) && !empty($_GET['display']))
					     {					     
						?>
						<div class="alert alert-success">
							<button class="close" data-dismiss="alert"></button>
						<?php
							 if($_GET['display']=='add')
					        {
					        	echo "Record Saved Successfully..";
					        }
					        if($_GET['display']=='update')
					     	{
					     		echo "Record Updated Successfully..";
					     	}
					     	if($_GET['display']=='delete')
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
								<div class="caption"><i class="icon-cogs"></i>Website Tab Pages</div>
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
											<th>Page Name / Heading</th>
											<th width="49">Banner</th>
											<th>Status</th>
											<th colspan="2">Action</th>
											<th>Preview</th>
										</tr>
									</thead>
									<tbody>
									<?php
									$sno=$start;
									while($row_content=mysql_fetch_array($result))
									{
										$sno=$sno+1;
									?>
										<tr>
											<td><?php echo $sno; ?></td>
											<td>
											<?php
							
							if($row_content['pagehead']=='m')
							{
								$pagename="select name from heading where sno='$row_content[heading]'";
								$demo_link = "../details.php?pgID=mn_".$row_content['sno'];
							}
							elseif($row_content['pagehead']=='s' or $row_content['pagehead']=='o')
							{
								$pagename="select subhead from sub_heading where sno='$row_content[heading]'";
								$demo_link = "../details.php?pgID=sb_".$row_content['sno'];
							}
							elseif($row_content['pagehead']=='q')
							{
								$pagename="select name from quick_menu where sno='$row_content[heading]'";
							}
							elseif($row_content['pagehead']=='t')
							{
								$pagename="select name from top_menu where sno='$row_content[heading]'";
							}
							elseif($row_content['pagehead']=='b')
							{
								$pagename="select name from bottom_menu where sno='$row_content[heading]'";
							}
							elseif($row_content['pagehead']=='l')
							{
								$pagename="select name from middle_menu where sno='$row_content[heading]'";
							}
							elseif($row_content['pagehead']=='b')
							{
								$pagename="select name from bottom_menu where sno='$row_content[heading]'";
							}
							elseif($row_content['pagehead']=='u')
							{
								$pagename="select subhead from sub_sub_sub_heading where sno='$row_content[heading]'";
							}
							else if($row_content['pagehead']=='p')
							{
								$pagename="select subcate from programs where parentid='$row_content[heading]'";
							}
							elseif($row_content['pagehead']=='n')
							{
								$pagename="select subhead from nestedsub_heading where sno='$row_content[heading]'";
							}
							elseif($row_content['pagehead']=='k')
							{
								$pagename="select name from top_quick_menu where sno='$row_content[heading]'";
							}
							else
							{

								$pagename="select subhead,heading from sub_sub_heading where sno='$row_content[heading]'";
							}
							$rowpage=mysql_fetch_array(mysql_query($pagename));
							if(isset($rowpage['heading']))
							{
								$pagename2="select subhead from sub_heading where sno='$rowpage[heading]'";
								$rowpage2=mysql_fetch_array(mysql_query($pagename2));
								if($rowpage2[0]!="")
									echo ucwords($rowpage2[0])." - ";
							}
							echo ucwords($rowpage[0]);
							?></td>
											<td width="49">
											<?php
											if(isset($row['banner']) && $row['banner']!='' && file_exists("../images/banner/".$row['banner']))
											{
											?>
											<a target="_blank" href="../images/banner/<?echo $row['banner']?>">
											<img border=0 src="images/down.jpg" title="<?echo $row['banner']?>" alt="View Banner"></a>
											<?
											}
											?>		
											</td>
											<td>
											<a href="tab.php?action=<?php echo $row_content['status']?>&sno=<?php echo $row_content['sno']?>&log=<?php echo $_SESSION['capture_code'];?>">
											<?php
											if($row_content['status']=='active')
											{
												echo "<img border=0 src='images/on.gif' alt=Active>";
											}
											else
											{
												echo "<img border=0 src='images/off.gif' alt=Inactive>";
											}
											?>
											</a></td>
											<td>
											<a href="tab.php?sno=<?php echo $row_content['sno'];?>&action=<?php echo 'edit_heading'?>&page=<?php if(isset($_GET['page'])) echo $_GET['page'];?>&log=<?php echo $_SESSION['capture_code'];?>">
											<img border="0" src="images/edit.png" width="20" height="20" alt="Edit" name="Edit"></a></td>
											<td><input type="image" img border="0" src="images/delete.png" width="20" height="20" onclick="var a=confirm('Are You sure delete this record from database ?');if(a==true){location.href='tab.php?sno=<?php echo $row_content['sno']?>&action=<?php echo 'delete_heading'?>&log=<?php echo $_SESSION['capture_code'];?>';}" alt="Delete" name="delete"></td>
											<td>
											<?php
											if($demo_link)
											{
											?>
											<a href="<?php echo $demo_link;?>" target="_blank" class="btn mini green-stripe">View</a>
											<?php
											}
											?>
											</td>

										</tr>
										<?php
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
						<table align="left">
						<tr>
						<td>
							<div class="pagination">
					        <?=$pagination?>
					        </div> 
						
						</td>
						</tr>
						</table>

						<!-- END SAMPLE TABLE PORTLET-->
					</div>					
				</div>
<script type="text/javascript">
					
					function valselect(theval,theform)
					{
						var a=theval.length;
						var b=a-parseInt(1);
						var sno=theval.substr(0,b);
						var ctype1=theval.substr(b,a);					
						theform.sno.value=sno;
						theform.typeval.value=ctype1;					
						if(ctype1=="p")
						{
							$("#packages").show();
						}
						else
						{
							$("#packages").hide();
						}
					}
					
					</script>
					
			
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN VALIDATION STATES-->
						<div class="portlet box purple">
							<div class="portlet-title">
								<div class="caption"><i class="icon-reorder"></i>Add Page Content</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<!--a href="#portlet-config" data-toggle="modal" class="config"></a-->
									<a href="javascript:;" class="reload"></a>
									<!--a href="javascript:;" class="remove"></a-->
								</div>
							</div>
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
								<form action="tab.php?action=category" enctype="multipart/form-data" id="form_page" name="form_page" class="form-horizontal" method="post">		
									<div class="control-group">
										<label class="control-label">Select Page to be Linked ( Menu Name )<span class="required">*</span></label>
										<div class="controls">
											<?php

											$main=mysql_query("select distinct(name),sno from heading where status='active' order by position");
											
											$head=mysql_query("select distinct(subhead),sno,heading from sub_heading where status='active' and pagetype!='t' order by heading");
											
											$head1=mysql_query("select distinct(subhead),sno,heading,mainhead from sub_sub_heading where status='active' order by mainhead");
											
											$head2=mysql_query("select * from sub_sub_sub_heading where status='active' order by mainhead");
											
											$head3=mysql_query("select * from quick_menu where status='active' order by position");
											
											$head4=mysql_query("select * from top_menu where status='active' order by position");
											
											$head6=mysql_query("select distinct(subhead),sno from sub_heading where status='active' and pagetype='t' order by position");
											
											$head5=mysql_query("select * from bottom_menu where status='active' order by position");
											
											$head7=mysql_query("select * from middle_menu where status='active' order by position");
											
											$head8=mysql_query("select distinct(subcate),parentid from programs where status='active' and ptype='main' order by position");
											
											$head9=mysql_query("select * from nestedsub_heading where status='active' order by mainhead");
											
											$head10=mysql_query("select * from top_quick_menu where status='active' order by name");
											?>
											
											<select class="span6 m-wrap" name="heading" onchange="valselect(this.value,form_page);" size="1">
												<option value="">Select...</option>
												<optgroup value="-1" STYLE="BACKGROUND:#D0E0F1;COLOR:#ff3300" label="Top Menu"></optgroup>

<?
while($hea4=mysql_fetch_array($head4))
{
?>
<option value="<?echo $hea4['sno'].'t'?>"><?php echo $hea4['name']?></option>
<?
}
?><optgroup value="-1" STYLE="BACKGROUND:#D0E0F1;COLOR:#ff3300" label="Main Heading"></optgroup>
<?
while($hea=mysql_fetch_array($main))
{

?>
<option value="<?php echo $hea['sno']."m"?>"><?echo $hea['name']?></option>
<?
}
?>
<optgroup value="-1" STYLE="BACKGROUND:#D0E0F1;COLOR:#ff3300" label="Sub Heading"></optgroup>

<?php
while($hea=mysql_fetch_array($head))
{
	$mhead=mysql_fetch_array(mysql_query("select name from heading where sno='$hea[heading]'"));
?>
<option value="<?php echo $hea['sno']."s"?>"><?php echo $mhead['name'].' - '.$hea['subhead']?></option>
<?
}
?>
<optgroup value="-1" STYLE="BACKGROUND:#D0E0F1;COLOR:#ff3300" label="Sub - Sub Heading"></optgroup>

<?php
while($hea1=mysql_fetch_array($head1))
{
	$mhead=mysql_fetch_array(mysql_query("select name from heading where sno='$hea1[mainhead]'"));

	$hname="select subhead from sub_heading where sno='$hea1[heading]'";
	$row_hname=mysql_fetch_array(mysql_query($hname));
?>
<option value="<?php echo $hea1['sno']."i"?>"><?echo $mhead['name'].' - '.$row_hname['subhead']." - ".$hea1['subhead'];?></option>
<?
}
?>
<optgroup value="-1" STYLE="BACKGROUND:#D0E0F1;COLOR:#ff3300" label="Sub-Sub-Sub Heading"></optgroup>

<?php
while($hea2=mysql_fetch_array($head2))
{
	$mhead=mysql_fetch_array(mysql_query("select name from heading where sno='$hea2[mainhead]'"));

	$hname="select subhead from sub_heading where sno='$hea2[heading]'";
	$row_hname=mysql_fetch_array(mysql_query($hname));
	
	$hname2="select subhead from sub_sub_heading where sno='$hea2[subheading]'";
	$row_hname2=mysql_fetch_array(mysql_query($hname2));
?>
<option value="<?php echo $hea2['sno']."u"?>"><?echo $mhead['name'].' - '.$row_hname['subhead'].' - '.$row_hname2['subhead']." - ".$hea2['subhead'];?></option>
<?php
}
?>
<optgroup value="-1" STYLE="BACKGROUND:#D0E0F1;COLOR:#ff3300" label="Nested Sub Heading"></optgroup>

<?php
while($hea9=mysql_fetch_array($head9))
{
	$mhead=mysql_fetch_array(mysql_query("select name from heading where sno='$hea9[mainhead]'"));

	$hname="select subhead from sub_heading where sno='$hea9[heading]'";
	$row_hname=mysql_fetch_array(mysql_query($hname));
	
	$hname2="select subhead from sub_sub_heading where sno='$hea9[subheading]'";
	$row_hname2=mysql_fetch_array(mysql_query($hname2));
	
	$hname3="select subhead from sub_sub_sub_heading where sno='$hea9[subsubhead]'";
	$row_hname3=mysql_fetch_array(mysql_query($hname3));
?>
<option value="<?php echo $hea9['sno']."n"?>"><?echo $mhead['name'].' - '.$row_hname['subhead'].' - '.$row_hname2['subhead'].' - '.$row_hname3['subhead']." - ".$hea9['subhead'];?></option>
<?php
}
?>
<optgroup value="-1" STYLE="BACKGROUND:#D0E0F1;COLOR:#ff3300" label="Quick Navigation Menu"></optgroup>

<?php
while($hea3=mysql_fetch_array($head3))
{
?>
<option value="<?echo $hea3['sno'].'q'?>"><?echo $hea3['name']?></option>
<?php
}
?>
<optgroup value="-1" STYLE="BACKGROUND:#D0E0F1;COLOR:#ff3300" label="Middle Menu"></optgroup>

<?php
while($hea7=mysql_fetch_array($head7))
{
?>
<option value="<?echo $hea7['sno'].'l'?>"><?echo $hea7['name']?></option>
<?php
}
?>

<optgroup value="-1" STYLE="BACKGROUND:#D0E0F1;COLOR:#ff3300" label="Sub Heading of Top Menu"></optgroup>

<?php
while($hea6=mysql_fetch_array($head6))
{
?>
<option value="<?echo $hea6['sno'].'o'?>"><?echo $hea6['subhead']?></option>
<?php
}
?>
<optgroup value="-1" STYLE="BACKGROUND:#D0E0F1;COLOR:#ff3300" label="Bottom Menu"></optgroup>

<?php
while($hea5=mysql_fetch_array($head5))
{
?>
<option value="<?echo $hea5['sno'].'b'?>"><?echo $hea5['name']?></option>
<?php
}
?>
<optgroup value="-1" STYLE="BACKGROUND:#D0E0F1;COLOR:#ff3300" label="Home Page Programs"></optgroup>

<?php
while($hea8=mysql_fetch_array($head8))
{
?>
<option value="<?echo $hea8['parentid'].'p'?>"><?echo $hea8['subcate']?></option>
<?php
}
?>
<optgroup value="-1" STYLE="BACKGROUND:#D0E0F1;COLOR:#ff3300" label="Top Quick Menu"></optgroup>

<?php
while($hea10=mysql_fetch_array($head10))
{
?>
<option value="<?echo $hea10['sno'].'k'?>"><?echo $hea10['name']?></option>
<?php
}
?>
											</select>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Tab Heading<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="txtheading" value="" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>	
									<div class="control-group">
										<label class="control-label">Tab Teaser Text<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 m-wrap" id="em1" name="teaser" rows="6" data-error-container="#editor2_error"></textarea>
										</div>
									</div>	
									<div class="control-group">
										<label class="control-label">Tab Description<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 ckeditor m-wrap" id="em1" name="description" rows="6" data-error-container="#editor2_error"></textarea>
											<div id="editor2_error"></div>
										</div>
									</div>								
									
									<div class="form-actions">
										<button type="submit" class="btn purple">Save</button>
										<button type="button" class="btn">Cancel</button>
										<input type="hidden" name="flag" size="20" value="1">
										<input type="hidden" name="action" size="5" value="save">
										<input type="hidden" name="sno" value="">
										<input type="hidden" name="typeval" value="">
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
function edit()
{
	if(isset($_GET['sno']) && !empty($_GET['sno']))
	{	
		$contentid=preg_replace('/[^0-9]/', '', trim($_GET['sno']));
		$query=mysql_query("select * from tab_content where sno='$contentid'");
		$row_content=mysql_fetch_array($query);

		if($row_content['pagehead']=='m')
		{
			$pagename="select name from heading where sno='$row_content[heading]'";
		}
		elseif($row_content['pagehead']=='s')
		{
			$pagename="select subhead,sno from sub_heading where sno='$row_content[heading]' and pagetype!='t'";
		}
		elseif($row_content['pagehead']=='i')
		{
			$pagename="select subhead from sub_sub_heading where sno='$row_content[heading]'";
		}
		elseif($row_content['pagehead']=='q')
		{
			$pagename="select name from quick_menu where sno='$row_content[heading]'";
		}
		elseif($row_content['pagehead']=='t')
		{
			$pagename="select name from top_menu where sno='$row_content[heading]'";
		}
		elseif($row_content['pagehead']=='o')
		{
			$pagename="select subhead from sub_heading where sno='$row_content[heading]' and pagetype='t'";
		}
		elseif($row_content['pagehead']=='b')
		{
			$pagename="select name from bottom_menu where sno='$row_content[heading]'";
		}
		elseif($row_content['pagehead']=='l')
		{
			$pagename="select name from middle_menu where sno='$row_content[heading]'";
		}
		elseif($row_content['pagehead']=='u')
		{
			$pagename="select subhead from sub_sub_sub_heading where sno='$row_content[heading]'";
		}
		elseif($row_content['pagehead']=='p')
		{
			$pagename="select subcate from programs where parentid='$row_content[heading]'";
		}
		elseif($row_content['pagehead']=='n')
		{
			$pagename="select subhead from nestedsub_heading where sno='$row_content[heading]'";
		}
		elseif($row_content['pagehead']=='k')
		{
			$pagename="select name from top_quick_menu where sno='$row_content[heading]'";
		}
		else
		{
			$pagename="select subhead from sub_sub_heading where sno='$row_content[heading]'";
		}
		$rowpage=mysql_fetch_array(mysql_query($pagename));						
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
	<script type="text/javascript" src="js/jquery.js"></script>

<script type="text/javascript">
$(document).ready(function(){
<?php
if($row_content['show_mapping']==0)
{
?>
	$("#google_map_code").hide();
<?php
}
?>

});
function show_maps(theval)
{
	if(theval=="1")
	{
		$("#google_map_code").show(200);
	}
	else
	{
		$("#google_map_code").hide(200);
	}
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
							Website Tab Management
							<small>Add Website Content</small>
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="mainmenu.php">Home</a> 
								<span class="icon-angle-right"></span>
							</li>
							<li>
								<a href="tab.php">Pages</a>
								<span class="icon-angle-right"></span>
							</li>
							<li><a href="#">Edit Website Page's</a></li>
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
								<div class="caption"><i class="icon-reorder"></i>Edit Page Content - <b>"<?php echo $rowpage[0];?>"</b></div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<!--a href="#portlet-config" data-toggle="modal" class="config"></a-->
									<a href="javascript:;" class="reload"></a>
									<!--a href="javascript:;" class="remove"></a-->
								</div>
							</div>
							<script type="text/javascript">
					
					function valselect(theval,theform)
					{
						var a=theval.length;
						var b=a-parseInt(1);
						var sno=theval.substr(0,b);
						var ctype1=theval.substr(b,a);
									
						theform.sno1.value=sno;
						theform.typeval.value=ctype1;
						if(ctype1=="p")
						{
							$("#packages").show();
						}
						else
						{
							$("#packages").hide();
						}					}
					</script>
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
								<form action="tab.php" id="form_edit_page" name="form_edit_page" class="form-horizontal" enctype="multipart/form-data" method="post">			
									<div class="control-group">
										<label class="control-label">Select Page to be Linked ( Menu Name )<span class="required">*</span></label>
										<div class="controls">
											<?php

											$main=mysql_query("select distinct(name),sno from heading where status='active' order by position");
											
											$head=mysql_query("select distinct(subhead),sno,heading from sub_heading where status='active' and pagetype!='t' order by heading");
											
											$head1=mysql_query("select distinct(subhead),sno,heading,mainhead from sub_sub_heading where status='active' order by mainhead");
											
											$head2=mysql_query("select * from sub_sub_sub_heading where status='active' order by mainhead");
											
											$head3=mysql_query("select * from quick_menu where status='active' order by position");
											
											$head4=mysql_query("select * from top_menu where status='active' order by position");
											
											$head6=mysql_query("select distinct(subhead),sno from sub_heading where status='active' and pagetype='t' order by position");
											
											$head5=mysql_query("select * from bottom_menu where status='active' order by position");
											
											$head7=mysql_query("select * from middle_menu where status='active' order by position");
											
											$head8=mysql_query("select distinct(subcate),parentid from programs where status='active' and ptype='main' order by position");
											
											$head9=mysql_query("select * from nestedsub_heading where status='active' order by mainhead");
											
											$head10=mysql_query("select * from top_quick_menu where status='active' order by name");
											?>
											
											<select size="1" name="menu_selection" onchange="valselect(this.value,form_edit_page);">
<option SELECTED value="<?php echo $row_content['heading']?>"><?php echo $rowpage[0]?></option>
<optgroup value="-1" STYLE="BACKGROUND:#D0E0F1;COLOR:#ff3300" label="Top Menu"></optgroup>

<?
while($hea4=mysql_fetch_array($head4))
{
?>
<option value="<?echo $hea4['sno'].'t'?>"><?echo $hea4['name']?></option>
<?
}
?>

<optgroup value="-1" STYLE="BACKGROUND:#D0E0F1;COLOR:#ff3300" label="Main Heading"></optgroup>
<?
while($hea=mysql_fetch_array($main))
{

?>
<option value="<?php echo $hea['sno']."m"?>"><?echo $hea['name']?></option>
<?
}
?>
<optgroup value="-1" STYLE="BACKGROUND:#D0E0F1;COLOR:#ff3300" label="Sub Heading"></optgroup>

<?
while($hea=mysql_fetch_array($head))
{
	$mhead=mysql_fetch_array(mysql_query("select name from heading where sno='$hea[heading]'"));
?>
<option value="<?php echo $hea['sno']."s"?>"><?echo $mhead['name']." - ".$hea['subhead']." - ".$hea['sno']?></option>
<?
}
?>
<optgroup value="-1" STYLE="BACKGROUND:#D0E0F1;COLOR:#ff3300" label="Sub - Sub Heading"></optgroup>

<?
while($hea1=mysql_fetch_array($head1))
{
	$mhead=mysql_fetch_array(mysql_query("select name from heading where sno='$hea1[mainhead]'"));

	$hname="select subhead from sub_heading where sno='$hea1[heading]'";
	$row_hname=mysql_fetch_array(mysql_query($hname));
?>
<option value="<?php echo $hea1['sno']."i"?>"><?echo $mhead['name']." - ".$row_hname['subhead']." - ".$hea1['subhead'];?></option>
<?
}
?>
<optgroup value="-1" STYLE="BACKGROUND:#D0E0F1;COLOR:#ff3300" label="Sub-Sub-Sub Heading"></optgroup>

<?php
while($hea2=mysql_fetch_array($head2))
{
	$mhead=mysql_fetch_array(mysql_query("select name from heading where sno='$hea2[mainhead]'"));

	$hname="select subhead from sub_heading where sno='$hea2[heading]'";
	$row_hname=mysql_fetch_array(mysql_query($hname));
	
	$hname2="select subhead from sub_sub_heading where sno='$hea2[subheading]'";
	$row_hname2=mysql_fetch_array(mysql_query($hname2));
?>
<option value="<?php echo $hea2['sno']."u"?>"><?echo $mhead['name'].' - '.$row_hname['subhead'].' - '.$row_hname2['subhead']." - ".$hea2['subhead'];?></option>
<?
}
?>
<optgroup value="-1" STYLE="BACKGROUND:#D0E0F1;COLOR:#ff3300" label="Nested Sub Heading"></optgroup>

<?php
while($hea9=mysql_fetch_array($head9))
{
	$mhead=mysql_fetch_array(mysql_query("select name from heading where sno='$hea9[mainhead]'"));

	$hname="select subhead from sub_heading where sno='$hea9[heading]'";
	$row_hname=mysql_fetch_array(mysql_query($hname));
	
	$hname2="select subhead from sub_sub_heading where sno='$hea9[subheading]'";
	$row_hname2=mysql_fetch_array(mysql_query($hname2));
	
	$hname3="select subhead from sub_sub_sub_heading where sno='$hea9[subsubhead]'";
	$row_hname3=mysql_fetch_array(mysql_query($hname3));
?>
<option value="<?php echo $hea9['sno']."n"?>"><?echo $mhead['name'].' - '.$row_hname['subhead'].' - '.$row_hname2['subhead'].' - '.$row_hname3['subhead']." - ".$hea9['subhead'];?></option>
<?
}
?>
<optgroup value="-1" STYLE="BACKGROUND:#D0E0F1;COLOR:#ff3300" label="Quick Navigation Menu"></optgroup>

<?
while($hea3=mysql_fetch_array($head3))
{
?>
<option value="<?echo $hea3['sno'].'q'?>"><?echo $hea3['name']?></option>
<?
}
?>
<optgroup value="-1" STYLE="BACKGROUND:#D0E0F1;COLOR:#ff3300" label="Middle Menu"></optgroup>

<?
while($hea7=mysql_fetch_array($head7))
{
?>
<option value="<?echo $hea7['sno'].'l'?>"><?echo $hea7['name']?></option>
<?
}
?>

<optgroup value="-1" STYLE="BACKGROUND:#D0E0F1;COLOR:#ff3300" label="Sub Heading of Top Bottom Menu"></optgroup>

<?
while($hea6=mysql_fetch_array($head6))
{
?>
<option value="<?echo $hea6['sno'].'o'?>"><?echo $hea6['subhead']?></option>
<?
}
?>
<optgroup value="-1" STYLE="BACKGROUND:#D0E0F1;COLOR:#ff3300" label="Bottom Menu"></optgroup>

<?
while($hea5=mysql_fetch_array($head5))
{
?>
<option value="<?echo $hea5['sno'].'b'?>"><?echo $hea5['name']?></option>
<?
}
?>
<optgroup value="-1" STYLE="BACKGROUND:#D0E0F1;COLOR:#ff3300" label="Quick Navigation Menu"></optgroup>

<?
while($hea8=mysql_fetch_array($head8))
{
?>
<option value="<?echo $hea8['parentid'].'p'?>"><?echo $hea8['subcate']?></option>
<?
}
?>
<optgroup value="-1" STYLE="BACKGROUND:#D0E0F1;COLOR:#ff3300" label="Top Quick Menu"></optgroup>

<?
while($hea10=mysql_fetch_array($head10))
{
?>
<option value="<?echo $hea10['sno'].'k'?>"><?echo $hea10['name']?></option>
<?
}
?>

</select>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Tab Heading<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="page_heading" value="<?php echo $row_content['page_heading'];?>" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>		
									<div class="control-group">
										<label class="control-label">Tab Teaser Text<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 m-wrap" id="em1" name="teaser" rows="6" data-error-container="#editor2_error"><?php echo $row_content['teaser_text'];?></textarea>
										</div>
									</div>						
									
									<div class="control-group">
										<label class="control-label">Tab Description<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 ckeditor m-wrap" name="description" rows="6" data-error-container="#editor2_error"><?php echo $row_content['detail'];?></textarea>
											<div id="editor2_error"></div>
										</div>
									</div>	
									<div class="form-actions">
										<button type="submit" class="btn purple">Save</button>
										<button type="button" class="btn">Cancel</button>
										<input type="hidden" name="action" size="20" value="edit1">
										<input type="hidden" name="sno" size="20" value="<?php echo $contentid; ?>">
										<input type="hidden" name="sno1" value="<?php echo $row_content['heading'];?>">
										<input type="hidden" name="typeval" value="<?php echo $row_content['pagehead'];?>">
										<input type="hidden" name="page" value="<?php echo $_GET['page'];?>">
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
	else
	{
		echo "<script>location.href='tab.php';</script>";
	}
}
?>