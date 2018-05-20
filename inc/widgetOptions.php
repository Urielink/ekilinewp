<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package ekiline
 */

/**
 * Extender funciones de widget, añadir CSS por cada item
 * Extend widget functions
 */
 
function ekiline_in_widget_form($t,$return,$instance){
    $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '', 'css_style' => '') );
    if ( !isset($instance['css_style']) )
        $instance['css_style'] = null;
    ?>
    <p>
        <label for="<?php echo $t->get_field_id('css_style'); ?>"><?php echo __( 'CSS custom class','ekiline' ) ?></label>
	    <input type="text" name="<?php echo $t->get_field_name('css_style'); ?>" id="<?php echo $t->get_field_id('css_style'); ?>" value="<?php echo $instance['css_style'];?>" />
    </p>
    <?php
    $retrun = null;
    return array($t,$return,$instance);
}

function ekiline_in_widget_form_update($instance, $new_instance, $old_instance){
    $instance['css_style'] = strip_tags($new_instance['css_style']);
    return $instance;
}

function ekiline_dynamic_sidebar_params($params){
    global $wp_registered_widgets;
    $widget_id = $params[0]['widget_id'];
    $widget_obj = $wp_registered_widgets[$widget_id];
    $widget_opt = get_option($widget_obj['callback'][0]->option_name);
    $widget_num = $widget_obj['params'][0]['number'];

            if(isset($widget_opt[$widget_num]['css_style']) ){
              if($widget_opt[$widget_num]['css_style'] == ''){
                $css_style = '';
              }else{
                $css_style = $widget_opt[$widget_num]['css_style'];
              }
            }
            else
              $css_style = '';
                
            $params[0]['before_widget'] = preg_replace('/class="/', 'class="'.$css_style.' ',  $params[0]['before_widget'], 1);

    return $params;
}

// register widget callbacks and update functions
add_action('in_widget_form', 'ekiline_in_widget_form',5,3);
add_filter('widget_update_callback', 'ekiline_in_widget_form_update',5,3);
add_filter('dynamic_sidebar_params', 'ekiline_dynamic_sidebar_params');

