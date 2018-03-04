<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package ekiline
 */

/**
 * Recent_Posts widget w/ category exclude class
 * This allows specific Category IDs to be removed from the Sidebar Recent Posts list
 * http://pastebin.com/jxDnqPqR
 */
class WP_Widget_Recent_Posts_Exclude extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'widget_recent_entries', 'description' => __( 'The most recent posts on your site in carousel format','ekiline' ) );
        parent::__construct(false, __( 'Recent posts carousel','ekiline' ), $widget_ops);
        $this->alt_option_name = 'widget_recent_entries';

        add_action( 'save_post', array(&$this, 'flush_widget_cache') );
        add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
        add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
    }

    function widget($args, $instance) {
            
        $uniqueId = 'widgetCarousel'.mt_rand();
       
        $cache = wp_cache_get('widget_recent_posts', 'widget');

        if ( !is_array($cache) )
            $cache = array();

        if ( ! isset( $args['widget_id'] ) )
            $args['widget_id'] = $this->id;

        if ( isset( $cache[ $args['widget_id'] ] ) ) {
            echo $cache[ $args['widget_id'] ];
            return;
        }

        ob_start();
        extract($args);

        $title = apply_filters('widget_title', empty($instance['title']) ? __( 'Recent posts','ekiline' ) : $instance['title'], $instance, $this->id_base);
        if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
            $number = 10;
        $exclude = empty( $instance['exclude'] ) ? '' : $instance['exclude'];

        $r = new WP_Query(array('posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'category__not_in' => explode(',', $exclude) ));
        if ($r->have_posts()) :
?>

        <?php //echo print_r(explode(',', $exclude)); ?>
        <?php echo $before_widget; ?>
        <?php if ( $title ) echo $before_title . $title . $after_title; ?>
        
        
<?php /* Insertando una lista sencilla con thumb        
        
            <ul class="list-unstyled">
                <?php while( $r->have_posts() ) : $r->the_post(); ?>                
                <li class="media">
                  <div class="media-left">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                      <div class="media-object"><?php the_post_thumbnail( array(50, 50) );?></div>
                    </a>
                  </div>
                  <div class="media-body">
                    <h4 class="media-heading">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                            <?php the_title(); ?> - <?php the_time( 'D M Y'); ?>
                        </a>
                    </h4>                    
                  </div>
                </li>  
                <?php endwhile;?>                
            </ul>
            
<?php /* Insertando un carrusel */ ?>         

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
                      <small><?php the_time( get_option( 'date_format' ) ); ?></small>                        
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
            
<?php /* Fin de carrusel */ ?>         

        <?php echo $after_widget; ?>
        
<?php
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();

        endif;

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_recent_posts', $cache, 'widget');
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int) $new_instance['number'];
        $instance['exclude'] = strip_tags( $new_instance['exclude'] );
        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_recent_entries']) )
            delete_option('widget_recent_entries');

        return $instance;
    }

    function flush_widget_cache() {
        wp_cache_delete('widget_recent_posts', 'widget');
    }

    function form( $instance ) {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $number = isset($instance['number']) ? absint($instance['number']) : 5;
        // $exclude = esc_attr( $instance['exclude'] );
        $exclude = empty( $instance['exclude'] ) ? '' : $instance['exclude'];
?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo __( 'Title:','ekiline' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('number'); ?>"><?php echo __( 'Number of posts to show:','ekiline' ); ?></label>
        <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="number" value="<?php echo $number; ?>" size="3" /></p>
        
        <p>
            <label for="<?php echo $this->get_field_id('exclude'); ?>"><?php echo __( 'Exclude categories:','ekiline' ); ?></label> 
        	<small><?php echo __( 'Category IDs, separated by commas','ekiline' ); ?></small>
            <!--input type="text" value="<?php //echo $exclude; ?>" name="<?php //echo $this->get_field_name('exclude'); ?>" id="<?php //echo $this->get_field_id('exclude'); ?>" class="widefat" /-->            
        </p>
 		<?php 
 			// dropdown de categorias
 			// https://codex.wordpress.org/Function_Reference/wp_dropdown_categories
 			
 			$args = array(
		        'name'             => $this->get_field_name('category'),
		        'show_option_none' => __( 'Select category', 'ekiline' ),
		        'show_count'       => 1,
		        'orderby'          => 'name',
		        'echo'             => 0,
		       	'selected'         => $exclude,
		        'class'            => 'widefat'
		    );
            echo wp_dropdown_categories($args); 

            // chekclist de categorias: https://codex.wordpress.org/Function_Reference/wp_category_checklist
            // echo wp_category_checklist($args); 
        ?>
        
<?php
    }
}

function WP_Widget_Recent_Posts_Exclude_init() {
    //unregister_widget('WP_Widget_Recent_Posts');
    register_widget('WP_Widget_Recent_Posts_Exclude');
}

add_action('widgets_init', 'WP_Widget_Recent_Posts_Exclude_init');



