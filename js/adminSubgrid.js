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
 */

( function ( $ ) {
    tinymce.PluginManager.add('custom_mce_button2', function(editor, url) {
    	
        editor.addButton('custom_mce_button2', {
            //icon: false,
            //text: 'B4 Cols',
            title : 'Insertar columnas',
            image: '../wp-content/themes/ekiline/img/ico-cols.png',
            onclick: function (e) {
            	
                editor.windowManager.open({
                	
                    title: 'Insertar columnas',
                    minWidth: 500,
                    minHeight: 100,

                    body: [
                    // item 1, las columnas
	                    {
	                    	type: 'listbox', 
	                    	name: 'column', 
	                    	label: 'Columns', 
						      values: [
        						  { text: 'Col 2', value: '<div class="col-sm-6">Column 1</div><div class="col-sm-6">Column 2</div>' },
        						  { text: 'Col 3', value: '<div class="col-sm-4">Column 1</div><div class="col-sm-4">Column 2</div><div class="col-sm-4">Column 3</div>' },
        						  { text: 'Col 4', value: '<div class="col-sm-3">Column 1</div><div class="col-sm-3">Column 2</div><div class="col-sm-3">Column 3</div><div class="col-sm-3">Column 4</div>' },
        						  { text: 'Col 6', value: '<div class="col-sm-2">Column 1</div><div class="col-sm-2">Column 2</div><div class="col-sm-2">Column 3</div><div class="col-sm-2">Column 4</div><div class="col-sm-2">Column 5</div><div class="col-sm-2">Column 6</div>' },
						      ]
	                	},
                	],
                    	
                    onsubmit: function (e) {
                        editor.insertContent( '<div class="row">' + e.data.column + '</div>' );
                    }
                    
                }); //editor.windowManager.open
                
            }
        });
    });
} )( jQuery );
