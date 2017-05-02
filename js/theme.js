/**
 * ekiline Theme scripts.
 * (http://stackoverflow.com/questions/11159860/how-do-i-add-a-simple-jquery-script-to-wordpress)
 */

	jQuery(document).ready(function($){
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
		
		// Carrusel: impedir que avance automaticamente
		
        $('.carousel').carousel({ interval: false });     
		

	    if ( $('#masthead').length ) {
	    	
	    	console.log ('si header');
	    	console.log ( $('#masthead').height() );
	    	
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
			