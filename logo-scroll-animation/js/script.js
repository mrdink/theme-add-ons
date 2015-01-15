(function($) {

  $(window).on("scroll touchmove", function () {
    $('.site-logo').toggleClass('on-scroll', $(document).scrollTop() > 0);
  });

})(jQuery);
