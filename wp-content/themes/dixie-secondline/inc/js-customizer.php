<?php
/**
 * SecondLine JS Customizer
 *
 * @package slt
 */

function secondline_themes_enqueue_script() {
	
	$secondline_ltr_checker = 'true';
	if(is_rtl()) {
		$secondline_ltr_checker = 'false';
	}	
	
	if ( get_theme_mod( 'secondline_themes_blog_pagination', 'default') == 'default' ) {
		
	   wp_add_inline_script( 'secondline-scripts', '	
			jQuery(document).ready(function($) { "use strict";
		
				/* Default Isotope Load Code */
				var $container = $(".secondline-blog-index-masonry").isotope();
				var $imgs = $(".secondline-blog-index-masonry img");
				$container.imagesLoaded( function() {
					$(".secondline-masonry-item").addClass("opacity-secondline");
					$container.isotope({
						itemSelector: ".secondline-masonry-item",				
						percentPosition: true,
						originLeft: ' . $secondline_ltr_checker . ',
						layoutMode: "' . esc_attr(get_theme_mod( "secondline_themes_blog_masonry_fit", "fitRows")) . '" 
			 		});
					$imgs.load(function () {
						$container.isotope("layout");
					});					
				});
				/* END Default Isotope Code */
		});
		' 
		);

	}
	
	
	if ( get_theme_mod( 'secondline_themes_blog_pagination') == 'infinite-scroll' ) {
		
	   wp_add_inline_script( 'secondline-scripts', '	
			jQuery(document).ready(function($) { "use strict";
		
				/* Default Isotope Load Code */
				var $container = $(".secondline-blog-index-masonry").isotope();
				var $imgs = $(".secondline-blog-index-masonry img");
				$container.imagesLoaded( function() {
					$(".secondline-masonry-item").addClass("opacity-secondline");
					$container.isotope({
						itemSelector: ".secondline-masonry-item",				
						percentPosition: true,
						originLeft: ' . $secondline_ltr_checker . ',
						layoutMode: "' . esc_attr(get_theme_mod( "secondline_themes_blog_masonry_fit", "fitRows")) . '" 
			 		});
					$imgs.load(function () {
						$container.isotope("layout");
					});					
				});
				/* END Default Isotope Code */
				
				
				/* Begin Infinite Scroll */
				$container.infinitescroll({
				  navSelector  : ".infinite-nav-slt",  
				  nextSelector : ".nav-previous a", 
				  itemSelector : ".secondline-masonry-item", 
			   		loading: {
			   		 	img: "' . esc_url( get_template_directory_uri() ) . '/images/loader.gif",
			   			 msgText: "",
			   		 	finishedMsg: "<div id=' . "'" . 'no-more-posts' . "'" . '>' . esc_html__( "No more posts", "dixie-secondline" ) . '</div>",
			   		 	speed: 0, }
				  },
				  // trigger Isotope as a callback
				  function( newElements ) {
					  
					 var player = $(".wp-block-audio audio, .powerpress_player audio, audio.wp-audio-shortcode");
						player.mediaelementplayer({
							 "classPrefix": "mejs-",				 
							 "isVideo": false,
							 "setDimensions": false,
							 "preload": "none",
							 "pauseOtherPlayers": true,
							 "alwaysShowControls": true,						
							 "startVolume": 0.8,
							 "skipBackInterval": 30,
							 "jumpForwardInterval": 30,
							 "timeAndDurationSeparator": "<span> / </span>",
							 "features": ["skipback", "playpause", "jumpforward", "current", "progress", "duration", "tracks", "volume", "speed"],
							 "speeds": ["2", "1.5", "1.25", "0.75"],
							 "defaultSpeed": "1",
							 success: function (mediaElement) { mediaElement.pause(); }           
					 });

					  
					  
				     $(".secondline-themes-gallery").flexslider({
				 		animation: "fade",      
				 		slideDirection: "horizontal", 
				 		slideshow: false,   
				 		smoothHeight: false,
				 		slideshowSpeed: 7000,  
				 		animationSpeed: 1000,        
				 		directionNav: true,             
				 		controlNav: true,
				 		prevText: "",   
				 		nextText: "",
				     });
					  
				    	$(".secondline-themes-default-blog-overlay a[data-rel^=\'prettyPhoto\'], .secondline-themes-feaured-image a[data-rel^=\'prettyPhoto\']").prettyPhoto({
				  			theme: "pp_default",
				    			hook: "data-rel",
				  			opacity: 0.7,
				    			show_title: false, 
				    			deeplinking: false,
				    			overlay_gallery: false,
				    			custom_markup: "",
				  			default_width: 1100,
				  			default_height: 619,
				    		social_tools:""
				    	});
						
						$(".secondline-themes-default-blog-overlay, .secondline-themes-default-blog-index").fitVids();

				    var $newElems = $( newElements );
		 	
						$newElems.imagesLoaded(function(){
							
						$container.isotope( "appended", $newElems );
						$(".secondline-masonry-item").addClass("opacity-secondline");
						
						if (typeof sppressProPlayerReboot !== "undefined" && $.isFunction(sppressProPlayerReboot)) {						
							if ($(".sm2-main-controls")[0]) {
								sppressProPlayerReboot();
							}															
						}
						if ($(".sppaudioplayer")[0]) {
							$("audio").audioPlayer();
						}						
						
					});

				  }
				);
			    /* END Infinite Scroll */
				
				
		});
		' 
		);

	}
	
	
	if ( get_theme_mod( 'secondline_themes_blog_pagination') == 'load-more' ) {
		
	   wp_add_inline_script( 'secondline-scripts', '	
			jQuery(document).ready(function($) { "use strict";
		
				/* Default Isotope Load Code */
				var $container = $(".secondline-blog-index-masonry").isotope();
				var $imgs = $(".secondline-blog-index-masonry img");
				$container.imagesLoaded( function() {
					$(".secondline-masonry-item").addClass("opacity-secondline");
					$container.isotope({
						itemSelector: ".secondline-masonry-item",				
						percentPosition: true,
						originLeft: ' . $secondline_ltr_checker . ',
						layoutMode: "' . esc_attr(get_theme_mod( "secondline_themes_blog_masonry_fit", "fitRows")) . '" 
			 		});
					$imgs.load(function () {
						$container.isotope("layout");
					});						
				});
				/* END Default Isotope Code */
				
				/* Begin Infinite Scroll */
				$container.infinitescroll({
					errorCallback: function(){  $(".infinite-nav-slt").delay(500).fadeOut(500, function(){ $(this).remove(); }); },
				  navSelector  : ".infinite-nav-slt",  
				  nextSelector : ".nav-previous a", 
				  itemSelector : ".secondline-masonry-item", 
			   		loading: {
			   		 	img: "' . esc_url( get_template_directory_uri() ) . '/images/loader.gif",
			   			 msgText: "",
			   		 	finishedMsg: "<div id=' . "'" . 'no-more-posts' . "'" . '>' . esc_html__( "No more posts", "dixie-secondline" ) . '</div>",
			   		 	speed: 0, }
				  },
				  // trigger Isotope as a callback
				  function( newElements ) {

					 var player = $(".wp-block-audio audio, .powerpress_player audio, audio.wp-audio-shortcode");
						player.mediaelementplayer({
							 "classPrefix": "mejs-",				 
							 "isVideo": false,
							 "setDimensions": false,
							 "preload": "none",
							 "pauseOtherPlayers": true,
							 "alwaysShowControls": true,						
							 "startVolume": 0.8,
							 "skipBackInterval": 30,
							 "jumpForwardInterval": 30,
							 "timeAndDurationSeparator": "<span> / </span>",
							 "features": ["skipback", "playpause", "jumpforward", "current", "progress", "duration", "tracks", "volume", "speed"],
							 "speeds": ["2", "1.5", "1.25", "0.75"],
							 "defaultSpeed": "1",
							 success: function (mediaElement) { mediaElement.pause(); }           
					 });

					  
					  
				     $(".secondline-themes-gallery").flexslider({
				 		animation: "fade",      
				 		slideDirection: "horizontal", 
				 		slideshow: false,   
				 		smoothHeight: false,
				 		slideshowSpeed: 7000,  
				 		animationSpeed: 1000,        
				 		directionNav: true,             
				 		controlNav: true,
				 		prevText: "",   
				 		nextText: "",
				     });
					  
				    	$(".secondline-themes-default-blog-overlay a[data-rel^=\'prettyPhoto\'], .secondline-themes-feaured-image a[data-rel^=\'prettyPhoto\']").prettyPhoto({
				  			theme: "pp_default",
				    			hook: "data-rel",
				  			opacity: 0.7,
				    			show_title: false, 
				    			deeplinking: false,
				    			overlay_gallery: false,
				    			custom_markup: "",
				  			default_width: 1100,
				  			default_height: 619,
				    		social_tools:""
				    	});
						
						$(".secondline-themes-default-blog-overlay, .secondline-themes-default-blog-index").fitVids();
					  

				    var $newElems = $( newElements );
		 	
						$newElems.imagesLoaded(function(){
							
						$container.isotope( "appended", $newElems );
						$(".secondline-masonry-item").addClass("opacity-secondline");
						
						if (typeof sppressProPlayerReboot !== "undefined" && $.isFunction(sppressProPlayerReboot)) {						
							if ($(".sm2-main-controls")[0]) {
								sppressProPlayerReboot();
							}															
						}
						if ($(".sppaudioplayer")[0]) {
							$("audio").audioPlayer();
						}						
						
					});

				  }
				);
			    /* END Infinite Scroll */
				 
	 			/* PAUSE FOR LOAD MORE */
	 			$(window).unbind(".infscr");
	 			// Resume Infinite Scroll
	 			$(".nav-previous a").click(function(){
	 				$container.infinitescroll("retrieve");
	 				return false;
	 			});
	 			/* End Infinite Scroll */
			
				 
		});
		' 
		);

	}

}
add_action( 'wp_enqueue_scripts', 'secondline_themes_enqueue_script' );