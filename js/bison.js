/**
 * For non-drupal installations the counterpart of this file is
 * https://idfg.idaho.gov/sites/all/themes/bison/js/login-menu.js
 */
(function ($) {
  Drupal.behaviors.bison = {
    attach: function (context, settings) {
      getUser();
    }
  }
  // Loads the current user from IDFG API endpoint.
  function getUser() {
    // API request for the current user.
    $.ajax({
      cache: false
      , crossDomain: true
      , dataType: 'jsonp'
      , success: function (data, requestStatus) {
        if (requestStatus === 'success') {
          if (data.user) {
            updateLoginText(data.user);
          } else {
            $('.accounts-login-link a').each(function()
              {
                this.href = this.href.replace(/\/accounts/, '/accounts/user/login');
              });
            updateLoginText("Login");
          }
        }
      }
      , type: 'GET'
      , url: Drupal.settings.basePath + 'user/state'
    });
  }
  // Convenience function which animates the login text field to a new value,
  // if not already set to that value.
  function updateLoginText(newText) {
    var loginElements = $('.accounts-login-link');
    for (var i = 0; i < loginElements.length; i++) {
      if (loginElements[i].textContent.indexOf(newText) < 0) {
        $(loginElements[i]).fadeOut(400, function () {
          $(this).find('a .link-text').text(newText);
          $(this).fadeIn(400);
        });
      }
    }
  }
})(jQuery);
