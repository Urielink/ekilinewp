<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ekiline
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('col-md-4 col-xs-6'); ?>>
        
    	<?php the_post_thumbnail( 'medium', array( 'class' => 'img-responsive' ));?>
    

    	<header class="entry-header">
    		
    		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
    
    	</header><!-- .entry-header -->
    
    	<div class="entry-content row">
    	     <?php the_excerpt(); ?> 
    	              
    	</div><!-- .entry-content -->

</article><!-- #post-## -->

