<?php
/**
 * Template part for displaying page content in image.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy 
 *
 * @package ekiline
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
	
	<?php if ( !is_home() && ! is_front_page() ) : ?> 
		
	<header class="entry-header">
	  	
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		
	</header><!-- .entry-header -->

	<?php endif; ?>

	<div class="entry-content clearfix">

        <div class="entry-attachment">
            <div class="attachment">
                <?php
                    /**
                     * Grab the IDs of all the image attachments in a gallery so we can get the URL of the next adjacent image in a gallery,
                     * or the first image (if we're looking at the last image in a gallery), or, in a gallery of one, just the link to that image file
                     */
                    $attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
                    foreach ( $attachments as $k => $attachment ) {
                        if ( $attachment->ID == $post->ID )
                            break;
                    }
                    $k++;
                    // If there is more than 1 attachment in a gallery
                    if ( count( $attachments ) > 1 ) {
                        if ( isset( $attachments[ $k ] ) )
                            // get the URL of the next image attachment
                            $next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
                        else
                            // or get the URL of the first image attachment
                            $next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
                    } else {
                        // or, if there's only 1 image, get the URL of the image
                        $next_attachment_url = wp_get_attachment_url();
                    }
                ?>

                <a href="<?php echo $next_attachment_url; ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php
                    $attachment_size = apply_filters( 'ekiline_attachment_size', array( 1200, 1200 ) ); // Filterable image size.
                    echo wp_get_attachment_image( $post->ID, $attachment_size );
                ?></a>
            </div><!-- .attachment -->

            <?php if ( ! empty( $post->post_excerpt ) ) : ?>
            <div class="entry-caption">
                <?php the_excerpt(); ?>
            </div><!-- .entry-caption -->
            <?php endif; ?>

        </div><!-- .entry-attachment -->

        <?php the_content(); ?>
        
        <?php wp_link_pages( array( 'before' => '<div class="page-links text-center my-2">' . __( 'Pages:', 'ekiline' ), 'after' => '</div>' ) ); ?>


	</div><!-- .entry-content -->

	<footer class="entry-footer text-muted clearfix bg-light px-2 mb-5">

        <small class="entry-meta">
            <?php 

                $metadata = wp_get_attachment_metadata();                
                $metaWidth = '';
                $metaHeight = '';                
                $messageMeta = __( 'Published <span class="entry-date"><time class="entry-date" datetime="%1$s" pubdate>%2$s</time></span> in <a href="%6$s" title="Return to %7$s" rel="gallery">%7$s</a>', 'ekiline' );
                                        
                if ( wp_attachment_is_image() ){                
                    $metaWidth = $metadata['width'];
                    $metaHeight = $metadata['height'];
                    $messageMeta = __( 'Published <span class="entry-date"><time class="entry-date" datetime="%1$s" pubdate>%2$s</time></span> at <a class="modal-image" href="%3$s" title="Link to full-size image">%4$s &times; %5$s</a> in <a href="%6$s" title="Return to %7$s" rel="gallery">%7$s</a>', 'ekiline' );                
                }
                
                printf( $messageMeta,
                    esc_attr( get_the_date( 'c' ) ),
                    esc_html( get_the_date() ),
                    wp_get_attachment_url(),
                    $metaWidth,
                    $metaHeight,
                    get_permalink( $post->post_parent ),
                    get_the_title( $post->post_parent )
                );
                
            ?>
            
        </small><!-- .entry-meta -->
	    
		<?php
			edit_post_link(
				sprintf(
					/* translators: %s: Name of current post */
					esc_html__( 'Edit this image %s', 'ekiline' ),
					the_title( '<i class="fa fa-pencil-alt"></i> <span class="screen-reader-text">"', '"</span>', false )
				),
                '<span class="edit-link btn btn-secondary">',
				'</span>'
			);
		?>
	</footer><!-- .entry-footer -->
	
    <nav id="image-navigation" aria-label="Image navigation">
	  <ul class="pagination justify-content-center">			    
        <li class="page-item page-link"><span class="fa fa-chevron-left"></span> <?php previous_image_link( false, __( 'Previous', 'ekiline' ) ); ?></li>
        <li class="page-item page-link"><?php next_image_link( false, __( 'Next', 'ekiline' ) ); ?> <span class="fa fa-chevron-right"></span></li>
      </ul>
    </nav><!-- #image-navigation -->        
	
</article><!-- #post-## -->

