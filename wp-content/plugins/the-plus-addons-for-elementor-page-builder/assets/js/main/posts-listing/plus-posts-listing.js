/*posts listing*/( function( $ ) {
	"use strict";
	var WidgetThePlusHandler = function ($scope, $) {
		var wid_sec=$scope.parents('section.elementor-element');

		if($scope.hasClass("elementor-widget") && $scope.find('.list-isotope').length>0){
			var b = window.theplus || {};
			b.window = $(window),
			b.document = $(document),
			b.windowHeight = b.window.height(),
			b.windowWidth = b.window.width();	
			b.list_isotope_Posts = function() {
				var c = function(c) {
					$('.list-isotope',$scope).each(function() {						
						var e, c = $(this), d = c.data("layout-type"),f = {
							itemSelector: ".grid-item",
							resizable: !0,
							sortBy: "original-order"
						};
						var uid=c.data("id");
						var inner_c=$('.'+uid).find(".post-inner-loop");
						$('.'+uid).addClass("pt-plus-isotope layout-" + d),
						e = "masonry" === d  ? "packery" : "fitRows",
						f.layoutMode = e,
						function() {
							//b.initMetroIsotope(),
							var generate_isotope = inner_c.isotope(f);
							generate_isotope.imagesLoaded().progress( function() {
								generate_isotope.isotope('layout');
							});
						}();
					});
				};
				if($scope.find('.list-isotope .post-filter-data').length>0){
					//List Isotope Filter Item
					$('.list-isotope .post-filter-data').find(".filter-category-list").on('click',function(event) {
						event.preventDefault();
						var p_list = $(this).closest(".list-isotope"),uid = p_list.data("id");
						
						var d = $(this).attr("data-filter");
						$(this).parent().parent().find(".active").removeClass("active"),
						$(this).addClass("active"),
						$('.'+uid).find(".post-inner-loop").isotope({
							filter: d
						}),
						$("body").trigger("isotope-sorted");
					});
				}
				b.window.on("resize", function() {
					c('[data-enable-isotope="1"]')
				}),
				b.document.on("load resize", function() {
					c('[data-enable-isotope="1"]')
				}),
				$(document).ready(function() {
					c('[data-enable-isotope="1"]')					
				}),
				$("body").on("post-load resort-isotope", function() {
					setTimeout(function() {
						c('[data-enable-isotope="1"]')
					}, 800)
				}),
				$("body").on("tabs-reinited", function() {
					setTimeout(function() {
						c('[data-enable-isotope="1"]')
					}, 800)
				});
			},
			b.init = function() {				
				b.list_isotope_Posts();				
			}
			,
			b.init();
		}
		if($scope.hasClass("elementor-widget") && $scope.find('.list-isotope-metro').length>0){
			$(window).on("resize", function() {
				theplus_setup_packery_portfolio('all');
				$('.list-isotope-metro .post-inner-loop').isotope('layout').isotope("reloadItems");
			});
			
			$("body").on("post-load resort-isotope", function() {
				setTimeout(function() {
					theplus_setup_packery_portfolio('all');
					$('.list-isotope-metro .post-inner-loop').isotope('layout');
				}, 800)
			});
			$("body").on("tabs-reinited", function() {
				setTimeout(function() {
					theplus_setup_packery_portfolio('all');
					$('.list-isotope-metro .post-inner-loop').isotope('layout');
				}, 800)
			});
		}
		if($scope.hasClass("elementor-widget") && $scope.find('.gallery-list.gallery-style-3').length>0){
			$('.gallery-list.gallery-style-3 .grid-item').each( function() { $(this).hoverdir(); } );
		}
		/* post listing out*/
		if($scope.hasClass("elementor-widget") && $scope.find('.dynamic-listing.dynamic-listing-style-1,.blog-list.blog-style-1,.gallery-list.gallery-style-2').length>0){
			$(document).ready(function($) {
				$(document).on('mouseenter',".dynamic-listing.dynamic-listing-style-1 .grid-item .blog-list-content,.blog-list.blog-style-1 .grid-item .blog-list-content,.gallery-list.gallery-style-2 .grid-item .gallery-list-content",function() {				
					$(this).find(".post-hover-content").slideDown(300)
				});
				$(document).on('mouseleave',".dynamic-listing.dynamic-listing-style-1 .grid-item .blog-list-content,.blog-list.blog-style-1 .grid-item .blog-list-content,.gallery-list.gallery-style-2 .grid-item .gallery-list-content",function() {
					$(this).find(".post-hover-content").slideUp(300)
				})
			});
		}
		
	};
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/global', WidgetThePlusHandler);
	});
})(jQuery);