<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ekiline
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
	<?php // en caso de tener imagen destacada: añade este div, y la clase en el div de la entrada. ?>
	<?php if ( has_post_thumbnail() ) { $thumbCss = 'class="col-md-9"'; ?>
	    <div class="cat-thumb col-md-3" style="min-height:120px;background:url('<?php destacadoUrl(); ?>') transparent no-repeat scroll center center / cover ;"></div>
	<?php } else { $thumbCss = 'class="col-md-12"'; } ?>
	
    <div <?php echo $thumbCss;?>>
    	<header class="entry-header">
    				  	
		  	<?php miniDate();?>
    		
    		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
    
    		<?php if ( 'post' === get_post_type() ) : ?>
    		<div class="entry-meta">
    			<?php ekiline_posted_on(); ?>
    		</div><!-- .entry-meta -->
    		<?php endif; ?>
    	</header><!-- .entry-header -->
    
    	<div class="entry-content row">
    	     <?php the_excerpt(); ?> 
    	    
    		<?php /**
    			the_content( sprintf(
    				// translators: %s: Name of current post. //
    				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'ekiline' ), array( 'span' => array( 'class' => array() ) ) ),
    				the_title( '<span class="screen-reader-text">"', '"</span>', false )
    			) ); **/
    		?>
          
    		<?php
    			wp_link_pages( array(
    				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ekiline' ),
    				'after'  => '</div>',
    			) );
    		?>
    	</div><!-- .entry-content -->
    
    	<footer class="entry-footer row">
    		<?php ekiline_entry_footer(); ?>
    	</footer><!-- .entry-footer -->
	</div>
</article><!-- #post-## -->
