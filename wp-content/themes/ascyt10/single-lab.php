<?php

global $product_terms;
global $taxonomy_name;
global $post_type;
global $post_type_name;
$post_type = esc_html(get_post_type_object(get_post_type())->name);
$post_type_name = esc_html(get_post_type_object(get_post_type())->label );
$product_terms = wp_get_object_terms($post->ID, 'lab_cat');
$taxonomy_name = $product_terms[0]->slug;
$term_name = $product_terms[0]->name;


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
  						<h1 class="bg-<?php echo $taxonomy_name; ?> color-white mt-4 lab-sngl"><?php the_title(); ?></h1>

  						<div class="float-right mt-10"><?php echo do_shortcode('[social4i size="small"]');?></div>
  						<div class="clearfix"></div>
						<?php while ( have_posts() ) : the_post();
						?>
							<?php get_template_part( 'content-lab', get_post_format() ); ?>
						<?php endwhile; ?>

						<div class="pnavi">
							<span class="previous"><?php previous_post_link('%link', '<img src="'.get_template_directory_uri().'/images/nav/icon-prev.png"> PREV'); ?></span>
							<span class="next"><?php next_post_link('%link', 'NEXT <img src="'.get_template_directory_uri().'/images/nav/icon-next.png">'); ?></span>
						</div>
					</div>

					<div class="pages-block">

						<div class="row clearfix">

						<?php
						$posts = get_posts( array(
							'post_type' => $post_type,
							'taxonomy' => $post_type.'_cat',
							'term' => $taxonomy_name,
							'posts_per_page' => 4,
							'orderby'     => 'date',
							'order'	=>	'DESC',
							'exclude' => $post->ID
						));


						foreach($posts as $post){
							setup_postdata( $post );

							$image_id = get_post_thumbnail_id($post->ID);
							$image_url = wp_get_attachment_image_src($image_id, 'medium');

							$term = array_pop(get_the_terms($post->ID, 'lab_cat'));
							$term_p = $term->parent;
							if ( ! $term_p == 0 ){
								$term = array_shift(get_the_terms($post->ID, 'lab_cat'));
							}

							$term_name = $term->name;
							$term_slug = $term->slug;

						?>

							<div class="col-xs-6 col-sm-4 mb-20">
								<div class="white-box p-10">
									<a href="<?php the_permalink(); ?>"><img src="<?php echo $image_url[0]; ?>" /></a>
									<div class="lab-title mt-10">
										<a href="<?php the_permalink(); ?>" ><?php the_title(); ?></a>
									</div>
									<div class="lab-cat">
										<h5 class="color-<?php echo $term_slug; ?> mt-10">■ <a href="/lab/<?php echo $term_slug; ?>/" class="color-<?php echo $term_slug; ?>"><?php echo $term_name; ?></a></h5>
									</div>
								</div>
							</div>
						<?php } ?>

						</div>

					</div>


				</div>

				<div class="col-sm-3 pt-40">
				<?php get_sidebar('lab'); ?>
				</div>
			</div>
		</div>
	</section>
<?php get_footer(); ?>