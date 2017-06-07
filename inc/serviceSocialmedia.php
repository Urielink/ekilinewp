<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *     // Jugar con urls https://wordpress.stackexchange.com/questions/29512/permalink-for-category-pages-and-posts
 *
 * @package ekiline
 */


function registerSocial() {
    
//Globales
    global $wp;
    
//Indice en Facebook, Twitter GooglePlus y Linkedin (customizer.php)
//Get social media accounts (customizer.php)
    $fbSocial = get_theme_mod('ekiline_fbProf','');
    $twSocial = get_theme_mod('ekiline_twProf','');
    $gpSocial = get_theme_mod('ekiline_gpProf','');
    $inSocial = get_theme_mod('ekiline_inProf','');
    $fbAppid = get_theme_mod('ekiline_fbSharid','');
    $currentUrl = '';
    $metaSocial = '';
    
// Arreglos para extraer la informacion en cada caso
// Get the info for each kind of tag
    $metaTitle = '';
    $metaDescription = '';
    $metaImages = get_site_icon_url();
    $metaType = 'website';
        if (is_page() || is_single()){
            $currentUrl = get_permalink();
        } elseif ( is_category() ){
            $currentUrl = get_queried_object(); 
            $currentUrl = get_term_link( $currentUrl, $currentUrl->taxonomy ); 
        } elseif ( is_archive() ) {
            $currentUrl = home_url( add_query_arg(array(),$wp->request) );
        }
    $blogInfo = '';

    if ( is_front_page() || is_home() ){
        
        $metaTitle = get_bloginfo( 'name' );
        $metaDescription = get_bloginfo('description');
        $blogInfo = get_bloginfo( 'name' );
        
        if ( has_post_thumbnail() ) {
            $metaImages = wp_get_attachment_url( get_post_thumbnail_id() );           
        }     
                
        
    }
    elseif ( is_single() || is_page() ){
            
        // personalizar la metadescripcion 
        // custom meta
        global $wp_query;
        $stdDesc = get_post_meta( $wp_query->post->ID, 'metaDescripcion', true);    
        wp_reset_query();
        
        if ( ! empty( $stdDesc ) ) {
            $metaDescription = $stdDesc; } 
        else {
            // metodo 1 con el extracto
            //$metaDescription = strip_tags( get_the_excerpt() );
            // metodo 2 con el contenido escapado
            // en promedio 24 palabras es un twitt.
            $metaDescription = wp_trim_words( strip_shortcodes( get_the_content() ), 24, '...' );
            // metodo 3 con el contenido escapado y limitado a número de caracteres 
            // $metaDescription = wp_trim_words( get_the_content() );
            // $metaDescription = mb_strimwidth( $metaDescription, 0, 180, '...');
        }
        
        // La imagen
        // The image
        if ( has_post_thumbnail() ) {
            // si tiene imagen destacada     
            // if has post_thumbnail       
            $metaImages = wp_get_attachment_url( get_post_thumbnail_id() );           
        }     
        elseif ( is_attachment() ) {
            // o si es un attachment            
            $metaImages = wp_get_attachment_url();                            
        } 
        else {
            // si no, entonces busca en el contenido del post incluido si es una galería            
            // if no image get the first from post
            global $post, $posts;
            
            $image_url = '';
            
            ob_start();
                // verificar si existe una galeria y tomar la primera imagen que encuentre
                // verify if has gallery
                if ( get_post_gallery() ) {
                    preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', get_post_gallery(), $matches);    
                } else {
                    preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
                }
             
            $image_url = $matches [1] [0]; // Necesita declararse el indice
            
            ob_end_clean();                            
                                            
            //En caso de no existir una u otra
            if( ! empty($image_url) ){
                $metaImages = $image_url;
            }            
        
        }
        
        if ( is_attachment() ) {
            $metaType = 'image';
        } else {
            $metaType = 'article';
        }
                   
        $metaTitle = get_the_title();        
        $blogInfo = get_bloginfo( 'name' );    
    }
    elseif ( is_archive() ){
                
        $cat_id = get_query_var('cat');
        $cat_data = get_option("category_$cat_id");
        
        if ( $cat_data['img'] ) {
            $metaImages = $cat_data['img'];
        }        
        
        $metaTitle = single_cat_title("", false);
        $metaDescription = strip_tags( category_description() );
        $blogInfo = get_bloginfo( 'name' );
    }
       
    if ( $gpSocial != '' ) {
        $metaSocial .= '
            <meta itemprop="name" content="'.$metaTitle.'">
            <meta itemprop="description" content="'.$metaDescription.'">
            <meta itemprop="image" content="'.$metaImages.'">
            ';
    }
    if ($twSocial != '') {
        $metaSocial .= '
            <meta name="twitter:card" content="summary">
            <meta name="twitter:site" content="'.$twSocial.'">
            <meta name="twitter:title" content="'.$metaTitle.'">
            <meta name="twitter:description" content="'.$metaDescription.'">
            <meta name="twitter:creator" content="'.$twSocial.'">
            <meta name="twitter:image" content="'.$metaImages.'">
            ';
    }
    if ($fbSocial != '') {
        $metaSocial .= '
            <meta property="og:title" content="'.$metaTitle.'"/>
            <meta property="og:type" content="'.$metaType.'"/>
            <meta property="og:url" content="'.$currentUrl.'"/>
            <meta property="og:image" content="'.$metaImages.'"/>
            <meta property="og:description" content="'.$metaDescription.'"/>
            <meta property="og:site_name" content="'.$blogInfo.'"/>
            ';
        if ( $fbAppid != '' ){
            $metaSocial .= '<meta property="og:app_id" content="'.$fbAppid.'"/>';
        }
    }
    
    echo $metaSocial;   
}

add_action( 'wp_head', 'registerSocial', 1);


//Crear un shortcode para crear un menu de redes sociales [socialmenu]
// Add a shortcode for link this

function ekiline_socialmenu($atts, $content = null) {
    
    extract(shortcode_atts(array('type' => 'menu'), $atts));
    
    $fbSocial = get_theme_mod('ekiline_fbProf','');
    $twSocial = get_theme_mod('ekiline_twProf','');
    $gpSocial = get_theme_mod('ekiline_gpProf','');
    $inSocial = get_theme_mod('ekiline_inProf','');
    $menuItems = '';
        
    if ($fbSocial) : $menuItems .= '<li><a href="'.$fbSocial.'" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a></li>'; endif;
    if ($twSocial) : $menuItems .= '<li><a href="https://twitter.com/'.$twSocial.'" target="_blank" title="Twitter"><i class="fa fa-twitter"></i></a></li>'; endif;
    if ($gpSocial) : $menuItems .= '<li><a href="'.$gpSocial.'" target="_blank" title="Google Plus"><i class="fa fa-google"></i></a></li>'; endif;
    if ($inSocial) : $menuItems .= '<li><a href="'.$inSocial.'" target="_blank" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>';endif;
                    
    return '<ul class="list-inline no-margin">'. $menuItems .'</ul>';
}
add_shortcode('socialmenu', 'ekiline_socialmenu');    
    
    
