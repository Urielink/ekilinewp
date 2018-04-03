<?php
/**
 * ekiline functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ekiline
 */

// Estilos // Styles
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {

	// permitir el uso del tema minificado // allow minified file
	$located = locate_template( 'style.min.css' );
	if ($located != '' ) {
		wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.min.css', array(), '1.0', 'all' );	
    } else {
		wp_enqueue_style( 'parent-style', get_stylesheet_uri() );	
    }	
	
}
