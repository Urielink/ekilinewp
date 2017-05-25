<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package ekiline
 */

/**
 * Extender campos en categorías y agregar imagen
 * Extend Category to grab an image
 *
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
<input type="text" name="Cat_meta[img]" id="Cat_meta[img]" size="3" style="width:60%;" value="<?php echo $cat_meta['img'] ? $cat_meta['img'] : ''; ?>"><br />
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

