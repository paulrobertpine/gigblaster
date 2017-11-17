jQuery(document).ready(function($) {

  $('.gig-description-button').click(function() {
      // alert("The thingy was clicked.");
      $('.gig-description-text').slideToggle();
      $('.gig-description-button').toggleClass('active');
  });
});
