<?php
global $post_type;
global $post_type_name;
global $taxonomy_name;
global $product_terms;
global $postname;
?>
<!DOCTYPE html>
<html lang="ja">
<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php
	if( (is_front_page()) || is_page() || (is_archive() && !is_tax()) ){
		wp_title( '|', true, 'right' );
	}else{
		if (($post_type=='designer') && (is_single())){
			echo $postname.'　'.$post_type_name; ?> ｜ <?php bloginfo('name');
		}
	}?></title>

	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico" />

	<!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->

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
	  js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.6&appId=249560828415983";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

	<div id="page-top" class="page-top"></div><!-- /.page-top -->

		<header id="main-menu" class="main-menu">

			<div class="container">
				<div class="row">
					<div class="col-md-4 pull-left">
						<ul class="contact-list">
							<li>
								<a class="site-name" href="<?php echo home_url('/'); ?>">
									<h1><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="100人のデザイナー"></h1>
								</a>
							</li>
							<li class="logo-sub pctablet"><h1 class="f14">パンフレットデザインなら<br>100人のデザイナー</h1></li>
						</ul>
					</div>
					<div class="col-md-8">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu">
								<i class="fa fa-bars"></i>
							</button>
							<div class="menu-logo">
								<h1><a href="<?php echo home_url('/'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="100人のデザイナー"></a></h1>
							</div><!-- /.menu-logo -->
						</div>
						<table class="hd-submenu">
							<tr class="bg-black">
								<th colspan="2">お気軽にご相談・お問い合わせください</th>
							</tr>
							<tr>
								<td><img src="<?php echo get_template_directory_uri(); ?>/images/background/txt-tel_2016.png" alt="東京：03-6361-0717　大阪：06-7878-8049　名古屋：052-766-6396"></td>
								<td class="hd-tel"><a href="<?php echo home_url('/'); ?>contact/"><span><img src="<?php echo get_template_directory_uri(); ?>/images/background/icon-mail.png"></span> メールはこちら</a></td>
							</tr>
						</table>
					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->

			<?php if(is_front_page() || is_page('1142') || is_page('2')){ ?>
			<div id="mv-visual">
				<div class="main-txt testb"><img src="<?php echo get_template_directory_uri(); ?>/images/background/main_mv_2.png" alt="100人のデザイナーで最強のパンフレットを作る"></div>
			</div>
			<?php } ?>
			<section class="bt-gray">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<?php wp_nav_menu( array('menu'  => 'mainMenu', 'container' => 'nav','container_id' => 'menu','container_class' => 'nav-main mega-menu top', 'menu_id' => 'headernavigation','menu_class' => 'nav nav-pills nav-main navbar-nav' ) ); ?>
							<ul class="hd-submenu"><li><a href="http://chat.100pamphlet.jp/" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/nav/txt-login.jpg" alt="ログイン" /></a></li></ul>
						</div>
					</div><!-- /.row -->
				</div><!-- /.container -->
			</section>
			<div class="side-fixed pctablet">
				<a href="/contact/" ><img src="<?php echo get_template_directory_uri(); ?>/images/nav/anchor-contact3.png" alt="お問い合わせはメール・お電話で" /></a>
			</div>
		</header><!-- /#main-menu -->