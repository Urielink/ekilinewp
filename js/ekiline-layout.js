/*
 * Arreglos jQuery, exclusivos para caracterisitcas del tema
 */

jQuery(document).ready(function($){
		
	// animar el boton del menu.
	$('.navbar-toggle').on('click', function () {
		$(this).toggleClass('active');
	});		

	/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 * 
	 *	Sidebars ocultar mostrar 
	 * 
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * **/			

	if ( $( 'body.toggle-sidebars' ).length ) {		        
		
	    // Sidebar izquierdo mostrar ocultar
		$("#show-sidebar-left").on('click',function(e) {
	    	e.preventDefault();
	        $(".toggle-sidebars").toggleClass("active-sidebar-left");
		});     
	
	    // Sidebar derecho mostrar ocultar
		$("#show-sidebar-right").on('click',function(e) {
			e.preventDefault();
			$(".toggle-sidebars").toggleClass("active-sidebar-right");
		});         
	}

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

	        } else if ( cThumb.hasClass( 'col-sm-4' ) ){
	        	
	        	$('.carousel-multiple').addClass('x3');           	
        		var slot = 2/2;
	
	        } else if ( cThumb.hasClass( 'col-sm-3' ) ){
	
	        	$('.carousel-multiple').addClass('x4');                
	        	var slot = 2;
	
	        } else if ( cThumb.hasClass( 'col-sm-2' ) ){
	
	        	$('.carousel-multiple').addClass('x6');                
	        	var slot = 2+2;
	
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
	 *	ModalBox para diferente contenido
	 * 
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * **/		
			
	var ekilinemodals = {			
		
		multipleModals: function ( linkClass ) {
			
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

	
	/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 * 
	 *	ModalBox para galeria de imagenes
	 * 
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * **/		
	
	$('.modal-gallery').each(function() {
	    // necesito diferenciar el objeto en cada caso
	    var getId = $(this).attr('id');
	    var rename = '#'+ getId + '.modal-gallery';
	    //console.log( rename );
		
	    // agrega parametros de bootstrap
	    $( rename + ' a:not(.carousel-control)' ).attr({"data-toggle" : "modal","data-target" : "#galleryModal" });    
	        
	    $( rename + ' a:not(.carousel-control)' ).on('click',function(){
	        
	        var gallery = $( rename ).html();
	                
	        var modalgallery = '';
	        modalgallery += '<div class="modal fade zoom" role="dialog" id="galleryModal">\
	                            <div class="modal-dialog">\
	                            <div class="modal-content">\
	                            <div class="modal-body">';
	                            
	        //carrusel                            
	        modalgallery += '<div id="carousel-modal" class="carousel slide carousel-fade" data-ride="carousel">\
	        	<button type="button" class="close" data-dismiss="modal">&times;</button>\
	                          <ol class="carousel-indicators"></ol>\
	                          <div class="carousel-inner" role="listbox">'+ gallery +'</div>\
	                          <a class="left carousel-control" href="#carousel-modal" role="button" data-slide="prev">\
	                            <span class="glyphicon glyphicon-chevron-left"></span>\
	                          </a>\
	                          <a class="right carousel-control" href="#carousel-modal" role="button" data-slide="next">\
	                            <span class="glyphicon glyphicon-chevron-right"></span>\
	                          </a>\
	                        </div>';                  
	                     
	        modalgallery += '</div></div></div></div>';
	        
	        
	        $( modalgallery ).modal('show');
	        
	        // saber a que elemento le dio click        
	        var nc = $(this).index( rename + ' a' );        
	        // console.log(nc);
	
	        
	        // Ejecuta las variables para activarse
	        $('body').on('shown.bs.modal', function(){  
	        	
	            $('.carousel').carousel({ swipe: 100 });	    	    

	                      
	            // busco cada item y limpio las clases reemplazandola por item.
	            $(this).find('#galleryModal .item').removeClass().addClass('item');
	            
	            // busco el link original y guardo la dirección en una variable para cuando elacen la imagen pequeña, se muestre la grande
		            $(this).find('#galleryModal figure a img').each(function(){
		            	//console.log(this);
			            var url = $(this).parent('a').attr('href');
			            //console.log(url);
			            var img = '<img src="'+url+'" />';
			            // console.log(img);
			            $(this).replaceWith(img);
		            });
		        
		        // Busco el rengón de texto y le añado la clase carousel-caption
	            $(this).find('#galleryModal .item .gallery-caption').addClass('carousel-caption');
	            
	            
	            // busco elmentos que no necesito y los elimino
	            $(this).find('#galleryModal .clearfix').remove();
	            $(this).find('#galleryModal figure').removeClass().addClass('text-center');
	            $(this).find('#galleryModal figure img').unwrap();
	            	$(this).find('#galleryModal figure img').unwrap();// esto se hace cada que un envoltorio estorba
	            	$(this).find('#galleryModal figure img').unwrap();// esto se hace cada que un envoltorio estorba
	
	            // busca los slides para hacer un índice.
	            var slides = $('body').find('#galleryModal').find('.item');
	            //console.log(slides);
	                        
	            // saca el total de elmentos que existen.
	            var ns = slides.length;
	            //console.log('hay ' + ns);
	            
	            // limpio los contadores del carrusel (se queda un registro)
	            $(this).find('#galleryModal .carousel-indicators li').remove();            
	            // creo el loop de contadores            
	            for (var i=0; i<ns; i++) {
	                // console.log('intento ' + i);
	                $(this).find('#galleryModal .carousel-indicators').append('<li data-target="#carousel-modal" data-slide-to="'+i+'"></li>');
	            }            
	            
	            // al primer slide activalo
	            //slides.first().addClass('active');
	            // al primer indicador activalo
	            //$(this).find('#galleryModal .carousel-indicators li').first().addClass('active');
	            
	            // de acuerdo al elmento que dio clic, habilitalo.
	            $( slides.eq( nc ) ).addClass('active');
	            $(this).find('#galleryModal .carousel-indicators li').eq( nc ).addClass('active');
	                     
	        }); // fin de activacion
	        
	        // Borrar registro del modal
	        $('body').on('hidden.bs.modal', function(){
	          $( '.modal, .modal-backdrop' ).remove();
	        });             
	        
	   });  
		
	});
		


	/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 * 
	 *	Alerta en el formulario de comentarios
	 *	Ejercicio original: http://stackoverflow.com/questions/33440243/wordpress-change-comment-error-message
	 * 
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * **/			
				
		    /**
		     *  Modal de validaciones.
		     *  1) la estructura de la caja (base bootstrap)
		     *  2) el arreglo para ver las alertas
		     *  3) el arreglo para ver el submit
		     *  4) eliminar el rastro de los modals (este normalmente se acumula si se invoca.)
		     * 
		     */        
		           
		        var modalAbre = '<div class="modal fade" role="dialog"><div class="modal-dialog"><div class="modal-content"><div class="modal-body">\
		                                <button type="button" class="close" data-dismiss="modal">&times;</button>';
		        var msjlAlerta = '<h4 class="text-center">¡Ups! olvidaste un dato</h4><p class="text-center">Por favor llena todos los campos.</p>';  
		        var msjConfirma = '<h4 class="text-center">¡Gracias por tu mensaje!</h4><p class="text-center">Lo revisaremos.</p>';  
		        var modalCierra = '</div></div></div></div>';             
		  
		        
		        $('#commentform').submit(function() {
		            
		            // modal + mensaje
		            var modalbox = modalAbre + msjlAlerta + modalCierra; 
	            	var valEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;	            	
		            
		            // si no estan llenos suelta la alerta
		            if ( $.trim( $("#comment").val() ) === "" || $.trim( $("#author").val() ) === "" || $.trim($("#email").val() ) === "" || valEmail.test( $("#email").val() ) === false || $.trim($("#url").val()) === "" ) {
		            	
            			$( modalbox ).modal('show');
            			
		                return false;
		                		            
		        	} else {

			            // modal + mensaje
			            var modalbox = modalAbre + msjConfirma + modalCierra;    
			            // el formulario ok suelta la confirmación          
			            $( modalbox ).modal("show");   
			            // cuando el usuario cierre la ventana, envialo a la otra página. 
			            // $( 'body' ).on('hidden.bs.modal', function(){
			              // window.location.href = 'gracias.html';    
			            // });             		            
		            }
		            
		        });		           
		        
		        // Borrar registro del modal
		        $( 'body' ).on('hidden.bs.modal', function(){
		          $( '.modal, .modal-backdrop' ).remove();
		        });             
		        
			
			
}); 			