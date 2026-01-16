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

	if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='active')
	{
		$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
		$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
		$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));
		
		if($capture==$postcapture && $capture!="" && $postcapture!="")
		{
		
			$query="update recruitments set status='inactive' where ser='$unid_id'";
			$rs=mysql_query($query);
			$md5_hash = md5(rand(0,999)); 
			$security_code = substr($md5_hash, 15, 6); 
			$_SESSION['capture_code']=$security_code;
			if($rs)
			{
				echo "<script>location.href='recruitments.php?display=status'</script>";	
			}
			else
			{
				echo "<script>location.href='recruitments.php?error=incorrect'</script>";	
			}
		}
		else
		{
			echo "<p align='center'>Please Wait..</p>";
			echo "<script>location.href='recruitments.php?status=codeinvalid'</script>";
		}
	}

	if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='inactive')
	{
		$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
		$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
		$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));
		
		if($capture==$postcapture && $capture!="" && $postcapture!="")
		{
		
			$query="update recruitments set status='active' where ser='$unid_id'";
			$rs=mysql_query($query);
			$md5_hash = md5(rand(0,999)); 
		$security_code = substr($md5_hash, 15, 6); 
		$_SESSION['capture_code']=$security_code;
			if($rs)
			{
				echo "<script>location.href='recruitments.php?display=update'</script>";	
			}
			else
			{
				echo "<script>location.href='recruitments.php?error=incorrect'</script>";	
			}
		}
		else
		{
			echo "<p align='center'>Please Wait..</p>";
			echo "<script>location.href='recruitments.php?status=codeinvalid'</script>";
		}
	}


	if(isset($_POST['flag']) && !empty($_POST['flag']) && $_POST['flag']==1)
	{
		$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
		$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_POST['log']));

		if($capture==$postcapture && $capture!="" && $postcapture!="")
		{
		
			$ran = rand(1,10000);	
			
			$iname = "";
			
			$doc_response = sh_upload_file("txtfile", "file", "../uploads/recruitments/", "rec_".$ran);

			if($doc_response)
			{
				$fname = $doc_response;
			}
			else
			{
				$attacherror=1;
				$errormsg="Unable to Upload Document!";
			}
		
			
			$desc=mysql_real_escape_string($_REQUEST['description']);
			//$desc=$_REQUEST['description'];
			
			$start_date=date("Y-m-d",strtotime($_POST['startdate']));
			
			$last_date=date("Y-m-d",strtotime($_POST['lastdate']));
			
			$insert = "
				insert into recruitments(
					startdate, lastdate, imageicon, reference_no,
					title, description, link, custom_status, status,
					extension, image, crdate, lastmodify, target, sorder
				)
				values(
					'$start_date', '$last_date', '$_POST[imageupload]', '" . filter_xss($_POST['ref_no']) . "',
					'" . filter_xss($_POST['txttitle']) . "',  '".filter_xss($_POST['description'])."',
					'".filter_xss($_POST['txtlink'])."', '$_POST[custom_status]', 'active', '$fname', 
					'$iname', '$pdate', '$pdate', '$_POST[target]', '" . filter_xss($_POST['sorder']) . "'
				)";

			$rs = mysql_query($insert);

			mysql_query("update update_tab set crdate = '$pdate'");

			$md5_hash = md5(rand(0,999)); 
			$security_code = substr($md5_hash, 15, 6); 
			$_SESSION['capture_code']=$security_code;

			if($rs)
			{
				echo "<script>location.href='recruitments.php?display=add'</script>";
			}
			else
			{
				echo "<script>location.href='recruitments.php?error=incorrect'</script>";
			}
		}
		else
		{
			echo "<p align='center'>Please Wait..</p>";
			echo "<script>location.href='recruitments.php?status=codeinvalid'</script>";
		}
	}

	if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='delete_heading')
	{
		$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
		$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
		$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));
		
		if($capture==$postcapture && $capture!="" && $postcapture!="")
		{
		
			$query="delete from recruitments where ser='$unid_id'";
			$rs=mysql_query($query);
				$md5_hash = md5(rand(0,999)); 
		$security_code = substr($md5_hash, 15, 6); 
		$_SESSION['capture_code']=$security_code;
			if($rs)
			{
				echo "<script>location.href='recruitments.php?display=delete'</script>";
			}
			else
			{
				echo "<script>location.href='recruitments.php?error=incorrect'</script>";
			}
		}
		else
		{
			echo "<p align='center'>Please Wait..</p>";
			echo "<script>location.href='recruitments.php?status=codeinvalid'</script>";
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
//error_reporting(E_ALL);
//ini_set('display_errors',1);
			$iname = "";
			$ran = rand(1,20000);
			
			$doc_response = sh_upload_file("txtfile", "file", "../uploads/recruitments/", "rec_" . $ran);

			if($doc_response)
			{
				$fname = $doc_response;
			}
			else
			{
				$attacherror=1;
				$errormsg="Unable to Upload Document!";
			}

		
			$start_date=date("Y-m-d",strtotime($_POST['startdate']));
			
			$last_date=date("Y-m-d",strtotime($_POST['lastdate']));
		
				
		$update = "
			update recruitments set
				startdate='$start_date', lastdate='$last_date', imageicon='$_POST[imageupload]',
				reference_no='" . filter_xss($_POST['ref_no']) . "', title='" . filter_xss($_POST['title']) . "',
				description='" . filter_xss($_POST['description']) . "', custom_status='$_POST[custom_status]',
				link='" . filter_xss($_POST['link']) . "', lastmodify='$pdate', target='$_POST[target]',
				sorder='".filter_xss($_POST['sorder'])."'";

		if($doc_response)
		{
			$update.=", extension='$fname'";
		}

		$update.=" where ser='$unid_id'";

		$rs=mysql_query($update);
		$md5_hash = md5(rand(0,999)); 
		$security_code = substr($md5_hash, 15, 6); 
		$_SESSION['capture_code']=$security_code;
		if($rs)
		{
			echo "<script>location.href='recruitments.php?display=update'</script>";
		}
		else
		{
			echo "<script>location.href='recruitments.php?error=incorrect'</script>";
		}
		}
		else
		{
			echo "<p align='center'>Please Wait..</p>";
			echo "<script>location.href='recruitments.php?status=codeinvalid'</script>";
		}
	}


function view()
{
	
	$tbl_name="recruitments";		//your table name
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
	$targetpage = "recruitments.php"; 	//your file name  (the name of this file)
	$limit = 10; 								//how many items to show per page
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
	
	$sql = "select * from recruitments order by ser desc LIMIT $start, $limit";
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
							Recruitments
							<small>Add/Edit Recruitment</small>
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="mainmenu.php">Home</a> 
								<span class="icon-angle-right"></span>
							</li>
							<li>
								<a href="#">Recruitment</a>
								<span class="icon-angle-right"></span>
							</li>
							<li><a href="#">Recruitments</a></li>
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
						?>						<div class="portlet box blue">
							<div class="portlet-title">
								<div class="caption"><i class="icon-cogs"></i>Website Pages</div>
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
											<th>Recruitment</th>
											<th width="49">Banner</th>
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
											<td width="49">
											<?php
											if(isset($row_content['banner']) && $row_content['banner']!='' && file_exists("../images/banner/".$row_content['banner']))
											{
											?>
											<a target="_blank" href="../images/banner/<?php echo $row_content['banner']?>">
											<img border=0 src="images/down.jpg" title="<?echo $row_content['banner']?>" alt="View Banner"></a>
											<?
											}
											?>		
											</td>
											<td>
											<a href="recruitments.php?action=<?php echo $row_content['status']?>&sno=<?php echo $row_content['ser']?>&log=<?php echo $_SESSION['capture_code'];?>">
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
											<a href="recruitments.php?sno=<?php echo $row_content['ser'];?>&action=<?php echo 'edit_heading'?>&log=<?php echo $_SESSION['capture_code'];?>">
											<img border="0" src="images/edit.png" width="20" height="20" alt="Edit" name="Edit"></a></td>
											<td><input type="image" img border="0" src="images/delete.png" width="20" height="20" onclick="var a=confirm('Are You sure delete this record from database ?');if(a==true){location.href='recruitments.php?sno=<?php echo $row_content['ser']?>&action=<?php echo 'delete_heading'?>&log=<?php echo $_SESSION['capture_code'];?>';}" alt="Delete" name="delete"></td>
											<td>
											
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
								<form action="recruitments.php?action=category" enctype="multipart/form-data" id="form_page" name="form_page" class="form-horizontal" method="post">
									
									<div class="control-group">
										<label class="control-label">Registration Date</label>
										<div class="controls">
											<input class="m-wrap" size="16" type="text" name="startdate" autocomplete="off" value="" id="ui_date_picker_change_year_month"/>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Closing Date</label>
										<div class="controls">
											<input class="m-wrap" size="16" type="text" name="lastdate" autocomplete="off" value="" id="ui_date_picker_change_year_month1"/>
										</div>
									</div>
																	
									<div class="control-group">
										<label class="control-label">Adv. / Reference No.<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="ref_no" value="" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>

									<div class="control-group">
										<label class="control-label">Post Name<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="txttitle" value="" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>
										
										<div class="control-group">
										<label class="control-label">Description<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 ckeditor m-wrap" name="description" rows="6" data-error-container="#editor2_error"></textarea>
											<div id="editor2_error"></div>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label">URL&nbsp;&nbsp;</label>
										<div class="controls">
											<input name="txtlink" type="text" class="span6 m-wrap"/>
											<span class="help-block">e.g: http://www.demo.com or http://demo.com - optional field</span>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Target<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="target">
												<option value="">Select...</option>
												<option value="_blank">Open in New Window</option>
												<option value="_self">Open in Same Window</option>
											</select>
											<span class="help-block">applicable only if you enter any other link</span>
										</div>
									</div>					
									
									<div class="control-group">
										<label class="control-label">Upload Attachment&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="file" name="txtfile" size="10" style="font-family: Verdana; font-size: 9pt">
											<span class="help-block">e.g: only doc,pdf,xls are allowed - optional field</span>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Website Position<span class="required">*</span></label>
										<div class="controls">
											<input name="sorder" type="text" class="span6 m-wrap"/>
										</div>
									</div>	
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
		$query=mysql_query("select * from recruitments where ser='$contentid'");
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
							Recruitments
							<small>Add/Edit Recruitment</small>
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="mainmenu.php">Home</a> 
								<span class="icon-angle-right"></span>
							</li>
							<li>
								<a href="#">Recruitment</a>
								<span class="icon-angle-right"></span>
							</li>
							<li><a href="#">Recruitments</a></li>
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
								<div class="caption"><i class="icon-reorder"></i>Edit Page Content - <b>"<?php echo $row_content['title'];?>"</b></div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<!--a href="#portlet-config" data-toggle="modal" class="config"></a-->
									<a href="javascript:;" class="reload"></a>
									<!--a href="javascript:;" class="remove"></a-->
								</div>
							</div>
							
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
								<form action="recruitments.php?action=category" enctype="multipart/form-data" id="form_page" name="editform_page" class="form-horizontal" method="post">
									
									<div class="control-group">
										<label class="control-label">Registration Date</label>
										<div class="controls">
											<input class="m-wrap" size="16" type="text" name="startdate" autocomplete="off" value="<?php echo $row_content['startdate'];?>" id="ui_date_picker_change_year_month"/>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Last Date</label>
										<div class="controls">
											<input class="m-wrap" size="16" type="text" name="lastdate" autocomplete="off" value="<?php echo $row_content['lastdate'];?>" id="ui_date_picker_change_year_month1"/>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label">Adv. / Reference No.<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="ref_no" value="<?php echo $row_content['reference_no'];?>" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>

									<div class="control-group">
										<label class="control-label">Post Name<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="title" value="<?php echo $row_content['title'];?>" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>
										
										<div class="control-group">
										<label class="control-label">Description<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 ckeditor m-wrap" name="description" rows="6" data-error-container="#editor2_error"><?php echo $row_content['description'];?></textarea>
											<div id="editor2_error"></div>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label">URL&nbsp;&nbsp;</label>
										<div class="controls">
											<input name="link" type="text" value="<?php echo $row_content['link'];?>" class="span6 m-wrap"/>
											<span class="help-block">e.g: http://www.demo.com or http://demo.com - optional field</span>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Target<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="target">
												<option value="">Select...</option>
												<option value="_blank" <?php if($row_content['target']=='_blank'){ echo 'selected';}?>>Open in New Window</option>
												<option value="_self" <?php if($row_content['target']=='_self'){ echo 'selected';}?>>Open in Same Window</option>
											</select>
											<span class="help-block">applicable only if you enter any other link</span>
										</div>
									</div>					
									
									<div class="control-group">
										<label class="control-label">Upload Attachment&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="file" name="txtfile" size="10" style="font-family: Verdana; font-size: 9pt">
											<span class="help-block"><?php
			if(isset($row_content['extension']) && $row_content['extension']!='' && file_exists("../uploads/recruitments/".$row_content['extension']))
			{
			?>
			<a href="../uploads/recruitments/<?php echo $row_content['extension']?>" title="View Attachment" target="_blank">
			<font color="#6A9D00" size="2" face="Trebuchet MS">view attachment</font></a>
			<?php
			}
			?>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												</font>												
			</p>
</span>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Website Position<span class="required">*</span></label>
										<div class="controls">
											<input name="sorder" value="<?php echo $row_content['sorder'];?>" type="text" class="span6 m-wrap"/>
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
	else
	{
		echo "<script>location.href='recruitments.php';</script>";
	}
}
?>
