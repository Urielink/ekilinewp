<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package ekiline
 */

get_header(); ?>
	
		<?php dynamic_sidebar( 'content-w1' ); ?>		
		
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/content', 'single' ); ?>

			<?php /** 10 27 2017 Custom pagination the_post_navigation(); 
			 		* https://codex.wordpress.org/Next_and_Previous_Links 
			 		* https://speckyboy.com/next-and-previous-links-on-wordpress-posts/ */?>

			<nav id="page-navigation" aria-label="Post navigation">
			  <ul class="pagination justify-content-center">
			    <li class="page-item page-link">
			    	<?php previous_post_link('%link', '%title', TRUE); ?>
			    </li>
			    <li class="page-item page-link">
			    	<?php next_post_link('%link', '%title', TRUE); ?>
			    </li>
			    
			  </ul>
			</nav>

			    

			<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			?>

		<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->

		<?php dynamic_sidebar( 'content-w2' ); ?>		
		
<?php get_footer(); ?>
