jQuery(document).ready(function($) {

  $('.gig-description-button').click(function() {
      $(this).next().slideToggle();
      $(this).toggleClass('active');
  });
});
