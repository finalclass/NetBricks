$.Component = function (name, definition) {
  if (!$.fn[name]) {
    $.fn[name] = function () {
      return this.each(function (options) {
        var $this = $(this);
        if (!$this.data(name)) {
          var api = definition.call(this, options);
          if (!api) {
            api = new Object();
          }
          $this.data(name, api);
          if (api.init) {
            api.init();
          }
        }
      });
    }
  }

  $(function () {
    $('.' + name)[name]();
  });

};