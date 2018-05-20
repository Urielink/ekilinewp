<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package ekiline
 */

// Extender campos en categorias y agregar imagen || Extend Category to grab an image

add_action ( 'edit_category_form_fields', 'extra_category_fields');
function extra_category_fields( $tag ) {
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

add_action( 'admin_enqueue_scripts', 'load_wp_media_files' );
function load_wp_media_files() {
    wp_enqueue_media();
}

/**
 * Abrir la biblioteca de medios y añadir una imagen principal a la categoría.
 * Get image url from library and add to field
 **/
 
add_action( 'admin_footer', 'ekiline_catimage_js' );
function ekiline_catimage_js() { 

	global $pagenow;
	if ($pagenow=='term.php' ) { ?>	
		
	<script type='text/javascript'>
		jQuery(document).ready(function($){
			
		  $('.image-upload-button').click(function(e) {
		  	
			var frame;
		    e.preventDefault();

		      if (frame) {
		      	frame.open();
		      return;
		    }

		    frame = wp.media.frames.file_frame = wp.media({
		      title: '<?php echo __( 'Upload or choose image','ekiline' ); ?>',
		      button: { text: '<?php echo __( 'Add image','ekiline' ); ?>' }, multiple: false 
					});

		    frame.on('select', function() {
		      var attachment = frame.state().get('selection').first().toJSON();
		      $('.image-upload-field').val(attachment.url);
		    });

		    frame.open();
		
		  });
		
		});
	</script>
	
	<?php }
}
