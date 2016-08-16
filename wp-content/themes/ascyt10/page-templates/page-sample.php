<?php
/**
 * Template Name: sample page
 *
 */
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

					<?php while ( have_posts() ) : the_post(); ?>
						<?php the_content(); ?>
					<?php endwhile; // end of the loop.
					wp_reset_query();


					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
					$the_query = new WP_Query( array(
						'post_status' => 'publish',
						'post_type' => array('pamph_catalog','pamph_company','pamph_clinic','pamph_recruit','pamph_school'),
						'paged' => $paged,
						'posts_per_page' => 30, // 表示件数
						'tax_query' => array(
							'relation' => 'OR',
							array(
								'taxonomy' => 'pamph_catalog_cat',
								'field' => 'slug',
								'terms' => 'example',
							),
							array(
								'taxonomy' => 'pamph_company_cat',
								'field' => 'slug',
								'terms' => 'example',
							),
							array(
								'taxonomy' => 'pamph_clinic_cat',
								'field' => 'slug',
								'terms' => 'example',
							),
							array(
								'taxonomy' => 'pamph_recruit_cat',
								'field' => 'slug',
								'terms' => 'example',
							),
							array(
								'taxonomy' => 'pamph_school_cat',
								'field' => 'slug',
								'terms' => 'example',
							),
						),
					) );


					if ($the_query->have_posts()) :

						$html_top_result='<div class="row mt-20">';

						while ($the_query->have_posts()) : $the_query->the_post();

							$post_type_name = esc_html(get_post_type_object(get_post_type())->label );
							$post_type_link = get_post_type_archive_link(get_post_type_object(get_post_type())->name );
							$product_terms = wp_get_object_terms($post->ID, 'pamph_tag');
							$taxonomy_name = $product_terms[0]->name;
							$taxonomy_slug = $product_terms[0]->slug;
							$taxonomy_link = get_term_link( $product_terms[0]->slug, 'pamph_tag' );

							$image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium' );
							$image_url_hon = $image_url[0];

							$permalink_html = '<a href="'.get_the_permalink($post).'" >'.get_the_title($post).'</a>';

							$html_top_result .= '<div class="col-xs-6 col-sm-4">';
							$html_top_result .= '<a href="'.get_the_permalink($post).'" ><img src="'.$image_url_hon.'" /></a>
							<div class="result-box-150">
								<span class="orange-icon"><a href="'.$post_type_link.'example/">'.$post_type_name.'</a></span><br>
							<a href="'.get_the_permalink($post).'" >'.get_the_title($post).'</a></div></div>';

						endwhile;

						$html_top_result .= '</div>';

					else :
						$html_top_result = '<div class="row mt-20" id="list"><div class="col-sm-12 mb-50">現在登録されている事例はありません。</div></div>';
					endif;

					echo $html_top_result;?>

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

					<?php 	wp_reset_query();
					?>

				</div>
				<div class="col-sm-3 pt-40">
					<?php get_sidebar("page"); ?>
				</div>
			</div><!-- /.row -->
		</div><!-- /.container -->
	</section><!-- /#top-contact -->
<?php get_footer(); ?>