var Nb_Extended_ArrayBuilderViewModel = function() {

  fc(this, 'text').bindable();
  this.text = '';

};

nb.component('nb_extended_array_builder', function () {
  var that = this;
  var $this = $(this);
  var formElemetnName = $this.data('name');
  var $list = $this.find('.array_builder_list');
  var $textInput = $this.find('.array_builder_text');
  var $submit = $this.find('.array_builder_add_button');
  var api;

  function buildItem(item) {
    var $hidden = $('<input type="hidden" name="' + formElemetnName + '[]" value="' + item + '"/>');
    var $text = $('<span/>').text(item);
    var $li = $('<li/>');
    return $li.append($hidden).append($text);
  }

  api = {

    addItem:function (item) {
      var $item = buildItem(item);
      $list.append($item);
    }
  };

  $this.model();

  return api;
});