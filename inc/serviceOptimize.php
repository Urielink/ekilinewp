<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package ekiline
 */

/* Usar urls relativas al desplegar ciertos contenidos */

function rw_relative_urls() {
    if ( is_feed() || get_query_var( 'sitemap' ) )
        return;

    $filters = array(
        'post_link',
        'post_type_link',
        'page_link',
        'attachment_link',
        'get_shortlink',
        'post_type_archive_link',
        'get_pagenum_link',
        'get_comments_pagenum_link',
        'term_link',
        'search_link',
        'day_link',
        'month_link',
        'year_link',
    );
    foreach ( $filters as $filter )
    {
        add_filter( $filter, 'wp_make_link_relative' );
    }
}

add_action( 'template_redirect', 'rw_relative_urls' );

/** 
 * Usar urls para trabajar en el sitio:
 * https://www.webhostinghero.com/how-to-insert-relative-image-urls-in-wordpress/
 */

function switch_to_relative_url($html, $id, $caption, $title, $align, $url, $size, $alt) {
    $imageurl = wp_get_attachment_image_src($id, $size);
    $relativeurl = wp_make_link_relative($imageurl[0]);   
    $html = str_replace($imageurl[0],$relativeurl,$html);      
    return $html;
}
add_filter('image_send_to_editor','switch_to_relative_url',10,8);

 
// SEO en caso de necesitar etiquetas en las paginas:
// https://www.sitepoint.com/wordpress-pages-use-tags/

// add tag support to pages
function tags_support_all() {
    register_taxonomy_for_object_type('post_tag', 'page');
}
add_action('init', 'tags_support_all');


// ensure all tags are included in queries
function tags_support_query($wp_query) {
    if ($wp_query->get('tag')) $wp_query->set('post_type', 'any');
}
add_action('pre_get_posts', 'tags_support_query');


// SEO extraer las etiquetas como keywords

function ekiline_keywords() {        
    global $post;
    
    if( is_single() || is_page() || is_home() ) :
        $tags = get_the_tags($post->ID);
        $keywords = '';
        if($tags) :
            foreach($tags as $tag) :
                $sep = (empty($keywords)) ? '' : ', ';
                $keywords .= $sep . $tag->name;
            endforeach;
    
            echo $keywords;
    
        endif;
    endif;
}


// Optimizacion metas

function ekiline_description(){
    // el dato que se mostrara
    if ( is_single() || is_page() ) {
        
    global $wp_query;
    $postid = $wp_query->post->ID;
    $stdDesc = get_post_meta($postid, 'metaDescripcion', true);
    wp_reset_query();
            
       if ( ! empty( $stdDesc ) ){
           // Si utilizan nuestro custom field
           echo $stdDesc;
       } else {
           echo strip_tags( get_the_excerpt() ); 
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
 * el agregar el atribto con el codigo de wordpress, como el caso de los scripts de IE.
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


/**
 * OPTIMIZACIoN: 
 *  Include para google analytics
 * @link https://developers.google.com/analytics/devguides/collection/gajs/
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
add_action('wp_footer', 'google_analytics_tracking_code', 100); 
    


/**
 * OPTIMIZACIoN: 
 *  Include para registrar páginas
 * @link https://wordpress.stackexchange.com/questions/237100/how-to-add-meta-tag-to-wordpress-posts-filter
**/

function registerSite() {

//Indice en Google y Bing
    $sconsole = get_theme_mod('ekiline_wmtools','');
    $wmbing = get_theme_mod('ekiline_wmbing','');
    if ( $sconsole != '' ) { echo '<meta name="google-site-verification" content="'. $sconsole .'" />'; }
    if ( $wmbing != '' ) { echo '<meta name="msvalidate.01" content="'. $wmbing .'" />'; }
}

add_action( 'wp_head', 'registerSite', 0);
