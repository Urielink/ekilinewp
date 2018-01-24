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
 * @link https://www.sitepoint.com/wordpress-pages-use-tags/
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
        $stdDesc = get_post_meta($postid, 'custom_meta_description', true);
        wp_reset_query();
            
        if ( ! empty( $stdDesc ) ) {
           //Si utilizan nuestro custom field || If use our custom field           
             echo $stdDesc;
        } elseif ( get_bloginfo('description') && is_front_page() || is_home() ) {
            //Si es homepage utiliza la informacion del sitio en general 
            echo get_bloginfo('description');
        } else {
            echo wp_trim_words( strip_shortcodes( get_the_content() ), 24, '...' );
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


/* Optimización El titulo con custom field para páginas y posts
 * https://developer.wordpress.org/reference/hooks/document_title_parts/
 */
function ekiline_title($title){

    global $wp_query;
    $cfTitle = get_post_meta($wp_query->post->ID, 'custom_title', true);
    wp_reset_query();
	
    if( is_single() || is_page() ){    	
		 
		if ( ! empty( $cfTitle ) ){
	        // change title parts here
	        $title['title'] = $cfTitle ; 
		    // $title['page'] = ''; // opcional si la pagina está numerada
	    	// $title['tagline'] = ''; // optional si requiere el tagline (home)
	        $title['site'] = get_bloginfo( 'name' ); //optional
		} 
    }

    return $title; 
}
add_filter('document_title_parts', 'ekiline_title', 10);


/** 
 * Añadir css por página.
 * Custom CSS by page
 * https://codex.wordpress.org/Function_Reference/wp_add_inline_style
 */

function ekiline_postcss(){
    
    // excluir si es tienda woocommerce || exclude woocommerce
    if ( is_single() || is_page() ) {
        
    global $wp_query;
    $postid = $wp_query->post->ID;
    $myCss = get_post_meta($postid, 'custom_css_style', true);
    wp_reset_query();
            
       if ( ! empty( $myCss ) ){
           // Si utilizan nuestro custom field
           // here is our custom field
           echo '<style type="text/css" id="custom-css-'.$postid.'">'.$myCss.'</style>';
       } 
     
    } 
    
}
add_action( 'wp_head', 'ekiline_postcss', 99);

/** 
 * Añadir js por página.
 * Custom JS by page
 * https://codex.wordpress.org/Function_Reference/wp_add_inline_style
 */

function ekiline_postjs(){
    
    // excluir si es tienda woocommerce || exclude woocommerce
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


/** Boton en menu con popwindow
 * https://codex.wordpress.org/Plugin_API/Action_Reference/wp_before_admin_bar_render
 * https://codex.wordpress.org/Javascript_Reference/ThickBox
 * Y con estilos agregados.
 * https://codex.wordpress.org/Function_Reference/wp_add_inline_style
 * https://gist.github.com/corvannoorloos/43980115659cb5aee571
 */

function ekiline_bar_link() {
	global $wp_admin_bar;
	if ( !is_super_admin() || !is_admin_bar_showing() )
		return;	
	
		$wp_admin_bar->add_menu( array(
		'id' => 'goekiline',
		'title' => __( 'FundMe', 'ekiline'),
		'href' => 'http://ekiline.com/fondeo/?TB_iframe=true&width=600&height=550',
		'meta' => array( 
			'class' => 'gold',
			'target' => '_blank',
			'onclick' => 'jQuery(this).addClass("thickbox");'
			)
	) );
} 
add_action('admin_bar_menu', 'ekiline_bar_link', 100 ); 

function ekiline_admin_styles() {
	if ( !is_super_admin() )
		return;	
	$extracss = '.gold a::before { content: "\f511";} .gold a { background-color: #58aa03 !important; } .gold:hover a { background-color: #ffb900 !important; color: #fff !important; } .gold:hover a::before { content: "\f339"; color: #fff !important; }'; 				    
    wp_add_inline_style( 'wp-admin', $extracss );
    wp_add_inline_style( 'ekiline-style', $extracss );
}
add_action( 'admin_enqueue_scripts', 'ekiline_admin_styles' );
add_action( 'wp_enqueue_scripts', 'ekiline_admin_styles' );


/**
 * Javascript :
 * Jquery libraries (https://codex.wordpress.org/Function_Reference/wp_enqueue_script)
 * When scripts depend by JQuery has to be mentioned
 * Localize: es un método que wordpress ha habilitado para trabajar con variables de PHP en JS
 * Localize: JS and PHP working together
 * https://codex.wordpress.org/Function_Reference/wp_localize_script
 * ENE, creamos la función para extraer de manera correcta los estilos y parsearlos con js.
 */
 
function ekiline_loadcss() {
	
    $params = null;
    
    if( true === get_theme_mod('ekiline_loadcss') && !is_admin() && !current_user_can('administrator') ){
            
        global $wp_styles; 
        
    	// 4jun bueno!
        $ret = array();
        foreach( $wp_styles->queue as $handle) {
          wp_dequeue_style($handle);
          $ret[] = $wp_styles->registered[$handle]->src ;              
          //$ret[] = $wp_styles->registered[$handle] ;              
      	}        
        //echo json_encode( $ret );             
        $params = $ret;   
    
    }   
	
    wp_localize_script('ekiline-layout', 'allCss', $params); 
        
}
add_action( 'wp_enqueue_scripts', 'ekiline_loadcss' );

/**
 * Optimizar los scripts con async, esta funcion solo requiere el manejador
 * y se sobreescribira el link con el atributo dado. Por algun extraña razon no permite 
 * el agregar el atributo con el codigo de wordpress, como el caso de los scripts de IE.
 * Ad async or defer attribute scripts, it needs the handler, even if you install a new plugin.
 **/


function wsds_defer_scripts( $tag, $handle, $src ) {

	// invoco los scripts registrados en wordpress 
    global $wp_scripts;   
	// y agrupo en un array nuevo
    $alljs = array();
    foreach( $wp_scripts->queue as $jshandle ) {    	
		$alljs[] = $jshandle;              
  	} 
	// descartando los que necesito cargar al inicio
	// array_diff() o array_splice() : https://stackoverflow.com/questions/369602/php-delete-an-element-from-an-array
	$allowjs = array("jquery-core","popper-script","bootstrap-script");	
	$defer_scripts = array_diff( $alljs, $allowjs );
		
	// para que se inicialicen mis funciones correctamente.
    if ( in_array( $handle, $defer_scripts ) ) {
        return '<script src="' . $src . '" type="text/javascript" defer async></script>' . "\n";
    }    
    return $tag;
} 
add_filter( 'script_loader_tag', 'wsds_defer_scripts', 10, 3 );



/**
 * OPTIMIZACIoN: Registrar google analytics (customizer.php)
 * Add google analyitcs script
 * @link https://developers.google.com/analytics/devguides/collection/gajs/
 * @link https://digwp.com/2012/06/add-google-analytics-wordpress/
 **/
 

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


/**
 * OPTIMIZACIoN: Registrar páginas (customizer.php)
 * https://wordpress.stackexchange.com/questions/237100/how-to-add-meta-tag-to-wordpress-posts-filter
**/

function registerSite() {

//Indice en Google y Bing
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
