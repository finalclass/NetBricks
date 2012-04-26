(function () {

  $(function () {
    nb.initializeComponents('body');
  });

  window.nb = {

    loadedScripts:new Array(),

    isCssJQueryUi:function (href) {
      var fileName = href.split('/').slice(-1)[0]; //get last element in the array with slice(-1)
      return fileName == 'jquery-ui.css';
    },

    isJQueryUiCssLoaded:function () {
      var isLoaded = false;
      $('head').find('link').each(function () {
        var $link = $(this);
        if (nb.isCssJQueryUi($link.attr('href'))) {
          isLoaded = true;
        }
      });
      return isLoaded;
    },

    initLoadedScripts:function () {
      $('script').each(function () {
        var $script = $(this);
        var scriptSrc = $script.attr('src');
        scriptSrc = nb.removeAfterQuestionMark(scriptSrc);
        nb.loadedScripts.push(scriptSrc);
      });
    },

    removeAfterQuestionMark:function (string) {
      var questionMarkPos = string.indexOf('?');
      if (questionMarkPos != -1) {
        string = string.slice(0, questionMarkPos);
      }
      return string;
    },

    addScriptFiles:function (scripts) {
      var $head = $('head');
      var i = 0;

      if(nb.loadedScripts.length == 0) {
        nb.initLoadedScripts();
      }

      for (i in scripts) {
        if (scripts.hasOwnProperty(i)) {
          scripts[i] = nb.removeAfterQuestionMark(scripts[i]);
        }
      }

      $(nb.loadedScripts).each(function () {
        var scriptSrc = this.toString();
        var pos = scripts.indexOf(scriptSrc);
        if (pos != -1) {
          scripts.splice(pos, 1);
        }
      });

      for (i in scripts) {
        if (scripts.hasOwnProperty(i)) {
          $head.append(
            $('<script type="text/javascript" src="' + scripts[i] + '"></script>')
          );
          nb.loadedScripts.push(scripts[i]);
        }
      }
    },

    addStyleFiles:function (links) {
      var $head = $('head');
      var isUiLoaded = nb.isJQueryUiCssLoaded();

      $('link').each(function () {
        var $link = $(this);
        var href = $link.attr('href');
        var pos = links.indexOf(href);
        if (pos != -1) {
          links.splice(pos, 1);
        }
      });

      for (var i in links) {
        if (links.hasOwnProperty(i) && !(isUiLoaded && nb.isCssJQueryUi(links[i]))) {
          $head.append(
            $('<link rel="stylesheet" href="' + links[i] + '"/>')
          );
        }
      }
    },

    /**
     * @param {String} component String The component name
     * @param {Function} [beforeScriptsLoaded] Function(html) optional
     */
    loader:function (component, beforeScriptsLoaded) {
      component = component.replace(new RegExp(/\\/g), '/');

      return $.getJSON('/-component/?component_name=' + component,
        function (response) {
          nb.addStyleFiles(response.styles);
          var wasNextCalled = false;

          function done(selector) {
            selector = selector || 'body';
            if (!wasNextCalled) {
              wasNextCalled = true;
              nb.addScriptFiles(response.scripts);
              nb.initializeComponents(selector);
            }
          }

          if (beforeScriptsLoaded) {
            beforeScriptsLoaded(response.html, done);
          } else {
            nb.addScriptFiles(response.scripts);
          }

        });
    },

    availableComponents:new Array(),

    /**
     *
     * @param name
     * @param definition
     */
    component:function (name, definition) {
      nb.availableComponents.push(name);
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
    },

    initializeComponents:function (selector) {
      var $root = $(selector).parent();
      for (var i in nb.availableComponents) {
        if (nb.availableComponents.hasOwnProperty(i)) {
          var component = nb.availableComponents[i];
          $root.find('.' + component).each(function () {
            var $element = $(this);
            if (!$element.data(component)) {
              $element[component]();
            }
          });
        }
      }
    }

  };
})();

