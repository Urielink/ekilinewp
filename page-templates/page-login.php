<?php
/**
 * Template Name: Login
 * 
 * @package ekiline
 *
 * https://ahmadawais.com/create-front-end-login-page-wordpress/
 * http://wordpress.stackexchange.com/questions/16004/redirect-user-to-original-url-after-login
 * https://codex.wordpress.org/Function_Reference/wp_login_form
 *
 * https://codex.wordpress.org/Customizing_the_Registration_Form
 *
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>


<section class="aa_loginForm">
        <?php 
            global $user_login;
            // In case of a login error.
            if ( isset( $_GET['login'] ) && $_GET['login'] == 'failed' ) : ?>
    	            <div class="aa_error">
    		            <p><?php __( 'FAILED: Try again!','ekiline' ); ?></p>
    	            </div>
            <?php 
                endif;
            // If user is already logged in.
            if ( is_user_logged_in() ) : ?>

                <div class="aa_logout"> 
                    
                    <?php 
                        __( 'Hello','ekiline' ); 
                        echo $user_login; 
                    ?>
                    
                    </br>
                    
                    <?php __( 'You are already logged in','ekiline' ); ?>

                </div>

                <a id="wp-submit" href="<?php echo wp_logout_url(); ?>" title="Logout">
                    <?php __( 'Exit','ekiline' ); ?>
                </a>

            <?php 
                // If user is not logged in.
                else: 
                
                    // Login form arguments.
                    $args = array(
                        'echo'           => true,
//                        'redirect'       => home_url( '/wp-admin/' ), 
                          'redirect'       => home_url(), 
                        'form_id'        => 'loginform',
                        'label_username' => __( 'Username','ekiline' ),
                        'label_password' => __( 'Password','ekiline' ),
                        'label_remember' => __( 'Remember me','ekiline' ),
                        'label_log_in'   => __( 'Log in','ekiline' ),
                        'id_username'    => 'user_login',
                        'id_password'    => 'user_pass',
                        'id_remember'    => 'rememberme',
                        'id_submit'      => 'wp-submit',
                        'remember'       => true,
                        'value_username' => NULL,
                        'value_remember' => true
                    ); 
                    
                    // Calling the login form.
                    wp_login_form( $args );
                endif;
        ?> 

</section>

	
<?php wp_footer(); ?>
</body>
</html>