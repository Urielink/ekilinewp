<?php
/**
 * ekiline functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ekiline
 */

if ( ! function_exists( 'ekiline_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ekiline_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on ekiline, use a find and replace
	 * to change 'ekiline' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'ekiline', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
        'top' => esc_html__( 'Top Menu', 'ekiline' ),
        'primary' => esc_html__( 'Primary Menu', 'ekiline' ),
        'modal' => esc_html__( 'Modal Menu', 'ekiline' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'ekiline_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
	
    // Add theme support for selective refresh for widgets.
    add_theme_support( 'customize-selective-refresh-widgets' );
}
endif; // ekiline_setup
add_action( 'after_setup_theme', 'ekiline_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 * Priority 0 to make it available to lower priority callbacks.
 * @global int $content_width
 */
 
function ekiline_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ekiline_content_width', 640 );
}
add_action( 'after_setup_theme', 'ekiline_content_width', 0 );


/**
 * Register widget area.
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
  
function ekiline_widgets_init() {
        	
// Default sidebar
	register_sidebar( array(
		'name'          => esc_html__( 'Left sidebar', 'ekiline' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	
// Right sidebar
    register_sidebar( array(
        'name'          => esc_html__( 'Right sidebar', 'ekiline' ),
        'id'            => 'sidebar-2',
        'description'   => '',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
		
// Footer widgets
    register_sidebar( array(
        'name'          => esc_html__( 'Footer widgets', 'ekiline' ),
        'id'            => 'footer-w1',
        'description'   => '',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h5 class="widget-title">',
        'after_title'   => '</h5>',
    ) );

// Widget in content
    register_sidebar( array(
        'name'          => esc_html__( 'In page at top of content', 'ekiline' ),
        'id'            => 'content-w1',
        'description'   => '',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );

        register_sidebar( array(
        'name'          => esc_html__( 'In page on bottom of content', 'ekiline' ),
        'id'            => 'content-w2',
        'description'   => '',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );
               
// Widgets at top of content
    register_sidebar( array(
        'name'          => esc_html__( 'Top first over all content', 'ekiline' ),
        'id'            => 'toppage-w1',
        'description'   => '',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h5>',
        'after_title'   => '</h5>',
    ) );   
            
// Widget positions for each menu
    register_sidebar( array(
        'name'          => esc_html__( 'Dropdown in top menu', 'ekiline' ),
        'id'            => 'navwidget-nw1',
        'description'   => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s navbar-btn btn-group dropdown">',
        'before_title'  => '<button class="btn btn-secondary btn-block dropdown-toggle" type="button" data-toggle="dropdown">',
        'after_title'   => ' <span class="caret"></span></button><div class="dropdown-menu">',
        'after_widget'  => '</div></div>',
    ) );     

    register_sidebar( array(
        'name'          => esc_html__( 'Dropdown in primary menu', 'ekiline' ),
        'id'            => 'navwidget-nw2',
        'description'   => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s navbar-btn btn-group dropdown">',
        'before_title'  => '<button class="btn btn-secondary btn-block dropdown-toggle" type="button" data-toggle="dropdown">',
        'after_title'   => ' <span class="caret"></span></button><div class="dropdown-menu">',
        'after_widget'  => '</div></div>',
    ) );     

// Widgets in widgets
    register_sidebar( array(
        'name'          => esc_html__( 'Dropdown in single bootstrap navbar', 'ekiline' ),
        'id'            => 'navwidget-nw3',
        'description'   => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s navbar-btn btn-group dropdown">',
        'before_title'  => '<button class="btn btn-secondary btn-block dropdown-toggle" type="button" data-toggle="dropdown">',
        'after_title'   => ' <span class="caret"></span></button><div class="dropdown-menu">',
        'after_widget'  => '</div></div>',
    ) );         
}
add_action( 'widgets_init', 'ekiline_widgets_init' );


/**
 * Ingreso de CSS y JS, para fines de optimización cargamos estilos y js de manera asincrona.
 * Enqueue scripts and styles (ekiline add css by other methods)
 */
  
function ekiline_scripts() {
/**
 * Añadir los estilos como wordpress lo requiere, descomentar en caso de conflicto
 * This is wordpress method for enqueue styles
 */
    wp_enqueue_style( 'bootstrap-4', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '4', 'all' );
	wp_enqueue_style( 'ie10-viewport-bug-workaround', get_template_directory_uri() . '/css/ie10-viewport-bug-workaround.min.css', array(), '1', 'all' );
		wp_style_add_data( 'ie10-viewport-bug-workaround', 'conditional', 'gte IE 8' );	
	wp_enqueue_style( 'layout', get_template_directory_uri() . '/css/ekiline.min.css', array(), '1.0', 'all' );	

	$located = locate_template( 'style.min.css' );
	if ($located != '' ) {
		wp_enqueue_style( 'ekiline-style', get_template_directory_uri() . '/style.min.css', array(), '1.0', 'all' );	
    } else {
		wp_enqueue_style( 'ekiline-style', get_stylesheet_uri() );	
    }	

    if( true === get_theme_mod( 'ekiline_fontawesome', true ) ) {
          wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/fontawesome-all.min.css', array(), '5.0.6', 'all' ); 
    }

    $gfont = get_theme_mod('ekiline_gfont','');
    if ($gfont != '') {
          wp_enqueue_style( 'google-font', $gfont, array(), '0.0.0', 'all' );
    }

    if( !is_admin() ){
        wp_dequeue_script('jquery');
        wp_dequeue_script('jquery-core');
        wp_dequeue_script('jquery-migrate');
        wp_enqueue_script('jquery', false, array(), false, true);
        wp_enqueue_script('jquery-core', false, array(), false, true);
        wp_enqueue_script('jquery-migrate', false, array(), false, true);          
     }        	

	wp_enqueue_script( 'popper-script', get_template_directory_uri() . '/js/popper.min.js', array('jquery'), '1', true  );
 	wp_enqueue_script( 'bootstrap-script', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '4', true  );
    wp_enqueue_script( 'ekiline-swipe', get_template_directory_uri() . '/js/carousel-swipe.min.js', array('jquery'), '20150716', true  );
    wp_enqueue_script( 'ekiline-layout', get_template_directory_uri() . '/js/ekiline.min.js', array('jquery'), '20151226', true  );

	wp_enqueue_script( 'ie10-vpbugwkrnd', get_template_directory_uri() . '/js/ie10-viewport-bug-workaround.min.js' );
		wp_script_add_data( 'ie10-vpbugwkrnd', 'conditional', 'gte IE 8' );
	wp_enqueue_script( 'html5shiv', '//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js' );
		wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );
	wp_enqueue_script( 'respond', '//oss.maxcdn.com/respond/1.4.2/respond.min.js' );
		wp_script_add_data( 'respond', 'conditional', 'lt IE 9' );
			
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}		
	
}
add_action( 'wp_enqueue_scripts', 'ekiline_scripts', 0 );

/**
 * Agregar estilos CSS en caso de que no esté habilitado JS
 * Add CSS styles for disabled js
 */

function ekilineNoscript(){
    $gfont = get_theme_mod('ekiline_gfont','');   
    $noScripts = '<noscript>'."\n";
    $noScripts .= '<link rel="stylesheet" href="'. get_template_directory_uri() . '/css/bootstrap.min.css" media="all" />'."\n";
    $noScripts .= '<link rel="stylesheet" href="'. get_stylesheet_uri() . '" media="all" />'."\n";    
    $noScripts .= '<style type="text/css">#pageLoad{display:none;}</style>'."\n";
    if( true === get_theme_mod('ekiline_fontawesome') ) {
        $noScripts .= '<link rel="stylesheet" href="'. get_template_directory_uri() . '/css/fontawesome-all.min.css" media="all" />'."\n";  
    }      
    if ($gfont != '') {
        $noScripts .= '<link rel="stylesheet" href="'. $gfont . '" media="all" />'."\n";  
    }        
    $noScripts .= '</noscript>'."\n";
    
    echo $noScripts;
}
add_action( 'wp_head', 'ekilineNoscript', 9);

/**
 * Permitir que los shortcodes funcionen en los widgets
 * Allow short-codes work in widgets
 */
add_filter('widget_text', 'do_shortcode');

/**
 * Declarar compatibilidad con woocommerce
 */
 
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Navwalker, for bootstrap menus.
 * https://github.com/wp-bootstrap/wp-bootstrap-navwalker
 */
require get_template_directory() . '/inc/wp-bootstrap-navwalker.php';

/**
 * Sobreescritura y elementos de Ekiline
 * Ekiline overide items
 */
// theme frontend addons
require get_template_directory() . '/inc/themeSidebars.php';
require get_template_directory() . '/inc/themeNavbars.php';
require get_template_directory() . '/inc/themeBreadcrumb.php';

// theme custom widgets
require get_template_directory() . '/inc/widgetNavVer.php';
require get_template_directory() . '/inc/widgetNavHor.php';
require get_template_directory() . '/inc/widgetRecentPostsCarousel.php';
require get_template_directory() . '/inc/widgetOptions.php';

// theme custom shortcodes
require get_template_directory() . '/inc/shortcodeAll.php';
require get_template_directory() . '/inc/shortcodeTabs.php';
require get_template_directory() . '/inc/shortcodeCollapse.php';
require get_template_directory() . '/inc/shortcodeInsertposts.php';
require get_template_directory() . '/inc/shortcodeGalleryslider.php';

// theme customizer services
require get_template_directory() . '/inc/serviceSocialmedia.php';
require get_template_directory() . '/inc/serviceOptimize.php';
require get_template_directory() . '/inc/serviceAccess.php';
require get_template_directory() . '/inc/serviceMaintenance.php';
require get_template_directory() . '/inc/serviceMinify.php';
require get_template_directory() . '/inc/serviceSitemap.php';
require get_template_directory() . '/inc/serviceCookies.php';

// theme admin extend options
require get_template_directory() . '/inc/adminCategoryfield.php';
// Deshabilitar bootstrap
require get_template_directory() . '/inc/adminEditor.php';
