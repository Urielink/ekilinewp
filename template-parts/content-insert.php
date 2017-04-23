<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ekiline
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('row'); ?>>
            
	<?php // en caso de tener imagen destacada: Agrega este div, y la clase en el div de la entrada. ?>
	<?php if ( has_post_thumbnail() ) { $thumbCss = 'class="col-md-9"'; ?>
	    <div class="cat-thumb col-xs-3">
	    	<?php the_post_thumbnail( 'large', array( 'class' => 'img-responsive' ));?>
	    </div>
	<?php } else { $thumbCss = 'class="col-md-12"'; } ?>
	
    <div <?php echo $thumbCss;?>>
    	<header class="entry-header">
    		
    		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
    
    	</header><!-- .entry-header -->
    
    	<div class="entry-content row">
    	     <?php the_excerpt(); ?> 
    	              
    	</div><!-- .entry-content -->

	</div>
</article><!-- #post-## -->

