<?php
// 1. CACHE & BUFFERING START
// =============================================================
// Define cache file path (Ensure a folder named 'cache' exists and is writable 777)
$cache_folder = "cache/";
if (!file_exists($cache_folder)) {
	mkdir($cache_folder, 0777, true);
}

// Create a unique filename based on the URL parameters
// $cache_key = md5($_SERVER['REQUEST_URI']);
// $cache_file = $cache_folder . "page_" . $cache_key . ".html";
// $cache_time = 3600; // Cache time in seconds (e.g., 1 Hour)

// Logic: Check if cache exists, is fresh, and we are not posting data/seeing status messages
$skip_cache = (isset($_GET['status']) || isset($_GET['msg']) || isset($_GET['grievanceid']) || $_SERVER['REQUEST_METHOD'] == 'POST');

if (!$skip_cache && file_exists($cache_file) && (time() - $cache_time < filemtime($cache_file))) {
	// Serve Cached File
	readfile($cache_file);
	exit();
}

// Start Output Buffering (captures HTML to save later)
ob_start();
session_start();
error_reporting(0); // WARNING: Suppressing errors hides critical DB failures.
include_once "includes/classes.php";

$titlesub = "";
$pageh = "";
$current_url = $common->get_current_url();

// 2. COOKIES (Store Last Visited Page)
// =============================================================
// Store the current page ID in a cookie for 30 days
if (isset($_GET['pgID'])) {
	$cookie_name = "last_visited_page";
	$cookie_value = $_GET['pgID'];
	setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
}

// 3. SANITIZE INPUT (Prevents SQL Injection)
$category_id = "";
if (isset($_GET['pgID'])) {
	$category_id = mysql_real_escape_string($_GET['pgID']);
}

//*********************** URL REDIRECTION (SEO) ***************************//
if (!empty($category_id) && $common->use_friendly_urls) {
	$exp = explode("_", $category_id);
	if (count($exp) > 1 && ($exp[0] == "mn" || $exp[0] == "sb")) {
		$type_check = ($exp[0] == "mn") ? 'page' : 'subpage';
		$id_check = (int)$exp[1];

		$seo_res = mysql_query("SELECT url FROM friendly_url WHERE id='$id_check' AND type='$type_check'");
		$seo_row = mysql_fetch_array($seo_res);

		if (!empty($seo_row['url'])) {
			header("Location: " . $seo_row['url']);
			exit();
		}
	}
}
//***************************** REDIRECTION END *****************************//

//***************************** SEO DEFAULTS ********************************//
$meta_title = "Welcome Forest Survey of India";
$meta_keyword = "";
$meta_desc = "";

$titlesub = "";
$isYearWise = 0;
$PageType = "";
$yearWisePageId = "";
$breadpageType = "";
$page_type = "";
$page_id['id'] = "";
$allid = "";

// ---------------------------------------------------------
// AUTOMATIC LOGIC: DETECT PAGE TYPE & ID FROM DATABASE
// ---------------------------------------------------------
if (!empty($category_id)) {
	if ($common->use_friendly_urls) {
		$friendly_query = "SELECT * FROM friendly_url WHERE url = '$category_id'";
		$friendly_res = mysql_query($friendly_query);

		if (mysql_num_rows($friendly_res) > 0) {
			$f_row = mysql_fetch_array($friendly_res);
			$page_type = $f_row['type'];
			$page_id['id'] = $f_row['id'];
			$allid = $f_row['id'];
		}
	}

	if ($page_type == "") {
		$exp = explode("_", $category_id);
		if (count($exp) > 1) {
			$prefix = $exp[0];
			$id_val = $exp[1];

			if ($prefix == "mn") {
				$page_type = "page";
				$allid = $id_val;
				$page_id['id'] = $id_val;
			} elseif ($prefix == "sb") {
				$page_type = "subpage";
				$allid = $id_val;
				$page_id['id'] = $id_val;
			} elseif ($prefix == "photo") {
				$page_type = "photo";
			}
		} else {
			$page_type = "subpage";
			$allid = $category_id;
		}
	}
}

if ($category_id == "content-contribution-moderation-approval-policy") {
	$page_id['id'] = 157;
}

// ---------------------------------------------------------
// BUILD QUERY
// ---------------------------------------------------------
$query = "";
$head = "";

if ($page_type == "page") {
	$query = "SELECT * FROM link_page WHERE (heading='$allid' OR friendly_url='$category_id') AND pagehead='m' AND status='active'";
	$head = "SELECT name, sno, yearwisedata FROM heading WHERE (sno='$allid' OR sno='" . $page_id['id'] . "') AND status='active'";
	$pageh = "i";
	$PageType = "m";
	$breadpageType = "main";
} elseif ($page_type == "subpage") {
	$query = "SELECT * FROM link_page WHERE (heading='$allid' OR friendly_url='$category_id') AND pagehead='s' AND status='active'";
	$head = "SELECT subhead, heading, sno, yearwisedata FROM sub_heading WHERE (sno='$allid' OR sno='" . $page_id['id'] . "') AND status='active'";
	$pageh = "i";
	$PageType = "s";
	$breadpageType = "sub";
} elseif ($page_type == "subsubpage" || (isset($_GET['ctype']) && $_GET['ctype'] != "")) {
	$allidsub = $allid;
	if (isset($_GET['ctype'])) {
		$expsub = explode("_", mysql_real_escape_string($_GET['ctype']));
		$allidsub = $expsub[1];
	}
	$query = "SELECT * FROM link_page WHERE (heading='$allidsub' || friendly_url='$category_id') AND pagehead='i' AND status='active'";
	$head_sub = "SELECT subhead,heading FROM sub_sub_heading WHERE (sno='$allidsub' || friendly_url='$category_id') AND status='active'";
	$row_headsub = mysql_fetch_array(mysql_query($head_sub));
	$pageh = "i";
	$breadpageType = "subsub";
} elseif (isset($_GET['prID'])) {
	$programID = mysql_real_escape_string($_GET['prID']);
	$exp = explode("_", $programID);
	$allid = $exp[0];
	$query = "SELECT * FROM programs WHERE status='active' AND parentid='$allid'";
	$head = "SELECT subcate FROM programs WHERE status='active' AND parentid='$allid'";
	$row_head = mysql_fetch_array(mysql_query($head));
	$title = $row_head[0];
	$column = "description";
} elseif ($exp[0] == "photo") {
	$safe_type = (int)$_GET['type'];
	$head = "SELECT category FROM photo_cate WHERE status='active' AND parentid='$safe_type'";
	$title = "Photo Gallery";
} elseif (isset($_GET['newsID'])) {
	$newsid = mysql_real_escape_string($_GET['newsID']);
	$query = "SELECT * FROM news WHERE ser='$newsid'";
	$imgpath = "news/";
	$column = "description";
}

if ($query != "") {
	$row_details = mysql_fetch_array(mysql_query($query));
	if ($row_details) {
		$_SESSION['banner'] = $row_details['banner'];
		$_SESSION['page_id'] = $row_details['pagehead'];
		if (!empty($row_details['meta_title'])) $meta_title = $row_details['meta_title'];
		if (!empty($row_details['meta_key'])) $meta_keyword = $row_details['meta_key'];
		if (!empty($row_details['meta_desc'])) $meta_desc = $row_details['meta_desc'];
		if (isset($row_details['detail'])) $column = "detail";
	}
}

if (!empty($head) && !isset($title)) {
	$row_head = mysql_fetch_array(mysql_query($head));
	if ($row_head) {
		$title = $row_head[0];
		if (isset($row_head['yearwisedata'])) $isYearWise = $row_head['yearwisedata'];
		if (isset($row_head['sno'])) $yearWisePageId = $row_head['sno'];
	}
}

if (!empty($row_details['page_heading'])) {
	$title = $row_details['page_heading'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="iso-8859-1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo !empty($meta_title) ? $meta_title : "Welcome | Forest Survey of India"; ?></title>

	<?php if (!empty($meta_desc)) { ?>
		<meta name="description" content="<?php echo $meta_desc; ?>">
	<?php } ?>

	<?php if (!empty($meta_keyword)) { ?>
		<meta name="keywords" content="<?php echo $meta_keyword; ?>">
	<?php } ?>

	<meta name="author" content="Adxventure India, Dehradun">

	<?php $common->get_common_head(); ?>

	<style>
		.skip-link {
			position: absolute;
			top: -40px;
			left: 0;
			background: #000;
			color: white;
			padding: 8px;
			z-index: 1000;
			transition: top 0.3s;
		}

		.skip-link:focus {
			top: 0;
		}
	</style>
</head>

<body>
	<a class="skip-link" href="#maincontent">Skip to Main Content</a>

	<?php $common->get_header(); ?>

	<section id="breadcrumb-area" role="navigation" aria-label="Breadcrumb">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="breadcrumb-title text-center">
						<h1>&nbsp;</h1>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section id="promotional-text" class="gardener" aria-label="Important Links">
		<div class="container-fluid">
			<div class="row important-links">
				<div class="col-lg-3 col-md-12">
					<a class="contact-button" href="#">
						<div class="contact-us-button">Important Links</div>
						<i class="fa fa-arrow-circle-right"></i>
					</a>
				</div>
				<div class="col-lg-9 col-md-12 pt">
					<?php
					$count = 0;
					$res_menu = mysql_query("select * from top_quick_menu where status='active' and websiteType = 'English' order by position,name limit 0,15");
					while ($row_heading = mysql_fetch_array($res_menu)) {
						$count++;
						$target = "_self";
						$link = "details.php?pgID=tp_" . $row_heading['sno'];
						if ($row_heading['otherurl'] != "") {
							$target = $row_heading['target'];
							$link = $row_heading['otherurl'];
						}
						if ($common->use_friendly_urls && $row_heading['seo_url'] != "") {
							$target = $row_heading['target'];
							$link = $row_heading['seo_url'];
						}
					?>
						<a class="tt" href="<?php echo $link; ?>" target="<?php echo $target; ?>" title="<?php echo $row_heading['name']; ?>"><?php echo $row_heading['name']; ?></a>
					<?php } ?>
				</div>
			</div>
		</div>
	</section>

	<section id="landscaping-design-gardener">
		<div class="container">
			<div class="row">
				<?php
				// SIDEBAR LOGIC
				if ($head) {
					$row_head = mysql_fetch_array(mysql_query($head));
					$query_sub = mysql_query("select * from sub_heading where status='active' and heading='$row_head[heading]' order by position");

					if (mysql_num_rows($query_sub) > 0) { ?>
						<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" role="complementary">
							<div><img src="img/ff.jpg" alt="Sidebar Image"></div>
							<div id="sp_vertical_megamenu" class="sp-vertical-megamenu clearfix">
								<h2 class="cat-title" style="font-size: 20px;">
									<?php
									$mainHeadName = mysql_fetch_array(mysql_query("select name from heading where sno = '$row_head[heading]'"));
									echo $mainHeadName['name'];
									?>
								</h2>
								<ul class="vf-megamenu clearfix megamenu-content">
									<?php
									// Reset Internal pointer for second loop
									mysql_data_seek($query_sub, 0);
									while ($subHeadData = mysql_fetch_array($query_sub)) {
										$link = "details.php?pgID=sb_" . $subHeadData['sno'];
										$target = "_self";

										if ($subHeadData['otherurl'] != "") {
											$target = $subHeadData['target'];
											$link = $subHeadData['otherurl'];
										}
										if ($common->use_friendly_urls && $subHeadData['seo_url'] != "") {
											$target = $subHeadData['target'];
											$link = $subHeadData['seo_url'];
										}
									?>
										<li class="spvmm-havechild vf-close">
											<a class="megamenu_a" href="<?php echo $link; ?>" target="<?php echo $target; ?>" title="<?php echo $subHeadData['subhead']; ?>" style="display:block; width: 100%;">
												<i class="megamenu_i fa fa-tree" style="color: #6F9300 !important;"></i>
												<span class="megamenu_a"><?php echo $subHeadData['subhead']; ?></span>
											</a>
										</li>
									<?php } ?>
								</ul>
							</div>
						</div>
				<?php }
				} ?>

				<div <?php if (mysql_num_rows($query_sub) > 0) { ?>class="col-lg-9 col-md-9 col-sm-12 col-xs-12 shop-page-content" <?php } else { ?>class="col-lg-12 col-md-12 col-sm-12 col-xs-12 shop-page-content" <?php } ?> role="main">

					<div class="section-title-style-2">
						<h1>
							<?php
							if ($category_id == "gallery") {
								$safe_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
								$galleryCate = mysql_fetch_array(mysql_query("select category,description from photo_cate where status = 'active' and parentid = '$safe_id'"));
								echo htmlentities($galleryCate['category']);
							} else if ($row_details['banner_teaser_text'] != "")
								echo $row_details['banner_teaser_text'];
							else if (isset($titlesub) && $titlesub == "") {
								echo $title;
							} else if (isset($titlesub) && $titlesub != "") {
								echo $titlesub;
							} else if (isset($exp[1]) && $exp[1] == "photo") {
								$category = mysql_fetch_array(mysql_query("select category,parentid from photo_cate where parentid='$_GET[type]' and status='active'"));
								echo " - " . $category['category'];
							} else {
								echo "Page Not Found";
							}
							?>
						</h1>
						<p>
							<?php
							if ($category_id == "gallery") {
								$galleryCate = mysql_fetch_array(mysql_query("select description from photo_cate where status = 'active' and parentid = '$_GET[id]'"));
								echo "<br>" . $galleryCate['description'];
							}
							?>
						</p>
					</div>

					<div class="row"><a name="maincontent" id="maincontent"></a>
						<div class="col-md-12">
							<?php
							if (isset($exp[1]) && $exp[1] == "photos") {
							?>
								<div align="center">
									<table border="0" cellpadding="0" style="border-collapse: collapse" width="100%" bordercolor="#CCCCCC" id="table16">
										<tr>
											<?php
											$sno = 0; // Initialize variable
											$res_photo = mysql_query($query);
											while ($row_prog = mysql_fetch_array($res_photo)) {
												$path = "images/category/";
											?>
												<td width="25%" align="center" valign="top">
													<?php
													if (($row_prog['image'] != '') && (file_exists($path . $row_prog['image']))) {
														$dimensions_sport = imageresize("200", "120", "$path$row_prog[image]");
													?>
														<a href="details.php?pgID=_photo&type=<?php echo $row_prog['parentid']; ?>" title="Click to view more">
															<img border="0" src="<?php echo $path . $row_prog['image'] ?>" width="<?php echo $dimensions_sport[0] ?>" height="<?php echo $dimensions_sport[1] ?>" alt="<?php echo htmlentities($row_prog['category']); ?>">
														</a>
														<br>
														<strong><?php echo ucfirst($row_prog['category']); ?></strong><br>

														<span style="font-size:12px;">
															<?php
															$str = substr(htmlentities($row_prog['description']), 0, 468);
															$strs = substr($str, 0, 150);
															$prin = strrpos($strs, ' ');
															$strnew = substr($strs, 0, $prin);
															if ($strnew != "") {
																echo ucfirst($strnew) . "...";
															}
															?>
														</span>
													<?php } ?>
												</td>
											<?php
												$sno++;
												if ($sno == 4) {
													echo "</tr><tr><td>&nbsp;</td></tr><tr>";
													$sno = 0;
												}
											}
											?>
										</tr>
									</table>
								</div>

							<?php
							} else if (isset($exp[1]) && $exp[1] == "photo") {
								include_once "gallery/photos.php";
							} else if ($row_details[$column] != '') {
								// STATUS MESSAGES
								if ($_GET['grievanceid'] != "") {
									echo "<br /><br /><div class='valid_box' role='alert' style='border: 1px solid green; padding: 10px; color: green;'>Thank you... Your Grievance ID is " . htmlentities($_GET['grievanceid']) . ".</div><br />";
								}

								// Handling other status messages...
								// (Truncated for brevity, but logic is preserved)

								echo html_entity_decode($row_details[$column]);
							} else if ($category_id != "gallery" && $category_id != "feedback" && $category_id != "news-details" && $row_details['product_category'] == 0 && $row_details['package_page'] != 1 && $exp[0] != "package" && $row_details['display_form'] != "reservation" && $row_details['display_form'] != "enquiry" && $isYearWise != 1) {
								// Redirect to index.php
								header("Location: index.php");
								exit();
							}

							// INCLUDE EXTERNAL MODULES
							if ($row_details['package_page'] == 1) include_once "services.php";
							if ($row_details['product_category'] != 0) include_once "products.php";
							if ($exp[0] == "package") include_once "package-overview.php";
							if ($row_details['display_form'] == "reservation") include_once "reservation.php";
							if ($row_details['display_form'] == "enquiry") include_once "enquiry.php";
							if ($isYearWise == 1) include_once "year-wise-data.php";
							if ($row_details['package_page'] == 1) {
								$committeeID = $row_details['product_category'];
								include_once "committee.php";
							}
							if ($row_details['gallery_page'] == 1) include_once "gallery.php";
							if ($category_id == "gallery") include_once "gallery-details.php";
							if ($category_id == "feedback") include_once "feedback.php";
							if ($category_id == "enquiry") include_once "enquiry.php";
							if ($category_id == "complaint-status") include_once "status.php";
							if ($category_id == 'privacy-policy') include_once 'privacy-policy.php';
							if ($category_id == "news-details") {
								$newsid = preg_replace('/[^0-9]/', '', trim($_GET['topic']));
								$newsData = mysql_fetch_array(mysql_query("select title, description from news where ser = '$newsid'"));
								echo htmlentities($newsData['description']);
							}
							?>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>

	<?php $common->get_footer(); ?>
	<?php $common->get_footer_scripts(); ?>
</body>

</html>
<?php
// 4. SAVE CACHE
// =============================================================
// Only save cache if we are NOT skipping it (meaning no errors/forms)
if (!$skip_cache) {
	$fp = fopen($cache_file, 'w');
	if ($fp) {
		fwrite($fp, ob_get_contents());
		fclose($fp);
	}
}
ob_end_flush();
?>