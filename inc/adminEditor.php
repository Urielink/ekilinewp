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
 * Add styles to wordpress admin editor
 */

add_editor_style('editor-style.css'); 


/**
 * Añadir los tipos de estilo que se requieren para trabajar con bootstrap:
 * http://www.wpbeginner.com/wp-tutorials/how-to-add-custom-styles-to-wordpress-visual-editor/ 
 */
 
//Registro mi menu de estilos 
//Register Ekiline styles 

function ekiline_bootstrap_styles($buttons) {
    array_unshift($buttons, 'styleselect');
    return $buttons;
}
add_filter('mce_buttons_2', 'ekiline_bootstrap_styles');

/*
* Genero mi callback
* Add my callback
*/

function ekiline_mce_before( $init_array ) {  

/**
 * La definición de estilos se agrega con arreglos, cada arreglo equivale a un objeto y este puede anidarse
 * Define the style_formats array
 * Each array child is a format with it's own settings
 * Notice that each array has title, block, classes, and wrapper arguments
 * Title is the label which will be visible in Formats menu
 * Block defines whether it is a span, div, selector, or inline style
 * Classes allows you to define CSS classes
 * Wrapper whether or not to add a new block-level element around any selected elements
 * Auxiliar: https://github.com/bostondv/bootstrap-tinymce-styles/blob/master/bootstrap-tinymce-styles.php
 * Permitir data-atts http://mawaha.com/allowing-data-attributes-in-wordpress-posts/ ,
 * https://codex.wordpress.org/TinyMCE_Custom_Styles,
 * http://www.lmhproductions.com/52/wordpress-tincymce-editor-removes-attributes/,
 * **https://getunderskeleton.com/wordpress-custom-styles-dropdown/
 */

    $style_formats = array(      
    
/**        array(  
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
                    'classes' => 'col-sm-4',
                ),
                array(  
                    'title' => __('4 columns', 'ekiline'),  
                    'block' => 'div',  
                    'classes' => 'col-sm-3',
                ),
                array(  
                    'title' => __('6 columns', 'ekiline'),  
                    'block' => 'div',  
                    'classes' => 'col-sm-2',
                ),              
            ),            
        ), 
**/        
        array(
            'title' => __( 'Typography', 'ekiline' ),
            'items' => array(
                array(
                    'title'     => __( 'Lead Text', 'ekiline' ),
                    'block'  => 'p',
                    'classes'   => 'lead',
                ),
                array(
                    'title'     => __( 'Small Text', 'ekiline' ),
                    'inline'    => 'small',
                ),
                array(
                    'title'     => __( 'Highlight', 'ekiline' ),
                    'inline'    => 'mark',
                ),
                array(
                    'title'     => __( 'Delete', 'ekiline' ),
                    'inline'    => 'del',
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
            'title' => __( 'Big headings', 'ekiline' ),
            'items' => array(
                array(
                    'title'     => __( 'Display 1', 'ekiline' ),
                    'selector'  => 'h1,h2,h3,h4',
                    'classes'   => 'display-1',
                ),                           
                array(
                    'title'     => __( 'Display 2', 'ekiline' ),
                    'selector'  => 'h1,h2,h3,h4',
                    'classes'   => 'display-2',
                ),                           
                array(
                    'title'     => __( 'Display 3', 'ekiline' ),
                    'selector'  => 'h1,h2,h3,h4',
                    'classes'   => 'display-3',
                ),                           
                array(
                    'title'     => __( 'Display 4', 'ekiline' ),
                    'selector'  => 'h1,h2,h3,h4',
                    'classes'   => 'display-4',
                ),                           
            ),
        ),
        
        array(
            'title' => __( 'Text Colors (B4)', 'ekiline' ),
            'items' => array(
                array(
                    'title'     => __( 'Primary', 'ekiline' ),
                    'inline'    => 'span',
                    'classes'   => 'text-primary',
                ),
                array(
                    'title'     => __( 'Secondary', 'ekiline' ),
                    'inline'    => 'span',
                    'classes'   => 'text-secondary',
                ),
                array(
                    'title'     => __( 'Success', 'ekiline' ),
                    'inline'    => 'span',
                    'classes'   => 'text-success',
                ),
                array(
                    'title'     => __( 'Danger', 'ekiline' ),
                    'inline'    => 'span',
                    'classes'   => 'text-danger',
                ),
                array(
                    'title'     => __( 'Warning', 'ekiline' ),
                    'inline'    => 'span',
                    'classes'   => 'text-warning',
                ),
                array(
                    'title'     => __( 'Info', 'ekiline' ),
                    'inline'    => 'span',
                    'classes'   => 'text-info',
                ),
                array(
                    'title'     => __( 'Light', 'ekiline' ),
                    'inline'    => 'span',
                    'classes'   => 'text-light',
                ),
                array(
                    'title'     => __( 'Dark', 'ekiline' ),
                    'inline'    => 'span',
                    'classes'   => 'text-dark',
                ),
                array(
                    'title'     => __( 'Muted', 'ekiline' ),
                    'inline'    => 'span',
                    'classes'   => 'text-muted',
                ),
            ),
        ),

        array(
            'title' => __( 'Background colors (B4)', 'ekiline' ),
            'items' => array(
                array(
                    'title'     => __( 'Primary', 'ekiline' ),
                    'block'     => 'div',
                    'classes'   => 'bg-primary',
                    'wrapper'   => true,
                ),
                array(
                    'title'     => __( 'Secondary', 'ekiline' ),
                    'block'     => 'div',
                    'classes'   => 'bg-secondary',
                    'wrapper'   => true,
                ),
                array(
                    'title'     => __( 'Success', 'ekiline' ),
                    'block'     => 'div',
                    'classes'   => 'bg-success',
                    'wrapper'   => true,
                ),
                array(
                    'title'     => __( 'Danger', 'ekiline' ),
                    'block'     => 'div',
                    'classes'   => 'bg-danger',
                    'wrapper'   => true,
                ),
                array(
                    'title'     => __( 'Warning', 'ekiline' ),
                    'block'     => 'div',
                    'classes'   => 'bg-warning',
                    'wrapper'   => true,
                ),
                array(
                    'title'     => __( 'Info', 'ekiline' ),
                    'block'     => 'div',
                    'classes'   => 'bg-info',
                    'wrapper'   => true,
                ),
                array(
                    'title'     => __( 'Light', 'ekiline' ),
                    'block'     => 'div',
                    'classes'   => 'bg-light',
                    'wrapper'   => true,
                ),
                array(
                    'title'     => __( 'Dark', 'ekiline' ),
                    'block'     => 'div',
                    'classes'   => 'bg-dark',
                    'wrapper'   => true,
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
                array(
                    'title'     => __( 'Inline list item', 'ekiline' ),
                    'selector'  => 'li',
                    'classes'   => 'list-inline-item',
                ),
            ),
        ),
        
        array(
            'title' => __( 'Solid buttons', 'ekiline' ),
            'items' => array(
                array(
                    'title'     => __( 'Primary', 'ekiline' ),
                    'inline'    => 'a',
                    'classes'   => 'btn btn-primary',
                ),
                array(
                    'title'     => __( 'Secondary', 'ekiline' ),
                    'inline'    => 'a',
                    'classes'   => 'btn btn-secondary',
                ),
                array(
                    'title'     => __( 'Success', 'ekiline' ),
                    'inline'    => 'a',
                    'classes'   => 'btn btn-success',
                ),
                array(
                    'title'     => __( 'Danger', 'ekiline' ),
                    'inline'    => 'a',
                    'classes'   => 'btn btn-danger',
                ),
                array(
                    'title'     => __( 'Warning', 'ekiline' ),
                    'inline'    => 'a',
                    'classes'   => 'btn btn-warning',
                ),
                array(
                    'title'     => __( 'Info', 'ekiline' ),
                    'inline'    => 'a',
                    'classes'   => 'btn btn-info',
                ),
                array(
                    'title'     => __( 'Light', 'ekiline' ),
                    'inline'    => 'a',
                    'classes'   => 'btn btn-light',
                ),
                array(
                    'title'     => __( 'Dark', 'ekiline' ),
                    'inline'    => 'a',
                    'classes'   => 'btn btn-dark',
                ),
            ),
        ),
        
        array(
            'title' => __( 'Outline buttons', 'ekiline' ),
            'items' => array(
                array(
                    'title'     => __( 'Primary', 'ekiline' ),
                    'inline'    => 'a',
                    'classes'   => 'btn btn-outline-primary',
                ),
                array(
                    'title'     => __( 'Secondary', 'ekiline' ),
                    'inline'    => 'a',
                    'classes'   => 'btn btn-outline-secondary',
                ),
                array(
                    'title'     => __( 'Success', 'ekiline' ),
                    'inline'    => 'a',
                    'classes'   => 'btn btn-outline-success',
                ),
                array(
                    'title'     => __( 'Danger', 'ekiline' ),
                    'inline'    => 'a',
                    'classes'   => 'btn btn-outline-danger',
                ),
                array(
                    'title'     => __( 'Warning', 'ekiline' ),
                    'inline'    => 'a',
                    'classes'   => 'btn btn-outline-warning',
                ),
                array(
                    'title'     => __( 'Info', 'ekiline' ),
                    'inline'    => 'a',
                    'classes'   => 'btn btn-outline-info',
                ),
                array(
                    'title'     => __( 'Light', 'ekiline' ),
                    'inline'    => 'a',
                    'classes'   => 'btn btn-outline-light',
                ),
                array(
                    'title'     => __( 'Dark', 'ekiline' ),
                    'inline'    => 'a',
                    'classes'   => 'btn btn-outline-dark',
                ),
            ),
        ),
        
        array(
            'title' => __( 'Button variables', 'ekiline' ),
            'items' => array(
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
                    'title'     => __( 'Block', 'ekiline' ),
                    'selector'  => 'a,button,input',
                    'classes'   => 'btn-block',
                ),
                array(
                    'title'        => __( 'Disabled', 'ekiline' ),
                    'selector'     => 'a,button,input',
                    'classes'   => 'disabled',
                    'attributes'   => array(
                        'disabled' => 'disabled'
                    ),
                ),
            ),
        ),
        
        array(
            'title' => __( 'Badge', 'ekiline' ),
            'items' => array(
                array(
                    'title'     => __( 'Primary', 'ekiline' ),
                    'inline'  => 'span',
                    'classes'   => 'badge badge-primary',
                ),
                array(
                    'title'     => __( 'Secondary', 'ekiline' ),
                    'inline'  => 'span',
                    'classes'   => 'badge badge-secondary',
                ),
                array(
                    'title'     => __( 'Success', 'ekiline' ),
                    'inline'  => 'span',
                    'classes'   => 'badge badge-success',
                ),
                array(
                    'title'     => __( 'Danger', 'ekiline' ),
                    'inline'  => 'span',
                    'classes'   => 'badge badge-danger',
                ),
                array(
                    'title'     => __( 'Warning', 'ekiline' ),
                    'inline'  => 'span',
                    'classes'   => 'badge badge-warning',
                ),
                array(
                    'title'     => __( 'Info', 'ekiline' ),
                    'inline'  => 'span',
                    'classes'   => 'badge badge-info',
                ),
                array(
                    'title'     => __( 'Light', 'ekiline' ),
                    'inline'  => 'span',
                    'classes'   => 'badge badge-light',
                ),
                array(
                    'title'     => __( 'Dark', 'ekiline' ),
                    'inline'  => 'span',
                    'classes'   => 'badge badge-dark',
                ),                
                array(
                    'title'     => __( 'Pill', 'ekiline' ),
                    'selector'  => 'span',
                    'classes'   => 'badge-pill',
                ),                
            ),
        ),
        
        array(
            'title' => __( 'Alerts', 'ekiline' ),
            'items' => array(
                array(
                    'title'     => __( 'Primary', 'ekiline' ),
                    'block'     => 'div',
                    'classes'   => 'alert alert-primary',
                    'wrapper'   => true,
                ),
                array(
                    'title'     => __( 'Secondary', 'ekiline' ),
                    'block'     => 'div',
                    'classes'   => 'alert alert-secondary',
                    'wrapper'   => true,
                ),
                array(
                    'title'     => __( 'Success', 'ekiline' ),
                    'block'     => 'div',
                    'classes'   => 'alert alert-success',
                    'wrapper'   => true,
                ),
                array(
                    'title'     => __( 'Danger', 'ekiline' ),
                    'block'     => 'div',
                    'classes'   => 'alert alert-danger',
                    'wrapper'   => true,
                ),
                array(
                    'title'     => __( 'Warning', 'ekiline' ),
                    'block'     => 'div',
                    'classes'   => 'alert alert-warning',
                    'wrapper'   => true,
                ),
                array(
                    'title'     => __( 'Info', 'ekiline' ),
                    'block'     => 'div',
                    'classes'   => 'alert alert-info',
                    'wrapper'   => true,
                ),
                array(
                    'title'     => __( 'Light', 'ekiline' ),
                    'block'     => 'div',
                    'classes'   => 'alert alert-light',
                    'wrapper'   => true,
                ),
                array(
                    'title'     => __( 'Dark', 'ekiline' ),
                    'block'     => 'div',
                    'classes'   => 'alert alert-dark',
                    'wrapper'   => true,
                ),
            ),
        ),
        
        array(
            'title' => __( 'Other (B4)', 'ekiline' ),
            'items' => array(
                array(
                    'title'     => __( 'Float Left', 'ekiline' ),
                    'selector'  => 'div, span, p',
                    'classes'   => 'float-left',
                ),
                array(
                    'title'     => __( 'Float Right', 'ekiline' ),
                    'selector'  => 'div, span, p',
                    'classes'   => 'float-right',
                ),
                array(
                    'title'     => __( 'Clearfix', 'ekiline' ),
                    'selector'  => 'div',
                    'classes'   => 'clearfix',
                ),            
                array(
                    'title'     => __( 'Blockquote', 'ekiline' ),
                    'selector'  => 'blockquote',
                    'classes'   => 'blockquote',
                ),
                array(
                    'title'     => __( 'Reverse Blockquote', 'ekiline' ),
                    'selector'  => 'blockquote',
                    'classes'   => 'blockquote text-right',
                ),
                array(
                    'title'     => __( 'Centered Blockquote', 'ekiline' ),
                    'selector'  => 'blockquote',
                    'classes'   => 'blockquote text-center',
                ),
                array(
                    'title'     => __( 'Blockquote Footer', 'ekiline' ),
                    'block'     => 'footer',
                    'classes'   => 'blockquote-footer',
                ),
                array(
                    'title'     => __( 'Rounded Image', 'ekiline' ),
                    'selector'  => 'img',
                    'classes'   => 'rounded',
                ),
                array(
                    'title'     => __( 'Circle Image', 'ekiline' ),
                    'selector'  => 'img',
                    'classes'   => 'rounded-circle',
                ),
                array(
                    'title'     => __( 'Thumbnail Image', 'ekiline' ),
                    'selector'  => 'img',
                    'classes'   => 'img-thumbnail',
                ),
                array(
                    'title'     => __( 'Responsive Image', 'ekiline' ),
                    'selector'  => 'img',
                    'classes'   => 'img-fluid',
                ),
            ),
        ),        
        
        array(
            'title' => __( 'Ekiline extra', 'ekiline' ),
            'items' => array(
                array(
                    'title'     => __( 'Iframe modal', 'ekiline' ),
                    'selector'  => 'a',
                    'classes'   => 'modal-iframe',
                ),
                array(
                    'title'     => __( 'Image modal', 'ekiline' ),
                    'selector'  => 'a',
                    'classes'   => 'modal-image',
                ),
                array(
                    'title'     => __( 'Tooltip', 'ekiline' ),
                    'selector'  => 'a',
                    'classes'   => 'tooltip-default',
                    'attributes' => array(
                        'title' => 'Tooltip text'
                    ),                                        
                ),
                array(
                    'title'     => __( 'Popover', 'ekiline' ),
                    'selector'  => 'a',
                    'classes'   => 'popover-default',
                    'attributes' => array(
                        'title' => 'Popover Title',
                        'data-content' => 'Popover Content',
                    ),                                        
                ),
                array(
                    'title'     => __( 'Popover dismiss', 'ekiline' ),
                    'selector'  => 'a',
                    'attributes' => array(
                        'tabindex' => '0',
                        'data-trigger' => 'focus',
                    ),                                        
                ),                                
                array(
                    'title'     => __( 'Popover Rich', 'ekiline' ),
                    'selector'  => 'a',
                    'classes'   => 'popover-rich',
                    'attributes' => array(
                        'title' => 'Popover Title',
                    ),                                        
                ),                                
                array(
                    'title'     => __( 'Show top', 'ekiline' ),
                    'selector'  => 'a',
                    'attributes' => array(
                        'data-placement' => 'top'
                    ),                                        
                ),
                array(
                    'title'     => __( 'Show right', 'ekiline' ),
                    'selector'  => 'a',
                    'attributes' => array(
                        'data-placement' => 'right'
                    ),                                        
                ),
                array(
                    'title'     => __( 'Show bottom', 'ekiline' ),
                    'selector'  => 'a',
                    'attributes' => array(
                        'data-placement' => 'bottom'
                    ),                                        
                ),
                array(
                    'title'     => __( 'Show left', 'ekiline' ),
                    'selector'  => 'a',
                    'attributes' => array(
                        'data-placement' => 'left'
                    ),                                        
                ),
                array(  
                    'title' => __('Hide content', 'ekiline'),  
                    'block' => 'div',  
                    'classes' => 'hide-content',
                ),                                
                                                
            ),
        ),                        
    
    );  
    
    // Insertar los arreglos
    // Insert the array, JSON ENCODED, into 'style_formats'
    
    $init_array['style_formats'] = json_encode( $style_formats );  
    
    return $init_array;  
  
} 
// Se agrega el filtro para sobreescribir las ordenes en el editor TinyMCE
// Attach callback to 'tiny_mce_before_init' 
add_filter( 'tiny_mce_before_init', 'ekiline_mce_before' ); 


/**
 * Oct 11 2017, añadir tareas al tinymce:
 * https://wordpress.stackexchange.com/questions/235020/how-to-add-insert-edit-link-button-in-custom-popup-tinymce-window 
 * Otro estudio:
 * https://jamesdigioia.com/add-button-pop-wordpresss-tinymce-editor/
 * Un tutorial:
 * https://dobsondev.com/2015/10/16/custom-tinymce-buttons-in-wordpress/
 * Otro ejemplo más elaborado
 * http://www.wpexplorer.com/wordpress-tinymce-tweaks/
 * https://github.com/SufferMyJoy/dobsondev-wordpress-tinymce-example
 **/
 
/**
 * Add a custom button to tinymce editor
 */
function custom_mce_buttons() {
    // Check if WYSIWYG is enabled
    if ( get_user_option( 'rich_editing' ) == 'true' ) {
        add_filter( 'mce_external_plugins', 'custom_tinymce_plugin' );
        add_filter( 'mce_buttons', 'register_mce_buttons' );
    }
}
add_action('admin_head', 'custom_mce_buttons');


// Add the path to the js file with the custom button function
function custom_tinymce_plugin( $plugin_array ) {
    // $plugin_array['custom_mce_button1'] = get_template_directory_uri() .'PATH_TO_THE_JS_FILE';
    // $plugin_array['custom_mce_button2'] = get_template_directory_uri() .'PATH_TO_THE_OTHER_JS_FILE';
    //$plugin_array['custom_mce_button1'] = get_template_directory_uri() .'/js/adminEditor.js';
    $plugin_array['custom_mce_button2'] = get_template_directory_uri() .'/js/adminSubgrid.js';
    $plugin_array['custom_mce_button3'] = get_template_directory_uri() .'/js/adminShowgrid.js';
    return $plugin_array;
}

// Register and add new button in the editor
function register_mce_buttons( $buttons ) {
    //array_push( $buttons, 'custom_mce_button1' );
    array_push( $buttons, 'custom_mce_button2' );
    array_push( $buttons, 'custom_mce_button3' );
    return $buttons;
}

