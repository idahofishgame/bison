/**
 * For non-drupal installations the counterpart of this file is found at
 * https://idfg.idaho.gov/sites/all/themes/bison/js/login-menu.js
 * Use this file to load both dynamic login and menu information.
 * For a live example of this script visit
 * http://fishandgame.idaho.gov/ifwis/style.
 */
(function ($) {
  Drupal.behaviors.bison = {
    attach: function (context, settings) {
      updateLoginLinks();
      getUser();
    }
  }

  // Add a return URL to the login URL if not present for post-login redirect.
  function updateLoginLinks() {
    var loginElements = $('.accounts-login-link a');
    for (var i = 0; i < loginElements.length; i++) {
      if ($(loginElements[i]).attr('href').toLowerCase().indexOf('returnurl=') == -1) {
        $(loginElements[i]).attr('href', $(loginElements[i]).attr('href') + '?returnurl=' + window.location.href);
      }
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
            updateLoginText("Login");
          }
        }
      }
      , type: 'GET'
      , url: 'https://idfg.idaho.gov/accounts/user/state'
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