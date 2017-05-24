<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package ekiline
 */

//Hacer un formulario de ingreso con shortcode.
// una version sencilla: https://wordpress.org/support/topic/front-end-login-using-php
// Una version extesa:  http://www.codesynthesis.co.uk/tutorials/creating-a-custom-login-form-in-wordpress
// Una version mejor explicada http://www.wavesolution.net/wordpress-login-page-customization/
// La version Oficial: https://codex.wordpress.org/Customizing_the_Login_Form
// Para verificar el codigo: https://github.com/WordPress/WordPress/blob/4.0/wp-includes/general-template.php#L400

function ekiline_loginfrontend() {
		
	ob_start(); // abre 		

		// argumentos de formulario de acceso.
		
		$args = array(  
			'echo' => true,
		    'redirect' => home_url(),   
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
		   
//23mayo		$args = wp_parse_args( $args, apply_filters( 'login_form_defaults', $defaults ) );
        $args = wp_parse_args( apply_filters( 'login_form_defaults', $args ) );
		
		$login_form_top = apply_filters( 'login_form_top', '', $args );
		$login_form_middle = apply_filters( 'login_form_middle', '', $args );
		$login_form_bottom = apply_filters( 'login_form_bottom', '', $args );   	
		
		// Diseño para el formulario
		echo '<div class="col-md-6 col-md-offset-3">';
				
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
		//	wp_login_form( $args );	/*Si se quieren personalizar los campos */	
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
						<input type="submit" name="wp-submit" id="' . esc_attr( $args['id_submit'] ) . '" class="btn btn-default btn-block" value="' . esc_attr( $args['label_log_in'] ) . '" />
						<input type="hidden" name="redirect_to" value="' . esc_url( $args['redirect'] ) . '" />
					</div>
					' . $login_form_bottom . '
				</form>';

				if ( $args['echo'] )
					echo $form;
				else
				
				return $form;
				
		echo '<p class="text-center"><a class="btn btn-link" href="'.home_url('/registro').'">Registrarse</a></p>';
				    		
		echo '</div>';
		    			

  	$insertarLogin = ob_get_clean(); // cierra
 
    return $insertarLogin;		
    		
	}
		
add_shortcode('loginform', 'ekiline_loginfrontend');

// Validaciones del formulario:
	
	function login_failed() {  
	    $login_page  = home_url( '/acceso' );  
	    wp_redirect( $login_page . '?login=failed' );  
	    exit;  
	}  
	add_action( 'wp_login_failed', 'login_failed' );  
	  
	function verify_username_password( $user, $username, $password ) {  
	    $login_page  = home_url( '/acceso' );  
	    if( $username == "" || $password == "" ) {  
	        wp_redirect( $login_page . "?login=empty" );  
	        exit;  
	    }  
	}  
	add_filter( 'authenticate', 'verify_username_password', 1, 3);
	
	

/**
 * Hacer un formulario de solicitud o registro  con shortcode; 2 situaciones:
 * 1 se debe crear la funcion que valide la informacion y genere el correo.
 * Esta varia por el uso de un plugin que envia una notificacion al dueño del portal.
 * 2 se genera el formulario que se insertara con el shortcode, este llama la funcion
 * de las validaciones.
 */

// 1) Inicia funcion proceso de de registro 
 
function registration_process_hook() {
    
    $new_user = null;
    $error = null;
    
	if (isset($_POST['adduser']) && isset($_POST['add-nonce']) && wp_verify_nonce($_POST['add-nonce'], 'add-user')) {
	
		// die if the nonce fails
		if ( !wp_verify_nonce($_POST['add-nonce'],'add-user') ) {
			wp_die(esc_html__( 'Sorry! Security first', 'ekiline' ));
		} else {
			// auto generate a password
            $user_pass = wp_generate_password();
			// setup new user
			$userdata = array(
                'user_pass' => $user_pass,
				'user_login' => esc_attr( $_POST['user_name'] ),
				'user_email' => esc_attr( $_POST['email'] ),
				'role' => get_option( 'default_role' ),
			);
			// setup some error checks
			if ( !$userdata['user_login'] )
				$error = esc_html__( 'A username is required for registration', 'ekiline' );
			elseif ( username_exists($userdata['user_login']) )
				$error = esc_html__( 'Sorry, that username already exists!', 'ekiline' );
			elseif ( !is_email($userdata['user_email'], true) )
				$error = esc_html__( 'You must enter a valid email address', 'ekiline' );
			elseif ( email_exists($userdata['user_email']) )
				$error = esc_html__( 'Sorry, that email address is already used!', 'ekiline' );
			// setup new users and send notification
			else{
				$new_user = wp_insert_user( $userdata );
                wp_new_user_notification($new_user, $user_pass);
			}
		}
	}
	if ( $new_user ) : ?>

	<!-- create and alert message to show successful registration -->
	<?php
		$user = get_user_by('id',$new_user);
		echo '<p class="alert alert-success">'.esc_html__( 'Thank you for registering', 'ekiline' ) . '<strong>' . $user->user_login . '</strong><br/>' . esc_html__( 'Please check your email for recieve your login password (Be sure to check your spam folder).', 'ekiline' ).'</p>';
	?>
	
	<?php else : ?>
	
		<?php if ( $error ) : ?>
			<p class="alert alert-warning"><!-- echo errors if users fails -->
				<?php echo $error; ?>
			</p>
		<?php endif; ?>
	
	<?php endif;

}
add_action('process_customer_registration_form', 'registration_process_hook'); 
 
// Finaliza 1) funcion proceso de de registro  


// 2) Inicia Shortcode que crea el formulario en el tema.

function ekiline_registerfrontend() {
		
	ob_start(); // abre 		?>
	
	<div class="col-md-6 col-md-offset-3">
		
	<?php do_action ('process_customer_registration_form'); ?>

	<form method="POST" id="adduser" class="form" action="">
		<div class="form-group">
			<label for="user_name"><?php echo esc_html__( 'Username', 'ekiline' ); ?></label>
			<input class="input form-control" name="user_name" type="text" id="user_name" value="" />
		</div>
		
		<p class="form-group">
			<label for="email"><?php echo esc_html__( 'E-mail', 'ekiline' ); ?></label>
			<input class="input form-control" name="email" type="text" id="email" value="" />
		</p>
		
		<p class="form-group">
			<input name="adduser" type="submit" id="addusersub" class="btn btn-default btn-block" value="<?php echo esc_html__( 'Request acces', 'ekiline' ); ?>" />
			<?php wp_nonce_field( 'add-user', 'add-nonce' ) ?><!-- a little security to process on submission -->
			<input name="action" type="hidden" id="action" value="adduser" />
		</p>
	</form>
	<p class="text-center"><a class="btn btn-link" href="<?php echo home_url(); ?>">Ingresar al sitio</a></p>
	</div>
	
<?php  $insertarRegistro = ob_get_clean(); // cierra
 
    return $insertarRegistro;		
    		
	}
	
add_shortcode('registerform', 'ekiline_registerfrontend');

// Finaliza 2) Shortcode que crea el formulario en el tema.


/** Una vez logeado **/


// Deshabilitar la barra de Administracion para el suscriptor:
// https://developer.wordpress.org/reference/functions/is_user_logged_in/
/**
	function remove_admin_bar() {
		if (!current_user_can('administrator') && !is_admin()) {
		  show_admin_bar(false);
		}
	}  
	add_action('after_setup_theme', 'remove_admin_bar');
**/
// redirigir la pagina de acceso al home que debe ser.

// function redirect() {
  // // se ha creado un acceso a un apartado de registro.
  // if ( !is_user_logged_in() && !is_page(array('Acceso','Registro')) ) {
      // wp_redirect( home_url('/acceso') );
      // die();
  // } else if ( is_user_logged_in() && is_page(array('Acceso','Registro')) ) {
      // wp_redirect( home_url() );
      // die();
  // }    
// }
// add_action( 'wp', 'redirect' );


// si el usuario queda logeado Agrega un boton para cerrar la sesion, directo en el menu.
// https://support.woothemes.com/hc/en-us/articles/203106357-Add-Login-Logout-Links-To-The-Custom-Primary-Menu-Area

function add_loginout_link( $items, $args ) {
    if (is_user_logged_in() && $args->theme_location == 'top') {
        $items .= '<li><a href="'. wp_logout_url(home_url()) .'">'.esc_html__( 'Exit', 'ekiline' ).'</a></li>';
    }
    return $items;
}
add_filter( 'wp_nav_menu_items', 'add_loginout_link', 10, 2 );

// descartar la pagina de ingreso de las busquedas
// http://wordpress.stackexchange.com/questions/142811/exclude-pages-from-wordpress-search-result-page

function exclude_pages_search_when_logged_in($query) {
    if ( $query->is_search && is_user_logged_in() )
        $query->set( 'post__not_in', array( 49 ) ); 
    return $query;
}
add_filter( 'pre_get_posts', 'exclude_pages_search_when_logged_in' );
