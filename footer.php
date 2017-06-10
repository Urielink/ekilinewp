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

            <div class="row"><?php dynamic_sidebar( 'footer-w1' ); ?></div>
            
            <div class="site-info no-margin clearfix">
    
                <?php printf( esc_html__( '&copy; Copyright %1$s', 'ekiline' ), esc_attr( date('Y') . ' ' . get_bloginfo( 'name', 'display' )) );?>
                <a class="btn btn-default btn-sm pull-right" href="#top"><i class="glyphicon glyphicon-chevron-up"></i></a>    
                
                <br/>
                
                <small>
                    <?php printf( esc_html__( 'Proudly powered by %s', 'ekiline' ), '<a href="https://wordpress.org/">WordPress</a>' ); ?>
                    <?php printf( esc_html__( 'By %s', 'ekiline' ), '<a href="'.__('http://ekiline.com','ekiline').'" target="_blank">Ekiline</a>' ); ?>
                </small>
                
            </div><!-- .site-info -->   
        
		</div>
		
	</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>
