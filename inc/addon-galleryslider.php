<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package ekiline
 */

// Carousel, si se detrmina que es un slider se añaden los marcos, flechas y jscript por cada carrusel, si se quieren colocar varios, se deben nombrar diferente.

add_filter( 'post_gallery', 'my_post_gallery', 10, 2 );
function my_post_gallery( $output, $attr) {
    global $post, $wp_locale;
    static $instance = 0;
    $instance++;
    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( !$attr['orderby'] )
            unset( $attr['orderby'] );
    }

    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'itemtag'    => 'div',
        'icontag'    => 'div',
        'captiontag' => 'div',
        'columns'    => 3,
        'size'       => 'thumbnail',
        'include'    => '',
        'exclude'    => '',
    	'carousel'   => '',
    	'name'		 => 'default',
    	'align'	     => 'text-center',
    	'indicators' => 'false',
    	'speed'	     => '3000',
    	'transition' => ''
    ), $attr));
    
    $id = intval($id);
    if ( 'RAND' == $order )
        $orderby = 'none';

    if ( !empty($include) ) {
        $include = preg_replace( '/[^0-9,]+/', '', $include );
        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( !empty($exclude) ) {
        $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }

    if ( empty($attachments) )
        return '';

    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        return $output;
    }
    
    
    if (!$carousel == 'true'){
    	if ($columns == '1'){
    		$numero = 'col-sm-12';
    	}
    	elseif ($columns == '2'){
    		$numero = 'col-xs-6';
    	}
    	elseif ($columns == '3'){
    		$numero = 'col-xs-4';
    	}
    	elseif ($columns == '4'){
    		$numero = 'col-sm-3 col-xs-6';
    	}
    	elseif ($columns == '5'){
    		$numero = 'col-sm-3 col-xs-6';
    	}
    	elseif ($columns == '6'){
    		$numero = 'col-sm-2 col-xs-6';
    	}
    	elseif ($columns == '7'){
    		$numero = 'col-sm-2 col-xs-6';
    	}
    	elseif ($columns == '8'){
    		$numero = 'col-sm-3 col-xs-6';
    	}
    	elseif ($columns == '9'){
    		$numero = 'col-sm-4 col-xs-6';
    	}
    }
    elseif ($carousel == 'true'){
                
        if ($columns == '1'){
            $numero = '';
            $galleryscript = '';
        }
        elseif ($columns == '2'){
            $numero = 'col-xs-6';
            $galleryscript = 'single-thumb x2';
        }
        elseif ($columns == '3'){
            $numero = 'col-xs-4';
            $galleryscript = 'single-thumb x3';
        }
        elseif ($columns == '4'){
            $numero = 'col-md-3 col-xs-6';
            $galleryscript = 'single-thumb x4';
        }
        elseif ($columns == '5'){
            $numero = 'col-md-2 col-xs-6';
            $galleryscript = 'single-thumb x6';
        }
        elseif ($columns == '6'){
            $numero = 'col-md-2 col-xs-6';
            $galleryscript = 'single-thumb x6';
        }           
        
    	//$numero = '';
    	$captionExtra = ' carousel-caption';
    	$carruselAbre = '<div data-ride="carousel-'.$name.'" data-interval="'.$speed.'" class="carousel slide '.$transition.' '.$galleryscript.'" id="carrusel-'.$name.'">';
    	$carruselCierra = '</div>';
    	$itemClass = 'item';
    	$laterales = '<a class="carousel-control left" href="#carrusel-'.$name.'" data-slide="prev"><i class="glyphicon glyphicon-chevron-left"></i>
    				  </a><a class="carousel-control right" href="#carrusel-'.$name.'" data-slide="next"><i class="glyphicon glyphicon-chevron-right"></i></a>';

    	foreach ( $_attachments as $key => $val ) {
    		if ($key == 0){
    			$activo = 'class="active"';
    		}else{$activo='';
    		}
    		$control .= '<li data-target="#carrusel-'.$name.'" data-slide-to="'.$key.'"'.$activo.'></li>';
    	}
    	
		if ($indicators == 'true'){
	    	$controles = '<ol class="carousel-indicators">'.$control.'</ol>';
		}
		
    	$carruselInternoAbre = '<div class="carousel-inner" role="listbox">';
    	$carruselInternoCierra = '</div>';
    	$first = true;
    	if ($align == 'izquierda'){$align = 'text-left';}
    	elseif ($align == 'derecha'){$align = 'text-right';}
    	 
    }
    $columns = $numero;    
    $wrapper ='<div class="row gallery-module wrapper-'.$name.'">';
    $wrapperClose ="</div>";
    
    
    foreach ( $attachments as $id => $attachment) { 
    	   
        if ( $first ){
	        $activo = 'active';
	        $first = false;
	    } else {
    		$activo = '';
    	}    	

    	$image = wp_get_attachment_image( $id, $size, false );    	
    	if(isset($attr['link']) && ('none' == $attr['link']) ){
    		$link = $image;
    	} else {
    		$link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);
    	}    	
    	 
        $output .= "<{$itemtag} class='gallery-item {$itemClass} {$activo}'>";  
              
            // En caso de tener textos añadir dentro de cada div de imagen
            
            if ( $captiontag || trim($attachment->post_excerpt) || trim($attachment->post_content) ) {
                
                // nuevas variables para cada etiqueta 
                if( $attachment->post_title ){ $slideTitle = "<h1 class='{$align}'>" . wptexturize($attachment->post_title) . "</h1>"; } else { $slideTitle =""; }
                if( $attachment->post_excerpt ){ $slideSubtitle = "<h2 class='{$align}'>" . wptexturize($attachment->post_excerpt) . "</h2>"; } else { $slideSubtitle =""; }
                if( $attachment->post_content ){ $slideParagraph = "<p class='{$align}'>". wptexturize($attachment->post_content) ."</p>"; } else { $slideParagraph =""; }
                    
                $slideCaption = "<{$captiontag} class='gallery-caption {$captionExtra}'>".$slideTitle.$slideSubtitle.$slideParagraph."</{$captiontag}>";
            }
            //continua arreglo
                            
        $output .= "<{$icontag} class='gallery-icon {$columns} {$align}'> $link $slideCaption </{$icontag}>";
                        
        $output .= "</{$itemtag}>";
    }

    return $wrapper.$carruselAbre.$controles.$carruselInternoAbre.$output.$carruselInternoCierra.$laterales.$carruselCierra.$wrapperClose;
}

/** 
* Añadimos funciones de personalización en la admnistracion de la galeria
* http://wordpress.stackexchange.com/questions/179357/custom-wordpress-gallery-option
* https://wordpress.org/support/topic/how-to-add-fields-to-gallery-settings
* http://wordpress.stackexchange.com/questions/182821/add-custom-fields-to-wp-native-gallery-settings
**/

add_action('print_media_templates', function(){

  // define your backbone template;
  // the "tmpl-" prefix is required,
  // and your input field should have a data-setting attribute
  // matching the shortcode name
  ?>
 
  <script type="text/html" id="tmpl-my-custom-gallery-setting">
    <div style="display:inline-block;margin-top:20px;border-top: 1px solid #C2C2C2;">
    <h2><?php _e('ekiline Settings'); ?></h2>
    
    <!--label class="setting">
      <span><?php _e('My setting'); ?></span>
      <select data-setting="my_custom_attr">
        <option value="foo"> Foo </option>
        <option value="bar"> Bar </option>
        <option value="default_val"> Default Value </option>
      </select>
    </label>

    <label class="setting">
        <span><?php _e('Text'); ?></span>
        <input type="text" value="" data-setting="ds_text" style="float:left;">
    </label>

    <label class="setting">
        <span><?php _e('Textarea'); ?></span>
        <textarea value="" data-setting="ds_textarea" style="float:left;"></textarea>
    </label>

    <label class="setting">
        <span><?php _e('Number'); ?></span>
        <input type="number" value="" data-setting="ds_number" style="float:left;" min="1" max="9">
    </label>

    <label class="setting">
      <span><?php _e('Select'); ?></span>
      <select data-setting="ds_select">
        <option value="option1"> 'Option-1' </option>
        <option value="option2"> 'Option-2' </option>
      </select>
    </label>

    <label class="setting">
        <span><?php _e('Bool'); ?></span>
        <input type="checkbox" data-setting="ds_bool">
    </label-->  
        
    <label class="setting">
        <span><?php _e('Transform to carousel'); ?></span>
        <input type="checkbox" data-setting="carousel">
    </label>  
    
    <label class="setting">
        <span><?php _e('Carousel name'); ?></span>
        <input type="text" value="" data-setting="name" placeholder="default">
    </label>
    
    <label class="setting">
      <span><?php _e('Carousel text caption align'); ?></span>
      <select data-setting="align">
        <option value="text-center"> <?php _e('Center'); ?> </option>
        <option value="text-left"> <?php _e('Left'); ?> </option>
        <option value="text-right"> <?php _e('Right'); ?> </option>
      </select>
    </label>

    <label class="setting">
      <span><?php _e('Carousel transition'); ?></span>
      <select data-setting="transition">
        <option value="none"> <?php _e('None'); ?> </option>
        <option value="carousel-fade"> <?php _e('Fade'); ?> </option>
        <option value="carousel-vertical"> <?php _e('Vertical'); ?> </option>
      </select>
    </label>

    <label class="setting">
        <span><?php _e('Show indicators'); ?></span>
        <input type="checkbox" data-setting="indicators">
    </label>  
    
    <label class="setting">
        <span><?php _e('Speed'); ?></span>
        <input type="number" value="" data-setting="speed" min="1000" max="9000" placeholder="3000">
    </label>

      
    </div>
  </script>

  <script>

    jQuery(document).ready(function(){

      // add your shortcode attribute and its default value to the
      // gallery settings list; $.extend should work as well...
      _.extend(wp.media.gallery.defaults, {
        /**my_custom_attr: 'default_val',
        ds_text: 'no text',
        ds_textarea: 'no more text',
        ds_number: "3",
        ds_select: 'option1',
        ds_bool: false,
        ds_text1: 'dummdideldei'    **/
        carousel: false,
        name: 'default',
        align: 'text-center',
        transition: 'none',
        indicators: false,
        speed: '3000'
           
      });

      // merge default gallery settings template with yours
      wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
        template: function(view){
          return wp.media.template('gallery-settings')(view)
               + wp.media.template('my-custom-gallery-setting')(view);
        }
      });

    });

  </script>
  <?php

});
