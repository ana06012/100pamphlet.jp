<?php

global $taxonomy_name;
global $post_type;
global $post_type_name;
$post_type = esc_html(get_post_type_object(get_post_type())->name);
$post_type_name = esc_html(get_post_type_object(get_post_type())->label );
$taxonomy_name = $post_type.'_cat';

$taxonomy_terms = wp_get_object_terms($post->ID, $taxonomy_name);
$taxonomy_terms_name = $taxonomy_terms[0]->name;
$taxonomy_terms_slug = $taxonomy_terms[0]->slug;
if($taxonomy_terms_slug=="top"){
	$taxonomy_terms_slug = $taxonomy_terms[1]->slug;
	$taxonomy_terms_name = $taxonomy_terms[1]->name;
}


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

					<?php if($taxonomy_terms_slug == 'result'){ ?>

						<div class="pages-title mt-20 mb-20"><h1 class="color-orange"><?php echo $post_type_name;?>実績一覧</h1></div>
						<p class="center">100人のデザイナーで制作した実績をご紹介。<br>
						画像をクリックすると詳細をご覧いただけます。</p>

						<?php
						$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
						$the_query = new WP_Query( array(
							'post_status' => 'publish',
							'post_type' => $post_type,
							'paged' => $paged,
							'posts_per_page' => 30, // 表示件数
							'tax_query' => array(
								array(
									'taxonomy' => $taxonomy_name,
									'field' => 'slug',
									'terms' => $taxonomy_terms_slug,
								),
							),
						) );


						if ($the_query->have_posts()) :

							$html_top_result='<div class="row mt-20">';

							while ($the_query->have_posts()) : $the_query->the_post();

								$post_type_name = esc_html(get_post_type_object(get_post_type())->label );
								$post_type_link = get_post_type_archive_link(get_post_type_object(get_post_type())->name ) ;
								$pamph_terms = wp_get_object_terms($post->ID, 'pamph_tag');
								$pamph_terms_name = $pamph_terms[0]->name;
								$pamph_terms_slug = $pamph_terms[0]->slug;
								$taxonomy_link = get_term_link( $pamph_terms[0]->slug, 'pamph_tag' );

								$image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium' );
								$image_url_hon = $image_url[0];

								$permalink_html = '<a href="'.get_the_permalink($post).'" >'.get_the_title($post).'</a>';

								$html_top_result .= '<div class="col-xs-6 col-sm-4">';
								$html_top_result .= '<a href="'.get_the_permalink($post).'" ><img src="'.$image_url_hon.'" /></a>
								<div class="result-box-150">
									<span class="orange-icon"><a href="'.$post_type_link.'result/">'.$post_type_name.'</a></span><br>
									<span class="black-icon"><a href="/pamph_tag/'.$pamph_terms_slug.'/">'.$pamph_terms_name.'</a></span><br>
								<a href="'.get_the_permalink($post).'" >'.get_the_title($post).'</a></div></div>';

							endwhile;

							$html_top_result .= '</div>';

						else :
							$html_top_result = '<div class="row mt-20" id="list"><div class="col-sm-12 mb-50">実績はありません。</div></div>';
						endif;

						echo $html_top_result;

					}else{ ?>

						<div class="pages-title mt-20 mb-20"><h2 class="color-orange"><?php echo $post_type_name;?><br>デザイン事例一覧</h2></div>
						<p class="center">デザインの事例をご紹介。<br>
						画像をクリックすると詳細をご覧いただけます。</p>

						<?php
						$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
						$the_query = new WP_Query( array(
							'post_status' => 'publish',
							'post_type' => $post_type,
							'paged' => $paged,
							'posts_per_page' => 30, // 表示件数
							'tax_query' => array(
								array(
									'taxonomy' => $taxonomy_name,
									'field' => 'slug',
									'terms' => $taxonomy_terms_slug,
								),
							),
						) );


						if ($the_query->have_posts()) :

							$html_top_result='<div class="row mt-20">';

							while ($the_query->have_posts()) : $the_query->the_post();

								$post_type_name = esc_html(get_post_type_object(get_post_type())->label );
								$post_type_link = get_post_type_archive_link(get_post_type_object(get_post_type())->name ) ;
								$pamph_terms = wp_get_object_terms($post->ID, 'pamph_tag');
								$pamph_terms_name = $pamph_terms[0]->name;
								$pamph_terms_slug = $pamph_terms[0]->slug;
								$taxonomy_link = get_term_link( $pamph_terms[0]->slug, 'pamph_tag' );

								$image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium' );
								$image_url_hon = $image_url[0];

								$permalink_html = '<a href="'.get_the_permalink($post).'" >'.get_the_title($post).'</a>';

								$html_top_result .= '<div class="col-xs-6 col-sm-4">';
								$html_top_result .= '<a href="'.get_the_permalink($post).'" ><img src="'.$image_url_hon.'" /></a>
								<div class="result-box-150">
									<span class="orange-icon"><a href="'.$post_type_link.'result/">'.$post_type_name.'</a></span><br>
								<a href="'.get_the_permalink($post).'" >'.get_the_title($post).'</a></div></div>';

							endwhile;

							$html_top_result .= '</div>';

						else :
							$html_top_result = '<div class="row mt-20" id="list"><div class="col-sm-12 mb-50">デザイン事例はありません。</div></div>';
						endif;

						echo $html_top_result;
					}?>

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