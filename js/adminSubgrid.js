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
    tinymce.PluginManager.add('custom_mce_button2', function(editor, url) {
    	
        editor.addButton('custom_mce_button2', {
            //icon: false,
            //text: 'B4 Cols',
            title : 'Add columns',
            image: '../wp-content/themes/ekiline/img/ico-cols.png',
            onclick: function (e) {
            	
                editor.windowManager.open({
                	
                    title: 'Add columns',
                    minWidth: 500,
                    minHeight: 100,

                    body: [
                    // item 1, las columnas
						{
				            type   : 'label',
				            name   : 'description',
				            label  : 'Columns',
				            text   : 'Each column is inserted by proportion'
						},                    
	                    {
	                    	type: 'listbox', 
	                    	name: 'column', 
						      values: [
        						  { text: '1 column', value: '<div class="col-sm-6"><p>Col 1</p></div>' },
        						  { text: '2 columns', value: '<div class="col-sm-6"><p>Col 1</p></div><div class="col-sm-6"><p>Col 2</p></div>' },
        						  { text: '3 columns', value: '<div class="col-sm-4"><p>Col 1</p></div><div class="col-sm-4"><p>Col 2</p></div><div class="col-sm-4"><p>Col 3</p></div>' },
        						  { text: '4 columns', value: '<div class="col-sm-3"><p>Col 1</p></div><div class="col-sm-3"><p>Col 2</p></div><div class="col-sm-3"><p>Col 3</p></div><div class="col-sm-3"><p>Col 4</p></div>' },
        						  { text: '5 columns', value: '<div class="col-sm"><p>Col 1</p></div><div class="col-sm"><p>Col 2</p></div><div class="col-sm"><p>Col 3</p></div><div class="col-sm"><p>Col 4</p></div><div class="col-sm"><p>Col 5</p></div>' },
        						  { text: '6 columns', value: '<div class="col-sm-2"><p>Col 1</p></div><div class="col-sm-2"><p>Col 2</p></div><div class="col-sm-2"><p>Col 3</p></div><div class="col-sm-2"><p>Col 4</p></div><div class="col-sm-2"><p>Col 5</p></div><div class="col-sm-2"><p>Col 6</p></div>' },
						      ]
	                	},
                	],
                    	
                    onsubmit: function (e) {
                        editor.insertContent( '<div class="row">' + e.data.column + '</div><br><br>' );
                    }
                    
                }); //editor.windowManager.open
                
            }
        });
    });
} )( jQuery );
