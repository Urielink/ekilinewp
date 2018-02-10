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
            	
            	// Obtengo plantillas de PHP y lo guardo en una variable
            	// https://stackoverflow.com/questions/1582251/how-to-load-html-using-jquery-into-a-tinymce-textarea
            	// https://www.tinymce.com/docs/plugins/template/#templates

/**				$.get('../wp-content/themes/ekiline/inc/adminLibrary.php', function(data){
				   $('#preset').val( data );
				});            	**/
					
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
/**						{
                        	type	: 'textbox',
                        	//subtype	: 'hidden',
                        	name	: 'preset',
                        	id	: 'preset',
                        	value : ''
                    	},**/
	                    {
	                    	type: 'listbox', 
	                    	name: 'choose', 
						      values: [
        						  { text: 'set 1', 
        						  	value: 'album' },
        						  { text: 'set 2', 
        						  	value: 'cards' },
        						  { text: 'set 3', 
        						  	value: '3' },
        						  { text: 'set 4', 
        						  	value: '4' },
        						  { text: 'set 5', 
        						  	value: '5' },
        						  { text: 'set 6', 
        						  	value: '6' },
						      ]
	                	},
                	],
                    	
/**                    onsubmit: function (e) {
                    	
                    	var choose = e.data.choose;
                    	var preset = e.data.preset;
                    	
                    	console.log(choose);                    	
                    	//console.log(preset);                    	

                        //editor.insertContent( '<div class="ekiline-preset">' + e.data.preset + '</div><br><br>' );
                        
						// create element and set string as it's content
						var $preset = $('<div class="layout">').html( preset );
						
						// modify attributes
						//$preset.find('#'+choose).css('color', 'red' );
						$preset = $preset.find('#'+choose).clone();
						$preset = $('<div class="layout2">').html( $preset );
						
						// return modified content to string
						var processedHTML = $preset.html();
						
						console.log(processedHTML);

                        editor.insertContent( processedHTML + '<br><br>' );

// corto                        
                    	//var choose = e.data.choose;
                    	//var preset = $('<div>').html($('<div>').html( e.data.preset ).find('#'+choose).clone());
                        //editor.insertContent( preset.html() + '<br><br>' );  
               	
                    }**/
                   
                   onsubmit: function(e){
                   	
					$.get('../wp-content/themes/ekiline/inc/adminLibrary.php', function(data){
                    	var choose = e.data.choose;
                    	console.log(choose);
                    	var preset = $('<div>').html( $('<div>').html( data ).find('#'+choose).clone() ).html();
                    	console.log(preset);
                        editor.insertContent( preset + '<br><br>' );  
					});            	

                   }
                    
                }); //editor.windowManager.open
                
            }
        });
    });
} )( jQuery );
