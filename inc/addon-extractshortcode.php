<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package ekilinewp
 */

/* Hacer que un shortcode se coloque en la parte superior:
 * 1) se registra el shortcode: function ekilinewp_topcontent.
 * referencias:
 * http://wordpress.stackexchange.com/questions/168789/get-shortcode-from-the-content-and-display-it-in-other-place-in-sidebar-for-ex
 * wordpress > get shortcode and parse out of content -plugin
 * https://wordpress.org/support/topic/extract-shortcode-out-of-the_content
 * https://codex.wordpress.org/Function_Reference/has_shortcode
 * https://developer.wordpress.org/reference/functions/has_shortcode/
 */
 
function ekilinewp_topcontent($atts, $content = null) {
	extract(shortcode_atts(array('name' => 'default'), $atts));	
	return do_shortcode($content);
}
add_shortcode('topcontent', 'ekilinewp_topcontent');


/* 2) se crea la funcion para el template, en caso de existir el shortcode.*/
 
if ( ! function_exists( 'topShortcode' ) ) {
	function topShortcode() {
		global $post; // identificar si es post
		if($post) {
			// identifica si en el contenido del post existe [topcontent]
			$pattern = get_shortcode_regex();
			preg_match('/'.$pattern.'/s', $post->post_content, $matches);
			// si hay parsealo.
			if( $matches ) :
				if (is_array($matches) && $matches[2] == 'topcontent') {
				   $shortcode = $matches[0];
				   echo do_shortcode($shortcode);
				} 
			endif; //$matches			
		} // endif $post						
	}// end func. topShortcode	
}
add_action( 'init', 'topShortcode' );

/* 3) se limpia el contenido del post.
 * http://stackoverflow.com/questions/22227106/strip-wordpress-gallery-shortcode-from-the-content-and-use-outside-the-loop
 */

function stripTopcontent( $content ) {
    preg_match_all( '/'. get_shortcode_regex() .'/s', $content, $matches, PREG_SET_ORDER );
    if ( ! empty( $matches ) ) {
        foreach ( $matches as $shortcode ) {
            if ( 'topcontent' === $shortcode[2] ) {
                $pos = strpos( $content, $shortcode[0] );
                if ($pos !== false)
                    return substr_replace( $content, '', $pos, strlen($shortcode[0]) );
            }
        }
    }
    return $content;
}
add_filter('the_content', 'stripTopcontent');

