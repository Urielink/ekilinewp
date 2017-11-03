<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package ekiline
 */
 
/**
 * Limpiar los caracteres especiales para otras funciones del tema
 * Clean special characters for more ekiline addons or customs.
 */
 
function ekiline_cleanspchar($text) {

    setlocale(LC_ALL, 'en_US.UTF8');
    $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
    $alias = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $text);
    $alias = strtolower(trim($alias, '-'));
    $alias = preg_replace("/[\/_|+ -]+/", "-", $alias);

    while (substr($alias, -1, 1) == "-") {
        $alias = substr($alias, 0, -1);
    }
    while (substr($alias, 0, 1) == "-") {
        $alias = substr($alias, 1, 100);
    }

    return $alias;
}

/**
 * Creamos nuevos tamaños de imagen para varios elmentos.
 * Add new image sizes
 * @link https://developer.wordpress.org/reference/functions/add_image_size/
 */
add_action( 'after_setup_theme', 'ekiline_theme_setup' );
function ekiline_theme_setup() {
    add_image_size( 'horizontal-slide', 960, 540, array( 'left', 'top' ) );
    add_image_size( 'vertical-slide', 540, 960, array( 'center', 'top' ) );
}
 
add_filter( 'image_size_names_choose', 'ekiline_custom_sizes' );
function ekiline_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'horizontal-slide' => __( 'Horizontal carousel', 'ekiline' ),
        'vertical-slide' => __( 'Vertical carousel', 'ekiline'  )
    ) );
}

/**
 * Agregar otras clases css al body para conocer el tipo de contenido.
 * Add custom css class to the array of body classes.
 */
 
function ekiline_body_css( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	//Page Slug Body Class
	global $post;
	if ( isset( $post ) ) {
		$classes[] = $post->post_type . '-' . $post->post_name;
	}
	
	// Theming: Ekiline services, Wireframe mode active, show bootstrap divs
	if( true === get_theme_mod('ekiline_wireframe') ){
        $classes[] = 'wf-ekiline';
	}
		
	return $classes;
}
add_filter( 'body_class', 'ekiline_body_css' );


/**
 * Customizer: Add theme colors (customizer.php).
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/wp_head
 */
 
function ekiline_csscolors() {
        
// Variables de color // Color values
    $bgcolor = '#'.get_background_color();
    $texto = get_option('text_color');
    $enlaces = get_option('links_color');
    $modulos = get_option('module_color');
    $menu = get_option('menu_color');
    $mgradient = get_option('menu_gradient');
    $footer = get_option('footer_color');
    $inverse = get_theme_mod('ekiline_inversemenu');
    // custom rounded elements
    $rangeLmnts = get_theme_mod('ekiline_range_lmnts');
        
    // Si no existen colores, añadir estos // add default value
    if ( !$texto ) : $texto = '#333333'; endif;
    if ( !$enlaces ) : $enlaces = '#337ab7'; endif;
    if ( !$modulos ) : $modulos = '#eeeeee'; endif;
    if ( !$footer ) : $footer = '#eeeeee'; endif;
    if ( $inverse ) : $inverse = '#ffffff;' ; endif;
        
    // Estilos en linea // inline styles
    $miestilo = '
        body{ color:'.$texto.'; }
        a:hover,a:focus,a:active{ color:'.$enlaces.';opacity:.6; }
        .page-title, .jumbotron .entry-title{color:'.$texto.';}
        .navbar-default { background-color:'.$menu.';}
        .navbar-inverse { background-color:'.$menu.';}
        .navbar-default .navbar-brand, .navbar-default .navbar-nav > li > a{ color:'.$texto.'; }
        .navbar-inverse .navbar-brand, .navbar-inverse .navbar-nav > li > a, a, h1 a, h2 a, h3 a, .pagination>li>a{ color:'.$enlaces.'; }
        .dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .dropdown-menu>.active>a:hover,
        .navbar-default .navbar-nav .open .dropdown-menu>.active>a, .navbar-default .navbar-nav .open .dropdown-menu>.active>a:focus, .navbar-default .navbar-nav .open .dropdown-menu>.active>a:hover{background-color:'.$enlaces.';}
        .pagination>.active>span,.pagination>.active>span:hover{background-color:'.$enlaces.';border-color:'.$enlaces.';}
        .site-footer { background-color: '.$footer.';}         
        .cat-thumb{background:url("'.get_site_icon_url().'") no-repeat center center / 100px;}
        .toggle-sidebars.left-on #secondary,.toggle-sidebars.right-on #third {background:'.$footer.';}
        #secondary{border-right:1px solid '.$modulos.';} #third{border-left:1px solid '.$modulos.';} .nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover{border: 1px solid '.$modulos.';}
        .modal-header, .nav-tabs{border-bottom: 1px solid '.$modulos.';} hr, .modal-footer{border-top: 1px solid '.$modulos.';}
        #pageLoad {width: 100%;height: 100%;position: fixed;text-align: center;z-index: 5000;top: 0;left: 0;right: 0;background-color:'.$bgcolor.';}  
        .breadcrumb, .bg-module { background-color:'.$modulos.'; }
        .carousel-indicators li,.popover-title,.popover,.tooltip-inner,.modal-content,.well-sm,.well-lg,.well,.progress,.alert,.thumbnail,.container .jumbotron,.container-fluid .jumbotron,.label,.navbar-toggle .icon-bar,.navbar-toggle,.nav-tabs-justified > li > a,.nav-pills > li > a,.nav-tabs.nav-justified > li > a,.input-group-addon.input-lg,.input-group-addon.input-sm,.input-group-addon,.input-group-sm > .form-control,.input-group-sm > .input-group-addon,.input-group-sm > .input-group-btn > .btn,.input-group-lg > .form-control,.input-group-lg > .input-group-addon,.input-group-lg > .input-group-btn > .btn,.form-control,.input-sm,.form-group-sm .form-control,.input-lg,.form-group-lg .form-control,.btn,.btn-lg,.btn-group-lg > .btn,.btn-sm,.btn-group-sm > .btn,.btn-sm,.btn-group-xs > .btn,.dropdown-menu,.pagination,.breadcrumb{border-radius:'.$rangeLmnts.'px;}        
        .nav-tabs > li > a{border-radius: '.$rangeLmnts.'px '.$rangeLmnts.'px 0px 0px;}
        .pagination>li:first-child>a, .pagination>li:first-child>span{border-top-left-radius: '.$rangeLmnts.'px;border-bottom-left-radius: '.$rangeLmnts.'px}
        .pagination>li:last-child>a, .pagination>li:last-child>span{border-top-right-radius: '.$rangeLmnts.'px;border-bottom-right-radius: '.$rangeLmnts.'px}
        ';
    // En caso de utilizar dos colores en el menú // if uses 2nd menu color    
    if ( $mgradient != '' ){
        $miestilo .= '
        .navbar-default, .navbar-inverse{
            background-image: -webkit-linear-gradient(top, '.$menu.' 0%, '.$mgradient.' 100%);
            background-image: -o-linear-gradient(top, '.$menu.' 0%, '.$mgradient.' 100%);
            background-image: -webkit-gradient(linear, left top, left bottom, from('.$menu.'), to('.$mgradient.'));
            background-image: linear-gradient(to bottom, '.$menu.' 0%, '.$mgradient.' 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="'.$menu.'", endColorstr="'.$mgradient.'", GradientType=0);
            border-color:'.$mgradient.';}              
        .navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .active > a,
        .navbar-inverse .navbar-nav > .open > a, .navbar-inverse .navbar-nav > .active > a {
            background-image: -webkit-linear-gradient(top, '.$mgradient.' 0%, '.$menu.' 100%);
            background-image: -o-linear-gradient(top, '.$mgradient.' 0%, '.$menu.' 100%);
            background-image: -webkit-gradient(linear, left top, left bottom, from('.$mgradient.'), to('.$menu.'));
            background-image: linear-gradient(to bottom, '.$mgradient.' 0%, '.$menu.' 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="'.$mgradient.'", endColorstr="'.$menu.'", GradientType=0);}';
    } else {
        $miestilo .= '.navbar-default, .navbar-inverse{background-color:'.$menu.';border-color:'.$menu.';background-image: none;}
        .navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:focus, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .current-menu-ancestor > a {background-color:rgba(0,0,0,.1)}
        .navbar-inverse .navbar-nav > .active > a, .navbar-inverse .navbar-nav > .active > a:focus, .navbar-inverse .navbar-nav > .active > a:hover, .navbar-inverse .navbar-nav > .current-menu-ancestor > a {background-color:rgba(0,0,0,.3)}
        ';
                
    }        

    echo '<style id="ekiline-inline" type="text/css" media="all">'.$miestilo.'</style>'."\n";

}
add_action('wp_head','ekiline_csscolors');


/**
 * Customizer: 
 * Establecer el ancho en cada pagina
 * Set CSS class width on #page
 **/

function ekiline_pagewidth() {
    
    if ( is_front_page() || is_home() ){
        echo get_theme_mod( 'ekiline_anchoHome', 'container' );
    }
    elseif ( is_single() || is_page() || is_search() || is_404() ){
        echo get_theme_mod( 'ekiline_anchoSingle', 'container' );
    }        
    elseif ( is_archive() || is_category() ){
        echo get_theme_mod( 'ekiline_anchoCategory', 'container' );
    }    
        
}

/**
 * Theming: 
 * Personalizar el formulario de busqueda
 * Override search form HTML
 **/
 
function ekiline_search_form( $form ) {
    
    $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
                <label class="screen-reader-text" for="s">' . esc_html__( 'Search Results for: %s', 'ekiline' ) . '</label>
                <div class="input-group">
                    <input class="form-control" type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . esc_html__( 'Search Results for:', 'ekiline' ) . '"/>
                    <span class="input-group-btn"><button class="btn btn-secondary" type="submit" id="searchsubmit"><i class="fa fa-search"></i> '. esc_attr__( 'Search', 'ekiline' ) .'</button></span>
                </div>
            </form>';

    return $form;
}

add_filter( 'get_search_form', 'ekiline_search_form' );


/**
 * Theming: 
 * Modificar el extracto
 * Excerpt override
 * @link https://codex.wordpress.org/Function_Reference/the_excerpt
 *
 **/

// Excerpt lenght 
function ekiline_excerpt_length( $length ) {
    
    $cutexcerpt = get_theme_mod('ekiline_cutexcerpt','');
    
    if (!$cutexcerpt){ $cutexcerpt = 20; }
    
    return $cutexcerpt;
}
add_filter( 'excerpt_length', 'ekiline_excerpt_length', 999 );

// Excerpt Button 
function ekiline_excerpt_button( $more ) {
    return '<p><a class="read-more btn btn-secondary" href="' . get_permalink( get_the_ID() ) . '">' . __( 'Read more', 'ekiline' ) . '</a></p>';
}
add_filter( 'excerpt_more', 'ekiline_excerpt_button' );


/**
 * Theming: Use a loader.
 **/
 

function ekiline_loader(){
             
    $loader = '<div id="pageLoad"><small class="loadtext">';
            if (get_site_icon_url()) {
                $loader .= '<img class="loadicon" src="'. get_site_icon_url() .'" alt="'. site_url() .'" width="100" height="100"/>'; 
            }
    $loader .= '<br/><noscript>'. __('Javascript is disabled','ekiline') .'</noscript>';
    $loader .= '<br/>'. __('Loading...','ekiline') .'</small></div>';    
    
    if( true === get_theme_mod('ekiline_loader') ){
        echo $loader;
    }
} 


/** 
 * Theming: 
 * Remover los shortcodes existentes en el extracto
 * Excerpt override and Remove [shortcode] items in excerpt: 
 * @link https://wordpress.org/support/topic/stripping-shortcodes-keeping-the-content
 * @link http://wordpress.stackexchange.com/questions/112010/strip-shortcode-from-excerpt 
 * @link **https://wordpress.org/support/topic/how-to-enable-shortcodes-in-excerpts
 **/

function wp_trim_excerpt_do_shortcode($text) {
	$raw_excerpt = $text;
	if ( '' == $text ) {
		$text = get_the_content('');

		$text = do_shortcode( $text ); 

		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]>', $text);
		$text = strip_tags($text);
		$excerpt_length = apply_filters('excerpt_length', 55);
		$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
		$words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
		if ( count($words) > $excerpt_length ) {
			array_pop($words);
			$text = implode(' ', $words);
			$text = $text . $excerpt_more;
		} else {
			$text = implode(' ', $words);
		}
	}
	return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'wp_trim_excerpt_do_shortcode');

/**
 * Theming: 
 * Paginacion para pages aplica solo en internas
 * Next and prevoius links for pages
 * @link https://codex.wordpress.org/Next_and_Previous_Links
 *
 **/

function ekiline_pages_navigation(){
    
    $thePages = '';
    $pagelist = get_pages('sort_column=menu_order&sort_order=asc');
    $pages = array();
    foreach ($pagelist as $page) {
       $pages[] += $page->ID;
    }

    $current = array_search(get_the_ID(), $pages);
    $prevID = (isset($pages[$current-1])) ? $pages[$current-1] : '';
    $nextID = (isset($pages[$current+1])) ? $pages[$current+1] : '';
    
    if (!empty($prevID)) {
        $thePages .= '<li class="previous page-item">';
        $thePages .= '<a class="page-link" href="'. get_permalink($prevID) .'" title="'. get_the_title($prevID) .'">'. __( '&larr; Previous', 'ekiline' ) .'</a>';
        $thePages .= "</li>";
    }
    if (!empty($nextID)) {
        $thePages .= '<li class="next page-item">';
        $thePages .= '<a class="page-link" href="'. get_permalink($nextID) .'" title="'. get_the_title($nextID) .'">'. __( 'Next &rarr;', 'ekiline' ) .'</a>';
        $thePages .= "</li>";      
    }
    
    $thePages = '<ul class="pagination pagination-sm justify-content-center">'.$thePages.'</ul>';
    
    if (!is_front_page()){
        echo $thePages;
    }
} 

/**
 * Theming: 
 * Paginacion para entradas o singles
 * Next and prevoius links for posts in archive or category
 * @link https://codex.wordpress.org/Next_and_Previous_Links
 * @link https://digwp.com/2016/10/wordpress-post-navigation-redux/
 *
 **/

function ekiline_posts_navigation( $args = array() ) {
    $navigation = '';
 
    // Don't print empty markup if there's only one page.
    if ( $GLOBALS['wp_query']->max_num_pages > 1 ) {
        $args = wp_parse_args( $args, array(
            'prev_text'          => __( 'Older posts', 'ekiline' ),
            'next_text'          => __( 'Newer posts', 'ekiline' ),
            'screen_reader_text' => __( 'Posts navigation', 'ekiline' ),
        ) );
 
        $next_link = get_previous_posts_link( $args['next_text'] . ' <span class="fa fa-angle-right"></span>' );
        $prev_link = get_next_posts_link( '<span class="fa fa-angle-left"></span> ' . $args['prev_text'] );
 
        if ( $prev_link ) {
            $navigation .= '<li class="previous page-item page-link">' . $prev_link . '</li>';
        }
 
        if ( $next_link ) {
            $navigation .= '<li class="next page-item page-link">' . $next_link . '</li>';
        }
        
        $navigation = '<ul class="pagination justify-content-center">'.$navigation.'</ul>';
 
        $navigation = _navigation_markup( $navigation, 'posts-navigation', $args['screen_reader_text'] );
    }
 
    echo $navigation;
}

/**
 * Theming: 
 * Paginacion para listados
 * Paginate links
 * @link https://codex.wordpress.org/Function_Reference/paginate_links
 * @link https://brinidesigner.com/wordpress-custom-pagination-for-bootstrap/
 **/

function ekiline_archive_pagination() {
    
    global $wp_query;
    $big = 999999999;
    $pagination = '';
    
    $pages = paginate_links(array(
                'base' => str_replace($big, '%#%', get_pagenum_link($big)),
                'format' => '?page=%#%',
                'current' => max(1, get_query_var('paged')),
                'total' => $wp_query->max_num_pages,
                'prev_next' => false,
                'type' => 'array',
                'prev_next' => TRUE,
                'prev_text' => __( '&larr; Previous', 'ekiline' ),
                'next_text' => __( 'Next &rarr;', 'ekiline' ),
            ));
            
    if (is_array($pages)) {
        
        $current_page = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
        
        $pagination .= '<ul class="pagination">';
        
        foreach ($pages as $i => $page) {
            //27 10 17 add CSS B4 pagination
            $page = str_replace( 'page-numbers', 'page-link', $page );			
			
            if ($current_page == 1 && $i == 0) {
                
                $pagination .= "<li class='page-item active'>$page</li>";
                
            } else {
                
                if ($current_page != 1 && $current_page == $i) {
                    
                    $pagination .= "<li class='page-item active'>$page</li>";
                    
                } else {
                    
                    $pagination .= "<li class='page-item'>$page</li>";
                    
                }
            }
            
        }
        
        $pagination .= '</ul>';
        
    }
    
    echo $pagination;
   
}


/**
 * Widgets: Set top widgets (header.php #25)
 **/

if ( ! function_exists ( 'topWidgets' ) ) {
    
	function topWidgets(){
		if ( is_active_sidebar( 'toppage-w1' ) ) {
		    return '<div class="row top-widgets">'.dynamic_sidebar( 'toppage-w1' ).'</div>';
		}
	}
}

/**
 * Customizer: Disable all media comments (customizer.php#371).
 **/
 
if( true === get_theme_mod('ekiline_mediacomment') ){
         
     function filter_media_comment_status( $open, $post_id ) {
        $post = get_post( $post_id );
        if( $post->post_type == 'attachment' ) {
            return false;
        }
        return $open;
    }
    add_filter( 'comments_open', 'filter_media_comment_status', 10 , 2 );

}



