<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Ekiline: Importar un listado de entradas de alguna categoria, se genera un loop. 
 * Ekiline: Insert a list of posts everywhere, it generates a loop
 * @link https://css-tricks.com/snippets/wordpress/run-loop-on-posts-of-specific-category/ 
 * @link http://code.tutsplus.com/tutorials/create-a-shortcode-to-list-posts-with-multiple-parameters--wp-32199
 * Especial atencion en el uso de ob_start();
 * @link http://wordpress.stackexchange.com/questions/41012/proper-use-of-output-buffer
 * @link https://developer.wordpress.org/reference/functions/query_posts/
 * @link https://codex.wordpress.org/Shortcode_API
 * @link https://wordpress.stackexchange.com/questions/96646/creating-wp-query-with-posts-with-specific-category
 *
 * @package ekiline
 */

 

function ekiline_addpostlist($atts, $content = null) {
    
    extract(shortcode_atts(array('catid'=>'','limit'=>'5', 'format'=>'default', 'sort'=>'DES'), $atts));
    
    // Por el formato es que cambia el tipo de contenido (default, block or carousel).
    // Content type changes with format value
        
    ob_start(); // abre 
    
            //Declarar las variables invoca las cotegorias necesarias WP_Query()
            $query_string = '';
            //$nuevoLoop = new WP_Query($query_string . '&cat='.$catid.'&posts_per_page='.$limit.'&order='.$sort );
            $nuevoLoop = new WP_Query(array( 'category_name' => $catid, 'posts_per_page' => $limit, 'order' => $sort ));
            // obtiene la cuenta de los posts
            // count posts
            $post_counter = 0; 
            $count = '';   
                                
            if ( $nuevoLoop->have_posts() ) {              
                    
                if ($format == 'default'){         
                
                    echo '<div class="clearfix modpostlist-'.$format.'">';   
                    
                        while ( $nuevoLoop->have_posts() ) {
                              $nuevoLoop->the_post(); 
                                    $post_counter++;  
                                    
                                        // trae la parte del template - get template part 
                                        get_template_part( 'template-parts/content', get_post_format() );
                                        
                                        // por cada 3 posts agrega un elemento (Puedes prescindir de esto) -  Add an HR
                                        if ($post_counter == 2):{ echo '<hr>'; } 
                                                // resetea el contador
                                                $post_counter = 0; 
                                        endif; 
                                }
                            
                    echo '</div>';
                
                } else if ($format == 'block'){
                            
                       //update: 29 08 2017 columns
                        $colSet = get_theme_mod('ekiline_Columns'); 
                         if ($colSet == '1' ) {
                             $colCount='2';
                         } elseif ($colSet == '2' ) {
                             $colCount='3';
                         } elseif ($colSet == '3' ) {
                             $colCount='4';
                         } else {
                             $colCount='3';
                         }                       
                    
                                                                                                    
                        echo '<div class="row clearfix modpostlist-'.$format.'">'; 
                        
                            while( $nuevoLoop->have_posts() ) : $nuevoLoop->the_post();                                 
                            
                                $count++;                               
                                
                                get_template_part( 'template-parts/content', 'block' );
                                
                                // por cada 3 posts agrega un divisor, necesario para mantener alineaciones
                                //if ($count == 3) : echo '<div class="clearfix middle"></div>'; $count = 0;  endif;
                                if ($count == $colCount ) : echo '<div class="clearfix middle"></div>'; $count = 0;  endif;
                                                                
                            endwhile;
                                
                        echo '</div>';
                    
                } else if ($format == 'carousel'){
                    
                // Limpiar las comas de las categorias para asignar un ID general.    
                // Clean ids commas to asign an id    
                    $catid = ekiline_cleanspchar($catid);                 
                
                    echo '<div id="carousel-module-00'.$catid.'" class="modpostlist-'.$format.' carousel slide clearfix" data-ride="carousel"><div class="carousel-inner" role="listbox">';   
                
                // Indicadores  Bootstrap
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
                            echo '<div class="carousel-item '.$countclass.'">';
                                get_template_part( 'template-parts/content', 'carousel' );
                            echo '</div>';
                    endwhile;
                                
                                
                // Controles        
                    echo '</div>
                          <a class="carousel-control-prev" href="#carousel-module-00'.$catid.'" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                          </a>
                          <a class="carousel-control-next" href="#carousel-module-00'.$catid.'" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                          </a>
                          </div>';                                      
                        
                }

                
            } //.if $nuevoLoop
                        
    
            wp_reset_postdata(); // resetea la peticion
        
        
    $insertarItem = ob_get_clean(); // cierra
    
    return $insertarItem;       

}
add_shortcode('modulecategoryposts', 'ekiline_addpostlist');

 