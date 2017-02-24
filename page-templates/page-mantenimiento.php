<?php
/**
 * Template Name: Mantenimiento
 * 
 * @package ekiline
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>


<div class="cover-wrapper">

      <div class="cover-wrapper-inner">

        <div class="cover-container">

			<?php while ( have_posts() ) : the_post(); ?>


	          <div class="cover-header clearfix">
	            <div class="inner">
					<h3 class="entry-title"><?php the_title();?></h3>
	            </div>
	          </div>
	
	          <div class="inner cover">
	    	    
		    		<?php the_content();?>
	          
			  </div>
	
	          <div class="cover-footer">
	            <div class="inner">
	              <p><?php printf( esc_html__( '© Copyright ' . date('Y') . ' %1$s', 'ekiline' ), esc_attr( get_bloginfo( 'name', 'display' )) );?></p>
	            </div>
	          </div>
          
			<?php endwhile; // End of the loop. ?>          	
          

        </div>

      </div>

    </div>	

	
<?php wp_footer(); ?>
</body>
</html>