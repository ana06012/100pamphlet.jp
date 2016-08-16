<?php

global $taxonomy_name;
global $post_type;
global $post_type_name;
global $taxonomy_terms_name;
global $terms;
$post_type = esc_html(get_post_type_object(get_post_type())->name);
$post_type_name = esc_html(get_post_type_object(get_post_type())->label );
$taxonomy_name = $post_type.'_cat';

$taxonomy_terms = wp_get_object_terms($post->ID, $taxonomy_name);
$taxonomy_terms_name = $taxonomy_terms[0]->name;
$taxonomy_terms_slug = $taxonomy_terms[0]->slug;
$term_id = $taxonomy_terms[0]->term_id;
$term_idsp = $taxonomy_name.'_'.$term_id; //カスタムフィールドを取得するのに必要なtermのIDは「taxonomyname_ + termID」
$pref_catch = get_field('pref_catch', $term_idsp);


// パラメータ
$args = array(
	'parent' => 0,
	'pad_counts' => false,
	'hide_empty' => true,
);
// カスタム分類のタームのリストを取得
$terms = get_terms( $taxonomy_name , $args );

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
						<div class="pages-title mt-10 mb-20"><h1 class="color-orange"><?php echo $taxonomy_terms_name;?></h1></div>
						<?php echo $pref_catch;?>

						<?php
						$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
						$the_query = new WP_Query( array(
							'post_status' => 'publish',
							'post_type' => $post_type,
							'paged' => $paged,
							'posts_per_page' => -1, // 表示件数
							'tax_query' => array(
								array(
									'taxonomy' => $taxonomy_name,
									'field' => 'slug',
									'terms' => $taxonomy_terms_slug,
								),
							),
						) );


						if ($the_query->have_posts()) :

							$html_top_result='';

							while ($the_query->have_posts()) : $the_query->the_post();

								if( get_field('d_address',$post->ID) ){
									$d_address = get_field('d_address',$post->ID);
								}
								if( get_field('d_url',$post->ID) ){
									$d_url = get_field('d_url',$post->ID);
								}
								if( get_field('d_strength',$post->ID) ){
									$d_strength = get_field('d_strength',$post->ID);
								}
								if( get_field('d_fee',$post->ID) ){
									$d_fee = get_field('d_fee',$post->ID);
								}

								$html_top_result .='<div class="mb-30"><div class="row mb-10">';
//								$html_top_result .= '<div class="col-sm-9">
								$html_top_result .= '<div class="col-sm-12">
									<h2 class="bl-orange">'.get_the_title($post).'<br>
									<span class="small">'.$d_address.'</span></h2></div>';
//								$html_top_result .= '<div class="col-sm-3 right">
//									<span class="orangeborder-icon"><a href="'.$d_url.'" target="_blank">Webサイト</a></span></div>';
								$html_top_result .= '</div><div class="row">';
								$html_top_result .= '<div class="col-sm-6"><div class="p-10">
									<h5 class="bb-gray mb-10"><strong>特徴</strong></h5>
									'.$d_strength.'</div></div>';
								$html_top_result .= '<div class="col-sm-6"><div class="p-10">
									<h5 class="bb-gray mb-10"><strong>料金</strong></h5>
									'.$d_fee.'</div></div>
									</div></div>';

							endwhile;
						endif;

						echo $html_top_result;
						?>

					<?php 	wp_reset_query();
					?>

					</div>
				</div>
				<div class="col-sm-3 pt-40">
					<?php get_sidebar("design_company"); ?>
				</div>
			</div><!-- /.row -->
		</div><!-- /.container -->
	</section><!-- /#top-contact -->
<?php get_footer(); ?>