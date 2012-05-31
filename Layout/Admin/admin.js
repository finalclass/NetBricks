nb.component('nb_layout_admin', function () {
  var $this = $(this);
  var that = this;
  var data = $.parseJSON($this.find('.nb_layout_admin_data').text());
  var $ajaxLoaderImage = $this.find('.ajax_loader');

  function getBaseURL() {
    return location.protocol + "//" + location.hostname +
      (location.port && ":" + location.port) + "/";
  }

  function initMenuHover() {
    $('.nb_layout_admin .menu li a').hover(
      function () {
        $(this).clearQueue().animate({'padding-left':25});
      },
      function () {
        $(this).animate({'padding-left':15});
      });
  }

  function animatePageShow() {
    $('.nb_layout_admin .top').animate({'margin-top':0});
    $('.nb_layout_admin .middle .menu').animate({'margin-left':0});
    $('.nb_layout_admin  .middle .content').animate({'opacity':1});
    $('.nb_layout_admin .footer').animate({'height':36});
    $('.nb_layout_admin  .middle .content').animate({'left':0}, data.animationSpeed);
  }

  function initAjaxContentLoading() {

    $(window).bind('hashchange', function () {
      var params = $.bbq.getState();
      var $destination = $(params.destination);
      $ajaxLoaderImage.fadeIn();
      $destination.css('position', 'relative').animate({'left':2000}, data.animationSpeed);
      nb.loader(params.component + '&' + objectToUrlParams(params),
        animateContentTransition($destination), function() {
          $ajaxLoaderImage.fadeOut();
        });
    });

    $('.nb_layout_admin').delegate('a', 'click', function (event) {
      var $a = $(this);
      var component = $a.data('component');
      var destination = $a.data('destination');
      var $destination = $(destination);
      if (!component || !destination || $destination.length == 0) {
        $ajaxLoaderImage.fadeIn();
        setTimeout(function() {
          $ajaxLoaderImage.fadeOut();
        }, 200);
        return true;
      } else {
        event.preventDefault();
      }

      var params = $a.data('params') || new Object();

      for (var i in params) {
        if (params.hasOwnProperty(i)) {
          data.params[i] = params[i];
        }
      }

      data.params.component = component;
      data.params.destination = destination;

      $.bbq.pushState(data.params);

      //window.location.hash = objectToUrlParams(data.params);
    });

    function animateContentTransition($destination) {

      return function (html, done) {
        $ajaxLoaderImage.fadeOut();
        $destination.html(html);
        $destination.animate({'left':0}, data.animationSpeed,
          function () {
            done($destination);
            changeUrls($destination);
          });
      }
    }

    function objectToUrlParams(obj) {
      var paramsPairs = new Array();
      for (var key in obj) {
        if (obj.hasOwnProperty(key)) {
          paramsPairs.push(key + '=' + obj[key]);
        }
      }

      return paramsPairs.join('&');
    }

    function changeUrls($destination) {
      //Add current params to each a.href
      $destination.find('a').each(function () {
        var $a = $(this);
        var aParams = $a.data('params') || new Object();

        var paramsPairs = new Array();

        for (var i in data.params) {
          if (data.params.hasOwnProperty(i) && aParams[i] == undefined) {
            aParams[i] = data.params[i];
            if(aParams[i].length == 0) {
              delete aParams[i];
            }
          }
        }

        delete aParams['component'];
        delete aParams['destination'];

        $a.attr('href', getBaseURL() + '?' + objectToUrlParams(aParams));
      });

      var state = $.bbq.getState();
      delete state['component'];
      delete state['destination'];

      //Add current params to empty form.action
      $('.nb_layout_admin .content').find('form').each(function () {
        var $form = $(this);
        if ($.trim($form.attr('action')).length == 0) {
          $form.attr('action', getBaseURL() + '?' + objectToUrlParams(state));
        }
      });
    }

    var state = $.bbq.getState();
    for(var i in state) {
      if(state.hasOwnProperty(i)) {
        data.params[i] = state[i];
      }
    }

    $.bbq.pushState(data.params);
    $(window).trigger('hashchange');
  }

  return {
    init:function () {
      initAjaxContentLoading();
      initMenuHover();
      animatePageShow();
    }
  };

});