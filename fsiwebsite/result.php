<?php
ob_start();
session_start();
error_reporting(0);
include_once "includes/classes.php";
$titlesub="";
$pageh = "";


$meta_title = $common->site_name;

$meta_desc = "";

$meta_keywords = "";

if(!empty($row_details['meta_title']))
	$meta_title = strip_tags($row_details['meta_title']);
if(!empty($row_details['meta_key']))
	$meta_keywords = strip_tags($row_details['meta_key']);
if(!empty($row_details['meta_desc']))
	$meta_desc = strip_tags($row_details['meta_desc']);	

if(isset($_GET['q']) && $_GET['q']!="")
{
    $string=preg_replace('/[^a-zA-Z0-9 \-_]/', '', trim($_GET['q']));
    //$query_dynamic="select * from link_page where lower(detail) like'%$string%' or (heading IN (select sno from heading where lower(name) like '%$string%' and status='active') or heading IN (select sno from sub_heading where lower(subhead) like '%$string%' and status='active') or heading IN (select sno from top_bottom_menu where lower(name) like '%$string%' and status='active'))and status='active'";
    if( $string ) 
    {
    	$query_dynamic="select * from link_page where lower(detail) like'%$string%' or (heading IN (select sno from heading where lower(name) like '%$string%' and status='active') or heading IN (select sno from sub_heading where lower(subhead) like '%$string%' and status='active'))and status='active'";
    $recordsfound=mysql_num_rows(mysql_query($query_dynamic));
    }
    $title="Search Result for <font color='#800000'>\" ".$string." \"</font>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Search Result</title>
	<?php
	if(!empty($meta_desc))
	{
	?>
	<meta name="description" content="<?php echo $meta_desc;?>">
	<?php
	}
	if(!empty($meta_keywords))
	{
	?>
	<meta name="keywords" content="<?php echo $meta_keywords;?>">
	<?php
	}
	?>
	<meta name="author" content="Adxventure India., Dehradun">
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
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-12 pt">
					<p><marquee dir="ltr" width="100%">
					<?php 
					$sno=0;
					// $sql_news=;
					$result_news=mysql_query("select * from news where status='active' order by newsdate asc");
					while($row_news=mysql_fetch_array($result_news))
					{
						// var_dump($row_news);
						$sno++;
						$iconimage="";
						$size=1;
						if($row_news['size']!="")
						{
							$size=$row_news['size'];
						}	
					
						if($row_news['extension']!='' && file_exists("news/".$row_news['extension']))
						{
							$primeLink = "news/".$row_news['extension'];
							$target  = "_blank";
						}
						else if( $row_news['link'] != '' )
						{
							$primeLink = $row_news['link'];
							$target  = $row_news['target'];						
						}
					?>
					<?php echo $row_news['title'];?>
					<?php
					}
					?>
					</marquee></p>
				</div>
                <?php if( $primeLink ) { ?><div class="col-lg-4 col-md-12"><a class="contact-button" href="<?php echo $primeLink;?>" target="<?php echo $target;?>"><div class="contact-us-button">Learn More</div><i class="fa fa-arrow-circle-right"></i></a></div><?php } ?>
			</div>
		</div>
	</section>  
    <!-- /#promotional-text -->


	
<section id="landscaping-design-gardener">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 shop-page-content">
					
                    <div class="section-title-style-2">
						<h1>Search Result</h1>
						<p>You Search for <strong>"<?php echo $string;?>", <?php echo $recordsfound;?></strong> Record(s) found.</p>
					</div>					
					<div class="row">
					    <div class="col-md-12">
                        	<div class="page-content">
    						<?php
    							$res_query=mysql_query($query_dynamic);
    							while($row_details=mysql_fetch_array($res_query))
    							{
    					    ?>
    						        <div class='valid_box' id='divid'>
    						            <h5><?php echo $row_details['page_heading'];?></h5>
    						            <?php																
    									$str=substr(strip_tags($row_details['detail']),0,800);
    									$strs=substr($str,0,350);
    									$prin=strrpos($strs,' ');
    									$strnew=substr($strs,0,$prin);
    									echo strip_tags($strnew)."..."; 
    									?><br/><a href="<?php echo $row_details['friendly_url'];?>" style="float: right;"><input type="button" title="Click here to read more" value="Read More" class="btn"></a>
    						        </div><div class="clearfix">&nbsp;</div><hr/>
    						<?php 
    						    }
    						?>
    						
    						
    							</div>
                    	
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
<?php } ?>
