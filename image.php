<?php
/**
 * Template for displaying image attachments
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ekiline
 */

get_header(); ?>
    
        <?php dynamic_sidebar( 'content-w1' ); ?>

        <main id="main" class="site-main" role="main">

            <?php while ( have_posts() ) : the_post(); ?>

                <?php get_template_part( 'template-parts/content', 'image' ); ?>

                <?php
                    // If comments are open or we have at least one comment, load up the comment template.
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;
                ?>

            <?php endwhile; // End of the loop. ?>

        </main><!-- #main -->

        <?php dynamic_sidebar( 'content-w2' ); ?>       
        
<?php get_footer(); ?>
