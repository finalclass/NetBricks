nb.component('nb_page_photo_manage_many', function() {
  var $this = $(this);

  $this.delegate('.remove', 'click', function(event) {
    if(event.isDefaultPrevented()) {
      return false;
    }

    event.preventDefault();

    var $link = $(this);

    $.ajax({
      url: $link.attr('href'),
      success: function(response) {
        $link.closest('.nb_page_photo_management_photo_box').fadeOut(function() {
          $(this).remove();
        });
      }
    });

    return false;
  });

});