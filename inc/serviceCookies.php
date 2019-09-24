<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * Establecer la politica de privacidad, ley cookie.
 * Set privacy terms and cookies.
 * 
 * @link una version sencilla: http://www.estudiosurestao.com/blog/mensaje-politica-de-cookies/
 * @link extraer el permanlink de un listado: https://developer.wordpress.org/reference/functions/get_permalink/
 * @link https://gist.github.com/ajskelton/27369df4a529ac38ec83980f244a7227
 *
 * @package ekiline 
 */

if ( get_theme_mod('ekiline_dropdownpages_setting_id') != '' ){
	add_action('wp_footer', 'my_privacy_js', 100); 
}  

function my_privacy_js() { 
	
    $lawUrl = get_theme_mod('ekiline_dropdownpages_setting_id'); 
	$lawUrl = esc_url( get_permalink( $lawUrl ) );
	
	$message = __( 'This site uses cookies. By continuing to browse the site, you are agreeing to our use of cookies.','ekiline' );
	$accept = __( 'Agree','ekiline' );
	$info = __( 'Find out more.','ekiline' );
	
	$alert = '<div id="cookieLaw" class="alert alert-dark alert-dismissible fade show fixed-bottom m-0" role="alert">';
	$alert .= $message; 
	$alert .= '<a class="btn btn-link" href="'.$lawUrl.'">'.$info.'</a>';
	$alert .= '<a class="accept btn btn-success btn-sm text-light" data-dismiss="alert">'.$accept.'</a>';
	$alert .= '<button type="button" class="accept close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>';
	$alert .= '</div>';
		
?>	
	
<script type='text/javascript'>
jQuery(document).ready(function($){
	
	var alert = '<?php echo $alert; ?>';
	
	function GetCookie(name) {
		var arg=name+"=";
		var alen=arg.length;
		var clen=document.cookie.length;
		var i=0;

		while (i<clen) {
			var j=i+alen;

			if (document.cookie.substring(i,j)==arg)
				return "1";
			i=document.cookie.indexOf(" ",i)+1;
			if (i==0)
				break;
		}

		return null;
	}

	$(function() {

		var visit=GetCookie("cookies_ekiline");

		if (visit==null){
			/* nueva visita */
			$('body').append( alert );
			/*console.log('nueva visita');*/
			/* visita acepta cookies */
			$("#cookieLaw .accept").on('click',function(e) {

				var expire=new Date();
				expire=new Date(expire.getTime()+7776000000);
				document.cookie="cookies_ekiline=aceptada; expires="+expire;

				var visit=GetCookie("cookies_ekiline");
				/*console.log('visita da clic')*/

			});  				

		} /* visit==1 en caso de extender funciones */

	});

});
</script>

<?php }