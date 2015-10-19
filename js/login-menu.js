/**
 * Loads dynamic login and menu information.  For a live example of
 * this in use visit http://fishandgame.idaho.gov/ifwis/style.
 */
$(document).ready(function () {
  getMainMenu();
  updateLoginLinks();
  getUser();
});

// Loads the main menu from IDFG API endpoint
function getMainMenu() {
  // API request for the menu
  $.ajax({
    cache: false
    , crossDomain: true
    , dataType: 'jsonp'
    , jsonpCallback: 'jQuery11120031282627722248435_1439335233466'
    , success: function (data, requestStatus) {
      if (requestStatus === 'success') {
        $('#block-idfg-components-menu').replaceWith(data);
        getUser();
        updateLoginLinks();
      }
    }
    , type: 'GET'
    , url: 'https://fishandgame.idaho.gov/ifwis/rest/services/web/site/menu/1.jsonp'
  });
}

// add a return URL to the login URL if not present for post-login redirect
function updateLoginLinks() {
  var loginElements = $('.accounts-login-link a');
  for (var i = 0; i < loginElements.length; i++) {
    if ($(loginElements[i]).attr('href').indexOf('?returnurl=') < 0) {
      $(loginElements[i]).attr('href', $(loginElements[i]).attr('href') + '?returnurl=' + window.location.href);
    }
  }
}

// Loads the current user from IDFG API endpoint
function getUser() {
  // API request for the current user
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

// Convenience function which animates the login text field to a new value, if not already set to that value
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
