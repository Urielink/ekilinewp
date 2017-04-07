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

<?php topNavbar(); // en caso de un menu superior ?>  
<?php topshortcode(); // de un shortcode que requiera mostrarse en la parte superior  ?>  
<?php topWidgets(); // en caso de widgets en la parte superior  ?>  
<?php videoHeader(); // en caso de cabecera con video  ?>  

<div id="page" class="site <?php wideSite(); ?>">

<?php customHeader(); // header personalizado ?>

<?php primaryNavbar(); // menu principal ?>		

<?php if( !is_front_page() ) : breadcrumb(); endif; // breadcrumb e imagen destacada ?>

	<div id="content" class="site-content">
