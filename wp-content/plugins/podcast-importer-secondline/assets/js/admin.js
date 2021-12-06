(function () {
  const editButtons = document.querySelectorAll(".button-link-edit");

  Array.from(editButtons).forEach((button) => {
    button.addEventListener("click", (event) => {
      event.preventDefault();

      const importID = button.getAttribute("data-import-id");
      const importForm = document.getElementById(
        `edit-import-form--${importID}`
      );

      if (importForm.classList.contains("expanded")) {
        importForm.classList.remove("expanded");
      } else {
        editButtons.forEach((button) => button.classList.remove("expanded"));

        importForm.classList.add("expanded");
      }
    });
  });
}())

jQuery(document).ready(function($) {
	'use strict';
  $( ".settings-wrapper" ).each(function() {
    var $heading = $( this ).find("h3");
    var $wrapper = $( this );
    $heading.click(function() {
      $wrapper.toggleClass("expanded")
    });
  });
})

