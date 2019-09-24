<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ekiline
 */

get_header(); ?>
    
        <?php dynamic_sidebar( 'content-w1' ); ?>

        <main id="main" class="site-main" role="main">

            <?php while ( have_posts() ) : the_post(); ?>

                <?php get_template_part( 'template-parts/content', 'page' ); ?>
                
                <?php if( !is_front_page() ) {?>
	                <nav id="page-navigation" class="small" aria-label="Page navigation"> 
	                    <?php ekiline_pages_navigation(); ?>         
	                </nav><!-- #page-navigation -->        
                <?php }?>

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
