/**
 * adminEditor.js
 *
 * Dic 15 2017, layouts o grid:
 * Casos de estudio
 * https://stackoverflow.com/questions/24695323/tinymce-listbox-onsubmit-giving-object-object-rather-than-value
 * https://stackoverflow.com/questions/23476463/wordpress-tinymce-add-a-description-to-a-popup-form
 * 
 * Oficial tinyMce.
 * https://www.tinymce.com/docs/advanced/creating-custom-dialogs/
 * https://www.tinymce.com/docs/demo/custom-toolbar-listbox/
 * 
 * Ejemplo de dialogo
 * https://jsfiddle.net/aeutaoLf/2/
 *
 */

( function ( $ ) {
    tinymce.PluginManager.add('custom_mce_button13', function(editor, url) {
    	    	
        editor.addButton('custom_mce_button13', {
            //icon: false,
            //text: 'Quick designs',
            // title : 'Quick designs',
            title : editor.getLang('ekiline_tinymce.addlays'),
            image: '../wp-content/themes/ekiline/img/ico-layout.png',
            onclick: function (e) {
            
	            //llamar el catalogo de diseños
	        	$.get('../wp-content/themes/ekiline/inc/adminLibrary.php', function(laysrc){
					
					// crear variable para cadena de JSON											
				    jsonObj = [];
				    
				    // Loop de extracción 
				    $('<div/>',{ html:laysrc }).children().each(function() {
				    							
				        var nameId = $(this).attr("id");
				
				        item = {};
				        item ["text"] = nameId;
				        item ["value"] = nameId;
				
				        jsonObj.push(item);
				        
				    });
				    
				    //console.log(JSON.stringify(jsonObj));
					    
					//ejecutar el editor								
	                editor.windowManager.open({
	                	
	                    title: editor.getLang('ekiline_tinymce.addlays'),
	                    minWidth: 500,
	                    minHeight: 100,
	
	                    body: [
	                    // item 1, las plantillas
							{
					            type   : 'label',
					            name   : 'description',
					            //label  : 'HTML presets',
					            label  : editor.getLang('ekiline_tinymce.laylab'),
					            // text   : 'Choose a design to create an amazing publication'
					            text   : editor.getLang('ekiline_tinymce.laytext')
							},   
		                    {
		                    	type: 'listbox', 
		                    	name: 'choose', 
		                    	id: 'choose', 
		                    	// JSON loop para textbox
							    'values' : jsonObj	
		                	},
	                	],
	                	
	                   onsubmit: function(e){
	                   	
			            	// Obtengo plantillas de PHP y lo guardo en una variable
			            	// https://stackoverflow.com/questions/1582251/how-to-load-html-using-jquery-into-a-tinymce-textarea
			            	// https://www.tinymce.com/docs/plugins/template/#templates
	
							//$.get('../wp-content/themes/ekiline/inc/adminLibrary.php', function(data){
		                    	var choose = e.data.choose;
		                    	//console.log(choose);
		                    	var preset = $('<div/>').html( $('<div/>').html( laysrc ).find('#'+choose).clone() ).html();
		                    	//console.log(preset);
		                        editor.insertContent( preset + '<br><br>' );  
							//});            	
	                   }
	                    
	                }); //editor.windowManager.open 
					    				    				    									
				});	//fin $.get()
	           
            } //fin onclick
        });

    });
} )( jQuery );
