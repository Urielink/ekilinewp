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


/** Personalizar el tema desde las opciones, logo, fondo, etc **/

function ekiline_theme_customizer( $wp_customize ) {
    
// colores  
    $colors = array();
    $colors[] = array( 'slug'=>'text_color', 'default' => '#333333', 'label' => __( 'Color de texto', 'ekiline' ) );
    $colors[] = array( 'slug'=>'links_color', 'default' => '#337ab7', 'label' => __( 'Color de links', 'ekiline' ) );
    $colors[] = array( 'slug'=>'module_color', 'default' => '#eeeeee', 'label' => __( 'Color de modulos', 'ekiline' ) );
    $colors[] = array( 'slug'=>'menu_color', 'default' => '#f8f8f8', 'label' => __( 'Color de menu', 'ekiline' ) );
    $colors[] = array( 'slug'=>'footer_color', 'default' => '#f8f8f8', 'label' => __( 'Color de pie de pagina', 'ekiline' ) );
    
    foreach($colors as $color)
    {
        // SETTINGS
        $wp_customize->add_setting( 
        		$color['slug'], array( 
        				'default' => $color['default'], 
        				'type' => 'option', 
        				'capability' => 'edit_theme_options' )
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
    		'ekiline_inversemenu', array(
    				'default' => ''
    		) );
    
    $wp_customize->add_control(
    		'ekiline_inversemenu',
    		array(
    				'label'          => __( 'Textos claros en menu y footer', 'ekiline' ),
    				'description'    => 'Habilita esta opcion en caso de utilizar un menu y un footer oscuros.',
    				'section'        => 'colors',
    				'settings'       => 'ekiline_inversemenu',
    				'type'           => 'checkbox'
    		)
    );    

// agregar un controlador: https://codex.wordpress.org/Class_Reference/WP_Customize_Control  
// https://make.wordpress.org/core/2014/07/08/customizer-improvements-in-4-0/
// https://developer.wordpress.org/themes/advanced-topics/customizer-api/
// http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/

    $wp_customize->add_setting( 'ekiline_logo_max' );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ekiline_logo_max', array(
            'label'    => __( 'Logotipo horizontal', 'ekiline' ),
            'description' => 'Esta es la imagen de tu marca que aparecera en el menu.',
            'section'  => 'title_tagline', // esta seccion corresponde a una predeterminada.
            'settings' => 'ekiline_logo_max',
            'priority' => 100,
    ) ) );
        
 // video
//     $wp_customize->add_section( 'ekiline_video_portada' , array(
//             'title'       => __( 'Video de cabecera', 'ekiline' ),
//             'priority'    => 90,
//             'description' => '<b>Debes tener una imagen de cabecera</b>.<br/>Elige un archivo de video <b>MP4, WEBM u OGV</b> de tu biblioteca. La imagen de cabecera se adaptara como fondo en caso de que los dispositivos no puedan reproducir video.',
//     ) );
    
//     $wp_customize->add_setting( 'ekiline_video' );
    
//     $wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, 'ekiline_video', array(
//             'label'    => __( 'Video MP4, WEBM u OGV', 'ekiline' ),
//             'section'  => 'ekiline_video_portada',
//             'settings' => 'ekiline_video',
//     ) ) );  

    // video
    
    $wp_customize->add_setting( 'ekiline_video' );
    
    $wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, 'ekiline_video', array(
    		'label'    => __( 'Video MP4, WEBM u OGV', 'ekiline' ),
        	'description' => '<b>Debes tener seleccionar una imagen de cabecera</b>.<br/>Elige un archivo de video <b>MP4, WEBM u OGV</b> de tu biblioteca. La imagen de cabecera se adaptara como fondo en caso de que los dispositivos no puedan reproducir video.',
    		'section'  => 'header_image',
    		'settings' => 'ekiline_video',
            'priority'    => 90,
    ) ) );   

    // Controlador para estalecer la altura de la imagen de cabecera
    
    $wp_customize->add_setting( 'ekiline_range_header', array( 
			'default' => '30',
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
    
    $wp_customize->add_setting( 'ekiline_logo_min' );
    
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ekiline_logo_min', array(
    		'label'    => __( 'Logotipo header', 'ekiline' ),
    		'description' => 'Agrega tu logotipo si deseas que aparezca en el encabezado.',
    		'section'  => 'header_image', 
    		'settings' => 'ekiline_logo_min',
    		'priority' => 100,
    ) ) );
    

// ancho de la pagina
    $wp_customize->add_section( 'ekiline_vista_section' , array(
            'title'       => __( 'Vista de tu sitio', 'ekiline' ),
            'priority'    => 50,
            'description' => 'Elige si quieres que el homepage, los listados o el articulo principal se desplieguen a todo lo ancho (fullwidth) o ajustada al centro.',
    ) );
    
        $wp_customize->add_setting(
            'ekiline_anchoHome', array(
                    'default' => 'container',
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
            'default' => ''
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
    
    // Servicios varios
     
    $wp_customize->add_section( 'ekiline_services' , array(
    		'title'       => __( 'Servicios extra', 'ekiline' ),
    		'priority'    => 160,
    		'description' => __( 'Caracteristicas agregadas para tu sitio.', 'ekiline' )
    ) );
    
    // Poner en mantenimiento
    $wp_customize->add_setting(
    		'ekiline_maintenance', array(
    				'default' => ''
    		) );
    
    $wp_customize->add_control(
    		'ekiline_maintenance',
    		array(
    				'label'          => __( 'Poner mi sitio en mantenimiento', 'ekiline' ),
    				'description'    => 'Si es necesario ',
    				'section'        => 'ekiline_services',
    				'settings'       => 'ekiline_maintenance',
    				'type'           => 'checkbox',
    		)
    );    

        
}
add_action('customize_register', 'ekiline_theme_customizer');
