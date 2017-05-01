<?php
/**
 * ekilinewp Theme Customizer.
 *
 * @package ekilinewp
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function ekilinewp_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'ekilinewp_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function ekilinewp_customize_preview_js() {
	wp_enqueue_script( 'ekilinewp_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'ekilinewp_customize_preview_js' );


/** Personalizar el tema desde las opciones, logo, fondo, etc 
 *  Los controladores deben complementarse de callbacks para sanitizar el dato.
 *  muestra: https://github.com/WPTRT/code-examples/blob/master/customizer/sanitization-callbacks.php
 **/

function ekilinewp_theme_customizer( $wp_customize ) {
    
// colores  v1, 23 abril, no se sanitiza mi array.
    $colors = array();
    $colors[] = array( 'slug'=>'text_color', 'default' => '#333333', 'label' => __( 'Color de texto', 'ekilinewp' ) );
    $colors[] = array( 'slug'=>'links_color', 'default' => '#337ab7', 'label' => __( 'Color de links', 'ekilinewp' ) );
    $colors[] = array( 'slug'=>'module_color', 'default' => '#eeeeee', 'label' => __( 'Color de modulos', 'ekilinewp' ) );
    $colors[] = array( 'slug'=>'menu_color', 'default' => '#f8f8f8', 'label' => __( 'Color de menu', 'ekilinewp' ) );
    $colors[] = array( 'slug'=>'footer_color', 'default' => '#f8f8f8', 'label' => __( 'Color de pie de pagina', 'ekilinewp' ) );
    
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
        						'section' => 'colors', 
        						'settings' => $color['slug'] 
        				)
        		)
        );
    }

    
    // Invertir el menu
    $wp_customize->add_setting(
    		'ekilinewp_inversemenu', array(
    				'default' => '',
    				'sanitize_callback' => 'ekilinewp_sanitize_checkbox'
    		) );
    
    $wp_customize->add_control(
    		'ekilinewp_inversemenu',
    		array(
    				'label'          => __( 'Textos claros en menu y footer', 'ekilinewp' ),
    				'description'    => 'Habilita esta opcion en caso de utilizar un menu y un footer oscuros.',
    				'section'        => 'colors',
    				'settings'       => 'ekilinewp_inversemenu',
    				'type'           => 'checkbox'
    		)
    );    

// agregar un controlador: https://codex.wordpress.org/Class_Reference/WP_Customize_Control  
// https://make.wordpress.org/core/2014/07/08/customizer-improvements-in-4-0/
// https://developer.wordpress.org/themes/advanced-topics/customizer-api/
// http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/

    $wp_customize->add_setting( 
            'ekilinewp_logo_max', array(
                    'default' => '',
                    'sanitize_callback' => 'ekilinewp_sanitize_image'
            ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ekilinewp_logo_max', array(
            'label'    => __( 'Logotipo horizontal', 'ekilinewp' ),
            'description' => 'Esta es la imagen de tu marca que aparecera en el menu.',
            'section'  => 'title_tagline', // esta seccion corresponde a una predeterminada.
            'settings' => 'ekilinewp_logo_max',
            'priority' => 100,
    ) ) );
        
 // video
//     $wp_customize->add_section( 'ekilinewp_video_portada' , array(
//             'title'       => __( 'Video de cabecera', 'ekilinewp' ),
//             'priority'    => 90,
//             'description' => '<b>Debes tener una imagen de cabecera</b>.<br/>Elige un archivo de video <b>MP4, WEBM u OGV</b> de tu biblioteca. La imagen de cabecera se adaptara como fondo en caso de que los dispositivos no puedan reproducir video.',
//     ) );
    
//     $wp_customize->add_setting( 'ekilinewp_video' );
    
//     $wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, 'ekilinewp_video', array(
//             'label'    => __( 'Video MP4, WEBM u OGV', 'ekilinewp' ),
//             'section'  => 'ekilinewp_video_portada',
//             'settings' => 'ekilinewp_video',
//     ) ) );  

    // video
    
    $wp_customize->add_setting( 
            'ekilinewp_video', array(
                    'default' => '',
                    'sanitize_callback' => 'ekilinewp_sanitize_video'
            ) );
    
    $wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, 'ekilinewp_video', array(
    		'label'    => __( 'Video MP4, WEBM u OGV', 'ekilinewp' ),
        	'description' => '<b>Debes tener seleccionar una imagen de cabecera</b>.<br/>Elige un archivo de video <b>MP4, WEBM u OGV</b> de tu biblioteca. La imagen de cabecera se adaptara como fondo en caso de que los dispositivos no puedan reproducir video.',
    		'section'  => 'header_image',
    		'settings' => 'ekilinewp_video',
            'priority'    => 90,
    ) ) );   

    // Controlador para estalecer la altura de la imagen de cabecera
    
    $wp_customize->add_setting( 'ekilinewp_range_header', array( 
			'default' => '30',
			'sanitize_callback'  => 'ekilinewp_sanitize_number_range'
    ) );

    $wp_customize->add_control( 'ekilinewp_range_header', array(
    		'type'        => 'range',
    		'priority'    => 10,
    		'section'     => 'header_image',
    		'label'       => 'Altura de cabecera',
    		'description' => 'Especifica la altura de la cabecera, esto solo afectara tu homepage.',
    		'input_attrs' => array(
    				'min'   => 30,
    				'max'   => 100,
    				'step'  => 10,
    		),
	) );    
    
    $wp_customize->add_setting( 'ekilinewp_logo_min', array( 
            'default' => '',
            'sanitize_callback'  => 'ekilinewp_sanitize_image'
    ) );
    
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ekilinewp_logo_min', array(
    		'label'    => __( 'Logotipo header', 'ekilinewp' ),
    		'description' => 'Agrega tu logotipo si deseas que aparezca en el encabezado.',
    		'section'  => 'header_image', 
    		'settings' => 'ekilinewp_logo_min',
    		'priority' => 100,
    ) ) );
    

// ancho de la pagina
    $wp_customize->add_section( 'ekilinewp_vista_section' , array(
            'title'       => __( 'Vista de tu sitio', 'ekilinewp' ),
            'priority'    => 50,
            'description' => 'Elige si quieres que el homepage, los listados o el articulo principal se desplieguen a todo lo ancho (fullwidth) o ajustada al centro.',
    ) );
    
        $wp_customize->add_setting(
            'ekilinewp_anchoHome', array(
                    'default' => 'container',
                    'sanitize_callback' => 'ekilinewp_sanitize_select'
                ) );
        
        $wp_customize->add_control(
            'ekilinewp_anchoHome',
            array(
                'type' => 'radio',
                'label' => 'Homepage',
                'section' => 'ekilinewp_vista_section',
                'choices' => array(
                    'container' => 'Ajustado',
                    'container-fluid' => 'A todo lo ancho',
                ),
            )
        );      
        
        $wp_customize->add_setting(
            'ekilinewp_anchoCategory', array(
                    'default' => 'container',
                    'sanitize_callback' => 'ekilinewp_sanitize_select'
                ) );
        
        $wp_customize->add_control(
            'ekilinewp_anchoCategory',
            array(
                'type' => 'radio',
                'label' => 'Categorias o listados',
                'section' => 'ekilinewp_vista_section',
                'choices' => array(
                    'container' => 'Ajustado',
                    'container-fluid' => 'A todo lo ancho',
                ),
            )
        ); 
        
        $wp_customize->add_setting(
            'ekilinewp_anchoSingle', array(
                    'default' => 'container',
                    'sanitize_callback' => 'ekilinewp_sanitize_select'
                ) );
        
        $wp_customize->add_control(
            'ekilinewp_anchoSingle',
            array(
                'type' => 'radio',
                'label' => 'Paginas individuales',
                'section' => 'ekilinewp_vista_section',
                'choices' => array(
                    'container' => 'Ajustado',
                    'container-fluid' => 'A todo lo ancho',
                ),
            )
        );         
        
        // ocultar y mostrar sidebars

        $wp_customize->add_setting(
            'ekilinewp_sidebarLeft', array(
                    'default' => 'on',
                    'sanitize_callback' => 'ekilinewp_sanitize_select'
                ) );
        
        $wp_customize->add_control(
            'ekilinewp_sidebarLeft',
            array(
                'type' => 'radio',
                'label' => 'Sidebar izquierdo',
                'section' => 'ekilinewp_vista_section',
                'choices' => array(
                    'on' => 'Estatico',
                    'off' => 'Plegable',
                ),
            )
        );     
        
        $wp_customize->add_setting(
            'ekilinewp_sidebarRight', array(
                    'default' => 'on',
                    'sanitize_callback' => 'ekilinewp_sanitize_select'
                ) );
        
        $wp_customize->add_control(
            'ekilinewp_sidebarRight',
            array(
                'type' => 'radio',
                'label' => 'Sidebar derecho',
                'section' => 'ekilinewp_vista_section',
                'choices' => array(
                    'on' => 'Estatico',
                    'off' => 'Plegable',
                ),
            )
        );              

	// Atributos especiales a los menus.

        $wp_customize->add_setting(
            'ekilinewp_topmenuSettings', array(
                    'default' => '0',
                    'sanitize_callback' => 'ekilinewp_sanitize_select'
                ) );
        
        $wp_customize->add_control(
            'ekilinewp_topmenuSettings',
            array(
                'type' => 'select',
                'label' => 'Top Menu extras',
            	'description' => __( 'Puedes fijar el menu, o hacer que se estacione con el scroll (affix).', 'ekilinewp' ),
            	'section' => 'menu_locations',
            	'priority'    => 100,
            	'choices' => array(
                    '0' => 'Normal',
                    '1' => 'Fijo superior',
                	'2' => 'Fijo inferior',
                	'3' => 'Fijo al scroll (affix)',
                ),
            )
        );   
        

    // Optimizacion, codigos de seguimiento
   
    $wp_customize->add_section( 'ekilinewp_tracking_section' , array(
            'title'       => __( 'Optimizacion', 'ekilinewp' ),
            'priority'    => 150,
            'description' => __( 'Agrega los codigos de seguimiento que te ayudaran a optimizar y dar seguimiento a este sitio web.', 'ekilinewp' )
    ) );

    // Codigo de analytics  
    $wp_customize->add_setting( 
        'ekilinewp_analytics', array(
            'default' => '',
            'sanitize_callback' => 'ekilinewp_sanitize_html'
        ) );
    
    $wp_customize->add_control(
        'ekilinewp_analytics',
            array(
                'label'          => __( 'Trackeo de Google', 'ekilinewp' ),
                'description'    => 'Inserta el codigo de Google analytics, solo tu identificador (UA-XXXXX-XX)',
                'section'        => 'ekilinewp_tracking_section',
                'settings'       => 'ekilinewp_analytics',
                'type'           => 'text'
            )
        );      
    
    // Servicios varios
     
    $wp_customize->add_section( 'ekilinewp_services' , array(
    		'title'       => __( 'Servicios extra', 'ekilinewp' ),
    		'priority'    => 160,
    		'description' => __( 'Caracteristicas agregadas para tu sitio.', 'ekilinewp' )
    ) );
    
    // Poner en mantenimiento
    $wp_customize->add_setting(
    		'ekilinewp_maintenance', array(
    				'default' => '',
    				'sanitize_callback' => 'ekilinewp_sanitize_checkbox'
    		) );
    
    $wp_customize->add_control(
    		'ekilinewp_maintenance',
    		array(
    				'label'          => __( 'Poner mi sitio en mantenimiento', 'ekilinewp' ),
    				'description'    => 'Si es necesario ',
    				'section'        => 'ekilinewp_services',
    				'settings'       => 'ekilinewp_maintenance',
    				'type'           => 'checkbox',
    		)
    );    

        
}
add_action('customize_register', 'ekilinewp_theme_customizer');

/* Scripts de saneado */

function ekilinewp_sanitize_checkbox( $checked ) {
    // Boolean check.
    return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

function ekilinewp_sanitize_html( $html ) {
    return wp_filter_post_kses( $html );
}

function ekilinewp_sanitize_image( $image, $setting ) {

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

function ekilinewp_sanitize_video( $video, $setting ) {

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


function ekilinewp_sanitize_number_range( $number, $setting ) {
    
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

function ekilinewp_sanitize_select( $input, $setting ) {
    
    // Ensure input is a slug.
    $input = sanitize_key( $input );
    
    // Get list of choices from the control associated with the setting.
    $choices = $setting->manager->get_control( $setting->id )->choices;
    
    // If the input is a valid key, return it; otherwise, return the default.
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}


