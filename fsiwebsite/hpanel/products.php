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
	$query="update prod_products set status='inactive' where sno='$_GET[sno]'";
	$rs=mysql_query($query);
	
	if($rs)
	{
		echo "<script>location.href='products.php?display=status'</script>";	
	}
	else
	{
		echo "<script>location.href='products.php?error=incorrect'</script>";	
	}
}

if($_GET['action']=='inactive')
{

	$query="update prod_products set status='active' where sno='$_GET[sno]'";
	$rs=mysql_query($query);

	if($rs)
	{
		echo "<script>location.href='products.php?display=update'</script>";	
	}
	else
	{
		echo "<script>location.href='products.php?error=incorrect'</script>";	
	}
}

if($_GET['action']=='yes')
{
	$query="update prod_products set home='no' where sno='$_GET[sno]'";
	$rs=mysql_query($query);
	
	if($rs)
	{
		echo "<script>location.href='products.php?display=update'</script>";	
	}
	else
	{
		echo "<script>location.href='products.php?error=incorrect'</script>";	
	}
}

if($_GET['action']=='no')
{
	$query="update prod_products set home='yes' where sno='$_GET[sno]'";
	$rs=mysql_query($query);
	
	if($rs)
	{
		echo "<script>location.href='products.php?display=update'</script>";	
	}
	else
	{
		echo "<script>location.href='products.php?error=incorrect'</script>";	
	}	
}

if($_POST['flag']==1)
{

	$auto_id=mysql_query("select max(sno) as sno from prod_products");
	
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
	$size=$_FILES['p_thumb'][size];
	$thumb_name=$ran."_".$_FILES['p_thumb'][name];
	$source=$_FILES['p_thumb'][tmp_name];
	if($size<=0)
	{
		$thumb_name="";
	}

	$uploadedpath="../images/products/";
	$dest=$uploadedpath.$thumb_name;
	
	$size2=$_FILES['p_large'][size];
	$large_name=$ran."_".$_FILES['p_large'][name];
	$source2=$_FILES['p_large'][tmp_name];
	if($size2<=0)
	{
		$large_name="";
	}

	$dest2=$uploadedpath.$large_name;

	$desc=mysql_real_escape_string($_REQUEST['description']);
	//$desc=$_REQUEST['description'];
	$count=0;
	
	//*********************************************************************************************
	
	$chk=mysql_query("select sno from friendly_url where url='$_POST[friendly_url]'");
	if(mysql_num_rows($chk)==0)
	{
		$seo=mysql_query("insert into friendly_url set url='$_POST[friendly_url]',type='product', id='$start'");
		mysql_query($seo);
	}
	/*else
	{
		echo "<script>alert('URL Alias already Exists');</script>";
	}*/
	
	//*********************************************************************************************

$query="insert into prod_products set sno='$start',prod_category='$_POST[p_category]', prod_name='$_POST[p_name]', prod_status='$_POST[p_status]', prod_manf='$_POST[p_manufacturer]', prod_type='$_POST[p_type]', prod_quantity='$_POST[p_quantity]', prod_desc='$_POST[p_description]', prod_thumb='$thumb_name', prod_large='$large_name', prod_price='$_POST[p_price]', friendly_url='$_POST[friendlyurl]',teaser='$_POST[p_teaser]',prod_extra1='$_POST[p_extra1]',prod_extra2='$_POST[p_extra2]', prod_sorder='$_POST[p_sorder]', meta_title='$_POST[meta_title]', meta_keyword='$_POST[meta_keyword]', meta_desc='$_POST[meta_description]',  crdate='$crdate',create_by='$_SESSION[userid]', ip_address='$_SERVER[REMOTE_ADDR]'";

$rs=mysql_query($query) or die(mysql_error());

mysql_query("update update_tab set crdate='$pdate'");

if($size>0)
{
	move_uploaded_file($source,$dest);
}
if($size2>0)
{
	move_uploaded_file($source2,$dest2);
}
	if($rs)
	{
		echo "<script>location.href='products.php?display=add'</script>";
	}
	else
	{
		echo "<script>location.href='products.php?error=incorrect'</script>";
	}
}

if($_GET['action']=='delete_heading')
{
	$query="delete from prod_products where sno='$_GET[sno]'";
	$rs=mysql_query($query);
	
	if($rs)
	{
		echo "<script>location.href='products.php?display=delete'</script>";
	}
	else
	{
		echo "<script>location.href='products.php?error=incorrect'</script>";
	}
}

if($_GET['action']=='edit_heading')
{
	edit();
	exit;
}

if($_POST['action']=='edit1')
{

	$ran=rand(1,1000);
	$size=$_FILES['p_thumb'][size];
	$thumb_name=$ran."_".$_FILES['p_thumb'][name];
	$source=$_FILES['p_thumb'][tmp_name];
	if($size<=0)
	{
		$thumb_name="";
	}

	$uploadedpath="../images/products/";
	$dest=$uploadedpath.$thumb_name;
	
	$size2=$_FILES['p_large'][size];
	$large_name=$ran."_".$_FILES['p_large'][name];
	$source2=$_FILES['p_large'][tmp_name];
	if($size2<=0)
	{
		$large_name="";
	}
	
	$dest2=$uploadedpath.$large_name;

	$desc=mysql_real_escape_string($_REQUEST['description']);
	//$desc=$_REQUEST['description'];
	
	$query="update prod_products set prod_category='$_POST[p_category]', prod_name='$_POST[p_name]', prod_status='$_POST[p_status]', prod_manf='$_POST[p_manufacturer]', prod_type='$_POST[p_type]', prod_quantity='$_POST[p_quantity]', prod_desc='$_POST[p_description]', prod_price='$_POST[p_price]',prod_extra1='$_POST[p_extra1]',prod_extra2='$_POST[p_extra2]', friendly_url='$_POST[friendlyurl]', prod_sorder='$_POST[p_sorder]', meta_title='$_POST[meta_title]',teaser='$_POST[p_teaser]', meta_keyword='$_POST[meta_keyword]', meta_desc='$_POST[meta_description]'";
	
	if($size>0)
	{
		$query.=", prod_thumb='$thumb_name'";
		move_uploaded_file($source,$dest);	
	}
	if($size2>0)
	{
		$query.=", prod_large='$large_name'";
		move_uploaded_file($source2,$dest2);	
	}
	$query.=", modify_ip=' $_SERVER[REMOTE_ADDR]',modify_date='$pdate',modify_by='$_SESSION[uid]' where sno='$_POST[sno]'";
	$rs=mysql_query($query) or die(mysql_error());

	if($rs)
	{
		echo "<script>location.href='products.php?display=update&page=$_POST[page]'</script>";
	}
	else
	{
		echo "<script>location.href='products.php?error=incorrect&page=$_POST[page]'</script>";
	}
}


function view()
{
	
	$tbl_name="prod_products";		//your table name
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
	$targetpage = "products.php"; 	//your file name  (the name of this file)
	$limit = 25; 								//how many items to show per page
	$page = $_GET['page'];
	if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0
	/* Get data. */
	
	$sql = "select * from prod_products order by sno desc LIMIT $start, $limit";
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
							<small>Add/Edit Products</small>
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
							<li><a href="#">Manage Products</a></li>
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
											<th>Product Name</th>
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
											<td>
											<?php echo $row_content['prod_name']; ?>
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
											<a href="products.php?action=<?php echo $row_content['status']?>&sno=<?php echo $row_content['sno']?>">
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
											<a href="products.php?sno=<?php echo $row_content['sno'];?>&action=<?php echo 'edit_heading'?>&page=<?php echo $_GET['page'];?>">
											<img border="0" src="images/edit.png" width="20" height="20" alt="Edit" name="Edit"></a></td>
											<td><input type="image" img border="0" src="images/delete.png" width="20" height="20" onclick="var a=confirm('Are You sure delete this record from database ?');if(a==true){location.href='products.php?sno=<?php echo $row_content[sno]?>&action=<?php echo 'delete_heading'?>';}" alt="Delete" name="delete"></td>
											<td>
											<?php echo $row_content['meta_title']; ?>
											</td>
											<td>
											<?php echo $row_content['meta_keyword']; ?>
											</td>
											<td>
											<?php echo $row_content['meta_desc']; ?>
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
								<form action="products.php?action=category" enctype="multipart/form-data" id="form_page" name="form_page" class="form-horizontal" method="post">
									<div class="control-group">
										<label class="control-label">Select Parent Category<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="p_category" size="1">
												<option value="">Select...</option>
												<?php
													$res_main=mysql_query("select category,sno from prod_category where status='active'");
													while($row_main=mysql_fetch_array($res_main))
													{
												?>
													<option value="<?php echo $row_main['sno'];?>"><?php echo $row_main['category'];?></option>
												<?php
													}
												?>
											</select>
										</div>
									</div>									
									<div class="control-group">
										<label class="control-label">Product Name<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="p_name" data-required="1" class="span6 m-wrap" size="20"/>
										</div>
									</div>								
									<div class="control-group">
										<label class="control-label">Product Status<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="p_status">
												<option value="">Select...</option>
												<option value="instock">In Stock</option>
												<option value="outstock">Out-of Stock</option>
											</select>
										</div>
									</div>		
									<div class="control-group">
										<label class="control-label">Select Product Manufacturers<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="p_manufacturer" size="1">
												<option value="">Select...</option>
												<?php
													$res_main=mysql_query("select name,sno from prod_manufacturer where status='active'");
													while($row_main=mysql_fetch_array($res_main))
													{
												?>
													<option value="<?php echo $row_main['sno'];?>"><?php echo $row_main['name'];?></option>
												<?php
													}
												?>
											</select>
										</div>
									</div>								
									<div class="control-group">
										<label class="control-label">Product Type<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="p_type">
												<option value="">Select...</option>
												<option value="bestseller">Best Sellers</option>
												<option value="new">New Arrivals</option>
												<option value="sale">On Sale</option>
												<option value="feature">Featured</option>
											</select>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Product Quantity<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="p_quantity" data-required="1" class="span6 m-wrap" size="20"/>
										</div>
									</div>	
									<div class="control-group">
										<label class="control-label">Product Teaser Text<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 m-wrap" id="em1" name="p_teaser" rows="6" data-error-container="#editor2_error"></textarea>
											<div id="editor2_error"></div>
										</div>
									</div>									
									<div class="control-group">
										<label class="control-label">Product Description<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 ckeditor m-wrap" id="em1" name="p_description" rows="6" data-error-container="#editor2_error"></textarea>
											<div id="editor2_error"></div>
										</div>
									</div>	
									<div class="control-group">
										<label class="control-label">Product Extra Information I<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="p_extra1" data-required="1" class="span6 m-wrap" size="20"/>
										</div>
									</div>	
									<div class="control-group">
										<label class="control-label">Product Extra Information II<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="p_extra2" data-required="1" class="span6 m-wrap" size="20"/>
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
										<label class="control-label">Upload Product Large Image&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="file" name="p_large" size="10" style="font-family: Verdana; font-size: 9pt">
											<span class="help-block">e.g: only jpg,png,gif are allowed - optional field</span>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label">Product Price&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="text" name="p_price" data-required="1" class="span6 m-wrap"/>
											<span class="help-block">e.g: </span>
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
										<label class="control-label">Sorting Order<span class="required">*</span></label>
										<div class="controls">
											<input name="p_sorder" type="text" class="span6 m-wrap"/>
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
		$query=mysql_query("select * from prod_products where sno='$contentid'");
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
								<a href="products.php">Products & Orders</a>
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
								
								echo $row_content['prod_name'];
								
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
								<form action="products.php" enctype="multipart/form-data" id="form_page" name="editform_page" class="form-horizontal" method="post">
									<div class="control-group">
										<label class="control-label">Select Parent Category<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="p_category" size="1">
												<option value="">Select...</option>
												<?php
													$res_main=mysql_query("select category,sno from prod_category where status='active'");
													while($row_main=mysql_fetch_array($res_main))
													{
												?>
													<option value="<?php echo $row_main['sno'];?>" <?php if($row_content['prod_category']==$row_main['sno']) { echo 'selected'; } ?>><?php echo $row_main['category'];?></option>
												<?php
													}
												?>
											</select>
										</div>
									</div>									
									<div class="control-group">
										<label class="control-label">Product Name<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="p_name" data-required="1" value="<?php echo $row_content['prod_name'];?>" class="span6 m-wrap" size="20"/>
										</div>
									</div>								
									<div class="control-group">
										<label class="control-label">Product Status<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="p_status">
												<option value="">Select...</option>
												<option value="instock" <?php if($row_content['prod_status']=="instock") { echo 'selected'; } ?>>In Stock</option>
												<option value="outstock" <?php if($row_content['prod_status']=="outstock") { echo 'selected'; } ?>>Out-of Stock</option>
											</select>
										</div>
									</div>		
									<div class="control-group">
										<label class="control-label">Select Product Manufacturers<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="p_manufacturer" size="1">
												<option value="">Select...</option>
												<?php
													$res_main=mysql_query("select name,sno from prod_manufacturer where status='active'");
													while($row_main=mysql_fetch_array($res_main))
													{
												?>
													<option value="<?php echo $row_main['sno'];?>" <?php if($row_content['prod_manf']==$row_main['sno']) { echo 'selected'; } ?>><?php echo $row_main['name'];?></option>
												<?php
													}
												?>
											</select>
										</div>
									</div>								
									<div class="control-group">
										<label class="control-label">Product Type<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="p_type">
												<option value="">Select...</option>
												<option value="bestseller" <?php if($row_content['prod_type']=="bestseller") { echo 'selected'; } ?>>Best Sellers</option>
												<option value="new" <?php if($row_content['prod_type']=="new") { echo 'selected'; } ?>>New Arrivals</option>
												<option value="sale" <?php if($row_content['prod_type']=="sale") { echo 'selected'; } ?>>On Sale</option>
												<option value="feature" <?php if($row_content['prod_type']=="feature") { echo 'selected'; } ?>>Featured</option>
											</select>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Product Quantity<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="p_quantity" value="<?php echo $row_content['prod_quantity'];?>" data-required="1" class="span6 m-wrap" size="20"/>
										</div>
									</div>	
									<div class="control-group">
										<label class="control-label">Product Teaser Text<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 m-wrap" id="em1" name="p_teaser" rows="6" data-error-container="#editor2_error"><?php echo $row_content['teaser'];?></textarea>
											<div id="editor2_error"></div>
										</div>
									</div>									
									<div class="control-group">
										<label class="control-label">Product Description<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 ckeditor m-wrap" id="em1" name="p_description" rows="6" data-error-container="#editor2_error"><?php echo $row_content['prod_desc'];?></textarea>
											<div id="editor2_error"></div>
										</div>
									</div>	
									<div class="control-group">
										<label class="control-label">Product Extra Information I<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="p_extra1" data-required="1" value="<?php echo $row_content['prod_extra1'];?>" class="span6 m-wrap" size="20"/>
										</div>
									</div>	
									<div class="control-group">
										<label class="control-label">Product Extra Information II<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="p_extra2" data-required="1" value="<?php echo $row_content['prod_extra2'];?>" class="span6 m-wrap" size="20"/>
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
										<label class="control-label">Upload Product Large Image&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="file" name="p_large" size="10" style="font-family: Verdana; font-size: 9pt">
											<span class="help-block">e.g: only jpg,png,gif are allowed - optional field</span>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label">Product Price&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="text" name="p_price" value="<?php echo $row_content['prod_price'];?>" data-required="1" class="span6 m-wrap"/>
											<span class="help-block">e.g: </span>
										</div>
									</div>								
								
									<div class="control-group">
										<label class="control-label">Menu Slug / Friendly URL&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="text" name="friendlyurl" value="<?php echo $row_content['friendly_url'];?>" data-required="1" class="span6 m-wrap"/>
											<span class="help-block">e.g: </span>
										</div>
									</div>								
									<div class="control-group">
										<label class="control-label">Sorting Order<span class="required">*</span></label>
										<div class="controls">
											<input name="p_sorder" type="text" value="<?php echo $row_content['prod_sorder'];?>" class="span6 m-wrap"/>
											<span class="help-block">starts with 0. for eg: 1, 2 or 40 </span>
										</div>
									</div>
									<div class="control-group" style="background:#5C5C5C">
										<label class="control-label" style="color:#FFFFFF">SEO Terms</label>									
									</div>
									<div class="control-group">
										<label class="control-label">SEO Meta Title:<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 m-wrap" id="em1" name="meta_title" rows="6" data-error-container="#editor2_error"><?php echo $row_content['meta_title'];?></textarea>
											<div id="editor2_error"></div>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label">SEO Meta Keywords:<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 m-wrap" id="em1" name="meta_keyword" rows="6" data-error-container="#editor2_error" cols="20"><?php echo $row_content['meta_keyword'];?></textarea>
											<div id="editor2_error"></div>
										</div>
									</div>
									
									<div class="control-group">
										<label class="control-label">SEO Meta Description<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 m-wrap" id="em1" name="meta_description" rows="6" data-error-container="#editor2_error"><?php echo $row_content['meta_desc'];?></textarea>
											<div id="editor2_error"></div>
										</div>
									</div>
									
									<div class="form-actions">
										<button type="submit" class="btn purple">Save</button>
										<button type="button" class="btn">Cancel</button>
										<input type="hidden" name="action" size="5" value="edit1">
										<input type="hidden" name="sno" size="20" value="<?php echo $contentid; ?>">
										<input type="hidden" name="page" size="20" value="<?php echo $_GET['page']; ?>">
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
		echo "<script>location.href='products.php';</script>";
	}
}
?>