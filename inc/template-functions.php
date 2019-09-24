<?php
/**
 * Functions which enhance the theme by hooking into WordPress
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
    add_image_size( 'square', 540, 540, array( 'center', 'top' ) );
}
 
add_filter( 'image_size_names_choose', 'ekiline_custom_sizes' );
function ekiline_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'horizontal-slide' => __( 'Horizontal carousel', 'ekiline' ),
        'vertical-slide' => __( 'Vertical carousel', 'ekiline'  ),
        'square' => __( 'Squares', 'ekiline'  )
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
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function ekiline_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'ekiline_pingback_header' );


/**
 * Customizer: Add theme colors (customizer.php).
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/wp_head
 */
 
function ekiline_csscolors() {
        
// Variables de color // Color values
    $bgcolor = '#'.get_background_color();
    $texto = get_option('text_color');
    $enlaces = get_option('links_color');
    $menu = get_option('menu_color');
    $mgradient = get_option('menu_gradient');
    $footer = get_option('footer_color');
    $inverse = get_theme_mod('ekiline_inversemenu');
    // custom rounded elements
    $rangeLmnts = get_theme_mod('ekiline_range_lmnts');
        
    // Si no existen colores, añadir estos // add default value
    if ( !$texto ) : $texto = '#333333'; endif;
    if ( !$enlaces ) : $enlaces = '#007bff'; endif;
    if ( !$footer ) : $footer = '#eeeeee'; endif;
    if ( $inverse ) : $inverse = '#ffffff;' ; endif;
    if ( $rangeLmnts == '' || '0' ) : $rangeLmnts = '0' ; endif;
        
    // Estilos en linea // inline styles
    $miestilo = '
        body{ color:'.$texto.'; }
        a:hover,a:focus,a:active{ color:'.$enlaces.';opacity:.6; }
        .page-title, .jumbotron .entry-title{color:'.$texto.';}
        .navbar.navbar-light.bg-light { background-color:'.$menu.' !important;}
        .navbar.navbar-dark.bg-dark { background-color:'.$menu.' !important;}
        .navbar-light .navbar-brand, .navbar-light .navbar-nav > li > a{ color:'.$texto.'; }
        .navbar-dark .navbar-brand, .navbar-dark .navbar-nav > li > a, a, h1 a, h2 a, h3 a, .pagination>li>a, .page-link, .page-link:hover{ color:'.$enlaces.'; }
        .dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .dropdown-menu>.active>a:hover,
        .navbar-light .navbar-nav .show .dropdown-menu>.active>a, .navbar-light .navbar-nav .show .dropdown-menu>.active>a:focus, .navbar-light .navbar-nav .show .dropdown-menu>.active>a:hover,.bg-link{background-color:'.$enlaces.';}
        .page-item.active .page-link, .btn-primary, .btn-outline-primary:hover{background-color:'.$enlaces.';border-color:'.$enlaces.';}
        .btn-outline-primary{border-color:'.$enlaces.';color:'.$enlaces.';}
        .site-footer { background-color: '.$footer.';}         
        .cat-thumb{background:url("'.get_site_icon_url().'") no-repeat center center / 100px;}
        .toggle-sidebars.left-on #secondary,.toggle-sidebars.right-on #third,.bg-footer{background:'.$footer.';}
        #pageLoad {width: 100%;height: 100%;position: fixed;text-align: center;z-index: 5000;top: 0;left: 0;right: 0;background-color:'.$bgcolor.';}  
        .carousel-indicators li,.popover-title,.popover,.tooltip-inner,.modal-content,.progress,.alert,.thumbnail,.container .jumbotron,.container-fluid .jumbotron,.label,.navbar-toggle .icon-bar,.navbar-toggle,.nav-tabs-justified > li > a,.nav-pills > li > a,.nav-tabs.nav-justified > li > a,.input-group-addon.input-lg,.input-group-addon.input-sm,.input-group-addon,.input-group-sm > .form-control,.input-group-sm > .input-group-addon,.input-group-sm > .input-group-btn > .btn,.input-group-lg > .form-control,.input-group-lg > .input-group-addon,.input-group-lg > .input-group-btn > .btn,.form-control,.input-sm,.form-group-sm .form-control,.input-lg,.form-group-lg .form-control,.btn,.btn-lg,.btn-group-lg > .btn,.btn-sm,.btn-group-sm > .btn,.btn-sm,.btn-group-xs > .btn,.dropdown-menu,.pagination,.breadcrumb{border-radius:'.$rangeLmnts.'px;}        
        .nav-tabs > li > a{border-radius: '.$rangeLmnts.'px '.$rangeLmnts.'px 0px 0px;}
        .pagination-sm .page-item:first-child .page-link{border-top-left-radius: '.$rangeLmnts.'px;border-bottom-left-radius: '.$rangeLmnts.'px}
        .pagination-sm .page-item:last-child .page-link{border-top-right-radius: '.$rangeLmnts.'px;border-bottom-right-radius: '.$rangeLmnts.'px}
        ';
    // En caso de utilizar dos colores en el menú // if uses 2nd menu color    
    if ( $mgradient != '' ){
        $miestilo .= '
        .navbar-light, .navbar-dark{
            background-image: -webkit-linear-gradient(top, '.$menu.' 0%, '.$mgradient.' 100%);
            background-image: -o-linear-gradient(top, '.$menu.' 0%, '.$mgradient.' 100%);
            background-image: -webkit-gradient(linear, left top, left bottom, from('.$menu.'), to('.$mgradient.'));
            background-image: linear-gradient(to bottom, '.$menu.' 0%, '.$mgradient.' 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="'.$menu.'", endColorstr="'.$mgradient.'", GradientType=0);}              
        .navbar-light .navbar-nav > .show > a, .navbar-light .navbar-nav > .active > a,
        .navbar-dark .navbar-nav > .show > a, .navbar-dark .navbar-nav > .active > a {
            background-image: -webkit-linear-gradient(top, '.$mgradient.' 0%, '.$menu.' 100%);
            background-image: -o-linear-gradient(top, '.$mgradient.' 0%, '.$menu.' 100%);
            background-image: -webkit-gradient(linear, left top, left bottom, from('.$mgradient.'), to('.$menu.'));
            background-image: linear-gradient(to bottom, '.$mgradient.' 0%, '.$menu.' 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="'.$mgradient.'", endColorstr="'.$menu.'", GradientType=0);}';
    } else {
        $miestilo .= '.navbar-light, .navbar-dark{background-color:'.$menu.';background-image: none;}
        .navbar-light .navbar-nav > .active > a, .navbar-light .navbar-nav > .active > a:focus, .navbar-light .navbar-nav > .active > a:hover, .navbar-light .navbar-nav > .current-menu-ancestor > a {background-color:rgba(0,0,0,.1)}
        .navbar-dark .navbar-nav > .active > a, .navbar-dark .navbar-nav > .active > a:focus, .navbar-dark .navbar-nav > .active > a:hover, .navbar-dark .navbar-nav > .current-menu-ancestor > a {background-color:rgba(0,0,0,.3)}
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
    
    $form = '<form role="search" method="get" id="searchform" class="searchform my-2" action="' . home_url( '/' ) . '" >
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

// Excerpt button y etiqueta <!--more-->
function ekiline_excerpt_button() {
    return '<p><a class="read-more btn btn-primary" href="' . get_permalink( get_the_ID() ) . '">' . __( 'Read more', 'ekiline' ) . '</a></p>';
}
add_filter( 'excerpt_more', 'ekiline_excerpt_button' );
add_filter('the_content_more_link', 'ekiline_excerpt_button', 10, 2);

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
 * Enero 2018, este arreglo cicla algunos elementos. Es necesario verificar el resto.
 **/

// function wp_trim_excerpt_do_shortcode($text) {
	// $raw_excerpt = $text;
	// if ( '' == $text ) {
		// $text = get_the_content('');
// 
		// $text = do_shortcode( $text ); 
// 
		// $text = apply_filters('the_content', $text);
		// $text = str_replace(']]>', ']]>', $text);
		// $text = strip_tags($text);
		// $excerpt_length = apply_filters('excerpt_length', 55);
		// $excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
		// $words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
		// if ( count($words) > $excerpt_length ) {
			// array_pop($words);
			// $text = implode(' ', $words);
			// $text = $text . $excerpt_more;
		// } else {
			// $text = implode(' ', $words);
		// }
	// }
	// return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
// }
// remove_filter('get_the_excerpt', 'wp_trim_excerpt');
// add_filter('get_the_excerpt', 'wp_trim_excerpt_do_shortcode');

/**
 * Theming: 
 * Paginacion para pages aplica solo en internas
 * Next and prevoius links for pages
 * @link https://codex.wordpress.org/Next_and_Previous_Links
 *
 **/

function ekiline_pages_navigation(){
    
	if ( is_front_page() ){		
        return;
    }	
	
	if ( class_exists( 'WooCommerce' ) ) {
		if ( is_cart() || is_checkout() || is_account_page() ){		
	        return;
	    }	
	}
	
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
        $thePages .= '<a class="page-link" href="'. get_permalink($prevID) .'" title="'. get_the_title($prevID) .'"><span class="fa fa-chevron-left"></span> '. get_the_title($prevID) .'</a>';
        $thePages .= "</li>";
    }
    if (!empty($nextID)) {
        $thePages .= '<li class="next page-item">';
        $thePages .= '<a class="page-link" href="'. get_permalink($nextID) .'" title="'. get_the_title($nextID) .'">'. get_the_title($nextID) .' <span class="fa fa-chevron-right"></span></a>';
        $thePages .= "</li>";      
    }
    
    $thePages = '<ul class="pagination pagination-sm justify-content-between">'.$thePages.'</ul>';
    
    //if (!is_front_page()){
        echo $thePages;
    //}
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
 
        $next_link = get_previous_posts_link( $args['next_text'] . ' <span class="fa fa-chevron-right"></span>' );
        $prev_link = get_next_posts_link( '<span class="fa fa-chevron-left"></span> ' . $args['prev_text'] );
 
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


/** 
 * Theming Admin theme page
 * Admin bar button
 * https://codex.wordpress.org/Plugin_API/Action_Reference/wp_before_admin_bar_render
 * https://codex.wordpress.org/Javascript_Reference/ThickBox
 * Y con estilos agregados.
 * https://codex.wordpress.org/Function_Reference/wp_add_inline_style
 * https://gist.github.com/corvannoorloos/43980115659cb5aee571
 * https://wordpress.stackexchange.com/questions/36394/wp-3-3-how-to-add-menu-items-to-the-admin-bar
 * https://wordpress.stackexchange.com/questions/266318/how-to-add-custom-submenu-links-in-wp-admin-menus
 */

function ekiline_bar() {

	global $wp_admin_bar;

	// if ( !is_admin_bar_showing() )
		// return;	
	
		$wp_admin_bar->add_menu( array(
			'id' => 'goekiline',
			'title' => __( 'FundMe', 'ekiline'),
			// 'href' => 'http://ekiline.com/fondeo/?TB_iframe=true&width=600&height=550',
			'href' => 'http://ekiline.com/fondeo/',
			'meta' => array( 
				'class' => 'gold',
				'target' => '_blank'
				//'onclick' => 'jQuery(this).addClass("thickbox");'
				),
	        'parent' => 'top-secondary'		
		) );
		
} 
add_action('admin_bar_menu', 'ekiline_bar', 0 ); 


/* subitem https://wordpress.stackexchange.com/questions/66498/add-menu-page-with-different-name-for-first-submenu-item 
 * http://wpsites.net/wordpress-admin/add-top-level-custom-admin-menu-link-in-dashboard-to-any-url/
 * https://developer.wordpress.org/reference/functions/add_ menu_page/
 * https://wordpress.stackexchange.com/questions/1039/adding-an-arbitrary-link-to-the-admin-menu
 * // add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
 */

// add_action( 'admin_menu', 'register_ekiline_menu_page' );
// function register_ekiline_menu_page() {
  // add_menu_page( 
  	// 'Ekiline Menu Page Title', 
  	// __( 'FundMe', 'ekiline'), 
  	// //'manage_options', 
  	// 'edit_posts', 
  	// 'themes.php?theme=ekiline',
  	// '', 
  	// 'dashicons-carrot', 
  	// null );
// }

// add_action( 'admin_footer', 'ekiline_menu_page_js' );
// function ekiline_menu_page_js() { 
	// echo "<script type='text/javascript'>\n";
	// //echo "jQuery('li#toplevel_page_themes-theme-ekiline a').addClass('gold thickbox').attr('href', 'http://ekiline.com/fondeo/?TB_iframe=true&width=600&height=550').attr('target', '_blank');";
	// echo "jQuery('li#toplevel_page_themes-theme-ekiline a').addClass('gold').attr('href', 'http://ekiline.com/fondeo/').attr('target', '_blank');";
	// echo "\n</script>";
// }

function ekiline_theme_page() {
    add_theme_page( 
    	'Ekiline Menu Page Title', 
    	__( 'About Ekiline', 'ekiline'), 
    	'edit_posts', 
    	'ekiline_options', 
    	'theme_html_page',
    	'dashicons-chart-pie'
	);
}
add_action( 'admin_menu', 'ekiline_theme_page' );
 
function theme_html_page() { 
	//add_thickbox(); ?>
<div class="wrap">
	<h1><span class="dashicons dashicons-layout" aria-hidden="true"></span> <?php _e('About Ekiline for Wordpress','ekiline'); ?></h1>
    
	<div id="welcome-panel" class="welcome-panel">
		
		<div class="welcome-panel-content">
	
			<h2><?php _e('Thanks for using this theme!','ekiline'); ?></h2>
			<hr />
			<p class="about-description"><?php _e('Find more information to improve your skills in the personalization of your site.','ekiline'); ?></p>
				
			<div class="welcome-panel-column-container">
				<div class="welcome-panel-column">
					<div style="padding:4px;">
						<h3><?php _e('Get the definitive version, with more benefits for the distribution of your projects:','ekiline'); ?></h3>
						<ul>
							<li><span class="dashicons dashicons-book dash-note"></span><?php _e('Quick use guide for your clients, in Keynote and Power Point format for editing.','ekiline'); ?></li>
							<li><span class="dashicons dashicons-edit dash-note"></span><?php _e('CSS complementary designs for general theme.','ekiline'); ?></li>
							<li><span class="dashicons dashicons-layout dash-note"></span><?php _e('HTML structures preloaded for use in publications.','ekiline'); ?></li>
							<li><span class="dashicons dashicons-welcome-view-site dash-note"></span><?php _e('Complete theme, without external links, ads or tips.','ekiline'); ?></li>
						</ul>
						<p>
							<a class="button button-primary button-hero" href="<?php _e('http://ekiline.com/compra/','ekiline'); ?>" target="_blank"><span class="dashicons dashicons-cart"></span> <?php _e('Buy and download','ekiline'); ?></a>
						</p>
						<p><span class="dashicons dashicons-carrot"></span> <?php _e('You can also','ekiline'); ?> <a href="<?php _e('http://ekiline.com/fondeo/','ekiline'); ?>" target="_blank"><?php _e('fund the development','ekiline'); ?></a> 
							<?php _e('or','ekiline'); ?> <a href="<?php _e('http://ekiline.com/gana/','ekiline'); ?>" target="_blank"><?php _e('earn money','ekiline'); ?></a> <?php _e('by helping.','ekiline'); ?></p>
					</div>
				</div>
				<div class="welcome-panel-column">
					<div style="padding:4px;">
						<h3><?php _e('About','ekiline'); ?></h3>
						<p><?php _e('Ekiline simplifies the creation of a website with Wordpress, it is a working method that brings together the standard practices of the internet industry, to facilitate the tasks of planning, design, development and optimization. For more information visit ekiline.com','ekiline'); ?></p>
						<p><strong><?php _e('Limited liability','ekiline'); ?></strong></p>
						<p><small><?php _e('As a courtesy, we provide information on how to use certain third-party products, but we do not directly support their use and we are not responsible for the functions, reliability or compatibility of such products. The names, trademarks and logos of third parties are registered trademarks of their respective owners.','ekiline'); ?></small></p>
					</div>
				</div>
				<div class="welcome-panel-column welcome-panel-last">
					<div style="padding:4px;">
						<h3><?php _e('Documentation','ekiline'); ?></h3>
						<ul>
							<li><a href="<?php _e('http://ekiline.com/instala/','ekiline'); ?>" target="_blank"> <?php _e('Installation','ekiline'); ?></a></li>
							<li><a href="<?php _e('http://ekiline.com/personaliza/','ekiline'); ?>" target="_blank"> <?php _e('Personalization','ekiline'); ?></a></li>
							<li><a href="<?php _e('http://ekiline.com/elementos/','ekiline'); ?>" target="_blank"> <?php _e('Elements and shortcodes','ekiline'); ?></a></li>
							<li><a href="<?php _e('http://ekiline.com/compatible/','ekiline'); ?>" target="_blank"> <?php _e('Compatibility','ekiline'); ?></a></li>
							<li><?php _e('Edit your HTML presets:','ekiline'); ?></li>
							<li><a href="<?php _e('theme-editor.php?file=template-parts%2Fcustom-layouts.php&theme=ekiline','ekiline'); ?>" target="_blank"> <?php _e('Custom presets','ekiline'); ?></a></li>
						</ul>
					</div>
				</div>
			</div>			
	
		</div>
	</div>   
	<p style="text-align: right;"><small><?php printf( esc_html__( '&copy; Copyright %1$s Ekiline', 'ekiline' ), esc_attr( date('Y') ) );?>. <?php _e('All rights reserved. Ekiline is a development of','ekiline'); ?> <a href="<?php _e('https://bixnia.com/','ekiline'); ?>" target="_blank"> <?php _e('B&nbsp;I&nbsp;X&nbsp;N&nbsp;I&nbsp;A','ekiline'); ?></a></small></p>
    
</div>
<?php }


function ekiline_admin_styles() {
	// if ( !is_super_admin() )
		// return;	
	$extracss = '.gold a::before { content: "\f511";} .gold a{ background-color: #58aa03 !important; } .gold:hover a{ background-color: #ffb900 !important; color: #fff !important; } .gold:hover a::before { content: "\f339"; color: #fff !important; }'; 				    
	$extracss .= '.advice a::before { content: "\f325";} .advice a { background-color: #ff7e00 !important; } .advice:hover a { background-color: #ff7e00 !important; color: #fff !important; } .advice:hover a::before { content: "\f325"; color: #fff !important; }'; 				    
	$extracss .= 'a.gold{ background-color: #58aa03 !important; } a.gold:hover{ background-color: #ffb900 !important; color: #fff !important; } a.gold:hover .dashicons-carrot::before {content: "\f339";color: #fff !important;}'; 				    
	$extracss .= '.dash-note{margin: 0px 10px 0px 0px;float: left;font-size: 20px;}'; 				
    wp_add_inline_style( 'wp-admin', $extracss );
    wp_add_inline_style( 'ekiline-style', $extracss );
}
add_action( 'admin_enqueue_scripts', 'ekiline_admin_styles');
add_action( 'wp_enqueue_scripts', 'ekiline_admin_styles');

/*
 * Noticias para el suscriptor de Ekiline
 * https://codex.wordpress.org/Function_Reference/fetch_feed
 * https://codex.wordpress.org/Plugin_API/Action_Reference/admin_notices
 */
 
function ekiline_docs_feed() {
//variables para noticias	
global $pagenow;
$pages = array('index.php','edit.php','post.php','themes.php','tools.php');
if ( is_admin() && in_array( $pagenow, $pages, true ) ){

	// Get RSS Feed(s)
	include_once( ABSPATH . WPINC . '/feed.php' );
	
	// Get a SimplePie feed object from the specified feed source.
	$rss = fetch_feed( 'http://ekiline.com/feed/' );
	
	$maxitems = 0;
	
	if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly
	
	    // Figure out how many total items there are, but limit it to 5. 
	    $maxitems = $rss->get_item_quantity( 20 ); 
	
	    // Build an array of all the items, starting with element 0 (first element).
	    $rss_items = $rss->get_items( 0, $maxitems );
		
		// order in notices: http://php.net/manual/es/function.shuffle.php
		shuffle($rss_items);	
	
	endif;
		
?>
    <div class="notice notice-success is-dismissible ekiline-notice" style="display: none;">
    	<h4 style="float:left;margin:13px 5px 0px;"><?php _e( 'Ekiline tips:', 'ekiline' ); ?></h4>
    	<a class="button button-primary" style="float:right;margin:8px 4px;" href="http://ekiline.com/gana/" target="_blank"><?php _e( 'Make money', 'ekiline' ); ?> <i class="far fa-money-bill-alt"></i></a>
    	<a class="button button-primary" style="float:right;margin:8px 4px;" href="http://ekiline.com/compra/" target="_blank"><?php _e( 'Get more', 'ekiline' ); ?></a>
    	<a class="button button-primary" style="float:right;margin:8px 4px;" href="themes.php?page=ekiline_options"><?php _e( 'About', 'ekiline' ); ?></a>
		<ul>
		    <?php if ( $maxitems == 0 ) : ?>
		        <li><?php _e( 'Connection not established', 'ekiline' ); ?></li>
		    <?php else : ?>
		    	<?php $i = 1; // en caso de querer mostrar menos noticias; ?>
		        <?php // Loop through each feed item and display each item as a hyperlink. ?>
		        <?php foreach ( $rss_items as $item ) : ?>
		            <li>
		                <a href="<?php echo esc_url( $item->get_permalink() ); ?>"
		                   title="<?php printf( __( 'Posted %s', 'ekiline' ), $item->get_date('j F Y | g:i a') ); ?>"
		                   target="_blank">
		                    <?php echo esc_html( $item->get_title() ); ?>
		                </a>
		            </li>
		            <?php if ($i++ == 1) break; ?>
		        <?php endforeach; ?>
		    <?php endif; ?>
		</ul>  
    </div>

<?php
	}
}
add_action( 'admin_notices', 'ekiline_docs_feed' );

function ekiline_docs_feed_set() {
global $pagenow;
$pages = array('index.php','edit.php','post.php','themes.php','tools.php');
if ( in_array( $pagenow, $pages, true ) ) { ?>	
	
<script type='text/javascript'>
	jQuery(document).ready(function($){
		//$('.ekiline-notice').show(1).delay(1000).hide(1);
		$('.ekiline-notice').delay(2000).show(100);
	});
</script>

<?php }
}
add_action( 'admin_footer', 'ekiline_docs_feed_set' );


/**
 * Fontawesome helper
 *
function ekiline_faw() {

	global $wp_admin_bar;

	// if ( !is_admin_bar_showing() )
		// return;	
	
		$wp_admin_bar->add_menu( array(
			'id' => 'fawekiline',
			'title' => __( 'FAw5', 'ekiline'),
			'href' => 'http://127.0.0.1:8020/pruebas-rapidas/fa5gen.html?TB_iframe=true&width=600&height=550',
			'meta' => array( 
				'class' => 'fawfive',
				'target' => '_blank',
				'onclick' => 'jQuery(this).addClass("thickbox");'
				),
	        //'parent' => 'top-secondary'		
		) );
		
} 
add_action('admin_bar_menu', 'ekiline_faw', 80 ); 
 * 
 */
 
/*
 * Personalizar el formulario de proteccion de lectura.
 * https://developer.wordpress.org/reference/functions/get_the_password_form/
 */
function ekiline_password_form() {
    global $post;
    $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
    $output = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" class="post-password-form form-inline col-sm-8 p-4 mx-auto text-center" method="post">';
    $output .= '<p>' . __( 'This content is password protected. To view it please enter your password below:','ekiline' ) . '</p>';
    $output .= '<div class="form-inline"><label for="' . $label . '">' . __( 'Password:','ekiline' ) . ' </label>';
    $output .= '<input class="form-control" name="post_password" id="' . $label . '" type="password" size="20" />';
    $output .= '<input class="btn btn-secondary" type="submit" name="Submit" value="' . esc_attr_x( 'Enter', 'post password form', 'ekiline' ) . '" /></div></form>';
    return $output;
} 
add_filter( 'the_password_form', 'ekiline_password_form' );
 