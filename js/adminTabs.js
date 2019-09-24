/**
 * Ekiline for WordPress Theme, Copyright 2018 Uri Lazcano. Ekiline is distributed under the terms of the GNU GPL. http://ekiline.com
 * 
 * adminTabs.js
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
    tinymce.PluginManager.add('custom_mce_button6', function(editor, url) {
    	
        editor.addButton('custom_mce_button6', {
            //icon: false,
            //title : 'Insert Tabs',
            title : editor.getLang('ekiline_tinymce.addtabs'),
            image: editor.getLang('ekiline_tinymce.themePath')+'/img/ico-tabs.png',
            onclick: function (e) {            	
                editor.windowManager.open({
                	
                    //title: 'Insert Tabs',
		            title : editor.getLang('ekiline_tinymce.addtabs'),
                    minWidth: 500,
                    minHeight: 100,

                    body: [
                    // item 1, map field
						{
                        	type	: 'textbox',
                        	name	: 'tabNumber',
                        	label	: editor.getLang('ekiline_tinymce.tabdesc'),
                    	},	                          	
                	],                    	
                    onsubmit: function (e) {
                    	
                    	/*Declaro mis variables: los tabs, el contador, el limite desde el input y el texto de ejemplo. */
						var tab = '';						
						var i;
						var tbnum = e.data.tabNumber;
						var tbtitle = editor.getLang('ekiline_tinymce.tabtitle');
						var tbcontent = editor.getLang('ekiline_tinymce.tabcont');
						//genero el loop
						for (i = 0; i < tbnum; i++) {
						    //tab += 'tab num ' + i + '<br><br>';
						    //tab += '[tabcontent title="' + tbtitle +'-'+ i + '"]<br><br>' + tbcontent + '[/tabcontent]<br><br>';
						    tab += '[tabcontent title="' + i +'&nbsp;'+ tbtitle + '"]<br><br>' + tbcontent + '<br><br>[/tabcontent]<br><br>';
						}
                    	  
                        editor.insertContent( '[moduletabs]<br><br>' + tab + '[/moduletabs]<br><br>' );
                                                
                    }
                    
                }); //editor.windowManager.open
                
            }
        });
    });
} )( jQuery );
