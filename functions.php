<?php
/**
 * H1 Theme functions and definitions
 *
 * @package H1 Theme
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'h1_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function h1_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on H1 Theme, use a find and replace
	 * to change 'h1-theme' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'h1-theme', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'h1-theme' ),
	) );
	
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'h1_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // h1_setup
add_action( 'after_setup_theme', 'h1_setup' );

/**
 * Enqueue scripts and styles.
 */
function h1_scripts() {
	$css_dir = get_stylesheet_directory_uri() . '/assets/styles/css';
	$js_dir = get_stylesheet_directory_uri() . '/assets/js/';

	wp_enqueue_style( 'h1-stylesheet', $css_dir . '/app.css' );

	wp_enqueue_style( 'h1-legacy-stylesheet', $css_dir . '/app-no-mq.css' ); // no mediaqueries, px instead of rem

	// Add conditional comments
    global $wp_styles;
    $wp_styles->registered['h1-legacy-stylesheet']->add_data( 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'jquery' );

	if ( defined( 'WP_ENV' ) && WP_ENV == 'development' ) {
		wp_enqueue_script( 'h1-js', $js_dir . '/dev/built.js', array( 'jquery' ), null, true );
	} else {
		wp_enqueue_script( 'h1-js', $js_dir . '/min/built.min.js', array( 'jquery' ), null, true );
	}

	// Comment out or remove if you don't need commenting
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'h1_scripts' );

/**
 * Define sidebars and possible custom widgets
 */
require get_stylesheet_directory() . '/functions/widgets.php';

/**
 * Load Foundation compatibility file.
 */
require get_template_directory() . '/functions/foundation.php';

/**
 * Navigation-related functions to be used in templates
 */
require get_template_directory() . '/functions/navigation.php';

/**
 * Load Custom walkers for use in nav menus
 */
// require get_template_directory() . '/functions/navigation-walkers.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/functions/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/functions/extras.php';


/**
 * Load Jetpack compatibility file.
 */
// require get_template_directory() . '/functions/jetpack.php';
