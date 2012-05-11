nb.component('nb_page_paragraph_manage_many', function() {
  var $this = $(this);

  $this.delegate('.remove', 'click', function(event) {
    if(event.isDefaultPrevented()) {
      return false;
    }
    event.preventDefault();

    var $link = $(this);
    console.log($link);

    $.ajax({
      url: $link.attr('href'),
      success: function(response) {
        $link.closest('tr').fadeOut(function() {
          $(this).remove();
        });
      }
    });

    return false;
  });
});