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
                
        <header class="entry-header border-bottom pb-2 mb-2">
                        
        <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
        
		<?php if ( 'post' === get_post_type() ) : ?>
		    
		<small class="entry-meta">
			<?php ekiline_posted_on(); ?>
		</small><!-- .entry-meta -->

		<?php endif; ?>
    
        </header><!-- .entry-header -->
    
        <div class="entry-content clearfix">
            
	        <?php if ( has_post_thumbnail() ) { ?>
	        	
		        <div class="cat-thumb">
		            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
		                <?php the_post_thumbnail( 'horizontal-slide', array( 'class' => 'img-fluid img-thumbnail' ));?>
		            </a>
		        </div>
	        
	        <?php } ?>
            
             <?php the_excerpt(); ?> 
                      
        </div><!-- .entry-content -->
        
    	<footer class="entry-footer page-footer bg-light px-2 mb-5">
    		<small><?php ekiline_entry_footer(); ?></small>
    	</footer><!-- .entry-footer -->
        

</article><!-- #post-## -->

