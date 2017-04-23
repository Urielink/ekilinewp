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

// SEO en caso de necesitar etiquetas en las paginas:
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


// Optimizacion metas

function getDescription(){
    // el dato que se mostrara
    if ( is_single() || is_page() ) {
        
    global $wp_query;
    $postid = $wp_query->post->ID;
    $stdDesc = get_post_meta($postid, 'metaDescripcion', true);
    wp_reset_query();
            
       if ( ! empty( $stdDesc ) ){
           // Si utilizan nuestro custom field
           echo $stdDesc;
       } else {
           echo single_post_title(); 
       }
     
    } elseif ( is_archive() ) {
        // las metas https://codex.wordpress.org/Meta_Tags_in_WordPress
     echo single_cat_title();
    } else {
     echo bloginfo('name'). ' - ' .bloginfo('description');
    }
    
}


/** si necesitaramos agregar campos en la edicion usamos metabox: 
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



/** Importar un listado de entradas de alguna categoria, se genera un loop. 
 * https://css-tricks.com/snippets/wordpress/run-loop-on-posts-of-specific-category/ 
 * http://code.tutsplus.com/tutorials/create-a-shortcode-to-list-posts-with-multiple-parameters--wp-32199
 * Especial atencion en el uso de ob_start();
 * http://wordpress.stackexchange.com/questions/41012/proper-use-of-output-buffer
**/

function ekiline_insertar($atts, $content = null) {
	
	extract(shortcode_atts(array('titulo'=>'','categoria'=>'','limite'=>'', 'class'=>'default-list', 'orden'=>'DES'), $atts));

	// mi variable de titulo
	if ($titulo){$titulo = '<h4 class="text-center">'.$titulo.'</h4>';}
		
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
							
					/* cambiar el modo de como se muestra el boton leer mas	
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
					
				// Limpiar las comas de las categorias para ejecutar carrusel en caso de ser mas de una.	
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
						
	
			wp_reset_postdata(); // resetea la peticion
		
		
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


// Elementos del formulario de busqueda

function my_search_form( $form ) {
    $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
    <label class="screen-reader-text" for="s">' . esc_html__( 'Search Results for: %s', 'ekiline' ) . '</label>
    <div class="input-group">
    <input class="form-control" type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . esc_html__( 'Search Results for: %s', 'ekiline' ) . '"/>
    <span class="input-group-btn"><input class="btn btn-default" type="submit" id="searchsubmit" value="'. esc_attr__( 'Search', 'ekiline' ) .'" /></span>
    </div>
    </form>';

    return $form;
}

add_filter( 'get_search_form', 'my_search_form' );



/* Para que la informacion interna tenga una mejor distribucion,
 * no siempre el fullwidth es necesario  */

function mainContainer() {
    
    if ( ! is_home() && ! is_front_page() ) {
             echo ' main-custom'; 
    } 
}


/**
 * Una vez personalizados los colores creamos una funcion para agregaros al header 
 * (https://codex.wordpress.org/Plugin_API/Action_Reference/wp_head).
 * 
 **/

function cssColors() {
		
// variables para los colores al instalar el tema.		
	$texto = get_option('text_color');
	$enlaces = get_option('links_color');
	$modulos = get_option('module_color');
	$menu = get_option('menu_color');
	$footer = get_option('footer_color');
	
	// si las opciones no estan customizadas utiliza los valores por default.
	if ( $texto == '') : $texto = '#333333'; else : $texto ; endif;
	if ( $enlaces == '') : $enlaces = '#337ab7'; else : $enlaces ; endif;
	if ( $modulos == '') : $modulos = '#eeeeee'; else : $modulos ; endif;
	if ( $menu == '') : $menu = '#f8f8f8'; else : $menu ; endif;
	if ( $footer == '') : $footer = $menu; else : $footer ; endif;
	if( true === get_theme_mod('ekiline_inversemenu') ){
	     $invFooter = '#ffffff;';
    } else {
         $invFooter = $texto ;
    }
	
	
	$miestilo = '<style id="ekiline-inline" type="text/css" media="all"> 
		/**body{font-family: "Open Sans", Arial, Helvetica, sans-serif;	}
		h1,h2,h3,h4,h5,h6,.h1,.h2,.h3,.h4,.h5,.h6{font-family: "Raleway", Arial, Helvetica, sans-serif;}**/
		body,.mini-fecha .dia{ color:'.$texto.'; }
		a:hover,a:focus,a:active{ color:'.$modulos.'; }
        .mini-fecha .dia{ background-color:'.$modulos.'; }
       	.mini-fecha .mes, .page-maintenance{ background-color:'.$texto.'; }
        .navbar-default { background-color:'.$menu.';border-color:rgba(255,255,255,.4); }
		.navbar-inverse { background-color:'.$menu.';border-color:rgba(0,0,0,.3); }
        .navbar-inverse .navbar-brand, .navbar-inverse .navbar-nav > li > a, a{ color:'.$enlaces.'; }
        .navbar-default .navbar-brand, .navbar-default .navbar-nav > li > a, a{ color:'.$texto.'; }
        .site-footer { background-color: '.$footer.';color:'.$invFooter.';}         
/* en caso de efectos de volumen */
        .navbar-default, .navbar-inverse {
            background-image: -webkit-linear-gradient(top, '.$menu.' 0%, '.$footer.' 100%);
            background-image: -o-linear-gradient(top, '.$menu.' 0%, '.$footer.' 100%);
            background-image: -webkit-gradient(linear, left top, left bottom, from('.$menu.'), to('.$footer.'));
            background-image: linear-gradient(to bottom, '.$menu.' 0%, '.$footer.' 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="'.$menu.'", endColorstr="'.$footer.'", GradientType=0);
            filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
            background-repeat: repeat-x;}				
        .navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .active > a,
        .navbar-inverse .navbar-nav > .open > a, .navbar-inverse .navbar-nav > .active > a {
            background-image: -webkit-linear-gradient(top, '.$footer.' 0%, '.$menu.' 100%);
            background-image: -o-linear-gradient(top, '.$footer.' 0%, '.$menu.' 100%);
            background-image: -webkit-gradient(linear, left top, left bottom, from('.$footer.'), to('.$menu.'));
            background-image: linear-gradient(to bottom, '.$footer.' 0%, '.$menu.' 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="'.$footer.'", endColorstr="'.$menu.'", GradientType=0);
            background-repeat: repeat-x;
            -webkit-box-shadow: inset 0 3px 9px #0000001a;
            box-shadow: inset 0 3px 9px #0000001a;
        }
                        
            
		</style>';

	echo $miestilo;

}
add_action('wp_head','cssColors');

/**
 *  Si el usuario desea agregar un logotipo en el navbar-brand:
 **/
 
function logoTheme() {
	//variables de logotipo
	$logoHor = get_theme_mod( 'ekiline_logo_max' );
	$logoIcono = get_site_icon_url();
	
    if ( $logoHor && !$logoIcono ) {
        echo '<img class="img-responsive" src="' . $logoHor . '" alt="' . get_bloginfo( 'name' ) . '"/>';
    } elseif ( !$logoHor && $logoIcono ) {
        echo '<img class="brand-icon" src="' . $logoIcono . '" alt="' . get_bloginfo( 'name' ) . '"/>' . get_bloginfo( 'name' );
    } elseif ( $logoHor && $logoIcono ) {
        echo '<img class="img-responsive hidden-xs" src="' . $logoHor . '" alt="' . get_bloginfo( 'name' ) . '"/>
        <span class="visible-xs"><img class="brand-icon" src="' . $logoIcono . '" alt="' . get_bloginfo( 'name' ) . '"/>' . get_bloginfo( 'name' ) . '</span>';
    } else {
        echo get_bloginfo( 'name' );
    } 

}

/**
function destacadoUrl() {
    if ( is_single() ){    
        if ( has_post_thumbnail() ) {
            $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
            echo $url;        
        }    
    }
}**/

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

/*Arreglo para que el ancho del sitio web se genere solo en una pagina, en este caso el home*/
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
    return '<p><a class="read-more" href="' . get_permalink( get_the_ID() ) . '">' . __( 'Leer mas', 'ekiline' ) . '</a></p>';
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

 function videoHeader() {


    if ( ! empty( get_theme_mod('ekiline_video') ) ) {
         
        echo	'<!--[if lt IE 9]><script>document.createElement("video");</script><![endif]-->'.
        		'<div class="embed-responsive embed-responsive-4by3">
        		  <video autoplay loop poster="'. get_header_image() .'" id="bgvid" style="background-image: url('. get_header_image() .');">
            	   <source src="'. get_theme_mod('ekiline_video')  .'" type="video/mp4">
        		  </video></div>';
                    
	}       

}


// Formatear la fecha
function miniDate() {	    
	/** https://codex.wordpress.org/Formatting_Date_and_Time
	//  http://wordpress.stackexchange.com/questions/90321/how-to-get-date-for-each-post **/
 	echo '<div class="mini-fecha"><span class="dia">'.get_the_date('j').'</span><span class="mes">'.get_the_date('M').'</span></div>';
}

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


/**
 * OPTIMIZACIoN: 
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
	

/* Funcion para eliminar los comentarios que aparecen en los adjuntos (attachments)
 */

function filter_media_comment_status( $open, $post_id ) {
	$post = get_post( $post_id );
	if( $post->post_type == 'attachment' ) {
		return false;
	}
	return $open;
}
add_filter( 'comments_open', 'filter_media_comment_status', 10 , 2 );

/* agregar Feeds RSS con un shortcode
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


/*	
 * Todos los componentes que no formen parte del template, es decir, 
 * fueran metodos o funciones para complementar plugins se recomienda manejarlas
 * como addons.
 * 
 */
