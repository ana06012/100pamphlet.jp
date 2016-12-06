<?php
/**
 * Twenty Twelve functions and definitions
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, @link http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

// Set up the content width value based on the theme's design and stylesheet.
if ( ! isset( $content_width ) )
	$content_width = 625;

/**
 * Twenty Twelve setup.
 *
 * Sets up theme defaults and registers the various WordPress features that
 * Twenty Twelve supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add a Visual Editor stylesheet.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links,
 * 	custom background, and post formats.
 * @uses register_nav_menu() To add support for navigation menus.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_setup() {
	/*
	 * Makes Twenty Twelve available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Twenty Twelve, use a find and replace
	 * to change 'twentytwelve' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'twentytwelve', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// This theme supports a variety of post formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status' ) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'twentytwelve' ) );

	/*
	 * This theme supports custom background color and image,
	 * and here we also set up the default background color.
	 */
	add_theme_support( 'custom-background', array(
		'default-color' => 'e6e6e6',
	) );

	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop
}
add_action( 'after_setup_theme', 'twentytwelve_setup' );


add_action('wp_enqueue_scripts', 'mnky_scripts');
function mnky_scripts() {
// Main stylesheet
	wp_register_style( 'main', get_stylesheet_uri());
	wp_enqueue_style( 'main' );
}

/**
 * Return the Google font stylesheet URL if available.
 *
 * The use of Open Sans by default is localized. For languages that use
 * characters not supported by the font, the font can be disabled.
 *
 * @since Twenty Twelve 1.2
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function twentytwelve_get_font_url() {
	$font_url = '';

	/* translators: If there are characters in your language that are not supported
	 * by Open Sans, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'twentytwelve' ) ) {
		$subsets = 'latin,latin-ext';

		/* translators: To add an additional Open Sans character subset specific to your language,
		 * translate this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language.
		 */
		$subset = _x( 'no-subset', 'Open Sans font: add new subset (greek, cyrillic, vietnamese)', 'twentytwelve' );

		if ( 'cyrillic' == $subset )
			$subsets .= ',cyrillic,cyrillic-ext';
		elseif ( 'greek' == $subset )
			$subsets .= ',greek,greek-ext';
		elseif ( 'vietnamese' == $subset )
			$subsets .= ',vietnamese';

		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => 'Open+Sans:400italic,700italic,400,700',
			'subset' => $subsets,
		);
		$font_url = add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" );
	}

	return $font_url;
}

/**
 * Enqueue scripts and styles for front-end.
 *
 * @since Twenty Twelve 1.0
 *
 * @return void
 */
//function twentytwelve_scripts_styles() {
//	global $wp_styles;
//
//	/*
//	 * Adds JavaScript to pages with the comment form to support
//	 * sites with threaded comments (when in use).
//	 */
//	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
//		wp_enqueue_script( 'comment-reply' );
//
//	// Adds JavaScript for handling the navigation menu hide-and-show behavior.
//	wp_enqueue_script( 'twentytwelve-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '1.0', true );
//
//	$font_url = twentytwelve_get_font_url();
//	if ( ! empty( $font_url ) )
//		wp_enqueue_style( 'twentytwelve-fonts', esc_url_raw( $font_url ), array(), null );
//
//	// Loads our main stylesheet.
//	wp_enqueue_style( 'twentytwelve-style', get_stylesheet_uri() );
//
//	// Loads the Internet Explorer specific stylesheet.
//	wp_enqueue_style( 'twentytwelve-ie', get_template_directory_uri() . '/css/ie.css', array( 'twentytwelve-style' ), '20121010' );
//	$wp_styles->add_data( 'twentytwelve-ie', 'conditional', 'lt IE 9' );
//}
//add_action( 'wp_enqueue_scripts', 'twentytwelve_scripts_styles' );

/**
 * Filter TinyMCE CSS path to include Google Fonts.
 *
 * Adds additional stylesheets to the TinyMCE editor if needed.
 *
 * @uses twentytwelve_get_font_url() To get the Google Font stylesheet URL.
 *
 * @since Twenty Twelve 1.2
 *
 * @param string $mce_css CSS path to load in TinyMCE.
 * @return string Filtered CSS path.
 */
function twentytwelve_mce_css( $mce_css ) {
	$font_url = twentytwelve_get_font_url();

	if ( empty( $font_url ) )
		return $mce_css;

	if ( ! empty( $mce_css ) )
		$mce_css .= ',';

	$mce_css .= esc_url_raw( str_replace( ',', '%2C', $font_url ) );

	return $mce_css;
}
add_filter( 'mce_css', 'twentytwelve_mce_css' );

/**
 * Filter the page title.
 *
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since Twenty Twelve 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function twentytwelve_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'twentytwelve' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'twentytwelve_wp_title', 10, 2 );

/**
 * Filter the page menu arguments.
 *
 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) )
		$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'twentytwelve_page_menu_args' );

/**
 * Register sidebars.
 *
 * Registers our main widget area and the front page widget areas.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'twentytwelve' ),
		'id' => 'sidebar-1',
		'description' => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'twentytwelve' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
			'name' => 'lab sidebar',
			'id' => 'sidebar-2',
			'description' => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'twentytwelve' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
	) );

}
add_action( 'widgets_init', 'twentytwelve_widgets_init' );

if ( ! function_exists( 'twentytwelve_content_nav' ) ) :
/**
 * Displays navigation to next/previous pages when applicable.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_content_nav( $html_id ) {
	global $wp_query;

	$html_id = esc_attr( $html_id );

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $html_id; ?>" class="navigation" role="navigation">
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> 前へ', 'twentytwelve' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( '次へ <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ); ?></div>
		</nav><!-- #<?php echo $html_id; ?> .navigation -->
	<?php endif;
}
endif;

if ( ! function_exists( 'twentytwelve_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentytwelve_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Twelve 1.0
 *
 * @return void
 */
function twentytwelve_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'twentytwelve' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 44 );
					printf( '<cite><b class="fn">%1$s</b> %2$s</cite>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span>' . __( 'Post author', 'twentytwelve' ) . '</span>' : ''
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'twentytwelve' ), get_comment_date(), get_comment_time() )
					);
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentytwelve' ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', 'twentytwelve' ), '<p class="edit-link">', '</p>' ); ?>
			</section><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'twentytwelve' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;

if ( ! function_exists( 'twentytwelve_entry_meta' ) ) :
/**
 * Set up post entry meta.
 *
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own twentytwelve_entry_meta() to override in a child theme.
 *
 * @since Twenty Twelve 1.0
 *
 * @return void
 */
function twentytwelve_entry_meta() {
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'twentytwelve' ) );

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'twentytwelve' ) );

	$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'twentytwelve' ), get_the_author() ) ),
		get_the_author()
	);

	// Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
	if ( $tag_list ) {
		$utility_text = __( 'This entry was posted in %1$s and tagged %2$s on %3$s<span class="by-author"> by %4$s</span>.', 'twentytwelve' );
	} elseif ( $categories_list ) {
		$utility_text = __( 'This entry was posted in %1$s on %3$s<span class="by-author"> by %4$s</span>.', 'twentytwelve' );
	} else {
		$utility_text = __( 'This entry was posted on %3$s<span class="by-author"> by %4$s</span>.', 'twentytwelve' );
	}

	printf(
		$utility_text,
		$categories_list,
		$tag_list,
		$date,
		$author
	);
}
endif;

/**
 * Extend the default WordPress body classes.
 *
 * Extends the default WordPress body class to denote:
 * 1. Using a full-width layout, when no active widgets in the sidebar
 *    or full-width template.
 * 2. Front Page template: thumbnail in use and number of sidebars for
 *    widget areas.
 * 3. White or empty background color to change the layout and spacing.
 * 4. Custom fonts enabled.
 * 5. Single or multiple authors.
 *
 * @since Twenty Twelve 1.0
 *
 * @param array $classes Existing class values.
 * @return array Filtered class values.
 */
function twentytwelve_body_class( $classes ) {
	$background_color = get_background_color();
	$background_image = get_background_image();

	if ( ! is_active_sidebar( 'sidebar-1' ) || is_page_template( 'page-templates/full-width.php' ) )
		$classes[] = 'full-width';

	if ( is_page_template( 'page-templates/front-page.php' ) ) {
		$classes[] = 'template-front-page';
		if ( has_post_thumbnail() )
			$classes[] = 'has-post-thumbnail';
		if ( is_active_sidebar( 'sidebar-2' ) && is_active_sidebar( 'sidebar-3' ) )
			$classes[] = 'two-sidebars';
	}

	if ( empty( $background_image ) ) {
		if ( empty( $background_color ) )
			$classes[] = 'custom-background-empty';
		elseif ( in_array( $background_color, array( 'fff', 'ffffff' ) ) )
			$classes[] = 'custom-background-white';
	}

	// Enable custom font class only if the font CSS is queued to load.
	if ( wp_style_is( 'twentytwelve-fonts', 'queue' ) )
		$classes[] = 'custom-font-enabled';

	if ( ! is_multi_author() )
		$classes[] = 'single-author';

	return $classes;
}
add_filter( 'body_class', 'twentytwelve_body_class' );

/**
 * Adjust content width in certain contexts.
 *
 * Adjusts content_width value for full-width and single image attachment
 * templates, and when there are no active widgets in the sidebar.
 *
 * @since Twenty Twelve 1.0
 *
 * @return void
 */
function twentytwelve_content_width() {
	if ( is_page_template( 'page-templates/full-width.php' ) || is_attachment() || ! is_active_sidebar( 'sidebar-1' ) ) {
		global $content_width;
		$content_width = 960;
	}
}
add_action( 'template_redirect', 'twentytwelve_content_width' );

/**
 * Register postMessage support.
 *
 * Add postMessage support for site title and description for the Customizer.
 *
 * @since Twenty Twelve 1.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 * @return void
 */
function twentytwelve_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'twentytwelve_customize_register' );

/* カスタム投稿タイプの追加 */
add_action( 'init', 'create_post_type' );
function create_post_type() {

	register_post_type( 'pamph_company', /* post-type */
		array(
			'labels' => array(
				'name' => __( '会社案内パンフレット制作' ),
				'singular_name' => __( '会社案内パンフレット制作' ),
				'all_items' => '会社案内パンフレット制作一覧',
				'add_new' => '会社案内パンフレット制作追加',
				'add_new_item' => '会社案内パンフレット制作の追加',
				'edit_item' => '会社案内パンフレット制作の編集',
				'new_item' => '会社案内パンフレット制作追加',
				'view_item' => '会社案内パンフレット制作を表示',
				'search_items' => '会社案内パンフレット制作を検索',
				'not_found' =>  '会社案内パンフレット制作が見つかりません',
				'not_found_in_trash' => 'ゴミ箱内に会社案内パンフレット制作が見つかりませんでした。',
				'parent_item_colon' => ''
			),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => true,
			'hierarchical' => false,
			'supports' => array('title','editor','thumbnail'),
			'menu_position' =>5,
			'has_archive' => true,
			'rewrite' => array(
				'slug' => 'pamph_company','with_front' => false)
		)
	);

	register_post_type( 'pamph_catalog', /* post-type */
		array(
			'labels' => array(
				'name' => __( 'カタログ制作' ),
				'singular_name' => __( 'カタログ制作' ),
				'all_items' => 'カタログ制作一覧',
				'add_new' => 'カタログ制作追加',
				'add_new_item' => 'カタログ制作の追加',
				'edit_item' => 'カタログ制作の編集',
				'new_item' => 'カタログ制作追加',
				'view_item' => 'カタログ制作を表示',
				'search_items' => 'カタログ制作を検索',
				'not_found' =>  'カタログ制作が見つかりません',
				'not_found_in_trash' => 'ゴミ箱内にカタログ制作が見つかりませんでした。',
				'parent_item_colon' => ''
			),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => true,
			'hierarchical' => false,
			'supports' => array('title','editor','thumbnail'),
			'menu_position' =>5,
			'has_archive' => true,
			'rewrite' => array(
				'slug' => 'pamph_catalog','with_front' => false)
		)
	);

	register_post_type( 'pamph_school', /* post-type */
		array(
			'labels' => array(
				'name' => __( '学校案内・入学案内制作' ),
				'singular_name' => __( '学校案内・入学案内制作' ),
				'all_items' => '学校案内・入学案内制作一覧',
				'add_new' => '学校案内・入学案内制作追加',
				'add_new_item' => '学校案内・入学案内制作の追加',
				'edit_item' => '学校案内・入学案内制作の編集',
				'new_item' => '学校案内・入学案内制作追加',
				'view_item' => '学校案内・入学案内制作を表示',
				'search_items' => '学校案内・入学案内制作を検索',
				'not_found' =>  '学校案内・入学案内制作が見つかりません',
				'not_found_in_trash' => 'ゴミ箱内に学校案内・入学案内制作が見つかりませんでした。',
				'parent_item_colon' => ''
			),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => true,
			'hierarchical' => false,
			'supports' => array('title','editor','thumbnail'),
			'menu_position' =>5,
			'has_archive' => true,
			'rewrite' => array(
				'slug' => 'pamph_school','with_front' => false)
		)
	);

	register_post_type( 'pamph_recruit', /* post-type */
		array(
			'labels' => array(
				'name' => __( '採用パンフレット制作' ),
				'singular_name' => __( '採用パンフレット制作' ),
				'all_items' => '採用パンフレット制作一覧',
				'add_new' => '採用パンフレット制作追加',
				'add_new_item' => '採用パンフレット制作の追加',
				'edit_item' => '採用パンフレット制作の編集',
				'new_item' => '採用パンフレット制作追加',
				'view_item' => '採用パンフレット制作を表示',
				'search_items' => '採用パンフレット制作を検索',
				'not_found' =>  '採用パンフレット制作が見つかりません',
				'not_found_in_trash' => 'ゴミ箱内に採用パンフレット制作が見つかりませんでした。',
				'parent_item_colon' => ''
			),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => true,
			'hierarchical' => false,
			'supports' => array('title','editor','thumbnail'),
			'menu_position' =>5,
			'has_archive' => true,
			'rewrite' => array(
				'slug' => 'pamph_recruit','with_front' => false)
		)
	);


	register_post_type( 'pamph_clinic', /* post-type */
		array(
			'labels' => array(
				'name' => __( '病院・クリニックパンフレット制作' ),
				'singular_name' => __( '病院・クリニックパンフレット制作' ),
				'all_items' => '病院・クリニックパンフレット制作一覧',
				'add_new' => '病院・クリニックパンフレット制作追加',
				'add_new_item' => '病院・クリニックパンフレット制作の追加',
				'edit_item' => '病院・クリニックパンフレット制作の編集',
				'new_item' => '病院・クリニックパンフレット制作追加',
				'view_item' => '病院・クリニックパンフレット制作を表示',
				'search_items' => '病院・クリニックパンフレット制作を検索',
				'not_found' =>  '病院・クリニックパンフレット制作が見つかりません',
				'not_found_in_trash' => 'ゴミ箱内に病院・クリニックパンフレット制作が見つかりませんでした。',
				'parent_item_colon' => ''
			),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => true,
			'hierarchical' => false,
			'supports' => array('title','editor','thumbnail'),
			'menu_position' =>5,
			'has_archive' => true,
			'rewrite' => array(
				'slug' => 'pamph_clinic','with_front' => false)
		)
	);


	/* タクソノミー カテゴリ追加 */
	register_taxonomy('pamph_company_cat','pamph_company', array(
		'hierarchical' => true,
		'labels' => array(
			'name' => 'カテゴリ',
			'singular_name' => 'カテゴリ',
			'search_items' =>  'カテゴリを検索',
			'all_items' => 'すべてのカテゴリ',
			'parent_item' => '親分類',
			'parent_item_colon' => '親分類：',
			'edit_item' => '編集',
			'update_item' => '更新',
			'add_new_item' => 'カテゴリを追加',
			'new_item_name' => '名前',
		),
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array(
			'slug' => 'pamph_company','with_front' => true)
	));
	/* タクソノミー カテゴリ追加 */
	register_taxonomy('pamph_catalog_cat','pamph_catalog', array(
		'hierarchical' => true,
		'labels' => array(
			'name' => 'カテゴリ',
			'singular_name' => 'カテゴリ',
			'search_items' =>  'カテゴリを検索',
			'all_items' => 'すべてのカテゴリ',
			'parent_item' => '親分類',
			'parent_item_colon' => '親分類：',
			'edit_item' => '編集',
			'update_item' => '更新',
			'add_new_item' => 'カテゴリを追加',
			'new_item_name' => '名前',
		),
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array(
			'slug' => 'pamph_catalog','with_front' => true)
	));
	/* タクソノミー カテゴリ追加 */
	register_taxonomy('pamph_school_cat','pamph_school', array(
		'hierarchical' => true,
		'labels' => array(
			'name' => 'カテゴリ',
			'singular_name' => 'カテゴリ',
			'search_items' =>  'カテゴリを検索',
			'all_items' => 'すべてのカテゴリ',
			'parent_item' => '親分類',
			'parent_item_colon' => '親分類：',
			'edit_item' => '編集',
			'update_item' => '更新',
			'add_new_item' => 'カテゴリを追加',
			'new_item_name' => '名前',
		),
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array(
			'slug' => 'pamph_school','with_front' => true)
	));
	/* タクソノミー カテゴリ追加 */
	register_taxonomy('pamph_recruit_cat','pamph_recruit', array(
		'hierarchical' => true,
		'labels' => array(
			'name' => 'カテゴリ',
			'singular_name' => 'カテゴリ',
			'search_items' =>  'カテゴリを検索',
			'all_items' => 'すべてのカテゴリ',
			'parent_item' => '親分類',
			'parent_item_colon' => '親分類：',
			'edit_item' => '編集',
			'update_item' => '更新',
			'add_new_item' => 'カテゴリを追加',
			'new_item_name' => '名前',
		),
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array(
			'slug' => 'pamph_recruit','with_front' => true)
	));
	/* タクソノミー カテゴリ追加 */
	register_taxonomy('pamph_clinic_cat','pamph_clinic', array(
		'hierarchical' => true,
		'labels' => array(
			'name' => 'カテゴリ',
			'singular_name' => 'カテゴリ',
			'search_items' =>  'カテゴリを検索',
			'all_items' => 'すべてのカテゴリ',
			'parent_item' => '親分類',
			'parent_item_colon' => '親分類：',
			'edit_item' => '編集',
			'update_item' => '更新',
			'add_new_item' => 'カテゴリを追加',
			'new_item_name' => '名前',
		),
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array(
			'slug' => 'pamph_clinic','with_front' => true)
	));

	register_post_type( 'web', /* post-type */
		array(
				'labels' => array(
						'name' => __( 'Webサイト制作' ),
						'singular_name' => __( 'Webサイト制作' ),
						'all_items' => 'Webサイト制作一覧',
						'add_new' => 'Webサイト制作追加',
						'add_new_item' => 'Webサイト制作の追加',
						'edit_item' => 'Webサイト制作の編集',
						'new_item' => 'Webサイト制作追加',
						'view_item' => 'Webサイト制作を表示',
						'search_items' => 'Webサイト制作を検索',
						'not_found' =>  'Webサイト制作が見つかりません',
						'not_found_in_trash' => 'ゴミ箱内にWebサイト制作が見つかりませんでした。',
						'parent_item_colon' => ''
				),
				'public' => true,
				'publicly_queryable' => true,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => true,
				'hierarchical' => false,
				'supports' => array('title','editor','thumbnail'),
				'menu_position' =>20,
				'has_archive' => true,
				'rewrite' => array(
						'slug' => 'web','with_front' => false)
		)
		);
	/* タクソノミー カテゴリ追加 */
	register_taxonomy('web_cat','web', array(
			'hierarchical' => true,
			'labels' => array(
					'name' => 'カテゴリ',
					'singular_name' => 'カテゴリ',
					'search_items' =>  'カテゴリを検索',
					'all_items' => 'すべてのカテゴリ',
					'parent_item' => '親分類',
					'parent_item_colon' => '親分類：',
					'edit_item' => '編集',
					'update_item' => '更新',
					'add_new_item' => 'カテゴリを追加',
					'new_item_name' => '名前',
			),
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array(
					'slug' => 'web','with_front' => true)
	));

	register_post_type( 'logo', /* post-type */
			array(
					'labels' => array(
							'name' => __( 'ロゴ制作' ),
							'singular_name' => __( 'ロゴ制作' ),
							'all_items' => 'ロゴ制作一覧',
							'add_new' => 'ロゴ制作追加',
							'add_new_item' => 'ロゴ制作の追加',
							'edit_item' => 'ロゴ制作の編集',
							'new_item' => 'ロゴ制作追加',
							'view_item' => 'ロゴ制作を表示',
							'search_items' => 'ロゴ制作を検索',
							'not_found' =>  'ロゴ制作が見つかりません',
							'not_found_in_trash' => 'ゴミ箱内にロゴ制作が見つかりませんでした。',
							'parent_item_colon' => ''
					),
					'public' => true,
					'publicly_queryable' => true,
					'show_ui' => true,
					'query_var' => true,
					'rewrite' => true,
					'hierarchical' => false,
					'supports' => array('title','editor','thumbnail'),
					'menu_position' =>25,
					'has_archive' => true,
					'rewrite' => array(
							'slug' => 'logo','with_front' => false)
			)
			);
	/* タクソノミー カテゴリ追加 */
	register_taxonomy('logo_cat','logo', array(
			'hierarchical' => true,
			'labels' => array(
					'name' => 'カテゴリ',
					'singular_name' => 'カテゴリ',
					'search_items' =>  'カテゴリを検索',
					'all_items' => 'すべてのカテゴリ',
					'parent_item' => '親分類',
					'parent_item_colon' => '親分類：',
					'edit_item' => '編集',
					'update_item' => '更新',
					'add_new_item' => 'カテゴリを追加',
					'new_item_name' => '名前',
			),
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array(
					'slug' => 'logo','with_front' => true)
	));

	/* カスタムタクソノミー タグ追加 */
	register_taxonomy('pamph_tag', array('pamph_company','pamph_catalog','pamph_school','pamph_recruit','pamph_clinic','web','logo'), array(
		'hierarchical' => true,
		'labels' => array(
			'name' => '仕様',
			'singular_name' => '仕様',
			'search_items' =>  '仕様を検索',
			'all_items' => 'すべての仕様',
			'parent_item' => '親分類',
			'parent_item_colon' => '親分類：',
			'edit_item' => '編集',
			'update_item' => '更新',
			'add_new_item' => '仕様を追加',
			'new_item_name' => '名前',
		),
		'show_ui' => true,
		'query_var' => true,

	));



	register_post_type( 'designer', /* post-type */
		array(
			'labels' => array(
				'name' => __( 'デザイナーポートフォリオ' ),
				'singular_name' => __( 'デザイナーポートフォリオ' ),
				'all_items' => 'デザイナーポートフォリオ一覧',
				'add_new' => 'デザイナーポートフォリオ追加',
				'add_new_item' => 'デザイナーポートフォリオの追加',
				'edit_item' => 'デザイナーポートフォリオの編集',
				'new_item' => 'デザイナーポートフォリオ追加',
				'view_item' => 'デザイナーポートフォリオを表示',
				'search_items' => 'デザイナーポートフォリオを検索',
				'not_found' =>  'デザイナーポートフォリオが見つかりません',
				'not_found_in_trash' => 'ゴミ箱内にデザイナーポートフォリオが見つかりませんでした。',
				'parent_item_colon' => ''
			),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => true,
			'hierarchical' => false,
			'supports' => array('title','thumbnail'),
			'menu_position' =>35,
			'has_archive' => true,
			'rewrite' => array(
				'slug' => 'designer','with_front' => false)
		)
	);

	register_post_type( 'faq', /* post-type */
		array(
			'labels' => array(
				'name' => __( 'よくある質問' ),
				'singular_name' => __( 'よくある質問' ),
				'all_items' => 'よくある質問一覧',
				'add_new' => 'よくある質問追加',
				'add_new_item' => 'よくある質問の追加',
				'edit_item' => 'よくある質問の編集',
				'new_item' => 'よくある質問追加',
				'view_item' => 'よくある質問を表示',
				'search_items' => 'よくある質問を検索',
				'not_found' =>  'よくある質問が見つかりません',
				'not_found_in_trash' => 'ゴミ箱内によくある質問が見つかりませんでした。',
				'parent_item_colon' => ''
			),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => true,
			'hierarchical' => false,
			'supports' => array('title','editor'),
			'menu_position' =>40,
			'has_archive' => true,
			'rewrite' => array(
				'slug' => 'faq','with_front' => false)
		)
	);
	/* タクソノミー カテゴリ追加 */
	register_taxonomy('faq_cat','faq', array(
		'hierarchical' => true,
		'labels' => array(
			'name' => 'よくある質問カテゴリ',
			'singular_name' => 'よくある質問カテゴリ',
			'search_items' =>  'よくある質問カテゴリを検索',
			'all_items' => 'すべてのよくある質問カテゴリ',
			'parent_item' => '親分類',
			'parent_item_colon' => '親分類：',
			'edit_item' => '編集',
			'update_item' => '更新',
			'add_new_item' => 'よくある質問カテゴリを追加',
			'new_item_name' => '名前',
		),
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array(
			'slug' => 'faq','with_front' => false)
	));


	register_post_type( 'design_company', /* post-type */
		array(
			'labels' => array(
				'name' => __( 'デザイン会社一覧' ),
				'singular_name' => __( 'デザイン会社一覧' ),
				'all_items' => 'デザイン会社一覧',
				'add_new' => 'デザイン会社追加',
				'add_new_item' => 'デザイン会社の追加',
				'edit_item' => 'デザイン会社の編集',
				'new_item' => 'デザイン会社追加',
				'view_item' => 'デザイン会社一覧を表示',
				'search_items' => 'デザイン会社を検索',
				'not_found' =>  'デザイン会社が見つかりません',
				'not_found_in_trash' => 'ゴミ箱内にデザイン会社が見つかりませんでした。',
				'parent_item_colon' => ''
			),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => true,
			'hierarchical' => false,
			'supports' => array('title','editor','thumbnail'),
			'menu_position' =>45,
			'has_archive' => true,
			'rewrite' => array(
				'slug' => 'design_company','with_front' => false)
		)
	);

	/* タクソノミー カテゴリ追加 */
	register_taxonomy('design_company_cat','design_company', array(
		'hierarchical' => true,
		'labels' => array(
			'name' => '都道府県',
			'singular_name' => '都道府県',
			'search_items' =>  '都道府県を検索',
			'all_items' => 'すべての都道府県',
			'parent_item' => '親分類',
			'parent_item_colon' => '親分類：',
			'edit_item' => '編集',
			'update_item' => '更新',
			'add_new_item' => 'カテゴリを追加',
			'new_item_name' => '名前',
		),
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array(
			'slug' => 'design_company','with_front' => true)
	));


	register_post_type( 'lab', /* post-type */
			array(
					'labels' => array(
							'name' => __( 'パンフレットデザインラボ' ),
							'singular_name' => __( 'パンフレットデザインラボ' ),
							'all_items' => 'パンフレットデザインラボ一覧',
							'add_new' => 'パンフレットデザインラボ追加',
							'add_new_item' => 'パンフレットデザインラボの追加',
							'edit_item' => 'パンフレットデザインラボの編集',
							'new_item' => 'パンフレットデザインラボ追加',
							'view_item' => 'パンフレットデザインラボを表示',
							'search_items' => 'パンフレットデザインラボを検索',
							'not_found' =>  'パンフレットデザインラボが見つかりません',
							'not_found_in_trash' => 'ゴミ箱内にパンフレットデザインラボが見つかりませんでした。',
							'parent_item_colon' => ''
					),
					'public' => true,
					'publicly_queryable' => true,
					'show_ui' => true,
					'query_var' => true,
					'rewrite' => true,
					'hierarchical' => false,
					'supports' => array('title','thumbnail'),
					'menu_position' =>30,
					'has_archive' => true,
					'rewrite' => array(
							'slug' => 'lab','with_front' => false)
			)
			);
	/* タクソノミー カテゴリ追加 */
	register_taxonomy('lab_cat','lab', array(
			'hierarchical' => true,
			'labels' => array(
					'name' => 'カテゴリ',
					'singular_name' => 'カテゴリ',
					'search_items' =>  'カテゴリを検索',
					'all_items' => 'すべてのカテゴリ',
					'parent_item' => '親分類',
					'parent_item_colon' => '親分類：',
					'edit_item' => '編集',
					'update_item' => '更新',
					'add_new_item' => 'カテゴリを追加',
					'new_item_name' => '名前',
			),
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array(
					'slug' => 'lab','with_front' => true)
	));

}

//カスタム投稿パーマリンク「/taxonomy/」削除
function my_custom_post_type_permalinks_set($termlink, $term, $taxonomy){
    return str_replace('/'.$taxonomy.'/', '/', $termlink);
}
add_filter('term_link', 'my_custom_post_type_permalinks_set',11,3);

//function.phpに追加
//カスタム分類アーカイブ用のリライトルールを追加 ※必要なら追加(faqを修正すること）
//add_rewrite_rule('faq/([^/]+)/?$', 'index.php?faq_ct=$matches[1]', 'top');
//add_rewrite_rule('faq/([^/]+)/page/([0-9]+)/?$', 'index.php?faq_ct=$matches[1]&paged=$matches[2]', 'top');


if ( ! function_exists( 'top_search_box' ) ){
function top_search_box() {
	global $post;

	$html = '<form role="search" method="get" id="searchform" class="searchform" action="'.home_url( '/' ).'">
				<div>
					<input type="text" value="" name="s" id="s" />
					<input type="submit" id="searchsubmit" value="検索" />
				</div>
			</form>';

	return $html;
}
add_shortcode('top_search_box', 'top_search_box');
}


if ( ! function_exists( 'display_news' ) ){
function display_news() {
	global $post, $posts;

	$posts_news = get_posts( array(
								'post_status' => 'publish',
								'category' => '1',
								'numberposts' => 3,
								'orderby'	=>	'desc'
							));

	$html='';

	if($posts_news){
		$html =  '<table class="foot-news">';

		foreach( $posts_news as $p ) :
			setup_postdata($p);

			$time = get_post_time('Y年m月d日',false,$p->ID);
			$news_html = '';
			$days = 14; //Newを表示させたい期間の日数
			$today = date_i18n('U');
			$entry = get_the_time('U',$p->ID);
			$kiji = date('U',($today - $entry)) / 86400 ;
			if( $days > $kiji ){
				$news_html = '<span class="newicon">NEW</span>';
			}



			$html .= '<tr><td class="date">'.$time.'</td><td class="title"><a href="'.get_the_permalink($p->ID).'">'.get_the_title($p->ID).'</a></td><td class="pctablet"><a href="'.get_the_permalink($p->ID).'"><i class="fa fa-angle-right" aria-hidden="true"></i></a></td></tr>';
		endforeach;

		$html .= '</table>';

		wp_reset_query();
	}
	return $html;
}
add_shortcode('display_news', 'display_news');
}


if ( ! function_exists( 'display_shinchaku' ) ){
function display_shinchaku() {
	global $post, $posts;

	$posts_sc = query_posts( array(
								'post_type' => array('post','snap'),
								'posts_per_page' => 2,
								'orderby'	=>	'desc'
							));

	if($posts_sc){
		$html =  '<div class="news">
  							<h2 class="new-title">新着情報</h2>
							<ul class="new_list">';

		foreach( $posts_sc as $p ) :
			setup_postdata($p);

			$post_type = esc_html(get_post_type_object(get_post_type($p->ID))->name);

			$time = get_post_time('Y年m月d日',false,$p->ID);

			$news_html = '';
			$days = 14; //Newを表示させたい期間の日数
			$today = date_i18n('U');
			$entry = get_the_time('U',$p->ID);
			$kiji = date('U',($today - $entry)) / 86400 ;
			if( $days > $kiji ){
				$news_html = '<span class="icon"><img src="'.get_template_directory_uri().'/images/contents/icon_new.png" alt="NEW"></span>';
			}

			$cat = '';
			$post_type_html ='';
			if($post_type == 'post'){
				$cat = get_the_category($p->ID);
				$post_type_html = '<span class="title"><a href="'.get_the_permalink($p->ID).'" style="color:black;">【'.$cat[0]->cat_name.'】'.get_the_title($p->ID).'</a></span>';
			}elseif ($post_type == 'snap'){
				$post_type_html = '<span class="title"><a href="'.home_url().'/snap/" style="color:black;">【保育スナップ】'.get_the_title($p->ID).'</a></span>';
			}

			$html .= '<li><table style="width:100%;"><tr><th style="width:30%;font-weight:normal;"><span class="day">'.$time.$news_html.'</span></th><td>'.$post_type_html.'</td></tr></table></li>';
		endforeach;

		$html .= '</ul>
						</div>';

		wp_reset_query();
	}
	return $html;
}
add_shortcode('display_shinchaku', 'display_shinchaku');
}


function display_top_result() {
	global $post;

	$prospects_top_result = query_posts( array(
				'post_status' => 'publish',
				'post_type' => array('pamph_company','pamph_clinic','pamph_catalog','pamph_recruit','pamph_school'),
				'posts_per_page' => 12,
				'tax_query' => array(
					'relation' => 'OR',
					array(
						'taxonomy' => 'pamph_company_cat',
						'field' => 'slug',
						'terms' => 'top'
					),
					array(
						'taxonomy' => 'pamph_clinic_cat',
						'field' => 'slug',
						'terms' => 'top'
					),
					array(
						'taxonomy' => 'pamph_catalog_cat',
						'field' => 'slug',
						'terms' => 'top'
					),
					array(
						'taxonomy' => 'pamph_recruit_cat',
						'field' => 'slug',
						'terms' => 'top'
					),
					array(
						'taxonomy' => 'pamph_school_cat',
						'field' => 'slug',
						'terms' => 'top'
					),
				),
				'orderby' => 'rand'
	) );

	if($prospects_top_result){
		$html_top_result='<div class="row">';

		foreach( $prospects_top_result as $post ) {
			setup_postdata( $post );

			$html_top_result.='<div class="col-xs-6 col-sm-3">
				<a href="'.get_the_permalink($post->ID).'" >'.get_the_post_thumbnail($post->ID,'medium').'</a>
				<div class="result-box"><a href="'.get_the_permalink($post->ID).'" >'.get_the_title($post->ID).'</a></div>
			</div>';

		}
		wp_reset_query();
		$html_top_result .= '</div>';

	}else{
		$html_top_result = '';
	}

	return $html_top_result;
}
add_shortcode('display_top_result', 'display_top_result');


function display_top_result_web() {
	global $post;

	$prospects_top_result = query_posts( array(
			'post_status' => 'publish',
			'post_type' => array('web'),
			'posts_per_page' => 4,
			'tax_query' => array(
					'relation' => 'OR',
					array(
							'taxonomy' => 'web_cat',
							'field' => 'slug',
							'terms' => 'top'
					),
			),
			'orderby' => 'date'
	) );

	if($prospects_top_result){
		$html_top_result='<div class="row">';

		foreach( $prospects_top_result as $post ) {
			setup_postdata( $post );

			$html_top_result.='<div class="col-xs-6 col-sm-3">
				<a href="'.get_the_permalink($post->ID).'" >'.get_the_post_thumbnail($post->ID,'medium').'</a>
				<div class="result-box"><a href="'.get_the_permalink($post->ID).'" >'.get_the_title($post->ID).'</a></div>
			</div>';

		}
		wp_reset_query();
		$html_top_result .= '</div>';

	}else{
		$html_top_result = '';
	}

	return $html_top_result;
}
add_shortcode('display_top_result_web', 'display_top_result_web');


if ( ! function_exists( 'display_result' ) ){
function display_result($atts) {
	global $post;
	extract(
		shortcode_atts(
			array(
				'result_post_type' => '',
				'result_post_num' => '-1'
			),
			$atts
		)
	);
	if($result_post_type!=''){
		$taxonomy_name = $result_post_type.'_cat';

		$the_query = new WP_Query( array(
			'post_status' => 'publish',
			'paged' => $paged,
			'posts_per_page' => $result_post_num, // 表示件数
			'tax_query' => array(
				array(
					'taxonomy' => $taxonomy_name,
					'field' => 'slug',
					'terms' => 'result',
				),
			),
		) );

	}else{
		$result_post_type = 'any';

		$the_query = new WP_Query( array(
			'post_status' => 'publish',
			'post_type' => array('pamph_company','pamph_clinic','pamph_catalog','pamph_recruit','pamph_school'),
			'posts_per_page' => $result_post_num, // 表示件数
			'tax_query' => array(
				'relation' => 'OR',
				array(
					'taxonomy' => 'pamph_company_cat',
					'field' => 'slug',
					'terms' => 'result'
				),
				array(
					'taxonomy' => 'pamph_clinic_cat',
					'field' => 'slug',
					'terms' => 'result'
				),
				array(
					'taxonomy' => 'pamph_catalog_cat',
					'field' => 'slug',
					'terms' => 'result'
				),
				array(
					'taxonomy' => 'pamph_recruit_cat',
					'field' => 'slug',
					'terms' => 'result'
				),
				array(
					'taxonomy' => 'pamph_school_cat',
					'field' => 'slug',
					'terms' => 'result'
				),
			),
			'orderby' => 'date'
		) );

	}


	if ($the_query->have_posts()) :

		$html_top_result='<div class="row mt-20">';

		while ($the_query->have_posts()) : $the_query->the_post();

			$post_type_name = esc_html(get_post_type_object(get_post_type())->label );
			$post_type_link = get_post_type_archive_link(get_post_type_object(get_post_type())->name ) ;
			$pamph_terms = wp_get_object_terms($post->ID, 'pamph_tag');
			$pamph_terms_name = $pamph_terms[0]->name;
			$pamph_terms_slug = $pamph_terms[0]->slug;
			$taxonomy_link = get_term_link( $pamph_terms[0]->slug, 'pamph_tag' );

			$image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium' );
			$image_url_hon = $image_url[0];

			$permalink_html = '<a href="'.get_the_permalink($post).'" >'.get_the_title($post).'</a>';

			$html_top_result .= '<div class="col-xs-6 col-md-4">';
			$html_top_result .= '<a href="'.get_the_permalink($post).'" ><img src="'.$image_url_hon.'" /></a>
			<div class="result-box-150">
				<span class="orange-icon"><a href="'.$post_type_link.'result/">'.$post_type_name.'</a></span><br>
				<span class="black-icon"><a href="/pamph_tag/'.$pamph_terms_slug.'/">'.$pamph_terms_name.'</a></span><br>
			<a href="'.get_the_permalink($post).'" >'.get_the_title($post).'</a></div></div>';

		endwhile;

		$html_top_result .= '</div>';

	else :
		$html_top_result = '<div class="row mt-20" id="list"><div class="col-sm-12 mb-50">実績はありません。</div></div>';
	endif;

	wp_reset_query();

	return $html_top_result;
}
add_shortcode('display_result', 'display_result');
}

if ( ! function_exists( 'display_top_faq' ) ){
function display_top_faq() {
	global $post;

	// カスタム分類名
	$taxonomy = 'faq_cat';

	$posts = get_posts( array(
		'post_type' => 'faq',
		'taxonomy' => $taxonomy,
		'term' => 'about-all',
		'posts_per_page' => -1,
		'meta_key' => 'order_num',
		'orderby'     => 'meta_value_num',
		'order'	=>	'ASC'
	));

	$html ='';

	foreach($posts as $post){

		setup_postdata( $post );
		$ID = get_the_ID($post);

		$title = get_the_title();
		$content = apply_filters('the_content',get_the_content());

		$toggle = '[toggle title="'.$title.'"]<div class="faq-answer">
				<table><tbody><tr>
				<th class="color-orange">A</th><td>'.$content.'</td>
				</tr></tbody></table>
			</div>[/toggle]';

		$html.= do_shortcode($toggle);

	}
	wp_reset_query();

	return $html;
}
add_shortcode('display_top_faq', 'display_top_faq');
}

function wbsExistPost($type, $slug){
	$loops= new wp_query();
	$loops->query("post_type={$type}&name={$slug}");
	if($loops->have_posts()) {
		return true;
	} else {
		return false;
	}
}

/* Breadcrumb NavXTで特定の複数カテゴリを除外する かなり強引 */
function my_filter_breadcrumbs($bcnObj) {
	$trail = array();
	if ( count($bcnObj->trail) > 0 ) {
		for ( $i = 0; $i < count($bcnObj->trail); $i++ ) {
			if ( 'TOP掲載' != $bcnObj->trail[$i]->get_title() ) {
				$trail[] = $bcnObj->trail[$i];
			}else{
				$title_of_parent = $bcnObj->trail[$i+1]->get_title();
				$url_of_parent = $bcnObj->trail[$i+1]->get_url();
				$bcnObj->trail[$i]->set_title($title_of_parent.'実績');
				$bcnObj->trail[$i]->set_url($url_of_parent.'result/');
				$trail[] = $bcnObj->trail[$i];
			}
		}
	}
	$bcnObj->trail = $trail;
	return $bcnObj;
}
add_action('bcn_after_fill', 'my_filter_breadcrumbs');


/* カスタム投稿タイプページのときにクラス付与 */
function make_menu_current( $classes, $item ) {
	if (!is_tax('pamph_tag')){
	    if ( 'pamph_catalog' == get_post_type()  ){
	    	$classes[] = 'pamph_catalog-page';
	    }elseif ( 'pamph_company' == get_post_type()  ) {
	        $classes[] = 'pamph_company-page';
	    }elseif ( 'pamph_clinic' == get_post_type()  ){
	    	$classes[] = 'pamph_clinic-page';
	    }elseif ( 'pamph_recruit' == get_post_type()  ){
	    	$classes[] = 'pamph_recruit-page';
	    }elseif ( 'pamph_school' == get_post_type()  ){
	    	$classes[] = 'pamph_school-page';
	   	}elseif ( 'lab' == get_post_type()  ){
			$classes[] = 'lab-page';
		}
    }

    $classes = array_unique( $classes );
    return $classes;
}
add_filter( 'nav_menu_css_class', 'make_menu_current', 10, 2 );


/**
 * Enqueue Javascript postMessage handlers for the Customizer.
 *
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 *
 * @since Twenty Twelve 1.0
 *
 * @return void
 */
function twentytwelve_customize_preview_js() {
	wp_enqueue_script( 'twentytwelve-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20130301', true );
}
add_action( 'customize_preview_init', 'twentytwelve_customize_preview_js' );

function lazyload_scripts_method() {
	wp_enqueue_script(
		'lazyload',
		get_template_directory_uri() . '/assets/js/jquery.lazyload.min.js',
		array( 'jquery' )
	);
}
add_action( 'wp_enqueue_scripts', 'lazyload_scripts_method' );

function masonry_scripts_method() {
	wp_enqueue_script(
		'masonry_pkgd',
		get_template_directory_uri() . '/assets/js/masonry.pkgd.min.js',
		array( 'jquery' )
	);
}
add_action( 'wp_enqueue_scripts', 'masonry_scripts_method' );

function imagesloaded_scripts_method() {
	wp_enqueue_script(
		'imagesloaded',
		get_template_directory_uri() . '/assets/js/imagesloaded.pkgd.min.js',
		array( 'jquery' )
	);
}
add_action( 'wp_enqueue_scripts', 'imagesloaded_scripts_method' );

function magnificpopup_scripts_method() {
	wp_enqueue_script(
		'magnificpopup',
		get_template_directory_uri() . '/assets/js/jquery.magnific-popup.min.js',
		array( 'jquery' )
	);
}
add_action( 'wp_enqueue_scripts', 'magnificpopup_scripts_method' );

//function infinitescroll_scripts_method() {
//	wp_enqueue_script(
//		'infinitescroll',
//		get_stylesheet_directory_uri() . '/assets/js/jquery.infinitescroll.min.js',
//		array( 'jquery' )
//	);
//}
//add_action( 'wp_enqueue_scripts', 'infinitescroll_scripts_method' );

function masonry_init_scripts_method() {
	wp_enqueue_script(
		'masonry_init',
		get_template_directory_uri() . '/assets/js/masonry_init.js',
		array( 'jquery' )
	);
}
add_action( 'wp_enqueue_scripts', 'masonry_init_scripts_method' );

add_filter( 'wpcf7_validate_email', 'wpcf7_text_validation_filter_extend', 11, 2 );
add_filter( 'wpcf7_validate_email*', 'wpcf7_text_validation_filter_extend', 11, 2 );
function wpcf7_text_validation_filter_extend( $result, $tag ) {
    $type = $tag['type'];
    $name = $tag['name'];
    $_POST[$name] = trim( strtr( (string) $_POST[$name], "\n", " " ) );
    if ( 'email' == $type || 'email*' == $type ) {
        if (preg_match('/(.*)_confirm$/', $name, $matches)){
            $target_name = $matches[1];
            if ($_POST[$name] != $_POST[$target_name]) {
                if (method_exists($result, 'invalidate')) {
                    $result->invalidate( $tag,"確認用のメールアドレスが一致していません");
                } else {
                    $result['valid'] = false;
                    $result['reason'][$name] = '確認用のメールアドレスが一致していません';
                }
            }
        }
    }
    return $result;
}


/* サイドバーウィジェットでショートコード呼び出し */
add_filter('widget_text', 'do_shortcode');

/* 最上位のページ取得 */
function ps_get_root_page( $cur_post, $cnt = 0 ) {
	if ( $cnt > 5 ) { return false; }
	$cnt++;
	if ( $cur_post->post_parent == 0 ) {
		$root_page = $cur_post;
	} else {
		$root_page = ps_get_root_page( get_post( $cur_post->post_parent ), $cnt );
	}
	return $root_page;
}

/* 最下層カテゴリ取得 */
function get_my_bottom_category() {

  $cats = get_the_category();   // 配列を取得
  $count_cat = count($cats);

  $new_cats = array();  // 新しい配列を用意
  for($i = 0; $i < $count_cat; $i++) {
    $ancestors = get_ancestors( $cats[$i]->cat_ID, 'category' );
    $count_anc = count($ancestors);
    $new_cats[$count_anc] = $cats[$i];  // 先祖の数をキーとした要素
  }
  krsort($new_cats);    // キーで逆順ソートする
  $cat = reset($new_cats);  // reset()の戻り値は先頭の要素

  return $cat;
}


/* 同じカテゴリのアーカイブリンク */
function extend_date_archives_add_rewrite_rules($wp_rewrite) {
    $rules = array();
    $structures = array(
        $wp_rewrite->get_category_permastruct() . $wp_rewrite->get_date_permastruct(),
        $wp_rewrite->get_category_permastruct() . $wp_rewrite->get_month_permastruct(),
        $wp_rewrite->get_category_permastruct() . $wp_rewrite->get_year_permastruct(),
    );
    foreach( $structures as $s ){
        $rules += $wp_rewrite->generate_rewrite_rules($s);
    }
    $wp_rewrite->rules = $rules + $wp_rewrite->rules;
}
add_action('generate_rewrite_rules', 'extend_date_archives_add_rewrite_rules');


add_filter('getarchives_where', 'custom_archives_where', 10, 2);
add_filter('getarchives_join', 'custom_archives_join', 10, 2);

function custom_archives_join($x, $r) {
  global $wpdb;
  $cat_ID = $r['cat'];
  if (isset($cat_ID)) {
    return $x . " INNER JOIN $wpdb->term_relationships ON ($wpdb->posts.ID = $wpdb->term_relationships.object_id) INNER JOIN $wpdb->term_taxonomy ON ($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id)";
  } else {
    return $x;
  }
}
function custom_archives_where($x, $r) {
  global $wpdb;
  $cat_ID = $r['cat'];
  if (isset($cat_ID)) {
    return $x . " AND $wpdb->term_taxonomy.taxonomy = 'category' AND $wpdb->term_taxonomy.term_id IN ($cat_ID)";
  } else {
    $x;
  }
}

function wp_get_cat_archives($opts, $cat) {
  $args = wp_parse_args($opts, array('echo' => '1')); // default echo is 1.
  $echo = $args['echo'] != '0'; // remember the original echo flag.
  $args['echo'] = 0;
  $args['cat'] = $cat;

  $archives = wp_get_archives(build_query($args));
  $archs = explode('</li>', $archives);
  $links = array();

  $cat0 = get_the_category();
  $cat_slug = $cat0[0]->category_nicename;

  foreach ($archs as $archive) {
    $link = preg_replace("/\/date\//", "/category/{$cat_slug}/date/", $archive);
    array_push($links, $link);
  }
  $result = implode('</li>', $links);

  if ($echo) {
    echo $result;
  } else {
    return $result;
  }
}
/* 同じカテゴリのアーカイブリンク終わり */



//中サイズ画像をトリミングする
update_option( 'medium_crop',true );
//大サイズ画像をトリミングする
update_option( 'large_crop',true );


//サブカテゴリに所属する投稿記事を排除する
function my_category_children( $return ) {
	return array();
}

/* 2014.5 yoshihisa tanno edited img_caption_shortcode original wp-includes media.php */
function my_img_caption($output, $attr, $content){
  extract(shortcode_atts(array(
    'id'    => '',
    'align'    => 'alignnone',
    'width'    => '',
    'caption' => ''
  ), $attr));

  if ( 1 > (int) $width || empty($caption) )
    return $content;

  if ( $id ) $id = 'id="' . esc_attr($id) . '" ';

  return '<div ' . $id . 'class="wp-caption ' . esc_attr($align)
    . '">'
    . do_shortcode( $content )
    . '<p class="wp-caption-text">' . $caption . '</p>'
    . '</div>';
}
add_filter('img_caption_shortcode', 'my_img_caption', 10, 3);

function auto_post_slug( $slug, $post_ID, $post_status, $post_type ) {
    if ( preg_match( '/(%[0-9a-f]{2})+/', $slug ) ) {
        $slug = utf8_uri_encode( $post_type ) . '-' . $post_ID;
    }
    return $slug;
}
add_filter( 'wp_unique_post_slug', 'auto_post_slug', 10, 4  );

/* 画像編集の際に勝手にwidth/heightが入るので削除 */
add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 );

function remove_width_attribute( $html ) {
   $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
   return $html;
}

function lig_wp_category_terms_checklist_no_top( $args, $post_id = null ) {
    $args['checked_ontop'] = false;
    return $args;
}
add_action( 'wp_terms_checklist_args', 'lig_wp_category_terms_checklist_no_top' );

remove_action('wp_head','wp_generator');


// カスタム分類アーカイブ用のリライトルールを追加する
add_rewrite_rule('pamph_company/([^/]+)/page/([0-9]+)/?$', 'index.php?pamph_company_cat=$matches[1]&paged=$matches[2]', 'top'); //2ページ目以降用
add_rewrite_rule('pamph_catalog/([^/]+)/page/([0-9]+)/?$', 'index.php?pamph_catalog_cat=$matches[1]&paged=$matches[2]', 'top'); //2ページ目以降用
add_rewrite_rule('pamph_school/([^/]+)/page/([0-9]+)/?$', 'index.php?pamph_school_cat=$matches[1]&paged=$matches[2]', 'top'); //2ページ目以降用
add_rewrite_rule('pamph_recruit/([^/]+)/page/([0-9]+)/?$', 'index.php?pamph_recruit_cat=$matches[1]&paged=$matches[2]', 'top'); //2ページ目以降用
add_rewrite_rule('pamph_clinic/([^/]+)/page/([0-9]+)/?$', 'index.php?pamph_clinic_cat=$matches[1]&paged=$matches[2]', 'top'); //2ページ目以降用
add_rewrite_rule('web/([^/]+)/page/([0-9]+)/?$', 'index.php?web_cat=$matches[1]&paged=$matches[2]', 'top'); //2ページ目以降用
add_rewrite_rule('lab/([^/]+)/page/([0-9]+)/?$', 'index.php?lab_cat=$matches[1]&paged=$matches[2]', 'top'); //2ページ目以降用

/* 空文字検索ではHOMEにリダイレクト */
function empty_search_redirect( $wp_query ) {
  if ( $wp_query->is_main_query() && $wp_query->is_search && ! $wp_query->is_admin ) {
    $s = $wp_query->get( 's' );
    if ( empty( $s ) ) {
      wp_safe_redirect( home_url('/') );
      exit;
    }
  }
}
add_action( 'parse_query', 'empty_search_redirect' );

/* 郵便番号自動住所 */
add_action( 'wp_enqueue_scripts', 'my_ajaxzip3' );
//function my_ajaxzip3() {
//	wp_enqueue_script( 'ajaxzip3', 'https://ajaxzip3.googlecode.com/svn/trunk/ajaxzip3/ajaxzip3-https.js' );
//}
function my_ajaxzip3() {
//	wp_enqueue_script( 'ajaxzip3', 'http://ajaxzip3.googlecode.com/svn/trunk/ajaxzip3/ajaxzip3.js' );
	wp_enqueue_script( 'ajaxzip3', 'https://ajaxzip3.github.io/ajaxzip3.js' );
}

add_action( 'wp_enqueue_scripts', 'autozip' );
function autozip() {
	wp_enqueue_script( 'autozip', get_template_directory_uri() . '/assets/js/autozip.js' );
}

/* 画像にsrcsetが埋め込まれるのを削除 */
add_filter( 'wp_calculate_image_srcset_meta', '__return_null' );

/* WP 本体 更新通知 非表示 */
add_filter('pre_site_transient_update_core', '__return_zero');
remove_action('wp_version_check', 'wp_version_check');
remove_action('admin_init', '_maybe_update_core');

/* WP プラグイン 更新通知 非表示 */
remove_action( 'load-update-core.php', 'wp_update_plugins' );
add_filter( 'pre_site_transient_update_plugins', create_function( '$a', "return null;" ) );

function admin_css() {
    echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo("template_directory").'/css/admin.css">';
}
add_action('admin_head', 'admin_css');