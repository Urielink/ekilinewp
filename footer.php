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
            
            <div class="site-info text-center clearfix">    
                <?php printf( esc_html__( '&copy; Copyright %1$s', 'ekiline' ), esc_attr( date('Y') . ' ' . get_bloginfo( 'name', 'display' )) );?> <a class="btn btn-secondary btn-sm float-right" href="#top"><span class="fa fa-chevron-up"></span></a>                    
                <br/>                
                <small class="float-left"><?php printf( esc_html__( 'Proudly powered by %s', 'ekiline' ), '<a href="https://wordpress.org/">WordPress</a>' ); ?> <?php printf( esc_html__( 'By %s', 'ekiline' ), '<a href="'.__('http://ekiline.com','ekiline').'" target="_blank">Ekiline</a>' ); ?></small>                
				<!-- idendificar queries lentas: https://css-tricks.com/finding-and-fixing-slow-wordpress-database-queries/ -->
                <span class="text-danger float-right"><?php echo get_num_queries(); ?> queries in <?php timer_stop(1); ?> seconds.</span>
            </div><!-- .site-info -->   
        
		</div>
		
	</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>
