jQuery(document).ready(function ($) {
  $('.accounts-login-link a').attr('href', $('#navbar-login a').attr('href') + '?returnurl=' + window.location.href);
  $.getJSON('https://idfg.idaho.gov/accounts/user/state?callback=?', null, function(data) {
    if (data.user !== null) {
      $('.accounts-login-link a .link-text').text(data.user);
    } else {
      $('.accounts-login-link a .link-text').text("Login");
    }
  });
});