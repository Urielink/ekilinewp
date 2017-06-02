<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package ekiline
 */

/**
 * Utilizar keywords en caso de necesitar etiquetas en las paginas:
 * https://www.sitepoint.com/wordpress-pages-use-tags/
 */

// Permitir el uso de etiquetas en pages
// add tag support to pages
function tags_support_all() {
    register_taxonomy_for_object_type('post_tag', 'page');
}
add_action('init', 'tags_support_all');


// Incluir todas
// ensure all tags are included in queries
function tags_support_query($wp_query) {
    if ($wp_query->get('tag')) $wp_query->set('post_type', 'any');
}
add_action('pre_get_posts', 'tags_support_query');


// Extraer las etiquetas como keywords

function ekiline_keywords() {        
    global $post;
    
    if( is_single() || is_page() || is_home() ) {
    
        $tags = get_the_tags($post->ID);
        $keywords = '';
        
        if($tags) {
            
            foreach($tags as $tag) :
                $sep = (empty($keywords)) ? '' : ', ';
                $keywords .= $sep . $tag->name;
            endforeach;
    
            echo $keywords;
    
        }
        
    } elseif ( is_tag() ){
            echo single_tag_title();
    }
}


// Optimización de la meta descripción con custom field
// Meta description , allow custom term by wp customfield

function ekiline_description(){

    if ( is_single() || is_page() ) {
        
    global $wp_query;
    $postid = $wp_query->post->ID;
    $stdDesc = get_post_meta($postid, 'metaDescripcion', true);
    wp_reset_query();
            
       if ( ! empty( $stdDesc ) ){
           // Si utilizan nuestro custom field
           // here is our custom field
           echo $stdDesc;
       } else {
//           echo strip_tags( get_the_excerpt() ); 
            echo wp_trim_words( get_the_content(), 24, '...' );
       }
     
    } 
    elseif ( is_archive() ) {
    // las metas https://codex.wordpress.org/Meta_Tags_in_WordPress
        echo single_cat_title();
    } 
    else {
        echo bloginfo('description');
    }
    
}


/**
 * Optimizar los scripts con async, esta funcion solo requiere el manejador
 * y se sobreescribira el link con el atributo dado. Por algun extraña razon no permite 
 * el agregar el atributo con el codigo de wordpress, como el caso de los scripts de IE.
 * Ad async or defer attribute scripts, it needs the handler, even if you install a new plugin.
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
		// 'bootstrap-script', Swipe compatibility
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


// function load_styles( $tag, $handle, $src ) {
//         
    // $load_css = array( 
        // 'bootstrap-337',
        // 'ie10-viewport-bug-workaround',
        // 'font-awesome',
        // 'layout',
        // 'ekiline-style'
        // //'google-font'
    // );
// 
    // if ( in_array( $handle, $load_css ) ) {
       // return '<link id="' . $handle . '" href="' . $src . '" type="text/css" media="all" rel="stylesheet">' . "\n";
    // }
//     
    // return $tag;
// } 
// add_filter( 'style_loader_tag', 'load_styles', 10, 3 );


/**
 * OPTIMIZACIoN: Registrar google analytics (customizer.php)
 * Add google analyitcs script
 * https://developers.google.com/analytics/devguides/collection/gajs/
 * https://digwp.com/2012/06/add-google-analytics-wordpress/
**/

function google_analytics_tracking_code(){
        
    $gacode = get_theme_mod('ekiline_analytics','');

    if ( $gacode != '' ) {
        
    echo "<script>
        window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
        ga('create', '" . $gacode . "', 'auto');
        ga('send', 'pageview');
         </script>
         <script async defer src='https://www.google-analytics.com/analytics.js'></script>
         ";     

    }
}
// Usar 'wp_head' 'wp_footer' para situar el script 
// If you need to allow in head just change wp_footer value
add_action('wp_footer', 'google_analytics_tracking_code', 100); 
    


/**
 * OPTIMIZACIoN: Registrar páginas (customizer.php)
 * https://wordpress.stackexchange.com/questions/237100/how-to-add-meta-tag-to-wordpress-posts-filter
**/

function registerSite() {

//Indice en Google y Bing
    $sconsole = get_theme_mod('ekiline_wmtools','');
    $wmbing = get_theme_mod('ekiline_wmbing','');
    if ( $sconsole != '' ) { echo '<meta name="google-site-verification" content="'. $sconsole .'" />'; }
    if ( $wmbing != '' ) { echo '<meta name="msvalidate.01" content="'. $wmbing .'" />'; }
}

add_action( 'wp_head', 'registerSite', 0);
