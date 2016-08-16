<?php
	global $cur_cat;

	$cat = get_the_category();
	$cur_cat = $cat[0];
	while ( $cur_cat->parent )
		$cur_cat = get_category( $cur_cat->parent );

get_header(); ?>
	<section id="main" class="main-contents mf">
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
					<div class="pages-block">
  						<div class="pages-title mt-10 mb-20">
  							<div class="bb-gray"><h1 class="bl-orange"><?php the_title(); ?></h1></div>
  						</div>
  						<div class="col-sm-12">
							<?php while ( have_posts() ) : the_post(); ?>

								<?php get_template_part( 'content', get_post_format() ); ?>

							<?php endwhile; // end of the loop. ?>
							<div class="pnavi">
								<span class="previous"><?php previous_post_link('%link', '<img src="'.get_template_directory_uri().'/images/nav/icon-prev.png"> PREV', TRUE); ?></span>
								<span class="next"><?php next_post_link('%link', 'NEXT <img src="'.get_template_directory_uri().'/images/nav/icon-next.png">', TRUE); ?></span>
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-3 pt-40">
				<?php get_sidebar(); ?>
				</div>
			</div>
		</div>
	</section>
<?php get_footer(); ?>