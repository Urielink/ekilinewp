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

// function ekiline_cleanspchar($string) {
    // $string = str_replace(' ', '-', $string);
    // $intercambio = array('á' => 'a', 'Á' => 'A', 'à' => 'a', 'À' => 'A', 'ă' => 'a', 'Ă' => 'A', 'â' => 'a', 'Â' => 'A', 'å' => 'a', 'Å' => 'A', 'ã' => 'a', 'Ã' => 'A', 'ą' => 'a', 'Ą' => 'A', 'ā' => 'a', 'Ā' => 'A', 'ä' => 'ae', 'Ä' => 'AE', 'æ' => 'ae', 'Æ' => 'AE', 'ḃ' => 'b', 'Ḃ' => 'B', 'ć' => 'c', 'Ć' => 'C', 'ĉ' => 'c', 'Ĉ' => 'C', 'č' => 'c', 'Č' => 'C', 'ċ' => 'c', 'Ċ' => 'C', 'ç' => 'c', 'Ç' => 'C', 'ď' => 'd', 'Ď' => 'D', 'ḋ' => 'd', 'Ḋ' => 'D', 'đ' => 'd', 'Đ' => 'D', 'ð' => 'dh', 'Ð' => 'Dh', 'é' => 'e', 'É' => 'E', 'è' => 'e', 'È' => 'E', 'ĕ' => 'e', 'Ĕ' => 'E', 'ê' => 'e', 'Ê' => 'E', 'ě' => 'e', 'Ě' => 'E', 'ë' => 'e', 'Ë' => 'E', 'ė' => 'e', 'Ė' => 'E', 'ę' => 'e', 'Ę' => 'E', 'ē' => 'e', 'Ē' => 'E', 'ḟ' => 'f', 'Ḟ' => 'F', 'ƒ' => 'f', 'Ƒ' => 'F', 'ğ' => 'g', 'Ğ' => 'G', 'ĝ' => 'g', 'Ĝ' => 'G', 'ġ' => 'g', 'Ġ' => 'G', 'ģ' => 'g', 'Ģ' => 'G', 'ĥ' => 'h', 'Ĥ' => 'H', 'ħ' => 'h', 'Ħ' => 'H', 'í' => 'i', 'Í' => 'I', 'ì' => 'i', 'Ì' => 'I', 'î' => 'i', 'Î' => 'I', 'ï' => 'i', 'Ï' => 'I', 'ĩ' => 'i', 'Ĩ' => 'I', 'į' => 'i', 'Į' => 'I', 'ī' => 'i', 'Ī' => 'I', 'ĵ' => 'j', 'Ĵ' => 'J', 'ķ' => 'k', 'Ķ' => 'K', 'ĺ' => 'l', 'Ĺ' => 'L', 'ľ' => 'l', 'Ľ' => 'L', 'ļ' => 'l', 'Ļ' => 'L', 'ł' => 'l', 'Ł' => 'L', 'ṁ' => 'm', 'Ṁ' => 'M', 'ń' => 'n', 'Ń' => 'N', 'ň' => 'n', 'Ň' => 'N', 'ñ' => 'n', 'Ñ' => 'N', 'ņ' => 'n', 'Ņ' => 'N', 'ó' => 'o', 'Ó' => 'O', 'ò' => 'o', 'Ò' => 'O', 'ô' => 'o', 'Ô' => 'O', 'ő' => 'o', 'Ő' => 'O', 'õ' => 'o', 'Õ' => 'O', 'ø' => 'oe', 'Ø' => 'OE', 'ō' => 'o', 'Ō' => 'O', 'ơ' => 'o', 'Ơ' => 'O', 'ö' => 'oe', 'Ö' => 'OE', 'ṗ' => 'p', 'Ṗ' => 'P', 'ŕ' => 'r', 'Ŕ' => 'R', 'ř' => 'r', 'Ř' => 'R', 'ŗ' => 'r', 'Ŗ' => 'R', 'ś' => 's', 'Ś' => 'S', 'ŝ' => 's', 'Ŝ' => 'S', 'š' => 's', 'Š' => 'S', 'ṡ' => 's', 'Ṡ' => 'S', 'ş' => 's', 'Ş' => 'S', 'ș' => 's', 'Ș' => 'S', 'ß' => 'SS', 'ť' => 't', 'Ť' => 'T', 'ṫ' => 't', 'Ṫ' => 'T', 'ţ' => 't', 'Ţ' => 'T', 'ț' => 't', 'Ț' => 'T', 'ŧ' => 't', 'Ŧ' => 'T', 'ú' => 'u', 'Ú' => 'U', 'ù' => 'u', 'Ù' => 'U', 'ŭ' => 'u', 'Ŭ' => 'U', 'û' => 'u', 'Û' => 'U', 'ů' => 'u', 'Ů' => 'U', 'ű' => 'u', 'Ű' => 'U', 'ũ' => 'u', 'Ũ' => 'U', 'ų' => 'u', 'Ų' => 'U', 'ū' => 'u', 'Ū' => 'U', 'ư' => 'u', 'Ư' => 'U', 'ü' => 'ue', 'Ü' => 'UE', 'ẃ' => 'w', 'Ẃ' => 'W', 'ẁ' => 'w', 'Ẁ' => 'W', 'ŵ' => 'w', 'Ŵ' => 'W', 'ẅ' => 'w', 'Ẅ' => 'W', 'ý' => 'y', 'Ý' => 'Y', 'ỳ' => 'y', 'Ỳ' => 'Y', 'ŷ' => 'y', 'Ŷ' => 'Y', 'ÿ' => 'y', 'Ÿ' => 'Y', 'ź' => 'z', 'Ź' => 'Z', 'ž' => 'z', 'Ž' => 'Z', 'ż' => 'z', 'Ż' => 'Z', 'þ' => 'th', 'Þ' => 'Th', 'µ' => 'u', 'а' => 'a', 'А' => 'a', 'б' => 'b', 'Б' => 'b', 'в' => 'v', 'В' => 'v', 'г' => 'g', 'Г' => 'g', 'д' => 'd', 'Д' => 'd', 'е' => 'e', 'Е' => 'E', 'ё' => 'e', 'Ё' => 'E', 'ж' => 'zh', 'Ж' => 'zh', 'з' => 'z', 'З' => 'z', 'и' => 'i', 'И' => 'i', 'й' => 'j', 'Й' => 'j', 'к' => 'k', 'К' => 'k', 'л' => 'l', 'Л' => 'l', 'м' => 'm', 'М' => 'm', 'н' => 'n', 'Н' => 'n', 'о' => 'o', 'О' => 'o', 'п' => 'p', 'П' => 'p', 'р' => 'r', 'Р' => 'r', 'с' => 's', 'С' => 's', 'т' => 't', 'Т' => 't', 'у' => 'u', 'У' => 'u', 'ф' => 'f', 'Ф' => 'f', 'х' => 'h', 'Х' => 'h', 'ц' => 'c', 'Ц' => 'c', 'ч' => 'ch', 'Ч' => 'ch', 'ш' => 'sh', 'Ш' => 'sh', 'щ' => 'sch', 'Щ' => 'sch', 'ъ' => '', 'Ъ' => '', 'ы' => 'y', 'Ы' => 'y', 'ь' => '', 'Ь' => '', 'э' => 'e', 'Э' => 'e', 'ю' => 'ju', 'Ю' => 'ju', 'я' => 'ja', 'Я' => 'ja');
    // $string = str_replace(array_keys($intercambio), array_values($intercambio), $string);
    // return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
// }

function ekiline_cleanspchar($name) {
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
 
function ekiline_csscolors() {
        
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
add_action('wp_head','ekiline_csscolors');



/** para llamar las imagenes destacadas **/
function destacadoUrl() {
    if ( is_single() ){    
        if ( has_post_thumbnail() ) {
            $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
            echo $url;        
        }    
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

// widgets dinamicos: Ejemplo en caso de tener varios en un espacio

function footerWidgets() {
        
    if ( is_active_sidebar( 'footer-w1' ) || is_active_sidebar( 'footer-w2' ) || is_active_sidebar( 'footer-w3' ) ) {
        return dynamic_sidebar( 'footer-w1' ).dynamic_sidebar( 'footer-w2' ).dynamic_sidebar( 'footer-w3' );
    }

}



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

/**
 * Enqueue scripts and styles.
 */
  
function ekiline_scripts() {
    
    // // Extra CSS
    wp_enqueue_style( 'bootstrap-337', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.3.7', 'all' );
        // Css con condicion: https://developer.wordpress.org/reference/functions/wp_style_add_data/
    wp_enqueue_style( 'ie10-viewport-bug-workaround', get_template_directory_uri() . '/css/ie10-viewport-bug-workaround.css', array(), '1', 'all' );
        wp_style_add_data( 'ie10-viewport-bug-workaround', 'conditional', 'gte IE 8' );
    wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '4.7.0', 'all' );
    // Llamar google fonts desde url.
    // wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Raleway:400,300,700,300italic,400italic,700italic|Open+Sans:400,400italic,300italic,300,700,700italic', array(), '0.0.0', 'all' );
    // metodo ekiline, no modificar.
    wp_enqueue_style( 'layout', get_template_directory_uri() . '/css/ekiline-layout.css', array(), '1.0', 'all' );  
    // U_ style: CSS (https://codex.wordpress.org/Function_Reference/wp_enqueue_script)
    wp_enqueue_style( 'ekiline-style', get_stylesheet_uri() );  
    
    /* Javascript : Desactivar Jquery para enviarlo al fondo (http://wordpress.stackexchange.com/questions/173601/enqueue-core-jquery-in-the-footer)
     * en caso contrario, solo Agrega esta linea y el script se ubucara en el <head>.
     *  wp_enqueue_script( 'bootstrap-script', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '20151113', true  );       
     * Mas info: 
     *  https://developer.wordpress.org/reference/functions/wp_enqueue_script/
     *  https://www.godaddy.com/garage/webpro/wordpress/3-ways-to-insert-javascript-into-wordpress-pages-or-posts/
     */  
    // wp_deregister_script( 'jquery' );
    // wp_register_script( 'jquery', includes_url( '/js/jquery/jquery.js' ), false, NULL, true );
    // wp_enqueue_script( 'jquery' );   
            
    /* ABR 22 2017 hay otro metodo para hacer que jquery se vaya al fondo sin de-registrarlo y aplica solo si no eres administrador 
     * http://stackoverflow.com/questions/35663927/wordpress-jquery-on-footer */
        
    if( !is_admin() ){
        wp_dequeue_script('jquery');
        wp_dequeue_script('jquery-core');
        wp_dequeue_script('jquery-migrate');
        wp_enqueue_script('jquery', false, array(), false, true);
        wp_enqueue_script('jquery-core', false, array(), false, true);
        wp_enqueue_script('jquery-migrate', false, array(), false, true);          
     }          
            
    // Javascript : Jquery libraries (https://codex.wordpress.org/Function_Reference/wp_enqueue_script)
    // Cuando los scripts dependen de JQuery se debe mencionar en el array
    wp_enqueue_script( 'bootstrap-script', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '3.3.7', true  );
    wp_enqueue_script( 'ekiline-swipe', get_template_directory_uri() . '/js/carousel-swipe.min.js', array('jquery'), '20150716', true  );
    wp_enqueue_script( 'lazy-load', get_template_directory_uri() . '/js/jquery.lazyload.js', array('jquery'), '20170327', true  );
    wp_enqueue_script( 'ekiline-layout', get_template_directory_uri() . '/js/ekiline-layout.js', array('jquery'), '20151226', true  );
    wp_enqueue_script( 'theme-scripts', get_template_directory_uri() . '/js/theme.js', array('jquery'), '20151113', true  );
    
    // scripts con condicionales, caso IE https://developer.wordpress.org/reference/functions/wp_script_add_data/
    wp_enqueue_script( 'ie10-vpbugwkrnd', get_template_directory_uri() . '/js/ie10-viewport-bug-workaround.min.js' );
        wp_script_add_data( 'ie10-vpbugwkrnd', 'conditional', 'gte IE 8' );
    wp_enqueue_script( 'html5shiv', '//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js' );
        wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );
    wp_enqueue_script( 'respond', '//oss.maxcdn.com/respond/1.4.2/respond.min.js' );
        wp_script_add_data( 'respond', 'conditional', 'lt IE 9' );
            
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }       
    
}
add_action( 'wp_enqueue_scripts', 'ekiline_scripts', 0 );


/* Hay prblemas al usar urls relativas */

/** urls relativas 
 * http://www.deluxeblogtips.com/relative-urls/
**/

$filters = array(
    'post_link',       // Normal post link
    'post_type_link',  // Custom post type link
    'page_link',       // Page link
    'attachment_link', // Attachment link
    'get_shortlink',   // Shortlink

    'post_type_archive_link',    // Post type archive link
    'get_pagenum_link',          // Paginated link
    'get_comments_pagenum_link', // Paginated comment link

    'term_link',   // Term link, including category, tag
    'search_link', // Search link

    'day_link',   // Date archive link
    'month_link',
    'year_link'

);

foreach ( $filters as $filter ) {
    add_filter( $filter, 'wp_make_link_relative' );
}

// $CssLink = wp_make_link_relative( get_stylesheet_uri() );
// $ThemeLink = wp_make_link_relative( get_template_directory_uri() );
// http://www.wpbeginner.com/wp-tutorials/25-extremely-useful-tricks-for-the-wordpress-functions-file/
// http://www.hongkiat.com/blog/wordpress-url-rewrite/ XX


/** optimizacion de carga de css y js, utilizando localize. XX
 *  https://codex.wordpress.org/Function_Reference/wp_localize_script
 *  https://pippinsplugins.com/use-wp_localize_script-it-is-awesome/    
 *  requiere de: optimizar.js
**/

function optimizar_carga() {
    
    wp_enqueue_script('optimizar', get_template_directory_uri().'/js/optimizar.js', array('jquery'),'1.0', true );
        
    wp_localize_script('optimizar', 'recurso_script', array(
            //asigno el css por cada archivo interno
                'css1' => get_template_directory_uri() . '/css/bootstrap.min.css',
                'css2' => get_template_directory_uri() . '/css/font-awesome.min.css',
                'css3' => get_template_directory_uri() . '/css/ekiline-layout.css',
                'css4' => '//fonts.googleapis.com/css?family=Raleway:400,300,700,300italic,400italic,700italic|Open+Sans:400,400italic,300italic,300,700,700italic',
                'css5' => get_stylesheet_uri(),
        )
    );
}
add_action('wp_enqueue_scripts', 'optimizar_carga', 10);



/**
 * Website design author for good relationships ;)
 */

function ekiline_theme_author() {
    
    $authname = get_theme_mod('ekiline_author','');
    
    $authname = wp_kses( $authname, array( 
        'a' => array(
            'href' => array(),
            'title' => array(),
            'target' => array()
        ),
        'br' => array(),
        'em' => array(),
        'strong' => array(),
    ) );      
    
    if ($authname){
        printf( esc_html__( 'By %s', 'ekiline' ), $authname );
    }    
}

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


//Hacer un include con un shortcode.

function ekiline_include($atts, $content = null) {
    
    extract( shortcode_atts( array( 'archivo' => '' ), $atts) );

    $path = $_SERVER['DOCUMENT_ROOT'].'/'.$archivo;
    
    ob_start(); // abre         

    echo include( $path );
    
    $insertarInclude = ob_get_clean(); // cierra
 
    return $insertarInclude;        
            
    }
    
add_shortcode('include', 'ekiline_include');



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


// Cover, este debe tener un titulo, como el contenido puede variar este se debe estar en un div a parte.

function ekiline_cover($atts, $content = null) {
    extract(shortcode_atts(array('title' => '','bgcolor'=>'#17B2CE','txtcolor'=>'#FFFFFF','bgimage'=>''), $atts));
    $titleBtn = ekiline_cleanspchar($title);
    if ( $bgimage ) { $bgimage='background-image:url('.$bgimage.')'; }
    return '    
    <div id="mod-cover" class="cover-wrapper" style="background-color:'.$bgcolor.';color:'.$txtcolor.';'.$bgimage.'">
      <div class="cover-wrapper-inner">
        <div class="cover-container">
          <div class="inner cover">
            <h3>'.$title.'</h3>
            '.do_shortcode($content).'
          </div>
        </div>
      </div>
    </div>      
    ';
}
add_shortcode('mod_cover', 'ekiline_cover');



// Validaciones del formulario:
    
    function login_failed() {  
        // $login_page  = home_url( '/acceso' );  
        // wp_redirect( $login_page . '?login=failed' );  
        // exit;  
        if ( shortcode_exists( 'loginform' ) ) {
            global $wp;
            $current_url = home_url(add_query_arg(array(),$wp->request));       
            $login_page  = $current_url;  
            wp_redirect( $login_page . '?login=failed' );  
            exit;  
        }       
        
    }  
    add_action( 'wp_login_failed', 'login_failed' );  
      
    function verify_username_password( $user, $username, $password ) {
        // $login_page  = home_url( '/acceso' );  
        // if( $username == "" || $password == "" ) {  
            // wp_redirect( $login_page . "?login=empty" );  
            // exit;  
        // }  
        if ( shortcode_exists( 'loginform' ) ) {
            global $wp;          
            $current_url = home_url(add_query_arg(array(),$wp->request));       
            $login_page  = $current_url;  
            if( $username == "" || $password == "" ) {  
                wp_redirect( $login_page . "?login=empty" );  
                exit;  
            }  
        }
    }  
    add_filter( 'authenticate', 'verify_username_password', 1, 3);
    

// PRUEBA: si se elige que los sidebars se oculten o muestren Agrega un boton al menu nav.
function add_sidebar_action( $items, $args ) {
    global $leftOn, $rightOn;    
        if ($leftOn == 'off') : $items .= '<li><a href="#" id="show-sidebar-left">'.esc_html__( 'Left sidebar', 'ekiline' ).'</a></li>'; endif;
        if ($rightOn == 'off') : $items .= '<li><a href="#" id="show-sidebar-right">'.esc_html__( 'Right sidebar', 'ekiline' ).'</a></li>'; endif;    
    return $items;    
}
add_filter( 'wp_nav_menu_items', 'add_sidebar_action', 10, 2 );

/**
 * Registers an editor stylesheet for the current theme.
 */
function wpdocs_theme_add_editor_styles() {
    $font_url = str_replace( ',', '%2C', '//fonts.googleapis.com/css?family=Lato:300,400,700' );
    add_editor_style( $font_url );
}
add_action( 'after_setup_theme', 'wpdocs_theme_add_editor_styles' ); 

    // descartar la pagina de ingreso de las busquedas
// http://wordpress.stackexchange.com/questions/142811/exclude-pages-from-wordpress-search-result-page

function exclude_pages_search_when_logged_in($query) {
    if ( $query->is_search && is_user_logged_in() )
        $query->set( 'post__not_in', array( 49 ) ); 
    return $query;
}
add_filter( 'pre_get_posts', 'exclude_pages_search_when_logged_in' );



/***** URLS relativas es un desmadre *****/

    $wp_customize->add_setting(
            'ekiline_relativeurl', array(
                    'default' => '',
                    'sanitize_callback' => 'ekiline_sanitize_checkbox'
            ) 
    );
    
    $wp_customize->add_control(
            'ekiline_relativeurl', array(
                    'label'          => __( 'Relative urls', 'ekiline' ),
                    'description'    => __( 'Recommended for sites developed in the local environment and need to be migrated', 'ekiline' ),
                    'section'        => 'ekiline_services',
                    'settings'       => 'ekiline_relativeurl',
                    'type'           => 'checkbox',
            )
    );     

// if( true === get_theme_mod('ekiline_relativeurl') ){ echo 'relativas' ;}


    /** 
     * Usar urls relativas en imagenes para trabajar en el sitio:
     * https://www.webhostinghero.com/how-to-insert-relative-image-urls-in-wordpress/
     */
    // para imagenes
    function switch_to_relative_url($html, $id, $caption, $title, $align, $url, $size, $alt) {
        $imageurl = wp_get_attachment_image_src($id, $size);
        $relativeurl = wp_make_link_relative($imageurl[0]);   
        $html = str_replace($imageurl[0],$relativeurl,$html);      
        return $html;
    }
    add_filter('image_send_to_editor','switch_to_relative_url',10,8);
    
    
    // para posts (no pages)
    function internal_link_to_relative(  $url, $post, $leavename ) {
    
        if ( $post->post_type == 'post' ) {
            $url = wp_make_link_relative($url);
        }                        
        return $url;
    }
    add_filter( 'post_link', 'internal_link_to_relative', 10, 3 );              
    
    // para acortar la información en el HTML
    function rw_relative_urls() {
        if ( is_feed() || get_query_var( 'sitemap' ) )
            return;
    
        $filters = array(
            'post_link',
            'post_type_link',
            'page_link',
            'attachment_link',
            'get_shortlink',
            'post_type_archive_link',
            'get_pagenum_link',
            'get_comments_pagenum_link',
            'term_link',
            'search_link',
            'day_link',
            'month_link',
            'year_link',
        );
        foreach ( $filters as $filter )
        {
            add_filter( $filter, 'wp_make_link_relative' );
        }
    }
    add_action( 'template_redirect', 'rw_relative_urls' );

 

function menuSocial(){
    
    $fbSocial = get_theme_mod('ekiline_fbProf','');
    $twSocial = get_theme_mod('ekiline_twProf','');
    $gpSocial = get_theme_mod('ekiline_gpProf','');
    $inSocial = get_theme_mod('ekiline_inProf','');
    $menuItems = '';
        
    if ($fbSocial) : $menuItems .= '<li><a href="'.$fbSocial.'" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a></li>'; endif;
    if ($twSocial) : $menuItems .= '<li><a href="'.$twSocial.'" target="_blank" title="Twitter"><i class="fa fa-twitter"></i></a></li>'; endif;
    if ($gpSocial) : $menuItems .= '<li><a href="'.$gpSocial.'" target="_blank" title="Google Plus"><i class="fa fa-google"></i></a></li>'; endif;
    if ($inSocial) : $menuItems .= '<li><a href="'.$inSocial.'" target="_blank" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>';endif;
                
    echo $menuItems;

    // $redes = array( 
                // $fbSocial => array('link' => $fbSocial, 'title' => 'Facebook', 'class' => 'fa fa-facebook') , 
                // $twSocial => array('link' => $twSocial, 'title' => 'Twitter', 'class' => 'fa fa-twitter') , 
                // $gpSocial => array('link' => $gpSocial, 'title' => 'Google Plus', 'class' => 'fa fa-google') , 
                // $inSocial => array('link' => $inSocial, 'title' => 'Linkedin', 'class' => 'fa fa-linkedin') 
                // );
        // foreach ($redes as $red) {
            // if ( $red['link'] ){
                // $menuItems .= '<li><a href="'.$red['link'].'" target="_blank" title="'.$red['title'].'"><i class="'.$red['class'].'"></i></a></li>';
            // }
        // }       
                
}
 