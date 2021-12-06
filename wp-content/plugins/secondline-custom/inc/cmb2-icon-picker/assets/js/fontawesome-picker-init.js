
jQuery(document).ready(function($) {
  'use strict';
  $('.fontawesome-icon-select').iconpicker({
    hideOnSelect: true
  });
}); // End Ready



/**
 * Group fix, by Mordi Sacks
 */
jQuery(document).bind('DOMNodeInserted', function (event) {
    if (jQuery(event.target).find('div.cmb-type-fontawesome-icon').length > 0) {
        jQuery(event.target).find('.fontawesome-icon-select').iconpicker({
            hideOnSelect: true
        });
    }
});
