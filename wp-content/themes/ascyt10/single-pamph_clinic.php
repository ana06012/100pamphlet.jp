<?php

global $post_type;
global $post_type_name;
global $post_type_link;
global $pamph_terms_name;
global $pamph_terms_slug;

$post_type = esc_html(get_post_type_object(get_post_type())->name);
$post_type_name = esc_html(get_post_type_object(get_post_type())->label );
$post_type_link = get_post_type_archive_link($post_type ) ;
$taxonomy_name = $post_type.'_cat';
$pamph_cats = wp_get_object_terms($post->ID, $taxonomy_name);
$pamph_cats_name = $pamph_cats[0]->name;
$pamph_cats_slug = $pamph_cats[0]->slug;
if($pamph_cats_slug=="top"){
	$pamph_cats_slug = $pamph_cats[1]->slug;
	$pamph_cats_name = $pamph_cats[1]->name;
}

$pamph_terms = wp_get_object_terms($post->ID, 'pamph_tag');
$pamph_terms_name = $pamph_terms[0]->name;
$pamph_terms_slug = $pamph_terms[0]->slug;
$taxonomy_link = get_term_link( $pamph_terms[0]->slug, 'pamph_tag' );


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

					<div class="pages-title mt-20 mb-20"><h1 class="result-title"><?php the_title(); ?></h1></div>
					<?php if ($pamph_cats_slug=='result'){
						while ( have_posts() ) : the_post();
					?>
						<?php get_template_part( 'content-result', get_post_format() ); ?>
					<?php endwhile; // end of the loop.
					 }else{
					 	while ( have_posts() ) : the_post();
					?>
						<?php //get_template_part( 'content-content', get_post_format() ); ?>
						<?php get_template_part( 'content-example', get_post_format() ); ?>
					<?php endwhile; // end of the loop.
					 } ?>

					<div class="pages-block">
						<div class="pages-title"><h3><?php echo 'その他の'.$pamph_cats_name; ?>を見る</h3></div>

						<div class="row clearfix">

						<?php
						$posts = get_posts( array(
							'post_status' => 'publish',
							'post_type' => $post_type,
							'posts_per_page' => 6,
							'tax_query' => array(
								array(
									'taxonomy' => $taxonomy_name,
									'field' => 'slug',
									'terms' => $pamph_cats_slug,
								),
							),
							'exclude' => $post->ID,
							'orderby' => 'rand'
						));


						foreach($posts as $post){
							setup_postdata( $post );
							$pamph_terms_post = wp_get_object_terms($post->ID, 'pamph_tag');
							$pamph_terms_name_post = $pamph_terms_post[0]->name;
							$pamph_terms_slug_post = $pamph_terms_post[0]->slug;
							$taxonomy_link_post = get_term_link( $pamph_terms_post[0]->slug, 'pamph_tag' );
							$image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium' );
							$image_url_hon = $image_url[0];
						?>
							<div class="col-xs-6 col-sm-4">
								<a href="<?php the_permalink(); ?>"><img src="<?php echo $image_url_hon; ?>" /></a>
								<div class="result-box-150">
									<span class="orange-icon"><a href="<?php echo $post_type_link; ?><?php echo $pamph_cats_slug; ?>/"><?php echo $post_type_name; ?></a></span><br>
									<?php if($pamph_cats_slug=='result'){ ?>
									<span class="black-icon"><a href="/pamph_tag/<?php echo $pamph_terms_slug_post;?>/"><?php echo $pamph_terms_name_post; ?></a></span><br>
									<?php } ?>
									<a href="<?php echo get_the_permalink($post); ?>" ><?php echo get_the_title($post); ?></a>
								</div>
							</div>

						<?php } ?>

						</div>
					</div>

					<div class="pages-block">
						 <div class="bg-lightgray pt-50 pb-50">
							<p class="center large"><strong>ご相談・ご訪問無料です。お気軽にご相談ください。</strong></p>
							<table class="foot-contact"><tbody><tr><td>
							<p class="superultralarge lh1 color-red pctablet"><img src="http://100pamphlet.jp/wp-content/uploads/2016/04/icon-tel.png" alt="icon-tel" class="size-full wp-image-331" /> <strong>0120-555-875</strong></p><p class="superultralarge lh1 color-red onlysmart"><img src="http://100pamphlet.jp/wp-content/uploads/2016/04/icon-tel.png" alt="icon-tel" class="size-full wp-image-331" /> <a href="tel:0120555875" class="color-red"><strong>0120-555-875</strong></a></p></td><td><p>受付時間<br>
							平日 10:00~18:00</p></td>
							</tr></tbody></table>
							<table class="foot-contact"><tbody><tr><td><p class="color-black pctablet"><span class="tel-black-icon">東　京</span> <strong>03-6361-0717</strong></p><p class="color-black onlysmart"><span class="tel-black-icon">東　京</span> <a href="tel:0363610717" class="color-black"><strong>03-6361-0717</strong></a></p></td><td><p class="color-black pctablet"><span class="tel-black-icon">大　阪</span> <strong>06-7878-8049</strong></p><p class="color-black onlysmart"><span class="tel-black-icon">大　阪</span> <a href="tel:0678788049" class="color-black"><strong>06-7878-8049</strong></a></p></td><td><p class="color-black pctablet"><span class="tel-black-icon">名古屋</span> <strong>052-766-6396</strong></p><p class="color-black onlysmart"><span class="tel-black-icon">名古屋</span> <a href="tel:0527666396" class="color-black"><strong>052-766-6396</strong></a></p></td></tr></tbody></table>

							<div class="mt-20"><a href="/contact/" class="red-btn"><span><img src="http://100pamphlet.jp/wp-content/uploads/2016/04/icon-mail.png" alt="icon-mail" class="size-full wp-image-338" /></span> メールでのお問い合わせ</a></div>
						</div>
					</div>

				</div>

				<div class="col-sm-3 pt-40">
				<?php get_sidebar('page'); ?>
				</div>
			</div>
		</div>
	</section>
<?php get_footer(); ?>