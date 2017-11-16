jQuery(document).ready(function($) {

  $('.gig-description-button').click(function() {
      // alert("The thingy was clicked.");
      $('.gig-description-text').slideToggle();
      $('.gig-description-button span')
        .toggleClass('dashicons-arrow-down-alt2')
        .toggleClass('dashicons-arrow-up-alt2');
  });
});
