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
 * Pase de datos
 * https://www.w3schools.com/js/tryit.asp?filename=tryjson_array_nested
 * https://www.w3schools.com/js/js_json_arrays.asp
 * https://www.codesd.com/item/dynamically-updating-a-tinymce-4-listbox.html
 * https://thewebsitedev.com/dynamic-content-tinymce/
 *
 */

( function ( $ ) {
    tinymce.PluginManager.add('custom_mce_button11', function(editor, url) {
    	        	
        editor.addButton('custom_mce_button11', {
            //icon: false,
            // title : 'Custom fields',
            title : editor.getLang('ekiline_tinymce.helpterms'),
            image: '../wp-content/themes/ekiline/img/ico-help.png',
            onclick: function (e) {
            	
            	// console.log(my_plugin);
            	// console.log(my_cats);

                editor.windowManager.open({
                	
                    title: editor.getLang('ekiline_tinymce.helpterms'),
                    minWidth: 500,
                    minHeight: 100,

                    body: [
						{
				            type   : 'label',
				            name   : 'description',
				            // text   : 'Choose and copy the value that help to modify a custom field in your website'
				            text   : editor.getLang('ekiline_tinymce.helpdesc')
						},                    
	                    {
	                    	type   : 'listbox', 
	                    	name   : 'customfields',
	                        'values': [
								{
		                        	// text	: 'Custom title',
		                        	text	: editor.getLang('ekiline_tinymce.ctitle'),
		                        	value	: 'custom_title'
			                    },
								{
		                        	// text	: 'Custom meta description',
		                        	text	: editor.getLang('ekiline_tinymce.cmdes'),
		                        	value	: 'custom_meta_description'
			                    },
								{
		                        	// text	: 'Custom css style',
		                        	text	: editor.getLang('ekiline_tinymce.ccss'),
		                        	value	: 'custom_css_style'
		                    	},
								{
		                        	// text	: 'Custom js script',
		                        	text	: editor.getLang('ekiline_tinymce.cjs'),
		                        	value	: 'custom_js_script'
		                    	}
	                        ]   			    
	                	}                    

                	],                    	
                    onsubmit: function (e) {
                    	// text	: 'Set custom field with:',
                        editor.insertContent( editor.getLang('ekiline_tinymce.addcfname') +'&nbsp;'+ e.data.customfields +'<br><br>' );
                    }
                    
                }); //editor.windowManager.open
                
            }
        });
        
    });
        
} )( jQuery );
