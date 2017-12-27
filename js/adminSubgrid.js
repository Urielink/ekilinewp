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
				            type   : 'label',
				            name   : 'description',
				            label  : 'Columnas',
				            text   : 'Las columnas se crean a proporción'
						},                    
	                    {
	                    	type: 'listbox', 
	                    	name: 'column', 
	                    	//label: 'Columnas', 
	                    	//text: 'Las columnas se insertan de manera proporcional', 
						      values: [
        						  { text: '1 columna', value: '<div class="col-sm-6">Columna 1</div>' },
        						  { text: '2 columnas', value: '<div class="col-sm-6">Columna 1</div><div class="col-sm-6">Columna 2</div>' },
        						  { text: '3 columnas', value: '<div class="col-sm-4">Columna 1</div><div class="col-sm-4">Columna 2</div><div class="col-sm-4">Columna 3</div>' },
        						  { text: '4 columnas', value: '<div class="col-sm-3">Columna 1</div><div class="col-sm-3">Columna 2</div><div class="col-sm-3">Columna 3</div><div class="col-sm-3">Columna 4</div>' },
        						  { text: '5 columnas', value: '<div class="col-sm">Columna 1</div><div class="col-sm">Columna 2</div><div class="col-sm">Columna 3</div><div class="col-sm">Columna 4</div><div class="col-sm">Columna 5</div>' },
        						  { text: '6 columnas', value: '<div class="col-sm-2">Columna 1</div><div class="col-sm-2">Columna 2</div><div class="col-sm-2">Columna 3</div><div class="col-sm-2">Columna 4</div><div class="col-sm-2">Columna 5</div><div class="col-sm-2">Columna 6</div>' },
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
