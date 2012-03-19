$.Component('nb_page_widget', function () {
    var that = this;
    var $this = $(this);

    function init() {
      $this.find('.widget_type').bind('click', onWidgetClick);
    }

    function destruct() {
      $this.find('.widget_type').unbind('click', onWidgetClick);
    }

    function onWidgetClick(event) {
      var type = $(event.target).data('type');
      $.get('/component=' + type, function(data) {
        destruct();
        $this.html(data);
      });
      $this.empty();
    }

    init();
});