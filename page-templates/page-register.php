<?php
/**
 * Template Name: Registro
 * 
 * @package ekilinewp
 *
 * https://codex.wordpress.org/Customizing_the_Registration_Form
 * http://advent.squareonemd.co.uk/create-your-own-registration-form-in-wordpress/
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
    
        <h2>Tu registro</h2>
                
        <?php do_action ('process_customer_registration_form'); ?><!-- the hook to use to process the form -->
        
        <form method="POST" id="adduser" class="user-forms" action="">
        	<strong>Name</strong>
        	<p class="form-username">
        		<label for="user_name"><?php echo 'Username (required)'; ?></label>
        		<input class="text-input" name="user_name" type="text" id="user_name" value="" />
        	</p>
        	
        	<p class="form-email">
        		<label for="email"><?php echo 'E-mail (required)'; ?></label>
        		<input class="text-input" name="email" type="text" id="email" value="" />
        	</p>
        	
        	<p class="form-submit">
        		<input name="adduser" type="submit" id="addusersub" class="submit button" value="Register" />
        		<?php wp_nonce_field( 'add-user', 'add-nonce' ) ?><!-- a little security to process on submission -->
        		<input name="action" type="hidden" id="action" value="adduser" />
        	</p>
        </form>

        <p>Al finalizar el registro, revise su e-mail con instrucciones adicionales.</p>
    	
    <?php wp_footer(); ?>

    </body>
</html>