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
    $colors[] = array( 'slug'=>'text_color', 'default' => '#333333', 'label' => __( 'Color de texto', 'ekiline' ), 'description' => '' );
    $colors[] = array( 'slug'=>'links_color', 'default' => '#337ab7', 'label' => __( 'Color de links', 'ekiline' ), 'description' => '' );
    $colors[] = array( 'slug'=>'menu_color', 'default' => '', 'label' => __( 'Color de menu', 'ekiline' ), 'description' => __( 'Elige un color como base, el segundo es opcional para crear un degradado', 'ekiline' ) );
    $colors[] = array( 'slug'=>'menu_gradient', 'default' => '', 'label' => '', 'description' => '' );
    $colors[] = array( 'slug'=>'module_color', 'default' => '#eeeeee', 'label' => __( 'Color de modulos', 'ekiline' ), 'description' => '' );
    $colors[] = array( 'slug'=>'footer_color', 'default' => '#eeeeee', 'label' => __( 'Color de pie de pagina', 'ekiline' ), 'description' => '' );
    
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
    				'label'          => __( 'Invertir menu', 'ekiline' ),
    				'description'    => 'Cambia el contraste del menu a oscuro.',
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
            'label'    => __( 'Logotipo horizontal', 'ekiline' ),
            'description' => 'Esta es la imagen de tu marca que aparecera en el menu.',
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
    		'label'    => __( 'Video MP4, WEBM u OGV', 'ekiline' ),
        	'description' => '<b>Debes seleccionar una imagen de cabecera</b>.<br/>Elige un archivo de video <b>MP4, WEBM u OGV</b> de tu biblioteca. La imagen de cabecera se adaptara como fondo en caso de que los dispositivos no puedan reproducir video.',
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
    		'label'       => 'Altura de cabecera',
    		'description' => 'Especifica la altura de la cabecera, esto solo afectara tu homepage.',
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
    		'label'    => __( 'Logotipo header', 'ekiline' ),
    		'description' => 'Agrega tu logotipo si deseas que aparezca en el encabezado.',
    		'section'  => 'header_image', 
    		'settings' => 'ekiline_logo_min',
    		'priority' => 100,
    ) ) );
    
// mensaje de cabecera     
    $wp_customize->add_setting( 'ekiline_headertext', array( 
            'default' => '',
            //'transport' => 'none',
            'sanitize_callback'  => 'ekiline_sanitize_html'
    ) );
    
    $wp_customize->add_control( 'ekiline_headertext', array(
            'type'        => 'textarea',
            'label'    => __( 'Mensaje de cabecera', 'ekiline' ),
            'description' => 'Personaliza el mensaje de tu encabezado. De manera predeterminada se toma el nombre y descripicion de tu sitio',
            'section'  => 'header_image', 
            'settings' => 'ekiline_headertext',
            'priority' => 100,
    ) );    
    

// ancho de la pagina
    $wp_customize->add_section( 'ekiline_vista_section' , array(
            'title'       => __( 'Vista de tu sitio', 'ekiline' ),
            'priority'    => 50,
            'description' => 'Elige si quieres que el homepage, los listados o el articulo principal se desplieguen a todo lo ancho (fullwidth) o ajustada al centro.',
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
                'label' => 'Homepage',
                'section' => 'ekiline_vista_section',
                'choices' => array(
                    'container' => 'Ajustado',
                    'container-fluid' => 'A todo lo ancho',
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
                'label' => 'Categorias o listados',
                'section' => 'ekiline_vista_section',
                'choices' => array(
                    'container' => 'Ajustado',
                    'container-fluid' => 'A todo lo ancho',
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
                'label' => 'Paginas individuales',
                'section' => 'ekiline_vista_section',
                'choices' => array(
                    'container' => 'Ajustado',
                    'container-fluid' => 'A todo lo ancho',
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
                'label' => 'Sidebar izquierdo',
                'section' => 'ekiline_vista_section',
                'choices' => array(
                    'on' => 'Estatico',
                    'off' => 'Plegable',
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
                'label' => 'Sidebar derecho',
                'section' => 'ekiline_vista_section',
                'choices' => array(
                    'on' => 'Estatico',
                    'off' => 'Plegable',
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
                'label' => 'Top Menu extras',
            	'description' => __( 'Puedes fijar el menu, o hacer que se estacione con el scroll (affix).', 'ekiline' ),
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
   
    $wp_customize->add_section( 'ekiline_tracking_section' , array(
            'title'       => __( 'Optimizacion', 'ekiline' ),
            'priority'    => 150,
            'description' => __( 'Agrega los codigos de seguimiento que te ayudaran a optimizar y dar seguimiento a este sitio web.', 'ekiline' )
    ) );

    // Codigo de analytics  
    $wp_customize->add_setting( 
        'ekiline_analytics', array(
            'default' => '',
            'sanitize_callback' => 'ekiline_sanitize_html'
        ) );
    
    $wp_customize->add_control(
        'ekiline_analytics',
            array(
                'label'          => __( 'Trackeo de Google', 'ekiline' ),
                'description'    => 'Inserta el codigo de Google analytics, solo tu identificador (UA-XXXXX-XX)',
                'section'        => 'ekiline_tracking_section',
                'settings'       => 'ekiline_analytics',
                'type'           => 'text'
            )
        );   
        
    // Codigo de wmtools 
    $wp_customize->add_setting( 
        'ekiline_wmtools', array(
            'default' => '',
            'sanitize_callback' => 'ekiline_sanitize_html'
        ) );
    
    $wp_customize->add_control(
        'ekiline_wmtools',
            array(
                'label'          => __( 'Search console code', 'ekiline' ),
                'description'    => 'Add google site verification content value',
                'section'        => 'ekiline_tracking_section',
                'settings'       => 'ekiline_wmtools',
                'type'           => 'text'
            )
        );       
        
    // Codigo de bing 
    $wp_customize->add_setting( 
        'ekiline_wmbing', array(
            'default' => '',
            'sanitize_callback' => 'ekiline_sanitize_html'
        ) );
    
    $wp_customize->add_control(
        'ekiline_wmbing',
            array(
                'label'          => __( 'Bing web master tools', 'ekiline' ),
                'description'    => 'Add msvalidate content value',
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
                    'label'          => __( 'Optimizar el codigo HTML', 'ekiline' ),
                    'description'    => __( 'Minifica el codigo para optimizar tu sitio.', 'ekiline' ),
                    'section'        => 'ekiline_tracking_section',
                    'settings'       => 'ekiline_minify',
                    'type'           => 'checkbox',
            )
    );               
    
    // Servicios Ekiline
         
    $wp_customize->add_section( 'ekiline_services' , array(
    		'title'       => __( 'Servicios varios', 'ekiline' ),
    		'priority'    => 160,
    		'description' => __( 'Caracteristicas agregadas para tu sitio.', 'ekiline' )
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
    				'label'          => __( 'Poner mi sitio en mantenimiento', 'ekiline' ),
    				'description'    => __( 'Muestra una pantalla de mantenimiento a tus usuarios.', 'ekiline' ),
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
                    'label'          => __( 'Demarcar los modulos', 'ekiline' ),
                    'description'    => 'Muestra lineas de division para apoyarte al personalizar tu sitio',
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
                    'label'          => __( 'Cancelar los comentarios en los medios', 'ekiline' ),
                    'description'    => 'Cancela los comentarios que se generan por cada imagen o video o archivo de tu biblioteca de medios.',
                    'section'        => 'ekiline_services',
                    'settings'       => 'ekiline_mediacomment',
                    'type'           => 'checkbox',
            )
    );  
    
    // Ekiline social
         
    $wp_customize->add_section( 'ekiline_social' , array(
            'title'       => __( 'Informacion social', 'ekiline' ),
            'priority'    => 170,
            'description' => __( 'Llena cada campo para habilitar prestaciones basicas para la difución de tu sitio', 'ekiline' )
    ) );

    // Facebook 
    $wp_customize->add_setting( 
        'ekiline_fbProf', array(
            'default' => '',
            'sanitize_callback' => 'ekiline_sanitize_html'
        ) );
    
    $wp_customize->add_control(
        'ekiline_fbProf',
            array(
                'label'          => __( 'Url de facebook', 'ekiline' ),
                'description'    => 'Escribe la dirección url de tu cuenta',
                'section'        => 'ekiline_social',
                'settings'       => 'ekiline_fbProf',
                'type'           => 'text'
            )
        );                    
                
    // Twitter 
    $wp_customize->add_setting( 
        'ekiline_twProf', array(
            'default' => '',
            'sanitize_callback' => 'ekiline_sanitize_html'
        ) );
    
    $wp_customize->add_control(
        'ekiline_twProf',
            array(
                'label'          => __( 'Cuenta de twitter', 'ekiline' ),
                'description'    => 'Escribe la dirección url de tu cuenta',
                'section'        => 'ekiline_social',
                'settings'       => 'ekiline_twProf',
                'type'           => 'text'
            )
        );      

    // Google plus 
    $wp_customize->add_setting( 
        'ekiline_gpProf', array(
            'default' => '',
            'sanitize_callback' => 'ekiline_sanitize_html'
        ) );
    
    $wp_customize->add_control(
        'ekiline_gpProf',
            array(
                'label'          => __( 'Cuenta de google+', 'ekiline' ),
                'description'    => 'Escribe la dirección url de tu cuenta',
                'section'        => 'ekiline_social',
                'settings'       => 'ekiline_gpProf',
                'type'           => 'text'
            )
        );            
                               
    // Linkedin 
    $wp_customize->add_setting( 
        'ekiline_inProf', array(
            'default' => '',
            'sanitize_callback' => 'ekiline_sanitize_html'
        ) );
    
    $wp_customize->add_control(
        'ekiline_inProf',
            array(
                'label'          => __( 'Cuenta de twitter', 'ekiline' ),
                'description'    => 'Escribe la dirección url de tu cuenta',
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


