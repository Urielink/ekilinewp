/**
 * ekiline Theme scripts.
 * (http://stackoverflow.com/questions/11159860/how-do-i-add-a-simple-jquery-script-to-wordpress)
 */
	/** variables globales: 
	 * la url del template
	 */	
			
	jQuery(document).ready(function($) {


	//  Optimizacion, estilos dinamicos despues de la carga
		// setTimeout(function () {						

		function miCss(optimizarCSS){
	
			// modifico el script para que busque los estilos del tema.
			var $head = $("head");
			// var $ultimocss = $head.find("link[rel='stylesheet']:last");
			// var $cssinline = $head.find("style:last");
			var $ultimocss = $head.find("link[id='ekiline-style-css']:last");
			var $cssinline = $head.find("style[id='ekiline-inline']:last");
			var linkCss = "<link rel='stylesheet' href='"+ optimizarCSS +"' type='text/css' media='screen'>";
				
	        // En caso de de encontrar una etiqueta de estilo o link o nada inserta el otro estilo css, 
	        	
			if ($cssinline.length){ 
					$cssinline.before(linkCss); 
				} else if ($ultimocss.length){
					$ultimocss.before(linkCss); 
				} else { 
					$head.append(linkCss); 
				}
		}
		
		miCss(recurso_script.css1);
		miCss(recurso_script.css2);
		miCss(recurso_script.css3);
		miCss(recurso_script.css4);
		miCss(recurso_script.css5);

		// }, 1000); // setTimeout()
		

	});