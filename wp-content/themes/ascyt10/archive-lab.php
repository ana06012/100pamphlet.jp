<?php
global $post_type;
global $post_type_name;
$post_type = esc_html(get_post_type_object(get_post_type())->name);
$post_type_name = esc_html(get_post_type_object(get_post_type())->label );

get_header(); ?>

	<div id="lab-visual">
		<div class="main-txt pctablet"><h1><img src="<?php echo get_template_directory_uri(); ?>/images/background/mv_txt_pc.png" alt="パンフレットデザインLab"></h1></div>
		<div class="main-txt onlysmart"><h1><img src="<?php echo get_template_directory_uri(); ?>/images/background/mv_txt_sp.png" alt="パンフレットデザインLab"></h1></div>
	</div>

	<section id="main" class="main-contents">
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
						<div class="row mt-4">

						<?php if ( have_posts() ) :
							while ( have_posts() ) : the_post();

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

							<div class="col-sm-6 col-md-4 mb-20">
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

							<?php endwhile;
							endif; ?>
						</div>

						<div class="pnavi">
							<?php
							global $wp_rewrite;
							$paginate_base = get_pagenum_link(1);
							if(strpos($paginate_base, '?') || ! $wp_rewrite->using_permalinks()){
							$paginate_format = '';
							$paginate_base = add_query_arg('paged','%#%');
							}
							else{
							$paginate_format = (substr($paginate_base,-1,1) == '/' ? '' : '/') .
							user_trailingslashit('page/%#%/','paged');
							$paginate_base .= '%_%';
							}
							echo paginate_links(array(
							'base' => $paginate_base,
							'format' => $paginate_format,
							'total' => $wp_query->max_num_pages,
							'mid_size' => 1,
							'current' => ($paged ? $paged : 1),
							'prev_text' => '<img src="'.get_template_directory_uri().'/images/nav/icon-prev.png"> PREV',
							'next_text' => 'NEXT <img src="'.get_template_directory_uri().'/images/nav/icon-next.png">',
							)); ?>
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