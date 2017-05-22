<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ekiline
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix row'); ?>>
    
	<?php /* En caso de tener imagen destacada (thumbnail):
	       * Se Agrega un div para dividir la informacion */ ?>

	<?php if ( has_post_thumbnail() ) { $thumbCss = 'col-md-8'; ?>
	
	    <div class="cat-thumb col-md-4">
	        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
	            <?php the_post_thumbnail( 'thumbnail', array( 'class' => 'img-thumbnail')); ?>
	        </a>
	    </div>
	    
	<?php } else { $thumbCss = 'col-md-12'; } ?>
	
    <div class="<?php echo $thumbCss;?>">
    	<header class="page-header">
    				  	    		
    		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
    
    		<?php if ( 'post' === get_post_type() ) : ?>
    		    
    		<div class="entry-meta">
    			<?php ekiline_posted_on(); ?>
    		</div><!-- .entry-meta -->

    		<?php endif; ?>
    	</header><!-- .page-header -->
    
    	<div class="entry-content">
    	    
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
    				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ekiline' ),
    				'after'  => '</div>',
    			) );
    		?>
    		
    	</div><!-- .entry-content -->
    
    	<footer class="entry-footer">
    		<?php ekiline_entry_footer(); ?>
    	</footer><!-- .entry-footer -->
	</div>
</article><!-- #post-## -->
