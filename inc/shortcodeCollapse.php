<?php
/**
* Bootstrap Tab Content: 
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

    $unique = mt_rand( 1 , 100 );
    extract( shortcode_atts( array( 'class' => '' ), $atts ) );
    $groupId = 'accordion-' . $unique;
    $regex = '\\[(\\[?)(collpasecontent)\\b([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)';
    preg_match_all("/$regex/is",$content,$match);
    $content = $match[0];
        
   $return =  '<div class="'.$class.'" id="'.$groupId.'" role="tablist" aria-multiselectable="true">';
   
        $i = -1;

            foreach($content as $c){ $i++;
                preg_match('/\[collpasecontent ([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)/',$c,$matchattr);
                $attr = shortcode_parse_atts($matchattr[1]);
                $unique_id = ekiline_cleanspchar($attr['title']).'-'.$i;
                $heading_id = ekiline_cleanspchar($attr['title']).$i.$i;
                                
                $return .= '<div class="card">';
                
                    $return .= '<div class="card-header" role="tab" id="'.$heading_id.'">
                                    <h4>';
                    
                        $return .= '<a '.(($i!=0) ? 'class="collapsed"' : '').' role="button" data-toggle="collapse" data-parent="#'.$groupId.'" href="#'.$unique_id.'" aria-expanded="true" aria-controls="'.$unique_id.'">'.$attr['title'].'</a>';
                        
                        $return .= '</h4>
                                </div>'; //card-heading

                    
                    $return .= '<div id="'.$unique_id.'" class="collapse '.(($i==0) ? 'show' : '').' '.$class.'" role="tabpanel" aria-labelledby="'.$heading_id.'">';
                                    $return .= do_shortcode($c);
                    $return .= '</div>';

                                        
                $return .= '</div>'; //card
                                                        
            }
                        

        $return .= '</div>'; //tablist
        
   return $return;
}

add_shortcode('modulegroupcollapse',  'gcollpase_shortcode');


function collpasecontent_shortcode( $atts, $content = null ) {
    extract( shortcode_atts( array( 'title' => '', 'class' => ''), $atts ) );

        $return = '<div class="card-body '.$class.'">'.do_shortcode($content).'</div>';

    return $return;
}

add_shortcode('collpasecontent',  'collpasecontent_shortcode');

