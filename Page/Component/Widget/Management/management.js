$.Component('nb_page_widget_management', function () {
  var that = this;
  var $this = $(this);
  var $addButton = $this.find('.add_widget');
  var $container = $this.find('.widget_container');

  function init() {
    $addButton.click(prevent(addWidget));
    $this.trigger('initialized');
  }

  function prevent(callback) {
    return function (event) {
      event.preventDefault();
      callback.call(that);
    }
  }

  function addWidget() {
    $.get('/component=/NetBricks/Page/Component/Widget', function (data) {
      var $widget = $(data).nb_page_widget();
      $container.append($widget);
    });
  }

  init();
  return this;
});