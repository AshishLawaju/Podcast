/*tabs & tours*/(function($) {
	"use strict";
	var WidgetTabHandler = function ($scope, $) {
		var $currentTab = $scope.find('.theplus-tabs-wrapper'),
		$TabHover = $currentTab.data('tab-hover'),
		$currentTabId = '#' + $currentTab.attr('id').toString();
		
		$($currentTabId + ' ul.plus-tabs-nav li .plus-tab-header').each( function(index) {
			var default_active=$(this).closest('.theplus-tabs-wrapper').data("tab-default");
			if( default_active == index ) {			
				$(this).removeClass('inactive').addClass('active');
			}			
		});

		$($currentTabId + ' .theplus-tabs-content-wrapper .plus-tab-content').each( function(index) {
			var default_active=$(this).closest('.theplus-tabs-wrapper').data("tab-default");
			if( default_active == index ) {
				$(this).removeClass('inactive').addClass('active');
			}
		});
		
		if('no' == $TabHover){
			$($currentTabId + ' ul.plus-tabs-nav li .plus-tab-header').on('click',function(){
				var currentTabIndex = $(this).data("tab");
				var tabsContainer = $(this).closest('.theplus-tabs-wrapper');
				var tabsNav = $(tabsContainer).children('ul.plus-tabs-nav').children('li').children('.plus-tab-header');
				var tabsContent = $(tabsContainer).children('.theplus-tabs-content-wrapper').children('.plus-tab-content');
				
				$(tabsContainer).find(">.theplus-tabs-nav-wrapper .plus-tab-header").removeClass('active default-active').addClass('inactive');
				$(this).addClass('active').removeClass('inactive');
				
				$(tabsContainer).find(">.theplus-tabs-content-wrapper>.plus-tab-content").removeClass('active').addClass('inactive');
				$(">.theplus-tabs-content-wrapper>.plus-tab-content[data-tab='"+currentTabIndex+"']",tabsContainer).addClass('active').removeClass('inactive');
			
				$(tabsContent).each( function(index) {
					$(this).removeClass('default-active');
				});				
				
				if($($currentTabId+" .list-carousel-slick > .post-inner-loop").length){
					$($currentTabId+" .list-carousel-slick > .post-inner-loop").slick('setPosition');	
				}
			});
		}
		if($($currentTabId).hasClass("mobile-accordion")){
			$(window).on("resize",function() {
				if($(window).innerWidth() <= 600){
					$($currentTabId).addClass("mobile-accordion-tab");
				}
			});
			$($currentTabId + ' .theplus-tabs-content-wrapper .elementor-tab-mobile-title').on('click',function(){
				var currentTabIndex = $(this).data("tab");
				var tabsContainer = $(this).closest('.theplus-tabs-wrapper');
				var tabsNav = $(tabsContainer).children('.theplus-tabs-content-wrapper').children('.elementor-tab-mobile-title');
				var tabsContent = $(tabsContainer).children('.theplus-tabs-content-wrapper').children('.plus-tab-content');
			
				$(tabsContainer).find(">.theplus-tabs-content-wrapper .elementor-tab-mobile-title").removeClass('active default-active').addClass('inactive');
				$(this).addClass('active').removeClass('inactive');
			
				$(tabsContainer).find(">.theplus-tabs-content-wrapper>.plus-tab-content").removeClass('active').addClass('inactive');
				$(">.theplus-tabs-content-wrapper>.plus-tab-content[data-tab='"+currentTabIndex+"']",tabsContainer).addClass('active').removeClass('inactive');
			
				$(tabsContent).each( function(index) {
					$(this).removeClass('default-active');
				});
				
				if($($currentTabId+" .list-carousel-slick > .post-inner-loop").length){
					$($currentTabId+" .list-carousel-slick > .post-inner-loop").slick('setPosition');
				}
			});
		}		
	};
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/tp-tabs-tours.default', WidgetTabHandler);
	});
})(jQuery);