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
            	
                editor.windowManager.open({
                	
                    title: editor.getLang('ekiline_tinymce.addlays'),
                    minWidth: 500,
                    minHeight: 100,

                    body: [
                    // item 1, las columnas
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
	                    	name: 'preset', 
						      values: [
        						  { text: '1', 
        						  	value: 'set 1' },
        						  { text: '2', 
        						  	value: 'set 2' },
        						  { text: '3', 
        						  	value: 'set 3' },
        						  { text: '4', 
        						  	value: 'set 4' },
        						  { text: '5', 
        						  	value: 'set 5' },
        						  { text: '6', 
        						  	value: 'set 6' },
						      ]
	                	},
                	],
                    	
                    onsubmit: function (e) {
                        editor.insertContent( '<div class="ekiline-preset">' + e.data.preset + '</div><br><br>' );
                    }
                    
                }); //editor.windowManager.open
                
            }
        });
    });
} )( jQuery );
