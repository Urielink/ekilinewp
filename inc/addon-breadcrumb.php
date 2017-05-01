<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 * Ejercicicio base: http://wp-snippets.com/breadcrumbs-without-plugin/
 * Ejercicicio enriquecido: http://dimox.net/wordpress-breadcrumbs-without-a-plugin/
 * Ajuste de meuestreo en categoria https://wordpress.stackexchange.com/questions/129609/how-to-show-only-one-category-in-breadcrumb-navigation
 *
 * @package ekilinewp
 */


function breadcrumb() {

//variables para los attachments        
$attachPost = get_post( get_the_ID() );
$attachUrl = get_permalink( $attachPost->post_parent );
$attachParent = get_the_title( $attachPost->post_parent );
    
            
    if ( !is_home() || !is_front_page() ) {
            
    echo '<ul class="breadcrumb">';
        
        echo '<li><a href="'. home_url() .'"> Home </a></li>';

        if ( is_category() || is_single() ) {
            
            if( is_category() ) {
                echo '<li>';
                    single_term_title();
                echo '</li>';
                                
            } elseif (is_single() ) {
                    
                if ( is_attachment() ){
                    
                    // si es un adjunto, muestra el titulo de donde viene
                    echo '<li><a href="'.$attachUrl.'" title="Volver a  '.$attachParent.'" rel="gallery">'.$attachParent.'</a></li>';                
                                    
                } else {
                        
                    // si no es un adjunto, entonces muestra la categoría del post
                    echo '<li>';
                    // se debe hacer un llamado en particular para mostrar solo la primer categoria del array (por ello se usa array_shift).
                    $cats = get_the_category( get_the_ID() );
                    $cat = array_shift($cats);
                    echo '<a href="' . esc_url( get_category_link( $cat->term_id ) ) . '" title="' . esc_attr( sprintf( __( 'Ver todo en %s', 'ekilinewp' ), $cat->name ) ) . '">'. $cat->name .'</a>';
                    echo '</li>';
                                        
                }
                
                the_title('<li>','</li>');
            }            
            
        } elseif ( is_page() ) {
                
            if (is_attachment()){                
                echo '<li><a href="'.$attachUrl.'" title="Volver a '.$attachParent.'" rel="gallery">'.$attachParent.'</a></li>';                
            }            
            
            echo '<li>';
              the_title();
            echo '</li>';
            
        }
        elseif (is_tag()) {        
             echo '<li>'; 
               single_tag_title(); 
             echo '</li>';
        }
        elseif (is_day()) {
            echo '<li>'. __( 'Archivo de ', 'ekilinewp' ); 
              the_time( get_option( 'date_format' ) );
            echo '</li>';
        }
        elseif (is_month()) {
            echo '<li>'. __( 'Archivo de ', 'ekilinewp' ); 
              the_time('F, Y'); 
            echo '</li>';
        }
        elseif (is_year()) {
            echo '<li>'. __( 'Archivo de ', 'ekilinewp' ); 
              the_time('Y'); 
            echo'</li>';
        }
        elseif (is_author()) {            
            global $author;
            $author = get_userdata($author);         
            echo '<li>'. __( 'Entradas de ', 'ekilinewp' ), sprintf($author->display_name) .'</li>';
        }
        elseif ( isset($_GET['paged']) && !empty($_GET['paged']) ) {
            echo '<li>'. __( 'Archivo', 'ekilinewp' ); 
            echo '</li>';
        }
        elseif (is_search()) {
            echo '<li>'. __( 'Resultados ', 'ekilinewp' ); 
            echo '</li>';
        }
        elseif (is_404()) {
            echo '<li>'. __( 'Error ', 'ekilinewp' ) .'</li>';
        }
        
    echo '</ul>';
            
    }    
    

}