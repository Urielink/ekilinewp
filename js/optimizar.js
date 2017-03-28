/**
 * ekiline Theme scripts.
 * (http://stackoverflow.com/questions/11159860/how-do-i-add-a-simple-jquery-script-to-wordpress)
 */
	/** variables globales: 
	 * la url del template
	 */	
	var templateUrl = recurso_script.templateUrl;

			
	jQuery(document).ready(function($) {


	//  Optimización, estilos dinámicos después de la carga
		// setTimeout(function () {
			
			// parametros
			WebFontConfig = {
			  google: { families: [ 'Raleway:400,300,700,300italic,400italic,700italic|Open+Sans:400,400italic,300italic,300,700,700italic' ] }
			};		 
			

		function miCss(archivoCss){
	
			// modifico el script para que busque los estilos del tema.
			var $head = $("head");
//			var $ultimocss = $head.find("link[rel='stylesheet']:last");
//			var $cssinline = $head.find("style:last");
			var $ultimocss = $head.find("link[id='ekiline-style-css']:last");
			var $cssinline = $head.find("style[id='ekiline-inline']:last");
			var linkCss = "<link rel='stylesheet' href='"+ templateUrl + archivoCss +"' type='text/css' media='screen'>";
				
	        // En caso de de encontrar una etiqueta de estilo ó link ó nada inserta el otro estilo css, 
	        	
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

		// }, 2000);
		

	});