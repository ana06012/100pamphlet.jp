<?php

$image_id = get_post_thumbnail_id($post->ID);
$image_url = wp_get_attachment_image_src($image_id, 'full');
$page_ttl_avobe ='';
$page_ttl='';
$page_ttl_desc='';
if( get_field('page_ttl_avobe',$post->ID) ){
	$page_ttl_avobe = get_field('page_ttl_avobe',$post->ID);
}
 if( get_field('page_ttl',$post->ID) ){
	$page_ttl = get_field('page_ttl',$post->ID);
}
 if( get_field('page_ttl_desc',$post->ID) ){
	$page_ttl_desc = get_field('page_ttl_desc',$post->ID);
}

get_header(); ?>

<?php if($image_url){ ?>
	<div id="normal-visual" style="background-image: url(<?php echo $image_url[0]; ?>);">
		<div class="head-page-container">
			<div class="main-txt">
				<h1><span class="small color-white"><strong><?php echo $page_ttl_avobe; ?></strong></span><br>
				<?php echo $page_ttl; ?></h1>
				<?php echo $page_ttl_desc; ?>
			</div>
		</div>
	</div>
<?php } ?>
	<section id="main" class="main-contents <?php if(!$image_url){ ?>mf<?php } ?>">
		<div class="container">
  			<div class="row">
  				<div class="col-sm-9">
  					<?php if(!is_front_page()): ?>
					<div class="breadcrumbs">
						<?php if(function_exists('bcn_display'))
						{
							bcn_display();
						}?>
					</div>
					<?php endif; ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php the_content(); ?>
					<?php endwhile; // end of the loop. ?>
				</div>
				<div class="col-sm-3 pt-40">
					<?php get_sidebar("page"); ?>
				</div>
			</div><!-- /.row -->
		</div><!-- /.container -->
	</section><!-- /#top-contact -->
<?php get_footer(); ?>