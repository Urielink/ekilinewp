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
		'default-text-color'     => '000000',
		'width'                  => 1024,
		'height'                 => 768,
		'flex-height'            => true,
		'wp-head-callback'       => 'ekiline_header_style',
        'default-image'          => get_template_directory_uri() . '/screenshot.png',
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
 		
/**
 * Imagen para frontpage, singles y categories
 * Heading image for frontpage, singles or categories
 */ 
		if ( is_front_page() && get_header_image() ){
		        
            // Variables - Values
            // reset range a 30
			if ($rangeHead == '0') {
			     $rangeHead = '30'; 
            }
            						
			// agregar background image
			$headerStyle = 'style="background-image:url(' . get_header_image() . ');height:' . $rangeHead . 'vh;"';
			
            // agregar brand image
            $coverLogo = get_theme_mod( 'ekiline_logo_min' );            
            if ( $coverLogo ){
                $coverLogo = '<a href="'.esc_url( home_url( '/' ) ).'" rel="home"><img class="cover-header-brand" src="' . get_theme_mod( 'ekiline_logo_min' ) . '" alt="' . get_bloginfo( 'name' ) . '"/></a>';
            }
            
            // Mensaje personalizado
            $headerText = get_theme_mod( 'ekiline_headertext', '' );
            
            // Permitir el uso de HTML a la vista
            // Alllow html on output
            $headerText = wp_kses( $headerText, array( 
                'a' => array(
                    'href' => array(),
                    'title' => array(),
                    'target' => array()
                ),
                'br' => array(),
            ) );               
            						
            // Establece la altura de la imagen en formato jumbotron           
			// Set the range for height value and format image as bootstrap jumbotron			
			if ( $rangeHead <= '95' && empty( get_theme_mod('ekiline_video') ) ) {

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
							            <div class="inner">'. $coverLogo .'
							              <nav class="nav cover-header-nav">'. do_shortcode("[socialmenu]") .'</nav>
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
			
            if ( ! empty( get_theme_mod('ekiline_video') ) ) {
                 
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
                                            <source src="'. get_theme_mod('ekiline_video')  .'" type="video/mp4">
                                        </video>
                                        <button id="vidpause" class="btn btn-default">'. __( 'Pause', 'ekiline' ) .'</button>
                                    </div>
                                 </header>';
                                 
                /**
                 * Agregar script para el video 
                 * Add inline script
                 * https://developer.wordpress.org/reference/functions/wp_add_inline_script/
                 * https://make.wordpress.org/core/2016/11/26/video-headers-in-4-7/
                 * https://wordpress.stackexchange.com/questions/33008/how-to-add-a-javascript-snippet-to-the-footer-that-requires-jquery
                 * https://wordpress.stackexchange.com/questions/24851/wp-enqueue-inline-script-due-to-dependancies
                 */                                                                   
                                
                function ekiline_headervideo() { 
                
                    echo '<script type="text/javascript">
                        var vid = document.getElementById("bgvid"),
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
                            // only functional if "loop" is removed 
                             vid.pause();
                            // to capture IE10
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
                        })                    
                        
                    </script>';
                    
                    }
                    
                add_action( 'wp_footer', 'ekiline_headervideo', 110 );
                                 
                                 
            }       
									
				
		} elseif ( is_single() || is_page() ){
		    
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
                    $customHeader .= '<div class="site-branding jumbo" style="background-image: url(' . $url . ');">';
                    $customHeader .= '<div class="inner"><h1 class="entry-title text-center" >'.$titulo.'</h1></div>';
                    $customHeader .= '</div></header>';
                    
                } else {
                    
                    $customHeader .= '<header id="masthead" class="site-header container-fluid">';
                    $customHeader .= '<div class="site-branding jumbotron" style="background-image: url(' . $url . ');">';
                    $customHeader .= '<h1 class="entry-title" >'.$titulo.'</h1>';
                    $customHeader .= '</div></header>';
                    
                }

			}
			
		} elseif ( is_category() ){
		    
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
                    $customHeader .= '<div class="site-branding jumbo" style="background-image: url(' . $url . ');">';
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
		
	
	echo $customHeader;
	
}

/* Agregar css al body para saber el tipo de header 
 * Help CSS, add css class to body for know type of heading */

add_filter( 'body_class', function( $classes ) {
    
    $rangeHead = get_theme_mod('ekiline_range_header');
    
    if ($rangeHead <= '95' && empty( get_theme_mod('ekiline_video') ) && is_front_page() ) {
        
        $classes[] = 'head-jumbotron';
                    
    } elseif ( $rangeHead >= '95' && empty( get_theme_mod('ekiline_video') ) && is_front_page() ) {
        
        $classes[] = 'head-cover';
        
    } elseif ( ! empty( get_theme_mod('ekiline_video') ) && is_front_page()) {
        
        $classes[] = 'head-video';
        
    }
    
    return $classes;
    
});
    
    