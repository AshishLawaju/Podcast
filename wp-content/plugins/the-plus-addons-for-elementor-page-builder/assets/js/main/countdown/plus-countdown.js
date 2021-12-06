( function( $ ) {
	"use strict";
	var WidgetCountDownHandler = function ($scope, $) {
		if($scope.find('.pt_plus_countdown').length>0){
			theplus_countdown();
			
			$(".pt_plus_countdown").change(function () {
				theplus_countdown();
			});
			
			function theplus_countdown(){
				$(".pt_plus_countdown").each(function () {
					var attrthis =$(this);
					var timer1 = attrthis.attr("data-timer");
					var offset_timer = attrthis.attr("data-offset");
					var text_days=attrthis.data("days");
					var text_hours=attrthis.data("hours");
					var text_minutes=attrthis.data("minutes");
					var text_seconds=attrthis.data("seconds");
					attrthis.downCount({
						date: timer1,
						offset: offset_timer,
						text_day:text_days,
						text_hour:text_hours,
						text_minute:text_minutes,
						text_second:text_seconds,
					});
				});
			}
		}
	};
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/tp-countdown.default', WidgetCountDownHandler);	
	});
})(jQuery);