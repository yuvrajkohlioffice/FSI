<?php
	include_once "includes/constant.php";
	include_once "control.php";
	
	$pdate = date("Y-m-d");

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
	    $query="update link_page set status='inactive' where sno='$unid_id'";
	    $rs=mysql_query($query);
		$md5_hash = md5(rand(0,999)); 
		$security_code = substr($md5_hash, 16, 16); 
		$_SESSION['capture_code']=$security_code;	
    	if($rs)
    	{
    		echo "<script>location.href='pages.php?display=status'</script>";	
    	}
    	else
    	{
    		echo "<script>location.href='pages.php?error=incorrect'</script>";	
    	}
}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='pages.php?status=codeinvalid'</script>";
	}
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='inactive')
{
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{

    	$query="update link_page set status='active' where sno='$unid_id'";
    	$rs=mysql_query($query);
    	$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 16, 16); 
	$_SESSION['capture_code']=$security_code;
    	if($rs)
    	{
    		echo "<script>location.href='pages.php?display=update'</script>";	
    	}
    	else
    	{
    		echo "<script>location.href='pages.php?error=incorrect'</script>";	
    	}
}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='pages.php?status=codeinvalid'</script>";
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

        $crdate = date("Y-m-d");
        $sql2="select max(sno) as sno from link_page";
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
        
        $ran=rand(1,1000);
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
        
        //$desc=mysql_real_escape_string($_REQUEST['description']);
        $desc=$_REQUEST['description'];
        $count=0;
        
        if($_POST['sno']!="")
        {
        	$hid=filter_xss($_POST['sno']);
        }
        else
        {
        	$hid=filter_xss($_POST['heading']);
        }
        
        $chk=mysql_query("select sno from friendly_url where url='".filter_xss($_POST['friendly_url'])."'");
        if(mysql_num_rows($chk)==0)
        {
        	$seo=mysql_query("insert into friendly_url set url='".filter_xss($_POST[friendly_url])."',type='".filter_xss($_POST[seotype])."', id='$hid'");
        	mysql_query($seo);
        }
        else
        {
        	$error="duplicate URL";
        }
        
        $totalarray = count( $_POST['packages'] );
        if( $totalarray > 0 )
        {
        	foreach( $_POST['packages'] as $packag )
        	{
        		$insert = "insert into display set packageid = '$packag', pageid = '$start',pagehead = '".filter_xss($_POST[typeval])."'";
        		mysql_query($insert);
        	}
        }
        $post_date=date("Y-m-d",strtotime($_POST['postdate']));
        
        $query="insert into link_page(roomid, postDate, display_page, gallery_page,product_category,sno,heading,page_heading,detail,friendly_url,show_mapping,map_code, package,package_page,status,crdate,banner,ipaddress,userid,pagehead, meta_title, meta_key, meta_desc, banner_heading, banner_teaser_text, display_form) values('".filter_xss($_POST[rooms_category])."', '$post_date','".filter_xss($_POST[display_page])."', '".filter_xss($_POST[gallery_status])."','".filter_xss($_POST[product_category])."', '$start','".filter_xss($_POST[sno])."','".filter_xss($_POST[txtheading])."','$desc','".filter_xss($_POST[friendly_url])."', '".filter_xss($_POST[show_mapping])."','".filter_xss($_POST[map_code])."','$pack','".filter_xss($_POST[main_page])."','active','$pdate','$fname','$_SERVER[REMOTE_ADDR]','$_SESSION[uname]','".filter_xss($_POST[typeval])."', '".filter_xss($_POST[seotitle])."', '".filter_xss($_POST[seokeywords])."', '".filter_xss($_POST[seodescription])."', '".filter_xss($_POST[bannerheading])."', '".filter_xss($_POST[bannerteaser])."', '".filter_xss($_POST[display_form])."')";
        
        $totalarray = count( $_POST['tabltitle'] );
        $i = 0;
        if( $totalarray > 0 )
        {
        	foreach( $_POST['tabltitle'] as $tabdata )
        	{
        		$tabTitle = filter_xss($_POST['tabltitle'][$i]);
        		$tabDesc = filter_xss($_POST['tabdescription'][$i]);
        		$tabRegisterLink = filter_xss($_POST['taboption1'][$i]);
        		$tabDates = filter_xss($_POST['tabcoursedates'][$i]);
        		$tabSorder = filter_xss($_POST['tabsorder'][$i]);
        		$tabStatus = filter_xss($_POST['tabstatus'][$i]);
        		 
        		$tabInsert = "insert into  tab_content set pageid = '$start', title = '$tabTitle', detail = '$tabDesc', showreglink = '$tabRegisterLink', showCourse = '$tabDates', sorder = '$tabSorder', status = '$tabStatus', crdate = '$crdate', ipaddress = '$_SERVER[REMOTE_ADDR]', userid = '$_SESSION[userid]'";
        		mysql_query($tabInsert);
        		$i++;
        	}
        }
        
        
        
        $rs=mysql_query($query);
        $md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 16, 16); 
	$_SESSION['capture_code']=$security_code;
        mysql_query("update update_tab set crdate='$pdate'");
        
     
        
        	if($rs)
        	{
        		echo "<script>location.href='pages.php?display=add'</script>";
        	}
        	else
        	{
        		echo "<script>location.href='pages.php?error=incorrect'</script>";
        	}
}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='pages.php?status=codeinvalid'</script>";
	}
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='delete_heading')
{
	
	$capture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_SESSION['capture_code']));
	$postcapture=preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['log']));
	$unid_id = preg_replace('/[^0-9]/', '', trim($_GET['sno']));

	if($capture==$postcapture && $capture!="" && $postcapture!="")
	{
    	$query="delete from link_page where sno='$unid_id'";
    	$rs=mysql_query($query);
    	$md5_hash = md5(rand(0,999)); 
		$security_code = substr($md5_hash, 16, 16); 
		$_SESSION['capture_code']=$security_code;
    	if($rs)
    	{
    		echo "<script>location.href='pages.php?display=delete'</script>";
    	}
    	else
    	{
    		echo "<script>location.href='pages.php?error=incorrect'</script>";
    	}
}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='pages.php?status=codeinvalid'</script>";
	}
}

if($_GET['action']=='edit_heading')
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

    	$sql1="select * from link_page where sno='$unid_id'";
    	$result1=mysql_query($sql1);
    	$row1=mysql_fetch_array($result1);
    	
    	$ran=rand(1,1000);
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
    	//$desc=mysql_real_escape_string($_REQUEST['description']);
    	$desc=$_REQUEST['description'];
    
    	if($_POST['sno1']!="")
    	{
    		$hid=filter_xss($_POST['sno1']);
    	}
    	else
    	{
    		$hid=filter_xss($_POST['heading']);
    	}
    	//*********************************************************************************************
    	$chk=mysql_query("select sno from friendly_url where url='$_POST[friendly_url]'");
    	if(mysql_num_rows($chk) == 0)
    	{
    		$seo=mysql_query("insert into friendly_url set url='".filter_xss($_POST[friendly_url])."',type='".filter_xss($_POST[seotype])."', id='$hid'");
    		mysql_query($seo);
    	}
    	else
    	{
    		$seo=mysql_query("update friendly_url set url='".filter_xss($_POST[friendly_url])."',type='".filter_xss($_POST[seotype])."' where id='$hid' and type='$_POST[seotype]'");
    		mysql_query($seo);
    	}
    	
    	$totalarray=count($_POST['packages']);
    	if($totalarray>0)
    	{
    		mysql_query("delete from display where pageid='".filter_xss($_POST[sno])."'");
    		foreach($_POST['packages'] as $packag)
    		{
    			$insert="insert into display set packageid='$packag', pageid='".filter_xss($_POST[sno])."',pagehead='".filter_xss($_POST[typeval])."'";
    			mysql_query($insert);
    		}
    	}
    
    $post_date=date("Y-m-d",strtotime($_POST['postdate']));

    	$query = "UPDATE `link_page` SET roomid = '0', postDate = '$post_date', display_page = '" . filter_xss($_POST[display_page]) . "', gallery_page = '".filter_xss($_POST[gallery_status])."', product_category = '0', banner_heading = '".filter_xss($_POST[bannerheading])."' , banner_teaser_text = '".filter_xss($_POST[bannerteaser])."', heading='".filter_xss($_POST[sno1])."',page_heading='".filter_xss($_POST[page_heading])."',package_page='".filter_xss($_POST[main_page])."',show_mapping='".filter_xss($_POST[show_mapping])."',map_code = '".filter_xss($_POST[map_code])."', friendly_url='".filter_xss($_POST[friendly_url])."', detail='$desc', pagehead='".filter_xss($_POST[typeval])."', display_form = '".filter_xss($_POST[display_form])."'";
    
    	if($fname)
    	{
    		$query.=", banner='$fname'";
    	}
    	
    	$query.=", ipaddress=' $_SERVER[REMOTE_ADDR]',modifydate='$pdate',modifyby='$_SESSION[uname]', meta_title = '".filter_xss($_POST[seotitle])."', meta_key = '".filter_xss($_POST[seokeywords])."', meta_desc =  '".filter_xss($_POST[seodescription])."' where sno='$unid_id'";


    	$rs=mysql_query($query);
    	$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 16, 16); 
	$_SESSION['capture_code']=$security_code;
    	$totalarray = count( $_POST['tabltitle'] );
    	$i = 0;
    	if( $totalarray > 0 )
    	{
    		mysql_query("delete from tab_content where pageid='$unid_id'");
    
    		foreach( $_POST['tabltitle'] as $tabdata )
    		{
    			$tabTitle = filter_xss($_POST['tabltitle'][$i]);
    			$tabDesc = filter_xss($_POST['tabdescription'][$i]);
    			$tabRegisterLink = filter_xss($_POST['taboption1'][$i]);
    			$tabDates = filter_xss($_POST['tabcoursedates'][$i]);
    			$tabSorder = filter_xss($_POST['tabsorder'][$i]);
    			$tabStatus = filter_xss($_POST['tabstatus'][$i]);
    			 
    			$tabInsert = "insert into tab_content set pageid = '$unid_id', title = '$tabTitle', detail = '$tabDesc', showreglink = '$tabRegisterLink', showCourse = '$tabDates', sorder = '$tabSorder', status = '$tabStatus', crdate = '$crdate', ipaddress = '$_SERVER[REMOTE_ADDR]', userid = '$_SESSION[userid]'";
    			mysql_query($tabInsert);
    			$i++;
    		}
    	}
    	mysql_query("update update_tab set crdate='$pdate'");
    	if($rs)
    	{
    		echo "<script>location.href='pages.php?display=update&page=$_POST[page]'</script>";
    	}
    	else
    	{
    		echo "<script>location.href='pages.php?error=incorrect&page=$_POST[page]'</script>";
    	}
	}
	else
	{
		echo "<p align='center'>Please Wait..</p>";
		echo "<script>location.href='pages.php?status=codeinvalid'</script>";
	}
}



function view()
{
	
	$tbl_name="link_page";		//your table name
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
	$targetpage = "pages.php"; 	//your file name  (the name of this file)
	$limit = 10; 
	if(isset($_GET['page'])	)							//how many items to show per page
		$page = $_GET['page'];
	else
		$page = 0;
	if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0
	/* Get data. */
	
	$sql = "select * from link_page order by sno desc LIMIT $start, $limit";
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
?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<?php include_once "head.php"; ?>
		<link rel="stylesheet" type="text/css" href="assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.css"/>
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
<body class="page-header-fixed">
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
							Website Content Management
							<small>Add/Edit Website Content</small>
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
							<li><a href="#">Website Page's</a></li>
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
							echo "<p><strong>URL Alias: ".$row_content['friendly_url']."</strong></p>";
							?></td>
											<td width="49">
											<?php
											if($row_content['banner']!='' && file_exists("../images/banner/".$row_content['banner']))
											{
											?>
											<a target="_blank" href="../images/banner/<?echo $row_content['banner']?>">
											<img border=0 src="images/down.jpg" title="<?echo $row_content['banner']?>" alt="View Banner"></a>
											<?
											}
											?>		
											</td>
											<td>
											<a href="pages.php?action=<?php echo $row_content['status']?>&sno=<?php echo $row_content['sno']?>&log=<?php echo $_SESSION['capture_code'];?>">
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
											<a href="pages.php?sno=<?php echo $row_content['sno'];?>&action=<?php echo 'edit_heading'?>&page=<?php if(isset($_GET['page'])) { echo $_GET['page']; } ?>&log=<?php echo $_SESSION['capture_code'];?>">
											<img border="0" src="images/edit.png" width="20" height="20" alt="Edit" name="Edit"></a></td>
											<td><input type="image" img border="0" src="images/delete.png" width="20" height="20" onClick="var a=confirm('Are You sure delete this record from database ?');if(a==true){location.href='pages.php?sno=<?php echo $row_content['sno']?>&action=<?php echo 'delete_heading'?>&log=<?php echo $_SESSION['capture_code'];?>';}" alt="Delete" name="delete"></td>
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
											
						if(ctype1=="m")
						{
							theform.seotype.value="page";
						}
						else if(ctype1=="s")
						{
							theform.seotype.value="subpage";
						}
						else if(ctype1=="b")
						{
							theform.seotype.value="bottom";
						}					
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
								<form action="pages.php?action=category" enctype="multipart/form-data" id="form_page" name="form_page" class="form-horizontal" method="post">
									<div class="control-group">
										<label class="control-label">Post Date</label>
										<div class="controls">
											<input class="m-wrap" size="16" type="text" name="postdate" autocomplete="off" value="" id="ui_date_picker_change_year_month"/>
										</div>
									</div>							
									<div class="control-group">
										<label class="control-label">Show Testimonials in Footer of this Page?<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="main_page" size="1">
											<option value="1">Yes</option>
											<option value="0" selected>No</option>											
											</select>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Show Gallery in this Page?<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="gallery_status" size="1">
											<option value="1">Yes</option>
											<option value="0" selected>No</option>											
											</select>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Select form to display in this Page<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="display_form" size="1">
											<option value="" selected>-- Select --</option>											
											<option value="reservation">Registration Form</option>
											<option value="feedback">Feedback Form</option>											
											<option value="eventhost">Host an Event</option>	
											<option value="gallery">Photo Gallery</option>										
											</select>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Select Page Layout<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="display_page" size="1">
											<option value="" selected>-- Select --</option>											
											<option value="standard">Standard Page</option>
											<option value="contact">Contact Page</option>
											<option value="room">Rooms Page</option>																						
											</select>
										</div>
									</div>	
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
											
											<select class="span6 m-wrap" name="heading" onChange="valselect(this.value,form_page);" size="1">
												<option value="">Select...</option>
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

<optgroup value="-1" STYLE="BACKGROUND:#D0E0F1;COLOR:#ff3300" label="Quick Navigation Menu"></optgroup>

<?php
while($hea3=mysql_fetch_array($head3))
{
?>
<option value="<?echo $hea3['sno'].'q'?>"><?echo $hea3['name']?></option>
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

<!--optgroup label = ""-->
<?php
while($hea5=mysql_fetch_array($head5))
{
?>
<option value="<?echo $hea5['sno'].'b'?>"><?echo $hea5['name']?></option>
<?php
}
?>
<!--/optgroup-->
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
										<label class="control-label">Page Heading<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="txtheading" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>	
									<div class="control-group">
										<label class="control-label">SEO Title<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 m-wrap" id="em1" name="seotitle" rows="6" data-error-container="#editor2_error"></textarea>
										</div>
									</div>	
									<div class="control-group">
										<label class="control-label">SEO Keywords<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 m-wrap" id="em1" name="seokeywords" rows="6" data-error-container="#editor2_error"></textarea>														</div>
									</div>	
									<div class="control-group">
										<label class="control-label">SEO Description<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 m-wrap" id="em1" name="seodescription" rows="6" data-error-container="#editor2_error"></textarea>													</div>
									</div>								
									<div class="control-group">
										<label class="control-label">Show Google Map?<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="show_mapping" onChange="show_maps(this.value);" size="1">
											<option value="1">Yes</option>
											<option value="0" selected>No</option>											
											</select>
										</div>
									</div>
									<div class="control-group" id="google_map_code">
										<label class="control-label">Enter Google Map Code<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 m-wrap" id="em1" name="map_code" rows="6" data-error-container="#editor2_error"></textarea>
											<span class="help-block">Note: Do not Add Iframe Tag. Enter Only Iframe Source Code</span>																		</div>
									</div>
									<div class="control-group">
										<label class="control-label">Upload Banner&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="file" name="txtbanner" size="10" style="font-family: Verdana; font-size: 9pt">
											<span class="help-block">e.g: only jpg,png,gif are allowed - optional field</span>
										</div>
									</div>	
									<div class="control-group">
										<label class="control-label">Banner Heading&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="text" name="bannerheading" data-required="1" class="span6 m-wrap"/>											
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Banner Teaser Text&nbsp;&nbsp;</label>
										<div class="controls">
										<input type="text" name="bannerteaser" data-required="1" class="span6 m-wrap"/>			
										</div>
									</div>																
									
									<div class="control-group">
										<label class="control-label">Menu Slug / Friendly URL&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="text" name="friendly_url" data-required="1" class="span6 m-wrap"/>
											<span class="help-block">e.g: </span>
										</div>
									</div>	
									<div class="control-group">
										<label class="control-label">Page Description<span class="required">*</span></label>
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
										<input type="hidden" name="seotype" value="">
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
	<script><p class="text-center"><strong>Published by</strong><br>
			Forest Survey of India<br>
			(Ministry of Environment<br>
			Forest and Climate Change)<br>
			Kaulagarh road, P.O. IPE<br>
			Dehradun – 248195, Uttarakhand.<br>
			India<br>
			<strong>Phone :</strong> (91) 0135-2756139, 2754507, 2755037<br>
			<strong>Fax:</strong> (91) 0135-2759104, 2754507, 2755037
			</p>


<table class="table table-bordered">
	<tbody>
		<tr class="active">
			<td class="heading1" colspan="2" align="center">Contents</td>
		</tr>
		<tr>
			<td align="center"><i aria-hidden="true" class="fa fa-caret-right"></i></td>
			<td>
			<a target="_blank" href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-cover.pdf">Cover Page</a></td>
		</tr>
		
		<tr>
			<td align="center"><i aria-hidden="true" class="fa fa-caret-right"></i></td>
			<td><a target="_blank" href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-contents.pdf">
			Contents</a></td>
		</tr>
		
		
		<tr>
			<td align="center"><i aria-hidden="true" class="fa fa-caret-right"></i></td>
			<td><a target="_blank" href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-chapter11.pdf">
			Chapter 11 - Forest & Tree Resources in States and Union Territories</a></td>
		</tr>
		<tr>
			<td align="center"></td>
			<td>
			<table width="100%">
	<tr>
		<td>
		<ul>
			<li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-andhra-pradesh.pdf" target="_blank">
			11.1 Andhra Pradesh</a></li>
			<li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-arunachal-pradesh.pdf" target="_blank">
			11.2 Arunachal Pradesh</a></li>
			<li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-assam.pdf" target="_blank">
			11.3 Assam</a></li>
				
			<li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-bihar.pdf" target="_blank">
			11.4 Bihar</a></li>
			<li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-chhattisgarh.pdf" target="_blank">
			11.5 Chattisgarh</a></li>
			
			<li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-delhi.pdf" target="_blank">
			11.6 Delhi</a></li>
			
			<li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-goa.pdf" target="_blank">
			11.7 Goa</a></li>
			
			<li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-gujarat.pdf" target="_blank">
			11.8 Gujarat</a></li>
			
			<li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-haryana.pdf" target="_blank">
			11.9 Haryana</a></li>
			
			<li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-himachal-pradesh.pdf" target="_blank">
			11.10 Himachal Pradesh</a></li>
			
			<li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-jammu-kashmir.pdf" target="_blank">
			11. 11 Jammu and Kashmir (combined)</a></li>
			
			<li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-jharkhand.pdf" target="_blank">
			11.12 Jharkhand</a></li>
			
			<li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-karnataka.pdf" target="_blank">
			11.13 Karnataka</a></li>
			
			<li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-kerala.pdf" target="_blank">
			11.14 Kerala</a></li>
			
			
			<li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-madhya-pradesh.pdf" target="_blank">
			11.15 Madhya Pradesh</a></li>
			
	         <li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-maharashtra.pdf" target="_blank">
			11.16 Maharashtra</a></li>
			
			<li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-manipur.pdf" target="_blank">
			11.17 Manipur</a></li>
			
			<li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-meghalaya.pdf" target="_blank">
			11.18 Meghalaya</a></li>
			
			
		</ul>
		</td>
		<td>
		<ul>
<li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-mizoram.pdf" target="_blank">
			11.19 Mizoram</a></li>
			
			<li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-nagaland.pdf" target="_blank">
			11.20 Nagaland</a></li>
			<li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-odisha.pdf" target="_blank">
			11.21 Odisha</a></li>
			
			<li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-punjab.pdf" target="_blank">
			11.22 Punjab</a></li>
			
			<li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-rajasthan.pdf" target="_blank">
			11.23 Rajasthan</a></li>
			
			<li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-sikkim.pdf" target="_blank">
			11.24 Sikkim</a></li>
			
			<li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-tamilnadu.pdf" target="_blank">
			11.25 Tamil Nadu</a></li>
			
			<li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-telangana.pdf" target="_blank">
			11.26 Telangana</a></li>
			
			<li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-tripura.pdf" target="_blank">
			11.27 Tripura</a></li>
			
			
			<li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-uttar-pradesh.pdf" target="_blank">
			11.28 Uttar Pradesh</a></li>
			
			<li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-uttarakhand.pdf" target="_blank">
			11.29 Uttarakhand</a></li>
			
                       <li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-west-bengal.pdf" target="_blank">
			11.30 West Bengal</a></li>
			
			<li>
          	        <a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-andaman-nicobar-islands.pdf" target="_blank">
			11.31 Andaman & Nicobar Islands</a></li>
			
			<li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-chandigarh.pdf" target="_blank">
			11.32 Chandigarh</a></li>
			
			<li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-dadra-nagar-haveli.pdf" target="_blank">
			11.33 Dadar and Nagar Haveli</a></li>
			
			<li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-daman-diu.pdf" target="_blank">
			11.34 Daman and Diu</a></li>
			
			<li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-lakshadweep.pdf" target="_blank">
			11.35 Lakshdweep</a></li>
			
			<li>
			<a href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-puducherry.pdf" target="_blank">
			11. 36 Puducherry</a></li>

		
		</ul>
		</td>
	</tr>
</table>
			</td>
		</tr>


		
		
<tr>
			<td align="center"><i aria-hidden="true" class="fa fa-caret-right"></i></td>
			<td><a target="_blank" href="http://fsi.nic.in/isfr19/vol2/isfr-2019-vol-ii-back.pdf">
			Back Cover</a></td>
		</tr>

	</tbody>
</table>
		jQuery(document).ready(function() {       
		   // initiate layout and plugins
		   App.init();
		   UIJQueryUI.init();
		});
	</script>
<script type="text/javascript">
jQuery( document ).ready(function() {
	var i=2;
	jQuery(".addmore").on('click',function(){
	    var data="<tr><td><div class='control-group'><hr/></div></td></tr><tr><td><div class='control-group'><label class='control-label'>Tab Title "+i+"<span class='required'>*</span></label><div class='controls'><input type='text' name='tabltitle[]' data-required='1' class='span6 m-wrap'/><div id='editor_error'></div></div></div></td></tr><tr><td><div class='control-group'><label class='control-label'>Tab Description "+i+"<span class='required'>*</span></label><div class='controls'><textarea class='span12 ckeditor m-wrap' id='editor"+i+"' name='tabdescription[]' rows='6' data-error-container='#editor3_error'></textarea><div id='editor2_error'></div></div></div></td></tr><tr><td><div class='control-group'><label class='control-label'>Show Choose your Course andRegister Now? "+i+"<span class='required'>*</span></label><div class='controls'><select class='span6 m-wrap' name='taboption1[]' size='1'><option value='' selected>-- Select --</option><option value='1'>Yes</option><option value='0'>No</option></select></div></div></td></tr><tr><td><div class='control-group'><labelclass='control-label'>Show Course Dates in this Tab? "+i+"<span class='required'>*</span></label><div class='controls'><select class='span6 m-wrap' name='tabcoursedates[]' size='1'><option value='' selected>-- Select --</option><option value='1'>Yes</option><option value='0'>No</option></select></div></div></div></td></tr><tr><td><div class='control-group'><label class='control-label'>Sorting Order "+i+"<span class='required'>*</span></label><div class='controls'><input type='text' name='tabsorder[]' data-required='1' class='span6 m-wrap'/></div></div></div></td></tr><tr><td><div class='control-group'><label class='control-label'>Tab Status "+i+"?<span class='required'>*</span></label><div class='controls'><select class='span6 m-wrap' name='tabstatus[]' size='1'><option value=''>-- Select --</option><option value='1' selected>Active</option><option value='0'>In-Active</option></select></div></div></div></td></tr>";

		jQuery('table.customizeTable').append(data);		
		CKEDITOR.replace('editor'+i);
		i++;
	});
	
	$(".delete").on('click', function() {
		if($("table.customizeTable tr").length != 2)
        {
			$('.case:checkbox:checked').parents("tr").remove();
		}
		else
		{
			alert("You cannot delete first row");
		}
	});
});
	
	function select_all() {
		$('input[class=case]:checkbox').each(function(){ 
			if($('input[class=check_all]:checkbox:checked').length == 0){ 
				$(this).prop("checked", false); 
			} else {
				$(this).prop("checked", true); 
			} 
		});
	}
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
		$query=mysql_query("select * from link_page where sno='$contentid'");
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
			$pagename="select menu from bottom_menu where sno='$row_content[heading]'";
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
?><!DOCTYPE html><html lang="en">
<!-- BEGIN HEAD -->
<head>
	<meta charset="utf-8" />
	<?php
		include_once "head.php";
	?>
		<link rel="stylesheet" type="text/css" href="assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.css"/>
	<link rel="stylesheet" type="text/css" href="css/style.css" />

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
<body class="page-header-fixed">
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
							Website Content Management
							<small>Add Website Content</small>
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="mainmenu.php">Home</a> 
								<span class="icon-angle-right"></span>
							</li>
							<li>
								<a href="pages.php">Pages</a>
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
						if(ctype1=="m")
						{
							theform.seotype.value="page";
						}
						else if(ctype1=="s")
						{
							theform.seotype.value="subpage";
						}
						else if(ctype1=="b")
						{
							theform.seotype.value="bottom";
						}
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
								<form action="pages.php" id="form_edit_page" name="form_edit_page" class="form-horizontal" enctype="multipart/form-data" method="post">
									<div class="control-group">
										<label class="control-label">Post Date</label>
										<div class="controls">
											<input class="m-wrap" size="16" type="text" name="postdate" autocomplete="off" value="<?php echo date('d-M-Y',strtotime($row_content['postDate']));?>" id="ui_date_picker_change_year_month"/>
										</div>
									</div>
									

									<div class="control-group">
										<label class="control-label">Show Testimonials in Footer of this Page?<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="main_page" size="1">
											<option value="1" <?php if($row_content['package_page']==1) { echo 'selected';}?>>Yes</option>
											<option value="0" <?php if($row_content['package_page']==0) { echo 'selected';}?>>No</option>											
											</select>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Show Gallery in this Page?<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="gallery_status" size="1">
											<option value="1" <?php if($row_content['gallery_page']==1) { echo 'selected';}?>>Yes</option>
											<option value="0" <?php if($row_content['gallery_page']==0) { echo 'selected';}?>>No</option>											
											</select>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Select form to display in this Page<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="display_form" size="1">
											<option value="" <?php if($row_content['display_form'] == "" ) { echo 'selected';}?>>-- Select --</option>											
											<option value="reservation" <?php if($row_content['display_form'] == "reservation") { echo 'selected';}?>>Reservation Form</option>
											<option value="feedback" <?php if($row_content['display_form'] == "feedback" ) { echo 'selected';}?>>Feedback Form</option>											
											<option value="eventhost" <?php if($row_content['display_form'] == "eventhost" ) { echo 'selected';}?>>Host an Event</option>											<option value="gallery" <?php if($row_content['display_form'] == "gallery" ) { echo 'selected';}?>>Photo Gallery</option>
											</select>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Select Page Layout<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="display_page" size="1">
											<option value="" <?php if($row_content['display_page'] == "reservation") { echo 'selected';}?>>-- Select --</option>											
											<option value="standard" <?php if($row_content['display_page'] == "standard") { echo 'selected';}?>>Standard Page</option>
											<option value="contact" <?php if($row_content['display_page'] == "contact") { echo 'selected';}?>>Contact Page</option>																										<option value="room" <?php if($row_content['display_page'] == "room") { echo 'selected';}?>>Rooms Page</option>																						
											</select>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Select Page to be Linked ( Menu Name )<span class="required">*</span></label>
										<div class="controls">
											<?php

											$main=mysql_query("select distinct(name),sno from heading where status='active' order by position");
											
											$head=mysql_query("select distinct(subhead),sno,heading from sub_heading where status='active' and pagetype!='t' order by heading");
											
											$head1=mysql_query("select distinct(subhead),sno,heading,mainhead from sub_sub_heading where status='active' order by mainhead");
											
											$head2=mysql_query("select * from sub_sub_sub_heading where status='active' order by mainhead");
											
											$head3=mysql_query("select * from quick_menu where status='active' order by position");
											
											//$head4=mysql_query("select * from top_menu where status='active' order by position");
											
											$head6=mysql_query("select distinct(subhead),sno from sub_heading where status='active' and pagetype='t' order by position");
											
											$head5=mysql_query("select * from bottom_menu where status='active' order by position");
											
											$head7=mysql_query("select * from middle_menu where status='active' order by position");
											
											$head8=mysql_query("select distinct(subcate),parentid from programs where status='active' and ptype='main' order by position");
											
											$head9=mysql_query("select * from nestedsub_heading where status='active' order by mainhead");
											
											$head10=mysql_query("select * from top_quick_menu where status='active' order by name");
											?>
											
											<select size="1" name="menu_selection" onChange="valselect(this.value,form_edit_page);">
<option SELECTED value="<?php echo $row_content['heading']?>"><?php echo $rowpage[0]?></option>

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
<optgroup value="-1" STYLE="BACKGROUND:#D0E0F1;COLOR:#ff3300" label="Quick Navigation Menu"></optgroup>

<?
while($hea3=mysql_fetch_array($head3))
{
?>
<option value="<?echo $hea3['sno'].'q'?>"><?echo $hea3['name']?></option>
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
										<label class="control-label">Page Heading<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="page_heading" value="<?php echo $row_content['page_heading'];?>" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>			
									<div class="control-group">
										<label class="control-label">SEO Title<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 m-wrap" id="em1" name="seotitle" rows="6" data-error-container="#editor2_error"><?php echo $row_content['meta_title'];?></textarea>
										</div>
									</div>	
									<div class="control-group">
										<label class="control-label">SEO Keywords<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 m-wrap" id="em1" name="seokeywords" rows="6" data-error-container="#editor2_error"><?php echo $row_content['meta_key'];?></textarea>														</div>
									</div>	
									<div class="control-group">
										<label class="control-label">SEO Description<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 m-wrap" id="em1" name="seodescription" rows="6" data-error-container="#editor2_error"><?php echo $row_content['meta_desc'];?></textarea>													</div>
									</div>					
									<div class="control-group">
										<label class="control-label">Show Google Map?<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="show_mapping" onChange="show_maps(this.value);" size="1">
											<option value="1" <?php if($row_content['show_mapping']==1) { echo 'selected';}?>>Yes</option>
											<option value="0" <?php if($row_content['show_mapping']==0) { echo 'selected';}?>>No</option>											
											</select>
										</div>
									</div>
									<div class="control-group" id="google_map_code">
										<label class="control-label">Enter Google Map Code<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 m-wrap" id="em1" name="map_code" rows="6" data-error-container="#editor2_error"><?php echo $row_content['map_code'];?></textarea>
											<span class="help-block">Note: Do not Add Iframe Tag. Enter Only Iframe Source Code</span>																		</div>
									</div>
									<div class="control-group">
										<label class="control-label">Upload Banner&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="file" name="txtbanner" size="10" style="font-family: Verdana; font-size: 9pt">
																						
											<?php
											if($row_content['banner']!='' && file_exists("../images/banner/".$row_content['banner']))
											{
											?>
											<a target="_blank" href="../images/banner/<?php echo $row_content['banner']?>">
											<img border=0 src="images/down.jpg" title="<?php echo $row_content['banner']?>"></a>&nbsp;&nbsp;&nbsp;&nbsp;
												
											<a href="link_page.php?sno=<?php echo $row_content[sno]?>&action=remove_banner">
											
											<input type="image" img border="0" src="images/home1.jpg" width="20" title="Click here to remove banner" height="20" onClick="var a=confirm('Are You sure delete you want to remove this banner ?');if(a==true){location.href='link_page.php?sno=<?php echo $row_content[sno]?>&action=remove_banner';}else{ return false;}" alt="Delete" name="delete"></a>
											<?php
											}
											?>

											<span class="help-block">e.g: only jpg,png,gif are allowed - optional field</span>
										</div>
									</div>	
									<div class="control-group">
										<label class="control-label">Banner Heading&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="text" name="bannerheading" value="<?php echo $row_content['banner_heading'];?>" data-required="1" class="span6 m-wrap"/>											
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Banner Teaser Text&nbsp;&nbsp;</label>
										<div class="controls">
										<input type="text" name="bannerteaser" value="<?php echo $row_content['banner_teaser_text'];?>" data-required="1" class="span6 m-wrap"/>			
										</div>
									</div>																		
									<div class="control-group">
										<label class="control-label">Menu Slug / Friendly URL&nbsp;&nbsp;</label>
										<div class="controls">
											<input type="text" name="friendly_url" value="<?php echo $row_content['friendly_url'];?>" data-required="1" class="span6 m-wrap"/>
											<span class="help-block">e.g: </span>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Page Description<span class="required">*</span></label>
										<div class="controls">
											<textarea class="span12 ckeditor m-wrap" name="description" rows="6" data-error-container="#editor2_error"><?php echo $row_content['detail'];?></textarea>
											<div id="editor2_error"></div>
										</div>
									</div>
																		
									<?php
			                        $row_seo=mysql_fetch_array(mysql_query("select type from friendly_url where url='$row_content[friendly_url]'"));
			                        if($row_seo['type']!="")
			                        {
			                        	$seotype = $row_seo['type'];
			                        }
			                        else
			                        {			                       		
			                        	$seotype = "page";
			                        }
			                        ?>
									<div class="form-actions">
										<button type="submit" class="btn purple">Save</button>
										<button type="button" class="btn">Cancel</button>
										<input type="hidden" name="action" size="20" value="edit1">
										<input type="hidden" name="sno" size="20" value="<?php echo $contentid; ?>">
										<input type="hidden" name="sno1" value="<?php echo $row_content['heading'];?>">
										<input type="hidden" name="typeval" value="<?php echo $row_content['pagehead'];?>">
										<input type="hidden" name="page" value="<?php echo $_GET['page'];?>">
										<input type="hidden" value="<?php echo $_SESSION['capture_code'];?>" name="log">
										<input type="hidden" name="seotype" value="<?php echo $seotype; ?>">
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
<script type="text/javascript">
jQuery( document ).ready(function() {
	var i=2;
	jQuery(".addmore").on('click',function(){
	    var data="<tr><td><div class='control-group'><hr/></div></td></tr><tr><td><div class='control-group'><label class='control-label'>Tab Title "+i+"<span class='required'>*</span></label><div class='controls'><input type='text' name='tabltitle[]' data-required='1' class='span6 m-wrap'/><div id='editor_error'></div></div></div></td></tr><tr><td><div class='control-group'><label class='control-label'>Tab Description "+i+"<span class='required'>*</span></label><div class='controls'><textarea class='span12 ckeditor m-wrap' id='editor"+i+"' name='tabdescription[]' rows='6' data-error-container='#editor2_error'></textarea><div id='editor2_error'></div></div></div></td></tr><tr><td><div class='control-group'><label class='control-label'>Show Choose your Course andRegister Now? "+i+"<span class='required'>*</span></label><div class='controls'><select class='span6 m-wrap' name='taboption1[]' size='1'><option value='' selected>-- Select --</option><option value='1'>Yes</option><option value='0'>No</option></select></div></div></td></tr><tr><td><div class='control-group'><labelclass='control-label'>Show Course Dates in this Tab? "+i+"<span class='required'>*</span></label><div class='controls'><select class='span6 m-wrap' name='tabcoursedates[]' size='1'><option value='' selected>-- Select --</option><option value='1'>Yes</option><option value='0'>No</option></select></div></div></div></td></tr><tr><td><div class='control-group'><label class='control-label'>Sorting Order "+i+"<span class='required'>*</span></label><div class='controls'><input type='text' name='tabsorder[]' data-required='1' class='span6 m-wrap'/></div></div></div></td></tr><tr><td><div class='control-group'><label class='control-label'>Tab Status "+i+"?<span class='required'>*</span></label><div class='controls'><select class='span6 m-wrap' name='tabstatus[]' size='1'><option value=''>-- Select --</option><option value='1' selected>Active</option><option value='0'>In-Active</option></select></div></div></div></td></tr>";

		jQuery('table.customizeTable').append(data);
		CKEDITOR.replace('editor'+i);
		i++;
	});
	
	$(".delete").on('click', function() {
		if($("table.customizeTable tr").length != 2)
        {
			$('.case:checkbox:checked').parents("tr").remove();
		}
		else
		{
			alert("You cannot delete first row");
		}
	});
});
	
	function select_all() {
		$('input[class=case]:checkbox').each(function(){ 
			if($('input[class=check_all]:checkbox:checked').length == 0){ 
				$(this).prop("checked", false); 
			} else {
				$(this).prop("checked", true); 
			} 
		});
	}
</script>

</body>
<!-- END BODY -->
</html>
<?php
	}
	else
	{
		echo "<script>location.href='pages.php';</script>";
	}
}
?>
