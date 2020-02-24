import 'custom-event-polyfill';

export default {
  init() {
    // JavaScript to be fired on all pages
    $('.hamburger').click(function() {
      $(this).toggleClass('is-active');
      $('.nav-mobile').toggleClass('is-active');
      $('body').toggleClass('is-active');
    });

  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
    $(document).ready(function(){
      $('.gallery').slickLightbox({
        itemSelector: '> div > a',
      });
    });
  },
};

$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});

