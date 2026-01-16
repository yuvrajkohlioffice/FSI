<?php
	include_once "includes/constant.php";
	include_once "control.php";
	if(!isset($_REQUEST['action']))
	{
		view();
		exit;
	}
	if(isset($_GET['action']) && $_GET['action']=="details")
	{
		view_details();
		exit;
	}
function view()
{

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
						<!-- BEGIN STYLE CUSTOMIZER -->
						
						<!-- END BEGIN STYLE CUSTOMIZER -->  
						<!-- BEGIN PAGE TITLE & BREADCRUMB-->
						<h3 class="page-title">
							Online Bulk Enquiries <small>Bulk Enquiry</small>
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="mainmenu.php">Home</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<a href="#">Form Details</a>
								<i class="icon-angle-right"></i>
							</li>
							<li><a href="#">Bulk Enquiry</a></li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->          
				<div class="row-fluid">
					<div class="span12">
						<!--div class="alert alert-success">
							<button class="close" data-dismiss="alert"></button>
							Please try to re-size your browser window in order to see the tables in responsive mode.<br>
							<span class="label label-important">NOTE:</span>&nbsp;This feature is supported by Internet Explorer 10, Latest Firefox, Chrome, Opera and Safari
						</div-->
						<!-- BEGIN SAMPLE TABLE PORTLET-->
						<div class="portlet box green">
							<div class="portlet-title">
								<div class="caption"><i class="icon-cogs"></i>Bulk Enquiry</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="#portlet-config" data-toggle="modal" class="config"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body flip-scroll">
								<table class="table-bordered table-striped table-condensed flip-content">
									<thead class="flip-content">
										<tr>
											<th>Sr. No.</th>											
											<th>Name</th>
											<th>Email ID</th>
											<th>Enquiry Date</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$count = 0;
										$res_enq = mysql_query("select * from product_enquiry");
										while($row_details = mysql_fetch_array($res_enq))
										{
											$count++;
										?>
										<tr>
											<td><?php echo $count; ?></td>
											<td><?php echo $row_details['name'];?></td>
											<td><?php echo $row_details['email'];?></td>
											<td><?php echo date("d-M-Y",strtotime($row_details['crdate']));?></td>
											<td align="center"><a href="enquiry-details.php?action=details&id=<?php echo $row_details['sno'];?>"><img src="images/detail1.gif" alt="Details"></a></td>

										</tr>
										<?php
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
						<!-- END SAMPLE TABLE PORTLET-->
						<!-- BEGIN SAMPLE TABLE PORTLET-->
						
						<!-- END SAMPLE TABLE PORTLET-->
					</div>
				</div>
				<!-- END PAGE CONTENT-->
			</div>
			<!-- END PAGE CONTAINER-->
		</div>
		<!-- END PAGE -->
	</div>
	<!-- END CONTAINER -->
	<!-- BEGIN FOOTER -->
	<?php
		include_once "footer_form.php";
	?> 
</body>
<!-- END BODY -->
</html>
<?php
}
function view_details()
{
	$contentid=preg_replace('/[^0-9]/', '', trim($_GET['id']));
	$query=mysql_query("select * from product_enquiry where sno='$contentid'");
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
						<!-- BEGIN STYLE CUSTOMIZER -->
						
						<!-- END BEGIN STYLE CUSTOMIZER -->  
						<!-- BEGIN PAGE TITLE & BREADCRUMB-->
						<h3 class="page-title">
							Online Bulk Enquiries <small>Bulk Enquiry</small>
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="mainmenu.php">Home</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<a href="enquiry-details.php">Form Details</a>
								<i class="icon-angle-right"></i>
							</li>
							<li><a href="enquiry-details.php">Bulk Enquiry</a></li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->          
				<div class="row-fluid">
					<div class="span12">
						<!--div class="alert alert-success">
							<button class="close" data-dismiss="alert"></button>
							Please try to re-size your browser window in order to see the tables in responsive mode.<br>
							<span class="label label-important">NOTE:</span>&nbsp;This feature is supported by Internet Explorer 10, Latest Firefox, Chrome, Opera and Safari
						</div-->
						<!-- BEGIN SAMPLE TABLE PORTLET-->
						<div class="portlet box green">
							<div class="portlet-title">
								<div class="caption"><i class="icon-cogs"></i>Poruct Enquiry Details</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="#portlet-config" data-toggle="modal" class="config"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body flip-scroll">
								<div class="control-group">
										<label class="control-label">Product Name&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['product_name'];?></b> 
										</div>
								</div>	
								<div class="control-group">
										<label class="control-label">Name&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['name'];?></b> 
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">Email ID&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['email'];?></b> 
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">Organisation Name&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['organization'];?></b> 
										</div>
								</div>
								<hr size="1">
								<div class="control-group">
										<label class="control-label">House No. / Building No.&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['house_no'];?></b> 
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">Street Name / No.&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['street_name'];?></b> 
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">Area Name&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['area_name'];?></b> 
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">Landmark&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['landmark'];?> </b>
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">Pin Code&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['pincode'];?> </b>
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">City&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['city'];?> </b>
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">State&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['state'];?></b> 
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">Country&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php 
											if(empty($row_content['other_country']))
												echo $row_content['country'];
											else
												echo $row_content['country'];											
											?> </b>
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">Mobile No.&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['mobile_no'];?> </b>
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">Landline No.&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['landline_no'];?></b> 
										</div>
								</div>
								<div class="control-group">
										<label class="control-label">Enquiry Details&nbsp;&nbsp;</label>
										<div class="controls">
											<b><?php echo $row_content['enquiry'];?> </b>
										</div>
								</div>
							</div>
						</div>
						<!-- END SAMPLE TABLE PORTLET-->
						<!-- BEGIN SAMPLE TABLE PORTLET-->
						
						<!-- END SAMPLE TABLE PORTLET-->
					</div>
				</div>
				<!-- END PAGE CONTENT-->
			</div>
			<!-- END PAGE CONTAINER-->
		</div>
		<!-- END PAGE -->
	</div>
	<!-- END CONTAINER -->
	<!-- BEGIN FOOTER -->
	<?php
		include_once "footer_form.php";
	?> 
</body>
<!-- END BODY -->
</html>
<?php
}
?>