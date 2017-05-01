<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ekilinewp
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php if ( !is_home() && ! is_front_page() ) : ?> 
		
	<header class="entry-header">
	  	<?php miniDate();?>

        <?php if ( !has_post_thumbnail() ) {
            // si no tiene imagen destacada solo pon el titulo
            the_title( '<h1 class="entry-title text-center">', '</h1>' ); 
        }?>
	  	
		<?php //**ELIMINAR?? the_title( '<h1 class="entry-title text-center">', '</h1>' ); ?>
		
	</header><!-- .entry-header -->

	<?php endif; ?>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ekilinewp' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
			edit_post_link(
				sprintf(
					/* translators: %s: Name of current post */
					esc_html__( 'Edit %s', 'ekilinewp' ),
					the_title( '<i class="fa fa-pencil"></i> <span class="screen-reader-text">"', '"</span>', false )
				),
                '<span class="edit-link btn btn-default">',
				'</span>'
			);
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

