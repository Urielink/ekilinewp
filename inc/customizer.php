<?php
/**
 * ekiline Theme Customizer.
 *
 * @package ekiline
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function ekiline_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'ekiline_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function ekiline_customize_preview_js() {
	wp_enqueue_script( 'ekiline_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'ekiline_customize_preview_js' );


/** Personalizar el tema desde las opciones, logo, fondo, etc 
 *  Los controladores deben complementarse de callbacks para sanitizar el dato.
 *  muestra: https://github.com/WPTRT/code-examples/blob/master/customizer/sanitization-callbacks.php
 **/

function ekiline_theme_customizer( $wp_customize ) {
    
// colores  v1, 23 abril, no se sanitiza mi array.
    $colors = array();
    $colors[] = array( 'slug'=>'text_color', 'default' => '#333333', 'label' => __( 'Text color', 'ekiline' ), 'description' => '' );
    $colors[] = array( 'slug'=>'links_color', 'default' => '#337ab7', 'label' => __( 'Links color', 'ekiline' ), 'description' => '' );
    $colors[] = array( 'slug'=>'menu_color', 'default' => '', 'label' => __( 'Menu color', 'ekiline' ), 'description' => __( 'Choose a base color, add second color for make a gradient', 'ekiline' ) );
    $colors[] = array( 'slug'=>'menu_gradient', 'default' => '', 'label' => '', 'description' => '' );
    $colors[] = array( 'slug'=>'module_color', 'default' => '#eeeeee', 'label' => __( 'Module colors', 'ekiline' ), 'description' => '' );
    $colors[] = array( 'slug'=>'footer_color', 'default' => '#eeeeee', 'label' => __( 'Footer colors', 'ekiline' ), 'description' => '' );
    
    foreach($colors as $color)
    {
        // SETTINGS
        $wp_customize->add_setting( 
        		$color['slug'], array( 
        				'default' => $color['default'], 
        				'type' => 'option', 
        				'capability' => 'edit_theme_options',
        				'sanitize_callback' => 'sanitize_hex_color' )
        		);

        // CONTROLS
        $wp_customize->add_control( 
        		new WP_Customize_Color_Control( 
        				$wp_customize, $color['slug'], 
        				array( 'label' => $color['label'], 
                				'description' => $color['description'], 
        						'section' => 'colors', 
        						'settings' => $color['slug'] 
        				)
        		)
        );
    }

    
    // Invertir el menu
    $wp_customize->add_setting(
    		'ekiline_inversemenu', array(
    				'default' => '',
    				'sanitize_callback' => 'ekiline_sanitize_checkbox'
    		) );
    
    $wp_customize->add_control(
    		'ekiline_inversemenu',
    		array(
    				'label'          => __( 'Inverse menu', 'ekiline' ),
    				'description'    => __( 'Change menu from lighten to darken', 'ekiline' ),
    				'section'        => 'colors',
    				'settings'       => 'ekiline_inversemenu',
    				'type'           => 'checkbox'
    		)
    );    

// agregar un controlador: https://codex.wordpress.org/Class_Reference/WP_Customize_Control  
// https://make.wordpress.org/core/2014/07/08/customizer-improvements-in-4-0/
// https://developer.wordpress.org/themes/advanced-topics/customizer-api/
// http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/

    $wp_customize->add_setting( 
            'ekiline_logo_max', array(
                    'default' => '',
                    'sanitize_callback' => 'ekiline_sanitize_image'
            ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ekiline_logo_max', array(
            'label'    => __( 'Horizontal logo', 'ekiline' ),
            'description' => __( 'This show your brand in menu', 'ekiline' ),
            'section'  => 'title_tagline', // esta seccion corresponde a una predeterminada.
            'settings' => 'ekiline_logo_max',
            'priority' => 100,
    ) ) );
        
    
    $wp_customize->add_setting( 
            'ekiline_video', array(
                    'default' => '',
                    'sanitize_callback' => 'ekiline_sanitize_video'
            ) );
    
    $wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, 'ekiline_video', array(
    		'label'    => __( 'Upload video to header', 'ekiline' ),
        	'description' => __( 'Recommended formats: MP4, WEBM or OGV, your header image conserves as video background or replacement', 'ekiline' ),
    		'section'  => 'header_image',
    		'settings' => 'ekiline_video',
            'priority'    => 90,
    ) ) );   

    // Controlador para estalecer la altura de la imagen de cabecera
    
    $wp_customize->add_setting( 'ekiline_range_header', array( 
			'default' => '30',
			'sanitize_callback'  => 'ekiline_sanitize_number_range'
    ) );

    $wp_customize->add_control( 'ekiline_range_header', array(
    		'type'        => 'range',
    		'priority'    => 10,
    		'section'     => 'header_image',
    		'label'       => __( 'Header image height', 'ekiline' ),
    		'description' => __( 'Choose from a standard Jumbotron size to a Cover full display format (only in homepage)', 'ekiline' ),
    		'input_attrs' => array(
    				'min'   => 30,
    				'max'   => 100,
    				'step'  => 10,
    		),
	) );    
    
    $wp_customize->add_setting( 'ekiline_logo_min', array( 
            'default' => '',
            'sanitize_callback'  => 'ekiline_sanitize_image'
    ) );
    
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ekiline_logo_min', array(
    		'label'    => __( 'Header logo', 'ekiline' ),
    		'description' => __( 'Add your brand in your image header', 'ekiline' ),
    		'section'  => 'header_image', 
    		'settings' => 'ekiline_logo_min',
    		'priority' => 100,
    ) ) );
    
// mensaje de cabecera     
    $wp_customize->add_setting( 'ekiline_headertext', array( 
            'default' => '',
            'transport' => 'none',
            'sanitize_callback'  => 'ekiline_sanitize_html'
    ) );
    
    $wp_customize->add_control( 'ekiline_headertext', array(
            'type'        => 'textarea',
            'label'    => __( 'Header message', 'ekiline' ),
            'description' => __( 'Customize the text in your heading image' , 'ekiline' ),
            'section'  => 'header_image', 
            'settings' => 'ekiline_headertext',
            'priority' => 100,
    ) );    
    

// ancho de la pagina
    $wp_customize->add_section( 'ekiline_vista_section' , array(
            'title'       => __( 'Site view', 'ekiline' ),
            'priority'    => 50,
            'description' => __( 'Allow fullwidth or center the content of your website by content type: homepage, categories or single content' , 'ekiline' ),
    ) );
    
        $wp_customize->add_setting(
            'ekiline_anchoHome', array(
                    'default' => 'container',
                    'sanitize_callback' => 'ekiline_sanitize_select'
                ) );
        
        $wp_customize->add_control(
            'ekiline_anchoHome',
            array(
                'type' => 'radio',
                'label' => __( 'Homepage', 'ekiline' ),
                'section' => 'ekiline_vista_section',
                'choices' => array(
                    'container' => __( 'Centered', 'ekiline' ),
                    'container-fluid' => __( 'Fullwidth', 'ekiline' ),
                ),
            )
        );      
        
        $wp_customize->add_setting(
            'ekiline_anchoCategory', array(
                    'default' => 'container',
                    'sanitize_callback' => 'ekiline_sanitize_select'
                ) );
        
        $wp_customize->add_control(
            'ekiline_anchoCategory',
            array(
                'type' => 'radio',
                'label' => __( 'Categories', 'ekiline' ),
                'section' => 'ekiline_vista_section',
                'choices' => array(
                    'container' => __( 'Centered', 'ekiline' ),
                    'container-fluid' => __( 'Fullwidth', 'ekiline' ),
                ),
            )
        ); 
        
        $wp_customize->add_setting(
            'ekiline_anchoSingle', array(
                    'default' => 'container',
                    'sanitize_callback' => 'ekiline_sanitize_select'
                ) );
        
        $wp_customize->add_control(
            'ekiline_anchoSingle',
            array(
                'type' => 'radio',
                'label' => __( 'Single pages', 'ekiline' ),
                'section' => 'ekiline_vista_section',
                'choices' => array(
                    'container' => __( 'Centered', 'ekiline' ),
                    'container-fluid' => __( 'Fullwidth', 'ekiline' ),
                ),
            )
        );         
        
        // ocultar y mostrar sidebars

        $wp_customize->add_setting(
            'ekiline_sidebarLeft', array(
                    'default' => 'on',
                    'sanitize_callback' => 'ekiline_sanitize_select'
                ) );
        
        $wp_customize->add_control(
            'ekiline_sidebarLeft',
            array(
                'type' => 'radio',
                'label' => __( 'Left sidebar', 'ekiline' ),
                'section' => 'ekiline_vista_section',
                'choices' => array(
                    'on' => __( 'Static', 'ekiline' ),
                    'off' => __( 'Toggle', 'ekiline' ),
                ),
            )
        );     
        
        $wp_customize->add_setting(
            'ekiline_sidebarRight', array(
                    'default' => 'on',
                    'sanitize_callback' => 'ekiline_sanitize_select'
                ) );
        
        $wp_customize->add_control(
            'ekiline_sidebarRight',
            array(
                'type' => 'radio',
                'label' => __( 'Right sidebar', 'ekiline' ),
                'section' => 'ekiline_vista_section',
                'choices' => array(
                    'on' => __( 'Static', 'ekiline' ),
                    'off' => __( 'Toggle', 'ekiline' ),
                ),
            )
        );              

	// Atributos especiales a los menus.

        $wp_customize->add_setting(
            'ekiline_topmenuSettings', array(
                    'default' => '0',
                    'sanitize_callback' => 'ekiline_sanitize_select'
                ) );
        
        $wp_customize->add_control(
            'ekiline_topmenuSettings',
            array(
                'type' => 'select',
                'label' => __( 'Top menu settings', 'ekiline' ),
            	'description' => __( 'Add behaviors for your menu, fix to top, fix to bottom or affix with scroll', 'ekiline' ),
            	'section' => 'menu_locations',
            	'priority'    => 100,
            	'choices' => array(
                    '0' => __( 'Default', 'ekiline' ),
                    '1' => __( 'Fixed top', 'ekiline' ),
                	'2' => __( 'Fixed bottom', 'ekiline' ),
                	'3' => __( 'Fix to scroll', 'ekiline' ),
                ),
            )
        );   
        

    // Optimizacion, codigos de seguimiento
   
    $wp_customize->add_section( 'ekiline_tracking_section' , array(
            'title'       => __( 'Site Optimization', 'ekiline' ),
            'priority'    => 150,
            'description' => __( 'Add tracking codes and improves site performance', 'ekiline' )
    ) );

    // Codigo de analytics  
    $wp_customize->add_setting( 
        'ekiline_analytics', array(
            'default' => '',
            'transport' => 'none',
            'sanitize_callback' => 'ekiline_sanitize_html'
        ) );
    
    $wp_customize->add_control(
        'ekiline_analytics',
            array(
                'label'          => __( 'Google Analytics', 'ekiline' ),
                'description'    => __( 'Add Google Analytics code, only your identifier ( UA-XXXXX-XX )', 'ekiline' ),
                'section'        => 'ekiline_tracking_section',
                'settings'       => 'ekiline_analytics',
                'type'           => 'text'
            )
        );   
        
    // Codigo de wmtools 
    $wp_customize->add_setting( 
        'ekiline_wmtools', array(
            'default' => '',
            'transport' => 'none',
            'sanitize_callback' => 'ekiline_sanitize_html'
        ) );
    
    $wp_customize->add_control(
        'ekiline_wmtools',
            array(
                'label'          => __( 'Search Console', 'ekiline' ),
                'description'    => __( 'Add google site verification, only content="value"', 'ekiline' ),
                'section'        => 'ekiline_tracking_section',
                'settings'       => 'ekiline_wmtools',
                'type'           => 'text'
            )
        );       
        
    // Codigo de bing 
    $wp_customize->add_setting( 
        'ekiline_wmbing', array(
            'default' => '',
            'transport' => 'none',
            'sanitize_callback' => 'ekiline_sanitize_html'
        ) );
    
    $wp_customize->add_control(
        'ekiline_wmbing',
            array(
                'label'          => __( 'Bing web master tools', 'ekiline' ),
                'description'    => __( 'Add msvalidate content="value"', 'ekiline' ),
                'section'        => 'ekiline_tracking_section',
                'settings'       => 'ekiline_wmbing',
                'type'           => 'text'
            )
        );              
        
            
        
    // Minificar el codigo
    $wp_customize->add_setting(
            'ekiline_minify', array(
                    'default' => '',
                    'sanitize_callback' => 'ekiline_sanitize_checkbox'
            ) );
    
    $wp_customize->add_control(
            'ekiline_minify',
            array(
                    'label'          => __( 'Optimize HTML', 'ekiline' ),
                    'description'    => __( 'Minify HTML output for site speed', 'ekiline' ),
                    'section'        => 'ekiline_tracking_section',
                    'settings'       => 'ekiline_minify',
                    'type'           => 'checkbox',
            )
    );               
    
    // Servicios Ekiline
         
    $wp_customize->add_section( 'ekiline_services' , array(
    		'title'       => __( 'Other services', 'ekiline' ),
    		'priority'    => 160,
    		'description' => __( 'Special features for your site', 'ekiline' )
    ) );
    
    // Poner en mantenimiento
    $wp_customize->add_setting(
    		'ekiline_maintenance', array(
    				'default' => '',
    				'sanitize_callback' => 'ekiline_sanitize_checkbox'
    		) );
    
    $wp_customize->add_control(
    		'ekiline_maintenance',
    		array(
    				'label'          => __( 'Site over maintenance', 'ekiline' ),
    				'description'    => __( 'Show a maintenance page to your visitors', 'ekiline' ),
    				'section'        => 'ekiline_services',
    				'settings'       => 'ekiline_maintenance',
    				'type'           => 'checkbox',
    		)
    );    

    // Poner en modo wireframe
    $wp_customize->add_setting(
            'ekiline_wireframe', array(
                    'default' => '',
                    'sanitize_callback' => 'ekiline_sanitize_checkbox'
            ) );
    
    $wp_customize->add_control(
            'ekiline_wireframe',
            array(
                    'label'          => __( 'Wireframe mode', 'ekiline' ),
                    'description'    => __( 'Show bootstrap style boxes to help you in the design process', 'ekiline' ),
                    'section'        => 'ekiline_services',
                    'settings'       => 'ekiline_wireframe',
                    'type'           => 'checkbox',
            )
    );   
    

    // Cancelar los comentarios en las imagenes
    $wp_customize->add_setting(
            'ekiline_mediacomment', array(
                    'default' => '',
                    'sanitize_callback' => 'ekiline_sanitize_checkbox'
            ) );
    
    $wp_customize->add_control(
            'ekiline_mediacomment',
            array(
                    'label'          => __( 'Cancel comments in attachments', 'ekiline' ),
                    'description'    => __( 'Yo can do this each attachment in media library or hiding all with this option' , 'ekiline' ),
                    'section'        => 'ekiline_services',
                    'settings'       => 'ekiline_mediacomment',
                    'type'           => 'checkbox',
            )
    );  
    
    // Ekiline social
         
    $wp_customize->add_section( 'ekiline_social' , array(
            'title'       => __( 'Social media', 'ekiline' ),
            'priority'    => 170,
            'description' => __( 'Set each field to show and allow basic social media features', 'ekiline' )
    ) );

    // Facebook 
    $wp_customize->add_setting( 
        'ekiline_fbProf', array(
            'default' => '',
            'transport' => 'none',
            'sanitize_callback' => 'ekiline_sanitize_html'
        ) );
    
    $wp_customize->add_control(
        'ekiline_fbProf',
            array(
                'label'          => __( 'Facebook', 'ekiline' ),
                'description'    => __( 'Add your Facebook page url','ekiline' ),
                'section'        => 'ekiline_social',
                'settings'       => 'ekiline_fbProf',
                'type'           => 'text'
            )
        );                    
                
    // Twitter 
    $wp_customize->add_setting( 
        'ekiline_twProf', array(
            'default' => '',
            'transport' => 'none',
            'sanitize_callback' => 'ekiline_sanitize_html'
        ) );
    
    $wp_customize->add_control(
        'ekiline_twProf',
            array(
                'label'          => __( 'Twitter', 'ekiline' ),
                'description'    => __( 'Add your Twitter name (@name)','ekiline' ),
                'section'        => 'ekiline_social',
                'settings'       => 'ekiline_twProf',
                'type'           => 'text'
            )
        );      

    // Google plus 
    $wp_customize->add_setting( 
        'ekiline_gpProf', array(
            'default' => '',
            'transport' => 'none',
            'sanitize_callback' => 'ekiline_sanitize_html'
        ) );
    
    $wp_customize->add_control(
        'ekiline_gpProf',
            array(
                'label'          => __( 'Google Plus', 'ekiline' ),
                'description'    => __( 'Add your Google Plus page url','ekiline' ),
                'section'        => 'ekiline_social',
                'settings'       => 'ekiline_gpProf',
                'type'           => 'text'
            )
        );            
                               
    // Linkedin 
    $wp_customize->add_setting( 
        'ekiline_inProf', array(
            'default' => '',
            'transport' => 'none',
            'sanitize_callback' => 'ekiline_sanitize_html'
        ) );
    
    $wp_customize->add_control(
        'ekiline_inProf',
            array(
                'label'          => __( 'Linkedin', 'ekiline' ),
                'description'    => __( 'Add your Linkedin page url','ekiline' ),
                'section'        => 'ekiline_social',
                'settings'       => 'ekiline_inProf',
                'type'           => 'text'
            )
        );              
        
}
add_action('customize_register', 'ekiline_theme_customizer');

/* Scripts de saneado */

function ekiline_sanitize_checkbox( $checked ) {
    // Boolean check.
    return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

function ekiline_sanitize_html( $html ) {
    return wp_filter_post_kses( $html );
}

function ekiline_sanitize_image( $image, $setting ) {

    /*
     * Array of valid image file types.
     *
     * The array includes image mime types that are included in wp_get_mime_types()
     */
    $mimes = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif'          => 'image/gif',
        'png'          => 'image/png',
        'bmp'          => 'image/bmp',
        'tif|tiff'     => 'image/tiff',
        'ico'          => 'image/x-icon'
    );

    // Return an array with file extension and mime_type.
    $file = wp_check_filetype( $image, $mimes );

    // If $image has a valid mime_type, return it; otherwise, return the default.
    return ( $file['ext'] ? $image : $setting->default );
}

function ekiline_sanitize_video( $video, $setting ) {

    $mimes = array(
        'asf|asx'       => 'video/x-ms-asf',
        'wmv'           => 'video/x-ms-wmv',
        'wmx'           => 'video/x-ms-wmx',
        'wm'            => 'video/x-ms-wm',
        'avi'           => 'video/avi',
        'divx'          => 'video/divx',
        'flv'           => 'video/x-flv',
        'mov|qt'        => 'video/quicktime',
        'mpeg|mpg|mpe'  => 'video/mpeg',
        'mp4|m4v'       => 'video/mp4',
        'ogv'           => 'video/ogg',
        'webm'          => 'video/webm',
        'mkv'           => 'video/x-matroska'
    );

    $file = wp_check_filetype( $video, $mimes );

    return ( $file['ext'] ? $video : $setting->default );
}


function ekiline_sanitize_number_range( $number, $setting ) {
    
    // Ensure input is an absolute integer.
    $number = absint( $number );
    
    // Get the input attributes associated with the setting.
    $atts = $setting->manager->get_control( $setting->id )->input_attrs;
    
    // Get minimum number in the range.
    $min = ( isset( $atts['min'] ) ? $atts['min'] : $number );
    
    // Get maximum number in the range.
    $max = ( isset( $atts['max'] ) ? $atts['max'] : $number );
    
    // Get step.
    $step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );
    
    // If the number is within the valid range, return it; otherwise, return the default
    return ( $min <= $number && $number <= $max && is_int( $number / $step ) ? $number : $setting->default );
}

function ekiline_sanitize_select( $input, $setting ) {
    
    // Ensure input is a slug.
    $input = sanitize_key( $input );
    
    // Get list of choices from the control associated with the setting.
    $choices = $setting->manager->get_control( $setting->id )->choices;
    
    // If the input is a valid key, return it; otherwise, return the default.
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}


