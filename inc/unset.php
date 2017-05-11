<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package ekiline
 */


/** si necesitaramos agregar campos en la edicion usamos metabox: 
 *  https://developer.wordpress.org/reference/functions/add_meta_box/
 *  https://www.sitepoint.com/adding-custom-meta-boxes-to-wordpress/
 **/

// En caso de necesitar limpiar o reemplazar caracteres especiales.

// function limpiarCaracteres($string) {
    // $string = str_replace(' ', '-', $string);
    // $intercambio = array('á' => 'a', 'Á' => 'A', 'à' => 'a', 'À' => 'A', 'ă' => 'a', 'Ă' => 'A', 'â' => 'a', 'Â' => 'A', 'å' => 'a', 'Å' => 'A', 'ã' => 'a', 'Ã' => 'A', 'ą' => 'a', 'Ą' => 'A', 'ā' => 'a', 'Ā' => 'A', 'ä' => 'ae', 'Ä' => 'AE', 'æ' => 'ae', 'Æ' => 'AE', 'ḃ' => 'b', 'Ḃ' => 'B', 'ć' => 'c', 'Ć' => 'C', 'ĉ' => 'c', 'Ĉ' => 'C', 'č' => 'c', 'Č' => 'C', 'ċ' => 'c', 'Ċ' => 'C', 'ç' => 'c', 'Ç' => 'C', 'ď' => 'd', 'Ď' => 'D', 'ḋ' => 'd', 'Ḋ' => 'D', 'đ' => 'd', 'Đ' => 'D', 'ð' => 'dh', 'Ð' => 'Dh', 'é' => 'e', 'É' => 'E', 'è' => 'e', 'È' => 'E', 'ĕ' => 'e', 'Ĕ' => 'E', 'ê' => 'e', 'Ê' => 'E', 'ě' => 'e', 'Ě' => 'E', 'ë' => 'e', 'Ë' => 'E', 'ė' => 'e', 'Ė' => 'E', 'ę' => 'e', 'Ę' => 'E', 'ē' => 'e', 'Ē' => 'E', 'ḟ' => 'f', 'Ḟ' => 'F', 'ƒ' => 'f', 'Ƒ' => 'F', 'ğ' => 'g', 'Ğ' => 'G', 'ĝ' => 'g', 'Ĝ' => 'G', 'ġ' => 'g', 'Ġ' => 'G', 'ģ' => 'g', 'Ģ' => 'G', 'ĥ' => 'h', 'Ĥ' => 'H', 'ħ' => 'h', 'Ħ' => 'H', 'í' => 'i', 'Í' => 'I', 'ì' => 'i', 'Ì' => 'I', 'î' => 'i', 'Î' => 'I', 'ï' => 'i', 'Ï' => 'I', 'ĩ' => 'i', 'Ĩ' => 'I', 'į' => 'i', 'Į' => 'I', 'ī' => 'i', 'Ī' => 'I', 'ĵ' => 'j', 'Ĵ' => 'J', 'ķ' => 'k', 'Ķ' => 'K', 'ĺ' => 'l', 'Ĺ' => 'L', 'ľ' => 'l', 'Ľ' => 'L', 'ļ' => 'l', 'Ļ' => 'L', 'ł' => 'l', 'Ł' => 'L', 'ṁ' => 'm', 'Ṁ' => 'M', 'ń' => 'n', 'Ń' => 'N', 'ň' => 'n', 'Ň' => 'N', 'ñ' => 'n', 'Ñ' => 'N', 'ņ' => 'n', 'Ņ' => 'N', 'ó' => 'o', 'Ó' => 'O', 'ò' => 'o', 'Ò' => 'O', 'ô' => 'o', 'Ô' => 'O', 'ő' => 'o', 'Ő' => 'O', 'õ' => 'o', 'Õ' => 'O', 'ø' => 'oe', 'Ø' => 'OE', 'ō' => 'o', 'Ō' => 'O', 'ơ' => 'o', 'Ơ' => 'O', 'ö' => 'oe', 'Ö' => 'OE', 'ṗ' => 'p', 'Ṗ' => 'P', 'ŕ' => 'r', 'Ŕ' => 'R', 'ř' => 'r', 'Ř' => 'R', 'ŗ' => 'r', 'Ŗ' => 'R', 'ś' => 's', 'Ś' => 'S', 'ŝ' => 's', 'Ŝ' => 'S', 'š' => 's', 'Š' => 'S', 'ṡ' => 's', 'Ṡ' => 'S', 'ş' => 's', 'Ş' => 'S', 'ș' => 's', 'Ș' => 'S', 'ß' => 'SS', 'ť' => 't', 'Ť' => 'T', 'ṫ' => 't', 'Ṫ' => 'T', 'ţ' => 't', 'Ţ' => 'T', 'ț' => 't', 'Ț' => 'T', 'ŧ' => 't', 'Ŧ' => 'T', 'ú' => 'u', 'Ú' => 'U', 'ù' => 'u', 'Ù' => 'U', 'ŭ' => 'u', 'Ŭ' => 'U', 'û' => 'u', 'Û' => 'U', 'ů' => 'u', 'Ů' => 'U', 'ű' => 'u', 'Ű' => 'U', 'ũ' => 'u', 'Ũ' => 'U', 'ų' => 'u', 'Ų' => 'U', 'ū' => 'u', 'Ū' => 'U', 'ư' => 'u', 'Ư' => 'U', 'ü' => 'ue', 'Ü' => 'UE', 'ẃ' => 'w', 'Ẃ' => 'W', 'ẁ' => 'w', 'Ẁ' => 'W', 'ŵ' => 'w', 'Ŵ' => 'W', 'ẅ' => 'w', 'Ẅ' => 'W', 'ý' => 'y', 'Ý' => 'Y', 'ỳ' => 'y', 'Ỳ' => 'Y', 'ŷ' => 'y', 'Ŷ' => 'Y', 'ÿ' => 'y', 'Ÿ' => 'Y', 'ź' => 'z', 'Ź' => 'Z', 'ž' => 'z', 'Ž' => 'Z', 'ż' => 'z', 'Ż' => 'Z', 'þ' => 'th', 'Þ' => 'Th', 'µ' => 'u', 'а' => 'a', 'А' => 'a', 'б' => 'b', 'Б' => 'b', 'в' => 'v', 'В' => 'v', 'г' => 'g', 'Г' => 'g', 'д' => 'd', 'Д' => 'd', 'е' => 'e', 'Е' => 'E', 'ё' => 'e', 'Ё' => 'E', 'ж' => 'zh', 'Ж' => 'zh', 'з' => 'z', 'З' => 'z', 'и' => 'i', 'И' => 'i', 'й' => 'j', 'Й' => 'j', 'к' => 'k', 'К' => 'k', 'л' => 'l', 'Л' => 'l', 'м' => 'm', 'М' => 'm', 'н' => 'n', 'Н' => 'n', 'о' => 'o', 'О' => 'o', 'п' => 'p', 'П' => 'p', 'р' => 'r', 'Р' => 'r', 'с' => 's', 'С' => 's', 'т' => 't', 'Т' => 't', 'у' => 'u', 'У' => 'u', 'ф' => 'f', 'Ф' => 'f', 'х' => 'h', 'Х' => 'h', 'ц' => 'c', 'Ц' => 'c', 'ч' => 'ch', 'Ч' => 'ch', 'ш' => 'sh', 'Ш' => 'sh', 'щ' => 'sch', 'Щ' => 'sch', 'ъ' => '', 'Ъ' => '', 'ы' => 'y', 'Ы' => 'y', 'ь' => '', 'Ь' => '', 'э' => 'e', 'Э' => 'e', 'ю' => 'ju', 'Ю' => 'ju', 'я' => 'ja', 'Я' => 'ja');
    // $string = str_replace(array_keys($intercambio), array_values($intercambio), $string);
    // return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
// }

function limpiarCaracteres($name) {
    // este ejemplo reemplaza el anterior: http://stackoverflow.com/questions/11979104/replace-special-characters-the-exact-same-way-as-wordpress
    setlocale(LC_ALL, 'en_US.UTF8');
    $name = iconv('UTF-8', 'ASCII//TRANSLIT', $name);
    $alias = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $name);
    $alias = strtolower(trim($alias, '-'));
    $alias = preg_replace("/[\/_|+ -]+/", "-", $alias);


    while (substr($alias, -1, 1) == "-") {
        $alias = substr($alias, 0, -1);
    }
    while (substr($alias, 0, 1) == "-") {
        $alias = substr($alias, 1, 100);
    }

    return $alias;
}


/**
 * Customize <main> css in pages and page-templates.
 */

function mainContainer() {
    
    if ( ! is_home() && ! is_front_page() ) {
             echo ' main-custom'; 
    } 
}

/**
 * Add css when style is defined in customizer.php #36.
 *
 * @param array $classes Classes for the body element.
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/wp_head
 */
 
function cssColors() {
        
// Color values at theme install.       
    $texto = get_option('text_color');
    $enlaces = get_option('links_color');
    $modulos = get_option('module_color');
    $menu = get_option('menu_color');
    $footer = get_option('footer_color');
    
    // If values are not set by user, set this.
    if ( $texto == '') : $texto = '#333333'; else : $texto ; endif;
    if ( $enlaces == '') : $enlaces = '#337ab7'; else : $enlaces ; endif;
    if ( $modulos == '') : $modulos = '#eeeeee'; else : $modulos ; endif;
    if ( $menu == '') : $menu = '#f8f8f8'; else : $menu ; endif;
    if ( $footer == '') : $footer = $menu; else : $footer ; endif;
    if ( true === get_theme_mod('ekiline_inversemenu') ) : $invFooter = '#ffffff;' ; else : $invFooter = $texto ; endif;
    
    // Inline CSS defined for theme.
    $miestilo = '<style id="ekiline-inline" type="text/css" media="all"> 
        /**body{font-family: "Open Sans", Arial, Helvetica, sans-serif; }
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
            box-shadow: inset 0 3px 9px #0000001a;}
        </style>';

    echo $miestilo;

}
add_action('wp_head','cssColors');



/** para llamar las imagenes destacadas
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

// widgets dinamicos: Ejemplo en caso de tener varios en un espacio
/**
function footerWidgets() {
        
    if ( is_active_sidebar( 'footer-w1' ) || is_active_sidebar( 'footer-w2' ) || is_active_sidebar( 'footer-w3' ) ) {
        return dynamic_sidebar( 'footer-w1' ).dynamic_sidebar( 'footer-w2' ).dynamic_sidebar( 'footer-w3' );
    }

}
**/


// Formatear la fecha
function miniDate() {       
    /** https://codex.wordpress.org/Formatting_Date_and_Time
    //  http://wordpress.stackexchange.com/questions/90321/how-to-get-date-for-each-post **/
    echo '<div class="mini-fecha"><span class="dia">'.get_the_date('j').'</span><span class="mes">'.get_the_date('M').'</span></div>';
}

/* Funcion especial, condicionar el uso de clases CSS de acuerdo a formatos o contenidos especificos
 * Se inyecta una CSS en el body
 * https://codex.wordpress.org/Plugin_API/Filter_Reference/body_class
 * https://developer.wordpress.org/reference/functions/body_class/
 */
 
/** En caso de necesitar el modo wireframe.**/

if( true === get_theme_mod('ekiline_wireframe') ){
    
    add_filter( 'body_class', function( $classes ) {
        return array_merge( $classes, array( 'wf-ekiline' ) );
    } );
}