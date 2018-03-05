<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package ekiline
 * 
 * dropdown de categorias: https://codex.wordpress.org/Function_Reference/wp_dropdown_categories
 * https://sushilwp.wordpress.com/2016/10/25/dropdown-categories/
 * checklist de categorias: https://codex.wordpress.org/Function_Reference/wp_category_checklist
 * https://wordpress.stackexchange.com/questions/124772/using-wp-category-checklist-in-a-widget
 * 
 */
 
// This is required to be sure Walker_Category_Checklist class is available
require_once ABSPATH . 'wp-admin/includes/template.php';
/**
 * Custom walker to print category checkboxes for widget forms
 */
class Walker_Category_Checklist_Widget extends Walker_Category_Checklist {

    private $name;
    private $id;

    function __construct( $name = '', $id = '' ) {
        $this->name = $name;
        $this->id = $id;
    }

    function start_el( &$output, $cat, $depth = 0, $args = array(), $id = 0 ) {
        extract( $args );
        if ( empty( $taxonomy ) ) $taxonomy = 'category';
        $class = in_array( $cat->term_id, $popular_cats ) ? ' class="popular-category"' : '';
        $id = $this->id . '-' . $cat->term_id;
        $checked = checked( in_array( $cat->term_id, $selected_cats ), true, false );
        $output .= "\n<li id='{$taxonomy}-{$cat->term_id}'$class>" 
            . '<label class="selectit"><input value="' 
            . $cat->term_id . '" type="checkbox" name="' . $this->name 
            . '[]" id="in-'. $id . '"' . $checked 
            . disabled( empty( $args['disabled'] ), false, false ) . ' /> ' 
            . esc_html( apply_filters( 'the_category', $cat->name ) ) 
            . '</label>';
      }
}
//1400

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
		// Cancelar herencia.
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

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts','ekiline' );

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number ) {
			$number = 5;
		}
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
		
//1400 llamar por categoria selecta: https://codex.wordpress.org/Class_Reference/WP_Query
		$checked = isset( $instance['widget_categories'] ) ? $instance['widget_categories'] : false;

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
			'category__in' => $checked
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

// variables para carrusel
        $uniqueId = 'widgetCarousel'.mt_rand();
		
		?>

		<?php /**<ul class="list-unstyled">
			<?php foreach ( $r->posts as $recent_post ) : ?>
				<?php
				$post_title = get_the_title( $recent_post->ID );
				$title      = ( ! empty( $post_title ) ) ? $post_title : __( '(no title)' );
				?>
				<li>
					<a href="<?php the_permalink( $recent_post->ID ); ?>"><?php echo $title ; ?></a>
					<?php if ( $show_date ) : ?>
						<span class="post-date small"><?php echo get_the_date( '', $recent_post->ID ); ?></small>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
		<hr /> **/?>

<!-- inicia carrusel -->
		
            <div id="<?php echo $uniqueId; ?>" class="widget-carousel carousel slide bg-dark" data-ride="carousel" data-interval="false">
            
              <div class="carousel-inner" role="listbox">
                  
                <ol class="carousel-indicators">
                <?php while( $r->have_posts() ) : $r->the_post();?> 
                <?php // conteo de posts
                        $count = $r->current_post + 0;
                        if ($count == '0') : $countclass = 'active' ; elseif ($count !='0') : $countclass = '' ; endif; 
                        ?>                                                        
                    <li data-target="#<?php echo $uniqueId; ?>" data-slide-to="<?php echo $count; ?>" class="<?php echo $countclass; ?>"></li>
                <?php endwhile;?>
                </ol> <!-- // fin de .carousel-indicators -->                      
                  
                <?php while( $r->have_posts() ) : $r->the_post();?>                   
                <?php // conteo de posts
                        $count = $r->current_post + 0;
                        // marcar el post 0 como el principal, para generar una clase CSS active
                        if ($count == '0') : $countclass = 'active' ; elseif ($count !='0') : $countclass = '' ; endif;        
                        ?>                                              
                <div class="carousel-item <?php echo $countclass; ?>">
                    <article<?php if ( !has_post_thumbnail() ) : echo ' class="no-thumb"'; endif; ?>>
                    
				    <?php if ( has_post_thumbnail() ){?>
				        <a class="link-image" href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">             
				        	<?php the_post_thumbnail( 'horizontal-slide', array( 'class' => 'img-fluid' ));?>
				        </a>
				    <?php }?>
				    
                    <div class="carousel-caption p-5">
                      <h4 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                      <p><?php the_excerpt(); ?></p>
                      <?php if ( $show_date ) : ?>
                      	<small><?php the_time( get_option( 'date_format' ) ); ?></small>      
                      <?php endif; ?>                  
                    </div>
                    </article>
                </div> <!-- // fin de .item -->  
                <?php endwhile;?>   

              </div> <!-- // fin de .carousel-inner -->
              
              <!-- Left and right controls -->
              <a class="carousel-control-prev" href="#<?php echo $uniqueId; ?>" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#<?php echo $uniqueId; ?>" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
              
            </div> <!-- // fin de .widget-carousel --> 
		
<!-- finaliza carrusel -->

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
//1400
        $instance['widget_categories'] = $new_instance['widget_categories'];

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
//1400		
        $defaults = array( 'widget_categories' => array() );
        $instance = wp_parse_args( (array) $instance, $defaults );    
        // Instantiate the walker passing name and id as arguments to constructor
        $walker = new Walker_Category_Checklist_Widget(
            $this->get_field_name( 'widget_categories' ), 
            $this->get_field_id( 'widget_categories' )
        );
		
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:','ekiline' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:','ekiline' ); ?></label>
		<input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" /></p>

		<!-- Formulario 14:00 -->
		<p><label for="<?php echo $this->get_field_id( 'widget_categories' ); ?>"><?php _e( 'Filter categories:','ekiline' ); ?></label></p>
        <?php echo '<ul class="categorychecklist" style="height:180px;overflow-y:scroll;border:solid 1px #ddd;padding:4px;">';
        wp_category_checklist( 0, 0, $instance['widget_categories'], FALSE, $walker, FALSE );
        echo '</ul>'; ?>

		<p><input class="checkbox" type="checkbox"<?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Show post date?','ekiline' ); ?></label></p>
						
<?php
	}
}

function ekiline_recent_posts_carousel_init() {
    //unregister_widget('WP_Widget_Recent_Posts');
    register_widget('ekiline_recent_posts_carousel');
}

add_action('widgets_init', 'ekiline_recent_posts_carousel_init');



