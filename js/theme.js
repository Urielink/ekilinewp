/**
 * ekiline Theme scripts.
 * (http://stackoverflow.com/questions/11159860/how-do-i-add-a-simple-jquery-script-to-wordpress)
 */

	jQuery(document).ready(function($){

//		// Encapsulo el script de fuentes y le pido que lo invoque después de un segundo al cargar este archivo
//		setTimeout(function () {
//			
//			// parametros
//			WebFontConfig = {
//			  google: { families: [ 'Assistant:200,400,700' ] }
//			};		 
//			
//			// insertar script de fuentes
//			var sf = document.createElement("script");
//			sf.type = "text/javascript";
//			sf.src = "https://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js";
//			$("head").append(sf);
//			
//			// insertar estilo css para hacer el cambio en las fuentes
//			var styleFont = $('<style type="text/css" media="all">body{font-family: "Assistant", sans-serif !important;font-weight:400;}h1,h2,h3,h4,h5,h6{font-family: "Assistant", sans-serif !important;font-weight:200;}</style>');
//			$('html > head').append(styleFont);		
//	
//		}, 500);

		
	
	/**  Optimización, estilos dinámicos después de la carga
	 * 	Busco el head, y tambien si existe un 'link' y guardo el estilo en una variable para insertarlo.
	 *  apoyo: http://stackoverflow.com/questions/805384/how-to-apply-inline-and-or-external-css-loaded-dynamically-with-jquery
	 *  
	 *  Advertencia: Esta función se coordina con inc/extras.php, el orden de los scripts y este archivo.
	 */
		
		function miCss(archivoCss){

			var templateUrl = thepath.themePath;
			
			var $head = $("head");
			var $wpcss = $head.find("style[id='ekiline-inline']"); 
			var $cssinline = $head.find("style:last");
			var $ultimocss = $head.find("link[rel='stylesheet']:last");
			var linkCss = "<link rel='stylesheet' href='"+ templateUrl + archivoCss +"' type='text/css' media='screen'>";
	
	        // En caso de de encontrar una etiqueta de estilo ó link ó nada inserta el otro estilo css, 


			if ($wpcss.length){ 
					$wpcss.before(linkCss); 
				} else if ($cssinline.length){ 
					$cssinline.before(linkCss); 
				} else if ($ultimocss.length){ 
					$ultimocss.before(linkCss); 
				} else { 
					$head.append(linkCss); 
				}

			
		}
		
			miCss('/css/bootstrap.min.css');
			miCss('/css/font-awesome.min.css');
			miCss('/css/ekiline-layout.css');
			miCss('/style.css');
			//en caso de explorer
			if(/*@cc_on!@*/false){ miCss('/style.css'); }		
			
			
		// El preload
	    setTimeout(function(){
	        $('#loadMask').fadeOut(500);
	    }, 600);			          
			
		
/*		
		var desfaseItem = '.carousel';
		var desfaseItem = '.destacado-estilo';
		var desfaseDerecho = '.thumb';
		var apareceItem = '.entry-title';
		var textoLoco = '#carrusel-homeslide .carousel-caption h1';
		
		
			
	    //desfasa la imagen de fondo
		
	    $(window).bind("load resize scroll",function(e) {
	        var y = $(window).scrollTop();

	        $( desfaseItem ).filter(function() {
	            return $(this).offset().top < (y + $(window).height()) &&
	            $(this).offset().top + $(this).height() > y;
	        }).css('background-position', 'center ' + parseInt(y / -2) + 'px');        

	        $( desfaseDerecho ).filter(function() {
	            return $(this).offset().top < (y + $(window).height()) &&
	            $(this).offset().top + $(this).height() > y;
	        }).css('background-position', 'right ' + parseInt(y / 2) + 'px');                
	        
	    });

	    // aparece los elementos a medida del scroll
	    $(window).scroll( function(){

	        // Por cada imagen 
	        $( apareceItem ).each( function(i){

	            var bottom_of_object = $(this).offset().top + $(this).outerHeight();
	            var bottom_of_window = $(window).scrollTop() + $(window).height();

	            // Si esta en el lugar fade in 
	            if( bottom_of_window > bottom_of_object ){
	                $(this).animate({'opacity':'1'},500);
	            }            

	        }); 

	    }); 
	    
	    // Hacer un texto a desproporcion
	    var size = ['16px', '24px', '32px', '40px', '44px'];
	    var weight = ['100', '300', '700', '900'];
	    $(textoLoco).each(function(){
	        $(this).html($(this).text().split(' ').map(function(v){
	            return '<span style="font-size:'+size[Math.floor(Math.random()*size.length)]+';font-weight:'+weight[Math.floor(Math.random()*weight.length)]+'">'+v+'</span>';
	        }).join(' '));
	    });
	    
	    // affix al menu
	    $('#secondary').affix({
	    	  offset: {
	    	    top: 100,
	    	    bottom: function () {
	    	      return (this.bottom = $('.footer').outerHeight(true))
	    	    }
	    	  }
	    	});	 
	    
	    $('#secondary').on('affix.bs.affix', function () {
	        $('#primary').addClass('col-md-offset-3')
	    });
	    $('#secondary').on('affix-top.bs.affix', function () {
	        $('#primary').removeClass('col-md-offset-3')
	    });
*/

		// Lazyload para imagenes
		$('img').lazyload({ 
			threshold : 200,
		    //placeholder : 'apple-touch-icon.png',
		    effect : "fadeIn" 
		});	    
		
		// Carrusel: impedir que avance automaticamente
		
        $('.carousel').carousel({ interval: false });     
		

	    if ( $('#masthead').length ) {
	    	
	    	//console.log ('si header');
	    	//console.log ( $('#masthead').height() );
	    	
	    	$('.top-navbar.navbar-affix').affix({
		        offset: {
		          top: $('#masthead').height()
		        }
		    });

	    } else {
	    	
//	    	console.log ('no header');
//	    	console.log ( $('.top-navbar.navbar-affix').height() );

	    	$('.top-navbar.navbar-affix').affix({
		        offset: {
		          top: $('.top-navbar').height()
		        }
		    });	    	
	    	
	    }
	    

	    // Carrusel con swipe
	    $('.carousel').carousel({
	    	  swipe: 30 // percent-per-second, default is 50. Pass false to disable swipe
	    	});	    
	    

	}); 			
			