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
    // 1. reemplazamos el random matematico para que la ejecucion sea con el nombre del tab.    
    // $unique = mt_rand();
    extract( shortcode_atts( array( 'class' => '' ), $atts ) );
    $regex = '\\[(\\[?)(collpasecontent)\\b([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)';
    preg_match_all("/$regex/is",$content,$match);
    $content = $match[0];
        
   $return =  '<div class="tabs-module clearfix '.$class.'">';
        $i = -1;
        $return .= '<ul class="nav nav-tabs">';
                        foreach($content as $c){ $i++;
                            //El nombre del tab va despues de $attr
                            //$unique_id = 'tab_tab_'.$unique.'_'.$i;
                            preg_match('/\[collpasecontent ([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)/',$c,$matchattr);
                            $attr = shortcode_parse_atts($matchattr[1]);
                            //Filtramos los caracteres y añadimos un contador.
                            $unique_id = ekiline_cleanspchar($attr['title']).'-'.$i;
                            $return .= '<li '.(($i==0) ? 'class="active"' : '').'><a href="#'.$unique_id.'" data-toggle="tab">'.$attr['title'].'</a></li>';
                            $content[$i] = str_replace('[collpasecontent ','[collpasecontent '.(($i==0) ? 'class="active"' : '').' id="'.$unique_id.'" ',$content[$i]);
                        }
        $return .= '</ul>';
        $return .= '<div class="tab-content">';
                        foreach($content as $c){
                            $return .= do_shortcode($c);
                        }
        $return .= '</div></div>';
        
   return $return;
}

add_shortcode('modulegroupcollapse',  'gcollpase_shortcode');


function collpasecontent_shortcode( $atts, $content = null ) {
    extract( shortcode_atts( array( 'title' => '', 'id' =>'', 'class' =>'' ), $atts ) );
        $return = '<div class="tab-pane '.$class.'" id="'.$id.'">';
        $return .= '<div class="panel-body">'.do_shortcode($content).'</div>';
        $return .= '</div>';
    return $return;
}

add_shortcode('collpasecontent',  'collpasecontent_shortcode');


/** Tabs para experimentar.
    Usar regex: http://wordpress.stackexchange.com/questions/116288/getting-the-count-of-a-shortcode-that-is-nested.
    O crer un modulo: http://wordpress.stackexchange.com/questions/121562/get-attributes-of-nested-shortcodes
**/

