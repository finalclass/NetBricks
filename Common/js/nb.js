(function () {
  window.nb = {

    /**
     *
     * @param component
     * @param callback
     */
    loader:function (component, callback) {
      return $.getJSON('-component/' + component.replace('\\', '/'), function (response) {
        var newScripts = response.scripts;
        var newStyles = response.styles;

        $('script').each(function () {
          var $script = $(this);
          var pos = newScripts.indexOf($script.attr('src'));
          if (pos != -1) {
            newScripts.splice(pos, 1);
          }
        });
        $('link').each(function () {
          var $link = $(this);
          var pos = newStyles.indexOf($link.attr('href'));
          if (pos == -1) {
            newStyles.splice(pos, 1);
          }
        });
        callback(response.html);
      });
    },

    /**
     *
     * @param name
     * @param definition
     */
    component:function (name, definition) {
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
    }


  };
})();

