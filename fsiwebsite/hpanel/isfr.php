<?php
	include_once "includes/constant.php";
	include_once "control.php";
	$crdate=date("Y-m-d");

if(!isset($_REQUEST['action']))
{
	$action='';
	$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 16, 16); 
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
		
		$query="update isfr_data set status='inactive' where ser='$unid_id'";
		$rs=mysql_query($query);
		$md5_hash = md5(rand(0,999)); 
		$security_code = substr($md5_hash, 16, 16); 
		$_SESSION['capture_code']=$security_code;
		if($rs)
		{
			echo "<script>location.href='isfr.php?display=status'</script>";	
		}
		else
		{
			echo "<script>location.href='isfr.php?error=incorrect'</script>";	
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='isfr.php?status=codeinvalid'</script>";
	}
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='inactive')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
	
		$query="update isfr_data set status='active' where ser='$unid_id'";
		$rs=mysql_query($query);
		$md5_hash = md5(rand(0,999)); 
		$security_code = substr($md5_hash, 16, 16); 
		$_SESSION['capture_code']=$security_code;
		if($rs)
		{
			echo "<script>location.href='isfr.php?display=update'</script>";	
		}
		else
		{
			echo "<script>location.href='isfr.php?error=incorrect'</script>";	
		}
		
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='isfr.php?status=codeinvalid'</script>";
	}
}


if(isset($_POST['flag']) && !empty($_POST['flag']) && $_POST['flag']==1)
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_POST['log']));
	$iname = "";
	$fname = "";
	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		$ran = rand(1,9999);
				
		$img_response = sh_upload_file("txtbanner", "image", "../uploads/images/banner/", "img_".$ran);
		if($img_response)
		{
			$fname = $img_response;
		}
		else
		{
			$attacherror=1;
			$errormsg="Unable to Upload Image!";
		}	

		$doc_response = sh_upload_file("txtfile", "file", "../uploads/documents/", "news_".$ran);
		if($doc_response)
		{
			$iname = $doc_response;
		}
		else
		{
			$attacherror=1;
			$errormsg="Unable to Upload Document!";
		}
	
		//$desc = mysql_real_escape_string($_REQUEST['description']);
		$desc = filter_xss($_REQUEST['description']);
		$desc = editor_xss($_REQUEST['description']);
		$url = "";
		if (!filter_var($_POST['url'], FILTER_VALIDATE_URL) === false) {
			$url = filter_xss($_POST['url']);
		}
		
		$news_date = date("Y-m-d",strtotime($_POST['newsdate']));
		
		$query="insert into isfr_data set postdate='$news_date', primeArea = '$_POST[primeArea]', title='".filter_xss(strip_tags($_POST['txtheading']))."',description='$desc',friendly_url='".filter_xss(strip_tags($_POST['friendly_url']))."', link='".$url."', target='".filter_xss($_POST['target'])."',status='active', extension='$iname',image='$fname',crdate='$crdate',sorder='".filter_xss($_POST['txtposition'])."'";
		
		$rs=mysql_query($query);
		$md5_hash = md5(rand(0,999)); 
		$security_code = substr($md5_hash, 16, 16); 
		$_SESSION['capture_code']=$security_code;
		mysql_query("update update_tab set crdate='$crdate'");
		
		if($rs)
		{
					
			$url = "isfr.php?display=add"; 
			
			if($attacherror)
			{
				$url .= "&msg=".$errormsg;
			}
			
			echo "<script>location.href='$url'</script>";

		}
		else
		{
			echo "<script>location.href='isfr.php?error=incorrect'</script>";
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='isfr.php?status=codeinvalid'</script>";
	}
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='delete_heading')
{
	
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		
		$query="delete from isfr_data where ser='$unid_id'";
		$rs=mysql_query($query);
		$md5_hash = md5(rand(0,999)); 
		$security_code = substr($md5_hash, 16, 16); 
		$_SESSION['capture_code']=$security_code;
		if($rs)
		{
			echo "<script>location.href='isfr.php?display=delete'</script>";
		}
		else
		{
			echo "<script>location.href='isfr.php?error=incorrect'</script>";
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='isfr.php?status=codeinvalid'</script>";
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
		$ran = rand(9999,50000);
		
		$iname = "";
		$fname = "";
		
		$img_response = sh_upload_file("txtbanner", "image", "../uploads/images/banner/", "img_".$ran);
		if($img_response)
		{
			$fname = $img_response;
		}
		else
		{
			$attacherror=1;
			$errormsg=" Unable to Upload Image!";
		}	

		$doc_response = sh_upload_file("txtfile", "file", "../uploads/documents/", "news_".$ran);
		if($doc_response)
		{
			$iname = $doc_response;
		}
		else
		{
			$attacherror=1;
			$errormsg.=" Unable to Upload Document!";
		}
	
		$news_date=date("Y-m-d",strtotime($_POST['newsdate']));
		
		$url = "";
		if (!filter_var($_POST['url'], FILTER_VALIDATE_URL) === false) {
			$url = filter_xss($_POST['url']);
		}
		
		//$desc=mysql_real_escape_string($_REQUEST['description']);
		//$desc = filter_xss($_REQUEST['description']);
		$desc = editor_xss($_REQUEST['description']);
		
		$query="update isfr_data set postdate='$news_date', primeArea = '$_POST[primeArea]', title='".filter_xss(strip_tags($_POST[txtheading]))."',description='$desc',friendly_url='".filter_xss(strip_tags($_POST[friendly_url]))."', link='".$url."', target='".filter_xss(strip_tags($_POST[target]))."',sorder='".filter_xss($_POST[txtposition])."'";
		
		if(!empty($iname))
		{
			$query.=", extension='$iname'";
		}
		if(!empty($fname))
		{
			$query.=", image='$fname'";
		}	
		
		$query.=", lastmodify='$pdate' where ser='$unid_id'";
		
		$rs = mysql_query($query);

		$md5_hash = md5(rand(0,999)); 
		$security_code = substr($md5_hash, 16, 16); 
		$_SESSION['capture_code']=$security_code;
	
		if($rs)
		{
			
			$url = "isfr.php?display=update"; 
			
			if($attacherror)
			{
				$url .= "&msg=".$errormsg;
			}
			
			echo "<script>location.href='$url'</script>";
		}
		else
		{
			echo "<script>location.href='isfr.php?error=incorrect'</script>";
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='isfr.php?status=codeinvalid'</script>";
	}
}


function view()
{
	
	$tbl_name="isfr_data";		//your table name
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
	$targetpage = "isfr.php"; 	//your file name  (the name of this file)
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
	
	$sql = "select * from isfr_data order by ser desc LIMIT $start, $limit";
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
							ISFR Management
							<small>Add/Edit ISFR</small>
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
							<li><a href="#">ISFR</a></li>
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
											<th>Heading</th>
											<th width="49">Banner</th>
											<th>Status</th>
											<th colspan="2">Action</th>
											<th>Preview</th>
										</tr>
									</thead>
									<tbody>
									<?php
									$sno = $start;
									while($row_content=mysql_fetch_array($result))
									{
										$sno=$sno+1;
									?>
										<tr>
											<td><?php echo $sno; ?></td>
											<td>
											<?php
												echo htmlspecialchars($row_content['title'], ENT_QUOTES);
											?>
											</td>
											<td width="49">
											<?php
											if(isset($row_content['image']) && $row_content['image']!='' && file_exists("../uploads/images/banner/".$row_content['image']))
											{
											?>
											<a target="_blank" href="../uploads/images/banner/<?php echo $row_content['image']?>">
											<img border=0 src="images/down.jpg" title="<?echo $row_content['banner']?>" alt="View Banner"></a>
											<?
											}
											?>		
											</td>
											<td>
											<a href="isfr.php?action=<?php echo $row_content['status']?>&sno=<?php echo $row_content['ser']?>&log=<?php echo $_SESSION['capture_code'];?>">
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
											<a href="isfr.php?sno=<?php echo $row_content['ser'];?>&action=<?php echo 'edit_heading'?>&log=<?php echo $_SESSION['capture_code'];?>">
											<img border="0" src="images/edit.png" width="20" height="20" alt="Edit" name="Edit"></a></td>
											<td><input type="image" img border="0" src="images/delete.png" width="20" height="20" onclick="var a=confirm('Are You sure delete this record from database ?');if(a==true){location.href='isfr.php?sno=<?php echo $row_content['ser']?>&action=<?php echo 'delete_heading'?>&log=<?php echo $_SESSION['capture_code'];?>';}" alt="Delete" name="delete"></td>
											<td>
											<?php
											if(isset($demo_link) && $demo_link)
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
								<form action="isfr.php?action=category" enctype="multipart/form-data" id="form_page" name="form_page" class="form-horizontal" method="post">
									<div class="control-group">
										<label class="control-label">Show in Prime Position<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="primeArea">
												<option value="">Select...</option>
												<option value="1">Yes</option>
												<option value="0">No</option>
											</select>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">ISFR Date</label>
										<div class="controls">
											<input class="m-wrap" size="16" type="text" name="newsdate" autocomplete="off" value="" id="ui_date_picker_change_year_month"/>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">ISFR Heading<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="txtheading" value="" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Menu Slug / Friendly URL&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="text" name="friendly_url" value="" data-required="1" class="span6 m-wrap" size="20"/>
											<span class="help-block">e.g: </span>
										</div>
									</div>	
										<div class="control-group">
										<label class="control-label">ISFR Description<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 ckeditor m-wrap" name="description" rows="6" data-error-container="#editor2_error"></textarea>
											<div id="editor2_error"></div>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label">URL&nbsp;&nbsp;</label>
										<div class="controls">
											<input name="url" type="text" class="span6 m-wrap"/>
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
										<label class="control-label">Upload Image&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="file" name="txtbanner" size="10" style="font-family: Verdana; font-size: 9pt">
											<span class="help-block">e.g: only jpg,png,gif are allowed - optional field</span>
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
											<input name="txtposition" type="text" class="span6 m-wrap"/>
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
		$query=mysql_query("select * from isfr_data where ser='$contentid'");
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
							ISFR Management
							<small>Add/Edit ISFR</small>
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
							<li><a href="#">ISFR</a></li>
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
								<div class="caption"><i class="icon-reorder"></i>Edit ISFR Content - <b>"<?php echo filter_xss($row_content['title']);?>"</b></div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<!--a href="#portlet-config" data-toggle="modal" class="config"></a-->
									<a href="javascript:;" class="reload"></a>
									<!--a href="javascript:;" class="remove"></a-->
								</div>
							</div>
							
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
								<form action="isfr.php?action=category" enctype="multipart/form-data" id="form_page" name="editform_page" class="form-horizontal" method="post">
									<div class="control-group">
										<label class="control-label">Show in Prime Position<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="primeArea">
												<option value="">Select...</option>
												<option value="1" <?php if($row_content['primeArea']=='1'){ echo 'selected';}?>>Yes</option>
												<option value="0" <?php if($row_content['primeArea']=='0'){ echo 'selected';}?>>No</option>
											</select>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">ISFR Date</label>
										<div class="controls">
											<input class="span6 m-wrap" size="16" type="text" name="newsdate" autocomplete="off" value="<?php echo date('d-M-Y',strtotime($row_content['postdate']));?>" id="ui_date_picker_change_year_month"/>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">ISFR Heading<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="txtheading" value="<?php echo filter_xss(strip_tags(addslashes($row_content['title'])));?>" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Menu Slug / Friendly URL&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="text" name="friendly_url" value="<?php echo $row_content['friendly_url'];?>" data-required="1" class="span6 m-wrap" size="20"/>
											<span class="help-block">e.g: </span>
										</div>
									</div>	
										<div class="control-group">
										<label class="control-label">ISFR Description<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 ckeditor m-wrap" name="description" rows="6" data-error-container="#editor2_error"><?php echo $row_content['description'];?></textarea>
											<div id="editor2_error"></div>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label">URL&nbsp;&nbsp;</label>
										<div class="controls">
											<input name="url" type="text" value="<?php echo $row_content['link'];?>" class="span6 m-wrap"/>
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
										<label class="control-label">Upload Image&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="file" name="txtbanner" size="10" style="font-family: Verdana; font-size: 9pt">
											<span class="help-block">e.g: only jpg,png,gif are allowed - optional field 
											<?php
											if($row_content['image']!='' && file_exists("../uploads/images/banner/".$row_content['image']))
											{
											?>
											<a href="../uploads/images/banner/<?php echo $row_content['image']?>" title="View Attachment" target="_blank">
											<font color="#6A9D00" size="2" face="Trebuchet MS">view attachment</font></a>
											<?php
											}
											?>
											</span>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Upload Attachment&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="file" name="txtfile" size="10" style="font-family: Verdana; font-size: 9pt">
											<span class="help-block">e.g: only doc,pdf,xls are allowed - optional field
											<?php
													if($row_content['extension']!='' && file_exists("../uploads/documents/".$row_content['extension']))
													{
													?>
													<a href="../uploads/documents/<?php echo $row_content['extension']?>" title="View Attachment" target="_blank">
													<font color="#6A9D00" size="2" face="Trebuchet MS">view attachment</font></a>
													<?php
													}
													?>
										</span>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Website Position<span class="required">*</span></label>
										<div class="controls">
											<input name="txtposition" type="text" value="<?php echo $row_content['sorder'];?>" class="span6 m-wrap"/>
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
		echo "<script>location.href='isfr.php';</script>";
	}
}
?>
