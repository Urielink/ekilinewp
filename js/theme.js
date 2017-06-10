/**
 * ekiline Theme scripts.
 * (http://stackoverflow.com/questions/11159860/how-do-i-add-a-simple-jquery-script-to-wordpress)
 */

	jQuery(document).ready(function($){

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
			