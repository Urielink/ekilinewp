<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ekiline
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
	
	<?php if ( !is_home() && ! is_front_page() ) : ?> 
		
	<header class="page-header">

        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	  	
	  	<?php ekiline_posted_on() ?>
	  		  	
	</header><!-- .page-header -->

	<?php endif; ?>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ekiline' ),
				'after'  => '</div>',
			) );
		?>		          

	</div><!-- .entry-content -->

	<footer class="entry-footer">

        <nav id="page-navigation">
            <?php getPrevNext(); ?>         
        </nav><!-- #page-navigation -->        

		<?php
			edit_post_link(
				sprintf(
					/* translators: %s: Name of current post */
					esc_html__( 'Edit %s', 'ekiline' ),
					the_title( '<i class="fa fa-pencil"></i> <span class="screen-reader-text">"', '"</span>', false )
				),
                '<span class="edit-link btn btn-default">',
				'</span>'
			);
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

