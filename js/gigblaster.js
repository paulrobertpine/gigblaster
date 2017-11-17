jQuery(document).ready(function($) {

  $('.gig-description-button').click(function() {
      $('.gig-description-text').slideToggle();
      $('.gig-description-button').toggleClass('active');
  });
});
