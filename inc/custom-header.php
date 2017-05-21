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

// Creo una funcion para agregar un header personalizado

function customHeader() {
    
     $customHeader = '';
    		
		/* Para el HOME:
		 * en caso de tener una imagen de cabecera aparecer un header
		 */ 

		if ( is_front_page() && get_header_image() ){

			// Variables
			$siteName = get_bloginfo( 'name', 'display' );
			$siteDescription = get_bloginfo( 'description', 'display'  );
			// Estilo de imagen de fondo: invocamos la imagen del editor de pagina y lo añadimos como css.
			// En combinacion con un range
			$rangeHead = get_theme_mod('ekiline_range_header');
			if ($rangeHead == '0') : $rangeHead = '30'; endif ;
						
			$headerStyle = 'style="background-image:url(' . get_header_image() . ');height:' . $rangeHead . 'vh;"';

            $coverLogo = get_theme_mod( 'ekiline_logo_min' );
            if ( $coverLogo ){
                $coverLogo = '<a href="'.esc_url( home_url( '/' ) ).'" rel="home"><img class="cover-header-brand" src="' . get_theme_mod( 'ekiline_logo_min' ) . '" alt="' . get_bloginfo( 'name' ) . '"/></a>';
            }
            
            $headerText = get_theme_mod( 'ekiline_headertext' );
            						
			//Estructura con condicion:
			
			if ( $rangeHead <= '95' && empty( get_theme_mod('ekiline_video') ) ) {
				// Si la altura es menor a 95, la imagen hereda la estructura de jumbotron.

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
			           
			    // para el menu de redes sociales    
                $fbSocial = get_theme_mod('ekiline_fbProf','');
                $twSocial = get_theme_mod('ekiline_twProf','');
                $gpSocial = get_theme_mod('ekiline_gpProf','');
                $inSocial = get_theme_mod('ekiline_inProf','');
                $menuItems = '';
                    
                if ($fbSocial) : $menuItems .= '<li><a href="'.$fbSocial.'" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a></li>'; endif;
                if ($twSocial) : $menuItems .= '<li><a href="'.$twSocial.'" target="_blank" title="Twitter"><i class="fa fa-twitter"></i></a></li>'; endif;
                if ($gpSocial) : $menuItems .= '<li><a href="'.$gpSocial.'" target="_blank" title="Google Plus"><i class="fa fa-google"></i></a></li>'; endif;
                if ($inSocial) : $menuItems .= '<li><a href="'.$inSocial.'" target="_blank" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>';endif;                
                if ($menuItems) : $menuItems = '<nav><ul class="nav cover-header-nav">'. $menuItems .'</ul></nav>';endif;
                            			    																				
				$customHeader = '<header id="masthead"  class="cover-wrapper" style="background-image:url(' . get_header_image() . ');">
							      <div class="cover-wrapper-inner">
							        <div class="cover-container">
							          <div class="cover-header clearfix">
							            <div class="inner">'. $coverLogo . $menuItems .'</div>
							          </div>
							          <div class="inner cover">';

                                    if ( !$headerText ){                                                                                                                                                        
                                        $customHeader .= '<h1 class="cover-title"><a href="'.esc_url( home_url( '/' ) ).'" rel="home">'. $siteName .'</a></h1>';                                                                                     
                                        $customHeader .= '<p class="cover-description">'. $siteDescription.'</p>';
                                    } else {
                                        $customHeader .= $headerText;
                                    }

				$customHeader .=    '</div>
				                      <div class="cover-footer">
							            <div class="inner"><p>Algun contenido</p></div>
							          </div>
							        </div>
							      </div>
							    </header>';	
			}
			
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
                // https://developer.wordpress.org/reference/functions/wp_add_inline_script/
                // https://make.wordpress.org/core/2016/11/26/video-headers-in-4-7/
                // https://wordpress.stackexchange.com/questions/33008/how-to-add-a-javascript-snippet-to-the-footer-that-requires-jquery
                // https://wordpress.stackexchange.com/questions/24851/wp-enqueue-inline-script-due-to-dependancies
                
                function myscript() { 
                
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
                add_action( 'wp_footer', 'myscript', 110 );
                                 
                                 
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

				// obten la url de la imagen función estándard
				//$url = wp_get_attachment_url( get_post_thumbnail_id() );
				
				// extracción de url a medida
                  $medium_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
                  $url = $medium_image_url[0];
                								

				$customHeader .= '<header id="masthead" class="site-header container-fluid" role="banner">';
    			$customHeader .= '<div class="site-branding jumbotron" style="background-image: url(' . $url . ');">';
    			$customHeader .= '<h1 class="entry-title" >'.$titulo.'</h1>';
    			$customHeader .= '</div></header>';
			}
				
			
		}
		
		/* Para las categorias :
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
				$customHeader .= '<h1 class="entry-title" >'.$titulo.'</h1>';
				$customHeader .= '</div></header>';
			}
		
				
		}		
		
	
	echo $customHeader;
	
}

/* Agrego una clase al body para saber que se utiliza cover o jumbotron */

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
    
    