$(function() {

  $('.nb_page_widget_management').each(function() {
    var that = this;
    var $this = $(this);
    var api = new Object();
    var $addButton = $this.find('.add_widget');
    var $container = $this.find('.widget_container');

    function init() {
      $this.data('nb_page_widget_management', api);
      $addButton.click(prevent(addWidget));
      $this.trigger('initialized');
    }

    function prevent(callback) {
      return function(event) {
        event.preventDefault();
        callback.call(that);
      }
    }

    function addWidget() {
      $.get('/component=/NetBricks/Page/Component/Widget', function(data) {
        var $widget = $(data).nb_page_widget();
        $container.append($widget);
      });
    }

    init();
  });


});