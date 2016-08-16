<?php
/**
 * Template Name: full-width
 *
 */
get_header(); ?>

	<section id="main" class="main-contents mf">
		<div class="container">
  			<div class="row">
  				<div class="col-sm-12">
  					<?php if(!is_front_page()): ?>
					<div class="breadcrumbs">
						<?php if(function_exists('bcn_display'))
						{
							bcn_display();
						}?>
					</div>
					<?php endif;

					while ( have_posts() ) : the_post(); ?>
					<?php the_content(); ?>
					<?php endwhile; // end of the loop. ?>
				</div>
			</div><!-- /.row -->
		</div><!-- /.container -->
	</section><!-- /#top-contact -->
<?php get_footer(); ?>
