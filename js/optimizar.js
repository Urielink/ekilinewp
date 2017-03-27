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

		function miCss(archivoCss){
	
			var $head = $("head");
//			var $ultimocss = $head.find("link[rel='stylesheet']:last");
			// modifico el script para que busque el estilo principal de la página.
			var $ultimocss = $head.find("link[id='ekiline-style-css']:last");
			var $cssinline = $head.find("style:last");
			var linkCss = "<link rel='stylesheet' href='"+ templateUrl + archivoCss +"' type='text/css' media='screen'>";
			
			console.log(templateUrl);
	
	        // En caso de de encontrar una etiqueta de estilo ó link ó nada inserta el otro estilo css, 
	        	
			if ($cssinline.length){ 
					//$cssinline.before(linkCss); 
				/*} else if ($ultimocss.length){ */
					$ultimocss.before(linkCss); 
				} else { 
					$head.append(linkCss); 
				}
		}
		
		miCss(recurso_script.css1);
		miCss(recurso_script.css2);
		miCss(recurso_script.css3);
		miCss(recurso_script.css4);
		

	});