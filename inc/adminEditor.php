<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 * Info: https://developer.wordpress.org/reference/functions/add_editor_style/
 *
 * @package ekiline
 */

if( true === get_theme_mod( 'ekiline_bootstrapeditor', true ) ) {
 
	/**
	 * Añadir estilos css al editor de wordpress (no requiere una función):
	 * Add styles to wordpress admin editor
	 */
	
	add_editor_style('editor-style.min.css'); 


	// La llega de gutenberg es inminente. || When gutenberg arrives

	$gutenbergExists = 'mce_buttons_3';	
	if ( in_array( 'gutenberg/gutenberg.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		$gutenbergExists = 'mce_buttons_2';
		function ekiline_gutenberg_styles() {
		     wp_enqueue_style( 'ekiline-gutenberg', get_template_directory_uri() . '/editor-style.min.css', array(), '1', 'all' );
		}
		add_action( 'enqueue_block_editor_assets', 'ekiline_gutenberg_styles' ); 		
	}	
		 
	// Registro Ekiline estilos || Register Ekiline styles 
	
	function ekiline_bootstrap_styles($buttons) {
	    array_unshift($buttons, 'styleselect');
	    return $buttons;
	}
	add_filter($gutenbergExists, 'ekiline_bootstrap_styles');
	
	// Genero mi callback || Add my callback
	
	function ekiline_mce_before( $init_array ) {  
	
	    $style_formats = array(      	    
	        array(
	            'title' => __( 'Typography', 'ekiline' ),
	            'items' => array(
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
	            'title' => __( 'Big text', 'ekiline' ),
	            'items' => array(
	                array(
	                    'title'     => __( 'Lead Text <p>', 'ekiline' ),
	                    'selector'  => 'p,span',
	                    'classes'   => 'lead',
	                ),
	                array(
	                    'title'     => __( 'Display 1', 'ekiline' ),
	                    'selector'  => 'p,h1,h2,h3,h4',
	                    'classes'   => 'display-1',
	                ),                           
	                array(
	                    'title'     => __( 'Display 2', 'ekiline' ),
	                    'selector'  => 'p,h1,h2,h3,h4',
	                    'classes'   => 'display-2',
	                ),                           
	                array(
	                    'title'     => __( 'Display 3', 'ekiline' ),
	                    'selector'  => 'p,h1,h2,h3,h4',
	                    'classes'   => 'display-3',
	                ),                           
	                array(
	                    'title'     => __( 'Display 4', 'ekiline' ),
	                    'selector'  => 'p,h1,h2,h3,h4',
	                    'classes'   => 'display-4',
	                ),                           
	            ),
	        ),
	        
			array(
	            'title' => __( 'Colors', 'ekiline' ),
	            'items' => array(

			        array(
			            'title' => __( 'Text colors', 'ekiline' ),
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
			            'title' => __( 'Background colors', 'ekiline' ),
			            'items' => array(
			                array(
			                    'title'     => __( 'Primary', 'ekiline' ),
			                    'selector'     => '*',
			                    'classes'   => 'bg-primary',
			                ),
			                array(
			                    'title'     => __( 'Secondary', 'ekiline' ),
			                    'selector'     => '*',
			                    'classes'   => 'bg-secondary',
			                ),
			                array(
			                    'title'     => __( 'Success', 'ekiline' ),
			                    'selector'     => '*',
			                    'classes'   => 'bg-success',
			                ),
			                array(
			                    'title'     => __( 'Danger', 'ekiline' ),
			                    'selector'     => '*',
			                    'classes'   => 'bg-danger',
			                ),
			                array(
			                    'title'     => __( 'Warning', 'ekiline' ),
			                    'selector'     => '*',
			                    'classes'   => 'bg-warning',
			                ),
			                array(
			                    'title'     => __( 'Info', 'ekiline' ),
			                    'selector'     => '*',
			                    'classes'   => 'bg-info',
			                ),
			                array(
			                    'title'     => __( 'Light', 'ekiline' ),
			                    'selector'     => '*',
			                    'classes'   => 'bg-light',
			                ),
			                array(
			                    'title'     => __( 'Dark', 'ekiline' ),
			                    'selector'     => '*',
			                    'classes'   => 'bg-dark',
			                ),
			            ),
			        ),
	            
				),
			),
	        
			array(
	            'title' => __( 'Buttons', 'ekiline' ),
	            'items' => array(
	            
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
			                    'selector'  => '.btn',
			                    'classes'   => 'btn-lg',
			                ),
			                array(
			                    'title'     => __( 'Small', 'ekiline' ),
			                    'selector'  => '.btn',
			                    'classes'   => 'btn-sm',
			                ),
			                array(
			                    'title'     => __( 'Block', 'ekiline' ),
			                    'selector'  => '.btn',
			                    'classes'   => 'btn-block',
			                ),
			                array(
			                    'title'        => __( 'Disabled', 'ekiline' ),
			                    'selector'  => '.btn',
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
	            'title' => __( 'Grid', 'ekiline' ),
	            'items' => array(
	                array(
	                    'title'     => __( 'Set containers', 'ekiline' ),

				            'items' => array(
				                array(
				                    'title'     => __( 'container', 'ekiline' ),
				                    'block'  => 'div',
				                    'classes'   => 'container',
				                    'wrapper'   => true,
				                ),
				                array(
				                    'title'     => __( 'container-fluid', 'ekiline' ),
				                    'block'  => 'div',
				                    'classes'   => 'container-fluid',
				                    'wrapper'   => true,
				                ),
				                array(
				                    'title'     => __( 'Set rows', 'ekiline' ),

							            'items' => array(
							                array(
							                    'title'     => __( 'row', 'ekiline' ),
							                    'block'  => 'div',
							                    'classes'   => 'row',
							                    'wrapper'   => true,
							                ),
							                array(
							                    'title'     => __( 'justify-content-start', 'ekiline' ),
							                    'selector'  => '.row',
							                    'classes'   => 'justify-content-start',
							                ),
							                array(
							                    'title'     => __( 'justify-content-center', 'ekiline' ),
							                    'selector'  => '.row',
							                    'classes'   => 'justify-content-center',
							                ),
							                array(
							                    'title'     => __( 'justify-content-end', 'ekiline' ),
							                    'selector'  => '.row',
							                    'classes'   => 'justify-content-end',
							                ),
							                array(
							                    'title'     => __( 'justify-content-around', 'ekiline' ),
							                    'selector'  => '.row',
							                    'classes'   => 'justify-content-around',
							                ),
							                array(
							                    'title'     => __( 'justify-content-between', 'ekiline' ),
							                    'selector'  => '.row',
							                    'classes'   => 'justify-content-between',
							                ),
							                array(
							                    'title'     => __( 'align-items-start', 'ekiline' ),
							                    'selector'  => '.row',
							                    'classes'   => 'align-items-start',
							                ),
							                array(
							                    'title'     => __( 'align-items-center', 'ekiline' ),
							                    'selector'  => '.row',
							                    'classes'   => 'align-items-center',
							                ),
							                array(
							                    'title'     => __( 'align-items-end', 'ekiline' ),
							                    'selector'  => '.row',
							                    'classes'   => 'align-items-end',
							                ),
							                array(
							                    'title'     => __( 'no-gutters', 'ekiline' ),
							                    'selector'  => '.row',
							                    'classes'   => 'no-gutters',
							                ),
							            ),	                    				                    				                    
				                ),            
			
				            ),	                    
	                ),
	                array(
	                    'title'     => __( 'Set columns', 'ekiline' ),
			            'items' => array(
			                array(
			                    'title'     => __( 'col', 'ekiline' ),
			                    'block'  => 'div',
			                    'classes'   => 'col',
			                ),			                
			                array(
			                    'title'     => __( 'col-sm-*', 'ekiline' ),
					            'items' => array(
					                array(
					                    'title'     => __( 'col-sm-6', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'col-sm-6',
					                ),
					                array(
					                    'title'     => __( 'col-sm-auto', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'col-sm-auto',
					                ),					
					            ),	                    				                    				                    
			                ),
			                array(
			                    'title'     => __( 'col-md-*', 'ekiline' ),
					            'items' => array(
					                array(
					                    'title'     => __( 'col-md-4', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'col-md-4',
					                ),
					                array(
					                    'title'     => __( 'col-md-auto', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'col-md-auto',
					                ),
					
					            ),	                    				                    				                    
			                ),			     
			                array(
			                    'title'     => __( 'col-lg-*', 'ekiline' ),
					            'items' => array(
					                array(
					                    'title'     => __( 'col-lg-3', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'col-lg-3',
					                ),
					                array(
					                    'title'     => __( 'col-lg-auto', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'col-lg-auto',
					                ),
					
					            ),	                    				                    				                    
			                ),
			                array(
			                    'title'     => __( 'col-xl-*', 'ekiline' ),
					            'items' => array(
					                array(
					                    'title'     => __( 'col-xl-3', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'col-xl-3',
					                ),
					                array(
					                    'title'     => __( 'col-xl-auto', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'col-xl-auto',
					                ),
					
					            ),	                    				                    				                    
			                ),			                			                           
			            ),	                    				                    				                    
	                    			                    
	                ),
	                
	                array(
	                    'title'     => __( 'Column align/order', 'ekiline' ),
			            'items' => array(
			                array(
			                    'title'     => __( 'align-self', 'ekiline' ),
					            'items' => array(				            
					                array(
					                    'title'     => __( 'align-self-start', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'align-self-start',
					                ),
					                array(
					                    'title'     => __( 'align-self-center', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'align-self-center',
					                ),
					                array(
					                    'title'     => __( 'align-self-end', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'align-self-start',
					                ),
					            ),
			                ),			                
			                array(
			                    'title'     => __( 'order', 'ekiline' ),
					            'items' => array(
					                array(
					                    'title'     => __( 'order-first', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'order-first',
					                ),					            
					                array(
					                    'title'     => __( 'order-last', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'order-last',
					                ),	
					                array(
					                    'title'     => __( 'order-sm-*', 'ekiline' ),
							            'items' => array(				            
							                array(
							                    'title'     => __( 'order-sm-first', 'ekiline' ),
							                    'selector'  => '*',
							                    'classes'   => 'order-sm-first',
							                ),
							                array(
							                    'title'     => __( 'order-sm-last', 'ekiline' ),
							                    'selector'  => '*',
							                    'classes'   => 'order-sm-last',
							                ),
							            ),
					                ),
					                array(
					                    'title'     => __( 'order-md-*', 'ekiline' ),
							            'items' => array(				            
							                array(
							                    'title'     => __( 'order-md-first', 'ekiline' ),
							                    'selector'  => '*',
							                    'classes'   => 'order-md-first',
							                ),
							                array(
							                    'title'     => __( 'order-md-last', 'ekiline' ),
							                    'selector'  => '*',
							                    'classes'   => 'order-md-last',
							                ),
							            ),
					                ),					                
					                array(
					                    'title'     => __( 'order-lg-*', 'ekiline' ),
							            'items' => array(				            
							                array(
							                    'title'     => __( 'order-lg-first', 'ekiline' ),
							                    'selector'  => '*',
							                    'classes'   => 'order-lg-first',
							                ),
							                array(
							                    'title'     => __( 'order-lg-last', 'ekiline' ),
							                    'selector'  => '*',
							                    'classes'   => 'order-lg-last',
							                ),
							            ),
					                ),									
					                array(
					                    'title'     => __( 'order-xl-*', 'ekiline' ),
							            'items' => array(				            
							                array(
							                    'title'     => __( 'order-xl-first', 'ekiline' ),
							                    'selector'  => '*',
							                    'classes'   => 'order-xl-first',
							                ),
							                array(
							                    'title'     => __( 'order-xl-last', 'ekiline' ),
							                    'selector'  => '*',
							                    'classes'   => 'order-xl-last',
							                ),
							            ),
					                ),
					            ),
			                ),		                
			                array(
			                    'title'     => __( 'offset', 'ekiline' ),
					            'items' => array(
					                array(
					                    'title'     => __( 'offset-sm-1', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'offset-sm-1',
					                ),
					                array(
					                    'title'     => __( 'offset-md-1', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'offset-md-1',
					                ),
					                array(
					                    'title'     => __( 'offset-lg-1', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'offset-lg-1',
					                ),
					                array(
					                    'title'     => __( 'offset-xl-1', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'offset-xl-1',
					                ),
					            ),
			                ),
			            ),	                    			                    
	                ),
	                array(
	                    'title'     => __( 'Measure', 'ekiline' ),
			            'items' => array(
			                array(
			                    'title'     => __( 'margin', 'ekiline' ),
					            'items' => array(
					                array(
					                    'title'     => __( 'm-0', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'm-0',
					                ),
					                array(
					                    'title'     => __( 'mt-1', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'mt-1',
					                ),
					                array(
					                    'title'     => __( 'mr-1', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'mr-1',
					                ),
					                array(
					                    'title'     => __( 'mb-1', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'mb-1',
					                ),
					                array(
					                    'title'     => __( 'ml-1', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'ml-1',
					                ),
					                array(
					                    'title'     => __( 'mx-1', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'mx-1',
					                ),
					                array(
					                    'title'     => __( 'my-1', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'my-1',
					                ),
					            ),
			                ),
			                array(
			                    'title'     => __( 'padding', 'ekiline' ),
					            'items' => array(
					                array(
					                    'title'     => __( 'p-0', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'p-0',
					                ),
					                array(
					                    'title'     => __( 'pt-1', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'pt-1',
					                ),
					                array(
					                    'title'     => __( 'pr-1', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'pr-1',
					                ),
					                array(
					                    'title'     => __( 'pb-1', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'pb-1',
					                ),
					                array(
					                    'title'     => __( 'pl-1', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'pl-1',
					                ),
					                array(
					                    'title'     => __( 'px-1', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'px-1',
					                ),
					                array(
					                    'title'     => __( 'py-1', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'py-1',
					                ),
					            ),
			                ),
			                array(
			                    'title'     => __( 'width', 'ekiline' ),
					            'items' => array(
					                array(
					                    'title'     => __( 'w-25', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'w-25',
					                ),
					                array(
					                    'title'     => __( 'w-50', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'w-50',
					                ),
					                array(
					                    'title'     => __( 'w-75', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'w-75',
					                ),
					                array(
					                    'title'     => __( 'w-100', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'w-100',
					                ),
					                array(
					                    'title'     => __( 'mw-100', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'mw-100',
					                ),

					            ),
			                ),
			                array(
			                    'title'     => __( 'height', 'ekiline' ),
					            'items' => array(
					                array(
					                    'title'     => __( 'h-25', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'h-25',
					                ),
					                array(
					                    'title'     => __( 'h-50', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'h-50',
					                ),
					                array(
					                    'title'     => __( 'h-75', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'h-75',
					                ),
					                array(
					                    'title'     => __( 'h-100', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'h-100',
					                ),
					                array(
					                    'title'     => __( 'mh-100', 'ekiline' ),
					                    'selector'  => '*',
					                    'classes'   => 'mh-100',
					                ),

					            ),
			                ),
			            ),	                    				                    				                    	                    			                    
	                ),             
	                
	            ),
	        ),        

	        array(
	            'title' => __( 'Lists and tables', 'ekiline' ),
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
	                array(
	                    'title'     => __( 'Table', 'ekiline' ),
	                    'selector'  => 'table',
	                    'classes'   => 'table',
	                ),
	                array(
	                    'title'     => __( 'Table dark', 'ekiline' ),
	                    'selector'  => 'table',
	                    'classes'   => 'table-dark',
	                ),
	                array(
	                    'title'     => __( 'Table head light', 'ekiline' ),
	                    'selector'  => 'thead',
	                    'classes'   => 'thead-light',
	                ),
	                array(
	                    'title'     => __( 'Table head dark', 'ekiline' ),
	                    'selector'  => 'thead',
	                    'classes'   => 'thead-dark',
	                ),
	                array(
	                    'title'     => __( 'Table striped', 'ekiline' ),
	                    'selector'  => 'table',
	                    'classes'   => 'table-striped',
	                ),
	                array(
	                    'title'     => __( 'Table bordered', 'ekiline' ),
	                    'selector'  => 'table',
	                    'classes'   => 'table-bordered',
	                ),
	                array(
	                    'title'     => __( 'Table hoverable', 'ekiline' ),
	                    'selector'  => 'table',
	                    'classes'   => 'table-hover',
	                ),
	                array(
	                    'title'     => __( 'Table small', 'ekiline' ),
	                    'selector'  => 'table',
	                    'classes'   => 'table-sm',
	                ),
	            ),
	        ),

	        array(
	            'title' => __( 'Utilities', 'ekiline' ),
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
					
	            ),
	        ),        	        	    
	    );  

	    $init_array['style_formats'] = json_encode( $style_formats );  	    
	    return $init_array;  
	  
	} 
	add_filter( 'tiny_mce_before_init', 'ekiline_mce_before' ); 

	// Agregar botones a tinymce editor || Add a custom button to tinymce editor

	add_action('admin_head', 'custom_mce_buttons');
 	function custom_mce_buttons() {
	    if ( get_user_option( 'rich_editing' ) == 'true' ) {
	        add_filter( 'mce_external_plugins', 'custom_tinymce_plugin' );
	        add_filter( 'mce_buttons_3', 'register_mce_buttons' );
	    }
	}
	
		// ajuste para su uso en el front || if editor allowed in front.
		if( !is_admin() ){
			add_action('wp_head', 'custom_mce_buttons_front');
		 	function custom_mce_buttons_front() {
			        add_filter( 'mce_external_plugins', 'custom_tinymce_plugin' );
			        add_filter( 'mce_buttons_3', 'register_mce_buttons' );
			}
		}	
	
	// Agregar la ruta a la funcion del boton || Add the path to the js file with the custom button function

	function custom_tinymce_plugin( $plugin_array ) {
	    $plugin_array['custom_mce_button2'] = get_template_directory_uri() .'/js/adminSubgrid.min.js';
	    $plugin_array['custom_mce_button3'] = get_template_directory_uri() .'/js/adminShowgrid.min.js';
	    $plugin_array['custom_mce_button4'] = get_template_directory_uri() .'/js/adminItemBg.min.js';
	    $plugin_array['custom_mce_button5'] = get_template_directory_uri() .'/js/adminMap.min.js';
	    $plugin_array['custom_mce_button6'] = get_template_directory_uri() .'/js/adminTabs.min.js';
	    $plugin_array['custom_mce_button7'] = get_template_directory_uri() .'/js/adminToggle.min.js';
	    $plugin_array['custom_mce_button8'] = get_template_directory_uri() .'/js/adminPops.min.js';
	    $plugin_array['custom_mce_button9'] = get_template_directory_uri() .'/js/adminShare.min.js';
	    $plugin_array['custom_mce_button10'] = get_template_directory_uri() .'/js/adminPostin.min.js';
	    $plugin_array['custom_mce_button12'] = get_template_directory_uri() .'/js/adminModal.min.js';
	    $plugin_array['custom_mce_button13'] = get_template_directory_uri() .'/js/adminLayout.min.js';
	    $plugin_array['custom_mce_button14'] = get_template_directory_uri() .'/js/adminCustom.min.js';
	    $plugin_array['custom_mce_button15'] = get_template_directory_uri() .'/js/adminFawfive.min.js';
	    $plugin_array['custom_mce_button16'] = get_template_directory_uri() .'/js/adminPro.min.js';
	    return $plugin_array;
	}
	
	// Registrar el boton y agregarlo || Register and add new button in the editor
	
	function register_mce_buttons( $buttons ) {
	    array_push( $buttons, 'custom_mce_button3, custom_mce_button2, custom_mce_button4, custom_mce_button6, custom_mce_button7, custom_mce_button8, custom_mce_button12, custom_mce_button10, custom_mce_button13, custom_mce_button14, custom_mce_button5, custom_mce_button9, custom_mce_button15, custom_mce_button16' );
	    return $buttons;
	}
	
	// Traducir los botones de tinyMCE || Lang traslate

	function ekiline_tinymce_add_locale($locales) {
	    $locales ['Ekiline-Tinymce'] = get_template_directory() . '/inc/ekiline-tinymce-langs.php';
	    return $locales;
	}
	add_filter('mce_external_languages', 'ekiline_tinymce_add_locale');

	foreach ( array('post.php','post-new.php') as $hook ) {
	     add_action( "admin_head-$hook", 'my_admin_head' );
	}

	if( !is_admin() ){
	    add_action( 'wp_head', 'my_admin_head' );	
	}	

	function my_admin_head() {
		$args = array( 'orderby' => 'name' ); 
		$cats = get_terms( 'category', $args ); 
		$list = array();
	
	    foreach ( $cats as $cat ) {
			$list[] = array(
				'text' =>	$cat->name,
				'value'	=>	$cat->term_id
			);
		}
		
		$json = wp_json_encode($list);

		echo '<script type="text/javascript">'	."\n".
				'var tinyCatList =' . $json . ';'	."\n".
			 '</script>'."\n";
	}
}

// Faltan botones de wordpress || Add hidden wordpress buttons.
function wp_mce_buttons( $buttons ) {	
	$buttons[] = 'wp_page';
	return $buttons;
}
add_filter( 'mce_buttons_2', 'wp_mce_buttons' );
