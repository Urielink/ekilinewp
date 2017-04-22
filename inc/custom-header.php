<?php
/**
 * Sample implementation of the Custom Header feature.
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php if ( get_header_image() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
	</a>
	<?php endif; // End header image check. ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 * @link https://make.wordpress.org/themes/2012/04/06/updating-custom-backgrounds-and-custom-headers-for-wordpress-3-4/
 *
 * @package ekiline
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses ekiline_header_style()
 */
function ekiline_custom_header_setup() {
	add_theme_support( 'custom-header', 
	apply_filters( 'ekiline_custom_header_args', array(
		'default-image'          => get_template_directory_uri() . '/screenshot.png',
		'default-text-color'     => '000000',
		'width'                  => 1000,
		'height'                 => 250,
		'flex-height'            => true,
		'wp-head-callback'       => 'ekiline_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'ekiline_custom_header_setup' );

if ( ! function_exists( 'ekiline_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog.
 *
 * @see ekiline_custom_header_setup().
 */
    function ekiline_header_style() {
    	$header_text_color = get_header_textcolor();
    
    	/*
    	 * If no custom options for text are set, let's bail.
    	 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: HEADER_TEXTCOLOR.
    	 */
    	if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
    		return;
    	}
    
    	// If we get this far, we have custom styles. Let's do this.
    	?>
    	<style type="text/css">
    	<?php
    		// Has the text been hidden?
    		if ( ! display_header_text() ) :
    	?>
    		.site-title,
    		.site-description {
    			position: absolute;
    			clip: rect(1px, 1px, 1px, 1px);
    		}
    	<?php
    		// If the user has set a custom color for the text use that.
    		else :
    	?>
    		.site-title a,
    		.site-description,
    		.cover-title {
    			color: #<?php echo esc_attr( $header_text_color ); ?>;
    		}
    		.custom-header-image {}
    	<?php endif; ?>
    	</style>
    	<?php
    }
endif;  // ekiline_admin_header_image

// Creo una función para añadir un header personalizado

function customHeader() {
        
    
     $customHeader = '';
    		
		/* Para el HOME:
		 * en caso de tener una imagen de cabecera aparecer un header
		 */ 

		if ( is_front_page() && get_header_image() ){

			// Variables
			$siteName = get_bloginfo( 'name', 'display' );
			$siteDescription = get_bloginfo( 'description', 'display'  );
			// Estilo de imagen de fondo: invocamos la imagen del editor de página y lo añadimos como css.
			// En combinación con un range
			$rangeHead = get_theme_mod('ekiline_range_header');
			if ($rangeHead == '0') : $rangeHead = '30'; endif ;
						
			$headerStyle = 'style="background-image:url(' . get_header_image() . ');height:' . $rangeHead . 'vh;"';
			
			//Estructura con condición:
			
			if ($rangeHead <= '95') {
				// Si la altura es menor a 95, la imagen hereda la estructura de jumbotron.

				$customHeader .= '<header id="masthead" class="site-header container-fluid" role="banner">';
				    
					$customHeader .= '<div class="site-branding jumbotron"'.$headerStyle.'>';
								
						if ( is_front_page() && is_home() ) : 
							$customHeader .= '<h1 class="site-title"><a href="'.esc_url( home_url( '/' ) ).'" rel="home">'. $siteName .'</a></h1>';
						else :
							$customHeader .= '<p class="site-title"><a href="'.esc_url( home_url( '/' ) ).'" rel="home">'. $siteName .'</a></p>';
						endif;	
						
						if ( $siteDescription || is_customize_preview() ) :
							$customHeader .= '<p class="site-description">'. $siteDescription.'</p>';
						endif;
													
					$customHeader .= '</div><!-- .site-branding -->
			
				</header><!-- #masthead -->'; 
			
			} else {				
				
				// Si la altura es mayor, la imagen hereda la estructura de cover.
				if ( get_theme_mod( 'ekiline_logo_min' ) ) {
					$coverLogo = '<img class="cover-header-brand" src="' . get_theme_mod( 'ekiline_logo_min' ) . '" alt="' . get_bloginfo( 'name' ) . '"/>';
				} 
												
				$customHeader = '<header id="masthead"  class="cover-wrapper" style="background-image:url(' . get_header_image() . ');">
							      <div class="cover-wrapper-inner">
							        <div class="cover-container">
							          <div class="cover-header clearfix">
							            <div class="inner">'.$coverLogo.'											
											<nav> 
												<ul class="nav cover-header-nav">
													<li><a href="https://www.google.com/search?q=ekiline.com" target="_blank"><i class="fa fa-google"></i></a></li>
													<li><a href="https://www.linkedin.com/" target="_blank"><i class="fa fa-linkedin"></i></a></li>
													<li><a href="https://es-la.facebook.com/ekiline/" target="_blank"><i class="fa fa-facebook"></i></a></li>
													<li><a href="https://twitter.com/ekilinemx/" target="_blank"><i class="fa fa-twitter"></i></a></li> 
												</ul>
											</nav>				
    									</div>
							          </div>
							          <div class="inner cover">
										<h1 class="cover-title">'.$siteName.'</h1>
										<p class="cover-description">'. $siteDescription.'</p>
					    			  </div>
							          <!--div class="cover-footer">
							            <div class="inner"><p>Algún contenido</p></div>
							          </div-->
							        </div>
							      </div>
							    </header>';	
			}			
				
		}

		/* Para las internas :
		 * en caso de tener una imagen destacada convertirla en un header
		 */		
		
		elseif ( is_single() || is_page() ){
			
			//extrae el id
			//$titulo = get_the_title($post->ID);
            $titulo = get_the_title();
						
			// y si tiene imagen destacada
			if ( has_post_thumbnail() ) {

				// obten la url de la imagen
				$url = wp_get_attachment_url( get_post_thumbnail_id() );

				$customHeader .= '<header id="masthead" class="site-header container-fluid" role="banner">';
    			$customHeader .= '<div class="site-branding jumbotron" style="background-image: url(' . $url . ');">';
    			$customHeader .= '<h1 class="site-title" >'.$titulo.'</h1>';
    			$customHeader .= '</div></header>';
			}
				
			
		}
		
		/* Para las categorías :
		 * en caso de tener una imagen convertirla en un header
		 * archivo complementario: *addon-categoryfield.php
		*/
		
		elseif ( is_category() ){
				
			// invocamos al titulo para insertar en header.
			$titulo = single_cat_title("", false);			
			//Llamamos el ID
			$cat_id = get_query_var('cat');
			//llamamos ese dato desde la BD
			$cat_data = get_option("category_$cat_id");
			
				
			// y si tiene imagen destacada
			if ( $cat_data['img'] ) {
		
				// obten la url de la imagen
				$url = $cat_data['img'];
		
				$customHeader .= '<header id="masthead" class="site-header container-fluid" role="banner">';
				$customHeader .= '<div class="site-branding jumbotron categoria" style="background-image: url(' . $url . ');">';
				$customHeader .= '<h1 class="site-title" >'.$titulo.'</h1>';
				$customHeader .= '</div></header>';
			}
		
				
		}		
		
	
	echo $customHeader;
	
}
