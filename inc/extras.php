<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package ekiline
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function ekiline_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	//Page Slug Body Class
	global $post;
	if ( isset( $post ) ) {
		$classes[] = $post->post_type . '-' . $post->post_name;
	}
		
	return $classes;
}
add_filter( 'body_class', 'ekiline_body_classes' );

// SEO en caso de necesitar etiquetas en las páginas:
// https://www.sitepoint.com/wordpress-pages-use-tags/

// add tag support to pages
function tags_support_all() {
	register_taxonomy_for_object_type('post_tag', 'page');
}
add_action('init', 'tags_support_all');


// ensure all tags are included in queries
function tags_support_query($wp_query) {
	if ($wp_query->get('tag')) $wp_query->set('post_type', 'any');
}
add_action('pre_get_posts', 'tags_support_query');


// SEO extraer las etiquetas como keywords

function getTags() {		
	global $post;
	
	if( is_single() || is_page() || is_home() ) :
		$tags = get_the_tags($post->ID);
		if($tags) :
			foreach($tags as $tag) :
				$sep = (empty($keywords)) ? '' : ', ';
				$keywords .= $sep . $tag->name;
			endforeach;
	
	 		echo $keywords;
	
		endif;
	endif;
}

// custom field, la descripción de un artículo
function cfPageDescription() { 
    global $wp_query;
    $postid = $wp_query->post->ID;
    echo get_post_meta($postid, 'pagina-descripcion', true);
    wp_reset_query();
}

/** si necesitaramos añadir campos en la edicion usamos metabox: 
 *  https://developer.wordpress.org/reference/functions/add_meta_box/
 *  https://www.sitepoint.com/adding-custom-meta-boxes-to-wordpress/
 **/

// En caso de necesitar limpiar o reemplazar caracteres especiales.

function limpiarCaracteres($string) {
	$string = str_replace(' ', '-', $string);
	$intercambio = array('á' => 'a', 'Á' => 'A', 'à' => 'a', 'À' => 'A', 'ă' => 'a', 'Ă' => 'A', 'â' => 'a', 'Â' => 'A', 'å' => 'a', 'Å' => 'A', 'ã' => 'a', 'Ã' => 'A', 'ą' => 'a', 'Ą' => 'A', 'ā' => 'a', 'Ā' => 'A', 'ä' => 'ae', 'Ä' => 'AE', 'æ' => 'ae', 'Æ' => 'AE', 'ḃ' => 'b', 'Ḃ' => 'B', 'ć' => 'c', 'Ć' => 'C', 'ĉ' => 'c', 'Ĉ' => 'C', 'č' => 'c', 'Č' => 'C', 'ċ' => 'c', 'Ċ' => 'C', 'ç' => 'c', 'Ç' => 'C', 'ď' => 'd', 'Ď' => 'D', 'ḋ' => 'd', 'Ḋ' => 'D', 'đ' => 'd', 'Đ' => 'D', 'ð' => 'dh', 'Ð' => 'Dh', 'é' => 'e', 'É' => 'E', 'è' => 'e', 'È' => 'E', 'ĕ' => 'e', 'Ĕ' => 'E', 'ê' => 'e', 'Ê' => 'E', 'ě' => 'e', 'Ě' => 'E', 'ë' => 'e', 'Ë' => 'E', 'ė' => 'e', 'Ė' => 'E', 'ę' => 'e', 'Ę' => 'E', 'ē' => 'e', 'Ē' => 'E', 'ḟ' => 'f', 'Ḟ' => 'F', 'ƒ' => 'f', 'Ƒ' => 'F', 'ğ' => 'g', 'Ğ' => 'G', 'ĝ' => 'g', 'Ĝ' => 'G', 'ġ' => 'g', 'Ġ' => 'G', 'ģ' => 'g', 'Ģ' => 'G', 'ĥ' => 'h', 'Ĥ' => 'H', 'ħ' => 'h', 'Ħ' => 'H', 'í' => 'i', 'Í' => 'I', 'ì' => 'i', 'Ì' => 'I', 'î' => 'i', 'Î' => 'I', 'ï' => 'i', 'Ï' => 'I', 'ĩ' => 'i', 'Ĩ' => 'I', 'į' => 'i', 'Į' => 'I', 'ī' => 'i', 'Ī' => 'I', 'ĵ' => 'j', 'Ĵ' => 'J', 'ķ' => 'k', 'Ķ' => 'K', 'ĺ' => 'l', 'Ĺ' => 'L', 'ľ' => 'l', 'Ľ' => 'L', 'ļ' => 'l', 'Ļ' => 'L', 'ł' => 'l', 'Ł' => 'L', 'ṁ' => 'm', 'Ṁ' => 'M', 'ń' => 'n', 'Ń' => 'N', 'ň' => 'n', 'Ň' => 'N', 'ñ' => 'n', 'Ñ' => 'N', 'ņ' => 'n', 'Ņ' => 'N', 'ó' => 'o', 'Ó' => 'O', 'ò' => 'o', 'Ò' => 'O', 'ô' => 'o', 'Ô' => 'O', 'ő' => 'o', 'Ő' => 'O', 'õ' => 'o', 'Õ' => 'O', 'ø' => 'oe', 'Ø' => 'OE', 'ō' => 'o', 'Ō' => 'O', 'ơ' => 'o', 'Ơ' => 'O', 'ö' => 'oe', 'Ö' => 'OE', 'ṗ' => 'p', 'Ṗ' => 'P', 'ŕ' => 'r', 'Ŕ' => 'R', 'ř' => 'r', 'Ř' => 'R', 'ŗ' => 'r', 'Ŗ' => 'R', 'ś' => 's', 'Ś' => 'S', 'ŝ' => 's', 'Ŝ' => 'S', 'š' => 's', 'Š' => 'S', 'ṡ' => 's', 'Ṡ' => 'S', 'ş' => 's', 'Ş' => 'S', 'ș' => 's', 'Ș' => 'S', 'ß' => 'SS', 'ť' => 't', 'Ť' => 'T', 'ṫ' => 't', 'Ṫ' => 'T', 'ţ' => 't', 'Ţ' => 'T', 'ț' => 't', 'Ț' => 'T', 'ŧ' => 't', 'Ŧ' => 'T', 'ú' => 'u', 'Ú' => 'U', 'ù' => 'u', 'Ù' => 'U', 'ŭ' => 'u', 'Ŭ' => 'U', 'û' => 'u', 'Û' => 'U', 'ů' => 'u', 'Ů' => 'U', 'ű' => 'u', 'Ű' => 'U', 'ũ' => 'u', 'Ũ' => 'U', 'ų' => 'u', 'Ų' => 'U', 'ū' => 'u', 'Ū' => 'U', 'ư' => 'u', 'Ư' => 'U', 'ü' => 'ue', 'Ü' => 'UE', 'ẃ' => 'w', 'Ẃ' => 'W', 'ẁ' => 'w', 'Ẁ' => 'W', 'ŵ' => 'w', 'Ŵ' => 'W', 'ẅ' => 'w', 'Ẅ' => 'W', 'ý' => 'y', 'Ý' => 'Y', 'ỳ' => 'y', 'Ỳ' => 'Y', 'ŷ' => 'y', 'Ŷ' => 'Y', 'ÿ' => 'y', 'Ÿ' => 'Y', 'ź' => 'z', 'Ź' => 'Z', 'ž' => 'z', 'Ž' => 'Z', 'ż' => 'z', 'Ż' => 'Z', 'þ' => 'th', 'Þ' => 'Th', 'µ' => 'u', 'а' => 'a', 'А' => 'a', 'б' => 'b', 'Б' => 'b', 'в' => 'v', 'В' => 'v', 'г' => 'g', 'Г' => 'g', 'д' => 'd', 'Д' => 'd', 'е' => 'e', 'Е' => 'E', 'ё' => 'e', 'Ё' => 'E', 'ж' => 'zh', 'Ж' => 'zh', 'з' => 'z', 'З' => 'z', 'и' => 'i', 'И' => 'i', 'й' => 'j', 'Й' => 'j', 'к' => 'k', 'К' => 'k', 'л' => 'l', 'Л' => 'l', 'м' => 'm', 'М' => 'm', 'н' => 'n', 'Н' => 'n', 'о' => 'o', 'О' => 'o', 'п' => 'p', 'П' => 'p', 'р' => 'r', 'Р' => 'r', 'с' => 's', 'С' => 's', 'т' => 't', 'Т' => 't', 'у' => 'u', 'У' => 'u', 'ф' => 'f', 'Ф' => 'f', 'х' => 'h', 'Х' => 'h', 'ц' => 'c', 'Ц' => 'c', 'ч' => 'ch', 'Ч' => 'ch', 'ш' => 'sh', 'Ш' => 'sh', 'щ' => 'sch', 'Щ' => 'sch', 'ъ' => '', 'Ъ' => '', 'ы' => 'y', 'Ы' => 'y', 'ь' => '', 'Ь' => '', 'э' => 'e', 'Э' => 'e', 'ю' => 'ju', 'Ю' => 'ju', 'я' => 'ja', 'Я' => 'ja');
	$string = str_replace(array_keys($intercambio), array_values($intercambio), $string);
	return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
}

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

//Contenedor es necesario si se requieren dividir la información en secciones.

function ekiline_contenedor($atts, $content = null) {
	extract(shortcode_atts(array('bgimage' => 'none','txtcolor' => '','class' => '','type' => 'row'), $atts));
	return '<div class="'.$type.' seccion '.$class.'" style="background-image:url('.$bgimage.');color:'.$texto.';">' . do_shortcode($content) . '</div>';
}
add_shortcode('contenedor', 'ekiline_contenedor');

// acordeon, este debe tener un título y la descricpión se insertará en un div

function ekiline_acordeon($atts, $content = null) {
	extract(shortcode_atts(array('titulo' => '','bgcolor'=>'#17B2CE','txtcolor'=>'','ancho'=>'normal'), $atts));
	$titleBtn = limpiarCaracteres($titulo);
	return '<a class="btn btn-block btn-info" data-toggle="collapse" href="#'.$titleBtn.'" aria-expanded="false" aria-controls="'.$titleBtn.'">'.$titulo.'</a>
			<div class="'.$ancho.' acordeon collapse" id="'.$titleBtn.'"><div style="background-color:'.$bgcolor.';color:'.$txtcolor.';padding:15px;overflow:hidden;">'.do_shortcode($content).'</div></div>';
}
add_shortcode('acordeon', 'ekiline_acordeon');


// Cover, este debe tener un título, como el contenido puede variar este se debe estar en un div a parte.

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
              <p>Cover template for <a href="http://getbootstrap.com">Bootstrap</a>, by <a href="https://twitter.com/mdo">@mdo</a>.</p>
            </div>
          </div-->
        </div>
      </div>
    </div>		
	';
}
add_shortcode('covermodule', 'ekiline_cover');



/** Importar un listado de entradas de alguna categoria, se genera un loop. 
 * https://css-tricks.com/snippets/wordpress/run-loop-on-posts-of-specific-category/ 
 * http://code.tutsplus.com/tutorials/create-a-shortcode-to-list-posts-with-multiple-parameters--wp-32199
 * Especial atención en el uso de ob_start();
 * http://wordpress.stackexchange.com/questions/41012/proper-use-of-output-buffer
**/

function ekiline_insertar($atts, $content = null) {
	
	extract(shortcode_atts(array('titulo'=>'','categoria'=>'','limite'=>'', 'class'=>'default-list', 'orden'=>'DES'), $atts));

	// mi variable de titulo
	if ($titulo){$titulo = '<h2 class="text-center">'.$titulo.'</h2>';}
		
	ob_start(); // abre 
	
			// invoca las cotegorias necesarias WP_Query()
			$nuevoLoop = new WP_Query($query_string . '&cat='.$categoria.'&posts_per_page='.$limite.'&order='.$orden );
			// obtiene la cuenta de los posts
			$post_counter = 0; 
				
								
			if ( $nuevoLoop->have_posts() ) {
					
				if ($class == 'default-list'){				
				
					echo $titulo.'<div class="clearfix '.$class.'">';	
					
						while ( $nuevoLoop->have_posts() ) {
							  $nuevoLoop->the_post(); 
							  		// $post_counter++;  
										// trae la parte del template para personalizar
							  			get_template_part( 'template-parts/content', 'insert' );
										// por cada 3 posts mete un hr
								  	/**	if ($post_counter == 1):{ echo '<hr>'; } 
											// resetea el contador
										    $post_counter = 0; 
								        endif; **/
								}
							
					echo '</div>';
				
				} 
					
				else if ($class == 'blocklist'){
							
					/* cambiar el modo de como se muestra el boton leer más	
					 * https://codex.wordpress.org/Customizing_the_Read_More */
																	
					echo $titulo.'<div class="clearfix container '.$class.'">';	
					
						while( $nuevoLoop->have_posts() ) : $nuevoLoop->the_post(); 								
						
							$count++;								
				  			
				  			get_template_part( 'template-parts/content', 'blocklist' );
							// por cada 3 posts mete un hr
						  	if ($count == 3) : echo '<hr>'; $count = 0;  endif;
						  	
						endwhile;
							
					echo '</div>';
				
				} 				
				
				else if ($class == 'carousel'){
					
				// Limpiar las comas de las categorias para ejecutar carrusel en caso de ser más de una.	
					$categoria = limpiarCaracteres($categoria);					
				
					echo $titulo.'<div id="carousel-module-00'.$categoria.'" class="'.$class.' slide clearfix" data-ride="carousel"><div class="carousel-inner" role="listbox">';	
				
				// Indicadores	
	                echo '<ol class="carousel-indicators">';
	                	while( $nuevoLoop->have_posts() ) : $nuevoLoop->the_post();
	                        $count = $nuevoLoop->current_post + 0;
	                        if ($count == '0') : $countclass = 'active' ; elseif ($count !='0') : $countclass = '' ; endif; 
	                    	echo '<li data-target="#carousel-module-00'.$categoria.'" data-slide-to="'.$count.'" class="'.$countclass.'"></li>';
	                	endwhile;
	                echo '</ol>' ; 					
	                
				// ITEMS
					while( $nuevoLoop->have_posts() ) : $nuevoLoop->the_post(); 							  	
                        $count = $nuevoLoop->current_post + 0;
                        if ($count == '0') : $countclass = 'active' ; elseif ($count !='0') : $countclass = '' ; endif; 							  	
							// trae la parte del template para personalizar
							echo '<div class="item '.$countclass.'">';
				  				get_template_part( 'template-parts/content', 'carousel' );
							echo '</div>';
					endwhile;
								
								
				// Controles		
					echo '</div>
						  <a class="left carousel-control" href="#carousel-module-00'.$categoria.'" role="button" data-slide="prev">
						    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
						    <span class="sr-only">Previous</span>
						  </a>
						  <a class="right carousel-control" href="#carousel-module-00'.$categoria.'" role="button" data-slide="next">
						    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
						    <span class="sr-only">Next</span>
						  </a>
						  </div>';										
					
						
				}

			} //.if $nuevoLoop
						
	
			wp_reset_postdata(); // resetea la petición
		
		
    $insertarItem = ob_get_clean(); // cierra
    
    return $insertarItem;		

}
add_shortcode('insertar', 'ekiline_insertar');



//Hacer un include con un shortcode.
function ekiline_include($atts, $content = null) {
	extract(shortcode_atts(array('archivo' => ''), $atts));

	$path = $_SERVER['DOCUMENT_ROOT'].'/'.$archivo;
	
	ob_start(); // abre 		

	echo include( $path );
	
    $insertarInclude = ob_get_clean(); // cierra
 
    return $insertarInclude;		
    		
	}
add_shortcode('include', 'ekiline_include');


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


// Elementos del formulario de búsqueda

function my_search_form( $form ) {
    $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
    <label class="screen-reader-text" for="s">' . esc_html__( 'Search Results for: %s', 'ekiline' ) . '</label>
    <div class="input-group">
    <input class="form-control" type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . esc_html__( 'Search Results for: %s', 'ekiline' ) . '"/>
    <span class="input-group-btn"><input class="btn btn-default" type="submit" id="searchsubmit" value="'. esc_attr__( 'Search' ) .'" /></span>
    </div>
    </form>';

    return $form;
}

add_filter( 'get_search_form', 'my_search_form' );


/** Sidebars dinamicas **/

/* En caso de que el sidebar esté activo, añade la clase columna de 9: 
 *index.php, single.php, search.php, page.php, archive.php, 404.php */

function sideOn() {
    if ( is_active_sidebar( 'sidebar-1' ) && !is_active_sidebar( 'sidebar-2' ) ) {
             $sideon = ' col-sm-9 side1'; 
    } else if ( !is_active_sidebar( 'sidebar-1' ) && is_active_sidebar( 'sidebar-2' ) ) {
             $sideon = ' col-sm-9 side2'; 
    } else if ( is_active_sidebar( 'sidebar-1' ) && is_active_sidebar( 'sidebar-2' ) ) {
             $sideon = ' col-sm-6 side1 side2'; 
    }     
    echo $sideon;
}

/* Para que la información interna tenga una mejor distribución,
 * no siempre el fullwidth es necesario  */

function mainContainer() {
    
    if ( ! is_home() && ! is_front_page() ) {
             $mainContainer = ' main-custom'; 
    } 
    echo $mainContainer;
}

/** Personalizar el tema desde las opciones, logo, fondo, etc **/

function ekiline_theme_customizer( $wp_customize ) {
	
// colores	
	$colors = array();
	$colors[] = array( 'slug'=>'text_color', 'default' => '#7c8d96', 'label' => __( 'Color de texto', 'ekiline' ) );
	$colors[] = array( 'slug'=>'links_color', 'default' => '#f8af0c', 'label' => __( 'Color de links', 'ekiline' ) );
	$colors[] = array( 'slug'=>'module_color', 'default' => '#d0d7dd', 'label' => __( 'Color de modulos', 'ekiline' ) );
	
	foreach($colors as $color)
	{
		// SETTINGS
		$wp_customize->add_setting( $color['slug'], array( 'default' => $color['default'], 'type' => 'option', 'capability' => 'edit_theme_options' ));

		// CONTROLS
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $color['slug'], array( 'label' => $color['label'], 'section' => 'colors', 'settings' => $color['slug'] )));
	}

// añadir un controlador: https://codex.wordpress.org/Class_Reference/WP_Customize_Control	
// https://make.wordpress.org/core/2014/07/08/customizer-improvements-in-4-0/
// https://developer.wordpress.org/themes/advanced-topics/customizer-api/

	$wp_customize->add_setting( 'ekiline_logo_max' );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ekiline_logo_max', array(
			'label'    => __( 'Imagen de logo horizontal', 'ekiline' ),
			'description' => 'Esta imagen se recomienda para su vista en ordenadores de escritorio.',
			'section'  => 'title_tagline', // esta seccion corresponde a una predeterminada.
			'settings' => 'ekiline_logo_max',
			'priority' => 100,
	) ) );

	$wp_customize->add_setting( 'ekiline_logo_min' );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ekiline_logo_min', array(
		'label'    => __( 'Imagen de logo vertical', 'ekiline' ),
		'description' => 'Esta imagen se recomienda para su vista en dispositivos móviles.',
		'section'  => 'title_tagline', // esta seccion corresponde a una predeterminada.
		'settings' => 'ekiline_logo_min',
		'priority' => 100,
	) ) );	
		
/** // video
	$wp_customize->add_section( 'ekiline_video_portada' , array(
			'title'       => __( 'Video de cabecera', 'ekiline' ),
			'priority'    => 90,
			'description' => '<b>Debes tener una imagen de cabecera</b>.<br/>Elige un archivo de video <b>MP4, WEBM u OGV</b> de tu biblioteca. La imagen de cabecera se adaptará como fondo en caso de que los dispositivos no puedan reproducir video.',
	) );
	
	$wp_customize->add_setting( 'ekiline_video' );
	
	$wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, 'ekiline_video', array(
			'label'    => __( 'Video MP4, WEBM u OGV', 'ekiline' ),
			'section'  => 'ekiline_video_portada',
			'settings' => 'ekiline_video',
	) ) );	
**/

// ancho de la página
    $wp_customize->add_section( 'ekiline_vista_section' , array(
            'title'       => __( 'Vista de tu sitio', 'ekiline' ),
            'priority'    => 50,
            'description' => 'Elige si quieres que el homepage, los listados o el articulo principal se desplieguen a todo lo ancho (fullwidth) o ajustada al centro.',
    ) );
	
	    $wp_customize->add_setting(
	        'ekiline_anchoHome', array(
	                'default' => 'container',
	            ) );
	    
	    $wp_customize->add_control(
	        'ekiline_anchoHome',
	        array(
	            'type' => 'radio',
	            'label' => 'Homepage',
	            'section' => 'ekiline_vista_section',
	            'choices' => array(
	                'container' => 'Ajustado',
	                'container-fluid' => 'A todo lo ancho',
	            ),
	        )
	    );      
	    
	    $wp_customize->add_setting(
	        'ekiline_anchoCategory', array(
	                'default' => 'container',
	            ) );
	    
	    $wp_customize->add_control(
	        'ekiline_anchoCategory',
	        array(
	            'type' => 'radio',
	            'label' => 'Categorías o listados',
	            'section' => 'ekiline_vista_section',
	            'choices' => array(
	                'container' => 'Ajustado',
	                'container-fluid' => 'A todo lo ancho',
	            ),
	        )
	    ); 
	    
	    $wp_customize->add_setting(
	        'ekiline_anchoSingle', array(
	                'default' => 'container',
	            ) );
	    
	    $wp_customize->add_control(
	        'ekiline_anchoSingle',
	        array(
	            'type' => 'radio',
	            'label' => 'Páginas individuales',
	            'section' => 'ekiline_vista_section',
	            'choices' => array(
	                'container' => 'Ajustado',
	                'container-fluid' => 'A todo lo ancho',
	            ),
	        )
	    );         
		
		// ocultar y mostrar sidebars

	    $wp_customize->add_setting(
	        'ekiline_sidebarLeft', array(
	                'default' => 'on',
	            ) );
	    
	    $wp_customize->add_control(
	        'ekiline_sidebarLeft',
	        array(
	            'type' => 'radio',
	            'label' => 'Sidebar izquierdo',
	            'section' => 'ekiline_vista_section',
	            'choices' => array(
	                'on' => 'Visible',
	                'off' => 'Plegable',
	            ),
	        )
	    );     
		
	    $wp_customize->add_setting(
	        'ekiline_sidebarRight', array(
	                'default' => 'on',
	            ) );
	    
	    $wp_customize->add_control(
	        'ekiline_sidebarRight',
	        array(
	            'type' => 'radio',
	            'label' => 'Sidebar derecho',
	            'section' => 'ekiline_vista_section',
	            'choices' => array(
	                'on' => 'Visible',
	                'off' => 'Plegable',
	            ),
	        )
	    );  	 			    
	
	
	
	
// Optimización, códigos de seguimiento
   
	$wp_customize->add_section( 'ekiline_tracking_section' , array(
			'title'       => __( 'Optimización', 'ekiline' ),
			'priority'    => 150,
			'description' => __( 'Añade los códigos de seguimiento que te ayudarán a optimizar y dar seguimiento a este sitio web.', 'ekiline' )
	) );

// Código de analytics	
	$wp_customize->add_setting( 
		'ekiline_analytics', array(
			'default' => ''
		) );
	
	$wp_customize->add_control(
	    'ekiline_analytics',
	        array(
	            'label'          => __( 'Trackeo de Google', 'ekiline' ),
				'description' 	 => 'Inserta el código de Google analytics, solo tu identificador (UA-XXXXX-XX)',
	            'section'        => 'ekiline_tracking_section',
	            'settings'       => 'ekiline_analytics',
	            'type'           => 'text'
	        )
		);    	
    
}
add_action('customize_register', 'ekiline_theme_customizer');


/**
 * Una vez personalizados los colores creamos una funcion para añadiros al header 
 * (https://codex.wordpress.org/Plugin_API/Action_Reference/wp_head).
 * 
 **/

function cssColors() {
		
// variables para los colores al instalar el tema.		
	$texto = get_option('text_color');
	$enlaces = get_option('links_color');
	$modulos = get_option('module_color');

	// si las opciones no están customizadas utiliza los valores por default.
	if ( $texto == '') : $texto = '#7c8d96'; else : $texto ; endif;
	if ( $enlaces == '') : $enlaces = '#f8af0c'; else : $enlaces ; endif;
	if ( $modulos == '') : $modulos = '#d0d7dd'; else : $modulos ; endif;

	$miestilo = '<style id="ekiline-inline" type="text/css" media="all"> 
		body{font-family: "Open Sans", Arial, Helvetica, sans-serif;	}
		h1,h2,h3,h4,h5,h6,.h1,.h2,.h3,.h4,.h5,.h6{font-family: "Raleway", Arial, Helvetica, sans-serif;}
		body,.mini-fecha .dia{ color:'.$texto.'; }
		a{ color:'.$enlaces.'; }
		a:hover,a:focus,a:active{ color:'.$modulos.'; }
        body > footer, .site-footer, .mini-fecha .dia{ background-color:'.$modulos.'; }
        .mini-fecha .mes{ background-color:'.$texto.'; }
		</style>';

	echo $miestilo;

}
add_action('wp_head','cssColors');

/**
 *  Si el usuario desea añadir un logotipo en el navbar-brand:
 **/
 
function logoTheme() {
    
    if ( get_theme_mod( 'ekiline_logo_max' ) && !get_theme_mod( 'ekiline_logo_min' ) ) {
        echo '<img class="img-responsive" src="' . get_theme_mod( 'ekiline_logo_max' ) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '"/>';
    } elseif ( get_theme_mod( 'ekiline_logo_min' ) && !get_theme_mod( 'ekiline_logo_max' ) ) {
        echo '<img class="img-responsive" src="' . get_theme_mod( 'ekiline_logo_min' ) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '"/>';
    } elseif ( get_theme_mod( 'ekiline_logo_max' ) && get_theme_mod( 'ekiline_logo_min' ) ) {
        echo '<img class="img-responsive hidden-xs" src="' . get_theme_mod( 'ekiline_logo_max' ) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '"/>
        <img class="img-responsive visible-xs" src="' . get_theme_mod( 'ekiline_logo_min' ) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '"/>';
    } else {
        echo bloginfo( 'name' );
    } 

}

// Imagen de cabecera

function headerStyle() {
    if (get_header_image()){   
        echo 'style="background-image:url(' . get_header_image() . ');"';
    }
}

function headerImage() {
    if (get_header_image()){   
        echo '<img src="' . get_header_image() . '" />';
    }
}


// Imagen destacada

function destacadoStyle() {
    // si es post o página :
    if ( is_single() || is_page() ){
        $titulo = get_the_title($post->ID);    
    }
        
    // y si tiene imagen destacada
    if ( has_post_thumbnail() ) {
        $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
        echo '<div class="destacado-estilo" style="background-image: url(' . $url . ');"><h1>'.$titulo.'</h1></div>'; 
    }    
}

function destacadoUrl() {    
    if ( has_post_thumbnail() ) {
        $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
        echo $url;        
    }    
}

function destacadoImage() {
    if ( has_post_thumbnail() ) {  
        echo the_post_thumbnail();

        // the_post_thumbnail( 'thumbnail' );       // Thumbnail (default 150px x 150px max)
        // the_post_thumbnail( 'medium' );          // Medium resolution (default 300px x 300px max)
        // the_post_thumbnail( 'large' );           // Large resolution (default 640px x 640px max)
        // the_post_thumbnail( 'full' );            // Full resolution (original size uploaded)         
        //  the_post_thumbnail( array(100, 100) );  // Other resolutions                        
        
    }
}

/*Arreglo para que el ancho del sitio web se genere solo en una página, en este caso el home*/
function wideSite() {
    if ( is_front_page() || is_home() ){
    	echo get_theme_mod( 'ekiline_anchoHome', 'container' );
    }
	elseif ( is_single() || is_page() || is_search() || is_404() ){
    	echo get_theme_mod( 'ekiline_anchoSingle', 'container' );
    }        
	elseif ( is_archive() || is_category() ){
    	echo get_theme_mod( 'ekiline_anchoCategory', 'container' );
    }    
        
}

// el extracto: https://codex.wordpress.org/Function_Reference/the_excerpt
function custom_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function customExcerptBtn( $more ) {
    return '<p><a class="read-more" href="' . get_permalink( get_the_ID() ) . '">' . __( 'Leer más', 'ekiline' ) . '</a></p>';
}
add_filter( 'excerpt_more', 'customExcerptBtn' );

/** remover [shortcodes] del extracto: 
	https://wordpress.org/support/topic/stripping-shortcodes-keeping-the-content
	http://wordpress.stackexchange.com/questions/112010/strip-shortcode-from-excerpt 
	Bueno: https://wordpress.org/support/topic/how-to-enable-shortcodes-in-excerpts
**/

function wp_trim_excerpt_do_shortcode($text) {
	$raw_excerpt = $text;
	if ( '' == $text ) {
		$text = get_the_content('');

		$text = do_shortcode( $text ); // CHANGED HERE

		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]>', $text);
		$text = strip_tags($text);
		$excerpt_length = apply_filters('excerpt_length', 55);
		$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
		$words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
		if ( count($words) > $excerpt_length ) {
			array_pop($words);
			$text = implode(' ', $words);
			$text = $text . $excerpt_more;
		} else {
			$text = implode(' ', $words);
		}
	}
	return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'wp_trim_excerpt_do_shortcode');

// widgets dinamicos: Ejemplo en caso de tener varios en un espacio
/**
function footerWidgets() {
        
    if ( is_active_sidebar( 'footer-w1' ) || is_active_sidebar( 'footer-w2' ) || is_active_sidebar( 'footer-w3' ) ) {
        return dynamic_sidebar( 'footer-w1' ).dynamic_sidebar( 'footer-w2' ).dynamic_sidebar( 'footer-w3' );
    }

}
**/

// widgets en la parte superior top.
if ( ! function_exists ( 'topWidgets' ) ) {
	function topWidgets(){
		if ( is_active_sidebar( 'toppage-w1' ) ) {
		    return '<div class="row top-widgets">'.dynamic_sidebar( 'toppage-w1' ).'</div>';
		}
	}
}


// widgets dinamicos: video

/** function videoHeader() {


    if ( ! empty( get_theme_mod('ekiline_video') ) ) {
         
        echo	'<!--[if lt IE 9]><script>document.createElement("video");</script><![endif]-->'.
        		'<video autoplay loop poster="'. get_header_image() .'" id="bgvid" style="background-image: url('. get_header_image() .');">
            	<source src="'. get_theme_mod('ekiline_video')  .'" type="video/mp4">
        		</video>';
                    
	}       

}
**/

// Formatear la fecha
function miniDate() {	    
	/** https://codex.wordpress.org/Formatting_Date_and_Time
	//  http://wordpress.stackexchange.com/questions/90321/how-to-get-date-for-each-post **/
 	echo '<div class="mini-fecha"><span class="dia">'.get_the_date('j').'</span><span class="mes">'.get_the_date('M').'</span></div>';
}


/* Eliminar párrafos vacíos en shortcodes.
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


/**
 * OPTIMIZACIÓN: 
 *	Include para google analytics
 * @ https://developers.google.com/analytics/devguides/collection/gajs/
 * https://digwp.com/2012/06/add-google-analytics-wordpress/
**/

function google_analytics_tracking_code(){
		
	$gacode = get_theme_mod('ekiline_analytics','');

	if ( $gacode != '' ) {
		
	echo "<script>
		window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
		ga('create', '" . $gacode . "', 'auto');
		ga('send', 'pageview');
		 </script>
		 <script async defer src='https://www.google-analytics.com/analytics.js'></script>
		 ";		

	}
}
// Usar 'wp_head' 'wp_footer' para situar el script 
add_action('wp_footer', 'google_analytics_tracking_code', 100);	
	

// si se elige que los sidebars se oculten o muestren añade un boton al menu nav.

function add_sidebar_action( $items, $args ) {

	$leftOn = get_theme_mod('ekiline_sidebarLeft','on');
	$rightOn = get_theme_mod('ekiline_sidebarRight','on');

	
    if ($leftOn == 'off') {
        $items .= '<li><a href="#" id="show-sidebar-left">'.esc_html__( 'Sidebar Left', 'ekiline' ).'</a></li>';
    }

    if ($rightOn == 'off') {
        $items .= '<li><a href="#" id="show-sidebar-right">'.esc_html__( 'Sidebar Right', 'ekiline' ).'</a></li>';
    }
	
    return $items;
	
}
add_filter( 'wp_nav_menu_items', 'add_sidebar_action', 10, 2 );


function sidebarButtons(){

	$leftOn = get_theme_mod('ekiline_sidebarLeft','on');
	$rightOn = get_theme_mod('ekiline_sidebarRight','on');

	
    if ($leftOn == 'off') {
        $items .= '<a href="#" id="show-sidebar-left" class="btn btn-default btn-sbleft">'.esc_html__( 'Sidebar Left', 'ekiline' ).'</a>';
    }

    if ($rightOn == 'off') {
        $items .= '<a href="#" id="show-sidebar-right" class="btn btn-default btn-sbright">'.esc_html__( 'Sidebar Right', 'ekiline' ).'</a>';
    }
	
    echo $items; 
}



/* Función especial, condicionar el uso de clases CSS de acuerdo a formatos o contenidos específicos
 * Se inyecta una CSS en el body
 * https://codex.wordpress.org/Plugin_API/Filter_Reference/body_class
 * https://developer.wordpress.org/reference/functions/body_class/
 */

add_filter( 'body_class', function( $classes ) {
	
	$leftOn = get_theme_mod('ekiline_sidebarLeft','on');
	$rightOn = get_theme_mod('ekiline_sidebarRight','on');
	
    if ( $leftOn == 'off' && $rightOn == 'on' ) {
	    return array_merge( $classes, array( 'toggle-sidebars left-on' ) );
	} elseif ( $rightOn == 'off' && $leftOn == 'on' ) {
	    return array_merge( $classes, array( 'toggle-sidebars right-on' ) );
	} elseif ( $rightOn == 'off' && $leftOn == 'off' ) {
	    return array_merge( $classes, array( 'toggle-sidebars right-on left-on' ) );
	} else {
	    return array_merge( $classes, array( 'show-sidebars' ) );
	} 	
	
} );

/* Función para eliminar los comentarios que aparecen en los adjuntos (attachments)
 */

function filter_media_comment_status( $open, $post_id ) {
	$post = get_post( $post_id );
	if( $post->post_type == 'attachment' ) {
		return false;
	}
	return $open;
}
add_filter( 'comments_open', 'filter_media_comment_status', 10 , 2 );

/* Añadir Feeds RSS con un shortcode
 * [rss feed="url" num="5"]
 */
 
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

/** Poner en modo de mantenimineto **/
// function maintenace_mode() {
      // if ( !current_user_can( 'edit_themes' ) || !is_user_logged_in() ) {wp_die('Maintenance.');}
// }
// add_action('get_header', 'maintenace_mode');

/*	
 * Todos los componentes que no formen parte del template, es decir, 
 * fueran metodos o funciones para complementar plugins se recomienda manejarlas
 * como addons.
 * 
 */
