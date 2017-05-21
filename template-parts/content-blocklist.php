<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ekiline
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('col-md-4'); ?>>
        
        <div class="cat-thumb">
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                <?php the_post_thumbnail( 'medium', array( 'class' => 'img-responsive'));?>    
            </a>
        </div>
        
        <header class="entry-header">
                		
		<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
    
    	</header><!-- .entry-header -->
    
    	<div class="entry-content">
    	    
    	     <?php the_excerpt(); ?> 
    	              
    	</div><!-- .entry-content -->

</article><!-- #post-## -->

