<?php
global $post_type;
global $post_type_name;
global $taxonomy_name;
global $product_terms;
?>
<!DOCTYPE html>
<html lang="ja">
<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>

	<!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->

	<link rel="stylesheet" type="text/css" href="http://mplus-fonts.sourceforge.jp/webfonts/basic_latin/mplus_webfonts.css">
	<link rel="stylesheet" type="text/css" href="http://mplus-fonts.sourceforge.jp/webfonts/general-j/mplus_webfonts.css">

	<!-- Bootstrap  -->
	<link href="<?php echo get_template_directory_uri(); ?>/assets/css/bootstrap.min.css" rel="stylesheet">

	<!-- icon fonts font Awesome -->
	<link href="<?php echo get_template_directory_uri(); ?>/assets/css/font-awesome.min.css" rel="stylesheet">

	<!-- Import Magnific Pop Up Styles -->
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/magnific-popup.css">

	<!-- Import Custom Styles -->
	<link href="<?php echo get_template_directory_uri(); ?>/assets/css/custom.css" rel="stylesheet">
	<link href="<?php echo get_template_directory_uri(); ?>/assets/css/style.css" rel="stylesheet">

	<link href="<?php echo get_template_directory_uri(); ?>/assets/css/lightbox.css" rel="stylesheet">

	<!-- Import Animate Styles -->
	<link href="<?php echo get_template_directory_uri(); ?>/assets/css/animate.min.css" rel="stylesheet">

	<!-- Import owl.carousel Styles -->
	<link href="<?php echo get_template_directory_uri(); ?>/assets/css/owl.carousel.css" rel="stylesheet">

	<!-- Import Custom Responsive Styles -->
	<link href="<?php echo get_template_directory_uri(); ?>/assets/css/responsive.css" rel="stylesheet">

	<!--[if IE]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/footerFixed.js"></script>

	<?php wp_head(); ?>
</head>

<body>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.5&appId=249560828415983";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

	<div class="sb-slidebar sb-right">
		<?php wp_nav_menu( array('menu'  => 'sp-menu', 'container' => 'nav','container_id' => '','container_class' => '', 'menu_id' => 'headernavigation','menu_class' => 'sb-menu','link_before'=>'<i class="fa fa-arrow-right" aria-hidden="true"></i>　' ) ); ?>
	</div>

	<div id="sb-site" class="mm-page">

		<header id="main-menu" class="main-menu">

			<div class="container">

				<div class="row">
					<div class="col-xs-4">
						<a class="site-name" href="<?php echo home_url('/'); ?>">
							<img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="100人のパンフレットデザイナー">
						</a>
					</div>
					<div class="col-xs-6">
						<ul class="hd-submenu">
							<li class="hd-tel"><a href="tel:0120555875" class="color-orange"><span><img src="<?php echo get_template_directory_uri(); ?>/images/sp/btn-tel.png"></span></a></li>
							<li class="hd-tel"><a href="<?php echo home_url('/'); ?>contact/"><span><img src="<?php echo get_template_directory_uri(); ?>/images/sp/btn-mail.png"></span></a></li>
						</ul>
					</div>
					<div class="col-xs-2">
						<div class="menu sb-toggle-right"><a href=""><i class="fa fa-bars"></i></a></div>

					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->
		</header><!-- /#main-menu -->