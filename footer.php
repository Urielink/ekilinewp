<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ekiline
 *
 * Añadimos widgets en el footer para poder crear columnas
 *
 * https://codex.wordpress.org/Function_Reference/is_active_sidebar
 *
 */
?>

		</div><!-- #primary -->
	
		<?php get_sidebar(); ?>
		<?php get_sidebar('right'); ?>	
	
	</div><!-- #content -->

</div><!-- #page -->

	<footer id="colophon" class="site-footer" role="contentinfo">
	    	    
	    <!--widgets-->
	    <div class="container">

            <?php dynamic_sidebar( 'footer-w1' ); ?>
            
    		<small class="site-info col-xs-12 text-center">

                <?php printf( esc_html__( '&copy; Copyright %1$s', 'ekiline' ), esc_attr( date('Y') . ' ' . get_bloginfo( 'name', 'display' )) );?>
                <span class="sep"> | </span>
                <?php printf( esc_html__( 'Por %s', 'ekiline' ), '<a href="#autor">Autor</a>' ); ?>
                <span class="sep"> | </span>
                <?php printf( esc_html__( 'Proudly powered by %s', 'ekiline' ), '<a href="https://wordpress.org/">WordPress</a>' ); ?>
                
    		</small><!-- .site-info -->

		</div>
		
	</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>
