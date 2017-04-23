<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package ekiline
 */

// Breadcrumb

function breadcrumb() {
	
	if( !is_front_page() ){
		
		echo '<ol id="crumbs" class="breadcrumb">';
		if (!is_home()) {
			echo '<li><a href="';
			echo home_url();
			echo '">';
			echo esc_html__('Home', 'ekiline');
			echo "</a>&nbsp;</li>";
			if (is_category() || is_single()) {
				echo '<li>';
				the_category(' </li><li> ');
				if (is_single()) {
					echo "</li><li>";
					the_title();
					echo '</li>';
				}
			} elseif (is_page()) {
				echo '<li>';
				echo the_title();
				echo '</li>';
			}
		}
		elseif (is_tag()) {
			single_tag_title();
		}
		elseif (is_day()) {
			echo"<li>Archive for "; the_time('F jS, Y'); echo'</li>';
		}
		elseif (is_month()) {
			echo"<li>Archive for "; the_time('F, Y'); echo'</li>';
		}
		elseif (is_year()) {
			echo"<li>Archive for "; the_time('Y'); echo'</li>';
		}
		elseif (is_author()) {
			echo"<li>Author Archive"; echo'</li>';
		}
		elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
			echo "<li>Blog Archives"; echo'</li>';
		}
		elseif (is_search()) {
			echo"<li>Search Results"; echo'</li>';
		}
		echo '</ol>';
	
	}
	
}
