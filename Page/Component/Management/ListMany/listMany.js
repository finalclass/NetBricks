nb.component('nb_page_list_many', function() {

  var $this = $(this);
  var $loader = $('.ajax_loader');
  $this.delegate('a.delete', 'click', function(event) {
    console.log('test');
    if(event.isDefaultPrevented()) {
      return false;
    }
    var $a = $(this);
    $loader.fadeIn();
    $.ajax({
      url: $a.attr('href'),
      success: function(response) {
        $loader.fadeOut();
        $a.parents('tr').fadeOut(function() {
          $(this).remove();
        });
      }
    });
    return false;
  });

});