<?php
	include_once "includes/constant.php";
	include_once "control.php";
	echo 10;
?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
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
	<div class="page-container">
		<!-- BEGIN SIDEBAR -->
		<?php
			include_once "side_bar.php";
		?>
		<!-- END SIDEBAR -->
		<!-- BEGIN PAGE -->
		<div class="page-content">
			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<div id="portlet-config" class="modal hide">
				<div class="modal-header">
					<button data-dismiss="modal" class="close" type="button"></button>
					<h3>Widget Settings</h3>
				</div>
				<div class="modal-body">
					Widget settings form goes here
				</div>
			</div>
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid">
				<!-- BEGIN PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN PAGE TITLE & BREADCRUMB-->
						<h3 class="page-title">
							Dashboard <small>statistics and more</small>
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="index.html">Home</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li><a href="#">Dashboard</a></li>
							<li class="pull-right no-text-shadow">
								<div id="dashboard-report-range" class="dashboard-date-range tooltips no-tooltip-on-touch-device responsive" data-tablet="" data-desktop="tooltips" data-placement="top" data-original-title="Change dashboard date range">
									<i class="icon-calendar"></i>
									<span></span>
									<i class="icon-angle-down"></i>
								</div>
							</li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<div id="dashboard">
					<!-- BEGIN DASHBOARD STATS -->
					<div class="row-fluid">
						<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
							<div class="dashboard-stat blue">
								<div class="visual">
									<i class="icon-comments"></i>
								</div>
								<div class="details">
									<div class="number">
										<?php
											echo mysql_num_rows(mysql_query("select sno from enquiry"));
										?>
									</div>
									<div class="desc">                           
										Total Enquiries
									</div>
								</div>
								<a class="more" href="#">
								View more <i class="m-icon-swapright m-icon-white"></i>
								</a>                 
							</div>
						</div>
						<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
							<div class="dashboard-stat green">
								<div class="visual">
									<i class="icon-shopping-cart"></i>
								</div>
								<div class="details">
									<div class="number">
									<?php
										echo mysql_num_rows(mysql_query("select sno from product_enquiry"));
									?></div>
									<div class="desc">Product Enquiries</div>
								</div>
								<a class="more" href="#">
								View more <i class="m-icon-swapright m-icon-white"></i>
								</a>                 
							</div>
						</div>
						<div class="span3 responsive" data-tablet="span6  fix-offset" data-desktop="span3">
							<div class="dashboard-stat purple">
								<div class="visual">
									<i class="icon-globe"></i>
								</div>
								<div class="details">
									<div class="number">2</div>
									<div class="desc">Recent Activities</div>
								</div>
								<a class="more" href="#">
								View more <i class="m-icon-swapright m-icon-white"></i>
								</a>                 
							</div>
						</div>
						<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
							<div class="dashboard-stat yellow">
								<div class="visual">
									<i class="icon-bar-chart"></i>
								</div>
								<div class="details">
									<div class="number">
									<?php
											echo mysql_num_rows(mysql_query("select sno from prod_products"));
									?>
									</div>
									<div class="desc">Total Prodcuts</div>
								</div>
								<a class="more" href="#">
								View more <i class="m-icon-swapright m-icon-white"></i>
								</a>                 
							</div>
						</div>
					</div>
					<!-- END DASHBOARD STATS -->
					
					<div class="clearfix"></div>
					<div class="row-fluid">
						<div class="span6">
							<div class="portlet box blue">
								<div class="portlet-title">
									<div class="caption"><i class="icon-bell"></i>Recent Activities</div>
									<div class="actions">
										<div class="btn-group">
											<a class="btn" href="#" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
											Filter By
											<i class="icon-angle-down"></i>
											</a>
											<div class="dropdown-menu hold-on-click dropdown-checkboxes pull-right">
												<label><input type="checkbox"> Finance</label>
												<label><input type="checkbox" checked=""> Membership</label>
												<label><input type="checkbox"> Customer Support</label>
												<label><input type="checkbox" checked=""> HR</label>
												<label><input type="checkbox"> System</label>
											</div>
										</div>
									</div>
								</div>
								<div class="portlet-body">
									<div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible="0">
										<ul class="feeds">
											<?php
											$res_activity = mysql_query("select details, purpose, userid, ip_address, browser, createdon from activity_log order by sno desc limit 0,40");
											while($row_activity = mysql_fetch_array($res_activity))
											{											
											?>
											<li>
												<div class="col1">
													<div class="cont">
														<div class="cont-col1">
															<div class="label label-info">                        
																<i class="icon-check"></i>
															</div>
														</div>
														<div class="cont-col2">
															<div class="desc">
																<?php echo $row_activity['details'];?>
																<span class="label label-warning label-mini">
																<?php echo $row_activity['ip_address'];?> 
																<i class="icon-share-alt"></i>
																</span>																
																<?php echo $row_activity['browser'];?> 																

															</div>
														</div>
													</div>
												</div>
												<div class="col2">
													<div class="date">
														<?php
															//$date_stamp = get_timestamp() - $row_activity['createdon'];
															
															$time_diff = abs(get_timestamp() - $row_activity['createdon']);
															
															if ($time_diff < 60) 
															{
															    echo $time_diff . " sec";
															}
															//if time difference is greater than 60 and lesser than 60*60*60 ,then its minutes
															if (($time_diff > (60)) && ($time_diff < (60 * 60 * 60))) {
															    echo round($time_diff / (60 * 60)) . " min";
															}
															 
															//if time difference is greater than 60*60*60 and lesser than 60*60*60*24,then its hours
															if (($time_diff > (60 * 60 * 60)) && ($time_diff <= (60 * 60 * 60 * 24))) {
															    echo round($time_diff / (60 * 60 * 60)) . " hours";
															}
															 
															if ($time_diff > (60 * 60 * 60 * 24)) {
															    echo round($time_diff / (60 * 60 * 60 * 24)) . " days";
															}
															
															
															?>
													</div>
												</div>
											</li>
											<?php
											}
											?>
											
										</ul>
									</div>
									<div class="scroller-footer">
										<div class="pull-right">
											<a href="#">See All Records <i class="m-icon-swapright m-icon-gray"></i></a> &nbsp;
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="span6">
							<div class="portlet box blue">
								<div class="portlet-title">
									<div class="caption"><i class="icon-bell"></i>Recent Activities</div>
									<div class="actions">
										<div class="btn-group">
											<a class="btn" href="#" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
											Filter By
											<i class="icon-angle-down"></i>
											</a>
											<div class="dropdown-menu hold-on-click dropdown-checkboxes pull-right">
												<label><input type="checkbox"> Finance</label>
												<label><input type="checkbox" checked=""> Membership</label>
												<label><input type="checkbox"> Customer Support</label>
												<label><input type="checkbox" checked=""> HR</label>
												<label><input type="checkbox"> System</label>
											</div>
										</div>
									</div>
								</div>
								<div class="portlet-body">
									<div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible="0">
										<ul class="feeds">
											<li>
												<div class="col1">
													<div class="cont">
														<div class="cont-col1">
															<div class="label label-info">                        
																<i class="icon-check"></i>
															</div>
														</div>
														<div class="cont-col2">
															<div class="desc">
																Mr. Abc Order Product.
																<span class="label label-warning label-mini">
																Take action 
																<i class="icon-share-alt"></i>
																</span>
															</div>
														</div>
													</div>
												</div>
												<div class="col2">
													<div class="date">
														Just now
													</div>
												</div>
											</li>
										</ul>
									</div>
									<div class="scroller-footer">
										<div class="pull-right">
											<a href="#">See All Records <i class="m-icon-swapright m-icon-gray"></i></a>&nbsp;
										</div>
									</div>
								</div>
							</div></div>
					</div>
				</div>
			</div>
			<!-- END PAGE CONTAINER-->    
		</div>
		<!-- END PAGE -->
	</div>
	<!-- END CONTAINER -->
	<?php
		include_once "footer.php";
	?>
</body>
<!-- END BODY -->
</html>
