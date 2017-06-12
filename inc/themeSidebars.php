<?php
/**
 * Script para las acciones de los sidebars
 * Sidebars activity
 * 
 * @package ekiline
 */
// Si el widget está activo: https://codex.wordpress.org/Function_Reference/is_active_widget
// is_active_sidebar(), is_active_widget(), is_dynamic_sidebar();
 
/**
 * Agrega clase css para habilitar sidebars
 * Add css to enable or disable Ekiline sidebars
 * @link  https://codex.wordpress.org/Plugin_API/Filter_Reference/body_class
 * @link  https://developer.wordpress.org/reference/functions/body_class/
 */

add_filter( 'body_class', function( $classes ) {
    
    //Llamo a mis variables
    $leftOn = get_theme_mod('ekiline_sidebarLeft','on');
    $rightOn = get_theme_mod('ekiline_sidebarRight','on');    
    
    if ( $leftOn == 'off' && $rightOn == 'on' ) {
        return array_merge( $classes, array( 'toggle-sidebars left-on' ) );
    } elseif ( $rightOn == 'off' && $leftOn == 'on' ) {
        return array_merge( $classes, array( 'toggle-sidebars right-on' ) );
    } elseif ( $rightOn == 'off' && $leftOn == 'off' ) {
        return array_merge( $classes, array( 'toggle-sidebars right-on left-on' ) );
    } else {
        return array_merge( $classes, array( 'static-sidebars' ) );
    }   
    
});

/* En caso de estar activos los sidebars, cambia la clase del contenedor principal y los sidebars.
 * Este fragmento afecta a la container: index.php, single.php, search.php, page.php, archive.php, 404.php 
 * If sidebars active, change width of each column (index.php, single.php, search.php, page.php, archive.php, 404.php )
 */

function sideOn() {
    
    //Llamo a mis variables
    $leftOn = get_theme_mod('ekiline_sidebarLeft','on');
    $rightOn = get_theme_mod('ekiline_sidebarRight','on');
        
    $sideon = '';
    
    if ( is_active_sidebar( 'sidebar-1' ) && !is_active_sidebar( 'sidebar-2' ) ) {
        
        if ($leftOn == 'off') : $sideon = ' toggle-side1';  
        else : $sideon = ' col-sm-9 pull-right side1'; endif;
        
    } else if ( !is_active_sidebar( 'sidebar-1' ) && is_active_sidebar( 'sidebar-2' ) ) {
        
        if ($rightOn == 'off') : $sideon = ' toggle-side2';  
        else : $sideon = ' col-sm-9 side2'; endif;            
        
    } else if ( is_active_sidebar( 'sidebar-1' ) && is_active_sidebar( 'sidebar-2' ) ){

        if ($leftOn == 'off' && $rightOn == 'off' ) : $sideon = ' toggle-bothsides';  
        elseif ($leftOn == 'off' && $rightOn != 'off' ) : $sideon = ' col-sm-9 toggle-side1'; 
        elseif ($leftOn != 'off' && $rightOn == 'off' ) : $sideon = ' col-sm-9 pull-right toggle-side2'; 
        else : $sideon = ' col-sm-6 col-sm-push-3 side1 side2'; endif;              
        
    } else if ( !is_active_sidebar( 'sidebar-1' ) && !is_active_sidebar( 'sidebar-2' ) ) {
        // si ninguno                        
         $sideon = ' no-sidebars'; 
    } 
        
    echo $sideon;
}

/*
 * Estos 2 fragmentos Agregan una clase a cada sidebar
 * afectan a sidebar.php y sidebar-right.php 
 * Add class to each sidebar (sidebar.php, sidebar-right.php)
 */

function leftSideOn() {    
    //Llamo a mis variables
    $leftOn = get_theme_mod('ekiline_sidebarLeft','on');
    $rightOn = get_theme_mod('ekiline_sidebarRight','on');
    
    if ( is_active_sidebar( 'sidebar-1' ) && !is_active_sidebar( 'sidebar-2' ) ) {
        echo ' col-sm-3 pull-left';
    } elseif ( is_active_sidebar( 'sidebar-1' ) && is_active_sidebar( 'sidebar-2' ) ) {
        if ($leftOn != 'off' && $rightOn == 'off' ) : echo ' col-sm-3 pull-left';
        elseif ($leftOn == 'off' && $rightOn == 'off' ) : echo ' col-sm-3';
        else : echo ' col-sm-3 col-sm-pull-6'; endif;          
    }
}

function rightSideOn() {    
    if ( is_active_sidebar( 'sidebar-2' ) ) : echo ' col-sm-3'; endif;     
}

/* Añadimos los botones a los sidebars, 
 * afectan a sidebar.php y sidebar-right.php 
 * Add buttons to hide/show sidebars (sidebar.php y sidebar-right.php)
 */
 
function leftSideButton(){
    $leftOn = get_theme_mod('ekiline_sidebarLeft','on');    
    if ( is_active_sidebar( 'sidebar-1' ) && $leftOn == 'off') : echo '<button id="show-sidebar-left" class="sidebar-toggle btn-sbleft" type="button"><span class="icon-bar"></span><span class="icon-bar"></span></button>'; endif;
}

function rightSideButton(){
    $rightOn = get_theme_mod('ekiline_sidebarRight','on');        
    if ( is_active_sidebar( 'sidebar-2' ) && $rightOn == 'off') : echo '<button id="show-sidebar-right" class="sidebar-toggle btn-sbright" type="button"><span class="icon-bar"></span><span class="icon-bar"></span></button>'; endif;
}
