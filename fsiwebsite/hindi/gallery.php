
                    	<?php
        			    $sub_query=mysql_query("select parentid, category, image, category_hindi from photo_cate where status='active' order by parentid desc");
                        while($row_subcate=mysql_fetch_array($sub_query))
                        {
                        ?>
        				<div class="col-lg-4 col-md-4 col-sm-6'">
        					<div class="single-latest-project-gardener" style="height:346px;">
        						<img src="../uploads/images/category/<?php echo $row_subcate['image'];?>" alt="<?php echo ucfirst($row_subcate['subcate']);?>">
        						<div class="overlay">
        							<div class="box-holder">
        								<div class="content-box">
        									<ul>
        										<li><a href="gallery&type=<?php echo $row_subcate['parentid'];?>" title="<?php echo ucfirst($row_subcate['subcate']);?>"><i class="fa fa-link"></i></a></li>
        									</ul>
        								</div>
        							</div>
        						</div>
        						<h3 style="text-align: center;"><?php echo ucfirst($row_subcate['category_hindi']);?></h3>
        					</div>
        				</div>
        				<?php
        				}
        				?>
        				