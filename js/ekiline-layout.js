/*
 * Arreglos jQuery, exclusivos para caracterisitcas del tema
 */

	jQuery(document).ready(function($){
		
		// animar el boton del menu.
		  $('.navbar-toggle').on('click', function () {
			    $(this).toggleClass('active');
		  });		

		// Sidebar izquierdo mostrar ocultar
			$("#show-sidebar-left").on('click',function(e) {
			        e.preventDefault();
			        $("#content").toggleClass("active-sidebar-left");
			});	

		// Sidebar izquierdo mostrar ocultar al hover
		/**			$( "#sidebar-left" )
					  .mouseover(function() {
					    $("#wrapper").toggleClass("active-sidebar-left");
					    $('#sidebar-left #navbar a').toggleClass("disabled");
					  })
					  .mouseout(function() {
					    $("#wrapper").toggleClass("active-sidebar-left");
					    $('#sidebar-left #navbar a').toggleClass("disabled");
					  });
		**/					

		// Sidebar derecho mostrar ocultar
			$("#show-sidebar-right").on('click',function(e) {
			        e.preventDefault();
			        $("#content").toggleClass("active-sidebar-right");
			});			  


			/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
			 * 
			 *	Carrusel multiple 
			 * 
			 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * **/			
			
			
            $('.carousel-multiple .item').each(function(){
                
                var cThumb = $(this).children();
                                                             
                  // Busca la clase que corresponda para determinar una variable de conteo y también que añada una clase al contenedor
                  
                    if ( cThumb.hasClass( 'col-sm-6' ) ){
    
                      $('.carousel-multiple').addClass('x2');                         
                      var slot = 0;
                        console.log('son 2 objetos de 6');
    
                    } else if ( cThumb.hasClass( 'col-sm-4' ) ){
    
                      $('.carousel-multiple').addClass('x3');                
                      var slot = 2/2;
                        console.log('son 3 objetos de 4');
    
                    } else if ( cThumb.hasClass( 'col-sm-3' ) ){
    
                      $('.carousel-multiple').addClass('x4');                
                      var slot = 2;
                    console.log('son 4 objetos de 3');
    
                    } else if ( cThumb.hasClass( 'col-sm-2' ) ){
    
                      $('.carousel-multiple').addClass('x6');                
                      var slot = 2+2;
                        console.log('son 6 objetos de 2');
    
                    }

                  // por cada objeto cuenta el priemro y clonalo para hacer el recorrido
                  // ejercicio original: http://www.bootply.com/4eSuqiPRo2
                  var next = $(this).next();
                  
                  if (!next.length) {
                    next = $(this).siblings(':first');
                  }
                  
                  next.children(':first-child').clone().appendTo( $(this) );    
                  
                  // aquí meto mi variable 'slot'.
                  for (var i=0;i<slot;i++) { 
                      
                    next=next.next();
                    if (!next.length) {
                        next = $(this).siblings(':first');
                    }
                    
                    next.children(':first-child').clone().appendTo( $(this) );
                  }			
            }); 

			
			
			
			
			
			
			
			
			
			
			/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
			 * 
			 *	ModalBox 
			 * 
			 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * **/			

			
			var ekilinemodals = {			
				
			multipleModals: function ( linkClass ) {
				
				/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
				 * 
				 *	ModalBox para diferente contenido
				 * 
				 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * **/		
				
				//Abr 28 2017 añadir un atributo a los links, para ejecutar los modals.
		        $( linkClass ).each(function(){        	
                  $(this).attr('data-toggle','modal');
                });				

		        $( linkClass ).on('click',function(){

					// declaro el nombre del modal que se va abrir
					var dataHref = $(this).attr('href') || null;
			        
						// si hay href="#nombreIndicador" establecer una nueva variable
						if ( dataHref != null ){
							// quitar el hashtag a #contenido para generar un id="" nuevo en el modal.			
							var hrefToid = dataHref.substr(1);
						}			        
			        
			        // En caso de tener ancho o alto para especificar el tamaño de la ventana, por default genera un modal a todo lo ancho y a todo lo alto.
					var dataWidth = $(this).attr('data-width') || null;
					var dataHeight = $(this).attr('data-height') || null;
					
						if (dataWidth == null || dataHeight == null){
							// pero si no esta especificado, dejar las ventanas al 100%
							dataWidth = '100' || dataHeight == '100';
						}
					
					// por el tipo de clase CSS determino el recurso a utilizar
					var dataSrc = $(this).attr('data-src') || null;
					
			        // si hay titulo en el boton genero un modal con titulo 
					var attrTittle = $(this).attr('title') || null;
			
			
					// Declaro mis espacios para insertar el tipo de elemento
			
			            var contenidoModal = ''; // acorde al tipo de contenido este campo se Agrega. 
			            
			            //Abr 28 2017: añado una clase extra al modal para poder maniobrar las medidas por tipo de contenido y le añado un sufijo "linkClass.substr(1)"
						var modalHtml = '<div class="modal window-'+ linkClass.substr(7) +' fade zoom" id="' + hrefToid + '"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-body">' + contenidoModal + '</div></div></div></div>';
			
						var modalTitle = '<div class="modal-header"><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button></div>';
			
						// de momento el footer no se requiere, pero lo dejaremos solo como referencia.
						var modalFooter = '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></div>';
				
			
			    	// Precarga la ventana que contendra la informacion
				        $( 'body' ).append(modalHtml);
				        
				    	// Precarga el espacio del titulo
				        $('#' + hrefToid + ' .modal-content').prepend( modalTitle );	        	
			
				    	// Precarga el espacio del footer
				        $('#' + hrefToid + ' .modal-content').append( modalFooter );	        	
				        
				    	// Si hay titulo, Agrega un H4 en el espacio del titulo
				        if ( attrTittle != null ){
				            $('#' + hrefToid + ' .modal-content .modal-header').append( '<h4 class="modal-title">' + attrTittle +'</div>' );	        	
				        }
				        
				        
			    	// Si el link tiene alguna de las clases, Agrega el contenido	        
				            	
						if ( linkClass == '.modal-iframe' ){
							
				            contenidoModal = '<iframe frameborder="0" scrolling="yes" allowtransparency="true" src="' + dataSrc + '" width="100%" height="100%"></iframe>';
			
				            $('#' + hrefToid + ' .modal-content .modal-body').html( contenidoModal );
			
						} else if ( linkClass == '.modal-image' ){
			
							dataWidth = '';
			
					        contenidoModal = '<img class="img-responsive" src="' + dataSrc + '"/>';
			
				            $('#' + hrefToid + ' .modal-content .modal-body').html( contenidoModal );
			
						} else if ( linkClass == '.modal-include' ){
			
				            $('#' + hrefToid + ' .modal-content .modal-body').load( dataSrc );
			
						} else if ( linkClass == '.modal-text' ){
			
							dataWidth = '20';
							
				            $('#' + hrefToid + ' .modal-content .modal-body').text( dataSrc );
			
						}  
			
			
			
						// Personalizo la medidas de las ventanas modal depende de si existe width, height en el boton.
						 
					    $( '#'+hrefToid ).on('show.bs.modal', function () {
					    	
			
					        $(this).find('.modal-dialog').css({
					                  // modal-dialog abarca el 100% de la ventana.
					                  width: dataWidth + '%', //ancho de ventana
					                  height: dataHeight + '%', //alto de ventana
					                  'padding':'0',
									  'margin': '0',
									  'margin-right': 'auto',
									  'margin-left': 'auto'
					           });
					           
					         $(this).find('.modal-content').css({
					                  'padding':'0'
					          }); 
					           
					         $(this).find('.modal-body').css({
					                  'padding':'0'
					         });
					         
				         //Abr 27, después de añadir la clase auxiliar, le pedimos que ajuste las medidas. 
					         $('.window-iframe').find('.modal-body').css({
				                  // modal body hereda la altura de la ventana
				                  'height': $(window).height() * 0.88
					         });		
					           
					    }); 	
					    
					    // función para ajustar los modals respecto al contenido interno
					    // https://codepen.io/dimbslmh/full/mKfCc
					    function setModalMaxHeight(element) {
					    	  this.$element     = $(element);  
					    	  this.$content     = this.$element.find('.modal-content');
					    	  var borderWidth   = this.$content.outerHeight() - this.$content.innerHeight();
					    	  var dialogMargin  = $(window).width() < 768 ? 20 : 60;
					    	  var contentHeight = $(window).height() - (dialogMargin + borderWidth);
					    	  var headerHeight  = this.$element.find('.modal-header').outerHeight() || 0;
					    	  var footerHeight  = this.$element.find('.modal-footer').outerHeight() || 0;
					    	  var maxHeight     = contentHeight - (headerHeight + footerHeight);

					    	  this.$content.css({
					    	      'overflow': 'hidden'
					    	  });
					    	  
					    	  this.$element
					    	    .find('.modal-body').css({
					    	      'max-height': maxHeight,
					    	      'overflow-y': 'auto'
					    	  });
					    	}

					    	$('.modal').on('show.bs.modal', function() {
					    	  $(this).show();
					    	  setModalMaxHeight(this);
					    	});

					    	$(window).resize(function() {
					    	  if ($('.modal.in').length != 0) {
					    	    setModalMaxHeight($('.modal.in'));
					    	  }
					    	});					    
					    
					    
					    
					    
					    
					    
					    
					    
					    
			
			
			
					// Borrar ventana
					  	$( '#'+hrefToid ).on('hidden.bs.modal', function(){
					    	$(this).remove();
						});				


				});         
		                
			}				

			};
		        
		      // invocar los 4 tipos de modalbox que existen
			ekilinemodals.multipleModals( '.modal-iframe' );
			ekilinemodals.multipleModals( '.modal-image' );
			ekilinemodals.multipleModals( '.modal-include' );
			ekilinemodals.multipleModals( '.modal-text' );     

			
				
			          
	}); 			