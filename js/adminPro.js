/**
 * Ekiline for WordPress Theme, Copyright 2018 Uri Lazcano. Ekiline is distributed under the terms of the GNU GPL. http://ekiline.com
 * 
 * adminCustom.js
 *
 * Dic 15 2017, layouts o grid:
 * Casos de estudio
 * https://stackoverflow.com/questions/24695323/tinymce-listbox-onsubmit-giving-object-object-rather-than-value
 * https://stackoverflow.com/questions/23476463/wordpress-tinymce-add-a-description-to-a-popup-form
 * https://stackoverflow.com/questions/1582251/how-to-load-html-using-jquery-into-a-tinymce-textarea
 * 
 * Oficial tinyMce.
 * https://www.tinymce.com/docs/advanced/creating-custom-dialogs/
 * https://www.tinymce.com/docs/demo/custom-toolbar-listbox/
 * https://www.tinymce.com/docs/plugins/template/#templates
 * 
 * Ejemplo de dialogo
 * https://jsfiddle.net/aeutaoLf/2/
 *
 */

( function ( $ ) {
    tinymce.PluginManager.add('custom_mce_button16', function(editor, url) {
    	    	
        editor.addButton('custom_mce_button16', {
            //icon: false,
            // title : 'Get more',
            title : editor.getLang('ekiline_tinymce.getMore'),
            image: '../wp-content/themes/ekiline/img/ico-ekiline.png',
            onclick: function (e) {
            	
            		var notification = '<div style="text-align:center;">';
            			notification +='<h1 style="font-size: 24px;text-align: center;">'+ editor.getLang('ekiline_tinymce.getMoreTitle') +'</h1>';
            			notification +='<p style="text-align: center;padding: 8px 0px;font-size: 16px;">'+ editor.getLang('ekiline_tinymce.getMoreDesc') +'</p>';
            			notification +='<p style="text-align: center;padding: 8px 0px;margin-bottom:14px;font-size: 16px;background-color: #f0f0f0;">';
            			notification +='<img src="../wp-content/themes/ekiline/img/ico-grid.png" style="margin-right:10px;">';
            			notification +='<img src="../wp-content/themes/ekiline/img/ico-cols.png" style="margin-right:10px;">';
            			notification +='<img src="../wp-content/themes/ekiline/img/ico-bg.png" style="margin-right:10px;">';
            			notification +='<img src="../wp-content/themes/ekiline/img/ico-tabs.png" style="margin-right:10px;">';
            			notification +='<img src="../wp-content/themes/ekiline/img/ico-toggle.png" style="margin-right:10px;">';
            			notification +='<img src="../wp-content/themes/ekiline/img/ico-tooltip.png" style="margin-right:10px;">';
            			notification +='<img src="../wp-content/themes/ekiline/img/ico-modal.png" style="margin-right:10px;">';
            			notification +='<img src="../wp-content/themes/ekiline/img/ico-insert.png" style="margin-right:10px;">';
            			notification +='<img src="../wp-content/themes/ekiline/img/ico-layout.png" style="margin-right:10px;">';
            			notification +='<img src="../wp-content/themes/ekiline/img/ico-custom.png" style="margin-right:10px;">';
            			notification +='<img src="../wp-content/themes/ekiline/img/ico-gmap.png" style="margin-right:10px;">';
            			notification +='<img src="../wp-content/themes/ekiline/img/ico-share.png" style="margin-right:10px;">';
            			notification +='<img src="../wp-content/themes/ekiline/img/ico-faw.png" style="margin-right:10px;">';
            			notification +='</p><p style="text-align: center;">';
            			notification +='<a class="button button-primary button-hero" href="http://ekiline.com/compra/" target="_blank">'+ editor.getLang('ekiline_tinymce.getMoreBuy') +'</a>';
        				notification +='<p/>';
    					notification +='</div>';

					//ejecutar el editor								
	                editor.windowManager.open({
	                	
			            // title : 'Get more',
	                    title: editor.getLang('ekiline_tinymce.getMore'),
	                    minWidth: 500,
	                    minHeight: 100,
	
	                    body: [
	                    // item 1, las plantillas
							{
					            type   : 'container',
					            name   : 'description',
                    			html   : notification
							},   
	                	],

	                }); //editor.windowManager.open 
					    				    				    									
	           
            } //fin onclick
        });

    });
} )( jQuery );
