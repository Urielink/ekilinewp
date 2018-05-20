<?php
/**
 * Poner el sitio en modo de mantenimineto, ejercicio original
 * Put site on maintenance mode, original resource:
 * 
 * @package ekiline
 */

if( true === get_theme_mod('ekiline_maintenance') ){
 
    function maintenace_mode() {
		
		global $pagenow;
		if ( $pagenow !== 'wp-login.php' && !is_admin() && !current_user_can( 'edit_posts' ) ) {
		    
			header( $_SERVER["SERVER_PROTOCOL"] . ' 503 Service Temporarily Unavailable', true, 503 );
			header( 'Content-Type: text/html; charset=utf-8' ); 

            get_template_part( 'template-parts/content', 'maintenance' );
		
            die();
            
		}
	}
	
    add_action( 'wp_loaded', 'maintenace_mode' );
}