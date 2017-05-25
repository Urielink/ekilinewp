<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package ekiline
 */
 
 /**
 * Clean special characters for more ekiline addons or customs.
 *
 * @param filter $text .
 * @return text without special characters.
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
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
 
function ekiline_body_classes( $classes ) {
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
add_filter( 'body_class', 'ekiline_body_classes' );


/**
 * Customizer: Add theme colors (customizer.php #36).
 *
 * @param array $classes Classes for the body element.
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/wp_head
 */
 
function cssColors() {
        
// Color values at theme install.       
    $bgcolor = '#'.get_background_color();
    $texto = get_option('text_color');
    $enlaces = get_option('links_color');
    $modulos = get_option('module_color');
    $menu = get_option('menu_color');
    $mgradient = get_option('menu_gradient');
    $footer = get_option('footer_color');
    $inverse = get_theme_mod('ekiline_inversemenu');
    
    // If values are not set by user, set this.
    if ( !$texto ) : $texto = '#333333'; endif;
    if ( !$enlaces ) : $enlaces = '#337ab7'; endif;
    if ( !$modulos ) : $modulos = '#eeeeee'; endif;
    if ( !$footer ) : $footer = '#eeeeee'; endif;
    if ( $inverse ) : $inverse = '#ffffff;' ; endif;
    
    // Inline CSS defined for theme.
    $miestilo = '
        body{ color:'.$texto.'; }
        a:hover,a:focus,a:active{ color:'.$modulos.'; }
        .navbar-inverse .navbar-text, .cover h1, .cover h2, .cover h3, .cover p{ color:'.$bgcolor.'; }
        .page-title, .jumbotron .entry-title, .site-main h1, .site-main h2, .site-main h3 {color:'.$texto.';}
        .page-maintenance{ background-color:'.$texto.'; }
        .navbar-default { background-color:'.$menu.'; }
        .navbar-inverse { background-color:'.$menu.'; }
        .navbar-default .navbar-brand, .navbar-default .navbar-nav > li > a{ color:'.$texto.'; }
        .navbar-inverse .navbar-brand, .navbar-inverse .navbar-nav > li > a, a, h1 a, h2 a, h3 a{ color:'.$enlaces.'; }
        .site-footer { background-color: '.$footer.';color:'.$inverse.';}         
        .cat-thumb{background:url("'.get_site_icon_url().'") no-repeat center center / 100px;}
        .toggle-sidebars.left-on #secondary,.toggle-sidebars.right-on #third {background:'.$footer.';}
        #secondary{border-right:1px solid '.$modulos.';} #third{border-left:1px solid '.$modulos.';}
        #page-load {width: 100%;height: 100%;position: fixed;text-align: center;z-index: 5000;top: 0;left: 0;right: 0;background-color:'.$bgcolor.';}
                
        ';
        
    if ( $mgradient != '' ){
        $miestilo .= '
        .navbar-default, .navbar-inverse {
            background-image: -webkit-linear-gradient(top, '.$menu.' 0%, '.$mgradient.' 100%);
            background-image: -o-linear-gradient(top, '.$menu.' 0%, '.$mgradient.' 100%);
            background-image: -webkit-gradient(linear, left top, left bottom, from('.$menu.'), to('.$mgradient.'));
            background-image: linear-gradient(to bottom, '.$menu.' 0%, '.$mgradient.' 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="'.$menu.'", endColorstr="'.$mgradient.'", GradientType=0);}              
        .navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .active > a,
        .navbar-inverse .navbar-nav > .open > a, .navbar-inverse .navbar-nav > .active > a {
            background-image: -webkit-linear-gradient(top, '.$mgradient.' 0%, '.$menu.' 100%);
            background-image: -o-linear-gradient(top, '.$mgradient.' 0%, '.$menu.' 100%);
            background-image: -webkit-gradient(linear, left top, left bottom, from('.$mgradient.'), to('.$menu.'));
            background-image: linear-gradient(to bottom, '.$mgradient.' 0%, '.$menu.' 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="'.$mgradient.'", endColorstr="'.$menu.'", GradientType=0);}';
    } else {
        $miestilo .= '.navbar-default, .navbar-inverse {background-color:'.$menu.';}
        .navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:focus, .navbar-default .navbar-nav > .active > a:hover {background-color:rgba(0,0,0,.1)}
        .navbar-inverse .navbar-nav > .active > a, .navbar-inverse .navbar-nav > .active > a:focus, .navbar-inverse .navbar-nav > .active > a:hover {background-color:rgba(0,0,0,.3)}
        ';
                
    }        

    echo '<style id="ekiline-inline" type="text/css" media="all">'.$miestilo.'</style>';

}
add_action('wp_head','cssColors');


/**
 * Customizer: Set CSS class width on #page
 **/


function wideSite() {
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
 * Theming: Override search form HTML
 **/
 
function my_search_form( $form ) {
    
    $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
                <label class="screen-reader-text" for="s">' . esc_html__( 'Search Results for: %s', 'ekiline' ) . '</label>
                <div class="input-group">
                    <input class="form-control" type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . esc_html__( 'Search Results for:', 'ekiline' ) . '"/>
                    <span class="input-group-btn"><input class="btn btn-default" type="submit" id="searchsubmit" value="'. esc_attr__( 'Search', 'ekiline' ) .'" /></span>
                </div>
            </form>';

    return $form;
}

add_filter( 'get_search_form', 'my_search_form' );


/**
 * Theming: Excerpt override
 * @link https://codex.wordpress.org/Function_Reference/the_excerpt
 *
 **/

// Excerpt lenght 
function custom_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

// Excerpt Button 
function customExcerptBtn( $more ) {
    return '<p><a class="read-more btn btn-default" href="' . get_permalink( get_the_ID() ) . '">' . __( 'Read more', 'ekiline' ) . '</a></p>';
}
add_filter( 'excerpt_more', 'customExcerptBtn' );

/** 
 * Theming: Excerpt override and Remove [shortcode] items in excerpt: 
 *	https://wordpress.org/support/topic/stripping-shortcodes-keeping-the-content
 *	http://wordpress.stackexchange.com/questions/112010/strip-shortcode-from-excerpt 
 *	**https://wordpress.org/support/topic/how-to-enable-shortcodes-in-excerpts
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
 * Theming: Next and prevoius links for pages
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
        $thePages .= '<li class="previous">';
        $thePages .= '<a href="'. get_permalink($prevID) .'" title="'. get_the_title($prevID) .'">'. __( '&larr; Previous', 'ekiline' ) .'</a>';
        $thePages .= "</li>";
    }
    if (!empty($nextID)) {
        $thePages .= '<li class="next">';
        $thePages .= '<a href="'. get_permalink($nextID) .'" title="'. get_the_title($nextID) .'">'. __( 'Next &rarr;', 'ekiline' ) .'</a>';
        $thePages .= "</li>";      
    }
    
    $thePages = '<ul class="pager">'.$thePages.'</ul>';
    
    echo $thePages;
    
} 

/**
 * Theming: Next and prevoius links for posts in archive or category
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
 
        $next_link = get_previous_posts_link( $args['next_text'] );
        $prev_link = get_next_posts_link( $args['prev_text'] );
 
        if ( $prev_link ) {
            $navigation .= '<li>' . $prev_link . '</li>';
        }
 
        if ( $next_link ) {
            $navigation .= '<li>' . $next_link . '</li>';
        }
        
        $navigation = '<ul class="pager">'.$navigation.'</ul>';
 
        $navigation = _navigation_markup( $navigation, 'posts-navigation', $args['screen_reader_text'] );
    }
 
    echo $navigation;
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

/* Funcion para eliminar los comentarios que aparecen en los adjuntos (media)*/
 
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



