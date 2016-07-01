/**
 * For non-drupal installations the counterpart of this file is
 * https://idfg.idaho.gov/sites/all/themes/bison/js/login-menu.js
 */
(function ($) {
  Drupal.behaviors.bison = {
    attach: function (context, settings) {
      $("#context-menu-dropdown").click( function() {
        $("#context-menu-dropdown .glyphicon").toggleClass("glyphicon-chevron-down glyphicon-chevron-up");
      });
    }
  }
})(jQuery);