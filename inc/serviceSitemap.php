<?php
/**
 * Function to automatically create a standard sitemap.xml
 * @package ekiline
 */

if( true === get_theme_mod('ekiline_sitemap') && is_admin() ) {
 
	add_action('admin_bar_menu', 'add_item', 80);
	
	function add_item( $admin_bar ){
		
	  global $pagenow;
	  $admin_bar->add_menu( array(
	  	'id'=>'ekiline-sitemap',
	  	'title'=>'Sitemap',
	  	'href'=>'#',
		'meta' => array(
			'class' => 'advice',
			)
		)
	  );
	  
	}

	add_action( 'admin_footer', 'ekiline_sitemap_action_js' );
	
	function ekiline_sitemap_action_js() { ?>
	  <script type="text/javascript" >
	     jQuery("li#wp-admin-bar-ekiline-sitemap .ab-item").on( "click", function() {
	        var data = { 'action': 'ekiline_sitemap_write' };
	        jQuery.post(ajaxurl, data, function(response) {
	           alert( response );
	        });		        	                	
	      });
	      
	  </script> <?php
	}

	add_action( 'wp_ajax_ekiline_sitemap_write', 'ekiline_sitemap_xml' );

} 


function ekiline_sitemap_xml() {

	$sitemap = '' ;
	
	$sitemapLimit = get_theme_mod('ekiline_sitemaplimit');
	
	if ( $sitemapLimit == '0' || null ){
		$sitemapLimit = '1';
	} else if ($sitemapLimit >= '200'){
		$sitemapLimit = '200';
	}

	if( str_replace( '-', '', get_option( 'gmt_offset' ) ) < 10 ) {
		$timeZone = '-0' . str_replace( '-', '', get_option( 'gmt_offset' ) ) ;
	} else {
		$timeZone = get_option( 'gmt_offset' ) ;
	}
	
	if( strlen( $timeZone ) == 3 ) {
		$timeZone = $timeZone . ':00' ;
	}

	$arrayPosts = array( 'post','page' );
	if ( class_exists( 'WooCommerce' ) ) {
		$arrayPosts = array( 'post','page','product' );
	} 	

	$postsForSitemap = get_posts(array(
			'numberposts' => $sitemapLimit,
			'orderby' => 'modified',
			'post_type' => $arrayPosts,
			'order' => 'DESC'
	));
	
	$sitemap .= '<?xml version="1.0" encoding="UTF-8"?>';
	$sitemap .= '<!-- Generated by Ekiline SEO Wordpress Theme (ekiline.com) -->' . "\n";
	$sitemap .= '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
	$sitemap .= "\t" . '<url>' . "\n" . 
				"\t\t" . '<loc>' . esc_url( home_url( '/' ) ) .'</loc>' . 
				"\n\t\t" . '<lastmod>' . date( "Y-m-d\TH:i:s", current_time( 'timestamp', 0 ) ) . $timeZone . '</lastmod>' . 
				"\n\t\t" . '<changefreq>daily</changefreq>' . 
				"\n\t\t" . '<priority>1.0</priority>' . 
				"\n\t" . '</url>' . "\n" ;

	foreach( $postsForSitemap as $post ){
		setup_postdata( $post ) ;
		$postdate = explode( ' ', $post->post_modified ) ;
		$priority = '0.8';
		$pfreq = 'weekly';
		$ptype = explode( ' ', $post->post_type ) ;
		if ($ptype[0] == 'page'){ $priority = '0.5'; $pfreq = 'monthly'; }
		
		$sitemap .= "\t" . '<url>' . "\n" . 
					"\t\t" . '<loc>' . get_permalink($post->ID) . '</loc>' . 
					"\n\t\t" . '<lastmod>' . $postdate[0] . 'T' . $postdate[1] . $timeZone . '</lastmod>' . 
					"\n\t\t" . '<changefreq>' . $pfreq . '</changefreq>' . 
					"\n\t\t" . '<priority>' . $priority . '</priority>' . 
					"\n\t" . '</url>' . "\n" ;
	}

	$sitemap .= '</urlset>' ;

	WP_Filesystem();
	global $wp_filesystem;
	
	$homedir = $wp_filesystem->abspath();
	$file = trailingslashit( $homedir ) . 'sitemap.xml';
	$wp_filesystem->put_contents( $file, $sitemap, FS_CHMOD_FILE );
    $response = __('Sitemap created successfully!', 'ekiline') . "\n" . get_site_url() . '/sitemap.xml';
    echo $response;		
	
    wp_die();
}