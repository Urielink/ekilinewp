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
        						  { text: 'set 1', 
        						  	value: 'album' },
        						  { text: 'set 2', 
        						  	value: 'cards' },
        						  { text: 'set 3', 
        						  	value: '3' },
        						  { text: 'set 4', 
        						  	value: '4' },
        						  { text: 'set 5', 
        						  	value: '5' },
        						  { text: 'set 6', 
        						  	value: '6' },
						      ]
	                	},
                	],
                    	
                    onsubmit: function (e) {
                        // editor.insertContent( '<div class="ekiline-preset">' + e.data.preset + '</div><br><br>' );
                    	var choose = e.data.preset;

		            	// Obtengo el archivo de plantillas y lo guardo en una variable
		            	// https://stackoverflow.com/questions/1582251/how-to-load-html-using-jquery-into-a-tinymce-textarea
		            	// https://www.tinymce.com/docs/plugins/template/#templates
		            	// ejercicio 1
						// $.get('../wp-content/themes/ekiline/js/adminLibrary.html', function(content) {
// 
						// var nucontent = $('<div class="dada">').html( content ).html();	
// 						
						// console.log(nucontent);
// 						
							// nucontent = $(nucontent).find('#album').css('background-color','red');
// 
							// console.log(nucontent);
// 								                        
// 
	                        // editor.insertContent( nucontent + '<br><br>' );
// 	                        
						// });		
						
//test2 https://stackoverflow.com/questions/9958282/how-do-i-load-html-into-a-variable-with-jquery

						// $.get('../wp-content/themes/ekiline/js/adminLibrary.html', function( content ) {
// 
	                        // editor.insertContent( content + '<br><br>' );
// 	                        
						// }, 'html');
						
// test3  https://stackoverflow.com/questions/16885538/how-to-load-an-html-fragment-with-jquery-ajax

							// $.get( '../wp-content/themes/ekiline/js/adminLibrary.html', { id : "album" } )
							  // .done(function( data ) {
							    // alert( "Data Loaded: " + data );
							  // }, 'html');						
						
							$.get( '../wp-content/themes/ekiline/js/adminLibrary.html', function( data ) {
							  var content = $(data).html();
							  console.log(content);

							  //editor.insertContent( content + '<br><br>' );
							}, 'html');
						
						
						
                    	
                    }
                    
                }); //editor.windowManager.open
                
            }
        });
    });
} )( jQuery );
