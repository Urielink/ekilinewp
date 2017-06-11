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


/** Al custom options for Ekiline Theme 
 *  Handlers need sanitize after output
 *  https://github.com/WPTRT/code-examples/blob/master/customizer/sanitization-callbacks.php
 **/

function ekiline_theme_customizer( $wp_customize ) {
    
// Colors array
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

    
    // Bootstrap inverse menu
    $wp_customize->add_setting( 
        'ekiline_inversemenu', array(
    				'default' => '',
    				'sanitize_callback' => 'ekiline_sanitize_checkbox'
        )
    );
    
    $wp_customize->add_control(
    	'ekiline_inversemenu', array(
    				'label'          => __( 'Inverse menu', 'ekiline' ),
    				'description'    => __( 'Change menu from lighten to darken', 'ekiline' ),
    				'section'        => 'colors',
    				'settings'       => 'ekiline_inversemenu',
    				'type'           => 'checkbox'
        )
    );    

    // Add a control: https://codex.wordpress.org/Class_Reference/WP_Customize_Control  
    // https://make.wordpress.org/core/2014/07/08/customizer-improvements-in-4-0/
    // https://developer.wordpress.org/themes/advanced-topics/customizer-api/
    // http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/

    $wp_customize->add_setting( 
        'ekiline_logo_max', array(
                'default' => '',
                'sanitize_callback' => 'ekiline_sanitize_image'
        ) 
    );

    $wp_customize->add_control( 
        new WP_Customize_Image_Control( 
            $wp_customize, 'ekiline_logo_max', 
                array(
                    'label'    => __( 'Horizontal logo', 'ekiline' ),
                    'description' => __( 'This show your brand in menu', 'ekiline' ),
                    'section'  => 'title_tagline', // this is a WP default section
                    'settings' => 'ekiline_logo_max',
                    'priority' => 100,
                ) 
        ) 
    );    
    
    $wp_customize->add_setting( 
            'ekiline_video', array(
                    'default' => '',
                    'sanitize_callback' => 'ekiline_sanitize_video'
            )
    );
    
    $wp_customize->add_control( 
        new WP_Customize_Upload_Control( 
            $wp_customize, 'ekiline_video', 
                array(
            		'label'    => __( 'Upload video to header', 'ekiline' ),
                	'description' => __( 'Recommended formats: MP4, WEBM or OGV, your header image conserves as video background or replacement', 'ekiline' ),
            		'section'  => 'header_image',
            		'settings' => 'ekiline_video',
                    'priority'    => 90,
                )
            ) 
    );   

    // Range control for heading
    
    $wp_customize->add_setting( 
        'ekiline_range_header', array( 
    			'default' => '30',
    			'sanitize_callback'  => 'ekiline_sanitize_number_range'
        )
    );

    $wp_customize->add_control( 
        'ekiline_range_header', array(
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
	       ) 
   );    
    
    $wp_customize->add_setting( 
        'ekiline_logo_min', array( 
                'default' => '',
                'sanitize_callback'  => 'ekiline_sanitize_image'
        ) 
    );
    
    $wp_customize->add_control( 
        new WP_Customize_Image_Control( 
            $wp_customize, 'ekiline_logo_min', 
                array(
            		'label'    => __( 'Header logo', 'ekiline' ),
            		'description' => __( 'Add your brand in your image header', 'ekiline' ),
            		'section'  => 'header_image', 
            		'settings' => 'ekiline_logo_min',
            		'priority' => 100,
                ) 
            ) 
    );
    
// Header message    
    $wp_customize->add_setting( 
        'ekiline_headertext', array( 
                'default' => '',
                'transport' => 'none',
                'sanitize_callback'  => 'ekiline_sanitize_html'
            ) 
    );
    
    $wp_customize->add_control( 
        'ekiline_headertext', array(
                'type'        => 'textarea',
                'label'    => __( 'Header message', 'ekiline' ),
                'description' => __( 'Customize the text in your heading image' , 'ekiline' ),
                'section'  => 'header_image', 
                'settings' => 'ekiline_headertext',
                'priority' => 100,
            ) 
    );    
    

// Page wide
    $wp_customize->add_section( 
        'ekiline_vista_section' , array(
            'title'       => __( 'Site view', 'ekiline' ),
            'priority'    => 120,
            'description' => __( 'Allow fullwidth or center the content of your website by content type: homepage, categories or single content' , 'ekiline' ),
        ) 
    );
    
        $wp_customize->add_setting(
            'ekiline_anchoHome', array(
                    'default' => 'container',
                    'sanitize_callback' => 'ekiline_sanitize_select'
                ) );
        
        $wp_customize->add_control(
            'ekiline_anchoHome', array(
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
            'ekiline_anchoCategory', array(
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
                ) 
        );
        
        $wp_customize->add_control(
            'ekiline_anchoSingle', array(
                'type' => 'radio',
                'label' => __( 'Single pages', 'ekiline' ),
                'section' => 'ekiline_vista_section',
                'choices' => array(
                    'container' => __( 'Centered', 'ekiline' ),
                    'container-fluid' => __( 'Fullwidth', 'ekiline' ),
                ),
            )
        );         
        
        // Hide or show sidebars

        $wp_customize->add_setting(
            'ekiline_sidebarLeft', array(
                    'default' => 'on',
                    'sanitize_callback' => 'ekiline_sanitize_select'
                ) );
        
        $wp_customize->add_control(
            'ekiline_sidebarLeft', array(
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
                ) 
        );
        
        $wp_customize->add_control(
            'ekiline_sidebarRight', array(
                'type' => 'radio',
                'label' => __( 'Right sidebar', 'ekiline' ),
                'section' => 'ekiline_vista_section',
                'choices' => array(
                    'on' => __( 'Static', 'ekiline' ),
                    'off' => __( 'Toggle', 'ekiline' ),
                ),
            )
        );              

	// Behaviors for top menu

        $wp_customize->add_setting(
            'ekiline_topmenuSettings', array(
                    'default' => '0',
                    'sanitize_callback' => 'ekiline_sanitize_select'
                ) 
        );
        
        $wp_customize->add_control(
            'ekiline_topmenuSettings', array(
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
        

    // Page optimization
   
    $wp_customize->add_section( 
        'ekiline_tracking_section' , array(
            'title'       => __( 'Site Optimization', 'ekiline' ),
            'priority'    => 150,
            'description' => __( 'Add tracking codes and improves site performance', 'ekiline' )
        ) 
    );

    $wp_customize->add_setting( 
        'ekiline_analytics', array(
            'default' => '',
            'transport' => 'none',
            'sanitize_callback' => 'ekiline_sanitize_html'
        ) 
    );
    
    $wp_customize->add_control(
        'ekiline_analytics', array(
                'label'          => __( 'Google Analytics', 'ekiline' ),
                'description'    => __( 'Add Google Analytics code, only your identifier ( UA-XXXXX-XX )', 'ekiline' ),
                'section'        => 'ekiline_tracking_section',
                'settings'       => 'ekiline_analytics',
                'type'           => 'text'
        )
    );   
        
    $wp_customize->add_setting( 
        'ekiline_wmtools', array(
            'default' => '',
            'transport' => 'none',
            'sanitize_callback' => 'ekiline_sanitize_html'
        ) 
    );
    
    $wp_customize->add_control(
        'ekiline_wmtools', array(
                'label'          => __( 'Search Console', 'ekiline' ),
                'description'    => __( 'Add google site verification, only content="value"', 'ekiline' ),
                'section'        => 'ekiline_tracking_section',
                'settings'       => 'ekiline_wmtools',
                'type'           => 'text'
        )
    );       
        
    $wp_customize->add_setting( 
        'ekiline_wmbing', array(
            'default' => '',
            'transport' => 'none',
            'sanitize_callback' => 'ekiline_sanitize_html'
        ) 
    );
    
    $wp_customize->add_control(
        'ekiline_wmbing', array(
                'label'          => __( 'Bing web master tools', 'ekiline' ),
                'description'    => __( 'Add msvalidate content="value"', 'ekiline' ),
                'section'        => 'ekiline_tracking_section',
                'settings'       => 'ekiline_wmbing',
                'type'           => 'text'
        )
    );              
        
    $wp_customize->add_setting(
            'ekiline_loadcss', array(
                    'default' => '',
                    'sanitize_callback' => 'ekiline_sanitize_checkbox'
            ) 
    );
    
    $wp_customize->add_control(
            'ekiline_loadcss', array(
                    'label'          => __( 'Optimize CSS style loading', 'ekiline' ),
                    'description'    => __( 'Increase speed loading your styles after your information', 'ekiline' ),
                    'section'        => 'ekiline_tracking_section',
                    'settings'       => 'ekiline_loadcss',
                    'type'           => 'checkbox',
            )
    );               
    
    $wp_customize->add_setting(
            'ekiline_minify', array(
                    'default' => '',
                    'sanitize_callback' => 'ekiline_sanitize_checkbox'
            ) 
    );
    
    $wp_customize->add_control(
            'ekiline_minify', array(
                    'label'          => __( 'Optimize HTML', 'ekiline' ),
                    'description'    => __( 'Minify HTML output for site speed', 'ekiline' ),
                    'section'        => 'ekiline_tracking_section',
                    'settings'       => 'ekiline_minify',
                    'type'           => 'checkbox',
            )
    );                   
    
    // Ekiline Services
         
    $wp_customize->add_section( 
        'ekiline_services' , array(
    		'title'       => __( 'Other services', 'ekiline' ),
    		'priority'    => 160,
    		'description' => __( 'Special features for your site', 'ekiline' )
        ) 
    );
    
    $wp_customize->add_setting(
    		'ekiline_maintenance', array(
    				'default' => '',
    				'sanitize_callback' => 'ekiline_sanitize_checkbox'
    		) 
    );
    
    $wp_customize->add_control(
    		'ekiline_maintenance', array(
    				'label'          => __( 'Site over maintenance', 'ekiline' ),
    				'description'    => __( 'Show a maintenance page to your visitors', 'ekiline' ),
    				'section'        => 'ekiline_services',
    				'settings'       => 'ekiline_maintenance',
    				'type'           => 'checkbox',
    		)
    );    

    $wp_customize->add_setting(
            'ekiline_wireframe', array(
                    'default' => '',
                    'sanitize_callback' => 'ekiline_sanitize_checkbox'
            ) 
    );
    
    $wp_customize->add_control(
            'ekiline_wireframe', array(
                    'label'          => __( 'Wireframe mode', 'ekiline' ),
                    'description'    => __( 'Show bootstrap style boxes to help you in the design process', 'ekiline' ),
                    'section'        => 'ekiline_services',
                    'settings'       => 'ekiline_wireframe',
                    'type'           => 'checkbox',
            )
    );   

    $wp_customize->add_setting(
            'ekiline_mediacomment', array(
                    'default' => '',
                    'sanitize_callback' => 'ekiline_sanitize_checkbox'
            ) 
    );
    
    $wp_customize->add_control(
            'ekiline_mediacomment', array(
                    'label'          => __( 'Cancel comments in attachments', 'ekiline' ),
                    'description'    => __( 'Yo can do this each attachment in media library or hiding all with this option' , 'ekiline' ),
                    'section'        => 'ekiline_services',
                    'settings'       => 'ekiline_mediacomment',
                    'type'           => 'checkbox',
            )
    );  
    
  
    
    // Ekiline social media
         
    $wp_customize->add_section( 
        'ekiline_social' , array(
            'title'       => __( 'Social media', 'ekiline' ),
            'priority'    => 170,
            'description' => __( 'Set each field to show and allow basic social media features', 'ekiline' )
        ) 
    );

    $wp_customize->add_setting( 
        'ekiline_fbProf', array(
            'default' => '',
            'transport' => 'none',
            'sanitize_callback' => 'ekiline_sanitize_html'
        ) 
    );
    
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
    
    $wp_customize->add_setting( 
        'ekiline_fbSharid', array(
            'default' => '',
            'transport' => 'none',
            'sanitize_callback' => 'ekiline_sanitize_html'
        ) 
    );
    
    $wp_customize->add_control(
        'ekiline_fbSharid',
            array(
                'description'    => __( 'Add your Facebook Share App ID','ekiline' ),
                'section'        => 'ekiline_social',
                'settings'       => 'ekiline_fbSharid',
                'type'           => 'text'
        )
    );     
                   
                
    $wp_customize->add_setting( 
        'ekiline_twProf', array(
            'default' => '',
            'transport' => 'none',
            'sanitize_callback' => 'ekiline_sanitize_html'
        ) 
    );
    
    $wp_customize->add_control(
        'ekiline_twProf', array(
                'label'          => __( 'Twitter', 'ekiline' ),
                'description'    => __( 'Add your Twitter name (@name)','ekiline' ),
                'section'        => 'ekiline_social',
                'settings'       => 'ekiline_twProf',
                'type'           => 'text'
            )
    );      

    $wp_customize->add_setting( 
        'ekiline_gpProf', array(
            'default' => '',
            'transport' => 'none',
            'sanitize_callback' => 'ekiline_sanitize_html'
        ) 
    );
    
    $wp_customize->add_control(
        'ekiline_gpProf', array(
                'label'          => __( 'Google Plus', 'ekiline' ),
                'description'    => __( 'Add your Google Plus page url','ekiline' ),
                'section'        => 'ekiline_social',
                'settings'       => 'ekiline_gpProf',
                'type'           => 'text'
        )
    );            
                               
    $wp_customize->add_setting( 
        'ekiline_inProf', array(
            'default' => '',
            'transport' => 'none',
            'sanitize_callback' => 'ekiline_sanitize_html'
        ) 
    );
    
    $wp_customize->add_control(
        'ekiline_inProf', array(
                'label'          => __( 'Linkedin', 'ekiline' ),
                'description'    => __( 'Add your Linkedin page url','ekiline' ),
                'section'        => 'ekiline_social',
                'settings'       => 'ekiline_inProf',
                'type'           => 'text'
        )
    );          
    
    // Design sources
   
    $wp_customize->add_section( 
        'ekiline_dtools_section' , array(
            'title'       => __( 'Design sources', 'ekiline' ),
            'priority'    => 180,
            'description' => __( 'Tools to complement the design of your site', 'ekiline' )
        ) 
    );

    $wp_customize->add_setting( 
        'ekiline_gfont', array(
            'default' => '',
            'transport' => 'none',
            'sanitize_callback' => 'ekiline_sanitize_html'
        ) 
    );
    
    $wp_customize->add_control(
        'ekiline_gfont', array(
                'label'          => __( 'Google fonts', 'ekiline' ),
                'description'    => __( 'Review and choose font type from https://fonts.google.com sample, then add the src="XXX" code', 'ekiline' ),
                'section'        => 'ekiline_dtools_section',
                'settings'       => 'ekiline_gfont',
                'type'           => 'text'
        )
    );          
        
    $wp_customize->add_setting( 
        'ekiline_cutexcerpt', array(
            'default' => '20',
            //'transport' => 'none',
            'sanitize_callback' => 'ekiline_sanitize_html'
        ) 
    );
    
    $wp_customize->add_control(
        'ekiline_cutexcerpt', array(
                'label'          => __( 'Summary words limit', 'ekiline' ),
                'description'    => __( 'Assign a number of words for the summary of your articles, default value is 20', 'ekiline' ),
                'section'        => 'ekiline_dtools_section',
                'settings'       => 'ekiline_cutexcerpt',
                'type'           => 'number'
        )
    );      


    $wp_customize->add_setting(
            'ekiline_fontawesome', array(
                    'default' => '',
                    'sanitize_callback' => 'ekiline_sanitize_checkbox'
            ) 
    );
    
    $wp_customize->add_control(
            'ekiline_fontawesome', array(
                    'label'          => __( 'Use Font Awesome', 'ekiline' ),
                    'description'    => __( 'A collection of icons to enhance your designs' , 'ekiline' ),
                    'section'        => 'ekiline_dtools_section',
                    'settings'       => 'ekiline_fontawesome',
                    'type'           => 'checkbox',
            )
    );     
    
    $wp_customize->add_setting(
            'ekiline_bootstrapeditor', array(
                    'default' => '',
                    'sanitize_callback' => 'ekiline_sanitize_checkbox'
            ) 
    );
    
    $wp_customize->add_control(
            'ekiline_bootstrapeditor', array(
                    'label'          => __( 'Use Bootstrap in editor', 'ekiline' ),
                    'description'    => __( 'Bootstrap design styles in edit control' , 'ekiline' ),
                    'section'        => 'ekiline_dtools_section',
                    'settings'       => 'ekiline_bootstrapeditor',
                    'type'           => 'checkbox',
            )
    );             
                
}
add_action('customize_register', 'ekiline_theme_customizer');

/* Sanitize callbacks */

function ekiline_sanitize_checkbox( $checked ) {

    return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

function ekiline_sanitize_html( $html ) {
    return wp_filter_post_kses( $html );
}

function ekiline_sanitize_image( $image, $setting ) {

    $mimes = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif'          => 'image/gif',
        'png'          => 'image/png',
        'bmp'          => 'image/bmp',
        'tif|tiff'     => 'image/tiff',
        'ico'          => 'image/x-icon'
    );

    $file = wp_check_filetype( $image, $mimes );

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
    
    $number = absint( $number );

    $atts = $setting->manager->get_control( $setting->id )->input_attrs;

    $min = ( isset( $atts['min'] ) ? $atts['min'] : $number );

    $max = ( isset( $atts['max'] ) ? $atts['max'] : $number );

    $step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );

    return ( $min <= $number && $number <= $max && is_int( $number / $step ) ? $number : $setting->default );
}

function ekiline_sanitize_select( $input, $setting ) {

    $input = sanitize_key( $input );

    $choices = $setting->manager->get_control( $setting->id )->choices;

    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}


