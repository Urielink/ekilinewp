<?php

// This file is based on wp-includes/js/tinymce/langs/wp-langs.php

if ( ! defined( 'ABSPATH' ) )
    exit;

if ( ! class_exists( '_WP_Editors' ) )
    require( ABSPATH . WPINC . '/class-wp-editor.php' );

function ekiline_tinymce_translation() {
    $strings = array(
    //adminShowgrid.js
        'showgrid' => __('Show grid', 'ekiline'),
    //adminItemBg.js
        'addbackground' => __('Add background', 'ekiline'),
        'choosebgcolor' => __('Choose a background color or set an image', 'ekiline'),
        'image' => __('Image', 'ekiline'),
        'choosebgimg' => __('Choose background image', 'ekiline'),
        'choose' => __('Choose', 'ekiline'),
        'bgstyle' => __('Background style', 'ekiline'),
        'pattern' => __('Pattern', 'ekiline'),
        'simple' => __('Simple', 'ekiline'),
        'responsive' => __('Responsive', 'ekiline'),
        'fixed' => __('Fixed', 'ekiline'),
        'parallax' => __('Parallax', 'ekiline'),
    //adminSubgrid.js
        'addcols' => __('Add columns', 'ekiline'),
        'col' => __('Column', 'ekiline'),
        'colspec' => __('Each column is inserted by proportion', 'ekiline'),
    );
    $locale = _WP_Editors::$mce_locale;
    $translated = 'tinyMCE.addI18n("' . $locale . '.ekiline_tinymce", ' . json_encode( $strings ) . ");\n";

     return $translated;
}

$strings = ekiline_tinymce_translation();