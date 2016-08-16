<?php
/**
 * The template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

global $wpdb;
$keyword = get_search_query();
get_header(); ?>
	<section id="main" class="main-contents mf">
		<div class="container">
			<div class="breadcrumbs">
				<?php if(function_exists('bcn_display'))
				{
					bcn_display();
				}?>
			</div>
			<div class="row">
				<div class="col-sm-9">
					<div class="pages-block">
						<div class="pages-title"><h1>
						<?php if ($keyword==''){
							echo '製品一覧';
						}else{
							echo '『'.$keyword.'』に一致する製品一覧';
						} ?></h1></div>

						<?php
						// If you use a custom search form
						// $keyword = sanitize_text_field( $_POST['keyword'] );
						// If you use default WordPress search form
						$keyword = '%' . $wpdb->esc_like( $keyword ) . '%'; // Thanks Manny Fleurmond
						// Search in all custom fields
						$post_ids_meta = $wpdb->get_col( $wpdb->prepare( "
						    SELECT DISTINCT post_id FROM {$wpdb->postmeta}
						    WHERE meta_value LIKE '%s'
						", $keyword ) );
						// Search in post_title and post_content
						$post_ids_post = $wpdb->get_col( $wpdb->prepare( "
						    SELECT DISTINCT ID FROM {$wpdb->posts}
						    WHERE post_title LIKE '%s'
						    OR post_content LIKE '%s'
						", $keyword, $keyword ) );
						$post_ids = array_merge( $post_ids_meta, $post_ids_post );
						// Query arguments

						if ($post_ids){
							$args = array(
								'post_type'   => 'pamph_company',
								'post_status' => 'publish',
								'post__in'    => $post_ids,
								'meta_key' => 'order_num',
								'orderby'     => 'meta_value_num',
								'order'	=>	'ASC'
							);
							$query = new WP_Query( $args );


							if ( $query->have_posts() ){

								$picked_post_ids = NULL;
								while ( $query->have_posts() ){
									$query->the_post();
									$picked_post_ids[] = get_the_ID();
								}

								// カスタム分類名
								$taxonomy = 'pamph_company_cat';

								// パラメータ
								$args = array(
									// 親タームのみ取得
									'parent' => 0,

									// 子タームの投稿数を親タームに含める
									'pad_counts' => false,

									// 投稿記事がないタームは取得しない
									'hide_empty' => true,
									'orderby'=> 'order'
								);

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

										$posts = get_posts( array(
											'post_type' => 'pamph_company',
											'taxonomy' => $taxonomy,
											'term' => $slug,
											'posts_per_page' => -1,
											'meta_key' => 'order_num',
											'orderby'     => 'meta_value_num',
											'order'	=>	'ASC'
										));

										if ($posts){

											$go_title = 0;
											foreach($posts as $post){

												setup_postdata( $post );
												$ID = get_the_ID($post);

												if ($ID!='120'){
													foreach ($picked_post_ids as $p_ids){
														if($p_ids == $ID){
															$go_title = 1;
														}
													}
												}
											}
											wp_reset_query();

											if ($go_title == 1){
												// 親タームのURLと名称
												echo '<h2 class="title-'.$slug.'"><a href="' . esc_url( $term_link ) . '">' . $term->name . '</a></h2>
													<div class="row">';
												foreach($posts as $post){

													setup_postdata( $post );
													$ID = get_the_ID($post);

													$go = 0;
													if ($ID!='120'){
														foreach ($picked_post_ids as $p_ids){
															if($p_ids == $ID){
																$go = 1;
															}
														}
													}
													if($go == 1){
											?>
													<div class="col-sm-6">
														<h3 class="prodcat-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
													</div>
											<?php
													}
												}
												wp_reset_query(); ?>
												</div>
											<?php
											}
										}
									}
								}

							}else{

								echo '検索キーワードに一致する製品はありません。';

							}
						}else{

							echo '検索キーワードに一致する製品はありません。';

						} ?>
					</div>
				</div>
				<div class="col-sm-3">
				</div>
			</div>
		</div>
	</section>
<?php get_footer(); ?>