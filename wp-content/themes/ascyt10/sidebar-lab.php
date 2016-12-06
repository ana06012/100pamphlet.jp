<?php
global $post_type;
?>

<div id="secondary" class="widget-area side-block" role="complementary">

	<div class="side-menu">
		<div class="side-box-b bg-black color-white"><h3>カテゴリー</h3></div>
		<div class="side-box p-5">
			<ul>
				<li class="lab-menu bg-lab_design"><a href="/lab/lab_design/" class="color-white"><i class="fa fa-caret-right" aria-hidden="true"></i> パンフレットデザイン</a></li>
				<li class="lab-menu bg-lab_frame"><a href="/lab/lab_frame/" class="color-white"><i class="fa fa-caret-right" aria-hidden="true"></i> パンフレットの構成</a></li>
				<li class="lab-menu bg-lab_howto"><a href="/lab/lab_howto/" class="color-white"><i class="fa fa-caret-right" aria-hidden="true"></i> パンフレットの作り方</a></li>
				<li class="lab-menu bg-lab_print"><a href="/lab/lab_print/" class="color-white"><i class="fa fa-caret-right" aria-hidden="true"></i> 印刷</a></li>
				<li class="lab-menu bg-lab_sales"><a href="/lab/lab_sales/" class="color-white"><i class="fa fa-caret-right" aria-hidden="true"></i> 売上向上</a></li>
				<li class="lab-menu bg-lab_others"><a href="/lab/lab_others/" class="color-white"><i class="fa fa-caret-right" aria-hidden="true"></i> その他</a></li>
			</ul>
		</div>
	</div>

	<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
	<div class="side-banner">
		<?php dynamic_sidebar( 'sidebar-2' ); ?>
	</div>
	<?php endif; ?>

</div><!-- #secondary -->