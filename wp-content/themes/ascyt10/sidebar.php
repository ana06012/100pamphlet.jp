<?php

global $cur_cat;
global $cur_top;

/* 追加2015.6 */
$cat = get_my_bottom_category();
$cat_id = $cat->cat_ID;
$cat_name = $cat->cat_name;
?>

<div id="secondary" class="widget-area side-block" role="complementary">

	<div class="side-menu">
		<div class="side-box-b pl-0"><h3 class="bl-orange">最近の<?php
					if($cur_top==1){
						echo $cur_cat->cat_name;
					}elseif($cur_top==0 || is_single()){
						echo $cat_name;
					}
					 ?></h3></div>
		 <div class="side-box">
			<?php if($cur_top==1){
				$args = array( 'numberposts' => 5,'category' => $cur_cat->cat_ID, 'orderby' => 'desc');
			}elseif($cur_top==0 || is_single()){
				$args = array( 'numberposts' => 5,'category' => $cat_id, 'orderby' => 'desc');
			}
			$posts = get_posts( $args );
			?>
			<ul>
			<?php foreach($posts as $post){

				setup_postdata( $post );
			?>

				<li class="prodcat-title">
				<a href="<?php the_permalink(); ?>"><span class="small"><?php the_time('Y年m月d日'); ?></span><br><?php the_title(); ?></a></li>

			<?php
			}
			wp_reset_query(); ?>
			</ul>
		</div>
	</div>


	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	<div class="side-banner">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div>
	<?php endif; ?>

</div><!-- #secondary -->