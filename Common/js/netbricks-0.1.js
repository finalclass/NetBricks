(function () {
  window.nb = {

    addScriptFiles:function (scripts) {
      var $head = $('head');
      $('script').each(function () {
        var $script = $(this);
        var pos = scripts.indexOf($script.attr('src'));
        if (pos != -1) {
          scripts.splice(pos, 1);
        }
      });

      for (var i in scripts) {
        if (scripts.hasOwnProperty(i)) {
          $head.append(
            $('<script type="text/javascript" src="' + scripts[i] + '"></script>')
          );
        }
      }
    },

    addStyleFiles:function (links) {
      var $head = $('head');
      $('link').each(function () {
        var $link = $(this);
        var pos = links.indexOf($link.attr('href'));
        if (pos != -1) {
          links.splice(pos, 1);
        }
      });

      for (var i in links) {
        if (links.hasOwnProperty(i)) {
          $head.append(
            $('<link rel="stylesheet" href="' + links[i] + '"/>')
          );
        }
      }
    },

    /**
     * @param component String The component name
     * @param beforeScriptsLoaded Function(html) optional
     * @param afterScriptsLoaded Function(html) optional
     */
    loader:function (component, beforeScriptsLoaded, afterScriptsLoaded) {
      component = component.replace(new RegExp(/\\/g), '/');
      return $.getJSON('-component/' + component, function (response) {
        nb.addStyleFiles(response.styles);
        if (beforeScriptsLoaded) {
          beforeScriptsLoaded(response.html);
        }
        nb.addScriptFiles(response.scripts);
        if (afterScriptsLoaded) {
          afterScriptsLoaded(response.html);
        }
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

