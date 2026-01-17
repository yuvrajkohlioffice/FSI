<?php
include 'includes/classes.php';
?>
<style media="print">
	@media print {

		header,
		footer {
			display: block !important;
			background: none !important;
			color: #000 !important;
			padding: 10px 0;
			border-top: 1px solid #ccc;
			border-bottom: 1px solid #ccc;
		}

		header *,
		footer * {
			color: #000 !important;
		}

		/* Optional: Add a page break after header or before footer if needed */
		/* header { page-break-after: avoid; } */
		/* footer { page-break-before: avoid; } */
	}
</style>

<style>
	.social li {
		display: inline-block !important;
	}

	.nav-header {
		/* background: #222; */
		padding: 10px;
	}

	.nav-header button {
		background: none;
		border: none;
		color: white;
		font-size: 20px;
		cursor: pointer;
	}

	#sidebar-menu {
		width: 315px;
		background-color: #98bc24;
		color: white;
		position: fixed;
		top: 0;
		left: -315px;
		height: 100vh;
		transition: left 0.3s ease;
		z-index: 1000;
		overflow-y: auto;
	}

	#sidebar-menu.active {
		left: 0;
	}

	#menu-close {
		background: none;
		border: none;
		color: black;
		font-size: 22px;
		float: right;
		margin: 10px;
		cursor: pointer;
	}

	#sidebar-menu ul {
		list-style: none;
		padding: 0;
		margin: 0;
	}

	#sidebar-menu ul li {
		padding: 10px;
		border-bottom: 1px solid #44444447;
	}

	#sidebar-menu ul li a {
		color: black;
		font-weight: 700 !important;
		text-decoration: none;
		display: flex;
		justify-content: space-between;
		align-items: center;
	}

	.m-0 {
		margin: 0 !important;
	}

	.submenu {
		display: none;
		list-style: none;
		padding-left: 20px;

	}

	.toggle-icon {
		font-weight: bold;
		margin-left: 10px;
	}

	.pt {
		display: flex;
		flex-wrap: wrap;
	}

	.important-links {
		display: flex;
		align-items: center;
		flex-wrap: wrap;
	}

	a {
		color: #000;
	}
</style>
<div class="mainmenu-gradient-bg">
	<!-- top header  -->
	<div class="container">
		<div class="row m-0 align-items-center py-2">

			<div class="col-12 col-lg-6 text-center text-lg-left mb-2 mb-lg-0">
				<a href="screen-reader-access" class="tt1">Screen Reader Access</a> |
				<a href="#maincontent" class="tt1">Skip to Main Content</a> |
				<a href="#navigation" class="tt1">Skip to Navigation</a> |
			</div>

			<div class="col-12 col-lg-6 text-center text-lg-right">
				<ul class="social m-0 p-0" style="display: inline-block;">
					<?php if ($common->facebook) { ?>
						<li class="list-inline-item"><a href="<?php echo $common->facebook; ?>" target="_blank" aria-label="facebook"><i class="fa fa-facebook"></i></a></li>
					<?php } ?>

					<?php if ($common->twitter) { ?>
						<li class="list-inline-item"><a href="<?php echo $common->twitter; ?>" target="_blank" aria-label="twitter"><i class="fa fa-twitter"></i></a></li>
					<?php } ?>

					<?php if ($common->youtube) { ?>
						<li class="list-inline-item"><a href="<?php echo $common->youtube; ?>" target="_blank" aria-label="youtube"><i class="fa fa-youtube"></i></a></li>
					<?php } ?>

					<?php if ($common->linkedin) { ?>
						<li class="list-inline-item"><a href="<?php echo $common->linkedin; ?>" target="_blank" aria-label="qoo"><img src="images/qoo.png" alt="qoo" style="width:70%"></a></li>
					<?php } ?>

					<li class="list-inline-item">
						<a href="https://www.instagram.com/bhartiyavansarvekshan/" target="_blank" aria-label="instagram"><i class="fa fa-instagram"></i></a>
					</li>

					<li class="list-inline-item">|</li>

					<li class="list-inline-item">
						<a href="/hindi" class="tt1">Hindi</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- start header -->
	<header id="maincontent">
		<div class="container">
			<div class="logo pull-left">
				<a href="index.php">
					<img src="img/resources/logo.png" alt="FSI" />
				</a>
			</div>
			<div class="top-info pull-right">
				<div class="info-box">
					<div class="search-wrapper pull-right ct1">
						<ul>
							<li>
								<ul class="search-box">
									<li>
										<form action="result.php" method="get">
											<input type="text" name="q" placeholder="Search for anything"
												aria-label="search">
											<button type="submit" aria-label="search-button"><i
													class="icon icon-Search"></i></button>
										</form>
									</li>
								</ul>
							</li>
						</ul>
					</div>
					<div class="clearfix"></div>

<div class="text-box">
    <p>
        <a href="/contact-us" style="color: #000000; text-decoration: none;">
            <span class="highlighted" style="color: #000000; font-weight: 600;">
                <i class="fa fa-phone"></i> Contact Us
            </span>
        </a>
    </p>
</div>

<div class="text-box">
    <p>
        <span class="highlighted" style="color: #000000; font-weight: 600;">
            <i class="fa fa-envelope"></i> 
            <?php 
                $emailValues = explode(',', htmlentities($common->default_email));
                echo htmlentities($emailValues[0]); 
            ?>
        </span>
    </p>
</div>
				</div>

				<div class="info-box">

					<div class="text-box">
						<p><span class="highlighted"><img src="img/gov-logo-1.png" alt="logo"></p>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- end header -->

	<!-- start mainmenu -->
	<nav class="mainmenu-navigation stricky">
		<div class="container mainmenu-gradient-bg">
			<div class="navigation pull-left ">
				<div class="nav-header">
					<button id="menu-toggle" type="button"><i class="fa fa-bars"></i></button>
				</div>
				<!-- sidebar  -->
				<div id="sidebar-menu">
					<button id="menu-close" type="button"><i class="fa fa-times"></i></button>
					<ul>
						<?php
						$res_menu = mysql_query("SELECT * FROM heading WHERE status='active' AND home='yes' AND (display_area='main' || display_area='topbottom') AND websiteType = 'English' ORDER BY position, name LIMIT 0,15");
						while ($row_heading = mysql_fetch_array($res_menu)) {
							$link = "details.php?pgID=mn_" . $row_heading['sno'];
							$target = "_self";

							if ($row_heading['otherurl'] != "") {
								$link = $row_heading['otherurl'];
								$target = $row_heading['target'];
							}
							if ($common->use_friendly_urls && $row_heading['seo_url'] != "") {
								$link = $row_heading['seo_url'];
								$target = $row_heading['target'];
							}

							$res_submenu = mysql_query("SELECT * FROM sub_heading WHERE status='active' AND heading='{$row_heading['sno']}' ORDER BY position, subhead LIMIT 0,15");
							$has_submenu = mysql_num_rows($res_submenu) > 0;
						?>
							<li class="">
								<a href="<?php echo $has_submenu ? 'javascript:void(0)' : htmlentities($link); ?>" class="<?php echo $has_submenu ? 'has-submenu' : ''; ?>" target="<?php echo $target; ?>">
									<?php echo htmlentities($row_heading['name']); ?>
									<?php if ($has_submenu) { ?><span class="toggle-icon">+</span><?php } ?>
								</a>
								<?php if ($has_submenu) { ?>
									<ul class="submenu">
										<?php while ($row_sub_heading = mysql_fetch_array($res_submenu)) {
											$sublink = "details.php?pgID=sb_" . $row_sub_heading['sno'];
											$subtarget = "_self";

											if ($row_sub_heading['otherurl'] != "") {
												$sublink = $row_sub_heading['otherurl'];
												$subtarget = $row_sub_heading['target'];
											}
											if ($common->use_friendly_urls && $row_sub_heading['seo_url'] != "") {
												$sublink = $row_sub_heading['seo_url'];
												$subtarget = $row_sub_heading['target'];
											}
										?>
											<li><a href="<?php echo htmlentities($sublink); ?>"
													target="<?php echo $subtarget; ?>"><?php echo htmlentities($row_sub_heading['subhead']); ?></a></li>
										<?php } ?>
									</ul>
								<?php } ?>
							</li>
						<?php } ?>
					</ul>
				</div>

				<!-- // menu bar  -->
				<div class="nav-footer "><a name="navigation"></a>
					<ul class="nav  menu" id="mainMenu">
						<?php
						$count = 0;
						$res_menu = mysql_query("select * from heading where status='active' and home='yes' and (display_area='main' || display_area='topbottom') and websiteType = 'English' order by position,name limit 0,15");
						$total_fields = mysql_num_rows($res_menu);
						while ($row_heading = mysql_fetch_array($res_menu)) {
							$count++;
							$target = "_self";
							$link = "details.php?pgID=mn_" . $row_heading['sno'];
							if ($row_heading['otherurl'] != "") {
								$target = $row_heading['target'];
								$link = $row_heading['otherurl'];
							}
							if ($common->use_friendly_urls && $row_heading['seo_url'] != "") {
								$target = $row_heading['target'];
								$link = $row_heading['seo_url'];
							}

							$active_link = 0;

							$res_submenu = mysql_query("select * from sub_heading where status='active' and heading='$row_heading[sno]' order by position,subhead limit 0,15");
							$total_sub_fields = mysql_num_rows($res_submenu);

							$other_attribute = $class = "";
							$class = "propClone";
							$other_attribute = 'class="inner-link"';
							if ($total_sub_fields > 0) {
								$link = "javascript:void(0)";
								$target = "_self";
								$class = "dropdown";
								$other_attribute = 'class="dropdown-toggle" data-toggle="dropdown"';
							}
						?>


							<li class="<?php echo $class; ?> item">
								<a href="<?php echo htmlentities($link); ?>" target="<?php echo $target; ?>"
									<?php echo $other_attribute; ?>><?php echo htmlentities($row_heading['name']); ?><?php if ($total_sub_fields > 0) { ?><b
										class="caret"></b><?php } ?></a>
								<?php if ($total_sub_fields > 0) { ?>

									<div class="sub-menu  dropdown item">
										<ul class="menu">
											<?php
											while ($row_sub_heading = mysql_fetch_array($res_submenu)) {
												$count1++;
												$target = "_self";
												$link = "details.php?pgID=sb_" . $row_sub_heading['sno'];
												if ($row_sub_heading['otherurl'] != "") {
													$target = $row_sub_heading['target'];
													$link = $row_sub_heading['otherurl'];
												}
												if ($common->use_friendly_urls && $row_sub_heading['seo_url'] != "") {
													$target = $row_sub_heading['target'];
													$link = $row_sub_heading['seo_url'];
												}
											?>

												<li><a href="<?php echo htmlentities($link); ?>" target="<?php echo $target; ?>">
														<?php echo htmlentities($row_sub_heading['subhead']); ?>
														<?php
														// Check if it's a local file
														$parsed_url = parse_url($link);
														if (!isset($parsed_url['host'])) {
															// It's a local file, remove any query strings
															$clean_link = strtok($link, '?');
															if (file_exists($clean_link)) {
																$file_size = filesize($clean_link);
																$file_type = pathinfo($clean_link, PATHINFO_EXTENSION);

																// Convert bytes to human-readable size
																$units = ['B', 'KB', 'MB', 'GB', 'TB'];
																$i = 0;
																while ($file_size >= 1024 && $i < count($units) - 1) {
																	$file_size /= 1024;
																	$i++;
																}
																$human_size = round($file_size, 2) . ' ' . $units[$i];

																echo " <span style='color:gray;'>($file_type, $human_size)</span>";
															}
														}
														?></a></li>
											<?php
											}
											?>
										</ul>
									</div>
								<?php } ?>
							</li>
						<?php
						}
						?>

					</ul>
				</div>
			</div>
		</div>
	</nav>