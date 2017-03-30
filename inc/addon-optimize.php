<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package ekiline
 */



/**
 * Optimizar los scripts con async, esta función solo requiere el manejador
 * y se sobreescribirá el link con el atributo dado. Por algun extraña razón no permite 
 * el añadir el atribto con el código de wordpress, como el caso de los scripts de IE.
 * //'ie10-vpbugwkrnd',
 * //'html5shiv',
 * //'respond',
 **/

function wsds_defer_scripts( $tag, $handle, $src ) {

	// The handles of the enqueued scripts we want to defer
	$defer_scripts = array( 
		'prismjs',
		'admin-bar',
		'et_monarch-ouibounce',
		'et_monarch-custom-js',
		'wpshout-js-cookie-demo',
		'cookie',
		'wpshout-no-broken-image',
		'goodbye-captcha-public-script',
		'devicepx',
		'search-box-value',
		'page-min-height',
		'kamn-js-widget-easy-twitter-feed-widget',
		'__ytprefs__',
		'__ytprefsfitvids__',
		'jquery-migrate',
		'icegram',
		'disqus',
		'comment-reply',
		'wp-embed',
		'wp-emoji-release',
		// 'bootstrap-script',
		'ekiline-swipe',
		'lazy-load',
		'ekiline-layout',
		'theme-scripts',
		'optimizar'
	);

    if ( in_array( $handle, $defer_scripts ) ) {
        return '<script src="' . $src . '" type="text/javascript" defer async></script>' . "\n";
    }
    
    return $tag;
} 
add_filter( 'script_loader_tag', 'wsds_defer_scripts', 10, 3 );


/** urls relativas 
 * http://www.deluxeblogtips.com/relative-urls/
**/

$filters = array(
    'post_link',       // Normal post link
    'post_type_link',  // Custom post type link
    'page_link',       // Page link
    'attachment_link', // Attachment link
    'get_shortlink',   // Shortlink

    'post_type_archive_link',    // Post type archive link
    'get_pagenum_link',          // Paginated link
    'get_comments_pagenum_link', // Paginated comment link

    'term_link',   // Term link, including category, tag
    'search_link', // Search link

    'day_link',   // Date archive link
    'month_link',
    'year_link'

);

foreach ( $filters as $filter ) {
    add_filter( $filter, 'wp_make_link_relative' );
}

// $CssLink = wp_make_link_relative( get_stylesheet_uri() );
// $ThemeLink = wp_make_link_relative( get_template_directory_uri() );
// http://www.wpbeginner.com/wp-tutorials/25-extremely-useful-tricks-for-the-wordpress-functions-file/
// http://www.hongkiat.com/blog/wordpress-url-rewrite/ XX


/** optimizacion de carga de css y js, utilizando localize. XX
 *	https://codex.wordpress.org/Function_Reference/wp_localize_script
 *	https://pippinsplugins.com/use-wp_localize_script-it-is-awesome/	
 *  requiere de: optimizar.js
**/

function optimizar_carga() {
	
	wp_enqueue_script('optimizar', get_template_directory_uri().'/js/optimizar.js', array('jquery'),'1.0', true );
		
	wp_localize_script('optimizar', 'recurso_script', array(
			//asigno el css por cada archivo interno
				'css1' => get_template_directory_uri() . '/css/bootstrap.min.css',
				'css2' => get_template_directory_uri() . '/css/font-awesome.min.css',
				'css3' => get_template_directory_uri() . '/css/ekiline-layout.css',
				'css4' => '//fonts.googleapis.com/css?family=Raleway:400,300,700,300italic,400italic,700italic|Open+Sans:400,400italic,300italic,300,700,700italic',
				'css5' => get_stylesheet_uri(),
		)
	);
}
add_action('wp_enqueue_scripts', 'optimizar_carga', 10);

