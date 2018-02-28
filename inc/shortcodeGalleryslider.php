<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 * Sobreescribir la galeria de wordpress para permitir añadir elmentos de bootstrap
 * Add bootstrap elements to gallery
 * Algunos ejemplos del overide: 
 * Some example to override gallery.
 * Oficial: https://developer.wordpress.org/reference/functions/gallery_shortcode/
 * Corroborando los problemas que da: 
 *   -https://wordpress.stackexchange.com/questions/43558/how-to-manually-fix-the-wordpress-gallery-code-using-php-in-functions-php
 *
 * @package ekiline
 */

if( false === get_theme_mod('ekiline_carouseldisable') ) {
 
	add_filter('post_gallery', 'ekiline_gallery', 10, 2);
	 
	function ekiline_gallery( $output,$attr ) {
	    
	    $post = get_post();
	 
	    static $instance = 0;
	    $instance++;
	 
	    if ( ! empty( $attr['ids'] ) ) {
	        // 'ids' is explicitly ordered, unless you specify otherwise.
	        if ( empty( $attr['orderby'] ) ) {
	            $attr['orderby'] = 'post__in';
	        }
	        
	        $attr['include'] = $attr['ids'];
	        
	    }
	 
	    /**
	     * Filters the default gallery shortcode output.
	     *
	     * If the filtered output isn't empty, it will be used instead of generating
	     * the default gallery template.
	     *
	     * @since 2.5.0
	     * @since 4.2.0 The `$instance` parameter was added.
	     *
	     * @see gallery_shortcode()
	     *
	     * @param string $output   The gallery output. Default empty.
	     * @param array  $attr     Attributes of the gallery shortcode.
	     * @param int    $instance Unique numeric ID of this gallery shortcode instance.
	     *
	     */
	    
	    if ( $output != '' ) {
	        return $output;
	    }
	 
	    $atts = shortcode_atts( array(
	        'order'      => 'ASC',
	        'orderby'    => 'menu_order ID',
	        'id'         => $post ? $post->ID : 0,
	        'itemtag'    => 'figure',
	        'icontag'    => 'div',
	        'captiontag' => 'figcaption',
	        'columns'    => 3,
	        'size'       => 'thumbnail',
	        'include'    => '',
	        'exclude'    => '',
	        'link'       => '',
	        //agregado
	        'carousel'   => '',
	        'showlink'   => '',
	        'showbutton' => 'false',
	        'name'       => 'default',
	        'align'      => 'text-center',
	        'indicators' => 'false',
	        'speed'      => 'false',
	        'transition' => '',
	        'gutters'	 => 'false'
	    ), $attr, 'gallery' );
	 
	    $id = intval( $atts['id'] );
	 
	    if ( ! empty( $atts['include'] ) ) {
	        $_attachments = get_posts( array( 'include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
	 
	        $attachments = array();
	        foreach ( $_attachments as $key => $val ) {
	            $attachments[$val->ID] = $_attachments[$key];
	        }
	    } elseif ( ! empty( $atts['exclude'] ) ) {
	        $attachments = get_children( array( 'post_parent' => $id, 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
	    } else {
	        $attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
	    }
	 
	    if ( empty( $attachments ) ) {
	        return '';
	    }
	 
	    if ( is_feed() ) {
	        $output = "\n";
	        foreach ( $attachments as $att_id => $attachment ) {
	            $output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
	        }
	        return $output;
	    }
	 
	    $itemtag = tag_escape( $atts['itemtag'] );
	    $captiontag = tag_escape( $atts['captiontag'] );
	    $icontag = tag_escape( $atts['icontag'] );
	    $valid_tags = wp_kses_allowed_html( 'post' );
	    if ( ! isset( $valid_tags[ $itemtag ] ) ) {
	        $itemtag = 'dl';
	    }
	    if ( ! isset( $valid_tags[ $captiontag ] ) ) {
	        $captiontag = 'dd';
	    }
	    if ( ! isset( $valid_tags[ $icontag ] ) ) {
	        $icontag = 'dt';
	    }
	 
	    $columns = intval( $atts['columns'] );
	    $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
	    $float = is_rtl() ? 'right' : 'left';
	 
	    $selector = "gallery-{$instance}-".$atts['name'];
		    $selectorCss = $atts['name'];
	  
	    
	    /** Variables de carrusel p1: las clases CSS y variables de objetos **/
	     
	    $itemcol = '';
	    $carousel = 'row';
	    $carouselitem = 'item';
	    $alignitems = $atts['align'];
	    $indicators = '';
	    $speed = '';
	    $transition = '';
	    $captionCss = '';
	    $gutters = $atts['gutters'];
			$gutterbottom = 'mb-4';
	                        
	    if ( empty( $atts['carousel'] ) ) {
	                
	        if ($columns == '1') : $itemcol = 'col-sm-12';
	        elseif ($columns == '2') : $itemcol = 'col-sm-6';
	        elseif ($columns == '3') : $itemcol = 'col-sm-4';
	        elseif ($columns == '4') : $itemcol = 'col-sm-3';
	        elseif ($columns == '5') : $itemcol = 'col-sm-1a5';
	        elseif ($columns == '6') : $itemcol = 'col-sm-2';
	        elseif ($columns == '7') : $itemcol = 'col-sm-1a7';
	        elseif ($columns == '8') : $itemcol = 'col-sm-1a8';
	        elseif ($columns == '9') : $itemcol = 'col-sm-1a9'; endif;
	        
	    } elseif ( ! empty( $atts['carousel'] ) ) {
	            
	        $carousel = 'carousel slide';
	        $indicators = $atts['indicators'];
	        $speed = ' data-interval="'.$atts['speed'].'"';
	        $transition = $atts['transition'];
	        $first = true;  // bandera
	                        
	        if ( $columns > '1' ){
	            $carousel = 'carousel slide carousel-multiple';
	        }         
	                
	        if ($columns == '1') : $itemcol = '';
	        elseif ($columns == '2') : $itemcol = 'col-sm-6';
	        elseif ($columns == '3' || $columns == '9') : $itemcol = 'col-sm-4';
	        elseif ($columns == '4' || $columns == '7' || $columns == '8') : $itemcol = 'col-sm-3';
	        elseif ($columns == '5' || $columns == '6') : $itemcol = 'col-sm-2';
	        endif;
	        
	    }     
	    
	    /** Si desean ver las imagenes como lightbox **/
	    if ( ! empty( $atts['showlink'] ) ) {
	        $showlink = 'modal-gallery';
	    } else {
	        $showlink = '';
	    }  
		
		/** Si desean ocultar los medianiles **/       
		if ($gutters == 'true'){
			$gutters = 'no-gutters';
			$gutterbottom = 'mb-0';
		} 
		   
	    /** Fin de Variables de carrusel p1 **/
	    
	    
	    $size_class = sanitize_html_class( $atts['size'] );
	    $gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-{$selectorCss} gallery-columns-{$columns} gallery-size-{$size_class} {$carousel} {$showlink} {$transition} {$gutters}'".$speed.">";
	 
	    $output = $gallery_div; 
	
	    /** Variables de carrusel p2: los controles y el div interno **/
	    
	    if ( ! empty( $atts['carousel'] ) ) {
	            
	        if ($indicators == 'true'){
	            
	            $control = '';
	            
	            foreach ( $_attachments as $key => $val ) {
	                if ( $key == 0 ) : $activo = 'class="active"';  else : $activo=''; endif;            
	                $control .= '<li data-target="#'. $selector .'" data-slide-to="'. $key .'" '. $activo .'></li>';
	            }                
	            
	            $output .= '<ol class="carousel-indicators">'.$control.'</ol>';        
	        }
	        
	        $output .= '<div class="carousel-inner" role="listbox">';
	
	    }    
	      
	    /** FIN de variables de carrusel p2 **/
	              
	    $i = 0;
	                            
	    foreach ( $attachments as $id => $attachment ) {
	             
	        $attr = ( trim( $attachment->post_excerpt ) ) ? array( 'aria-describedby' => "$selector-$id" ) : '';
	        if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
	            $image_output = wp_get_attachment_link( $id, $atts['size'], false, false, false, $attr );
	        } elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
	            $image_output = wp_get_attachment_image( $id, $atts['size'], false, $attr );
	        } else {
	            $image_output = wp_get_attachment_link( $id, $atts['size'], true, false, false, $attr );
	        }
	        $image_meta  = wp_get_attachment_metadata( $id );
	 
	        $orientation = '';
	        if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
	            $orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
	        }  
	         
	    /** Variables de carrusel p3 la : clase CSS active **/    
	        if ( ! empty( $atts['carousel'] ) ) {                
	            if ( $first ) : $carouselitem = 'carousel-item active'; $first = false;
	            else :  $carouselitem = 'carousel-item'; endif;                               
	        }                  
	    /** FIN Variables de carrusel p3 **/
	              
	        /** A.Si no hay carrusel, entonces es una galeria con grid**/  
	        if ( !empty( $atts['carousel'] ) ) {
	            $output .= "<div class='{$carouselitem} {$gutters}'>";
	        }
	
	        $output .= "<{$itemtag} class='gallery-item {$gutterbottom} {$itemcol} {$alignitems}'>";
	        
	            $output .= "<{$icontag} class='gallery-icon {$orientation}'>
	                            $image_output
	                        </{$icontag}>";
	                
	            if ( $captiontag && trim($attachment->post_excerpt) || trim($attachment->post_title) ) {
	                
	                //en caso de tener título o descripcion y estar habilitado el carrusel
	                $captionTitle = '';
	                $captionText = '';                                
	                                
	                if( (!empty( $atts['carousel'] )) ){ $captionCss = 'carousel-caption';}
	                if( $attachment->post_title && (!empty( $atts['carousel'] )) ){ $captionTitle = '<h2 class="'.$alignitems.'">' . wptexturize($attachment->post_title) . '</h2>';}
	                if( $attachment->post_excerpt ){ $captionText = '<p class="'.$alignitems.'">' . wptexturize($attachment->post_excerpt) . '</p>';}
	                     
//feb2018 boton de enlace es necesario de manera ocasional.
					/*boton de enlace*/
					$captionBtn = '';
	                                
	                if ( $atts['showbutton'] == 'true' ) {
	                	
				        $attr = ( trim( $attachment->post_excerpt ) ) ? array( 'aria-describedby' => "$selector-$id" ) : '';
						
				        if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
							$captionBtn = wp_get_attachment_link( $id, '', false, false, $attachment->post_title, $attr );
				        } elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
							$captionBtn = ''; //wp_get_attachment_link( $id, '', false, $attr ); // si no hay enlace, no hay boton.
				        } else {
							$captionBtn = wp_get_attachment_link( $id, '', true, false, $attachment->post_title, $attr );
				        }
							
						$captionBtn = '<p class="caption-button '.$alignitems.'">' . $captionBtn . '</p>';
						
					}							 
						                            
	            $output .= "<{$captiontag} class='wp-caption-text gallery-caption $captionCss' id='$selector-$id'>
	                        " . $captionTitle . $captionText . $captionBtn . "
	                        </{$captiontag}>";      
	                                          
	            }
	        
	        $output .= "</{$itemtag}>";
			
	        /** A.Si no hay carrusel, entonces es una galeria con grid**/  
	        if ( !empty( $atts['carousel'] ) ) {
	            $output .= "</div>";
	        }
	        
	        if ( empty( $atts['carousel'] ) && $columns > 1 && ++$i % $columns == 0 ) {
	            //$output .= '<div class="w-100"></div>';
	        }
	    }
	 
	    if ( empty( $atts['carousel'] ) && $columns > 0 && $i % $columns !== 0 ) {
	        //$output .= '<div class="w-100 last"></div>';
	    }
	    
	    if ( ! empty( $atts['carousel'] ) ) {
	        $output .= '</div>'; /* <-- .carousel-inner" */
	        					
	        $output .= '<a class="carousel-control-prev" href="#'.$selector.'" role="button" data-slide="prev">
					    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="sr-only">Previous</span></a>
						<a class="carousel-control-next" href="#'.$selector.'" role="button" data-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only">Next</span></a>';  					
						
						      
	    }
	    
	 
	    $output .= "</div>\n"; /* <-- $output = $gallery_div; */
	         
	    return $output;
	}
	
	/*Enero agregar clase responsiva a las imagenes de la galería*/
	function addImgClass( $attr ) {    
	    $attr['class'] .= ' img-fluid';
	    return $attr;
	};
	add_filter( 'wp_get_attachment_image_attributes', 'addImgClass' );
	
	
	/** 
	* Añadimos funciones de personalizacion en la admnistracion de la galeria
	* Add options menu in gallery admin panel
	* http://wordpress.stackexchange.com/questions/179357/custom-wordpress-gallery-option
	* https://wordpress.org/support/topic/how-to-add-fields-to-gallery-settings
	* http://wordpress.stackexchange.com/questions/182821/add-custom-fields-to-wp-native-gallery-settings
	**/
	//FEB, con el widget de galeria no funcionan las opciones hay que investigar.
	global $pagenow;
	if ( ( $pagenow != 'widgets.php' ) ) {
		add_action('print_media_templates', function(){
		  ?>
		 
		  <script type="text/html" id="tmpl-ekiline-gallery-setting">
		    <div style="display:inline-block;margin-top:20px;border-top: 1px solid #C2C2C2;">
		    <h2><?php echo __( 'Ekiline settings','ekiline' ); ?></h2>
		    
		    <label class="setting">
		        <span><?php echo __( 'Open linked media on modal window','ekiline' ); ?></span>
		        <input type="checkbox" data-setting="showlink">
		    </label>      
		            
		    <label class="setting">
		        <span><?php echo __( 'Transform to carousel','ekiline' ); ?></span>
		        <input type="checkbox" data-setting="carousel">
		    </label>  
		        
		    <label class="setting">
		        <span><?php echo __( 'Carousel name (for customize)','ekiline' ); ?></span>
		        <input type="text" value="" data-setting="name" placeholder="default">
		    </label>
		    
		    <label class="setting">
		      <span><?php echo __( 'Carousel text caption align','ekiline' ); ?></span>
		      <select data-setting="align">
		        <option value="text-center"> <?php echo __( 'Center','ekiline' ); ?> </option>
		        <option value="text-left"> <?php echo __( 'Left','ekiline' ); ?> </option>
		        <option value="text-right"> <?php echo __( 'Right','ekiline' ); ?> </option>
		      </select>
		    </label>
		
		    <label class="setting">
		      <span><?php echo __( 'Carousel transition','ekiline' ); ?></span>
		      <select data-setting="transition">
		        <option value="none"> <?php echo __( 'Default','ekiline' ); ?> </option>
		        <option value="carousel-fade"> <?php echo __( 'Fade','ekiline' ); ?> </option>
		        <option value="carousel-vertical"> <?php echo __( 'Vertical','ekiline' ); ?> </option>
		      </select>
		    </label>
		
		    <label class="setting">
		        <span><?php echo __( 'Show indicators','ekiline' ); ?></span>
		        <input type="checkbox" data-setting="indicators">
		    </label>  
		    
		    <!--Update, usabilidad, es mejor recurrir a un selector con valores preestablecidos-->
		    <!--label class="setting">
		        <span><?php echo __( 'Speed','ekiline' ); ?></span>
		        <input type="number" value="" data-setting="speed" min="1000" max="9000" placeholder="false">
		    </label-->
		    
		    <label class="setting">
		      <span><?php echo __( 'Speed','ekiline' ); ?></span>
		      <select data-setting="speed">
		        <option value="false"> <?php echo __( 'Stop','ekiline' ); ?> </option>
		        <option value="3000"> <?php echo __( '3sec','ekiline' ); ?> </option>
		        <option value="6000"> <?php echo __( '6sec','ekiline' ); ?> </option>
		        <option value="9000"> <?php echo __( '9sec','ekiline' ); ?> </option>
		      </select>
		    </label>
		    
		    <label class="setting">
		        <span><?php echo __( 'Hide gutters','ekiline' ); ?></span>
		        <input type="checkbox" data-setting="gutters">
		    </label>  

		    <label class="setting">
		        <span><?php echo __( 'Show link as button','ekiline' ); ?></span>
		        <input type="checkbox" data-setting="showbutton">
		    </label>  
		    
		      
		    </div>
		  </script>
		
		  <script>
		
		    jQuery(document).ready(function(){
		
		      _.extend(wp.media.gallery.defaults, {
		        carousel: false,
		        showlink: false,
		        name: 'default',
		        align: 'text-center',
		        transition: 'none',
		        indicators: false,
		        speed: false,
		        gutters: false,
		        showbutton: false           
		      });
		
		      wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
		        template: function(view){
		          return wp.media.template('gallery-settings')(view)
		               + wp.media.template('ekiline-gallery-setting')(view);
		        }
		      });
		
		    });
		
		  </script>
		  <?php
		
		});
	}

}