<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package ekiline
 */

// acordeon, este debe tener un titulo y la descricpion se insertara en un div

function ekiline_collapse_single($atts, $content = null) {
    extract(shortcode_atts(array( 'title' => ''), $atts));
    $titleBtn = ekiline_cleanspchar($title);
    return '<a class="btn btn-default" data-toggle="collapse" href="#'.$titleBtn.'" aria-expanded="false" aria-controls="'.$titleBtn.'">'.$title.'</a>
            <div class="acordeon collapse" id="'.$titleBtn.'">
                <div class="well">'.do_shortcode($content).'</div>
            </div>';
}
add_shortcode('mod_collapse', 'ekiline_collapse_single');


/* Extender el Shortcode [Embed]
 * https://developer.wordpress.org/reference/classes/wp_embed/run_shortcode/
 * https://wordpress.stackexchange.com/questions/134228/how-to-overwrite-youtube-embed
 * https://wordpress.stackexchange.com/questions/13810/adding-a-filter-to-a-shortcode
 * https://wordpress.stackexchange.com/questions/112294/filter-specific-shortcode-output
 * https://wordpress.stackexchange.com/questions/99978/how-add-class-youtube-and-type-html-to-oembed-code
 */

function ekiline_embed_override($html, $url, $atts, $post_id) {
    
    extract( shortcode_atts(array( 'responsive' => '4by3',), $atts) );    
        
    return '<div class="embed-responsive embed-responsive-'.$responsive.'">' . $html . '</div>';
}
add_filter('embed_oembed_html', 'ekiline_embed_override', 99, 4);
add_filter('wp_video_shortcode', 'ekiline_embed_override', 99, 4);



/* Eliminar parrafos vacios en shortcodes.
 * http://mattpierce.info/2015/10/fixing-shortcodes-and-paragraph-tags-in-wordpress/
 * https://gist.github.com/maxxscho/2058547
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