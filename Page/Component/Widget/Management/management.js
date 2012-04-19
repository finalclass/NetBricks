nb.component('nb_page_widget_management', function () {
  var that = this;
  var $this = $(this);
  var $addButton = $this.find('.add_widget');
  var $container = $this.find('.widget_container');

  function init() {
    $addButton.click(prevent(addWidget));
    $this.trigger('initialized');
  }

  $container.on('widget_set', function(event, data) {
    var widgetSelector = $(event.target).closest('.widget_selector');
    console.log(widgetSelector);
    console.log(arguments);
  });

  function prevent(callback) {
    return function (event) {
      event.preventDefault();
      callback.call(that);
    }
  }

  function addWidget() {
    nb.loader('/NetBricks/Page/Component/Widget', function(component) {
      var $widget = $(component).nb_page_widget();
      var $div = $("<div/>");
      $container.append($widget);
    });
  }

  init();
  return this;
});