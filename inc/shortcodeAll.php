<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package ekiline
 */


//columna por default mide 1 columna

function ekiline_columna($atts, $content = null) {
    extract(shortcode_atts(array('sangria' => '','ancho' => '12','bgcolor' => 'inherit','txtcolor' => ''), $atts));
    return '<div class="columna col-sm-offset-'.$sangria.' col-sm-'.$ancho.'" style="background-color:'.$bgcolor.';color:'.$txtcolor.';">' . do_shortcode($content) . '</div>';
}
add_shortcode('columna', 'ekiline_columna');

//bloquecon texto centrado, por default mide 6columns y tiene fondo negro.

function ekiline_bloque($atts, $content = null) {
    extract(shortcode_atts(array('ancho' => '6','bgcolor' => '#000000','txtcolor' => '','bgimage' => 'none'), $atts));
    return '<div class="bloque col-sm-'.$ancho.'" style="background-color:'.$bgcolor.';color:'.$txtcolor.';background-image:url('.$bgimage.');"><div class="inblock">' . do_shortcode($content) . '</div></div>';
}
add_shortcode('bloque', 'ekiline_bloque');

//Contenedor es necesario si se requieren dividir la informacion en secciones.

function ekiline_contenedor($atts, $content = null) {
    extract(shortcode_atts(array('bgimage' => 'none','txtcolor' => '','class' => '','type' => 'row'), $atts));
    return '<div class="'.$type.' seccion '.$class.'" style="background-image:url('.$bgimage.');color:'.$texto.';">' . do_shortcode($content) . '</div>';
}
add_shortcode('contenedor', 'ekiline_contenedor');

// acordeon, este debe tener un titulo y la descricpion se insertara en un div

function ekiline_acordeon($atts, $content = null) {
    extract(shortcode_atts(array('titulo' => '','bgcolor'=>'#17B2CE','txtcolor'=>'','ancho'=>'normal'), $atts));
    $titleBtn = limpiarCaracteres($titulo);
    return '<a class="btn btn-block btn-info" data-toggle="collapse" href="#'.$titleBtn.'" aria-expanded="false" aria-controls="'.$titleBtn.'">'.$titulo.'</a>
            <div class="'.$ancho.' acordeon collapse" id="'.$titleBtn.'"><div style="background-color:'.$bgcolor.';color:'.$txtcolor.';padding:15px;overflow:hidden;">'.do_shortcode($content).'</div></div>';
}
add_shortcode('acordeon', 'ekiline_acordeon');



// Cover, este debe tener un titulo, como el contenido puede variar este se debe estar en un div a parte.

function ekiline_cover($atts, $content = null) {
    extract(shortcode_atts(array('title' => '','bgcolor'=>'#17B2CE','txtcolor'=>'#FFFFFF','bgimage'=>'none'), $atts));
    $titleBtn = limpiarCaracteres($titulo);
    return '    
    <div class="cover-wrapper" style="background-color:'.$bgcolor.';color:'.$txtcolor.';background-image:url('.$bgimage.');">
      <div class="cover-wrapper-inner">
        <div class="cover-container">
          <div class="cover-header clearfix">
            <div class="inner">
              <h3 class="cover-header-brand">'.$title.'</h3>
              <!--nav>
                <ul class="nav cover-header-nav">
                  <li class="active"><a href="#">Home</a></li>
                  <li><a href="#">Features</a></li>
                  <li><a href="#">Contact</a></li>
                </ul>
              </nav-->
            </div>
          </div>
          <div class="inner cover">'.do_shortcode($content).'</div>
          <!--div class="cover-footer">
            <div class="inner">
              <p>Cover footer.</p>
            </div>
          </div-->
        </div>
      </div>
    </div>      
    ';
}
add_shortcode('covermodule', 'ekiline_cover');


//Hacer un include con un shortcode.
/**
function ekiline_include($atts, $content = null) {
    
    extract( shortcode_atts( array( 'archivo' => '' ), $atts) );

    $path = $_SERVER['DOCUMENT_ROOT'].'/'.$archivo;
    
    ob_start(); // abre         

    echo include( $path );
    
    $insertarInclude = ob_get_clean(); // cierra
 
    return $insertarInclude;        
            
    }
    
add_shortcode('include', 'ekiline_include');
**/

//Hacer un iFrame con un shortcode.
function ekiline_iframe($atts, $content = null) {
    extract(shortcode_atts(array('archivo' => '', 'proporcion' => 'regular'), $atts));

    if ($proporcion == 'widescreen') {
        $proporcion = '16by9';
    } elseif ($proporcion == 'regular'){
        $proporcion = '4by3';
    }

    
    ob_start(); // abre         

        echo '<div class="embed-responsive embed-responsive-'.$proporcion.'">
                <iframe class="embed-responsive-item" src="'.$archivo.'"></iframe>
              </div>';      
        
    $insertarIframe = ob_get_clean(); // cierra
 
    return $insertarIframe;     
            
    }
add_shortcode('iframe', 'ekiline_iframe');

/* agregar Feeds RSS con un shortcode
 * [rss feed="url" num="5"]
 *
 
//This file is needed to be able to use the wp_rss() function.

include_once(ABSPATH.WPINC.'/rss.php');

function readRss($atts) {
    extract(shortcode_atts(array(
    "feed" => 'http://',
      "num" => '1',
    ), $atts));

    return wp_rss($feed, $num);
}

add_shortcode('rss', 'readRss'); 
**/

/* Eliminar parrafos vacios en shortcodes.
 * http://mattpierce.info/2015/10/fixing-shortcodes-and-paragraph-tags-in-wordpress/
 * https://gist.github.com/maxxscho/2058547
 */

 function shortcode_empty_paragraph_fix($content)
{  
    $array = array (
        '<p>[' => '[',
        ']</p>' => ']',
        ']<br />' => ']'
    );

    $content = strtr($content, $array);

    return $content;
}

add_filter('the_content', 'shortcode_empty_paragraph_fix');