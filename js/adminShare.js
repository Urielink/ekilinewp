/**
 * Ekiline for WordPress Theme, Copyright 2018 Uri Lazcano. Ekiline is distributed under the terms of the GNU GPL. http://ekiline.com
 * 
 * adminShare.js
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
    tinymce.PluginManager.add('custom_mce_button9', function(editor, url) {
    	
        editor.addButton('custom_mce_button9', {
            //icon: false,
            // title : 'Social tools',
            title : editor.getLang('ekiline_tinymce.share'),
            image: '../wp-content/themes/ekiline/img/ico-share.png',
            onclick: function (e) {
            	
                editor.windowManager.open({
                	
                    title: editor.getLang('ekiline_tinymce.share'),
                    minWidth: 500,
                    minHeight: 100,

                    body: [
						{
				            type   : 'label',
				            name   : 'description',
				            // text   : 'Choose a shortcode to enhance your page, '
				            text   : editor.getLang('ekiline_tinymce.sharetext')
						},                    
	                    {
	                    	type: 'listbox', 
	                    	name: 'tools', 
						      values: [
						      //Your social links nav
        						  { text: editor.getLang('ekiline_tinymce.socialnet'), value: '[socialmenu]' },
						      //Share nav for visitors
        						  { text: editor.getLang('ekiline_tinymce.socialshare'), value: '[socialsharemenu]' },
						      //Insert a login form
        						  { text: editor.getLang('ekiline_tinymce.loginform'), value: '[loginform]' },
						      ]
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
