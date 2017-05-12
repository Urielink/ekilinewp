<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Importar un listado de entradas de alguna categoria, se genera un loop. 
 * https://css-tricks.com/snippets/wordpress/run-loop-on-posts-of-specific-category/ 
 * http://code.tutsplus.com/tutorials/create-a-shortcode-to-list-posts-with-multiple-parameters--wp-32199
 * Especial atencion en el uso de ob_start();
 * http://wordpress.stackexchange.com/questions/41012/proper-use-of-output-buffer
 * https://developer.wordpress.org/reference/functions/query_posts/
 *
 * @package ekiline
 */

 

function ekiline_insertar($atts, $content = null) {
    
    extract(shortcode_atts(array('catid'=>'','limit'=>'', 'format'=>'default', 'sort'=>'DES'), $atts));
        
    ob_start(); // abre 
    
            // 9may 2017: hay que declarar las variables invoca las cotegorias necesarias WP_Query()
            $query_string = '';
            $nuevoLoop = new WP_Query($query_string . '&cat='.$catid.'&posts_per_page='.$limit.'&order='.$sort );
            // obtiene la cuenta de los posts
            $post_counter = 0; 
            $count = '';                               
            
                
                                
            if ( $nuevoLoop->have_posts() ) {
                    
                if ($format == 'default'){              
                
                    echo '<div class="clearfix insert-'.$format.'">';   
                    
                        while ( $nuevoLoop->have_posts() ) {
                              $nuevoLoop->the_post(); 
                                    // $post_counter++;  
                                        // trae la parte del template para personalizar
                                        get_template_part( 'template-parts/content', 'insert' );
                                        // por cada 3 posts mete un hr
                                    /** if ($post_counter == 1):{ echo '<hr>'; } 
                                            // resetea el contador
                                            $post_counter = 0; 
                                        endif; **/
                                }
                            
                    echo '</div>';
                
            } 
                    
            else if ($format == 'blocklist'){
                            
                    /* cambiar el modo de como se muestra el boton leer mas 
                     * https://codex.wordpress.org/Customizing_the_Read_More */
                                                                    
                    echo '<div class="clearfix insert-'.$format.'">'; 
                    
                        while( $nuevoLoop->have_posts() ) : $nuevoLoop->the_post();                                 
                        
                            $count++;                               
                            
                            get_template_part( 'template-parts/content', 'blocklist' );
                            
                            // por cada 3 posts mete una división
                            if ($count == 3) : echo '<div class="clearfix middle"></div>'; $count = 0;  endif;
                            
                        endwhile;
                            
                    echo '</div>';
                
            }               
                
                else if ($format == 'carousel'){
                    
                // Limpiar las comas de las categorias para ejecutar carrusel en caso de ser mas de una.    
                    $catid = limpiarCaracteres($catid);                 
                
                    echo '<div id="carousel-module-00'.$catid.'" class="insert-'.$format.' carousel slide clearfix" data-ride="carousel"><div class="carousel-inner" role="listbox">';   
                
                // Indicadores  
                    echo '<ol class="carousel-indicators">';
                        while( $nuevoLoop->have_posts() ) : $nuevoLoop->the_post();
                            $count = $nuevoLoop->current_post + 0;
                            if ($count == '0') : $countclass = 'active' ; elseif ($count !='0') : $countclass = '' ; endif; 
                            echo '<li data-target="#carousel-module-00'.$catid.'" data-slide-to="'.$count.'" class="'.$countclass.'"></li>';
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
                          <a class="left carousel-control" href="#carousel-module-00'.$catid.'" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                          </a>
                          <a class="right carousel-control" href="#carousel-module-00'.$catid.'" role="button" data-slide="next">
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

 