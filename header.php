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

<?php topWidgets(); // en caso de widgets en la parte superior  ?>  
<?php topShortcode(); // de un shortcode que requiera mostrarse en la parte superior  ?>  
<?php topNavbar(); // en caso de un menu superior ?>  
<?php videoHeader(); // Cabecera con video  ?>  
<?php customHeader(); // header personalizado ?>

<div id="page" class="site <?php wideSite(); ?>">

<?php primaryNavbar(); // menu principal ?>		

	<div id="content" class="site-content">
	