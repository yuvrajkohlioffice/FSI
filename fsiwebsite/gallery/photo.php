<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title>Galleriffic | Thumbnail rollover effects and slideshow crossfades</title>
		<link rel="stylesheet" href="css/basic.css" type="text/css" />
		<link rel="stylesheet" href="css/galleriffic-2.css" type="text/css" />
		<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
		<script type="text/javascript" src="js/jquery.galleriffic.js"></script>
		<script type="text/javascript" src="js/jquery.opacityrollover.js"></script>
		<!-- We only want the thunbnails to display when javascript is disabled -->
		<!--script type="text/javascript">
			document.write('<style>.noscript { display: none; }</style>');
		</script-->
	</head>
	<body>
		<div id="page" style="width: 854px;" align="center">
			<div id="container">
				

				<!-- Start Advanced Gallery Html Containers -->
				<div id="gallery" class="content">
					<div id="controls" class="controls"></div>
					<div class="slideshow-container">
						<div id="loading" class="loader" style="position: absolute; left: -55px; top: 0px; width:605px"></div>
						<div id="slideshow" class="slideshow"></div>
					</div>
					<div id="caption" class="caption-container"></div>
				</div>
				<div id="thumbs" class="navigation">
					<ul class="thumbs noscript">
						<li>
							<a class="thumb" name="leaf" href="images/a.jpg" width="75" height="75" >
								<img src="images/a.jpg" width="75" height="75"  />
							</a>
							
						</li>

						<li>
							<a class="thumb" name="drop" href="images/b.jpg" width="75" height="75">
								<img src="images/b.jpg" width="75" height="75" />
							</a>
							<div class="caption">
								&nbsp;</div>
						</li>

						<li>
							<a class="thumb" name="bigleaf" href="images/c.jpg" >
								<img src="images/c.jpg" width="75" height="75"  />
							</a>
							<div class="caption">
								
								&nbsp;</div>
						</li>

						<li>
							<a class="thumb" name="lizard" href="images/d.jpg">
								<img src="images/d.jpg" width="75" height="75" />
							</a>
							<div class="caption">
							
								&nbsp;</div>
						</li>

						<li>
							<a class="thumb" href="images/e.jpg" >
								<img src="images/e.jpg"  width="75" height="75" />
							</a>
							<div class="caption">
								
								&nbsp;</div>
						</li>

						<li>
							<a class="thumb" href="images/f.jpg" >
								<img src="images/f.jpg" width="75" height="75"  />
							</a>
							<div class="caption">
							
								&nbsp;</div>
						</li>

						<li>
							<a class="thumb" href="images/g.jpg" >
								<img src="images/g.jpg" width="75" height="75" />
							</a>
							<div class="caption">
								
								&nbsp;</div>
						</li>

						<li>
							<a class="thumb" href="images/h.jpg" >
								<img src="images/h.jpg" width="75" height="75"  />
							</a>
							<div class="caption">
							
								&nbsp;</div>
						</li>

						<li>
							<a class="thumb" href="images/i.jpg" >
								<img src="images/i.jpg" width="75" height="75" />
							</a>
							<div class="caption">
								
								&nbsp;</div>
						</li>

						<li>
							<a class="thumb" href="images/j.jpg" >
								<img src="images/j.jpg" width="75" height="75"  />
							</a>
							<div class="caption">
							
								&nbsp;</div>
						</li>

						<li>
							<a class="thumb" href="images/k.jpg">
								<img src="images/k.jpg" width="75" height="75"  />
							</a>
							<div class="caption">
							
								&nbsp;</div>
						</li>

						<li>
							<a class="thumb" href="images/l.jpg">
								<img src="images/l.jpg" width="75" height="75" />
							</a>
							<div class="caption">
								
								&nbsp;</div>
						</li>

						<li>
							<a class="thumb" href="images/m.jpg" >
								<img src="images/m.jpg" width="75" height="75"  />
							</a>
							<div class="caption">
								
								&nbsp;</div>
						</li>

						<li>
							<a class="thumb" href="images/n.jpg" >
								<img src="images/n.jpg" width="75" height="75"   />
							</a>
							</li>

						<li>
							<a class="thumb" href="images/o.jpg">
								<img src="images/o.jpg" width="75" height="75"  />
							</a>
							</li>

						<li>
							<a class="thumb" href="images/p.jpg" >
								<img src="images/p.jpg" width="75" height="75"   />
							</a>
							</li>
							
							<li>
							<a class="thumb" href="images/q.jpg" >
								<img src="images/q.jpg" width="75" height="75"  />
							</a>
							</li>
<li>
							<a class="thumb" href="images/r.jpg" >
								<img src="images/r.jpg" width="75" height="75"   />
							</a>
							</li>
					
					<li>
							<a class="thumb" href="images/s.jpg" >
								<img src="images/s.jpg" width="75" height="75"  />
							</a>
							</li>
							
							
							<li>
							<a class="thumb" href="images/t.jpg" >
								<img src="images/t.jpg" width="75" height="75"  />
							</a>
							</li>
							<li>
							<a class="thumb" href="images/u.jpg" >
								<img src="images/u.jpg" width="75" height="75"   />
							</a>
							</li>

							
							
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
	</body>
</html>