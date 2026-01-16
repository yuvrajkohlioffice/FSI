<style>
.section-title-style-2 h1{
    font-size: 16px!important;
    line-height: 2em!important;
}
</style>
<div class="section-title-style-2">
	<h1><?php 
	        $gallery_desc='';
			if( $category_id == "gallery" )
			{
				$galleryCate = mysql_fetch_array( mysql_query( "select category,description,category_hindi,description_hindi from photo_cate where status = 'active' and parentid = '$_GET[type]'"));
				echo $galleryCate['category_hindi'];
				$gallery_desc=$galleryCate['description_hindi'];
			}
		
		?></h1>
		
		<?php echo $gallery_desc;  ?>
</div>
<?php
$sub_query=mysql_query("select extraClass, image, subcate from photo_subcate where parentid='$_GET[type]' and status='active' order by sorder");
while($row_subcate=mysql_fetch_array($sub_query))
{
?>
<div class="col-lg-4 col-md-4 col-sm-6'">
	<div class="single-latest-project-gardener">
		<img src="../uploads/images/subcate/<?php echo $row_subcate['image'];?>" alt="<?php echo ucfirst($row_subcate['subcate']);?>">
		<div class="overlay">
			<div class="box-holder">
				<div class="content-box">
					<ul>
						<li><a href="../uploads/images/subcate/<?php echo $row_subcate['image'];?>" class="fancybox" data-fancybox-group="home-gallery" title="<?php echo ucfirst($row_subcate['subcate']);?>"><i class="fa fa-camera"></i></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
}
?>
        				
