<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package ekiline
 */

get_header(); ?>

	<div id="primary" class="content-area<?php sideOn(); ?>">
		
		<?php breadcrumb(); ?>
	
		<?php dynamic_sidebar( 'content-w1' ); ?>		
		
		<main id="main" class="site-main<?php mainContainer(); ?>" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/content', 'single' ); ?>

			<?php the_post_navigation(); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			?>

		<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->

		<?php dynamic_sidebar( 'content-w2' ); ?>		
		
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_sidebar('right'); ?>
<?php get_footer(); ?>
