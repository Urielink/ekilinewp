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
            'default-image'          => get_parent_theme_file_uri('/img/ekiline-pattern.png'),
    		'default-text-color'     => '000000',
    		'width'                  => 1680,
    		'height'                 => 1050,
    		'flex-height'            => true,
    		'wp-head-callback'       => 'ekiline_header_style',
    	   )
        ) 
    );
    register_default_headers( array(
        'default-image' => array(
            'url'           => '%s/img/ekiline-pattern.png',
            'thumbnail_url' => '%s/img/ekiline-pattern.png',
            'description'   => __( 'Default Header Image', 'ekiline' ),
        ),
    ) );   
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
    		.site-title, .site-description, .cover-title, .cover-description { position: absolute; clip: rect(1px, 1px, 1px, 1px); }
    	<?php
    		// If the user has set a custom color for the text use that.
    		else :
    	?>
    		.site-title, .site-title a, .site-description, .cover-title, .cover-title a, .cover-description, .site-branding.jumbotron, .inner.cover, .video-text { color: #<?php echo esc_attr( $header_text_color ); ?>; }
    		
    	<?php endif; ?>
    	</style>
    	<?php
    }
endif;  // ekiline_admin_header_image

/**
 * Header de Ekiline, se habilita con la existencia de una imagen, 
 * y permite establecer un formato de portada completa o de altura variable.
 * trabaja en conjunto con customizer.php
 *
 * Ekiline theming: Advanced header fucntion.
 * Works by choosing an image, and setting it in customizer. 
 */
 
function customHeader() {
    
    // Variables 
    $customHeader = '';
    $siteName = get_bloginfo( 'name', 'display' );
    $siteDescription = get_bloginfo( 'description', 'display'  );
    // Tamaño de imagen 
    // Background image size
    $rangeHead = get_theme_mod('ekiline_range_header');
	$setVideo = get_theme_mod('ekiline_video');
 		
/**
 * Imagen para frontpage, singles y categories
 * Heading image for frontpage, singles or categories
 */ 
		if ( is_front_page() && get_header_image() ){
		        
            // Variables - Values // reset range 0 a 30
			if ($rangeHead == '0') {
			     $rangeHead = '30'; 
            }
            						
			// agregar background image // add background image
			$headerStyle = 'style="background-image:url(' . get_header_image() . ');height:' . $rangeHead . 'vh;"';
			
            // agregar brand image // add brand image
            $coverLogo = get_theme_mod( 'ekiline_logo_min' );            
            if ( $coverLogo ){
                $coverLogo = '<a class="cover-header-brand" href="'.esc_url( home_url( '/' ) ).'" rel="home"><img src="' . get_theme_mod( 'ekiline_logo_min' ) . '" alt="' . get_bloginfo( 'name' ) . '"/></a>';
            }
            
            // Mensaje personalizado // custom message
            $headerText = get_theme_mod( 'ekiline_headertext', '' );
            
            // Permitir el uso de HTML a la vista // Alllow html on output
            $headerText = wp_kses( $headerText, array( 
                'a' => array(
                    'href' => array(),
                    'title' => array(),
                    'target' => array()
                ),
                'br' => array(),
                'p' => array(
                    'class' => array(),
                ),
                'span' => array(
                    'class' => array(),
                ),
                'small' => array(
                    'class' => array(),
                ),                                                                
                'strong' => array(),
                'h1' => array(
                    'class' => array(),
                ),
                'h2' => array(
                    'class' => array(),
                ),
                'h3' => array(
                    'class' => array(),
                ),
            ) );               
            						
            // Establece la altura de la imagen en formato jumbotron           
			// Set the range for height value and format image as bootstrap jumbotron			
			if ( $rangeHead <= '95' && empty( $setVideo ) ) {

				$customHeader .= '<header id="masthead" class="site-header container-fluid" role="banner">';
				    
					$customHeader .= '<div class="site-branding jumbotron"'.$headerStyle.'>';

                        $customHeader .= $coverLogo;

                        if ( !$headerText ){																																						
    						$customHeader .= '<h1 class="site-title"><a href="'.esc_url( home_url( '/' ) ).'" rel="home">'. $siteName .'</a></h1>';                                														
                            $customHeader .= '<p class="site-description">'. $siteDescription.'</p>';
						} else {
						    $customHeader .= $headerText;
						}
						
					$customHeader .= '</div><!-- .site-branding -->
			
				</header><!-- #masthead -->'; 
			
			} else {
			     
                // Si range es 100 el formato debe ser cover                         
                // If image range is biggest (100) format image as bootstrap cover   			           
                // Variables para los menus de socialmedia, se habilitan al ser llenados sus campos  
			    // Values for socialmedia menu in cover, works with user social media accounts   
			    // do_shortcode("[socialmenu]") es un widget que se puede utilizar en cualquier parte del sitio
			    // do_shortcode("[socialmenu]") is a widget that can use in any space
                
                // Formato Cover HTML - Set cover HTML   
                            			    																				
				$customHeader = '<header id="masthead"  class="cover-wrapper" style="background-image:url(' . get_header_image() . ');">
							      <div class="cover-wrapper-inner">
							        <div class="cover-container">
							          <div class="cover-header clearfix">
							            <div class="inner">
							              <nav class="nav cover-header-nav justify-content-md-end justify-content-center">'. do_shortcode("[socialmenu]") .'</nav>
							              '. $coverLogo .'
							            </div>
							          </div>
							          <div class="inner cover">';

                                    if ( !$headerText ){                                                                                                                                                        
                                        $customHeader .= '<h1 class="cover-title"><a href="'.esc_url( home_url( '/' ) ).'" rel="home">'. $siteName .'</a></h1>';                                                                                     
                                        $customHeader .= '<p class="cover-description">'. $siteDescription.'</p>';
                                    } else {
                                        $customHeader .= $headerText;
                                    }

				$customHeader .=    '</div>
				                      <div class="cover-footer text-right">
							            <div class="inner">
							             <small>&copy; Copyright '. esc_attr( date('Y') ) .' '. $siteName .'</small>
							            </div>
							          </div>
							        </div>
							      </div>
							    </header>';	
			}
			
			// Agregar video - Set video in header 
			
            if ( ! empty( $setVideo ) ) {
                 
                $customHeader = '<!--[if lt IE 9]><script>document.createElement("video");</script><![endif]-->'.
                                '<header class="video-container" style="background-image: url('. get_header_image() .');background-size:cover;">
                                    <div class="video-text">
                                        '.$coverLogo;

                                    if ( !$headerText ){                                                                                                                                                        
                                        $customHeader .= '<h1 class="cover-title"><a href="'.esc_url( home_url( '/' ) ).'" rel="home">'. $siteName .'</a></h1>';                                                                                     
                                        $customHeader .= '<p class="cover-description">'. $siteDescription.'</p>';
                                    } else {
                                        $customHeader .= $headerText;
                                    }
                                        
                $customHeader .= '</div>                                                                
                                    <div class="video-media embed-responsive embed-responsive-16by9">
                                        <video autoplay loop poster="'. get_header_image() .'" id="bgvid">
                                            <source src="'. $setVideo  .'" type="video/mp4">
                                        </video>
                                        <button id="vidpause" class="btn btn-secondary btn-sm">'. __( 'Pause', 'ekiline' ) .'</button>
                                    </div>
                                 </header>';
                                 
                /**
                 * Agregar script para el video // Add inline script
                 * @link https://developer.wordpress.org/reference/functions/wp_add_inline_script/
                 * @link https://make.wordpress.org/core/2016/11/26/video-headers-in-4-7/
                 * @link https://wordpress.stackexchange.com/questions/33008/how-to-add-a-javascript-snippet-to-the-footer-that-requires-jquery
                 * @link https://wordpress.stackexchange.com/questions/24851/wp-enqueue-inline-script-due-to-dependancies
                 */                                                                   
                                
                function ekiline_headervideo() { 
                
                    echo '<script type="text/javascript">
                    
                        var vid = document.getElementById("bgvid");
                        pauseButton = document.getElementById("vidpause");
                        
                        if (window.matchMedia("(prefers-reduced-motion)").matches) {
                            vid.removeAttribute("autoplay");
                            vid.pause();
                            pauseButton.innerHTML = "'. __( 'Pause', 'ekiline' ) .'";
                        }
                        
                        function vidFade() {
                            vid.classList.add("stopfade");
                        }
                        
                        vid.addEventListener("ended", function() {
                            vid.pause();
                            vidFade();
                        });
                        
                        pauseButton.addEventListener("click", function() {
                            vid.classList.toggle("stopfade");
                            if (vid.paused) {
                                vid.play();
                                pauseButton.innerHTML = "'. __( 'Pause', 'ekiline' ) .'";
                            } else {
                                vid.pause();
                                pauseButton.innerHTML = "'. __( 'Play', 'ekiline' ) .'";
                            }
                        });
                        
                    </script>';
                    
                    }
                    
                add_action( 'wp_footer', 'ekiline_headervideo', 110 );
                                 
                                 
            }       
									
				
		} elseif ( is_single() && true === get_theme_mod('ekiline_showEntryHeading') || is_page() && true === get_theme_mod('ekiline_showPageHeading') ){
					    
            /**
             * Imagenes para el resto de las páginas
             * Heading image for pages and singles
             */ 

            $titulo = get_the_title();
						
			if ( has_post_thumbnail() ) {

                  $medium_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
                  $url = $medium_image_url[0];
                								
                if ( $rangeHead >= '95' ) {
                    
                    $customHeader .= '<header id="masthead" class="site-header">';
                    $customHeader .= '<div class="site-branding jumbotron" style="background-image: url(' . $url . ');">';
                    $customHeader .= '<div class="inner"><h1 class="entry-title text-center" >'.$titulo.'</h1></div>';
                    $customHeader .= '</div></header>';
                    
                } else {
                    
                    $customHeader .= '<header id="masthead" class="site-header container-fluid">';
                    $customHeader .= '<div class="site-branding jumbotron" style="background-image: url(' . $url . ');">';
                    $customHeader .= '<h1 class="entry-title" >'.$titulo.'</h1>';
                    $customHeader .= '</div></header>';
                    
                }

			}
			
		} elseif ( is_category() && true === get_theme_mod('ekiline_showCategoryHeading') ){
		    
            /**
             * Imagenes para categories
             * Heading image for categories
             * addon-categoryfield.php
             */ 

			$titulo = single_cat_title("", false);			
			$cat_id = get_query_var('cat');
			$cat_data = get_option("category_$cat_id");
							
			// si tiene imagen
			if ( $cat_data['img'] ) {
		
				// dame la url
				$url = $cat_data['img'];

                if ( $rangeHead >= '95' ) {
                    
                    $customHeader .= '<header id="masthead" class="site-header">';
                    $customHeader .= '<div class="site-branding jumbotron" style="background-image: url(' . $url . ');">';
                    $customHeader .= '<div class="inner"><h1 class="entry-title text-center" >'.$titulo.'</h1></div>';
                    $customHeader .= '</div></header>';
                    
                } else {
                    
                    $customHeader .= '<header id="masthead" class="site-header container-fluid">';
                    $customHeader .= '<div class="site-branding jumbotron" style="background-image: url(' . $url . ');">';
                    $customHeader .= '<h1 class="entry-title" >'.$titulo.'</h1>';
                    $customHeader .= '</div></header>';
                    
                }
								
				
			}
		
				
		}		

        /**
         * Si utiliza woocommerce, el producto no requiere imagen de cabecera, a menos que crees un homepage con imagen principal.
         * If is woocommerce post doesnt need a header image, but if you want a store with frontpage params allow it.
         * @link https://docs.woocommerce.com/document/conditional-tags/
         * class_exists( 'WooCommerce' ), 
         */ 
                
        if ( get_post_type( get_the_ID() ) == 'product' && !is_front_page() ){
            $customHeader = '';
        } 
			
	
	echo $customHeader;
	
}

/* Agregar css al body para saber el tipo de header 
 * Help CSS, add css class to body for know type of heading */

add_filter( 'body_class', function( $classes ) {
        
    if ( get_header_image() && is_front_page() ){
    
        $rangeHead = get_theme_mod('ekiline_range_header');
        
        if ($rangeHead <= '95' && empty( $setVideo ) ) {
            
            $classes[] = 'head-jumbotron';
                        
        } elseif ( $rangeHead >= '95' && empty( $setVideo ) ) {
            
            $classes[] = 'head-cover';
            
        } elseif ( ! empty( $setVideo ) ) {
            
            $classes[] = 'head-video';
            
        }
    
    }
    
    return $classes;
    
});
    
    