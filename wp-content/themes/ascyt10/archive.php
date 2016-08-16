<?php
global $cur_cat;
global $cur_top;

$cur_top=1;
$cur_cat = get_category( intval( get_query_var('cat') ) );
while ( $cur_cat->parent ){
  $cur_cat = get_category( $cur_cat->parent );
  $cur_top=0;
}
get_header(); ?>
	<section id="main" class="main-contents mf">
		<div class="container">
			<div class="row">
				<div class="col-sm-9">
					<div class="breadcrumbs">
						<?php if(function_exists('bcn_display'))
						{
							bcn_display();
						}?>
					</div>
					<div class="pages-block">
						<div class="pages-title mt-20 mb-20"><h1><?php single_cat_title( ); ?>一覧</h1></div>

						<table class="foot-news">

						<?php if ( have_posts() ) :
						while ( have_posts() ) : the_post();

							$time = get_post_time('Y年m月d日');
						 ?>
							<tr><td class="date"><?php echo $time ?></td><td class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></td></tr>

						<?php endwhile;
						endif; ?>

						</table>


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
						'total' => $wp_query->max_num_pages,
						'mid_size' => 1,
						'current' => ($paged ? $paged : 1),
						'prev_text' => '<img src="'.get_template_directory_uri().'/images/nav/icon-prev.png"> PREV',
						'next_text' => 'NEXT <img src="'.get_template_directory_uri().'/images/nav/icon-next.png">',
						)); ?>
						</div>

					</div>

				</div>

				<div class="col-sm-3 pt-40">
				<?php get_sidebar(); ?>
				</div>
			</div>
		</div>
	</section>
<?php get_footer(); ?>