<?php
global $product_terms;
global $taxonomy_name;
?>

	<div class="services">

		<?php if( get_field('service_block') ){
			while( has_sub_field('service_block') ){
				$service_title = get_sub_field('service_title');
				$service_content = get_sub_field('service_content');
		?>
		<div class="service-items">
			<h2 class="blog_detail-h-title"><?php echo $service_title;?></h2>
			<?php
				echo $service_content;?>
		</div>
		<?php 	}
		}?>

	</div>

