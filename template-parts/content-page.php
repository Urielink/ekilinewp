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

	<div class="entry-content clearfix border-top pt-2 mt-2">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links text-center my-2">' . esc_html__( 'Pages:', 'ekiline' ),
				'after'  => '</div>',
			) );
		?>		          

	</div><!-- .entry-content -->

    <?php if ( !is_home() && ! is_front_page() ) : ?> 
   	
	<footer class="entry-footer page-footer bg-light px-2 mb-5">
	    
       <small><?php ekiline_entry_footer(); ?></small>
           
	</footer><!-- .entry-footer -->
	
    <?php endif; ?>
	
	
</article><!-- #post-## -->

