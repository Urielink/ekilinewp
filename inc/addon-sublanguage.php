<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package ekiline
 */


/*
 *	Al insertar el plugin de sublanguage se debe personalizar el switch
 */

function my_custom_switch($languages, $sublanguage) {

	$langItem = '';	
	 
	foreach ($languages as $language) {
						
		if ($sublanguage->current_language->ID == $language->ID) : $langClass = ' active' ; else : $langClass = '' ; endif;

    	$langItem .= '<li class="lang '. $language->post_name . $langClass .'"><a href="'. $sublanguage->get_translation_link($language).'">'. $language->post_title.'</a></li>';	

		}

		echo '<ul class="list-unstyled list-inline">'.$langItem.'</ul>';
		
}


add_action('sublanguage_custom_switch', 'my_custom_switch', 10, 2);
