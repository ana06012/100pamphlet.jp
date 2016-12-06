<?php
global $post_type;
global $post_type_name;
global $terms;
$post_type = esc_html(get_post_type_object(get_post_type())->name);
$post_type_name = esc_html(get_post_type_object(get_post_type())->label );

get_header();

$page_id = 7734; //表示したい固定ページのページID
$post = get_post( $page_id );

 ?>

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

					<div class="pages-block">
					<?php endif;

					echo apply_filters('the_content', $post->post_content); //固定ページの内容

					?>

						<table class="basic-t mt-20">
							<tbody><tr><th class="bg-lightorange">エリア</th><td>

						<?php // カスタム分類名
						$taxonomy = 'design_company_cat';

						// パラメータ
						$args = array(
							// 親タームのみ取得
							'parent' => 0,

							// 子タームの投稿数を親タームに含める
							'pad_counts' => false,

							// 投稿記事がないタームは取得しない
							'hide_empty' => true,
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
								$term_name = $term->name;

								$term_name = str_replace("のデザイン会社","",$term_name);

								// 親タームのURLと名称とカウントを出力
								?>
								<div class="col-xs-6 col-sm-3 mb-10">
									<a href="<?php echo esc_url( $term_link ); ?>"><?php echo $term_name;?></a>
								</div>

							<?php }
							wp_reset_query(); ?>
						<?php } ?>

							</td></tr></tbody>
						</table>
					</div>

				</div>
				<div class="col-sm-3 pt-40">
					<?php get_sidebar("design_company"); ?>
				</div>
			</div><!-- /.row -->
		</div><!-- /.container -->
	</section><!-- /#top-contact -->
<?php get_footer(); ?>
