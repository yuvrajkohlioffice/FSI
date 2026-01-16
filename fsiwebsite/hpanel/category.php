<?php
	include_once "includes/constant.php";
	include_once "control.php";
	$crdate=date("Y-m-d");
	
if(!isset($_REQUEST['action']))
{
	$action='';
	view();
	exit;
}

if(!isset($flag))
{
	$flag='';
}

if($_GET['action']=='active')
{
	$query="update prod_category set status='inactive' where sno='$_GET[sno]'";
	$rs=mysql_query($query);
	
	if($rs)
	{
		echo "<script>location.href='category.php?display=status'</script>";	
	}
	else
	{
		echo "<script>location.href='category.php?error=incorrect'</script>";	
	}
}

if($_GET['action']=='inactive')
{

	$query="update prod_category set status='active' where sno='$_GET[sno]'";
	$rs=mysql_query($query);

	if($rs)
	{
		echo "<script>location.href='category.php?display=update'</script>";	
	}
	else
	{
		echo "<script>location.href='category.php?error=incorrect'</script>";	
	}
}

if($_GET['action']=='yes')
{
	$query="update prod_category set home='no' where sno='$_GET[sno]'";
	$rs=mysql_query($query);
	
	if($rs)
	{
		echo "<script>location.href='category.php?display=update'</script>";	
	}
	else
	{
		echo "<script>location.href='category.php?error=incorrect'</script>";	
	}
}

if($_GET['action']=='no')
{
	$query="update prod_category set home='yes' where sno='$_GET[sno]'";
	$rs=mysql_query($query);
	
	if($rs)
	{
		echo "<script>location.href='category.php?display=update'</script>";	
	}
	else
	{
		echo "<script>location.href='category.php?error=incorrect'</script>";	
	}	
}

if($_POST['flag']==1)
{

	$auto_id=mysql_query("select max(sno) as sno from prod_category");
	
	$row_id=mysql_fetch_array($auto_id);
	
	if($row_id['sno']=="")
	{
		$start=1;
	}
	else
	{
		$start=$row_id['sno']+1;
	}
	
	$ran=rand(1,1000);
	$size=$_FILES['txtbanner'][size];
	$fname=$ran."_".$_FILES['txtbanner'][name];
	$source=$_FILES['txtbanner'][tmp_name];
	if($size<=0)
	{
		$fname="";
	}

	$uploadedpath="../images/products/category/";
	$dest=$uploadedpath.$fname;
	
	$size1=$_FILES['p_thumb'][size];
	$thumb_name=$ran."_thumb_".$_FILES['p_thumb'][name];
	$source1=$_FILES['p_thumb'][tmp_name];
	if($size1<=0)
	{
		$thumb_name="";
	}

	$uploadedpath1="../images/products/category/";
	$dest1=$uploadedpath1.$thumb_name;

	$desc=mysql_real_escape_string($_REQUEST['description']);
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

$query="insert into prod_category set sno='$start' ,category = '$_POST[name]' , description = '$desc', friendly_url='$_POST[friendlyurl]', products_extra1='$_POST[meta_title]', products_extra2='$_POST[meta_keyword]', products_extra3='$_POST[meta_description]',  status='active', sorder='$_POST[txtposition]', banner='$fname',thumb_image='$thumb_name', crdate='$crdate',createby='$_SESSION[userid]', ip_address='$_SERVER[REMOTE_ADDR]'";

$rs=mysql_query($query) or die(mysql_error());

mysql_query("update update_tab set crdate='$pdate'");

if($size>0)
{
	move_uploaded_file($source,$dest);
}
if($size1>0)
{
	move_uploaded_file($source1,$dest1);
}


	if($rs)
	{
		echo "<script>location.href='category.php?display=add'</script>";
	}
	else
	{
		echo "<script>location.href='category.php?error=incorrect'</script>";
	}
}

if($_GET['action']=='delete_heading')
{
	$query="delete from prod_category where sno='$_GET[sno]'";
	$rs=mysql_query($query);
	
	if($rs)
	{
		echo "<script>location.href='category.php?display=delete'</script>";
	}
	else
	{
		echo "<script>location.href='category.php?error=incorrect'</script>";
	}
}

if($_GET['action']=='edit_heading')
{
	edit();
	exit;
}

if($_POST['action']=='edit1')
{

	$sql1="select * from prod_category where sno='$_POST[sno]'";
	$result1=mysql_query($sql1) or die(mysql_error());
	$row1=mysql_fetch_array($result1) or die(mysql_error());
	
	$ran=rand(1,1000);
	
	$size=$_FILES['txtbanner'][size];
	$fname=$ran."_".$_FILES['txtbanner'][name];
	$source=$_FILES['txtbanner'][tmp_name];
	
	$uploadedpath="../images/products/category/";
	$dest=$uploadedpath.$fname;
	
	$size1=$_FILES['p_thumb'][size];
	$thumb_name=$ran."_thumb_".$_FILES['p_thumb'][name];
	$source1=$_FILES['p_thumb'][tmp_name];
	if($size1<=0)
	{
		$thumb_name="";
	}

	$uploadedpath1="../images/products/category/";
	$dest1=$uploadedpath1.$thumb_name;
	
	$desc=mysql_real_escape_string($_REQUEST['description']);
	//$desc=$_REQUEST['description'];
	
	$query="update prod_category set category = '$_POST[name]' , description = '$desc', friendly_url='$_POST[friendlyurl]', products_extra1='$_POST[meta_title]', products_extra2='$_POST[meta_keyword]', products_extra3='$_POST[meta_description]',  status='active', sorder='$_POST[txtposition]'";

	if($size>0)
	{
		$query.=", banner='$fname'";
		move_uploaded_file($source,$dest);	
	}
	if($size1>0)
	{
		$query.=", thumb_image='$thumb_name'";
		move_uploaded_file($source1,$dest1);	
	}
	$query.=", modify_ip=' $_SERVER[REMOTE_ADDR]',modify_date='$pdate',modify_by='$_SESSION[uid]' where sno='$_POST[sno]'";
	$rs=mysql_query($query);

	if($rs)
	{
		echo "<script>location.href='category.php?display=update'</script>";
	}
	else
	{
		echo "<script>location.href='category.php?error=incorrect'</script>";
	}
}


function view()
{
	
	$tbl_name="prod_category";		//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = 3;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	$query = "SELECT COUNT(*) as num FROM $tbl_name";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	//$total_pages=$max;
	/* Setup vars for query. */
	$targetpage = "category.php"; 	//your file name  (the name of this file)
	$limit = 10; 								//how many items to show per page
	$page = $_GET['page'];
	if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0
	/* Get data. */
	
	$sql = "select * from prod_category order by sno desc LIMIT $start, $limit";
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
							Products & Orders Management
							<small>Add/Edit Product Category</small>
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="mainmenu.php">Home</a> 
								<span class="icon-angle-right"></span>
							</li>
							<li>
								<a href="#">Products & Orders</a>
								<span class="icon-angle-right"></span>
							</li>
							<li><a href="#">Manage Category</a></li>
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
								<div class="caption"><i class="icon-cogs"></i>Product Category</div>
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
											<th>Friendly URL</th>
											<th width="49">Banner</th>
											<th>Status</th>
											<th colspan="2">Action</th>
											<th>SEO Title</th>
											<th>SEO Keywords</th>
											<th>SEO Description</th>
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
											<td><span class="badge badge-info"><?php echo mysql_num_rows(mysql_query("select sno from prod_products where prod_category='$row_content[sno]'")); ?></span> <?php echo $row_content['category']; ?></span>
											</td>
											<td>
											<?php echo $row_content['friendly_url']; ?>
											</td>
											<td width="49">
											<?php
											if($row_content['banner']!='' && file_exists("../images/products/category/".$row_content['banner']))
											{
											?>
											<a target="_blank" href="../images/products/category/<?php echo $row_content['banner']?>">
											<img border=0 src="images/down.jpg" title="<?php echo $row_content['banner']?>" alt="View Banner"></a>
											<?
											}
											?>		
											</td>
											<td>
											<a href="category.php?action=<?php echo $row_content['status']?>&sno=<?php echo $row_content['sno']?>">
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
											<a href="category.php?sno=<?php echo $row_content['sno'];?>&action=<?php echo 'edit_heading'?>">
											<img border="0" src="images/edit.png" width="20" height="20" alt="Edit" name="Edit"></a></td>
											<td><input type="image" img border="0" src="images/delete.png" width="20" height="20" onclick="var a=confirm('Are You sure delete this record from database ?');if(a==true){location.href='category.php?sno=<?php echo $row_content[sno]?>&action=<?php echo 'delete_heading'?>';}" alt="Delete" name="delete"></td>
											<td>
											<?php echo $row_content['products_extra1']; ?>
											</td>
											<td>
											<?php echo $row_content['products_extra2']; ?>
											</td>
											<td>
											<?php echo $row_content['products_extra3']; ?>
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
								<form action="category.php?action=category" enctype="multipart/form-data" id="form_page" name="form_page" class="form-horizontal" method="post">
																		
									<div class="control-group">
										<label class="control-label">Category Name<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="name" data-required="1" class="span6 m-wrap" size="20"/>
										</div>
									</div>	
									
									<div class="control-group">
										<label class="control-label">Upload Product Thumb Image&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="file" name="p_thumb" size="10" style="font-family: Verdana; font-size: 9pt">
											<span class="help-block">e.g: only jpg,png,gif are allowed - optional field</span>
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
									<div class="control-group" style="background:#5C5C5C">
										<label class="control-label" style="color:#FFFFFF">SEO Terms</label>									
									</div>
									<div class="control-group">
										<label class="control-label">SEO Meta Title:<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 m-wrap" id="em1" name="meta_title" rows="6" data-error-container="#editor2_error"></textarea>
											<div id="editor2_error"></div>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label">SEO Meta Keywords:<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 m-wrap" id="em1" name="meta_keyword" rows="6" data-error-container="#editor2_error" cols="20"></textarea>
											<div id="editor2_error"></div>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label">SEO Meta Description<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 m-wrap" id="em1" name="meta_description" rows="6" data-error-container="#editor2_error"></textarea>
											<div id="editor2_error"></div>
										</div>
									</div>
									
									<div class="form-actions">
										<button type="submit" class="btn purple">Save</button>
										<button type="button" class="btn">Cancel</button>
										<input type="hidden" name="flag" size="20" value="1">
										<input type="hidden" name="action" size="5" value="save">
									
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
		$query=mysql_query("select * from prod_category where sno='$contentid'");
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
							Products & Order Management
							<small>Edit Product Category</small>
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="mainmenu.php">Home</a> 
								<span class="icon-angle-right"></span>
							</li>
							<li>
								<a href="category.php">Products & Orders</a>
								<span class="icon-angle-right"></span>
							</li>
							<li><a href="#">Edit Product Category</a></li>
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
								<div class="caption"><i class="icon-reorder"></i>Edit Product Category - <b>"
								<?php 
								
								echo $row_content['category'];
								
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
								<form action="category.php?action=category" enctype="multipart/form-data" id="form_page" name="editform_page" class="form-horizontal" method="post">
																		
									<div class="control-group">
										<label class="control-label">Category Name<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="name" data-required="1" value="<?php echo $row_content['category'];?>"  class="span6 m-wrap" size="20"/>
										</div>
									</div>								
									
									<div class="control-group">
										<label class="control-label">Upload Category Banner&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="file" name="txtbanner" size="10" style="font-family: Verdana; font-size: 9pt">
											<?php
											if($row_content['banner']!='' && file_exists("../images/products/category/".$row_content['banner']))
											{
											?>
											<a target="_blank" href="../images/products/category/<?php echo $row_content['banner']?>">
											<img border=0 src="images/down.jpg" title="<?php echo $row_content['banner']?>"></a>
											<?php
											}
											?>
											<span class="help-block">e.g: only jpg,png,gif are allowed - optional field</span>
										</div>
									</div>																	
									<div class="control-group">
										<label class="control-label">Upload Product Thumb Image&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="file" name="p_thumb" size="10" style="font-family: Verdana; font-size: 9pt">
											<?php
											if($row_content['thumb_image']!='' && file_exists("../images/products/category/".$row_content['thumb_image']))
											{
											?>
											<a target="_blank" href="../images/products/category/<?php echo $row_content['thumb_image']?>">
											<img border=0 src="images/down.jpg" title="<?php echo $row_content['thumb_image']?>"></a>
											<?php
											}
											?><span class="help-block">e.g: only jpg,png,gif are allowed - optional field</span>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Menu Slug / Friendly URL&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="text" name="friendlyurl" value="<?php echo $row_content['friendly_url'];?>"  data-required="1" class="span6 m-wrap"/>
											<span class="help-block">e.g: </span>
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
									<div class="control-group" style="background:#5C5C5C">
										<label class="control-label" style="color:#FFFFFF">SEO Terms</label>									
									</div>
									<div class="control-group">
										<label class="control-label">SEO Meta Title:<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 m-wrap" id="em1" name="meta_title" rows="6" data-error-container="#editor2_error"><?php echo $row_content['products_extra1'];?></textarea>
											<div id="editor2_error"></div>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label">SEO Meta Keywords:<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 m-wrap" id="em1" name="meta_keyword" rows="6" data-error-container="#editor2_error" cols="20"><?php echo $row_content['products_extra2'];?></textarea>
											<div id="editor2_error"></div>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label">SEO Meta Description<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 m-wrap" id="em1" name="meta_description" rows="6" data-error-container="#editor2_error"><?php echo $row_content['products_extra3'];?></textarea>
											<div id="editor2_error"></div>
										</div>
									</div>
									
									<div class="form-actions">
										<button type="submit" class="btn purple">Save</button>
										<button type="button" class="btn">Cancel</button>
										<input type="hidden" name="action" size="5" value="edit1">
										<input type="hidden" name="sno" size="5" value="<?php echo $contentid;?>">
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
		echo "<script>location.href='category.php';</script>";
	}
}
?>