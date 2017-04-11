<?php
/**
 * Poner el sitio en modo de mantenimineto, ejercicio original:
 * https://www.nosegraze.com/maintenance-screen-wordpress/
 * 
 * @package ekiline
 */

/** Poner en modo de mantenimineto **/

function maintenace_mode() {

	if( true === get_theme_mod('ekiline_maintenance') ){
		
		global $pagenow;
		if ( $pagenow !== 'wp-login.php' && ! current_user_can( 'manage_options' ) && ! is_admin() ) {
			header( $_SERVER["SERVER_PROTOCOL"] . ' 503 Service Temporarily Unavailable', true, 503 );
			header( 'Content-Type: text/html; charset=utf-8' ); 
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<meta name="description" content="<?php getDescription(); ?>" />
		<link href="<?php echo get_template_directory_uri() . '/css/bootstrap.min.css'; ?>" rel="stylesheet" type="text/css">	
		<link href="<?php echo get_template_directory_uri() . '/css/font-awesome.min.css'; ?>" rel="stylesheet" type="text/css">	
		<link href="<?php echo get_template_directory_uri() . '/css/ekiline-layout.css'; ?>" rel="stylesheet" type="text/css">	
		<link href="<?php echo get_stylesheet_uri(); ?>" rel="stylesheet" type="text/css">	
		<title><?php echo get_bloginfo( 'name' ).' | '.__( 'Estamos en mantenimiento', 'ekiline' ) ?></title>
		<?php cssColors(); ?>
	</head>	
	<body class="page-maintenance">	

		<header id="masthead"  class="cover-wrapper">
			<div class="cover-wrapper-inner">
				<div class="cover-container">
					<div class="cover-header clearfix">
						<div class="inner">
							<img class="cover-header-brand" src="<?php echo get_theme_mod( 'ekiline_logo_min' ); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>"/>
							<nav> 
								<ul class="nav cover-header-nav">
									<li><a href="https://www.google.com/search?q=<?php echo get_site_url(); ?>" target="_blank"><i class="fa fa-google"></i></a></li>
									<li><a href="https://www.linkedin.com/" target="_blank"><i class="fa fa-linkedin"></i></a></li>
									<li><a href="https://es-la.facebook.com/" target="_blank"><i class="fa fa-facebook"></i></a></li>
									<li><a href="https://twitter.com/" target="_blank"><i class="fa fa-twitter"></i></a></li> 
								</ul>
							</nav>				
						</div>
					</div>
					
					<div class="inner cover">
					<h1 class="cover-title"><?php echo get_bloginfo( 'name' ); ?></h1>
					<p><mark class="cover-description"><?php echo __( 'Estamos en mantenimiento, muchas gracias por tu paciencia', 'ekiline' ) ?></mark></p>
					</div>
					
					<div class="cover-footer">
						<div class="inner">
			                <?php printf( esc_html__( '© Copyright ' . date('Y') . ' %1$s', 'ekiline' ), esc_attr( get_bloginfo( 'name', 'display' )) );?>
			                <span class="sep"> | </span>
			                <?php printf( esc_html__( 'Por %s', 'ekiline' ), '<a href="#autor">Autor</a>' ); ?>
			                <span class="sep"> | </span>
			                <?php printf( esc_html__( 'Proudly powered by %s', 'ekiline' ), '<a href="https://wordpress.org/">WordPress</a>' ); ?>						
						</div>
					</div>
				</div>
			</div>
		</header>		
		
	</body>
</html>			

<?php die();
		}
	}
}

add_action( 'wp_loaded', 'maintenace_mode' );