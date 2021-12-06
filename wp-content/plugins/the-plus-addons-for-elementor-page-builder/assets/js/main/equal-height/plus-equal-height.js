/*equal height*/( function ( $ ) {	
	$.fn.equalHeights = function() {
  var max_height = 0;
  $(this).each(function() {
    max_height = Math.max($(this).outerHeight(), max_height);
  });
  $(this).each(function() {
    $(this).css('min-height',max_height);
  });
};

$(document).ready(function() {
	var container = $('.elementor-element[data-tp-equal-height-loadded]');
    if(container.length){
		container.each(function() {
			var id = $(this).data('id');
			var new_find = $(this).data('tp-equal-height-loadded');
			$('.elementor-element-'+id +' '+ new_find).equalHeights();
		});	
	}
	
});
$(window).on("load resize",function() {
	var container = $('.elementor-element[data-tp-equal-height-loadded]');
    if(container.length){
		container.each(function() {
			var id = $(this).data('id');
			var new_find = $(this).data('tp-equal-height-loadded');
			$('.elementor-element-'+id +' '+ new_find).equalHeights();
		});	
	}
});

} ( jQuery ) );

