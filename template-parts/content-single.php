<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ekiline
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
    
	<header class="entry-header">

        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<small class="entry-meta">
			<?php ekiline_posted_on(); ?>
		</small><!-- .entry-meta -->
		
	</header><!-- .entry-header -->

	<div class="entry-content clearfix border-top pt-2 mt-2">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links text-center my-2">' . esc_html__( 'Pages:', 'ekiline' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer text-muted clearfix bg-light px-2 mb-5">
		<small><?php ekiline_entry_footer(); ?></small>
	</footer><!-- .entry-footer -->
	
</article><!-- #post-## -->

