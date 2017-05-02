<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ekiline
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        
	<?php the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ));?>
    
    <div class="carousel-caption">
    		
	<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
    <?php the_excerpt(); ?> 

	</div>
</article><!-- #post-## -->

