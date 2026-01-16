<?php
ob_start();
session_start();
error_reporting(0);
include_once "includes/classes.php";
$titlesub="";
$pageh = "";

$current_url = $common->get_current_url();

//*********************** URL REDIRECTION ***************************//
if(isset($_GET['pgID']) && !empty($_GET['pgID']) && $common->use_friendly_urls)
{

	$stringValue = preg_replace('/[^a-zA-Z0-9 \-_]/', '', trim($_GET['pgID']));
	$exp=explode("_",$stringValue);	
	if(!empty($exp[0]))
	{
		$category_id=$exp[0];
		
		if(isset( $_GET['ctype'] ) && $_GET['ctype']!="")
		{
		    $ctypeValue = preg_replace('/[^a-zA-Z0-9 \-_]/', '', trim($_GET['ctype']));
			$expsub = explode("_",$ctypeValue);
			$category_id = $expsub[1];
			$page_type = "subsubpage";	
		}		
		else if($exp[0]=="mn")
			$page_type="page";
		else if($exp[0]=="sb")
			$page_type="subpage";			
			
		$seo_title=mysql_fetch_array(mysql_query("select url from friendly_url where id='$category_id' and type='$page_type'"));
		if(empty($seo_title['url']))
		{
			if($page_type=="page")
				$seo_title=mysql_fetch_array(mysql_query("select name  from heading where status='active' and sno='$category_id'"));
			else if($page_type=="subpage")
				$seo_title=mysql_fetch_array(mysql_query("select subhead as name from sub_heading where status='active' and sno='$category_id'"));
			else if($page_type=="subsubpage")
				$seo_title=mysql_fetch_array(mysql_query("select subhead as name from sub_sub_heading where status='active' and sno='$category_id'"));	
		
			$friendly_url= $common->get_auto_friendly_url($seo_title['name']);
		}
		else
		{
			$friendly_url= $seo_title['url'];
		}
		//header("Location:$friendly_url");
	}
}

//***************************** URL REDIRECTION ENDS HERE **********************************//
if( $common->use_friendly_urls )
{
	$seo_title=mysql_query("select url,id,type from friendly_url where url='$category_id'");
	if(mysql_num_rows($seo_title)>0)
	{
		$page_id=mysql_fetch_array($seo_title);	
		$page_type =$page_id['type'];
	}
}
//***************************** SEO TERMS INITIALIZATION STARTS HERE **********************************//
	
	$meta_title="Welcome Forest Survey of India";
	$meta_keyword="";
	$meta_desc="";
	
//***************************** SEO TERMS INITIALIZATION STARTS ENDS HERE **********************************//

$titlesub="";
$isYearWise = 0;
$PageType = "";
$yearWisePageId = "";
$breadpageType = "";


// var_dump($page_id['id']);
if($category_id == "privacy-policy"){
	$page_type ="subpage";
	$page_id['id'] = 151;
}

if($category_id == "content-contribution-moderation-approval-policy"){
		$page_id['id'] = 157;
}

if(isset($_GET['pgID']) && $_GET['pgID']!="" || $page_type =="page"  || $page_type =="subpage")
{
	//  mn=" Main Menu "  sb=SUB MENU sub= sub sub menu tb=top bottom menu bo= bottom menu/
	$imgpath="uploads/images/banner/";
	$stringValue = preg_replace('/[^a-zA-Z0-9 \-_]/', '', trim($_GET['pgID']));
	$exp=explode("_",$stringValue);
	$allid=$exp[0];
	// echo($_GET['pgID']);	
	
	if($exp[0]=="mn" || $page_type=="page")
	{
		$query="select * from link_page where (heading='$a	llid' or friendly_url='$category_id') and pagehead='m' and status='active'";
		$head="select name, sno, yearwisedata from heading where (sno='$allid' or sno='$page_id[id]') and status='active'";	
		$pageh="i";
		$PageType = "m";
		$breadpageType = "main";
	}
	else if($exp[0]=="about")
	{
		$query="select * from welcome";
		$head="select heading from welcome";
	}
	else if($exp[0]=="abou")
	{
		$query="select * from welcome_sec";
		$head="select heading from welcome_sec";
	}
	if($exp[0]=="sb" || $page_type=="subpage")
	{
		$query="select * from link_page where (heading='$allid' or friendly_url='$category_id') and pagehead='s' and status='active'";
		$head="select subhead, heading, sno, yearwisedata from sub_heading where (sno='$allid' or sno='$page_id[id]') and status='active'";
		$pageh="i";
		$PageType = "s";	
		$breadpageType = "sub";
	}
	if($exp[0]=="sub")
	{
		$query="select * from link_page where heading='$allid' and pagehead='i' and status='active'";
		$head="select subhead,heading from sub_sub_heading where sno='$allid' and status='active'";
		$pageh="i";
		$breadpageType = "subsub";		
	}

	else if($exp[0]=="qu")
	{
		$query="select * from link_page where heading='$allid' and pagehead='q' and status='active'";
		$head="select name,sno from quick_menu where sno='$allid' and status='active'";
		$pageh="q";	
	}
	else if($exp[0]=="tp")
	{
		$query="select * from link_page where heading='$allid' and pagehead='k' and status='active'";
		$head="select name,sno from top_quick_menu where sno='$allid' and status='active'";
		$pageh="q";	
	}

	else if($exp[0]=="bo")
	{
		$query="select * from link_page where heading='$allid' and pagehead='b' and status='active'";
		$head="select name from bottom_menu where sno='$allid' and status='active'";		
	}
	
	else if($exp[0]=="photos")
	{
		$query="select * from photo_cate where status='active'";
		$title="Photo Gallery";
	}
	
	else if($exp[0]=="photo")
	{
		$head="select category from photo_cate where status='active' and parentid='$_GET[type]'";
		//$title="Photo Gallery";
	}
	if($exp[0]=="package" || $page_type=="package")
	{
		$query = "select * from package_master where ( sno = '$allid' or friendly_url = '$category_id' ) and status='1'";
		$head = "select package_name, sno from package_master where ( sno = '$allid' or sno = '$page_id[id]' ) and status = '1'";	
		$pageh="p";	
	}	

	if(isset($_GET['ctype']) && $_GET['ctype']!="" || $page_type == "subsubpage" )
	{
		$ctypevalue = preg_replace('/[^a-zA-Z0-9 \-_]/', '', trim($_GET['ctype']));
		$expsub=explode("_",$ctypevalue);
		$allidsub=$expsub[1];
	
		if($page_type == "subsubpage")
		{	
			$query="select * from link_page where ( heading='$allidsub' || friendly_url='$category_id') and pagehead='i' and status='active'";
			
			$head_sub="select subhead,heading from sub_sub_heading where (sno='$allidsub' || friendly_url='$category_id') and status='active'";			
			$row_headsub=mysql_fetch_array(mysql_query($head_sub));

		}
	}
        if(!empty($head))
        {
			$row_head=mysql_fetch_array(mysql_query($head));
			$title=$row_head[0];
			if( $exp[0]=="sb" || $page_type=="subpage" || $exp[0]=="mn" || $page_type=="page" )
			{
				$isYearWise = $row_head['yearwisedata'];
			}
			
			$yearWisePageId = $row_head['sno'];
			
        }
	
	if(isset($_GET['ctype']) && $_GET['ctype']!="")
	{
		//$title=$row_headsub[0];
		$titlesub=$row_headsub[0];
		$titlesub=$row_headsub[0];
	}
	if($query!="")
	{
		$row_details=mysql_fetch_array(mysql_query($query));
		$ext= substr($row_details['banner'],-3);
		$column="detail";
		$imgcolumn="banner";
		
		$_SESSION['banner'] = $row_details['banner'];
		
		$_SESSION['page_id'] = $row_details['pagehead'];
		
		$_SESSION['slider_page_id'] = $row_details['heading'];
		
		$imgpathp = "uploads/images/banner/";
		if($exp[0]=="photo")
		{
			$imgpathp="images/gallery_pic.jpg";
		}		
		if(!empty($row_details['meta_title']))
			$meta_title=$row_details['meta_title'];
			
		if(!empty($row_details['meta_key']))
			$meta_keyword=$row_details['meta_key'];
			
		if(!empty($row_details['meta_desc']))
			$meta_desc=$row_details['meta_desc'];
	}
}
else if(isset($_GET['prID']) && $_GET['prID']!="")
{
	$imgpath="programs/";
	$imgcolumn="image";
	$programID = preg_replace('/[^a-zA-Z0-9 \-_]/', '', trim($_GET['prID']));
	$exp=explode("_",$programID);
	$allid=$exp[0];

	$query="select * from programs where status='active' and parentid='$exp[0]'";
	$head="select subcate from programs where status='active' and parentid='$exp[0]'";
	
	//$row_head=mysql_fetch_array(mysql_query($head));
	$title=$row_head[0];

	$row_details=mysql_fetch_array(mysql_query($query));
	$ext= substr($row_details['image'],-3);
	$column="description";
$title=$row_details['pname'];
	//echo $exp[0];
}
else if(isset($_GET['newsID']) && $_GET['newsID']!='')
{
    $newsid = preg_replace('/[^a-zA-Z0-9 \-_]/', '', trim($_GET['newsID']));
//onmouseover="this.style.color='#000000'" onmouseout="this.style.color='#CCCCCC'"
$query="select * from news where ser='$newsid'";
$imgpath="news/";
$row_details=mysql_fetch_array(mysql_query($query));
$title=$row_details['title'];
// $title=1;

$attachment="news/".$row_details['extension'];
$ext= substr($row_details['image'],-3);
$column="description";
if($row_details['extension']!='' && file_exists("news/".$row_details['extension']))
{
	$link = "news/".$row_details['extension'];
	$target = "_blank";
}
$attach_post_meta = "<a href='$link' target='$target'> Click here to read more</a>";
	
}
else if(isset($_GET['q']) && $_GET['q']!="")
{
	$imgpath="promotional_offers/";
	$imgcolumn="image";
	$stringVal = preg_replace('/[^a-zA-Z0-9 \-_]/', '', trim($_GET['q']));
	$exp=explode("_",$stringVal);
	$allid=$exp[0];

	$query="select * from promotional_offers where status='active' and parentid='$exp[0]'";
	$head="select subcate from promotional_offers where status='active' and parentid='$exp[0]'";
	
	$row_head=mysql_fetch_array(mysql_query($head));
	$title=$row_head[0];

	$row_details=mysql_fetch_array(mysql_query($query));
	$ext= substr($row_details['image'],-3);
	$column="description";

}
else
{
	echo "<script>location.href='index.php'</script>";
}
if(!empty($row_details['page_heading']))
{
	$title =  $row_details['page_heading'];
	$meta_title= $row_details['meta_title'];
	$meta_keyword= $row_details['meta_key'];
	$meta_desc= $row_details['meta_desc'];

}
if(isset($_GET['ctype']) && !empty($_GET['ctype']) && !empty($row_details['page_heading']))
{
	$titlesub=$row_headsub[0];
}

// $meta_title = $common->site_name;

// $meta_desc = "";

// $meta_keywords = "";

// if(!empty($row_details['meta_title']))
// 	$meta_title = strip_tags($row_details['meta_title']);
// if(!empty($row_details['meta_key']))
// 	$meta_keywords = strip_tags($row_details['meta_key']);
// if(!empty($row_details['meta_desc']))
// 	$meta_desc = strip_tags($row_details['meta_desc']);	
		
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="iso-8859-1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo !empty($meta_title) ? $meta_title : "Welcome | Forest Survey of India"; ?></title>
	<?php
		if(!empty($meta_desc)){
	?>
	<meta name="description" content="<?php echo $meta_desc;?>">
	<?php
	}
	if(!empty($meta_keyword))
	{
	?>
	<meta name="keywords" content="<?php echo $meta_keyword	;?>">
	<?php
	}
	
	?>
	<meta name="author" content="Adxventure India, Dehradun">
	<?php
		$common->get_common_head();
	?>
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
		<div class="container-fluid">
			<div class="row important-links">				
				<div class="col-lg-3 col-md-12">    
					<a class="contact-button" href=""><div class="contact-us-button">Important Links</div>
					<i class="fa fa-arrow-circle-right"></i></a>
				</div>
				<div class="col-lg-9 col-md-12 pt">
					<?php
						$count=0;						
						$res_menu = mysql_query("select * from top_quick_menu where status='active' and websiteType = 'English' order by position,name limit 0,15");
						$total_fields = mysql_num_rows($res_menu);
						while($row_heading= mysql_fetch_array($res_menu))
						{
							$count++;
							$target="_self";
							$link="details.php?pgID=tp_".$row_heading['sno'];
							if($row_heading['otherurl']!="")
							{
								$target=$row_heading['target'];
								$link=$row_heading['otherurl'];
							}
							if( $common->use_friendly_urls && $row_heading['seo_url'] != "" )
							{						
								$target=$row_heading['target'];
								$link=$row_heading['seo_url'];
							}
							
							$active_link = 0;
							
					?>
						<a class="tt" href="<?php echo $link;?>" target="<?php echo $target;?>" title="<?php echo $row_heading['name'];?>"><?php echo $row_heading['name'];?></a>
					<?php
						}
					?>
				</div>
			</div>
		</div>
	</section> 
    <!-- /#promotional-text -->

	

	
<section id="landscaping-design-gardener">
		<div class="container">
			<div class="row">
                <?php
		if( $head )
		{
                $row_head=mysql_fetch_array(mysql_query($head));
				// var_dump($head);

            	$query_sub = mysql_query("select * from sub_heading where status='active' and heading='$row_head[heading]' order by position");
            	if( mysql_num_rows( $query_sub ) > 0 ) { ?>
				<!-- .sidebar -->
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div><img src="img/ff.jpg" alt=""></div>
					<div id="sp_vertical_megamenu" class="sp-vertical-megamenu clearfix">
                    <h2 class="cat-title" style="font-size: 20px;">
                    <?php	
                    $mainHeadName = mysql_fetch_array( mysql_query( "select name from heading where sno = '$row_head[heading]'"));
                    echo $mainHeadName['name'];
					?></h2>
                        <ul class="vf-megamenu clearfix megamenu-content">
                         <?php
                		    $row_head=mysql_fetch_array(mysql_query($head));
                			$query_sub = mysql_query("select * from sub_heading where status='active' and heading='$row_head[heading]' order by position");
                			while( $subHeadData = mysql_fetch_array( $query_sub)){
								if($subHeadData['otherurl']!="")
								{
									$target=$subHeadData['target'];
									$link=$subHeadData['otherurl'];
								}
								if( $common->use_friendly_urls && $subHeadData['seo_url'] != "" )
								{						
									$target=$subHeadData['target'];
									$link=$subHeadData['seo_url'];
								}
                			?>
                			<li class="spvmm-havechild vf-close"><i class="megamenu_i fa fa-tree"></i>
                                <a class="megamenu_a" href="<?php echo $link;?>" target="<?php echo $target;?>" title="<?php echo $subHeadData['subhead'];?>"><?php echo $subHeadData['subhead'];?></a>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
				</div> <!-- /.sidebar -->
			    <?php } } ?>
			
				<div <?php if( mysql_num_rows( $query_sub ) > 0 ) { ?>class="col-lg-9 col-md-9 col-sm-12 col-xs-12 shop-page-content"<?php } else { ?>class="col-lg-12 col-md-12 col-sm-12 col-xs-12 shop-page-content"<?php } ?>>
					
                    <div class="section-title-style-2">
						<h1><?php 
								if( $category_id == "gallery" )
								{
									$galleryCate = mysql_fetch_array( mysql_query( "select category,description from photo_cate where status = 'active' and parentid = '$_GET[id]'"));
									echo $galleryCate['category'];
								}
								else if( $row_details['banner_teaser_text'] != "")
									echo $row_details['banner_teaser_text'];
								else if(isset($titlesub) && $titlesub=="")
								{
									// echo 1;
									echo $title;
								}
								else if(isset($titlesub) && $titlesub!="")
								{
									// echo 2;
									echo $titlesub;
								}	
								else if(isset($exp[1]) && $exp[1]=="photo")
								{
									$category=mysql_fetch_array(mysql_query("select category,parentid from photo_cate where parentid='$_GET[type]' and status='active'"));
									echo " - ".$category['category'];
								}	
								else
								{
									echo "Page Not Found";
								}	
							?></h1>
							<p>
							<?php
							if( $category_id == "gallery" )
								{
									$galleryCate = mysql_fetch_array( mysql_query( "select description from photo_cate where status = 'active' and parentid = '$_GET[id]'"));
									echo "<br>".$galleryCate['description'];
								}
								?>
							</p>	
					</div>					
					<div class="row"><a name="maincontent"></a>
					    <div class="col-md-12">
                    	<?php
						if(isset($exp[1]) && $exp[1]=="photos")
						{								
						?>
							<div align="center">
									<table border="0" cellpadding="0" style="border-collapse: collapse" width="100%" bordercolor="#CCCCCC" id="table16">
										<tr>
								<?php			
								$res_photo=mysql_query($query);		
								while($row_prog=mysql_fetch_array($res_photo))
								{			
									$path="images/category/";
								
								?>
								<td width="25%" align="center" valign="top">
									<?php
									if(($row_prog['image']!='') && (file_exists($path.$row_prog['image'])))
									{
										$dimensions_sport=imageresize("200","120","$path$row_prog[image]");
									?>
									<a href="details.php?pgID=_photo&type=<?php echo $row_prog['parentid'];?>" title="Click here to view more" style="text-decoration:none">

									<img border="0" src="<?php echo $path.$row_prog[image]?>" width="<?php echo $dimensions_sport[0]?>" height="<?php echo $dimensions_sport[1]?>" hspace="0"></a>
											<br>
											<table id="table17">
											<tr>
											<td align="left">
											<a href="details.php?pgID=_photo&type=<?php echo $row_prog['parentid'];?>" title="Click here to view more" style="text-decoration:none">
											<font face="Arial" size="2" color="#3086AB"><b><?php echo ucfirst($row_prog['category']);?></b></font></a><font face="Arial" size="2" color="#3086AB">									</font></td>
											</tr>
											<tr>
											<td align="left">
											
											<a href="details.php?pgID=_photo&type=<?php echo $row_prog['parentid'];?>" style="text-decoration:none">

											<font face="Arial" size="1" color="black">
											<?php
												
												$str= substr(htmlentities($row_prog['description']),0,468);
												$strs=substr($str,0,150);
												$prin=strrpos($strs,' ');
												$strnew=substr($strs,0,$prin);
												if($strnew!="")
												{
													echo ucfirst($strnew)."...";
												}
												?>								</font></a></td>
											</tr>
											</table>
											
								<?php
									
								}
								?>				
								</td>
										<?php
										$sno++;
										if($sno==4)
										{
											echo "</tr><tr><td>&nbsp;</td></tr><tr>";
											$sno=0;
										}
										
										}
										?>
										</tr>
										<tr>
										<td>
										<?php
										if(mysql_num_rows(mysql_query($query))==0)
										{

										echo "<br><p align='center'><font face='Trebuchet MS' size='2' color='#333333'><b>Photo Gallery will be updated soon..</b></font></p>";
										}
										?>

										</td>
										</tr>
									</table>
								</div>
							
						<?php
						}
						else if(isset($exp[1]) && $exp[1]=="photo")
						{											
							include_once "gallery/photos.php";
						}													
						else if($row_details[$column]!='')
						{
								if( $_GET['grievanceid'] != "" )
							{
						?>
							<br/><br/>
							<div class='valid_box' id='divid'><font color='green'>Thank you for using Complaint/ Grievance Registration service. Your Complaint is now registered successfully.<br/><br/>Your Grievance ID is <?php echo $_GET['grievanceid'];?>. You can use this Unique ID to track your complaint.</font><br><br></div><br/>
						   <?php 
						   }
							if(isset($_GET['status']) && !empty($_GET['status']))
							{
								$token=preg_replace('/[^a-z]/', '', trim($_GET['status']));
								if($token=="done")
								{
									echo "<div class='valid_box' id='divid'><font color='green'>Thanks for your Valuable Feedback.</font><br><br><font color='#000000'><b> For any further enquiries, Contact us at:</b></font><br><br></div>";	
								}
								else if($token=="uploaded")
								{
									echo "<div class='valid_box' id='divid'><font color='green'>We've received your resume.<br>Thank you for applying for the post. We'll get back to you soon.</font><br><br><font color='#000000'><b> For any further enquiries, Contact us at:</b></font><br><br></div>";	
								}
								else if($token=="error")
								{
									echo "<div class='error_box' id='divid'><font color='#FF0000'>Error Occured while sending your details.<br>Please try again.</font><br><br><font color='#000000'><b> For any further enquiries, Contact us at:</b></font><br><br></div>";	
								}
								else if($token=="duplicate")
								{
									echo "<div class='error_box' id='divid'><font color='#FF0000'>Email ID already registered.</b></font><br><br></div>";	
								}
							}
							if(isset($_GET['msg']) && !empty($_GET['msg']))
							{
								$token = preg_replace('/[^a-zA-Z ]/', '', trim($_GET['msg']));
								if(!empty($token))
								{
									echo "<div class='valid_box' id='divid'><font color='green'>".$token."</font><br><br><font color='#000000'><b> For any further enquiries, Contact us at:</b></font><br><br></div>";	
								}															
							}
							echo html_entity_decode($row_details[$column]);										
						}																									
						else if(  $category_id != "gallery" &&  $category_id != "feedback" && $category_id != "news-details" && $row_details['product_category'] == 0 && $row_details['package_page'] != 1 && $exp[0] != "package" &&  $row_details['display_form'] != "reservation" &&  $row_details['display_form'] != "enquiry" && $isYearWise != 1)
						{
							echo "Page under Construction";
						}
						/*if( $row_details['show_mapping'] == 1 )
						{
							echo '<div align="center"><iframe src="'.$row_details['map_code'].'"></iframe></div>';
						}*/
						if($row_details['package_page'] == 1)
						{
							include_once "services.php";														
						}	
						if($row_details['product_category'] != 0)
						{
							include_once "products.php";														
						}														
						if( $exp[0] == "package" )
						{
							include_once "package-overview.php";
						}
						if( $row_details['display_form'] == "reservation" )
						{
							include_once "reservation.php";
						}
						if( $row_details['display_form'] == "enquiry" )
						{
							include_once "enquiry.php";
						}
						if( $isYearWise == 1 )
						{
							include_once "year-wise-data.php";
						}
						if( $row_details['package_page'] == 1 )
						{
							$committeeID = $row_details['product_category'];
							include_once "committee.php";
						}
						if( $row_details['gallery_page'] == 1 )
						{
							include_once "gallery.php";
						}
						if( $category_id == "gallery" )
						{
							include_once "gallery-details.php";
						}
						if( $category_id == "feedback" )
						{
							include_once "feedback.php";
						}
						if( $category_id == "enquiry" )
						{
							include_once "enquiry.php";
						}
						if( $category_id == "complaint-status" )
						{
							include_once "status.php";
						}
						if( $category_id == 'privacy-policy')
						{
							include_once 'privacy-policy.php';
						}
						if( $category_id == "news-details" )
						{
							$newsid = preg_replace('/[^0-9]/', '', trim($_GET['topic']));
							$newsData = mysql_fetch_array( mysql_query( "select title, description from news where ser = '$newsid'" ));
							echo htmlentities($newsData['description']);
						}
						?>
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
