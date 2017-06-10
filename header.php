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
<meta name="description" content="<?php ekiline_description(); ?>" />
<meta name="keywords" content="<?php ekiline_keywords(); ?> " />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>	
    
    <div id="pageLoad">
        <small class="loadtext">
            <?php if (get_site_icon_url()) : echo '<img class="loadicon" src="'. get_site_icon_url() .'" alt="'. site_url() .'" width="100" height="100"/>'; endif;?>
            <br/><noscript><?php echo __('Javascript is disabled','ekiline') ?></noscript>
            <br/><?php echo __('Loading...','ekiline') ?>
        </small>
    </div>

<?php topWidgets(); ?>  
<?php topNavbar(); ?>  
<?php customHeader(); ?>

<div id="page" class="site <?php ekiline_pagewidth(); ?>">
    
<?php primaryNavbar(); ?>     

	<div id="content" class="site-content">
	    
<?php breadcrumb(); ?>
	
		<div id="primary" class="content-area<?php sideOn(); ?>"><!-- // termina en footer.php -->
				
	