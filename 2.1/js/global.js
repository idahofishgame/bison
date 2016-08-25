(function($) {
  /*
  	This javascript patch is to redirect active traffic to a notification
    of online sales being halted due to concerns over security.
  */
  $(document).ready(function() {

    var search_url = "id.outdoorcentral.us";
    var replace_url = "https://idfg.idaho.gov/press/online-sales-suspended";

    $("a").each(function() {
      var href = $(this).attr('href');
      if (href.indexOf(search_url) !== -1) {
        $(this).attr("href", replace_url);
      }
    });
  });
})(jQuery);
