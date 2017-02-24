/*
 * Arreglos jQuery, exclusivos para caracterísitcas del tema
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
		  
		  
		// Carrusel de varios thumbs con avance de uno a uno por 2 thumbs

		$('.single-thumb.x2 .item').each(function(){
		  var next = $(this).next();
		  if (!next.length) {
		    next = $(this).siblings(':first');
		  }
		  next.children(':first-child').clone().appendTo($(this));
		  
		  // variante: 1 = 2thumbs, 2 = 4thumbs y así sucesivamente… también se modifica en el css
		  
		  for (var i=0;i<0;i++) { 
		    next=next.next();
		    if (!next.length) {
		    	next = $(this).siblings(':first');
		  	}
		    
		    next.children(':first-child').clone().appendTo($(this));
		  }
		});	
					
		// Carrusel de varios thumbs con avance de uno a uno por 3 thumbs

			$('.single-thumb.x3 .item').each(function(){
			  var next = $(this).next();
			  if (!next.length) {
			    next = $(this).siblings(':first');
			  }
			  next.children(':first-child').clone().appendTo($(this));
			  
			  // variante: 1 = 3thumbs, 2 = 4thumbs y así sucesivamente… también se modifica en el css
			  
			  for (var i=0;i<1;i++) { 
			    next=next.next();
			    if (!next.length) {
			    	next = $(this).siblings(':first');
			  	}
			    
			    next.children(':first-child').clone().appendTo($(this));
			  }
			});	
			
		// Carrusel de varios thumbs con avance de uno a uno por 4 thumbs

			$('.single-thumb.x4 .item').each(function(){
			  var next = $(this).next();
			  if (!next.length) {
			    next = $(this).siblings(':first');
			  }
			  next.children(':first-child').clone().appendTo($(this));
			  
			  // variante: 1 = 3thumbs, 2 = 4thumbs y así sucesivamente… también se modifica en el css
			  
			  for (var i=0;i<2;i++) { 
			    next=next.next();
			    if (!next.length) {
			    	next = $(this).siblings(':first');
			  	}
			    
			    next.children(':first-child').clone().appendTo($(this));
			  }
			});					
						

		// Carrusel de varios thumbs con avance de uno a uno por 6 thumbs
			
			$('.single-thumb.x6 .item').each(function(){
			  var next = $(this).next();
			  if (!next.length) {
			    next = $(this).siblings(':first');
			  }
			  next.children(':first-child').clone().appendTo($(this));
			  
			  // variante: 1 = 3thumbs, 2 = 4thumbs y así sucesivamente… también se modifica en el css
			  
			  for (var i=0;i<4;i++) { 
			    next=next.next();
			    if (!next.length) {
			    	next = $(this).siblings(':first');
			  	}
			    
			    next.children(':first-child').clone().appendTo($(this));
			  }
			});	
			
			var ekilinemodals = {			
				
			multipleModals: function ( linkClass ) {
				
				/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
				 * 
				 *	ModalBox para diferente contenido
				 * 
				 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * **/			

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
							// pero si no está especificado, dejar las ventanas al 100%
							dataWidth = '100' || dataHeight == '100';
						}
					
					// por el tipo de clase CSS determino el recurso a utilizar
					var dataSrc = $(this).attr('data-src') || null;
					
			        // si hay titulo en el botón genero un modal con titulo 
					var attrTittle = $(this).attr('title') || null;
			
			
					// Declaro mis espacios para insertar el tipo de elemento
			
			            var contenidoModal = ''; // acorde al tipo de contenido este campo se añade.
			            	
						var modalHtml = '<div class="modal fade zoom" id="' + hrefToid + '"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-body">' + contenidoModal + '</div></div></div></div>';
			
						var modalTitle = '<div class="modal-header"><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button></div>';
			
						// de momento el footer no se requiere, pero lo dejaremos solo como referencia.
						var modalFooter = '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></div>';
				
			
			    	// Precarga la ventana que contendrá la información
				        $( 'body' ).append(modalHtml);
				        
				    	// Precarga el espacio del titulo
				        $('#' + hrefToid + ' .modal-content').prepend( modalTitle );	        	
			
				    	// Precarga el espacio del footer
				        $('#' + hrefToid + ' .modal-content').append( modalFooter );	        	
				        
				    	// Si hay titulo, añade un H4 en el espacio del titulo
				        if ( attrTittle != null ){
				            $('#' + hrefToid + ' .modal-content .modal-header').append( '<h4 class="modal-title">' + attrTittle +'</div>' );	        	
				        }
				        
				        
			    	// Si el link tiene alguna de las clases, añade el contenido	        
				            	
						if ( linkClass == '.modal-iframe' ){
			
				            contenidoModal = '<iframe frameborder="0" scrolling="yes" allowtransparency="true" src="' + dataSrc + '" width="100%" height="100%"></iframe>';
			
				            $('#' + hrefToid + ' .modal-content .modal-body').html( contenidoModal );
			
						} else if ( linkClass == '.modal-image' ){
			
							dataWidth = '60';
			
					        contenidoModal = '<img class="img-responsive" src="' + dataSrc + '"/>';
			
				            $('#' + hrefToid + ' .modal-content .modal-body').html( contenidoModal );
			
						} else if ( linkClass == '.modal-include' ){
			
				            $('#' + hrefToid + ' .modal-content .modal-body').load( dataSrc );
			
						} else if ( linkClass == '.modal-text' ){
			
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
					                  'border-radius':'0',
					                  'padding':'0'
					          }); 
					           
					         $(this).find('.modal-body').css({
					                  'padding':'0',
					                  // modal body hereda la altura de la ventana
					                  'height': $(window).height() * 0.81
					           });		           
					           
					           
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