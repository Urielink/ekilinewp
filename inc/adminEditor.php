<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 * Info: https://developer.wordpress.org/reference/functions/add_editor_style/
 *
 * @package ekiline
 */

/**
 * Añadir estilos css al editor de wordpress (no requiere una función):
 */

// add_editor_style('editor-style.css'); 
add_editor_style('editor-style.css'); 

/**
 * Registers an editor stylesheet for the current theme.
 */
// function wpdocs_theme_add_editor_styles() {
    // $font_url = str_replace( ',', '%2C', '//fonts.googleapis.com/css?family=Lato:300,400,700' );
    // add_editor_style( $font_url );
// }
// add_action( 'after_setup_theme', 'wpdocs_theme_add_editor_styles' ); 

/**
 * Añadir los tipos de estilo que se requieren para trabajar con bootstrap:
 * http://www.wpbeginner.com/wp-tutorials/how-to-add-custom-styles-to-wordpress-visual-editor/ 
 */
 
//Registro mi menu de estilos 

function ekiline_bootstrap_styles($buttons) {
    array_unshift($buttons, 'styleselect');
    return $buttons;
}
add_filter('mce_buttons_2', 'ekiline_bootstrap_styles');

/*
* Genero mi callback
*/

function ekiline_mce_before( $init_array ) {  

// Define the style_formats array
/*
* Each array child is a format with it's own settings
* Notice that each array has title, block, classes, and wrapper arguments
* Title is the label which will be visible in Formats menu
* Block defines whether it is a span, div, selector, or inline style
* Classes allows you to define CSS classes
* Wrapper whether or not to add a new block-level element around any selected elements
* Auxiliar: https://github.com/bostondv/bootstrap-tinymce-styles/blob/master/bootstrap-tinymce-styles.php
*/

    $style_formats = array(      
    
        array(  
            'title' => __('Columns', 'ekiline'),  
            'items' => array(                
                array(  
                    'title' => __('Columns container', 'ekiline'),  
                    'block' => 'div',  
                    'classes' => 'row',
                    'wrapper' => true,
                ),
                array(  
                    'title' => __('2 columns', 'ekiline'),  
                    'block' => 'div',  
                    'classes' => 'col-sm-6',
                ),
                array(  
                    'title' => __('3 columns', 'ekiline'),  
                    'block' => 'div',  
                    'classes' => 'col-sm-4'
                ),
                array(  
                    'title' => __('4 columns', 'ekiline'),  
                    'block' => 'div',  
                    'classes' => 'col-sm-3'
                ),
                array(  
                    'title' => __('6 columns', 'ekiline'),  
                    'block' => 'div',  
                    'classes' => 'col-sm-2'
                ),

            )                
        ), 
        
        array(
            'title' => __( 'Typography', 'ekiline' ),
            'items' => array(
                array(
                    'title'     => __( 'Lead Text', 'ekiline' ),
                    'block'  => 'p',
                    'classes'   => 'lead',
                ),
                array(
                    'title'     => __( 'Small', 'ekiline' ),
                    'inline'    => 'small',
                ),
                array(
                    'title'     => __( 'Highlight', 'ekiline' ),
                    'inline'    => 'mark',
                ),
                array(
                    'title'     => __( 'Insert', 'ekiline' ),
                    'inline'    => 'ins',
                ),
                array(
                    'title'     => __( 'Abbreviation', 'ekiline' ),
                    'inline'    => 'abbr',
                ),
                array(
                    'title'     => __( 'Initialism', 'ekiline' ),
                    'inline'    => 'abbr',
                    'classes'   => 'initialism',
                ),
                array(
                    'title'     => __( 'Cite', 'ekiline' ),
                    'inline'    => 'cite',
                ),
                array(
                    'title'     => __( 'User Input', 'ekiline' ),
                    'inline'    => 'kbd',
                ),
                array(
                    'title'     => __( 'Variable', 'ekiline' ),
                    'inline'    => 'var',
                ),
                array(
                    'title'     => __( 'Sample Output', 'ekiline' ),
                    'inline'    => 'samp',
                ),
                array(
                    'title'     => __( 'Address', 'ekiline' ),
                    'format'    => 'address',
                    'wrapper'   => true,
                ),
                array(
                    'title'     => __( 'Code Block', 'ekiline' ),
                    'format'    => 'pre',
                    'wrapper'   => true,
                ),
            ),
        ),
        array(
            'title' => __( 'Colors', 'ekiline' ),
            'items' => array(
                array(
                    'title'     => __( 'Muted', 'ekiline' ),
                    'inline'    => 'span',
                    'classes'   => 'text-muted',
                ),
                array(
                    'title'     => __( 'Primary', 'ekiline' ),
                    'inline'    => 'span',
                    'classes'   => 'text-primary',
                ),
                array(
                    'title'     => __( 'Success', 'ekiline' ),
                    'inline'    => 'span',
                    'classes'   => 'text-success',
                ),
                array(
                    'title'     => __( 'Info', 'ekiline' ),
                    'inline'    => 'span',
                    'classes'   => 'text-info',
                ),
                array(
                    'title'     => __( 'Warning', 'ekiline' ),
                    'inline'    => 'span',
                    'classes'   => 'text-warning',
                ),
                array(
                    'title'     => __( 'Danger', 'ekiline' ),
                    'inline'    => 'span',
                    'classes'   => 'text-danger',
                ),
                array(
                    'title'     => __( 'Background Primary', 'ekiline' ),
                    'block'     => 'div',
                    'classes'   => 'bg-primary',
                    'wrapper'   => true,
                ),
                array(
                    'title'     => __( 'Background Success', 'ekiline' ),
                    'block'     => 'div',
                    'classes'   => 'bg-success',
                    'wrapper'   => true,
                ),
                array(
                    'title'     => __( 'Background Info', 'ekiline' ),
                    'block'     => 'div',
                    'classes'   => 'bg-info',
                    'wrapper'   => true,
                ),
                array(
                    'title'     => __( 'Background Warning', 'ekiline' ),
                    'block'     => 'div',
                    'classes'   => 'bg-warning',
                    'wrapper'   => true,
                ),
                array(
                    'title'     => __( 'Background Danger', 'ekiline' ),
                    'block'     => 'div',
                    'classes'   => 'bg-danger',
                    'wrapper'   => true,
                ),
            ),
        ),
        array(
            'title' => __( 'Utilities', 'ekiline' ),
            'items' => array(
                array(
                    'title'     => __( 'Pull Left', 'ekiline' ),
                    'block'  => 'div',
                    'classes'   => 'pull-left',
                ),
                array(
                    'title'     => __( 'Pull Right', 'ekiline' ),
                    'block'  => 'div',
                    'classes'   => 'pull-right',
                ),
                array(
                    'title'     => __( 'Clearfix', 'ekiline' ),
                    'block'  => 'div',
                    'classes'   => 'clearfix',
                ),
                array(
                    'title'     => __( 'Center Block', 'ekiline' ),
                    'block'  => 'div',
                    'classes'   => 'center-block',
                ),
            ),
        ),
        array(
            'title' => __( 'Lists', 'ekiline' ),
            'items' => array(
                array(
                    'title'     => __( 'Unstyled List', 'ekiline' ),
                    'selector'  => 'ul,ol',
                    'classes'   => 'list-unstyled',
                ),
                array(
                    'title'     => __( 'Inline List', 'ekiline' ),
                    'selector'  => 'ul,ol',
                    'classes'   => 'list-inline',
                ),
            ),
        ),
        array(
            'title' => __( 'Buttons', 'ekiline' ),
            'items' => array(
                array(
                    'title'     => __( 'Default', 'ekiline' ),
                    'inline'    => 'a',
                    'classes'   => 'btn btn-default',
                ),
                array(
                    'title'     => __( 'Primary', 'ekiline' ),
                    'inline'    => 'a',
                    'classes'   => 'btn btn-primary',
                ),
                array(
                    'title'     => __( 'Success', 'ekiline' ),
                    'inline'    => 'a',
                    'classes'   => 'btn btn-success',
                ),
                array(
                    'title'     => __( 'Info', 'ekiline' ),
                    'inline'    => 'a',
                    'classes'   => 'btn btn-info',
                ),
                array(
                    'title'     => __( 'Warning', 'ekiline' ),
                    'inline'    => 'a',
                    'classes'   => 'btn btn-warning',
                ),
                array(
                    'title'     => __( 'Danger', 'ekiline' ),
                    'inline'    => 'a',
                    'classes'   => 'btn btn-danger',
                ),
                array(
                    'title'     => __( 'Link', 'ekiline' ),
                    'inline'    => 'a',
                    'classes'   => 'btn btn-link',
                ),
                array(
                    'title'     => __( 'Large', 'ekiline' ),
                    'selector'  => 'a,button,input',
                    'classes'   => 'btn-lg',
                ),
                array(
                    'title'     => __( 'Small', 'ekiline' ),
                    'selector'  => 'a,button,input',
                    'classes'   => 'btn-sm',
                ),
                array(
                    'title'     => __( 'Extra Small', 'ekiline' ),
                    'selector'  => 'a,button,input',
                    'classes'   => 'btn-xs',
                ),
                array(
                    'title'     => __( 'Block', 'ekiline' ),
                    'selector'  => 'a,button,input',
                    'classes'   => 'btn-block',
                ),
                array(
                    'title'        => __( 'Disabled', 'ekiline' ),
                    'selector'     => 'a,button,input',
                    'attributes'   => array(
                        'disabled' => 'disabled'
                    ),
                ),
            ),
        ),
        array(
            'title' => __( 'Labels', 'ekiline' ),
            'items' => array(
                array(
                    'title'     => __( 'Default', 'ekiline' ),
                    'inline'  => 'span',
                    'classes'   => 'label label-default',
                ),
                array(
                    'title'     => __( 'Primary', 'ekiline' ),
                    'inline'  => 'span',
                    'classes'   => 'label label-primary',
                ),
                array(
                    'title'     => __( 'Success', 'ekiline' ),
                    'inline'  => 'span',
                    'classes'   => 'label label-success',
                ),
                array(
                    'title'     => __( 'Info', 'ekiline' ),
                    'inline'  => 'span',
                    'classes'   => 'label label-info',
                ),
                array(
                    'title'     => __( 'Warning', 'ekiline' ),
                    'inline'  => 'span',
                    'classes'   => 'label label-warning',
                ),
                array(
                    'title'     => __( 'Danger', 'ekiline' ),
                    'inline'  => 'span',
                    'classes'   => 'label label-danger',
                ),
            ),
        ),
        array(
            'title' => __( 'Alerts', 'ekiline' ),
            'items' => array(
                array(
                    'title'     => __( 'Success', 'ekiline' ),
                    'block'     => 'div',
                    'classes'   => 'alert alert-success',
                    'wrapper'   => true,
                ),
                array(
                    'title'     => __( 'Info', 'ekiline' ),
                    'block'     => 'div',
                    'classes'   => 'alert alert-info',
                    'wrapper'   => true,
                ),
                array(
                    'title'     => __( 'Warning', 'ekiline' ),
                    'block'     => 'div',
                    'classes'   => 'alert alert-warning',
                    'wrapper'   => true,
                ),
                array(
                    'title'     => __( 'Danger', 'ekiline' ),
                    'block'     => 'div',
                    'classes'   => 'alert alert-danger',
                    'wrapper'   => true,
                ),
            ),
        ),
        array(
            'title' => __( 'Other', 'ekiline' ),
            'items' => array(
                array(
                    'title'     => __( 'Reverse Blockquote', 'ekiline' ),
                    'selector'  => 'blockquote',
                    'classes'   => 'blockquote-reverse',
                ),
                array(
                    'title'     => __( 'Centered Blockquote', 'ekiline' ),
                    'selector'  => 'blockquote',
                    'classes'   => 'text-center',
                ),
                array(
                    'title'     => __( 'Blockquote Footer', 'ekiline' ),
                    'block'     => 'footer',
                ),
                array(
                    'title'     => __( 'Well', 'ekiline' ),
                    'block'     => 'div',
                    'classes'   => 'well',
                    'wrapper'   => true,
                ),
                array(
                    'title'     => __( 'Large Well', 'ekiline' ),
                    'block'     => 'div',
                    'classes'   => 'well well-lg',
                    'wrapper'   => true,
                ),
                array(
                    'title'     => __( 'Small Well', 'ekiline' ),
                    'block'     => 'div',
                    'classes'   => 'well well-sm',
                    'wrapper'   => true,
                ),
                array(
                    'title'     => __( 'Badge', 'ekiline' ),
                    'inline'     => 'span',
                    'classes'   => 'badge',
                ),
                array(
                    'title'     => __( 'Rounded Image', 'ekiline' ),
                    'selector'  => 'img',
                    'classes'   => 'img-rounded',
                ),
                array(
                    'title'     => __( 'Circle Image', 'ekiline' ),
                    'selector'  => 'img',
                    'classes'   => 'img-circle',
                ),
                array(
                    'title'     => __( 'Thumbnail Image', 'ekiline' ),
                    'selector'  => 'img',
                    'classes'   => 'img-thumbnail',
                ),
            ),
        ),        
                     
    
    );  
    
    // Insert the array, JSON ENCODED, into 'style_formats'
    
    $init_array['style_formats'] = json_encode( $style_formats );  
    
    return $init_array;  
  
} 
// Attach callback to 'tiny_mce_before_init' 
add_filter( 'tiny_mce_before_init', 'ekiline_mce_before' ); 


