/**
 * adminShowgrid.js
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
 * Estudio
 * https://www.tinymce.com/docs/api/tinymce.dom/tinymce.dom.domutils/#addclass
 * https://www.tinymce.com/docs/demo/custom-toolbar-button/
 * https://www.tinymce.com/docs/advanced/creating-a-custom-button/
 * https://stackoverflow.com/questions/3279947/how-to-check-classes-of-node-inside-tinymce
 * https://community.tinymce.com/communityQuestion?id=90661000000Ms8XAAS
 *
 */

( function ( $ ) {
    tinymce.PluginManager.add('custom_mce_button3', function(editor, url) {
    	
        editor.addButton('custom_mce_button3', {
            //icon: false,
            //text: 'B4 Cols',
            // title : 'Show grid',
            title : editor.getLang('ekiline_tinymce.showgrid'),
            image: '../wp-content/themes/ekiline/img/ico-grid.png',
            onclick: function (e) {
            	
        		//editor.insertContent('&nbsp;<b>It\'s my button!</b>&nbsp;');
        		/**
        		 * https://www.tinymce.com/docs/api/tinymce.dom/tinymce.dom.domutils/#addclass
        		 * **https://www.tinymce.com/docs/demo/custom-toolbar-button/
        		 * **https://www.tinymce.com/docs/advanced/creating-a-custom-button/
        		 * **https://stackoverflow.com/questions/3279947/how-to-check-classes-of-node-inside-tinymce
        		 */
				tinymce.activeEditor.dom.toggleClass( tinymce.activeEditor.dom.select('#tinymce'), 'wf-ekiline');

				showf = tinymce.activeEditor.dom.select('#tinymce');
				if ( $(showf).hasClass("wf-ekiline") ) {
					this.active(true); 
				} else {
					this.active(false); 
				}
				
				//https://community.tinymce.com/communityQuestion?id=90661000000Ms8XAAS
				//this.active(true); 
                
            }
        });
    });
} )( jQuery );


