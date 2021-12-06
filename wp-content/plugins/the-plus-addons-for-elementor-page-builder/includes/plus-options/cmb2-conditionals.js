jQuery( document ).ready( function( $ ) {
	'use strict';
	$( 'input[data-conditional-id]' ).each(function () {
	var $this=$(this);
	var ids=$(this).data('conditional-id');
	var values=$(this).data('conditional-value');
		$( "#"+ids ).change(function () {
		
		$( "#"+ids+" option:selected" ).each(function() {
		  var value = $( this ).val();
			if(value==values){
				$this.parent('td').parent('tr').removeClass("hidden").addClass("show");
			}else{
				$this.parent('td').parent('tr').removeClass("show").addClass("hidden");
			}
		});
		
	  })
	  .change();
	});
});

(function(a){'use strict';function b(){a('[data-conditional-id]').each((c,d)=>{function e(k){return g.includes(k)&&''!==k}let f=d.dataset.conditionalId,g=d.dataset.conditionalValue,h=d.closest('.cmb-row'),j=h.classList.contains('cmb-repeat-group-field');if(j){let k=h.closest('.cmb-repeatable-group').getAttribute('data-groupid'),l=h.closest('.cmb-repeatable-grouping').getAttribute('data-iterator');f=`${k}[${l}][${f}]`}a("[name='" + f + "']").each(function(k,l){'select-one'===l.type?(!e(l.value)&&a(h).hide(),a(l).on('change',function(m){e(m.target.value)?a(h).show():a(h).hide()})):'radio'===l.type?(!e(l.value)&&l.checked&&a(h).hide(),a(l).on('change',function(m){e(m.target.value)?a(h).show():a(h).hide()})):'checkbox'===l.type&&(!l.checked&&a(h).hide(),a(l).on('change',function(m){m.target.checked?a(h).show():a(h).hide()}))})})} a( document ).ready( function(){b()}),a('.cmb2-wrap > .cmb2-metabox').on('cmb2_add_row',function(){b()})})(jQuery);