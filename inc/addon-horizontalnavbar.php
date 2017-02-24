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
            'description' => __( 'Add navbar custom menu to your page.' ),
            'customize_selective_refresh' => true,
        );
        parent::__construct( false, __('Navbar Menu Navigation'), $widget_ops );        
    }

    function widget( $args, $instance ) {
        
        // Get menu
        $nav_menu = ! empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;

        if ( !$nav_menu ) 
            return;

        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

        echo $args['before_widget'];
        
        if ( !empty($instance['title']) )

            echo $args['before_title'] . $instance['title'] . $args['after_title'];
        
        // Añadir logo
        
	    if ( get_theme_mod( 'ekiline_logo_max' ) && !get_theme_mod( 'ekiline_logo_min' ) ) {
	        $identidad = '<img class="img-responsive" src="' . get_theme_mod( 'ekiline_logo_max' ) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '"/>';
	    } elseif ( get_theme_mod( 'ekiline_logo_min' ) && !get_theme_mod( 'ekiline_logo_max' ) ) {
	        $identidad = '<img class="img-responsive" src="' . get_theme_mod( 'ekiline_logo_min' ) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '"/>';
	    } elseif ( get_theme_mod( 'ekiline_logo_max' ) && get_theme_mod( 'ekiline_logo_min' ) ) {
	        $identidad = '<img class="img-responsive hidden-xs" src="' . get_theme_mod( 'ekiline_logo_max' ) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '"/><img class="img-responsive visible-xs" src="' . get_theme_mod( 'ekiline_logo_min' ) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '"/>';
	    } else {
	        $identidad = bloginfo( 'name' );
	    } 

        // variable contenedora
                
        $abreMenu = '<nav id="site-navigation"  class="navbar navbar-default" role="navigation">
	    			<div class="container">
		        		<div class="navbar-header">
	                        <!-- .navbar-toggle is used as the toggle for collapsed navbar content -->
	                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse.widget-hm">
	                            <span class="sr-only">'. esc_html__('Toggle navigation','ekiline') .'</span>
	                            <span class="icon-bar"></span>
	                            <span class="icon-bar"></span>
	                            <span class="icon-bar"></span>
	                        </button>
	                        <!-- Your site title as branding in the menu -->                
	                        <a class="navbar-brand" href="'. esc_url( home_url( '/' ) ) .'" title="'. esc_attr( get_bloginfo( 'name', 'display' ) ) .'" rel="home">'. $identidad .'</a>
	                    </div><!-- .navbar-header -->';        
                    
        echo $abreMenu;
                    
        $nav_menu_args = array(
            'menu'        => $nav_menu,
            'container'         => 'div',
            'container_class'   => 'collapse navbar-collapse widget-hm',
            'container_id'      => 'navbar-collapse-in',
            'menu_class'        => 'nav navbar-nav',
            'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
            'menu_id'           => 'widget-menu',
            'walker'            => new wp_bootstrap_navwalker()            
        );

        /**
         * Filter the arguments for the Custom Menu widget.
         *
         * @since 4.2.0
         * @since 4.4.0 Added the `$instance` parameter.
         *
         * @param array    $nav_menu_args {
         *     An array of arguments passed to wp_nav_menu() to retrieve a custom menu.
         *
         *     @type callable|bool $fallback_cb Callback to fire if the menu doesn't exist. Default empty.
         *     @type mixed         $menu        Menu ID, slug, or name.
         * }
         * @param stdClass $nav_menu      Nav menu object for the current menu.
         * @param array    $args          Display arguments for the current widget.
         * @param array    $instance      Array of settings for the current widget.
         */
        wp_nav_menu( apply_filters( 'widget_nav_menu_args', $nav_menu_args, $nav_menu, $args, $instance ) );
        // añado un widget dentro del menu (por si acaso) 
        $cierraMenu = !dynamic_sidebar( 'navwidget-nw3' ).'</div></nav>';
        echo $cierraMenu.$args['after_widget'];
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
            <?php echo sprintf( __( 'No menus have been created yet. <a href="%s">Create some</a>.' ), esc_attr( $url ) ); ?>
        </p>
        <div class="nav-menu-widget-form-controls" <?php if ( empty( $menus ) ) { echo ' style="display:none" '; } ?>>
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ) ?></label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>"/>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'nav_menu' ); ?>"><?php _e( 'Select Menu:' ); ?></label>
                <select id="<?php echo $this->get_field_id( 'nav_menu' ); ?>" name="<?php echo $this->get_field_name( 'nav_menu' ); ?>">
                    <option value="0"><?php _e( '&mdash; Select &mdash;' ); ?></option>
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