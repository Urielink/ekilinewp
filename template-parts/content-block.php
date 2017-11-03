<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ekiline
 */

//update: 29 08 2017 columns
$colSet = get_theme_mod('ekiline_Columns'); 
 if ($colSet == '1' ) {
     $colClass='col-md-6';
 } elseif ($colSet == '2' ) {
     $colClass='col-md-4';
 } elseif ($colSet == '3' ) {
     $colClass='col-md-3';
 } else {
     $colClass='col-md-4';
 }
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $colClass ); ?>>
        
        <div class="cat-thumb">
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                <?php the_post_thumbnail( 'horizontal-slide', array( 'class' => 'img-responsive img-thumbnail' ));?>
            </a>
        </div>
        
        <header class="entry-header">
                        
        <?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
    
        </header><!-- .entry-header -->
    
        <div class="entry-content clearfix">
            
             <?php the_excerpt(); ?> 
                      
        </div><!-- .entry-content -->

</article><!-- #post-## -->

