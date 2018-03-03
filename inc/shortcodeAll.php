<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package ekiline
 */

// acordeon, este debe tener un titulo y la descricpion se insertara en un div
// acordion or callapse single, needs a title

function ekiline_collapse_single($atts, $content = null) {
    extract(shortcode_atts(array( 'title' => '', 'class' => ''), $atts));
    $titleBtn = ekiline_cleanspchar($title);
    return '<a class="btn btn-secondary" data-toggle="collapse" href="#'.$titleBtn.'" aria-expanded="false" aria-controls="'.$titleBtn.'">'.$title.'</a>
            <div class="acordeon collapse '.$class.'" id="'.$titleBtn.'">
                '.do_shortcode($content).'
            </div>';
}
add_shortcode('singlecollapse', 'ekiline_collapse_single');


/* Extender el Shortcode [Embed] para añadir comportamineto responsivo a videos de youtube
 * Extend shortcode [Embed] por youtube linked video
 * @link https://developer.wordpress.org/reference/classes/wp_embed/run_shortcode/
 * @link https://wordpress.stackexchange.com/questions/134228/how-to-overwrite-youtube-embed
 * @link https://wordpress.stackexchange.com/questions/13810/adding-a-filter-to-a-shortcode
 * @link https://wordpress.stackexchange.com/questions/112294/filter-specific-shortcode-output
 * @link https://wordpress.stackexchange.com/questions/99978/how-add-class-youtube-and-type-html-to-oembed-code
 */

function ekiline_embed_override($html, $url, $atts, $post_id) {
	$tag = '';
	
	if( strpos( $url, 'youtube.com' ) ) {
	    extract( shortcode_atts( array( 'responsive' => '16by9', ) , $atts) );    
		$tag = '<div class="embed-responsive embed-responsive-'.$responsive.'">' . $html . '</div>';
	} else {
		$tag = $html;
	}
        
    return $tag;
}
add_filter('embed_oembed_html', 'ekiline_embed_override', 99, 4);
// add_filter('wp_video_shortcode', 'ekiline_embed_override', 99, 4);



/* Eliminar parrafos vacios en shortcodes.
 * Clear all empty paragraphs in shortcodes.
 * @link http://mattpierce.info/2015/10/fixing-shortcodes-and-paragraph-tags-in-wordpress/
 * @link https://gist.github.com/maxxscho/2058547
 */

 function shortcode_empty_paragraph_fix($content) {  
    $array = array (
        '<p>[' => '[',
        ']</p>' => ']',
        ']<br />' => ']' 
    );
    $content = strtr($content, $array);
    return $content;
}

add_filter('the_content', 'shortcode_empty_paragraph_fix');