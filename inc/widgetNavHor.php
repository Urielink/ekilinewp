<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package ekiline
 */

/**
 * Extend nav menu widget 
 *
 * Adds different formatting to the default WordPress Nav Menu Widget
 */

class HorizontalNavbarWidget extends WP_Widget {

    function __construct() {
        // Instantiate the parent object
        //parent::__construct( false, 'Vertical Menu Navigation' );
        $widget_ops = array(
            'description' => __( 'Add a single bootstrap navbar','ekiline' ),
            'customize_selective_refresh' => true,
        );
        parent::__construct( false, __( 'Bootstrap navbar menu','ekiline' ), $widget_ops );        
    }

    function widget( $args, $instance ) {
        
        // Get menu
        $nav_menu = ! empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;

        if ( !$nav_menu ) 
        
            return;

        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

        echo $args['before_widget'];
                
        // variable contenedora
                
        echo '<nav id="site-navigation-horizontal"  class="navbar navbar-expand-md navbar-light bg-light" role="navigation">';
        
			echo '<div class="container-fluid">';	 
		                       
				if ( !empty($instance['title']) ) echo '<div class="navbar-brand">'. $instance['title'] .'</div>';
	                                               
		       	  	echo '<button type="button" class="navbar-toggler" data-toggle="collapse" data-target=".navbar-collapse.'.$this->id.'"><span class="navbar-toggler-icon"></span></button>';
		                   
		           		echo '<div class="collapse navbar-collapse '.$this->id.'">';        
                
		        $nav_menu_args = array(
			        'depth'             => 2,
		            'menu'        => $nav_menu,
		            // 'container'         => 'div',
		            // 'container_class'   => 'collapse navbar-collapse',
		            'container_id'      => 'navbar-collapse-in',
		            'menu_class'        => 'nav navbar-nav',
		            'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
		            'menu_id'           => 'widget-menu',
		            'walker'            => new WP_Bootstrap_Navwalker()
		        );
		
		        wp_nav_menu( apply_filters( 'widget_nav_menu_args', $nav_menu_args, $nav_menu, $args, $instance ) );
		        
		        // widget en navbar 
		        dynamic_sidebar( 'navwidget-nw3' );
        
        // cierre de etiquetas #site-navigation-horizontal,.container-fluid, .collapse navbar-collapse
        echo '</div></div></nav>';        
                
        echo $args['after_widget'];
    }

    function update( $new_instance, $old_instance ) {
        // Save widget options
        $instance = array();
        if ( ! empty( $new_instance['title'] ) ) {
            $instance['title'] = sanitize_text_field( $new_instance['title'] );
        }
        if ( ! empty( $new_instance['nav_menu'] ) ) {
            $instance['nav_menu'] = (int) $new_instance['nav_menu'];
        }
        return $instance;        
    }

    function form( $instance ) {
        // Output admin widget options form
        $title = isset( $instance['title'] ) ? $instance['title'] : '';
        $nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';

        // Get menus
        $menus = wp_get_nav_menus();

        // If no menus exists, direct the user to go and create some.
        ?>
        <p class="nav-menu-widget-no-menus-message" <?php if ( ! empty( $menus ) ) { echo ' style="display:none" '; } ?>>
            <?php
            if ( isset( $GLOBALS['wp_customize'] ) && $GLOBALS['wp_customize'] instanceof WP_Customize_Manager ) {
                $url = 'javascript: wp.customize.panel( "nav_menus" ).focus();';
            } else {
                $url = admin_url( 'nav-menus.php' );
            }
            ?>
            <?php echo sprintf( __( 'No menus have been created yet. <a href="%s">Create some</a>.','ekiline' ), esc_attr( $url ) ); ?>
        </p>
        <div class="nav-menu-widget-form-controls" <?php if ( empty( $menus ) ) { echo ' style="display:none" '; } ?>>
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo __( 'Title:','ekiline' ) ?></label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>"/>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'nav_menu' ); ?>"><?php echo __( 'Select Menu:','ekiline' ); ?></label>
                <select id="<?php echo $this->get_field_id( 'nav_menu' ); ?>" name="<?php echo $this->get_field_name( 'nav_menu' ); ?>">
                    <option value="0"><?php echo __( '&mdash; Select &mdash;','ekiline' ); ?></option>
                    <?php foreach ( $menus as $menu ) : ?>
                        <option value="<?php echo esc_attr( $menu->term_id ); ?>" <?php selected( $nav_menu, $menu->term_id ); ?>>
                            <?php echo esc_html( $menu->name ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>
        </div>
        <?php        
    }

}

function horizontalnavbar_register_widgets() {
    register_widget( 'HorizontalNavbarWidget' );
}

add_action( 'widgets_init', 'horizontalnavbar_register_widgets' );