<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package ekiline
 * 
 */

require_once ABSPATH . 'wp-admin/includes/template.php';

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

class ekiline_recent_posts_carousel extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget_recent_entries',
			'description' => __( 'The most recent posts on your site in carousel format','ekiline' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct(false, __( 'Recent posts carousel','ekiline' ), $widget_ops);
		$this->alt_option_name = 'widget_recent_entries';
	}

	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts','ekiline' );

		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number ) {
			$number = 5;
		}
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

		$checked = isset( $instance['widget_categories'] ) ? $instance['widget_categories'] : false;

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

        $uniqueId = 'widgetCarousel'.mt_rand();
		
		?>

            <div id="<?php echo $uniqueId; ?>" class="widget-carousel carousel slide bg-dark" data-ride="carousel" data-interval="false">
            
              <div class="carousel-inner" role="listbox">
                  
                <ol class="carousel-indicators">
                <?php while( $r->have_posts() ) : $r->the_post();?> 
                <?php $count = $r->current_post + 0;
                        if ($count == '0') : $countclass = 'active' ; elseif ($count !='0') : $countclass = '' ; endif; 
                        ?>                                                        
                    <li data-target="#<?php echo $uniqueId; ?>" data-slide-to="<?php echo $count; ?>" class="<?php echo $countclass; ?>"></li>
                <?php endwhile;?>
                </ol> <!-- // fin de .carousel-indicators -->                      
                  
                <?php while( $r->have_posts() ) : $r->the_post();?>                   
                <?php $count = $r->current_post + 0;
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

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
        $instance['widget_categories'] = $new_instance['widget_categories'];
		return $instance;
	}

	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false ;
        $defaults = array( 'widget_categories' => array() );
        $instance = wp_parse_args( (array) $instance, $defaults );    
        $walker = new Walker_Category_Checklist_Widget(
            $this->get_field_name( 'widget_categories' ), 
            $this->get_field_id( 'widget_categories' )
        );
		
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:','ekiline' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:','ekiline' ); ?></label>
		<input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" /></p>

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
    register_widget('ekiline_recent_posts_carousel');
}

add_action('widgets_init', 'ekiline_recent_posts_carousel_init');



