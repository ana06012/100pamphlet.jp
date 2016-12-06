<?php
global $terms;
?>

<div id="secondary" class="widget-area side-block" role="complementary">

	<div class="side-menu">
		<h3 class="sidebox">お問い合わせ<span class="small">（無料）</span></h3>
		<div class="side-box">
			<p class="color-red fs-12 mb-0 pctablet"><span><img src="<?php echo get_template_directory_uri(); ?>/images/sidebar/txt-tel-2.png" style="width:20px;"></span> <strong>0120-555-875</strong></p>
			<p class="color-red fs-12 mb-0 onlysmart"><span><img src="<?php echo get_template_directory_uri(); ?>/images/sidebar/txt-tel-2.png" style="width:20px;"></span> <a href="tel:0120555875" class="color-orange"><strong>0120-555-875</strong></a></p>
			<p class="small">平日 10:00-18:00</p>
			<p class="color-black left mb-5 pctablet"><span class="tel-black-icon">東　京</span><br class="smallpc"> <strong>03-6361-0717</strong></p>
			<p class="color-black left mb-5 onlysmart"><span class="tel-black-icon">東　京</span> <a href="tel:0363610717" class="color-black"><strong>03-6361-0717</strong></a></p>
			<p class="color-black left mb-5 pctablet"><span class="tel-black-icon">大　阪</span><br class="smallpc"> <strong>06-7878-8049</strong></p>
			<p class="color-black left mb-5 onlysmart"><span class="tel-black-icon">大　阪</span> <a href="tel:0678788049" class="color-black"><strong>06-7878-8049</strong></a></p>
			<p class="color-black left pctablet"><span class="tel-black-icon">名古屋</span><br class="smallpc"> <strong>052-766-6396</strong></p>
			<p class="color-black left onlysmart"><span class="tel-black-icon">名古屋</span> <a href="tel:0527666396" class="color-black"><strong>052-766-6396</strong></a></p>
			<a href="/contact/" class="red-btn mb-5" ><span><img src="<?php echo get_template_directory_uri(); ?>/images/sidebar/icon-mail.png"></span> メールでのお問い合わせ</a>
		</div>

		<div class="side-box-b pl-0"><h3 class="bl-orange">エリア</h3></div>
		<div class="side-box">
			<ul>
				<?php if ( count( $terms ) != 0 ) {
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
						<li class="prodcat-title">
							<a href="<?php echo esc_url( $term_link ); ?>"><?php echo $term_name;?></a>
						</li>

					<?php }
					wp_reset_query(); ?>
				<?php } ?>

			</ul>
		</div>
	</div>

	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	<div class="side-banner">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div>
	<?php endif; ?>

</div><!-- #secondary -->