/*jQuery('body').prepend('<div id="page-preloader"><div id="pp-wrapper"><div id="pp-image"><div class="spinner rotateY"><img src="https://www.thystaworld.hu/wp-content/uploads/2019/03/preloader-white.png" alt="Preloader image"></div></div></div></div>');*/

jQuery(window).on('load', function() {

    jQuery("#pp-image").fadeOut();
    jQuery("#page-preloader").delay(500).fadeOut(200);

});