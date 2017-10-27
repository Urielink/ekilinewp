<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * Hacer un formulario de ingreso con shortcode.
 * Login shortcode
 * @link una version sencilla: https://wordpress.org/support/topic/front-end-login-using-php
 * @link Una version extesa:  http://www.codesynthesis.co.uk/tutorials/creating-a-custom-login-form-in-wordpress
 * @link Una version mejor explicada http://www.wavesolution.net/wordpress-login-page-customization/
 * @link La version Oficial: https://codex.wordpress.org/Customizing_the_Login_Form
 * @link Para verificar el codigo: https://github.com/WordPress/WordPress/blob/4.0/wp-includes/general-template.php#L400 
 *
 * @package ekiline 
 */

function ekiline_loginfrontend() {
    
	global $wp;
    $current_url = home_url(add_query_arg(array(),$wp->request));
    
		
	ob_start(); // abre 		

		// argumentos de formulario de acceso.
		
		$args = array(  
			'echo' => true,
            'redirect' => $current_url,   
		    //'redirect' => home_url(),   
			'form_id' => 'loginform',
			'label_username' => __( 'Username','ekiline' ),
			'label_password' => __( 'Password','ekiline' ),
			'label_remember' => __( 'Remember me','ekiline' ),
			'label_log_in' => __( 'Log in','ekiline' ),
			'id_username' => 'user',
			'id_password' => 'pass',
			'id_remember' => 'rememberme',
			'id_submit' => 'wp-submit',
			'remember' => true,
			'value_username' => '',
			'value_remember' => false, // Set this to true to default the "Remember me" checkbox to checked 
		   );

        $args = wp_parse_args( apply_filters( 'login_form_defaults', $args ) );
		
		$login_form_top = apply_filters( 'login_form_top', '', $args );
		$login_form_middle = apply_filters( 'login_form_middle', '', $args );
		$login_form_bottom = apply_filters( 'login_form_bottom', '', $args );   	
		
				
			// mensajes de error
				
			$login  = (isset($_GET['login']) ) ? $_GET['login'] : 0;
			
		    if ( $login === "failed" ) {  
		        echo '<p class="alert alert-warning">'.esc_html__( 'Invalid username or password', 'ekiline' ).'</p>';  
		    } elseif ( $login === "empty" ) {  
		        echo '<p class="alert alert-warning">'.esc_html__( 'Username or Password is empty', 'ekiline' ).'</p>';  
		    } elseif ( $login === "false" ) {  
		        echo '<p class="alert alert-warning">'.esc_html__( 'You are logged out', 'ekiline' ).'</p>';  
		    }
		    
		// imprime el formulario

			$form = '
				<form name="' . $args['form_id'] . '" id="' . $args['form_id'] . '" action="' . esc_url( site_url( 'wp-login.php', 'login_post' ) ) . '" method="post">
					' . $login_form_top . '
					<div class="form-group">
						<label for="' . esc_attr( $args['id_username'] ) . '">' . esc_html( $args['label_username'] ) . '</label>
						<input type="text" name="log" id="' . esc_attr( $args['id_username'] ) . '" class="input form-control" value="' . esc_attr( $args['value_username'] ) . '" size="20" />
					</div>
					<div class="form-group">
						<label for="' . esc_attr( $args['id_password'] ) . '">' . esc_html( $args['label_password'] ) . '</label>
						<input type="password" name="pwd" id="' . esc_attr( $args['id_password'] ) . '" class="input form-control" value="" size="20" />
					</div>
					' . $login_form_middle . '
					' . ( $args['remember'] ? '<p class="login-remember pull-right"><label><input name="rememberme" type="checkbox" id="' . esc_attr( $args['id_remember'] ) . '" value="forever"' . ( $args['value_remember'] ? ' checked="checked"' : '' ) . ' /> ' . esc_html( $args['label_remember'] ) . '</label></p>' : '' ) . '
					<div class="form-group">
						<input type="submit" name="wp-submit" id="' . esc_attr( $args['id_submit'] ) . '" class="btn btn-secondary btn-block" value="' . esc_attr( $args['label_log_in'] ) . '" />
						<input type="hidden" name="redirect_to" value="' . esc_url( $args['redirect'] ) . '" />
					</div>
					' . $login_form_bottom . '
				</form>';

				if ( $args['echo'] )
					echo $form;
				else
				
				return $form;
				
        // en caso de que esté habilitada la opción de registro mostrar enlace
        if ( get_option( 'users_can_register' ) ) {				
		  echo '<p class="text-center"><a class="btn btn-link" href="'.site_url('/wp-login.php?action=register').'">Registrarse</a></p>';
		  }
		  
  	$insertarLogin = ob_get_clean(); // cierra
  	
  	if (!is_user_logged_in()){
  	          	    
        return $insertarLogin;      
        
  	} else {
  	    
  	    // https://codex.wordpress.org/wp_get_current_user
        $current_user = wp_get_current_user();
    	
    	return '<div class="well">
            	   <h4>'. esc_html__( 'Hi ', 'ekiline' ) . $current_user->user_login .'</h4>
                   <p>'. esc_html__( 'Thank you for visit this website.', 'ekiline' ) .'</p>
      	           <a class="btn btn-danger" href="'. wp_logout_url(home_url()) .'">'. esc_html__( 'Exit', 'ekiline' ) .'</a>
	           </div>';    	  
    }
    		
}
		
add_shortcode('loginform', 'ekiline_loginfrontend');

/* si el usuario queda logeado Agrega un boton para cerrar la sesion, directo en el menu.
 * If user is logedin add a link to menu
 * @link https://support.woothemes.com/hc/en-us/articles/203106357-Add-Login-Logout-Links-To-The-Custom-Primary-Menu-Area
 */

function add_loginout_link( $items, $args ) {
    if (is_user_logged_in() && $args->theme_location == 'top') {
        $items .= '<li><a href="'. wp_logout_url(home_url()) .'">'.esc_html__( 'Exit', 'ekiline' ).'</a></li>';
    }
    return $items;
}
add_filter( 'wp_nav_menu_items', 'add_loginout_link', 10, 2 );

