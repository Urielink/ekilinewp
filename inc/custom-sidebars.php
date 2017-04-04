<?php
/**
 * Script para las acciones de los sidebars
 *
 * @package ekiline
 */

// cada sidebar tiene una variable.

$leftOn = get_theme_mod('ekiline_sidebarLeft','on');
$rightOn = get_theme_mod('ekiline_sidebarRight','on');


/* Función especial, condicionar el uso de clases CSS de acuerdo a formatos o contenidos específicos
 * Se inyecta una CSS en el body
 * https://codex.wordpress.org/Plugin_API/Filter_Reference/body_class
 * https://developer.wordpress.org/reference/functions/body_class/
 */

add_filter( 'body_class', function( $classes ) {
    
    //Llamo a mis variables
    global $leftOn, $rightOn;
    
    
    if ( $leftOn == 'off' && $rightOn == 'on' ) {
        return array_merge( $classes, array( 'toggle-sidebars left-on' ) );
    } elseif ( $rightOn == 'off' && $leftOn == 'on' ) {
        return array_merge( $classes, array( 'toggle-sidebars right-on' ) );
    } elseif ( $rightOn == 'off' && $leftOn == 'off' ) {
        return array_merge( $classes, array( 'toggle-sidebars right-on left-on' ) );
    } else {
        return array_merge( $classes, array( 'show-sidebars' ) );
    }   
    
} );



/* En caso de que el sidebar esté activo, añade la clase columna de 9: 
 *index.php, single.php, search.php, page.php, archive.php, 404.php */

function sideOn() {
    // debo sobreescribir la clase que actúa en conjunto con el grid, para darle prioridad al contenido (SEO).
    global $leftOn;
    
    if ($leftOn != 'off') { $gridFix = 'col-sm-push-3 '; }
    
    if ( is_active_sidebar( 'sidebar-1' ) && !is_active_sidebar( 'sidebar-2' ) ) {
             $sideon = ' col-sm-9 side1'; 
    } else if ( !is_active_sidebar( 'sidebar-1' ) && is_active_sidebar( 'sidebar-2' ) ) {
             $sideon = ' col-sm-9 side2'; 
    } else if ( is_active_sidebar( 'sidebar-1' ) && is_active_sidebar( 'sidebar-2' ) ) {
             $sideon = ' col-sm-6 '. $gridFix .'side1 side2'; 
    }     
    echo $sideon;
}

function gridCss() {

    // debo sobreescribir la clase que actúa en conjunto con el grid, para darle prioridad al contenido (SEO).
    global $rightOn;
    
    if ($rightOn != 'off') { $gridFix = ' col-sm-pull-6'; } else { $gridFix = ' col-sm-pull-9';}

    if ( is_active_sidebar( 'sidebar-1' ) && !is_active_sidebar( 'sidebar-2' ) ) {
             $gridCss = ' col-sm-3 col-sm-pull-6'; 
    } else if ( !is_active_sidebar( 'sidebar-1' ) && is_active_sidebar( 'sidebar-2' ) ) {
             $gridCss = ' col-sm-3'; 
    } else if ( is_active_sidebar( 'sidebar-1' ) && is_active_sidebar( 'sidebar-2' ) ) {
             $gridCss = ' col-sm-3'.$gridFix; 
    }     
    echo $gridCss;
}

// si se elige que los sidebars se oculten o muestren añade un boton al menu nav.

function add_sidebar_action( $items, $args ) {

    global $leftOn, $rightOn;
    
    if ($leftOn == 'off') {
        $items .= '<li><a href="#" id="show-sidebar-left">'.esc_html__( 'Sidebar Left', 'ekiline' ).'</a></li>';
    }

    if ($rightOn == 'off') {
        $items .= '<li><a href="#" id="show-sidebar-right">'.esc_html__( 'Sidebar Right', 'ekiline' ).'</a></li>';
    }
    
    return $items;
    
}
add_filter( 'wp_nav_menu_items', 'add_sidebar_action', 10, 2 );


function sidebarButtons(){

    global $leftOn, $rightOn;
    
    if ($leftOn == 'off') {
        $items .= '<a href="#" id="show-sidebar-left" class="btn btn-default btn-sbleft">'.esc_html__( 'Sidebar Left', 'ekiline' ).'</a>';
    }

    if ($rightOn == 'off') {
        $items .= '<a href="#" id="show-sidebar-right" class="btn btn-default btn-sbright">'.esc_html__( 'Sidebar Right', 'ekiline' ).'</a>';
    }
    
    echo $items; 
}

