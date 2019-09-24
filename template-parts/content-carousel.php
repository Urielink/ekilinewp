<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * https://developer.wordpress.org/reference/functions/has_post_thumbnail/
 *
 * @package ekiline
 */
 $thumbClass = '';
 if ( !has_post_thumbnail() ){ $thumbClass = 'no-thumb'; }

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $thumbClass ); ?>>
    
    <?php if ( has_post_thumbnail() ){?>
                
        <a class="link-image" href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">             
            
        	<?php the_post_thumbnail( 'horizontal-slide', array( 'class' => 'img-fluid' ));?>
        	
        </a>
        
    <?php }?>

        <div class="carousel-caption p-5">
        		
        	<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
        	
            <?php the_excerpt(); ?> 
    
    	</div>
	
	
</article><!-- #post-## -->

