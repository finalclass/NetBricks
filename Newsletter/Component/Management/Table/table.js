nb.component('nb_newsletter_management_table', function() {

  var $this = $(this);

  $this.delegate('.remove', 'click', function(event) {
    var $a = $(this);
    if(event.isDefaultPrevented()) {
      return false;
    }
    event.preventDefault();

    $.ajax({
      url: $a.attr('href'),
      success: function(response) {
        var $row = $a.parents('tr');
        $row.fadeOut(function() {
          $row.remove();
        });
      }
    });

  });

});