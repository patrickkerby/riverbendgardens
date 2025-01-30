import 'custom-event-polyfill';

export default {
  init() {
    // JavaScript to be fired on all pages
    $('.hamb').click(function() {
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

      $(document).on('click', 'li.product a.add_to_cart_button', function() {
        $('body').addClass('quickview-open');
      });
      $(document).on('click', '.openModal', function() {
        $('body').addClass('quickview-open');
      });
      // remove class from body when close button is clicked  
      $(document).on('click', '.close-product', function(e) {
        if (!$(e.target).is('.quickview'))
          $('.quickview-open').removeClass('quickview-open');
      });
      $(document).on('click', '.close', function(e) {
        if (!$(e.target).is('.quickview'))
          $('.quickview-open').removeClass('quickview-open');
      });
      // remove class from body when you click on the overlay
      $(document).on('click', '.pp_overlay', function(e) {
        if (!$(e.target).is('.quickview-open'))
          $('.quickview-open').removeClass('quickview-open');
      });        
      // remove class from body when you hit escape
      $(document).bind('keyup', function(e){ 
        if(e.which == 27){
          if (!$(e.target).is('.quickview-open'))
          $('.quickview-open').removeClass('quickview-open');
         }
      });
      // close the modal when you click on our new button  
      $('.close-product').on('click',function() { $.prettyPhoto.close(); });

      $('.modal').each(function () {
        const modalId = `#${$(this).attr('id')}`;
        if (window.location.href.indexOf(modalId) !== -1) {
            $(modalId).modal('show');
        }
      });

      // remove class from body when close button is clicked  
      $(document).on('click', '.close-product', function(e) {
        if (!$(e.target).is('.quickview')) {
          $('.quickview-open').removeClass('quickview-open'); 
        }
      });
      $(document).on('click', '.close', function(e) {
        if (!$(e.target).is('.quickview')) {
          $('.quickview-open').removeClass('quickview-open'); 
        }
      });

      setTimeout(function() {
        $('.woocommerce-message').fadeOut('fast');
      }, 5000);
    },

      
  };

$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});

