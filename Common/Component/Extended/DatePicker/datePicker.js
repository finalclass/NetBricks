nb.component('nb_extended_date_picker', function() {
  var $this = $(this);
  var that = this;
  var $textInput = $this.find('input[type="text"]');
  var $hidden = $this.find('input[type="hidden"]');

  return {
    init: function() {
      $textInput.datepicker({
        'dateFormat': "yy-mm-dd",
        'altField': $hidden,
        'altFormat': '@'
      });
    }
  }
});