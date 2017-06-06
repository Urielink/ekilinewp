<?php
/**
* Bootstrap Tab Content: https://github.com/takien/WordPress/blob/master/Bootstrapcollpasecontent/bootstrap-tab-content.php
* Add Bootstrap tab on WordPress posts/page using shortcode.
* Example usage
    [modulegroupcollapse]
        [collpasecontent title="Title tab 1"]
            content tab 1
        [/collpasecontent]
        [collpasecontent title="Title tab 2"]
            content tab 2
        [/collpasecontent]
    [/modulegroupcollapse]
*
* 
* @package ekiline
*
*/

function gcollpase_shortcode( $atts, $content = null ) {

    // $unique = mt_rand();
    extract( shortcode_atts( array( 'class' => '', 'id' => 'accordion' ), $atts ) );
    $groupId = $id;
    $regex = '\\[(\\[?)(collpasecontent)\\b([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)';
    preg_match_all("/$regex/is",$content,$match);
    $content = $match[0];
        
   $return =  '<div class="panel-group '.$class.'" id="'.$groupId.'" role="tablist" aria-multiselectable="true">';
   
        $i = -1;

            foreach($content as $c){ $i++;
            
                //El nombre del tab va despues de $attr
                //$unique_id = 'tab_tab_'.$unique.'_'.$i;
                preg_match('/\[collpasecontent ([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)/',$c,$matchattr);
                $attr = shortcode_parse_atts($matchattr[1]);
                //Filtramos los caracteres y añadimos un contador.
                $unique_id = ekiline_cleanspchar($attr['title']).'-'.$i;
                //creo un id grupal para cada item
                $heading_id = ekiline_cleanspchar($attr['title']).$i.$i;
                                
                $return .= '<div class="panel panel-default">';
                
                    $return .= '<div class="panel-heading" role="tab" id="'.$heading_id.'">
                                    <h4 class="panel-title">';
                    
                        $return .= '<a '.(($i!=0) ? 'class="collapsed"' : '').' role="button" data-toggle="collapse" data-parent="#'.$groupId.'" href="#'.$unique_id.'" aria-expanded="true" aria-controls="'.$unique_id.'">'.$attr['title'].'</a>';
                        
                        $return .= '</h4>
                                </div>'; //panel-heading

                    
                    $return .= '<div id="'.$unique_id.'" class="panel-collapse collapse '.(($i==0) ? 'in' : '').' '.$class.'" role="tabpanel" aria-labelledby="'.$heading_id.'">';
                                    $return .= do_shortcode($c);
                    $return .= '</div>';

                                        
                $return .= '</div>'; //panel-default
                                                        
            }
                        

        $return .= '</div>'; //panel-group
        
   return $return;
}

add_shortcode('modulegroupcollapse',  'gcollpase_shortcode');


function collpasecontent_shortcode( $atts, $content = null ) {
    extract( shortcode_atts( array( 'title' => ''), $atts ) );

        $return = '<div class="panel-body">'.do_shortcode($content).'</div>';

    return $return;
}

add_shortcode('collpasecontent',  'collpasecontent_shortcode');


/** Tabs para experimentar.
    Usar regex: http://wordpress.stackexchange.com/questions/116288/getting-the-count-of-a-shortcode-that-is-nested.
    O crer un modulo: http://wordpress.stackexchange.com/questions/121562/get-attributes-of-nested-shortcodes
**/

