<?php
/**
 * The template for displaying the footer
 *
 */
?>

<footer id="footer">
	<div id="footer-top" class="footer-top">
		<div class="container">
			<div class="f-social"><?php echo do_shortcode('[social4i size="small"]');?></div>
			<div class="row">
				<div class="col-sm-3 center mb-30">
					<div class="f-menu">
						<h3 class="bl-orange">メインコンテンツ</h3>
						<?php wp_nav_menu( array('menu'  => 'footerMenu' ) ); ?>
					</div>
				</div>
				<div class="col-sm-3 center mb-30">
					<div class="f-menu">
						<h3 class="bl-orange">制作パンフレットカテゴリ</h3>
						<?php wp_nav_menu( array('menu'  => 'footerMenu2' ) ); ?>
					</div>
				</div>
				<div class="col-sm-3 center mb-30">
					<div class="f-menu">
						<h3 class="bl-orange">サポート</h3>
						<?php wp_nav_menu( array('menu'  => 'footerMenu3' ) ); ?>
					</div>
				</div>
				<div class="col-sm-3 center mb-30">
					<div class="f-menu">
						<h3 class="bl-orange">会社情報</h3>
						<?php wp_nav_menu( array('menu'  => 'footerMenu4' ) ); ?>
					</div>
				</div>
			</div><!-- /.row -->
		</div><!-- /.container -->
	</div><!-- /#footer-top -->

	<div id="footer-bottom" class="footer-bottom text-center">
		<div class="container">
			<div class="col-xs-12">
				<div class="copyright">
				株式会社アセンダ<br>
				Copyright &copy; <?php echo date('Y'); ?> ASCENDA,INC. All rights reserved.
				</div><!-- /.copyright -->
			</div>
		</div>
	</div><!-- /#footer-bottom -->
</footer>

</div>

<!-- Include modernizr-2.8.3.min.js -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/modernizr-2.8.3.min.js"></script>

<!-- Include jquery.min.js plugin -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery-2.1.0.min.js"></script>

<!-- Google Maps Script -->
<script src="http://maps.google.com/maps/api/js?sensor=true"></script>

<!-- Gmap3.js For Static Maps -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/gmap3.js"></script>

<!-- Javascript Plugins  -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/plugins.js"></script>

<!-- Custom Functions  -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/functions.js"></script>

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/wow.min.js"></script>

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.ajaxchimp.min.js"></script>

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/gallery.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/lightbox.js"></script>

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/slidebars.js"></script>
<script>
  (function($) {
    $(document).ready(function() {
      $.slidebars();
    });
  }) (jQuery);
</script>

<?php wp_footer(); ?>

</body>
</html>

