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
		
		$query="update photo_subcate set status='inactive' where childid='$unid_id'";
		$rs=mysql_query($query);
			$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 15, 6); 
	$_SESSION['capture_code']=$security_code;
		if($rs)
		{
			echo "<script>location.href='photo-gallery.php?display=status'</script>";	
		}
		else
		{
			echo "<script>location.href='photo-gallery.php?error=incorrect'</script>";	
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='photo-gallery.php?status=codeinvalid'</script>";
	}
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='inactive')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));
	
	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		
		$query="update photo_subcate set status='active' where childid='$unid_id'";
		$rs=mysql_query($query);
		$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 15, 6); 
	$_SESSION['capture_code']=$security_code;
		if($rs)
		{
			echo "<script>location.href='photo-gallery.php?display=update'</script>";	
		}
		else
		{
			echo "<script>location.href='photo-gallery.php?error=incorrect'</script>";	
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='photo-gallery.php?status=codeinvalid'</script>";
	}
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='yes')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));
	
	if($capture==$postcapture && $capture!="" && $postcapture!="")
		{
	
		$query="update photo_subcate set home='no' where childid='$unid_id'";
		$rs=mysql_query($query);
			$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 15, 6); 
	$_SESSION['capture_code']=$security_code;
		if($rs)
		{
			echo "<script>location.href='photo-gallery.php?display=update'</script>";	
		}
		else
		{
			echo "<script>location.href='photo-gallery.php?error=incorrect'</script>";	
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='photo-gallery.php?status=codeinvalid'</script>";
	}
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='no')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));
	
	if($capture==$postcapture && $capture!="" && $postcapture!="")
		{
	
		$query="update photo_subcate set home='yes' where childid='$unid_id'";
		$rs=mysql_query($query);
			$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 15, 6); 
	$_SESSION['capture_code']=$security_code;
		if($rs)
		{
			echo "<script>location.href='photo-gallery.php?display=update'</script>";	
		}
		else
		{
			echo "<script>location.href='photo-gallery.php?error=incorrect'</script>";	
		}
	}	
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='photo-gallery.php?status=codeinvalid'</script>";
	}
}

if(isset($_POST['flag']) && !empty($_POST['flag']) && $_POST['flag']==1)
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_POST['log']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
		
		$auto_id=mysql_query("select max(childid) as sno from photo_subcate");
		
		$row_id=mysql_fetch_array($auto_id);
		
		if($row_id['sno']=="")
		{
			$start=1;
		}
		else
		{
			$start=$row['sno']+1;
		}
		
		$$fname = "";
		$ran=rand(1,1000);

		$img_response = sh_upload_file("txtbanner", "image", "../uploads/images/subcate/", "img_".$ran);
		if($img_response)
		{
			$fname = $img_response;
		}
		else
		{
			$attacherror=1;
			$errormsg=" Unable to Upload Image!";
		}	
			
		$desc=filter_xss($_REQUEST['description']);
		//$desc=$_REQUEST['description'];
		$count=0;
		
		//*********************************************************************************************
		
		$chk=mysql_query("select sno from friendly_url where url='$_POST[friendly_url]'");
		if(mysql_num_rows($chk)==0)
		{
			$seo=mysql_query("insert into friendly_url set url='$_POST[friendly_url]',type='category', id='$start'");
			mysql_query($seo);
		}
	
		
		//*********************************************************************************************
	
		$query="insert into photo_subcate set subcate = '".filter_xss($_POST['name'])."', extraClass = '".filter_xss($_POST['extraClass'])."',parentid='".filter_xss($_POST['parent_id'])."', description = '$desc', status='active', sorder='".filter_xss($_POST['txtposition'])."', image='$fname', crdate='$crdate'";
		
		$rs=mysql_query($query);
			$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 15, 6); 
	$_SESSION['capture_code']=$security_code;
		mysql_query("update update_tab set crdate='$pdate'");
		
		
		if($rs)
		{
			echo "<script>location.href='photo-gallery.php?display=add'</script>";
		}
		else
		{
			echo "<script>location.href='photo-gallery.php?error=incorrect'</script>";
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='photo-gallery.php?status=codeinvalid'</script>";
	}
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='delete_heading')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));
	
	if($capture==$postcapture && $capture!="" && $postcapture!="")
		{
	
		$query="delete from photo_subcate where childid='$unid_id'";
		$rs=mysql_query($query);
			$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 15, 6); 
	$_SESSION['capture_code']=$security_code;
		if($rs)
		{
			echo "<script>location.href='photo-gallery.php?display=delete'</script>";
		}
		else
		{
			echo "<script>location.href='photo-gallery.php?error=incorrect'</script>";
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='photo-gallery.php?status=codeinvalid'</script>";
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
		
		$$fname = "";
		$ran=rand(1,1000);

		$img_response = sh_upload_file("txtbanner", "image", "../uploads/images/subcate/", "img_".$ran);
		if($img_response)
		{
			$fname = $img_response;
		}
		else
		{
			$attacherror=1;
			$errormsg=" Unable to Upload Image!";
		}	
		
		$desc=filter_xss($_REQUEST['description']);
		//$desc=$_REQUEST['description'];
		
		$query="update photo_subcate set subcate = '".filter_xss($_POST['name'])."', extraClass = '".filter_xss($_POST['extraClass'])."',parentid='".filter_xss($_POST['parent_id'])."', description = '$desc', status='active', sorder='".filter_xss($_POST['txtposition'])."'";
	
		if($img_response)
		{
			$query.=", image='$fname'";
		}
		
		$query.=" where childid='$unid_id'";

		$rs=mysql_query($query);
		$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 15, 6); 
	$_SESSION['capture_code']=$security_code;
		if($rs)
		{
			echo "<script>location.href='photo-gallery.php?display=update'</script>";
		}
		else
		{
			echo "<script>location.href='photo-gallery.php?error=incorrect'</script>";
		}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='photo-gallery.php?status=codeinvalid'</script>";
	}
}


function view()
{
	
	$tbl_name="photo_subcate";		//your table name
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
	$targetpage = "photo-gallery.php"; 	//your file name  (the name of this file)
	$limit = 30; 								//how many items to show per page
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
	
	$sql = "select * from photo_subcate order by childid desc LIMIT $start, $limit";
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
							Photo Gallery
							<small>Add/Edit Gallery</small>
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="mainmenu.php">Home</a> 
								<span class="icon-angle-right"></span>
							</li>
							<li>
								<a href="#">Extra's</a>
								<span class="icon-angle-right"></span>
							</li>
							<li><a href="#">Manage Photo's</a></li>
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
								<div class="caption"><i class="icon-cogs"></i>Photo Category</div>
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
											<th>Category Name</th>
											<th>Name</th>
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
											$row_cate=mysql_fetch_array(mysql_query("select category from photo_cate where parentid='$row_content[parentid]'"));
											echo $row_cate['category']; ?>
											</td>
											<td>
											<?php echo $row_content['subcate']; ?>
											</td>
											<td width="49">
											<?php
											if(isset($row_content['image']) && $row_content['image']!='' && file_exists("../uploads/images/subcate/".$row_content['image']))
											{
											?>
											<a target="_blank" href="../uploads/images/subcate/<?php echo $row_content['image']?>">
											<img border=0 src="../uploads/images/subcate/<?php echo $row_content['image']?>" width="40" height="40" title="<?php echo $row_content['image']?>" alt="View Banner"></a>
											<?
											}
											?>		
											</td>
											<td>
											<a href="photo-gallery.php?action=<?php echo $row_content['status']?>&sno=<?php echo $row_content['childid']?>&log=<?php echo $_SESSION['capture_code'];?>">
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
											<a href="photo-gallery.php?sno=<?php echo $row_content['childid'];?>&action=<?php echo 'edit_heading'?>&log=<?php echo $_SESSION['capture_code'];?>">
											<img border="0" src="images/edit.png" width="20" height="20" alt="Edit" name="Edit"></a></td>
											<td><input type="image" img border="0" src="images/delete.png" width="20" height="20" onclick="var a=confirm('Are You sure delete this record from database ?');if(a==true){location.href='photo-gallery.php?sno=<?php echo $row_content['childid']?>&action=<?php echo 'delete_heading'?>&log=<?php echo $_SESSION['capture_code'];?>';}" alt="Delete" name="delete"></td>
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
								<div class="caption"><i class="icon-reorder"></i>Add New</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<!--a href="#portlet-config" data-toggle="modal" class="config"></a-->
									<a href="javascript:;" class="reload"></a>
									<!--a href="javascript:;" class="remove"></a-->
								</div>
							</div>
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
								<form action="photo-gallery.php?action=category" enctype="multipart/form-data" id="form_page" name="form_page" class="form-horizontal" method="post">
									<div class="control-group">
										<label class="control-label">Photo Category<span class="required">*</span></label>
										<div class="controls">
											<select name="parent_id">
											<option value="">-- Select --</option>
											<?php
											$res_cate = mysql_query("select category,parentid from photo_cate where status='active' order by parentid desc");
											while($row_cate= mysql_fetch_array($res_cate))
											{
											?>
												<option value="<?php echo $row_cate['parentid'];?>"><?php echo $row_cate['category'];?></option>
											<?php
											}
											?>
																						
											</select>
										</div>
									</div>								
									<div class="control-group">
										<label class="control-label">Name<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="name" data-required="1" class="span6 m-wrap" size="20"/>
										</div>
									</div>

									<div class="control-group">
										<label class="control-label">CSS Classes to used by container<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="extraClass" data-required="1" class="span6 m-wrap" size="20"/>
										</div>
									</div>									
									
									<div class="control-group">
										<label class="control-label">Upload Category Banner&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="file" name="txtbanner" size="10" style="font-family: Verdana; font-size: 9pt">
											<span class="help-block">e.g: only jpg,png,gif are allowed - optional field</span>
										</div>
									</div>																	
									
									<div class="control-group">
										<label class="control-label">Menu Slug / Friendly URL&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="text" name="friendlyurl" data-required="1" class="span6 m-wrap"/>
											<span class="help-block">e.g: </span>
										</div>
									</div>	
									<div class="control-group">
										<label class="control-label">Category Description<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 ckeditor m-wrap" id="em1" name="description" rows="6" data-error-container="#editor2_error"></textarea>
											<div id="editor2_error"></div>
										</div>
									</div>								
									<div class="control-group">
										<label class="control-label">Sorting Order<span class="required">*</span></label>
										<div class="controls">
											<input name="txtposition" type="text" class="span6 m-wrap"/>
											<span class="help-block">starts with 0. for eg: 1, 2 or 40 </span>
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
		$query=mysql_query("select * from photo_subcate where childid='$contentid'");
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
							Photo Gallery
							<small>Add/Edit Gallery</small>
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="mainmenu.php">Home</a> 
								<span class="icon-angle-right"></span>
							</li>
							<li>
								<a href="#">Extra's</a>
								<span class="icon-angle-right"></span>
							</li>
							<li><a href="#">Manage Photo's</a></li>
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
								<div class="caption"><i class="icon-reorder"></i>Edit Photo Gallery - <b>"
								<?php 
								
								echo $row_content['subcate'];
								
								?>" </b></div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<!--a href="#portlet-config" data-toggle="modal" class="config"></a-->
									<a href="javascript:;" class="reload"></a>
									<!--a href="javascript:;" class="remove"></a-->
								</div>
							</div>
							
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
								<form action="photo-gallery.php?action=category" enctype="multipart/form-data" id="form_page" name="editform_page" class="form-horizontal" method="post">
																		
									<div class="control-group">
										<label class="control-label">Photo Category<span class="required">*</span></label>
										<div class="controls">
											<select name="parent_id">
											<option value="">-- Select --</option>
											<?php
											$res_cate = mysql_query("select category,parentid from photo_cate where status='active' order by parentid desc");
											while($row_cate= mysql_fetch_array($res_cate))
											{
											?>
												<option value="<?php echo $row_cate['parentid'];?>" <?php if($row_content['parentid']==$row_cate['parentid']) { echo 'selected';}?>><?php echo $row_cate['category'];?></option>
											<?php
											}
											?>
																						
											</select>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label">Photo Name<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="name" data-required="1" value="<?php echo $row_content['subcate'];?>"  class="span6 m-wrap" size="20"/>
										</div>
									</div>								
									
									<div class="control-group">
										<label class="control-label">Upload Category Banner&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="file" name="txtbanner" size="10" style="font-family: Verdana; font-size: 9pt">
											<?php
											if($row_content['image']!='' && file_exists("../uploads/images/subcate/".$row_content['image']))
											{
											?>
											<a target="_blank" href="../uploads/images/subcate/<?php echo $row_content['image']?>">
											<img border=0 src="images/down.jpg" title="<?php echo $row_content['image']?>"></a>
											<?php
											}
											?>
											<span class="help-block">e.g: only jpg,png,gif are allowed - optional field</span>
										</div>
									</div>	

									<div class="control-group">
										<label class="control-label">CSS Classes to used by container<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="extraClass" value="<?php echo $row_content['extraClass'];?>" data-required="1" class="span6 m-wrap" size="20"/>
										</div>
									</div>									
									
									<div class="control-group">
										<label class="control-label">Category Description<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 ckeditor m-wrap" id="em1" name="description" rows="6" data-error-container="#editor2_error"> 
											<?php echo $row_content['description'];?> </textarea>
											<div id="editor2_error"></div>
										</div>
									</div>								
									<div class="control-group">
										<label class="control-label">Sorting Order<span class="required">*</span></label>
										<div class="controls">
											<input name="txtposition" type="text" value="<?php echo $row_content['sorder'];?>"  class="span6 m-wrap"/>
											<span class="help-block">starts with 0. for eg: 1, 2 or 40 </span>
										</div>
									</div>
									
									
									<div class="form-actions">
										<button type="submit" class="btn purple">Save</button>
										<button type="button" class="btn">Cancel</button>
										<input type="hidden" name="action" size="5" value="edit1">
										<input type="hidden" name="sno" size="5" value="<?php echo $contentid;?>">
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
		echo "<script>location.href='photo-gallery.php';</script>";
	}
}
?>
