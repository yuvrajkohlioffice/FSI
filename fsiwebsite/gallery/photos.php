<?php
if(isset($_GET['type']) && !empty($_GET['type']))
{
	$photo_category_id = "";
	
	$photo_category_id = preg_replace('/[^0-9]/', '', trim( $_GET['type'] ));
	
	if( !empty($photo_category_id) )
	{
		include_once "includes/classes.php";
	
		$sub_query = "select * from photo_subcate where parentid = '$photo_category_id' and status = 'active' order by sorder";
		$subcate = mysql_query( $sub_query );
		if(mysql_num_rows(mysql_query($sub_query))>0)
		{
?>
		
<head>
		<link rel="stylesheet" href="gallery/css/basic.css" type="text/css" />
		<link rel="stylesheet" href="gallery/css/galleriffic-2.css" type="text/css" />
		<script type="text/javascript" src="gallery/js/jquery-1.3.2.js"></script>
		<script type="text/javascript" src="gallery/js/jquery.galleriffic.js"></script>
		<script type="text/javascript" src="gallery/js/jquery.opacityrollover.js"></script>
		<!-- We only want the thunbnails to display when javascript is disabled -->
		<!--script type="text/javascript">
			document.write('<style>.noscript { display: none; }</style>');
		</script-->
		</head>

		<div align="right"><a href="javascript:history.back(-1);"><img src="/UserFiles/images/fsi_new/back_button.png" border="0"></a></div>

		<div id="page">
			<div id="container">
				

				<!-- Start Advanced Gallery Html Containers -->
				<div id="gallery" class="content">
					<div id="controls" class="controls"></div>
					<div class="slideshow-container">
						<div id="loading" class="loader"></div>
						<div id="slideshow" class="slideshow"></div>
					</div>
					<div id="caption" class="caption-container"></div>
				</div>
				<div id="thumbs" class="navigation">
					<ul class="thumbs noscript">
						<?php
						while($row_subcate=mysql_fetch_array($subcate))
						{						
						?>
						<li>
							<a class="thumb" name="leaf" href="uploads/images/subcate/<?php echo $row_subcate['image'];?>" width="75" height="75" title="<?php echo ucfirst($row_subcate['subcate']);?>">
								<img src="uploads/images/subcate/<?php echo $row_subcate['image'];?>" width="75" height="75" alt="<?php echo ucfirst($row_subcate['subcate']);?>" />
							</a>
							<div class="caption">
								<div class="image-title"><?php echo ucfirst($row_subcate['subcate']);?></div>
								<div class="image-desc"><?php echo ucfirst($row_subcate['description']);?></div>
							</div>
						</li>
						<?php
						}
						?>
					
					</ul>
				</div>
				<div style="clear: both;"></div>
			</div>
		</div>
		<div id="footer">&nbsp;</div>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				// We only want these styles applied when javascript is enabled
				$('div.navigation').css({'width' : '300px', 'float' : 'left'});
				$('div.content').css('display', 'block');

				// Initially set opacity on thumbs and add
				// additional styling for hover effect on thumbs
				var onMouseOutOpacity = 0.67;
				$('#thumbs ul.thumbs li').opacityrollover({
					mouseOutOpacity:   onMouseOutOpacity,
					mouseOverOpacity:  1.0,
					fadeSpeed:         'fast',
					exemptionSelector: '.selected'
				});
				
				// Initialize Advanced Galleriffic Gallery
				var gallery = $('#thumbs').galleriffic({
					delay:                     2500,
					numThumbs:                 15,
					preloadAhead:              10,
					enableTopPager:            true,
					enableBottomPager:         true,
					maxPagesToShow:            7,
					imageContainerSel:         '#slideshow',
					controlsContainerSel:      '#controls',
					captionContainerSel:       '#caption',
					loadingContainerSel:       '#loading',
					renderSSControls:          true,
					renderNavControls:         true,
					playLinkText:              'Play Slideshow',
					pauseLinkText:             'Pause Slideshow',
					prevLinkText:              '&lsaquo; Previous Photo',
					nextLinkText:              'Next Photo &rsaquo;',
					nextPageLinkText:          'Next &rsaquo;',
					prevPageLinkText:          '&lsaquo; Prev',
					enableHistory:             false,
					autoStart:                 false,
					syncTransitions:           true,
					defaultTransitionDuration: 900,
					onSlideChange:             function(prevIndex, nextIndex) {
						// 'this' refers to the gallery, which is an extension of $('#thumbs')
						this.find('ul.thumbs').children()
							.eq(prevIndex).fadeTo('fast', onMouseOutOpacity).end()
							.eq(nextIndex).fadeTo('fast', 1.0);
					},
					onPageTransitionOut:       function(callback) {
						this.fadeTo('fast', 0.0, callback);
					},
					onPageTransitionIn:        function() {
						this.fadeTo('fast', 1.0);
					}
				});
			});
		</script>
		<?php
		}
		else
		{
			echo "<br><p align='center'><font face='Trebuchet MS' size='2' color='#333333'><b>Photos in this category will be updated soon..</b></font></p>";
		}
		?>
<?php
	}
	else
	{
		echo "<br><p align='center'><font face='Trebuchet MS' size='2' color='#333333'><b>Unauthorize Access..</b></font></p>";
	}
}
else
{
	echo "<br><p align='center'><font face='Trebuchet MS' size='2' color='#333333'><b>Unauthorize Access..</b></font></p>";
}
?>