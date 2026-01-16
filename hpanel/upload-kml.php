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

if(isset($_POST['flag']) && !empty($_POST['flag']) && $_POST['flag']==1)
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_POST['log']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		$kmldate=date("Y-m-d",strtotime($_POST['fdate']));
	
		$index=0;
		$state=mysql_query("select name,sno from state_master where status='active' order by name limit 0,18");
		while($row_state=mysql_fetch_array($state))
		{
			$default_size = 20 * 1024 * 1024;
			
			$ran=rand(1,500000);
			$upload_file_name = "updoc".$row_state['sno'];
			$text_field_name = "txttitle".$row_state['sno'];
			$size = $_FILES[ $upload_file_name ]['size'];
			$source = $_FILES[ $upload_file_name ]['tmp_name'];
			$fname = $ran."_".$_FILES[ $upload_file_name ]['name'];
			$type = $_FILES[ $upload_file_name ]['type'];
			
			$original_extension = (false === $pos = strrpos($fname, '.')) ? '' : substr($fname, $pos);
			
			if($_FILES[ $upload_file_name ]['name']!='' && ($type=="application/octet-stream" || $type=="application/xml" || $type == "application/vnd.google-earth.kml+xml") && ($original_extension == ".xml" || $original_extension == ".kml") && $size <= $default_size)
			{		
				$val=$_POST[ $text_field_name ];
				$sql="insert into upload_kml(state,date,title,extension,status,crdate) values('$row_state[sno]','$kmldate','$val','$fname','active','$crdate')";
			
				$uploadpath="../uploads/kmlfiles/";
				$dest=$uploadpath.$fname;
					
				if(move_uploaded_file($source,$dest))
				{      
					$rs = mysql_query($sql);
				}			
			}
			$index++;
		}
	
		mysql_query("update update_tab set crdate='$pdate'");
	
		if($rs)
		{
			echo "<script>location.href='upload-kml.php?display=add'</script>";
		}
		else
		{
			echo "<script>location.href='upload-kml.php?error=incorrect'</script>";
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='upload-kml.php?status=codeinvalid'</script>";
	}
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='delete_heading')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));
	
	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		$query="delete from upload_kml where ser='$unid_id'";
		$rs=mysql_query($query);
		
		if($rs)
		{
			echo "<script>location.href='upload-kml.php?display=delete'</script>";
		}
		else
		{
			echo "<script>location.href='upload-kml.php?error=incorrect'</script>";
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='upload-kml.php?status=codeinvalid'</script>";
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
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['ser']));
	
	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		$default_size = 20 * 1024 * 1024;
		
		$ran=rand(5000,9000);
		$size = $_FILES['updoc']['size'];
		$source = $_FILES['updoc']['tmp_name'];
		$fname = $ran."_".$_FILES['updoc']['name'];
		$type = $_FILES['updoc']['type'];
		$uploadpath="../uploads/kmlfiles/";
		$dest=$uploadpath.$fname;
		
		$sql1="update upload_kml set state='$_POST[state]', date='$_POST[fdate]',title='$_POST[txttitle]',description='$_POST[txtdescription]'";
		
		$original_extension = (false === $pos = strrpos($fname, '.')) ? '' : substr($fname, $pos);
		
		if($_FILES[ $upload_file_name ]['name']!='' && ($type=="application/octet-stream" || $type=="application/xml" || $type == "application/vnd.google-earth.kml+xml") && ($original_extension == ".xml" || $original_extension == ".kml") && $size <= $default_size)
		{
			$sql1.=" ,extension='$fname'";
			move_uploaded_file($source, $dest);
		}
		 $sql1.=" where ser='$unid_id'";
		 
		$rs = mysql_query($sql1);
	
		if($rs)
		{
			echo "<script>location.href='upload-kml.php?display=update'</script>";
		}
		else
		{
			echo "<script>location.href='upload-kml.php?error=incorrect'</script>";
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='upload-kml.php?status=codeinvalid'</script>";
	}
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='off')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['ser']));
	
	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		$sql="update upload_kml set status='inactive' where ser='$unid_id'";
		$rs = mysql_query($sql);
		
		if($rs)
		{
			echo "<script>location.href='upload-kml.php?display=update'</script>";	
		}
		else
		{
			echo "<script>location.href='upload-kml.php?error=incorrect'</script>";	
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='upload-kml.php?status=codeinvalid'</script>";
	}
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='on')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['ser']));
	
	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		$sql="update upload_kml set status='active' where ser='$unid_id'";
		$rs = mysql_query($sql);
		
		if($rs)
		{
			echo "<script>location.href='upload-kml.php?display=update'</script>";	
		}
		else
		{
			echo "<script>location.href='upload-kml.php?error=incorrect'</script>";	
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='upload-kml.php?status=codeinvalid'</script>";
	}
}

function view()
{
	
	$tbl_name="upload_kml";		//your table name
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
	$targetpage = "upload-kml.php"; 	//your file name  (the name of this file)
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
	
	$sql = "select * from $tbl_name order by ser desc LIMIT $start, $limit";
	$result=mysql_query($sql) or die(mysql_error());
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
	<link rel="stylesheet" type="text/css" href="assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.css"/>

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
							Upload KML Files
							<small>Upload Files (A-K)</small>
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
							<li><a href="#">Upload KML Files (A-K)</a></li>
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
								<div class="caption"><i class="icon-cogs"></i>Upload KML Files</div>
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
											<th>KML Title</th>
											<th>State</th>
											<th>Date</th>																						
											<th>KML</th>
											<th>Status</th>											
											<th colspan="2">Action</th>
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
												echo $row_content['title'];
											?>
											</td>
											<td>
											<?php
											$row_state = mysql_fetch_array(mysql_query("select name from state_master where sno = '$row_content[state]'"));
											echo $row_state['name'];
											?>
											</td>
											<td>
											<?php
											echo date("d-M-Y",strtotime($row_content['date']));
											?>
											</td>
											<td>
											<?php
											if(isset($row_content['extension']) && $row_content['extension']!="" && file_exists("../uploads/kmlfiles/$row_content[extension]"))
											{
											echo "<a target=_blank  href='../uploads/kmlfiles/$row_content[extension]'><img border=0 src='images/down.jpg' width=18 height=19 alt=View Attachment></a>";
										    }
											?>
											</td>
											<td>
											<?php
											if($row_content['status']=='inactive')
											{
											?>
											<a href="upload-kml.php?action=on&ser=<?php echo $row_content['ser'];?>&log=<?php echo $_SESSION['capture_code'];?>"><img src=images/off.gif border=0 title='Inactive' width=16 height=16></a>
											<?php
											}
											else
											{
											?>
											<a href="upload-kml.php?action=off&ser=<?php echo $row_content['ser'];?>&log=<?php echo $_SESSION['capture_code'];?>"><img src=images/on.gif border=0 title='Active' width=16 height=16></a>
											<?php
											}
											?>											</td>
											<td>
											<a href="upload-kml.php?sno=<?php echo $row_content['ser'];?>&action=<?php echo 'edit_heading'?>&log=<?php echo $_SESSION['capture_code'];?>">
											<img border="0" src="images/edit.png" width="20" height="20" alt="Edit" name="Edit"></a></td>
											<td><input type="image" img border="0" src="images/delete.png" width="20" height="20" onclick="var a=confirm('Are You sure delete this record from database ?');if(a==true){location.href='upload-kml.php?sno=<?php echo $row_content['ser']?>&action=<?php echo 'delete_heading'?>&log=<?php echo $_SESSION['capture_code'];?>';}" alt="Delete" name="delete"></td>
											

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
		
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN VALIDATION STATES-->
						<div class="portlet box purple">
							<div class="portlet-title">
								<div class="caption"><i class="icon-reorder"></i>Upload KML Files</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<!--a href="#portlet-config" data-toggle="modal" class="config"></a-->
									<a href="javascript:;" class="reload"></a>
									<!--a href="javascript:;" class="remove"></a-->
								</div>
							</div>
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
								<form action="upload-kml.php?action=category" enctype="multipart/form-data" id="form_page" name="form_page" class="form-horizontal" method="post">
									<div class="control-group">
										<label class="control-label">Select Date</label>
										<div class="controls">
											<input class="m-wrap" size="16" type="text" name="fdate" autocomplete="off" value="" id="ui_date_picker_change_year_month"/>
										</div>
									</div>
									<?php 
									$count = 0;
									$state=mysql_query("select name,sno from state_master where status='active' order by name limit 0,18");
									while($row_state=mysql_fetch_array($state))
									{
										$count++;
									?>	
									<div style="background:#193A01; color:#FFFFFF; padding: 10px;"><?php echo $count.". ".$row_state['name'];?></div>
									<br>
									<div class="control-group">
										<label class="control-label">KML File Title</label>
										<div class="controls">
											<input class="m-wrap" size="16" type="text" name="txttitle<?php echo $row_state['sno'];?>" value=""/>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Upload KML&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="file" name="updoc<?php echo $row_state['sno'];?>" size="10" style="font-family: Verdana; font-size: 9pt">
											
										</div>
									</div>
									<?php
									}
									?>
									
									<div class="form-actions">
										<button type="submit" class="btn purple">Save</button>
										<button type="button" class="btn">Cancel</button>
										<input type="hidden" name="flag" size="20" value="1">
										<input type="hidden" name="action" size="5" value="save">
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
	<script src="assets/scripts/ui-jqueryui.js"></script>     
	<!-- END PAGE LEVEL SCRIPTS -->
	<script>
		jQuery(document).ready(function() {       
		   // initiate layout and plugins
		   App.init();
		   UIJQueryUI.init();
		});
	</script>
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
		$query=mysql_query("select * from upload_kml where sno='$contentid'");
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
							Upload KML Files
							<small>Upload Files</small>
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
							<li><a href="#">Upload KML Files (A-K)</a></li>
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
								<div class="caption"><i class="icon-reorder"></i>Edit File</b></div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<!--a href="#portlet-config" data-toggle="modal" class="config"></a-->
									<a href="javascript:;" class="reload"></a>
									<!--a href="javascript:;" class="remove"></a-->
								</div>
							</div>
							
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
								<form action="upload-kml.php?action=category" enctype="multipart/form-data" id="form_page" name="editform_page" class="form-horizontal" method="post">
									
									<div class="control-group">
										<label class="control-label">Upload Attachment&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="file" name="txtfile" size="10" style="font-family: Verdana; font-size: 9pt">
											<span class="help-block">e.g: only doc,pdf,xls are allowed - optional field
											<?php
													if($row_content['filename']!='' && file_exists("../uploads/kmlfiles/".$row_content['filename']))
													{
													?>
													<a href="../uploads/kmlfiles/<?php echo $row_content['filename']?>" title="View Attachment" target="_blank">
													<font color="#6A9D00" size="2" face="Trebuchet MS">view attachment</font></a>
													<?php
													}
													?>
										</span>
										</div>
									</div>
										
									<div class="form-actions">
										<button type="submit" class="btn purple">Save</button>
										<button type="button" class="btn">Cancel</button>
										<input type="hidden" name="action" size="5" value="edit1">
										<input type="hidden" name="sno" value="<?php echo $contentid;?>">
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
		echo "<script>location.href='upload-kml.php';</script>";
	}
}
?>