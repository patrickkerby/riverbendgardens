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

      //Open modal con url
      var url      	= window.location.href;
      var modal_code 	= getParameterByName('modal',url);

      if(window.location.href.indexOf('?modal='+modal_code) != -1) {
          $('#pickupModal-'+modal_code).modal('show');
          /*Like a query string
        http://www.website.com/page.html?modal=1
        http://www.website.com/page.html?modal=2
        ...
          */
        }

      }); 

      function getParameterByName(name, url) { //Obtiene un value de un query string
        if (!url) url = window.location.href;
        name = name.replace(/[[]]/g, '\\$&');
        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ''));
      }
    },
  };

$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});

