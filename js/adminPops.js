/**
 * Ekiline for WordPress Theme, Copyright 2018 Uri Lazcano. Ekiline is distributed under the terms of the GNU GPL. http://ekiline.com
 * 
 * adminPops.js
 * 
 * Oficial tinyMce.
 * https://www.tinymce.com/docs/advanced/creating-custom-dialogs/
 * https://www.tinymce.com/docs/demo/custom-toolbar-listbox/
 * 
 * Ejemplo de dialogo
 * https://jsfiddle.net/aeutaoLf/2/
 * 
 * Estudio:
 * https://www.tinymce.com/docs/api/tinymce.dom/tinymce.dom.selection/#setcontent
 * http://archive.tinymce.com/wiki.php/api4:method.tinymce.dom.DOMUtils.setAttribs
 *
 */

( function ( $ ) {
    tinymce.PluginManager.add('custom_mce_button8', function(editor, url) {
    	
        editor.addButton('custom_mce_button8', {
            //icon: false,
            //title : 'Tooltips',
            //text: 'Tooltips',
            title : editor.getLang('ekiline_tinymce.addtooltips'),
            image: editor.getLang('ekiline_tinymce.themePath')+'/img/ico-tooltip.png',
            onclick: function (e) {
            	
            	//1) inicio la seleccion del objeto
            	editor.focus();  
            	
                editor.windowManager.open({
                	
                    //title: 'Create a tooltip or popover item',
		            title : editor.getLang('ekiline_tinymce.ttiptitlex'),
                    minWidth: 500,
                    minHeight: 100,

                    body: [
						{
                        	type	: 'label',
		                    //text: 'By default you set a tooltip adding only title and position. If you fill all fields tooltip transforms to popover.',
                        	text	: editor.getLang('ekiline_tinymce.ttipdesc'),
                    	},
                    // item 1, titulo de tooltip
						{
				            //label   : 'Set title to item',
				            label   : editor.getLang('ekiline_tinymce.tttitle'),
                        	type	: 'textbox',
                        	name	: 'title',
                        	value 	: '',
                    	},
                    // item 2, si tiene descripcion entonces es un popover
						{
				            //label   : 'Set description to item',
				            label   : editor.getLang('ekiline_tinymce.ttdesc'),
                        	type	: 'textbox',
	                        multiline: true,
	                        minWidth: 500,
	                        minHeight: 100,
	                        //placeholder: 'Add your text',
	                        placeholder: editor.getLang('ekiline_tinymce.ttplace'),
                        	name	: 'desc',
                        	value 	: '',
                    	},
                    // item 3, Si tiene etiquetas HTML entonces es un popover enriquecido
						{
				            label   : 'Allow HTML content',
				            label   : editor.getLang('ekiline_tinymce.ttcheck'),
                        	type	: 'checkbox',
                        	name	: 'richpop',
                        	value	: '',
                    	},                    	
                    // item 4, posision para mostrar
						{
				            //label   : 'Set position to show pop item',
				            label   : editor.getLang('ekiline_tinymce.ttpos'),
                        	type	: 'listbox',
                        	name	: 'show',
	                        'values': [
								{
		                        	// text	: 'Top',
		                        	text	: editor.getLang('ekiline_tinymce.top'),
		                        	value	: 'top'
		                    	},
								{
		                        	// text	: 'Right',
		                        	text	: editor.getLang('ekiline_tinymce.right'),
		                        	value	: 'right'
		                    	},
								{
		                        	// text	: 'Bottom',
		                        	text	: editor.getLang('ekiline_tinymce.bottom'),
		                        	value	: 'bottom'
		                    	},
								{
		                        	// text	: 'Left',
		                        	text	: editor.getLang('ekiline_tinymce.left'),
		                        	value	: 'left'
		                    	}
	                        ]                        	
                    	},
	                          	
                	],                    	
                    onsubmit: function (e) {
						// Reservo mi selección
						var selection = editor.selection.getContent();
                    	// establezco mis variables acorde al dato
						var poptitle = e.data.title;
						var popdesc = e.data.desc;
						var rich = e.data.richpop;
						var popshow = e.data.show;
						// creo un diferenciador
						var id = Math.floor(Math.random() * 100) + 1; // unique id	
						// reservo el espacio de mis atributos
						var atts = '';
						// creo la etiqueta general				
						var poptag = '';						
						var pophtml = '';						
								
						// el metodo en cada caso:															
						// if( popdesc ){							
							// poptitle = poptitle + '&nbsp;' + popdesc;
							// if( rich ){
								// poptitle += '&nbsp;con HTML';
							// } 							
						// } 
						
						if( popdesc == '' ){
							poptag = '<a class="tooltip-default" title="' + poptitle + '" href="#" data-placement="' + popshow + '">' + selection + '</a>';
						} else if ( popdesc != '' && rich == false ){
							poptag = '<a class="popover-default" title="' + poptitle + '" href="#popover" data-content="' + popdesc + '" data-placement="' + popshow + '">' + selection + '</a>';
						} else if ( popdesc != '' && rich == true ){
							poptag = '<a class="popover-rich" title="' + poptitle + '" href="#pop' + id + '" data-placement="' + popshow + '">' + selection + '</a>';
							//pophtml = '<div id="pop' + id + '">' + popdesc + '</div>';
						}
						
						
						// formatos OK.
						//<a class="tooltip-default" title="Mensaje de muestra" href="#" data-placement="top">Tooltip top</a>
						//<a class="popover-default" title="titulo de popover" href="#popover" data-content="contenido de popover" data-placement="bottom">Popover bottom</a>
						//<a class="popover-rich" title="Pop Over con contenido HTML" href="#contenidoHTML" data-placement="right">Popover con HTML</a>
						//<p id="contenidoHTML">Nullam quis risus eget urna mollis ornare vel eu leo.</p>


						//2) añado el contenido al rededor del objeto: https://www.tinymce.com/docs/api/tinymce.dom/tinymce.dom.selection/#setcontent
                        //editor.selection.setContent('<h1>' + editor.selection.getContent() + '</h1>');
                        editor.selection.setContent( poptag );
                        
                        if ( popdesc != '' && rich == true ){
	                        //agregar contenido al final: http://archive.tinymce.com/wiki.php/API3:method.tinymce.dom.DOMUtils.add, 
	                        //attrs: http://archive.tinymce.com/wiki.php/api4:method.tinymce.dom.DOMUtils.setAttribs;
	                        editor.dom.add( editor.getBody(), 'div', { id : 'pop' + id, 'class' : 'dotted' }, popdesc );
                    	}
                    	
                    }
                    
                }); //editor.windowManager.open
                
            }
        });
    });
} )( jQuery );
