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
    tinymce.PluginManager.add('custom_mce_button7', function(editor, url) {
    	
        editor.addButton('custom_mce_button7', {
            //icon: false,
            //title : 'Toggle item',
            title : editor.getLang('ekiline_tinymce.addtoggle'),
            image: '../wp-content/themes/ekiline/img/ico-toggle.png',
            onclick: function (e) {            	
                editor.windowManager.open({
                	
                    //title: 'Toggle Item',
		            title : editor.getLang('ekiline_tinymce.addtoggle'),
                    minWidth: 500,
                    minHeight: 100,

                    body: [
                    // item 1, numbe of items
						{
                        	type	: 'textbox',
                        	name	: 'toggNumber',
                        	//label	: 'Insert a single toggle item o multiple accordion items',
                        	label	: editor.getLang('ekiline_tinymce.togdesc'),
                    	},	                          	
                	],                    	
                    onsubmit: function (e) {
                    	
                    	/*Declaro mis variables: los tabs, el contador, el limite desde el input y el texto de ejemplo. */
						var toggle = '';						
						var i;
						var tgnum = e.data.toggNumber;
						var tgid = Math.floor(Math.random() * 100) + 1; // unique id
						var tgtitle = editor.getLang('ekiline_tinymce.togtitle'); //Title this toggle item
						var tgcontent = editor.getLang('ekiline_tinymce.togcont'); //Add any content with format, text, images, galleries.
						
						//genero el loop; necesito diferenciar cada tab para el ejemplo.
						for (i = 0; i < tgnum; i++) {
						    toggle += '[collpasecontent title="' + tgid + i +'&nbsp;'+ tgtitle + '"]<br><br>' + tgcontent + '<br><br>[/collpasecontent]<br><br>';
						}
                    	
                    	if( tgnum == '1' ){
                    		
                            editor.insertContent( '[singlecollapse title="' + tgid +'&nbsp;'+ tgtitle + '"]<br><br>' + tgcontent + '<br><br>[/singlecollapse]<br><br>' );
                		
                    	} else if ( tgnum > '1' ) {
                    		
	                        editor.insertContent( '[modulegroupcollapse]<br><br>' + toggle + '[/modulegroupcollapse]<br><br>' );
                    		
                    	}
                    	  
                        
                        

                                                
                    }
                    
                }); //editor.windowManager.open
                
            }
        });
    });
} )( jQuery );
