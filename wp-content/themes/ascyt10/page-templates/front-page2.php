<?php
/**
 * Template Name: front-page(testB)
 *
 */
get_header(2); ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; // end of the loop. ?>
<?php get_footer(); ?>