<?php
/**
 * Script para las acciones de los sidebars
 *
 * @package ekiline
 */

// Global, sidebar activas
$sideLeft = is_active_sidebar( 'sidebar-1' );
$sideRight = is_active_sidebar( 'sidebar-2' ); 

// Global, sidebar plegable
$leftOn = get_theme_mod('ekiline_sidebarLeft','on');
$rightOn = get_theme_mod('ekiline_sidebarRight','on');


/* Funcion especial, condicionar el uso de clases CSS de acuerdo a formatos o contenidos especificos
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
        return array_merge( $classes, array( 'static-sidebars' ) );
    }   
    
} );

/* En caso de estar activos los sidebars, cambia la clase del contenedor principal y los sidebars.
 * Este fragmento afecta a la container: index.php, single.php, search.php, page.php, archive.php, 404.php 
 */

function sideOn() {
    
    //Llamo a mis variables
    global $sideLeft, $sideRight, $leftOn, $rightOn;
            
    if ( $sideLeft && !$sideRight ) {
        // si el sidebar izquierdo existe y no el derecho        
        if ($leftOn == 'off') : $sideon = ' toggle-side1';  
        else : $sideon = ' col-sm-9 pull-right side1'; endif;
        
    } else if ( !$sideLeft && $sideRight ) {
        // si el sidebar derecho existe y no el izquierdo                
        if ($rightOn == 'off') : $sideon = ' toggle-side2';  
        else : $sideon = ' col-sm-9 side2'; endif;            
              
    } else if ( $sideLeft && $sideRight ) {
        // si ambos sidebars existen                
        if ($leftOn == 'off' && $rightOn == 'off' ) : $sideon = ' toggle-bothsides';  
        elseif ($leftOn == 'off' && $rightOn != 'off' ) : $sideon = ' col-sm-9 toggle-side1'; 
        elseif ($leftOn != 'off' && $rightOn == 'off' ) : $sideon = ' col-sm-9 pull-right toggle-side2'; 
        else : $sideon = ' col-sm-6 col-sm-push-3 side1 side2'; endif;       
                                     
    } else if ( !$sideLeft && !$sideRight ) {
        // si ninguno                        
         $sideon = ' no-sidebars'; 
    }     
    echo $sideon;
}

/* Estos 2 fragmentos Agregan una clase a cada sidebar
 * afectan a sidebar.php y sidebar-right.php 
 */

function leftSideOn() {    
    //Llamo a mis variables
    global $sideLeft, $sideRight, $leftOn, $rightOn;
                
    if ( $sideLeft && !$sideRight ) {
        echo ' col-sm-3 pull-left';
    } elseif ( $sideLeft && $sideRight ) {
        if ($leftOn != 'off' && $rightOn == 'off' ) : echo ' col-sm-3 pull-left';
        elseif ($leftOn == 'off' && $rightOn == 'off' ) : echo ' col-sm-3';
        else : echo ' col-sm-3 col-sm-pull-6'; endif;          
    }
}

function rightSideOn() {    
    //Llamo a mis variables
    global $sideRight;            
    if ( $sideRight ) : echo ' col-sm-3'; endif;     
}

/* Añadimos los botones a los sidebars, 
 * afectan a sidebar.php y sidebar-right.php 
 */
 
function leftSideButton(){
    global $sideLeft, $leftOn;
    if ( $sideLeft && $leftOn == 'off') : echo '<button id="show-sidebar-left" class="sidebar-toggle btn-sbleft" type="button"><span class="icon-bar"></span><span class="icon-bar"></span></button>'; endif;
}

function rightSideButton(){
    global $sideRight,$rightOn;    
    if ( $sideRight && $rightOn == 'off') : echo '<button id="show-sidebar-right" class="sidebar-toggle btn-sbright" type="button"><span class="icon-bar"></span><span class="icon-bar"></span></button>'; endif;
}

// PRUEBA: si se elige que los sidebars se oculten o muestren Agrega un boton al menu nav.
// function add_sidebar_action( $items, $args ) {
    // global $leftOn, $rightOn;    
        // if ($leftOn == 'off') : $items .= '<li><a href="#" id="show-sidebar-left">'.esc_html__( 'Left sidebar', 'ekiline' ).'</a></li>'; endif;
        // if ($rightOn == 'off') : $items .= '<li><a href="#" id="show-sidebar-right">'.esc_html__( 'Right sidebar', 'ekiline' ).'</a></li>'; endif;    
    // return $items;    
// }
// add_filter( 'wp_nav_menu_items', 'add_sidebar_action', 10, 2 );


