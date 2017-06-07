<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ekiline
 */

get_header(); ?>
	
		<?php dynamic_sidebar( 'content-w1' ); ?>

		<main id="main" class="site-main woocommerce-main" role="main">

        <?php woocommerce_content(); ?>

		</main><!-- #main -->

		<?php dynamic_sidebar( 'content-w2' ); ?>		
		
<?php get_footer(); ?>
