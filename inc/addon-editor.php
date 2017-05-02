<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 * Info: https://developer.wordpress.org/reference/functions/add_editor_style/
 *
 * @package ekiline
 */

/**
 * Añadir estilos al editor de wordpress (no requiere una función):
 */

// add_editor_style('editor-style.css'); 
add_editor_style('editor-style.css'); 

/**
 * Registers an editor stylesheet for the current theme.
 */
function wpdocs_theme_add_editor_styles() {
    $font_url = str_replace( ',', '%2C', '//fonts.googleapis.com/css?family=Lato:300,400,700' );
    add_editor_style( $font_url );
}
add_action( 'after_setup_theme', 'wpdocs_theme_add_editor_styles' ); 
 
