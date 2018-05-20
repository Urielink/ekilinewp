<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package ekiline 
 */

// Registrar las metadatos para campos personalizados
 
add_action( 'init', 'ekiline_register_meta' );
function ekiline_register_meta() {
	
	$metas = array('custom_meta_description','custom_title','custom_css_style','custom_js_script');

	$args = array(
	    'type'      => 'string',
	    'single'        => true,
	    'sanitize_callback' => 'sanitize_text_field',
	);

	foreach($metas as $key => $value) {
		register_meta( 'post', $value, $args );
		add_post_meta( 1, $value, '', true );
	}
}
 
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


// Optimizacion de la meta descripcion con custom field
// Meta description , allow custom term by wp customfield

function ekiline_description(){
    
    if ( is_single() || is_page() ) {
        
        global $wp_query;
        $postid = $wp_query->post->ID;
        $stdDesc = get_post_meta($postid, 'custom_meta_description', true);
        wp_reset_query();
            
        if ( ! empty( $stdDesc ) ) {
             echo $stdDesc;
        } elseif ( get_bloginfo('description') && is_front_page() || is_home() ) {
            echo get_bloginfo('description');
        } else {
            echo wp_trim_words( strip_shortcodes( get_the_content() ), 24, '...' );
        }      
    } 
    elseif ( is_archive() ) {
        echo single_cat_title();
    } 
    else {
        echo bloginfo('description');
    }
    
}


// Optimizacion El titulo con custom field para paginas y posts

function ekiline_title($title){
	
    if( is_single() || is_page() ){    	

	    global $wp_query;
	    $cfTitle = get_post_meta($wp_query->post->ID, 'custom_title', true);
	    wp_reset_query();
		 
		if ( ! empty( $cfTitle ) ){
	        $title['title'] = $cfTitle ; 
	        $title['site'] = get_bloginfo( 'name' ); //optional
		} 
    }

    return $title; 
}
add_filter('document_title_parts', 'ekiline_title', 10);


// Agregar css por pagina. || Custom CSS by page

function ekiline_postcss(){
    
    // no aplica si es tienda woocommerce || exclude woocommerce
    if ( is_single() || is_page() ) {
        
    global $wp_query;
    $postid = $wp_query->post->ID;
    $myCss = get_post_meta($postid, 'custom_css_style', true);
    wp_reset_query();
            
       if ( ! empty( $myCss ) ){
           echo '<style type="text/css" id="custom-css-'.$postid.'">'.$myCss.'</style>';
       } 
     
    } 
    
}
add_action( 'wp_head', 'ekiline_postcss', 99);

// Agregar js por pagina. || Custom JS by page

function ekiline_postjs(){
    
    // no aplica si es tienda woocommerce || exclude woocommerce
    if ( is_single() || is_page() ) {
        
    global $wp_query;
    $postid = $wp_query->post->ID;
    $myJs = get_post_meta($postid, 'custom_js_script', true);
    wp_reset_query();
            
       if ( ! empty( $myJs ) ){
           echo '<script type="text/javascript" id="custom-js-'.$postid.'">'.$myJs.'</script>'."\n";
       } 
     
    } 
    
}
add_action( 'wp_footer', 'ekiline_postjs', 99);

 
function ekiline_loadcss() {
	
    $params = null;
    
    if( true === get_theme_mod('ekiline_loadcss') && !is_admin() && !current_user_can('edit_posts')){
            
        global $wp_styles; 

	    $allcss = array();
	    foreach( $wp_styles->queue as $csshandle ) {    	
			$allcss[] = $csshandle;              
	  	} 
		$allowcss = array('photoswipe-default-skin');	
		$load_css = array_diff( $allcss, $allowcss );        
        $ret = array();
        foreach( $load_css as $handle) {
          wp_dequeue_style($handle);
          $ret[] = array( 'id' => $handle , 'src' => $wp_styles->registered[$handle]->src , 'media' => $wp_styles->registered[$handle]->args ) ;              
      	}        
        $params = $ret;   
    
    }   
	
    wp_localize_script('ekiline-layout', 'allCss', $params); 
        
}
add_action( 'wp_enqueue_scripts', 'ekiline_loadcss' );

function wsds_defer_scripts( $tag, $handle, $src ) {

    global $wp_scripts;   
    $alljs = array();
    foreach( $wp_scripts->queue as $jshandle ) {    	
		$alljs[] = $jshandle;              
  	} 
	$allowjs = array('jquery-core','popper-script','bootstrap-script');	
	$defer_scripts = array_diff( $alljs, $allowjs );
    if ( in_array( $handle, $defer_scripts ) ) {
        return '<script type="text/javascript" src="' . $src . '" defer="defer" async="async"></script>' . "\n";
    }    
    return $tag;
} 
if ( ! is_admin() ) add_filter( 'script_loader_tag', 'wsds_defer_scripts', 10, 3 );



// OPTIMIZACIoN: Registrar google analytics (customizer.php)
// Add google analyitcs script

function google_analytics_tracking_code(){
        
    $gacode = get_theme_mod('ekiline_analytics','');
    $gascript = '';       

    if ( $gacode != '' ) {

    $gascript .= '<script async src="https://www.googletagmanager.com/gtag/js?id='. $gacode .'"></script>'."\n";
    $gascript .= '<script>'."\n";       
    $gascript .= "window.dataLayer = window.dataLayer || [];"."\n";
    $gascript .= "function gtag(){dataLayer.push(arguments);}"."\n";
    $gascript .= "gtag('js', new Date());"."\n";   
    $gascript .= "gtag('config', '". $gacode ."');"."\n";   
    $gascript .= '</script>'."\n";       
         	       
	echo $gascript;         

    }
}
// Usar 'wp_head' para situar el script 
// If you need to allow in head just change wp_footer value
add_action('wp_footer', 'google_analytics_tracking_code', 100); 

//Indice en Google y Bing

function registerSite() {
    $sconsole = get_theme_mod('ekiline_wmtools','');
    $wmbing = get_theme_mod('ekiline_wmbing','');
    if ( $sconsole != '' ) { echo '<meta name="google-site-verification" content="'. $sconsole .'" />'."\n"; }
    if ( $wmbing != '' ) { echo '<meta name="msvalidate.01" content="'. $wmbing .'" />'."\n"; }
}

add_action( 'wp_head', 'registerSite', 0);

/* Agregar las metaetiquetas para los smartphones */

function iosfeatures() {
    $iosfeats = '<meta name="apple-mobile-web-app-title" content="'.get_bloginfo( 'name' ).'">'."\n";
    $iosfeats .= '<meta name="apple-mobile-web-app-capable" content="yes">'."\n";
    $iosfeats .= '<meta name="apple-mobile-web-app-status-bar-style" content="black">'."\n";    
    echo $iosfeats;
}
add_action( 'wp_head', 'iosfeatures', 2);

