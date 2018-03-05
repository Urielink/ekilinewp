<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package ekiline
 */

/**
 * Core class used to implement a Recent Posts widget.
 *
 * @since 2.8.0
 *
 * @see WP_Widget
 */
class ekiline_recent_posts_carousel extends WP_Widget {

	/**
	 * Sets up a new Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget_recent_entries',
			'description' => __( 'The most recent posts on your site in carousel format','ekiline' ),
			'customize_selective_refresh' => true,
		);
		//Cancelar herencia.
		//parent::__construct( 'recent-posts', __( 'Recent Posts' ), $widget_ops );
		parent::__construct(false, __( 'Recent posts carousel','ekiline' ), $widget_ops);
		$this->alt_option_name = 'widget_recent_entries';
		// acciones para refrescar este widget
        add_action( 'save_post', array(&$this, 'flush_widget_cache') );
        add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
        add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
	}

	/**
	 * Outputs the content for the current Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Recent Posts widget instance.
	 */
	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts' );

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number ) {
			$number = 5;
		}
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
//selecciones
		// $selected     = isset( $instance['selected'] ) ? absint( $instance['selected'] ) : 0 ;
		// $checked     = isset( $instance['checked'] ) ? (bool) $instance['checked'] : false ;

		$selected = ( ! empty( $instance['selected'] ) ) ? absint( $instance['selected'] ) : 0;
		// if ( ! $selected ) {
			// $selected = 0;
		// }
		
		$checked = isset( $instance['checked'] ) ? $instance['checked'] : false;
		// if ( ! $checked ) {
			// $checked = '0,1';
		// }
//fin selecciones


		/**
		 * Filters the arguments for the Recent Posts widget.
		 *
		 * @since 3.4.0
		 * @since 4.9.0 Added the `$instance` parameter.
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args     An array of arguments used to retrieve the recent posts.
		 * @param array $instance Array of settings for the current widget.
		 */
		$r = new WP_Query( apply_filters( 'widget_posts_args', array(
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
		), $instance ) );

		if ( ! $r->have_posts() ) {
			return;
		}
		?>
		<?php echo $args['before_widget']; ?>
		<?php
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		?>
		<ul>
			<?php foreach ( $r->posts as $recent_post ) : ?>
				<?php
				$post_title = get_the_title( $recent_post->ID );
				$title      = ( ! empty( $post_title ) ) ? $post_title : __( '(no title)' );
				?>
				<li>
					<a href="<?php the_permalink( $recent_post->ID ); ?>"><?php echo $title ; ?></a>
					<?php if ( $show_date ) : ?>
						<span class="post-date"><?php echo get_the_date( '', $recent_post->ID ); ?></span>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
		<small><?php echo $selected; ?> | <?php echo $checked; ?></small>
		<?php
		echo $args['after_widget'];
	}

	/**
	 * Handles updating the settings for the current Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
//selecciones
		$instance['selected'] = (int) $new_instance['selected'];
		$instance['checked'] = isset( $new_instance['checked'] ) ? (bool) $new_instance['checked'] : false;
//fin selecciones
		return $instance;
	}

	/**
	 * Outputs the settings form for the Recent Posts widget.
	 *
	 * @since 2.8.0
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false ;
//selecciones
		$selected     = isset( $instance['selected'] ) ? absint( $instance['selected'] ) : 0 ;
		$checked     = isset( $instance['checked'] ) ? (bool) $instance['checked'] : false ;
		
		// dropdown de categorias: https://codex.wordpress.org/Function_Reference/wp_dropdown_categories
		$args = array(
	        'name'             => $this->get_field_name('category'),
	        'show_option_none' => __( 'Select category', 'ekiline' ),
	        'show_count'       => 1,
	        'orderby'          => 'name',
	        'echo'             => 0,
	       	'selected'         => $selected, //0,
	        'class'            => 'widefat'
	    );
        $show_cats = wp_dropdown_categories($args); 
		
        // chekclist de categorias: https://codex.wordpress.org/Function_Reference/wp_category_checklist
        // args: wp_category_checklist($post_id, $descendants_and_self, $selected_cats,$popular_cats, $walker, $checked_ontop)
        $sel_cats = wp_category_checklist( 0 , 0 , $checked, false, null, false ); 
//fin selecciones				
		
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
		<input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox"<?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label></p>
		
		<?php echo $show_cats; //selecciones ?>
		
		<?php echo $sel_cats; //selecciones ?>
		
		<!-- punto de partida 13:39 -->
		
<?php
	}
}

function ekiline_recent_posts_carousel_init() {
    //unregister_widget('WP_Widget_Recent_Posts');
    register_widget('ekiline_recent_posts_carousel');
}

add_action('widgets_init', 'ekiline_recent_posts_carousel_init');



