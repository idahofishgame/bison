(function($) {
  /**
  *	 Redirect active traffic to a notification of online sales halt.
  */
  $(document).ready(function() {
    var s = "id.outdoorcentral.us";
    var r = "https://idfg.idaho.gov/press/online-sales-suspended";
    $("a").each(function() {
      var h = $(this).attr('href');
      if (h !== undefined && h.indexOf(s) !== -1) {
        $(this).attr("href", r);
      }
    });
  });
})(jQuery);
