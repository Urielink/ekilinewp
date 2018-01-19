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
 * Pase de datos
 * https://www.w3schools.com/js/tryit.asp?filename=tryjson_array_nested
 * https://www.w3schools.com/js/js_json_arrays.asp
 * https://www.codesd.com/item/dynamically-updating-a-tinymce-4-listbox.html
 * https://thewebsitedev.com/dynamic-content-tinymce/
 *
 */

( function ( $ ) {
    tinymce.PluginManager.add('custom_mce_button10', function(editor, url) {
    	        	
        editor.addButton('custom_mce_button10', {
            //icon: false,
            // title : 'Entries module',
            title : editor.getLang('ekiline_tinymce.modcat'),
            image: '../wp-content/themes/ekiline/img/ico-insert.png',
            onclick: function (e) {
            	
            	// console.log(my_plugin);
            	// console.log(my_cats);

                editor.windowManager.open({
                	
                    title: editor.getLang('ekiline_tinymce.modcat'),
                    minWidth: 500,
                    minHeight: 100,

                    body: [
						{
				            type   : 'label',
				            name   : 'description',
				            // text   : 'Choose category and format to show a list of entries'
				            text   : editor.getLang('ekiline_tinymce.modcatdesc')
						},                    
	                    {
	                    	type   : 'listbox', 
	                    	name   : 'tools',
	                    	// obtengo los datos desde mi función. 
						    values : tinyCatList						    
	                	},
                	],                    	
                    onsubmit: function (e) {
                        editor.insertContent( e.data.tools + '<br><br>' );
                    }
                    
                }); //editor.windowManager.open
                
            }
        });
        
    });
        
} )( jQuery );