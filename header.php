<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ekiline
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<meta name="description" content="<?php getDescription(); ?>" />
<meta name="keywords" content="<?php getTags(); ?> " />

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
	
<?php topNavbar();topshortcode();topWidgets();videoHeader();?>  

<div id="page" class="site <?php wideSite(); ?>">

<?php if ( is_front_page() && get_header_image()){ /* en caso de tener una imagen de cabecera aparecer un header solo en el home */ ?>	
	<header id="masthead" class="site-header" role="banner">
	    
		<div class="site-branding jumbotron" <?php headerStyle(); ?>>
			<?php if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php endif;

			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) : ?>
				<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
			<?php endif; ?>
			
			<a class="skip-link screen-reader-text btn btn-sm btn-default" href="#content"><?php esc_html_e( 'Ir al contenido', 'ekiline' ); ?></a>

		</div><!-- .site-branding -->

	</header><!-- #masthead -->
<? } ?>

<?php primaryNavbar(); ?>	
	
<?php if( !is_front_page() && !is_archive() ) { destacadoStyle().breadcrumb(); } // breadcrumb e imagen destacada ?>
<?php if(is_archive() ) { categoryImage().breadcrumb(); } // imagen de categoría ?>

	<div id="content" class="site-content">
