<?php
/**
* Bootstrap Tab Content: https://github.com/takien/WordPress/blob/master/BootstrapTabContent/bootstrap-tab-content.php
* Add Bootstrap tab on WordPress posts/page using shortcode.
* Example usage
	[tabs]
		[tabcontent title="Title tab 1"]
			content tab 1
		[/tabcontent]
		[tabcontent title="Title tab 2"]
			content tab 2
		[/tabcontent]
	[/tabs]
*
* 
* @package ekiline
*
*/

function tabs_shortcode( $atts, $content = null ) {
	// 1. reemplazamos el random matemático para que la ejecución sea con el nombre del tab.	
	// $unique = mt_rand();
	extract( shortcode_atts( array( 'class' => '', 'title' => '' ), $atts ) );
	$regex = '\\[(\\[?)(tabcontent)\\b([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)';
	preg_match_all("/$regex/is",$content,$match);
	$content = $match[0];
	
	if ($title){$title = '<h2 class="text-center">'.$title.'</h2>';}
	
   $return =  '<div class="tabs-module clearfix '.$class.'"><div class="container">'.$title;
		$i = -1;
		$return .= '<ul class="nav nav-pills">';
		foreach($content as $c){ $i++;
			//El nombre del tab va despues de $attr
			//$unique_id = 'tab_tab_'.$unique.'_'.$i;
			preg_match('/\[tabcontent ([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)/',$c,$matchattr);
			$attr = shortcode_parse_atts($matchattr[1]);
			//Filtramos los caracteres y añadimos un contador.
			$unique_id = limpiarCaracteres($attr['title']).'-'.$i;
			$return .= '<li '.(($i==0) ? 'class="active"' : '').'><a href="#'.$unique_id.'" data-toggle="tab">'.$attr['title'].'</a></li>';
			$content[$i] = str_replace('[tabcontent ','[tabcontent '.(($i==0) ? 'class="active"' : '').' id="'.$unique_id.'" ',$content[$i]);
		}
		$return .= '</ul>';
		$return .= '<div class="tab-content">';
		foreach($content as $c){
			$return .= do_shortcode($c);
		}
		$return .= '</div>';
   $return .= '</div></div>';
   return $return;
}

add_shortcode('tabsmodule',  'tabs_shortcode');


function tabcontent_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array( 'title' => '', 'id' =>'', 'class' =>'' ), $atts ) );
	$return = '<div class="tab-pane '.$class.'" id="'.$id.'">';
	$return .= do_shortcode($content);
	$return .= '</div>';
	return $return;
}

add_shortcode('tabcontent',  'tabcontent_shortcode');


/** Tabs para experimentar.
	Usar regex: http://wordpress.stackexchange.com/questions/116288/getting-the-count-of-a-shortcode-that-is-nested.
	O crer un modulo: http://wordpress.stackexchange.com/questions/121562/get-attributes-of-nested-shortcodes
**/

