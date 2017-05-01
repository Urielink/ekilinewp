<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ekilinewp
 */

if ( ! is_active_sidebar( 'sidebar-2' ) ) {
	return;
}
?>

<div id="third" class="widget-area<?php rightSideOn(); ?>" role="complementary">
    <?php rightSideButton(); ?>
	<?php dynamic_sidebar( 'sidebar-2' ); ?>
</div><!-- #secondary -->
