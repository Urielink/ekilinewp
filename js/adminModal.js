/**
 * Ekiline for WordPress Theme, Copyright 2018 Uri Lazcano. Ekiline is distributed under the terms of the GNU GPL. http://ekiline.com
 * 
 * adminModal.js
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
    tinymce.PluginManager.add('custom_mce_button12', function(editor, url) {
    	
        editor.addButton('custom_mce_button12', {
            //icon: false,
            //title : 'Modal box',
            //text: 'Modal box',
            title : editor.getLang('ekiline_tinymce.addmodal'),
            image: editor.getLang('ekiline_tinymce.themePath')+'/img/ico-modal.png',
            onclick: function (e) {
            	
            	//1) inicio la seleccion del objeto
            	editor.focus();  
            	
                editor.windowManager.open({
                	
                    //title: 'Create a modalbox with custom content',
		            title : editor.getLang('ekiline_tinymce.modaltitle'),
                    minWidth: 500,
                    minHeight: 100,

                    body: [
						{
                        	type	: 'label',
		                    //text: 'Assign modal on selected item, set title and edit content',
                        	text	: editor.getLang('ekiline_tinymce.modaldesc'),
                    	},
                    // item 1, titulo de modal, si no hay, no muestra header
						{
				            //label   : 'Set title to modal',
				            label   : editor.getLang('ekiline_tinymce.mbxtitle'),
                        	type	: 'textbox',
                        	name	: 'title',
                        	value 	: '',
                    	},
                    // item 2, Contenido
						{
				            //label   : 'Set modal content, text, images hard code HTML.',
				            label   : editor.getLang('ekiline_tinymce.mbxdesc'),
                        	type	: 'textbox',
	                        multiline: true,
	                        minWidth: 500,
	                        minHeight: 100,
	                        //placeholder: 'Add your text',
	                        placeholder: editor.getLang('ekiline_tinymce.ttplace'),
                        	name	: 'desc',
                        	value 	: '',
                    	},
	                          	
                	],                    	
                    onsubmit: function (e) {
						// Reservo mi selección
						var selection = editor.selection.getContent();
						//console.log(selection);
                    	// establezco mis variables acorde al dato
						var modaltitle = e.data.title;
						var modalbody = e.data.desc;
						// creo un diferenciador
						var id = Math.floor(Math.random() * 100) + 1; // unique id									
						// creo la etiqueta general				
						var linktag = '';
												
						if ( modalbody != '' ){

							if ( modaltitle != '' ){
								modaltitle = ' title="' + modaltitle + '" ';
							}
							
							linktag = '<a class="modal-inline"' + modaltitle + 'href="#mbox' + id + '">' + selection + '</a>';

	                        editor.selection.setContent( linktag );							
	                        editor.dom.add( editor.getBody(), 'div', { 'class' : 'mbox' + id + ' dotted' }, modalbody );
                    	}
                    	
                    }
                    
                }); //editor.windowManager.open
                
            }
        });
    });
} )( jQuery );
