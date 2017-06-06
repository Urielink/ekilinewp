<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * https://developer.wordpress.org/reference/functions/has_post_thumbnail/
 *
 * @package ekiline
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
    <?php if ( has_post_thumbnail() ){?>
                
        <a class="link-image" href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark" style="background-image:url(<?php the_post_thumbnail_url() ;?>)">             
            
        	<?php the_post_thumbnail( 'horizontal-slide', array( 'class' => 'img-responsive img-thumbnail' ));?>
        	
        </a>
        
    <?php }?>

        <div class="carousel-caption">
        		
        	<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
        	
            <?php the_excerpt(); ?> 
    
    	</div>
	
	
</article><!-- #post-## -->

