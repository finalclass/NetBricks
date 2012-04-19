nb.component('nb_page_photo_selector', function () {
  var $this = $(this);
  var $combo = $this.find('.nb_extended_combo_box');

  $this.delegate('*', 'combo_change', function () {
    var $selected = $combo.data('nb_extended_combo_box').getSelectedItem();
    var id = $selected.find('img').data('id');
    $this.trigger('widget_set', {photo_document_id:id});
  });
});