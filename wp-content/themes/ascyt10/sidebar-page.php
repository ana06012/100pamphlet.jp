<?php
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

		<div class="side-box-b pl-0"><h3 class="bl-orange">制作内容から探す</h3></div>
		<div class="side-box">
			<ul>
				<li class="prodcat-title"><a href="/pamph/">すべて</a></li>
				<li class="prodcat-title"><a href="/pamph_company/result/">会社案内パンフレット</a></li>
				<li class="prodcat-title"><a href="/pamph_catalog/result/">カタログ</a></li>
				<li class="prodcat-title"><a href="/pamph_school/result/">学校案内・入学案内</a></li>
				<li class="prodcat-title"><a href="/pamph_recruit/result/">採用パンフレット</a></li>
				<li class="prodcat-title"><a href="/pamph_clinic/result/">病院・クリニックパンフレット</a></li>
				<li class="prodcat-title"><a href="/web/result/">Webサイト</a></li>
			</ul>
		</div>

		<div class="side-box-b pl-0"><h3 class="bl-orange">仕様から探す</h3></div>
		<div class="side-box">
			<ul>
				<li class="prodcat-title"><a href="/pamph/">すべて</a></li>
				<li class="prodcat-title"><a href="/pamph_tag/saddle/">中とじパンフレット</a></li>
				<li class="prodcat-title"><a href="/pamph_tag/leaflet/">三つ折パンフレット（リーフレット）</a></li>
				<li class="prodcat-title"><a href="/pamph_tag/poster/">チラシ・ポスター</a></li>
				<li class="prodcat-title"><a href="/pamph_tag/folder/">フォルダ</a></li>
			</ul>
		</div>

		<div class="side-box-b pl-0"><h3 class="bl-orange">パンフレット制作<br>ラインナップ</h3></div>
		<div class="side-box">
			<ul>
				<li class="prodcat-title"><a href="/pamph_company/">会社案内パンフレット</a></li>
				<li class="prodcat-title"><a href="/pamph_catalog/">カタログ</a></li>
				<li class="prodcat-title"><a href="/pamph_school/">学校案内・入学案内</a></li>
				<li class="prodcat-title"><a href="/pamph_recruit/">採用パンフレット</a></li>
				<li class="prodcat-title"><a href="/pamph_clinic/">病院・クリニックパンフレット</a></li>
				<li class="prodcat-title"><a href="/web/">Webサイト</a></li>
			</ul>
		</div>
	</div>

	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	<div class="side-banner">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div>
	<?php endif; ?>

</div><!-- #secondary -->