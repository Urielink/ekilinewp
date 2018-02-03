<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package ekiline
 */

/**
 * Extender campos en categorias y agregar imagen
 * Extend Category to grab an image
 * Adds add extra fields to category
 * https://en.bainternet.info/wordpress-category-extra-fields/
 */

//declarar accion para el campo extra
//add extra fields to category edit form hook
add_action ( 'edit_category_form_fields', 'extra_category_fields');

function extra_category_fields( $tag ) {
    // revisar la existencia del ID
    // check for existing featured ID
    $t_id = $tag->term_id;
    $cat_meta = get_option( "category_$t_id");	
?>

<tr class="form-field">
<th scope="row" valign="top"><label for="cat_Image_url"><?php echo __( 'Category image','ekiline' ); ?></label></th>
<td>
	<input type="text" class="image-upload-field" name="Cat_meta[img]" id="Cat_meta[img]" size="3" style="width:60%;" value="<?php echo $cat_meta['img'] ? $cat_meta['img'] : ''; ?>">
	<input type="button" class="image-upload-button button" value="<?php echo __( 'Upload image','ekiline' ); ?>" />
<br />
    <span class="description"><?php echo __( 'Add url image','ekiline' ); ?></span>
</td>
</tr>

<?php
}

// guardar el dato de nuestro campo
// save extra category extra fields hook
add_action ( 'edited_category', 'save_extra_category_fileds');

function save_extra_category_fileds( $term_id ) {
    if ( isset( $_POST['Cat_meta'] ) ) {
        $t_id = $term_id;
        $cat_meta = get_option( "category_$t_id");
        $cat_keys = array_keys($_POST['Cat_meta']);
            foreach ($cat_keys as $key){
            if (isset($_POST['Cat_meta'][$key])){
                $cat_meta[$key] = $_POST['Cat_meta'][$key];
            }
        }

        update_option( "category_$t_id", $cat_meta );
    }
}

// Inicializar los scripts de medioa : https://codex.wordpress.org/Javascript_Reference/wp.media
// init all the needed JavaScript-Libraries and Styles
add_action( 'admin_enqueue_scripts', 'load_wp_media_files' );
function load_wp_media_files() {
    wp_enqueue_media();
}

/**
 * Abrir la biblioteca de medios y añadir una imagen principal a la categoría.
 * Get image url from library and add to field
 * https://mikejolley.com/2012/12/21/using-the-new-wordpress-3-5-media-uploader-in-plugins/
 * https://dobsondev.com/2015/01/23/using-the-wordpress-media-uploader/
 * https://codestag.com/how-to-use-wordpress-3-5-media-uploader-in-theme-options/
 **/
 
add_action( 'admin_footer', 'ekiline_catimage_js' );
function ekiline_catimage_js() { 
global $pagenow;
if ($pagenow=='term.php' ) { ?>	
	
<script type='text/javascript'>
	jQuery(document).ready(function($){
		
		//console.log('catscript');
	
	  $('.image-upload-button').click(function(e) {
	  	
		var frame;
	    e.preventDefault();
	    // Dialogo de imagenes abrir o reabrir,
	      if (frame) {
	      	frame.open();
	      return;
	    }
	    
	    // Opciones wp.media 
	    frame = wp.media.frames.file_frame = wp.media({
	      title: '<?php echo __( 'Upload or choose image','ekiline' ); ?>',
	      button: { text: '<?php echo __( 'Add image','ekiline' ); ?>' }, multiple: false 
				});
	
	    // Al seleccionar imagen, insertala en el campo. 
	    frame.on('select', function() {
	      var attachment = frame.state().get('selection').first().toJSON();
	      $('.image-upload-field').val(attachment.url);
	    });
	    
	    // Open the uploader dialog
	    frame.open();
	
	  });
	
	});
</script>

<?php }
}
