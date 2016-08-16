<?php
global $post_type_name;
global $post_type_link;
global $pamph_terms_name;
global $pamph_terms_slug;
?>

	<div class="services">
		<div class="row">
		<?php
		$my_upload_images = get_post_meta( $post->ID, 'my_upload_images', true );
		if ( $my_upload_images ){
			$i=0;
			foreach( $my_upload_images as $key => $img_id ){
				if ($i<3){
					$thumb_src = wp_get_attachment_image_src ($img_id,'thumbnail');
					$full_src = wp_get_attachment_image_src ($img_id,'medium');
					if ( !$img_title = get_the_title($img_id) ) $img_title = get_the_title( $post->ID );
					echo
					'<div class="col-sm-4">
						<img src="'.$full_src[0].'" />
					</div>';
				}
				$i++;
			}
		}?>
		</div>

		<div class="float-right"><?php echo do_shortcode('[social4i size="small"]');?></div>
		<div class="clearfix"></div>
		<div class="entry">
			<?php if(get_field('pamph_title')){ ?>
			<h3 class="mb-10"><?php echo get_field('pamph_title'); ?></h3>
			<?php } ?>
			<?php the_content(); ?>

			<?php if($post_type='web' && get_field('web_url')){ ?>
			<span class="orangeborder-icon"><a href="<?php echo get_field('web_url');?>" target="_blank" class="color-black">このWebサイトを閲覧する</a></span>
			<?php } ?>

			<div class="bg-lightgray p-20 mt-20 mb-20">
				<table class="pamph-cat">
					<tr><th><img src="<?php echo get_template_directory_uri(); ?>/images/contents/txt-cat.png"></th>
					<td><a href="<?php echo $post_type_link;?>"><?php echo $post_type_name;?></a></td></tr>
					<tr><th><img src="<?php echo get_template_directory_uri(); ?>/images/contents/txt-type.png"></th>
					<td><a href="/pamph_tag/<?php echo $pamph_terms_slug;?>/"><?php echo $pamph_terms_name;?></a></td></tr>
				</table>
			</div>
		</div>

	</div>

