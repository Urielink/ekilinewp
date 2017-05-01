<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 * Algunos ejemplos del overide: 
 * Oficial: https://developer.wordpress.org/reference/functions/gallery_shortcode/
 * Corroborando los problemas que da: 
 *   -https://wordpress.stackexchange.com/questions/43558/how-to-manually-fix-the-wordpress-gallery-code-using-php-in-functions-php
 *
 * @package ekilinewp
 */

add_filter('post_gallery', 'ekilinewp_gallery', 10, 2);
 
function ekilinewp_gallery( $output,$attr ) {
    
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
        'name'       => 'default',
        'align'      => 'text-center',
        'indicators' => 'false',
        'speed'      => '3000',
        'transition' => ''
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
  
    
    /** Variables de carrusel p1: las clases CSS y variables de objetos **/
     
    $itemcol = '';
    $carousel = 'row';
    $carouselitem = 'item';
    $alignitems = $atts['align'];
    $indicators = '';
    $transition = '';
                    
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
    
         
    /** Fin de Variables de carrusel p1 **/
    
    
    $size_class = sanitize_html_class( $atts['size'] );
    $gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class} {$carousel} {$transition}'".$speed.">";
 
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
            if ( $first ) : $carouselitem = 'item active'; $first = false;
            else :  $carouselitem = 'item'; endif;                               
        }                  
    /** FIN Variables de carrusel p3 **/
                
        $output .= "<div class='{$carouselitem}'><{$itemtag} class='gallery-item {$itemcol} {$alignitems}'>";
        
            $output .= "<{$icontag} class='gallery-icon {$orientation}'>
                            $image_output
                        </{$icontag}>";
                
            if ( $captiontag && trim($attachment->post_excerpt) ) {
                                
            $output .= "<{$captiontag} class='wp-caption-text gallery-caption' id='$selector-$id'>
                        " . wptexturize($attachment->post_excerpt) . "
                        </{$captiontag}>";                        
            }
        
        $output .= "</{$itemtag}></div>";
        
        if ( empty( $atts['carousel'] ) && $columns > 1 && ++$i % $columns == 0 ) {
            $output .= '<div class="clearfix middle"></div>';
        }
    }
 
    if ( empty( $atts['carousel'] ) && $columns > 0 && $i % $columns !== 0 ) {
        $output .= '<div class="clearfix last"></div>';
    }
    
    if ( ! empty( $atts['carousel'] ) ) {
        $output .= '</div>'; /* <-- .carousel-inner" */
        
        $output .= '<a class="left carousel-control" href="#'.$selector.'" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span></a>
                    <a class="right carousel-control" href="#'.$selector.'" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span></a>';        
    }
    
 
    $output .= "</div>\n"; /* <-- $output = $gallery_div; */
         
    return $output;
}



/** 
* Añadimos funciones de personalizacion en la admnistracion de la galeria
* http://wordpress.stackexchange.com/questions/179357/custom-wordpress-gallery-option
* https://wordpress.org/support/topic/how-to-add-fields-to-gallery-settings
* http://wordpress.stackexchange.com/questions/182821/add-custom-fields-to-wp-native-gallery-settings
**/

add_action('print_media_templates', function(){
  ?>
 
  <script type="text/html" id="tmpl-ekilinewp-gallery-setting">
    <div style="display:inline-block;margin-top:20px;border-top: 1px solid #C2C2C2;">
    <h2><?php _e('ekilinewp Settings','ekilinewp'); ?></h2>
            
    <label class="setting">
        <span><?php _e('Transform to carousel','ekilinewp'); ?></span>
        <input type="checkbox" data-setting="carousel">
    </label>  
    
    <label class="setting">
        <span><?php _e('Carousel name','ekilinewp'); ?></span>
        <input type="text" value="" data-setting="name" placeholder="default">
    </label>
    
    <label class="setting">
      <span><?php _e('Carousel text caption align','ekilinewp'); ?></span>
      <select data-setting="align">
        <option value="text-center"> <?php _e('Center','ekilinewp'); ?> </option>
        <option value="text-left"> <?php _e('Left','ekilinewp'); ?> </option>
        <option value="text-right"> <?php _e('Right','ekilinewp'); ?> </option>
      </select>
    </label>

    <label class="setting">
      <span><?php _e('Carousel transition','ekilinewp'); ?></span>
      <select data-setting="transition">
        <option value="none"> <?php _e('None','ekilinewp'); ?> </option>
        <option value="carousel-fade"> <?php _e('Fade','ekilinewp'); ?> </option>
        <option value="carousel-vertical"> <?php _e('Vertical','ekilinewp'); ?> </option>
      </select>
    </label>

    <label class="setting">
        <span><?php _e('Show indicators','ekilinewp'); ?></span>
        <input type="checkbox" data-setting="indicators">
    </label>  
    
    <label class="setting">
        <span><?php _e('Speed','ekilinewp'); ?></span>
        <input type="number" value="" data-setting="speed" min="1000" max="9000" placeholder="3000">
    </label>
      
    </div>
  </script>

  <script>

    jQuery(document).ready(function(){

      _.extend(wp.media.gallery.defaults, {
        carousel: false,
        name: 'default',
        align: 'text-center',
        transition: 'none',
        indicators: false,
        speed: '3000'
           
      });

      wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
        template: function(view){
          return wp.media.template('gallery-settings')(view)
               + wp.media.template('ekilinewp-gallery-setting')(view);
        }
      });

    });

  </script>
  <?php

});
