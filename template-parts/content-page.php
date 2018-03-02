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
		
    <header class="entry-header">

        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
        
        <div class="entry-meta">
            <?php ekiline_posted_on() ?>
        </div><!-- .entry-meta -->
                
    </header><!-- .entry-header -->

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
   	
	<footer class="entry-footer text-muted">
	    
       <?php ekiline_entry_footer(); ?>
           
	</footer><!-- .entry-footer -->
	
    <?php endif; ?>
	
	
</article><!-- #post-## -->

