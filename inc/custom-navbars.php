<?php
/**
 * Script para modificar los menus preestablecidos.
 *
 * @package ekiline
 */

// menu en la parte superior top
 
function topNavbar(){
	 
if ( has_nav_menu( 'top' ) ) : ?>
<nav id="site-navigation-top"  class="navbar navbar-default overtake top-navbar" role="navigation" data-spy="affix" data-offset-top="200">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse.top">
                <span class="sr-only"><?php _e('Toggle navigation','ekiline') ?> </span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- Your site title as branding in the menu -->                
            <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php logoTheme(); ?></a>
			<p class="navbar-text hidden-xs"><?php echo get_bloginfo( 'description' ); ?></p>        	
        </div>
        
        <div id="navbar-collapse-out" class="collapse navbar-collapse top">
        			
        <!-- The WordPress Menu goes here -->
        <?php wp_nav_menu( array(
                'menu'              => 'top',
                'theme_location'    => 'top',
                'depth'             => 2,
//                'container'         => 'div',
//                    'container_class'   => 'collapse navbar-collapse top',
//                    'container_id'      => 'navbar-collapse-out',
                'container'         => '',
                'menu_class'        => 'nav navbar-nav navbar-right',
                'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                'menu_id'           => 'top-menu',
                'walker'            => new wp_bootstrap_navwalker()
                )
        ); ?>

		<?php dynamic_sidebar( 'navwidget-nw1' ); ?>     
        
        </div>
    </div><!-- .container -->         
</nav><!-- .site-navigation -->         
<?php endif;

}


// menu en la parte superior del contenido (primary)


function primaryNavbar(){
	
if ( has_nav_menu( 'primary' ) ) : ?>
        <nav id="site-navigation-primary"  class="navbar navbar-default primary-navbar" role="navigation">
            <div class="navbar-header">
                <!-- .navbar-toggle is used as the toggle for collapsed navbar content -->
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse.primary">
                    <span class="sr-only"><?php _e('Toggle navigation','ekiline') ?> </span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Your site title as branding in the menu -->                
                <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php logoTheme(); ?></a>
	            <p class="navbar-text"><?php echo get_bloginfo( 'description' ); ?></p>
            </div><!-- .navbar-header -->
            

            <!-- The WordPress Menu goes here -->
            <?php wp_nav_menu( array(
                    'menu'              => 'primary',
                    'theme_location'    => 'primary',
                    'depth'             => 2,
                    'container'         => 'div',
                        'container_class'   => 'collapse navbar-collapse primary',
                        'container_id'      => 'navbar-collapse-in',
                    'menu_class'        => 'nav navbar-nav',
                    'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                    'menu_id'           => 'main-menu',
                    'walker'            => new wp_bootstrap_navwalker())
            ); ?>                           
            
    		<?php dynamic_sidebar( 'navwidget-nw2' ); ?>     
    
        </nav><!-- .site-navigation -->		
        
<?php endif;
}
