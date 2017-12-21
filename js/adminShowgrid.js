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
    tinymce.PluginManager.add('custom_mce_button3', function(editor, url) {
    	
        editor.addButton('custom_mce_button3', {
            //icon: false,
            //text: 'B4 Cols',
            title : 'Mostrar columnas',
            image: '../wp-content/themes/ekiline/img/ico-grid.png',
            onclick: function (e) {
            	
        		//editor.insertContent('&nbsp;<b>It\'s my button!</b>&nbsp;');
        		/**
        		 * https://www.tinymce.com/docs/api/tinymce.dom/tinymce.dom.domutils/#addclass
        		 * **https://www.tinymce.com/docs/demo/custom-toolbar-button/
        		 * **https://www.tinymce.com/docs/advanced/creating-a-custom-button/
        		 */
				tinymce.activeEditor.dom.toggleClass( tinymce.activeEditor.dom.select('#tinymce'), 'wf-ekiline');
				
				this.active(true); //https://community.tinymce.com/communityQuestion?id=90661000000Ms8XAAS

        		
                
            }
        });
    });
} )( jQuery );


