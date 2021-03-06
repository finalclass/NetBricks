var hash = window.location.hash.substr(1)
if(hash.length > 0) {
  window.location = hash;
}

nb.component('brick_autoloader', function () {

  $(this).delegate('a', 'click', function (event) {
    var $this = $(this);
    var component = $this.data('component');
    var destination = $this.data('destination');
    var params = $this.data('params');

    if (!component || !destination) {
      return true;
    }
    event.preventDefault();

    window.location.hash = $this.attr('href');

    $('body').css('cursor', 'wait');

    nb.loader(component, function (html, done) {
      $(destination).fadeOut('fast', function () {
        $('body').css('cursor', 'auto');
        $(destination).html(html).fadeIn('fast');
        done();
      });
    }, null, params);

    return false;
  });

  //$(this).find('a[href="' + window.location.hash.substr(1) + '"]').first().click();

});