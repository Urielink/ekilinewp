/**
 * Ekiline for WordPress Theme, Copyright 2018 Uri Lazcano. Ekiline is distributed under the terms of the GNU GPL. http://ekiline.com
 * 
 * adminEditor.js
 *
 * Oct 11 2017, añadir tareas al tinymce:
 * https://wordpress.stackexchange.com/questions/235020/how-to-add-insert-edit-link-button-in-custom-popup-tinymce-window 
 * Otro estudio:
 * https://jamesdigioia.com/add-button-pop-wordpresss-tinymce-editor/
 * Un tutorial:
 * https://dobsondev.com/2015/10/16/custom-tinymce-buttons-in-wordpress/
 * http://archive.tinymce.com/wiki.php/API3:method.tinymce.dom.DOMUtils.add
 *
 */

( function ( $ ) {
    tinymce.PluginManager.add('custom_mce_button1', function(editor, url) {
        editor.addButton('custom_mce_button1', {
            icon: false,
            text: 'THE_TEXT_OF_THE_BUTTON',
            onclick: function (e) {
                editor.windowManager.open( {
                    title: 'THE_TITLE_OF_THE_POPUP_WINDOW',
                    id: 'plugin-slug-insert-dialog', // El ejercicio original no invoca la clase del item, le añadí un ID.
                    body: [
                    {
                        type: 'textbox',
                        name: 'title',
                        placeholder: 'PLACE_HOLDER_TEXT',
                        multiline: true,
                        minWidth: 700,
                        minHeight: 50,
                    },
                    {
                        type: 'button',
                        name: 'link',
                        text: 'Insert/Edit link',
                        onclick: function( e ) {
                            //get the Wordpess' "Insert/edit link" popup window.
//                            var textareaId = $('.mce-custom-textarea').attr('id'); 
// El ejercicio original no invoca la clase del item, le añadí un ID.
                            var textareaId = $('#plugin-slug-insert-dialog .mce-textbox').attr('id');
                            console.log(textareaId + ' hola');
                            wpActiveEditor = true; //we need to override this var as the link dialogue is expecting an actual wp_editor instance
                            wpLink.open( textareaId ); //open the link popup
                            return false;
                        },
                    },
                    {
                        type: 'button',
                        name: 'image',
                        classes: 'sidetag-media-button',
                        text: 'Insert Media',
                        onclick: function( e ) {

                            $( function($){
                                // Set all variables to be used in scope
                                var frame;
                                //it has to match the "textareaID" above, because it is the input field that we are
                                //going to insert the data in HTML format.
//                                var imgContainer = $( '.mce-custom-textarea' );
// El ejercicio original no invoca la clase del item, le añadí un ID.
                                var imgContainer = $( '#plugin-slug-insert-dialog .mce-textbox' );

                                // ADD IMAGE LINK
                                e.preventDefault();

                                // If the media frame already exists, reopen it.
                                if ( frame ) {
                                    frame.open();
                                    return;
                                }

                                // Create a new media frame
                                frame = wp.media({
                                    title: 'Select or Upload Media',
                                    button: {
                                      text: 'Use this media'
                                    },
                                    multiple: false  // Set to true to allow multiple files to be selected
                                });

                                // When an image is selected in the media frame...
                                frame.on( 'select', function() {

                                    // Get media attachment details from the frame state
                                    var attachment = frame.state().get('selection').first().toJSON();

                                    // Send the attachment URL to our custom image input field.
                                    var imageContent = '<img class="side-tag-image" src="'+attachment.url+'" alt="'+attachment.alt+'" style="max-width:100%;"/>'+attachment.caption;
                                    imgContainer.val( imageContent + imgContainer.val() );

                                });
                                // Finally, open the modal on click
                                frame.open();
                        });
                        return false;
                        }
                    }
                    ],
                    onsubmit: function( e ) {
                        // wrap it with a div and give it a class name
                        editor.insertContent( '<div class="CLASS_NAME">' + e.data.title + '</div>');
                    }
                });
            }
        });
    });
} )( jQuery );
