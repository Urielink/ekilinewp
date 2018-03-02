<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ekiline
 */

get_header(); 

//update: 29 08 2017 columns
$colSet = get_theme_mod('ekiline_Columns'); 
$cssCols = '';
$cssToCol = '';
if ($colSet != '0') { $cssCols = ' row'; $cssToCol = ' col-md-12'; }

?>
		
		<?php dynamic_sidebar( 'content-w1' ); ?>		

		<main id="main" class="site-main<?php echo $cssCols; ?>" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="entry-header<?php echo $cssToCol; ?>">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .entry-header -->

			<?php /* Start the Loop * ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 *
					get_template_part( 'template-parts/content', get_post_format() );
				?>

			<?php endwhile; */?>
			
			<?php /* Ekiline Loop with columns */ ?>
			<?php $count = ''; while ( have_posts() ) : the_post(); $count++; ?>

				<?php

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					//get_template_part( 'template-parts/content', get_post_format() );

                if ($colSet == '1' ) : $colCount='2'; elseif ($colSet == '2' ) : $colCount='3'; elseif ($colSet == '3' ) : $colCount='4'; else : $colCount='3'; endif;                       
                 
                if ($colSet == '0') {                    
                    get_template_part( 'template-parts/content', get_post_format() );                    
                } else if ($colSet != '0' ) {                                            
                    get_template_part( 'template-parts/content', 'block' );                     
                } 	
                
                if ($count == $colCount ) : echo '<div class="clearfix middle"></div>'; $count = 0;  endif;									
					
				?>

			<?php endwhile; ?>			

        <nav id="page-navigation">
            <?php ekiline_archive_pagination();?>
        </nav>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
		
		<?php dynamic_sidebar( 'content-w2' ); ?>		

<?php get_footer(); ?>
