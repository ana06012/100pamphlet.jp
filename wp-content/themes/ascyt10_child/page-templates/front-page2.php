<?php
/**
 * Template Name: front-page(testB)
 *
 */
get_header(); ?>
	<?php if(is_front_page() || is_page('1142') || is_page('2')){ ?>
	<div id="mv-visual">
		<div class="main-txt"><img src="<?php echo get_template_directory_uri(); ?>/images/background/main_mv_1.png" alt="当社登録デザイナー100人の中から最適なデザインをご提案いたします。"></div>
	</div>
	<?php } ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; // end of the loop. ?>
<?php get_footer(); ?>