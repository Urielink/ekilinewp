<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ekiline
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
    
    	<header class="entry-header">
    				  	    		
    		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
    
    		<?php if ( 'post' === get_post_type() ) : ?>
    		    
    		<small class="entry-meta">
    			<?php ekiline_posted_on(); ?>
    		</small><!-- .entry-meta -->

    		<?php endif; ?>
    	</header><!-- .entry-header -->
    
    	<div class="entry-content clearfix border-top pt-2 mt-2">

            <?php if ( has_post_thumbnail() ) { ?>
            
                <div class="cat-thumb float-left mr-2 my-1">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <?php the_post_thumbnail( 'thumbnail', array( 'class' => 'img-thumbnail')); ?>
                    </a>
                </div>
                
            <?php } ?>
    	    
    	    
    		<?php
    		// or use the_content()
    			the_excerpt( sprintf(
    				// translators: %s: Name of current post. //
    				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'ekiline' ), array( 'span' => array( 'class' => array() ) ) ),
    				the_title( '<span class="screen-reader-text">"', '"</span>', false )
    			) );
    		?>
          
    		<?php
    			wp_link_pages( array(
    				'before' => '<div class="page-links text-center my-2">' . esc_html__( 'Pages:', 'ekiline' ),
    				'after'  => '</div>',
    			) );
    		?>
    		
    	</div><!-- .entry-content -->
    
    	<footer class="entry-footer page-footer bg-light px-2 mb-5">
    		<small><?php ekiline_entry_footer(); ?></small>
    	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
