<?php

global $product_terms;
global $taxonomy_name;
global $post_type;
global $post_type_name;
global $paged;
$post_type = esc_html(get_post_type_object(get_post_type())->name);
$post_type_name = esc_html(get_post_type_object(get_post_type())->label );

$term = array_pop(get_the_terms($post->ID, 'lab_cat'));
$term_p = $term->parent;
if ( ! $term_p == 0 ){
    $term = array_shift(get_the_terms($post->ID, 'lab_cat'));
}

$slug = $term->slug;

$product_terms = $term;
$taxonomy_name = $slug;

$term_name = $term->name;

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
						<h1 class="bg-<?php echo $taxonomy_name; ?> color-white mt-4 lab-sngl mb-20"><?php echo $term_name; ?></h1>

						<div class="row">

					<?php
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
					$the_query = new WP_Query( array(
							'post_status' => 'publish',
							'post_type' => $post_type,
							'paged' => $paged,
							'posts_per_page' => 12, // 表示件数
							'tax_query' => array(
									array(
											'taxonomy' => 'lab_cat',
											'field' => 'slug',
											'terms' => $taxonomy_name,
									),
							),
					) );

					if ($the_query->have_posts()){
						while ($the_query->have_posts()) : $the_query->the_post();

							$image_id = get_post_thumbnail_id($post->ID);
							$image_url = wp_get_attachment_image_src($image_id, 'medium');

							$term_slug = $taxonomy_name;


						 ?>

							<div class="col-xs-6 col-sm-4 mb-20">
								<div class="white-box p-10">
									<a href="<?php the_permalink(); ?>"><img src="<?php echo $image_url[0]; ?>" /></a>
									<div class="lab-title mt-10">
										<a href="<?php the_permalink(); ?>" ><?php the_title(); ?></a>
									</div>
								</div>
							</div>

						<?php endwhile;
					}else{ ?>
						<div class="col-xs-12 mb-20">記事はありません。</div>
					<?php } ?>
						</div>
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
					'total' => $the_query->max_num_pages,
					'mid_size' => 1,
					'current' => ($paged ? $paged : 1),
					'prev_text' => '<img src="'.get_template_directory_uri().'/images/nav/icon-prev.png"> PREV',
					'next_text' => 'NEXT <img src="'.get_template_directory_uri().'/images/nav/icon-next.png">',
					)); ?>
					</div>

				</div>

				<div class="col-sm-3 pt-40">
				<?php get_sidebar('lab'); ?>
				</div>
			</div>
		</div>
	</section>
<?php get_footer(); ?>