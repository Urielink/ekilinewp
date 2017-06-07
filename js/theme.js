/**
 * ekiline Theme scripts.
 * (http://stackoverflow.com/questions/11159860/how-do-i-add-a-simple-jquery-script-to-wordpress)
 */

	jQuery(document).ready(function($){
    	
		/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
		 * 
		 *	En caso de optimizar la carga de estilos
		 *  Parsear la variable de estilos y crear cada css en el head.
		 *  Revisar esto: http://larryullman.com/forums/index.php?/topic/3558-jquery-ajax-how-to-use-json-to-create-new-html-elements/
		 * 
		 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * **/		
		
		// variable php
		if ( allCss != null ){
			
			var obj = allCss;	
			
			//console.log(allCss);
			
			// crear un estilo por cada ruta extríada.
			
			$.each( obj, function( key, value ) {
					 //alert( key + ": " + value );
			
				var $head = $("head");
				var $wpcss = $head.find("style[id='ekiline-inline']"); 
				var $cssinline = $head.find("style:last");
				var $ultimocss = $head.find("link[rel='stylesheet']:last");
				var linkCss = "<link id='"+ key +"' rel='stylesheet' href='"+ value +"' type='text/css' media='screen'>";
			
			  // En caso de de encontrar una etiqueta de estilo ó link ó nada inserta el otro estilo css, 
			
				if ($wpcss.length){ 
						$wpcss.before(linkCss); 
					} else if ($cssinline.length){ 
						$cssinline.before(linkCss); 
					} else if ($ultimocss.length){ 
						$ultimocss.before(linkCss); 
					} else { 
						$head.append(linkCss); 
					}		
				
			});			
			
		}
	
	
		// El preload
	    setTimeout(function(){
	        $('#pageLoad').fadeOut(500);
	    }, 600);			          
	            
	    // Carrusel con swipe, impedir que avance automaticamente	
	    $('.carousel').carousel({
	    	  interval: false,
	    	  swipe: 30, // percent-per-second, default is 50. Pass false to disable swipe
	    	});	  
                
        // Affix: calcula la altura del header
	    if ( $('#masthead').length ) {	    	
	    	$('.top-navbar.navbar-affix').affix({
		        offset: {
		          top: $('#masthead').height()
		        }
		    });
	    } else {
	    	$('.top-navbar.navbar-affix').affix({
		        offset: {
		          top: $('.top-navbar').height()
		        }
		    });	    		    	
	    }
	    
	    // Tooltips
        $('.tooltip-top').tooltip({ placement: 'top' }); 
        $('.tooltip-right').tooltip({ placement: 'right' }); 
        $('.tooltip-left').tooltip({ placement: 'left' }); 
        $('.tooltip-bottom').tooltip({ placement: 'bottom' }); 
        
        //Pop overs
        $('.popover-top').popover({ placement: 'top' });
        $('.popover-right').popover({ placement: 'right' });
        $('.popover-left').popover({ placement: 'left' });
        $('.popover-bottom').popover({ placement: 'bottom' });
	    
    	
		/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
		 * 
		 *	Agregar clases en items del core de wordpress
		 *	Widgets que no requieren ser sobreescritos (overide)
		 * 
		 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * **/		
				
		$( '.widget_rss ul' ).addClass( 'list-group' );		
		$( '.widget_rss ul li' ).addClass( 'list-group-item' );		
		$( '#calendar_wrap, .calendar_wrap' ).addClass( 'table-responsive');
		$( 'table#wp-calendar' ).addClass( 'table table-striped');
		$( '.widget_text select, .widget_archive select, .widget_categories select' ).addClass( 'form-control');
		$( '.widget_recent_comments ul' ).addClass('list-group');
		$( '.widget_recent_comments ul li' ).addClass( 'list-group-item');		
		$( '.widget_recent_comments ul li' ).addClass( 'list-group-item');		
		$( '.nav-links' ).addClass( 'pager');		
		$( '.nav-links .nav-next' ).addClass( 'next');		
		$( '.nav-links .nav-previous' ).addClass( 'previous');		

		/**  
		 *	Alerta en el formulario de comentarios
		 *	Ejercicio original: http://stackoverflow.com/questions/33440243/wordpress-change-comment-error-message
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
			