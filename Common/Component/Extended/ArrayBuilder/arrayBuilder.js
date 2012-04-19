nb.component('nb_extended_array_builder', function () {
  var that = this;
  var $this = $(this);
  var formElemetnName = $this.data('name');
  var $container = $this.find('.array_builder_list');
  var api;

  api = {

    buildItem: function(item) {
      var $hidden = $('<input type="hidden" name="' + formElemetnName + '[]" value="' + item + '"/>');
      var $text = $('<span/>').text(item);
      var $li = $('<li/>');
      return $li.append($hidden).append($text);
    },

    addItem: function(item) {
      var $item = api.buildItem(item);
      $container.append($item);
    }

  };

  return api;
});