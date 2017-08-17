<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ekiline
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
	
	<?php if ( !is_home() && ! is_front_page() ) : ?> 
		
	<header class="page-header">

        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	  	
	  	<?php ekiline_posted_on() ?>
	  		  	
	</header><!-- .page-header -->

	<?php endif; ?>

	<div class="entry-content clearfix">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ekiline' ),
				'after'  => '</div>',
			) );
		?>		          

	</div><!-- .entry-content -->

    <?php if ( !is_home() && ! is_front_page() ) : ?> 
        
	<footer class="entry-footer text-muted clearfix">
	    
       <?php ekiline_entry_footer(); ?>
           
	</footer><!-- .entry-footer -->
	
    <?php endif; ?>
	
	
</article><!-- #post-## -->

