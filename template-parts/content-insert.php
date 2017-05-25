<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ekiline
 *
 * En caso de tener imagen destacada o thumbanil dividir el contenido
 * If post have a thumbnail divide content
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
            	
	<?php if ( has_post_thumbnail() ) { $thumbCss = 'class="col-md-9"'; ?>
	    <div class="cat-thumb col-xs-3">
	    	<?php the_post_thumbnail( 'large', array( 'class' => 'img-responsive img-thumbnail' ));?>
	    </div>
	<?php } else { $thumbCss = 'class="col-md-12"'; } ?>
	
    <div <?php echo $thumbCss;?>>
    	<header class="page-header">
    		
    		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
    
    	</header><!-- .page-header -->
    
    	<div class="entry-content">
    	     <?php the_excerpt(); ?> 
    	              
    	</div><!-- .entry-content -->

	</div>
</article><!-- #post-## -->

