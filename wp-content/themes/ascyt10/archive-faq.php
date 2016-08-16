<?php

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
					<?php endif;?>

					<div class="pages-title mt-20 mb-20"><h1 class="color-orange">よくある質問</h1></div>
					<?php

						// カスタム分類名
						$taxonomy = 'faq_cat';

						// パラメータ
						$args = array(

							// 子タームの投稿数を親タームに含める
							'pad_counts' => false,

							// 投稿記事がないタームは取得しない
							'hide_empty' => true,
							'orderby'=> 'order',
							'exclude'=> array('22'),
						);

						$terms = '';
						// カスタム分類のタームのリストを取得
						$terms = get_terms( $taxonomy , $args );

						if ( count( $terms ) != 0 ) {

							// 親タームのリスト $terms を $term に格納してループ
							foreach ( $terms as $term ) {

								// 親タームのURLを取得
								$term = sanitize_term( $term, $taxonomy );
								$term_link = get_term_link( $term, $taxonomy );
								if ( is_wp_error( $term_link ) ) {
									continue;
								}

								$slug = $term->slug;

								// 親タームのURLと名称とカウントを出力
								echo '<h2 class="obi-orange-faq mt-20 mb-10">' . $term->name . '</h2>';

								$posts = get_posts( array(
									'post_type' => 'faq',
									'taxonomy' => $taxonomy,
									'term' => $slug,
									'posts_per_page' => -1,
									'meta_key' => 'order_num',
									'orderby'     => 'meta_value_num',
									'order'	=>	'ASC'
								));

								foreach($posts as $post){

									setup_postdata( $post );
									$ID = get_the_ID($post);

									$title = get_the_title();
									$content = apply_filters('the_content',get_the_content());

									$toggle = '[toggle title="'.$title.'"]<div class="faq-answer">
											<table><tbody><tr>
											<th class="color-orange">A</th><td>'.$content.'</td>
											</tr></tbody></table>
										</div>[/toggle]';

									echo do_shortcode($toggle);

								}
								wp_reset_query(); ?>
							<?php }
						} ?>

				</div>

				<div class="col-sm-3 pt-40">
				<?php get_sidebar("page"); ?>
				</div>
			</div>
		</div>
	</section>
<?php get_footer(); ?>