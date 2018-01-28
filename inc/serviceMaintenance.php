<?php
/**
 * Poner el sitio en modo de mantenimineto, ejercicio original
 * Put site on maintenance mode, original resource:
 * https://www.nosegraze.com/maintenance-screen-wordpress/
 * https://codex.wordpress.org/Function_Reference/is_customize_preview
 * https://codex.wordpress.org/Function_Reference/is_preview
 * 
 * @package ekiline
 */

// if customizer checked
if( true === get_theme_mod('ekiline_maintenance') ){
 
    function maintenace_mode() {
		
		global $pagenow;
		if ( $pagenow !== 'wp-login.php' && ! current_user_can( 'manage_options' ) && ! is_admin() ) {
		    
			header( $_SERVER["SERVER_PROTOCOL"] . ' 503 Service Temporarily Unavailable', true, 503 );
			header( 'Content-Type: text/html; charset=utf-8' ); 

            get_template_part( 'template-parts/content', 'maintenance' );
		
            die();
            
		}
	}
	
    add_action( 'wp_loaded', 'maintenace_mode' );
}