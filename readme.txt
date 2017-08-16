=== Ekiline ===

Contributors: automattic
Tags: one-column, two-columns, three-columns, left-sidebar, right-sidebar, grid-layout, flexible-header, custom-background, custom-colors, custom-header, custom-menu, custom-logo, featured-image-header, featured-images, footer-widgets, full-width-template, microformats, theme-options, translation-ready, blog, e-commerce, entertainment, food-and-drink, news, portfolio, photography

Requires at least: 4.0
Tested up to: 4.7
Stable tag: 1.0.0
License: GNU General Public License v2 or later
License URI: LICENSE

A starter theme called ekiline, based in underscores.

== Description ==

Hi! Im ekiline, a theme for wordpress based in underscores.
Mi developer and designer is @Urielink, It has done all its enthusiasm and effort to make easier the process of personalizing a site that uses wordpress.
With me you can build a very simple or very robust site without needing to fill your wordpress installation of plugins.
And you can also make combinations of elements based on Bootstrap 3.7 to make web pages suitable to what you need.
I have everything you need to start a wordpress development.
But I'm still in development, if you like to be notified subscribe or follow me.

== Installation ==

1. In your admin panel, go to Appearance > Themes and click the Add New button.
2. Click Upload and Choose File, then select the theme's .zip file. Click Install Now.
3. Click Activate to use your new theme right away.

== Frequently Asked Questions ==

= Does this theme support any plugins? =

ekiline includes support for Infinite Scroll in Jetpack.

== Changelog ==

= 1.0 - May 01 2017 =
* Initial release

== Credits ==

* Based on Underscores http://underscores.me/, (C) 2012-2016 Automattic, Inc., [GPLv2 or later](https://www.gnu.org/licenses/gpl-2.0.html)
* normalize.css http://necolas.github.io/normalize.css/, (C) 2012-2016 Nicolas Gallagher and Jonathan Neal, [MIT](http://opensource.org/licenses/MIT)
* Bootstrap v3.3.7 http://getbootstrap.com, Copyright 2011-2016 Twitter, Inc., Bootstrap are licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
* Dimox breadcrumb licensed under [MIT] http://dimox.net/wordpress-breadcrumbs-without-a-plugin 
* Bootstrap Navwalker [GPLv3 or later] https://github.com/twittem/wp-bootstrap-navwalker
* Wordpress tools: https://codex.wordpress.org/Theme_Unit_Test

== Algunos metodos de compresión ==

#Version 1, compilada de lecturas web (metodo propio)

<ifModule mod_deflate.c>
  AddOutputFilterByType DEFLATE text/html text/xml text/css text/plain
  AddOutputFilterByType DEFLATE image/svg+xml application/xhtml+xml application/xml
  AddOutputFilterByType DEFLATE application/rdf+xml application/rss+xml application/atom+xml
  AddOutputFilterByType DEFLATE text/javascript application/javascript application/x-javascript application/json
  AddOutputFilterByType DEFLATE application/x-font-ttf application/x-font-otf
  AddOutputFilterByType DEFLATE font/truetype font/opentype
</ifModule>

<IfModule mod_expires.c>
	ExpiresActive On
	ExpiresByType image/jpg "access 1 week"
	ExpiresByType image/jpeg "access 1 week"
	ExpiresByType image/gif "access 1 week"
	ExpiresByType image/png "access 1 week"
	ExpiresByType image/ico "access 1 week"
	ExpiresDefault "access 7 days"
</IfModule>
 
## Fonts caching for a year
<FilesMatch "\.(eot|svg|ttf|woff)$">
	Header set Cache-Control "max-age=29030400, public"
</FilesMatch>
 
## Cache Icon, PDF and Flash movie for a year
<FilesMatch "\.(ico|pdf|flv|swf)$">
	Header set Cache-Control "max-age=29030400, public"
</FilesMatch>
 
## Cache CSS and JS for 1 week
<FilesMatch "\.(xml|txt|css|js)$">
	Header set Cache-Control "max-age=604800, proxy-revalidate"
</FilesMatch>



#Version 2, por goDaddy.

<IfModule mod_deflate.c>
# Compress HTML, CSS, JavaScript, Text, XML and fonts
AddOutputFilterByType DEFLATE application/javascript
AddOutputFilterByType DEFLATE application/rss+xml
AddOutputFilterByType DEFLATE application/vnd.ms-fontobject
AddOutputFilterByType DEFLATE application/x-font
AddOutputFilterByType DEFLATE application/x-font-opentype
AddOutputFilterByType DEFLATE application/x-font-otf
AddOutputFilterByType DEFLATE application/x-font-truetype
AddOutputFilterByType DEFLATE application/x-font-ttf
AddOutputFilterByType DEFLATE application/x-javascript
AddOutputFilterByType DEFLATE application/xhtml+xml
AddOutputFilterByType DEFLATE application/xml
AddOutputFilterByType DEFLATE font/opentype
AddOutputFilterByType DEFLATE font/otf
AddOutputFilterByType DEFLATE font/ttf
AddOutputFilterByType DEFLATE image/svg+xml
AddOutputFilterByType DEFLATE image/x-icon
AddOutputFilterByType DEFLATE text/css
AddOutputFilterByType DEFLATE text/html
AddOutputFilterByType DEFLATE text/javascript
AddOutputFilterByType DEFLATE text/plain
AddOutputFilterByType DEFLATE text/xml
# Remove browser bugs (only needed for really old browsers)
BrowserMatch ^Mozilla/4 gzip-only-text/html
BrowserMatch ^Mozilla/4\.0[678] no-gzip
BrowserMatch \bMSIE !no-gzip !gzip-only-text/html
Header append Vary User-Agent
</IfModule>

<IfModule mod_expires.c>
# Enable expirations
ExpiresActive On
# Default directive
ExpiresDefault "access plus 1 month"
# My favicon
ExpiresByType image/x-icon "access plus 1 year"
# Images
ExpiresByType image/gif "access plus 1 month"
ExpiresByType image/png "access plus 1 month"
ExpiresByType image/jpg "access plus 1 month"
ExpiresByType image/jpeg "access plus 1 month"
# CSS
ExpiresByType text/css "access plus 1 month"
# Javascript
ExpiresByType application/javascript "access plus 1 year"
</IfModule>


== Limitación de la plataforma ==


/*Deshabilitar cosas
 * Editor de temas y plugins
 * Instalación o update de plugins y temas
 * https://premium.wpmudev.org/blog/how-to-disable-the-wordpress-plugin-and-theme-editor/?imob=b&utm_expid=3606929-106.UePdqd0XSL687behGg-9FA.1&utm_referrer=https%3A%2F%2Fwww.google.com.mx%2F
 */
define('DISALLOW_FILE_EDIT',true);
define('DISALLOW_FILE_MODS',true);

//HAZ ESTO SI NO SOY YO
$current_user = wp_get_current_user();
if( $current_user->user_login != 'Urielink' ){

    /* Deshabilitar cosas
     * widgets de dashboard
     * https://codex.wordpress.org/Dashboard_Widgets_API#Advanced:_Removing_Dashboard_Widgets
     */
    function remove_dashboard_meta() {
            remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
            remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
            remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
            remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
            remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
            remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
            remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
            remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
            remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');//since 3.8
    }
    add_action( 'admin_init', 'remove_dashboard_meta' );
    /* Deshabilitar cosas (oculta pero ejecuta)
     * Objetos del menu lateral
     * https://codex.wordpress.org/Function_Reference/remove_menu_page
     */
     function remove_menus(){
      
      remove_menu_page( 'index.php' );                  //Dashboard
      remove_menu_page( 'jetpack' );                    //Jetpack* 
      // remove_menu_page( 'edit.php' );                   //Posts
      remove_menu_page( 'upload.php' );                 //Media
      // remove_menu_page( 'edit.php?post_type=page' );    //Pages
      remove_menu_page( 'edit-comments.php' );          //Comments
      // remove_menu_page( 'themes.php' );                 //Appearance
      remove_menu_page( 'plugins.php' );                //Plugins
      remove_menu_page( 'users.php' );                  //Users
      remove_menu_page( 'tools.php' );                  //Tools
      remove_menu_page( 'options-general.php' );        //Settings
      remove_menu_page( 'link-manager.php' );        //Links
    }
    add_action( 'admin_menu', 'remove_menus' );
    /* Deshabilitar cosas (oculta pero ejecuta)
     * Objetos del menu superior
     * https://codex.wordpress.org/Function_Reference/remove_node
     */
    function remove_nodes( $wp_admin_bar ) {
        $wp_admin_bar->remove_node( 'wp-logo' );
        $wp_admin_bar->remove_node( 'comments' );
          $wp_admin_bar->remove_node( 'new-user' );
          $wp_admin_bar->remove_node( 'new-media' );
          $wp_admin_bar->remove_node( 'my-account' );
          $wp_admin_bar->remove_node( 'user-info' );
          $wp_admin_bar->remove_node( 'edit-profile' );
    }
    add_action( 'admin_bar_menu', 'remove_nodes', 999 );
    /* Añadir solo un boton
     * https://wordpress.stackexchange.com/questions/23035/remove-edit-your-profile-from-admin-menu-bar
     */
    function add_nodes( $wp_admin_bar ) {
        $args = array(
            'id'     => 'logout',           // id of the existing child node (New > Post)
            'parent' => 'top-secondary',    // set parent
            );
        $wp_admin_bar->add_node( $args );
    }
    add_action( 'admin_bar_menu', 'add_nodes', 999 );

}//FIN HAZ ESTO SI NO SOY YO


/* Restringir el acceso a ciertas páginas
 * https://wordpress.stackexchange.com/questions/242813/plugin-to-restrict-access-to-pages-in-wp-admin
 * https://codex.wordpress.org/Function_Reference/wp_get_current_user
 * https://wordpress.stackexchange.com/questions/91330/restrict-admin-access-to-certain-pages-for-certain-users
 */

if( $current_user->user_login != 'Urielink' ){
    add_filter( 'admin_init', 'restricciones_admin' );
}

function restricciones_admin() {
    
    global $pagenow;
    
    $arr = array(
        'update-core.php',
        //'edit.php',
        'user-new.php',
        'upload.php',
        'media-new.php',
        'edit-comments.php',
        'plugins.php',
        'users.php',
        'profile.php',
        'tools.php',
        'import.php',
        'export.php',
        'options-general.php',
        'options-writing.php',
        'options-reading.php',
        'options-discussion.php',
        'options-media.php',
        'options-permalink.php',
        'options-general.php?page=customizer-preview-for-theme-demo',
        'options-general.php?page=limit-login-attempts'
    );    
    
    foreach ($arr as $key => $value) {
        if ( $pagenow == $value ) {
            echo 'Lo siento, no tienes permisos para acceder a esta página.';
            wp_die();
        }       
    }

}     
 
  
 
/*
 * Añadir seguridad
 * http://www.wpbeginner.com/wp-tutorials/9-most-useful-htaccess-tricks-for-wordpress/
 * https://wordpress.stackexchange.com/questions/37144/how-to-protect-uploads-if-user-is-not-logged-in
 * https://wordpress.stackexchange.com/questions/23007/how-do-i-remove-dashboard-access-from-specific-user-roles
 */