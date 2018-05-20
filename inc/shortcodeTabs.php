<?php
/**
* Bootstrap Tab Content:
* Add Bootstrap tab on WordPress posts/page using shortcode.
* Example usage
	[moduletabs]
		[tabcontent title="Title tab 1"]
			content tab 1
		[/tabcontent]
		[tabcontent title="Title tab 2"]
			content tab 2
		[/tabcontent]
	[/moduletabs]
*
* 
* @package ekiline
*
*/

function tabs_shortcode( $atts, $content = null ) {

	extract( shortcode_atts( array( 'class' => '' ), $atts ) );
	$regex = '\\[(\\[?)(tabcontent)\\b([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)';
	preg_match_all("/$regex/is",$content,$match);
	$content = $match[0];
		
   $return =  '<div class="tabs-module clearfix '.$class.'">';
		$i = -1;
		$return .= '<ul class="nav nav-tabs">';
                		foreach($content as $c){ $i++;
                			preg_match('/\[tabcontent ([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)/',$c,$matchattr);
                			$attr = shortcode_parse_atts($matchattr[1]);
                			$unique_id = ekiline_cleanspchar($attr['title']).'-'.$i;
                			$return .= '<li class="nav-item"><a '.(($i==0) ? 'class="nav-link active"' : 'class="nav-link"').' href="#'.$unique_id.'" data-toggle="tab">'.$attr['title'].'</a></li>';
                			$content[$i] = str_replace('[tabcontent ','[tabcontent '.(($i==0) ? 'class="active"' : '').' id="'.$unique_id.'" ',$content[$i]);
                		}
		$return .= '</ul>';
		$return .= '<div class="tab-content">';
                		foreach($content as $c){
                			$return .= do_shortcode($c);
                		}
		$return .= '</div></div>';
		
   return $return;
}

add_shortcode('moduletabs',  'tabs_shortcode');


function tabcontent_shortcode( $atts, $content = null ) {
    extract( shortcode_atts( array( 'title' => '', 'id' =>'', 'class' =>'' ), $atts ) );
        $return = '<div class="tab-pane '.$class.'" id="'.$id.'">';
    	$return .= '<div class="card-body">'.do_shortcode($content).'</div>';
    	$return .= '</div>';
	return $return;
}

add_shortcode('tabcontent',  'tabcontent_shortcode');

