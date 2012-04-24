nb.component('nb_page_photo_selector', function() {
  var $this = $(this);
  var that = this;
  var $iframe = $this.find('iframe');
  var api = new Object();

  function onPhotoSelect(event, args) {
    console.log('onPhotoSelect');
    console.log(arguments);
  }

  function selectPhoto(id) {
    api.onPhotoSelected(id);
  }

  function onGalleryItemClick(event, args) {
    var id = $(event.currentTarget).data('id');
    selectPhoto(id);
  }

  function onIframeLoad() {
    var id = $iframe.contents().find('#nb_page_photo_id').text();
    if(!id) {
      return;
    }
    selectPhoto(id);
  }

  api.init = function() {
    $iframe.load(onIframeLoad);
    $this.delegate('img', 'click', onGalleryItemClick);
  };

  api.onPhotoSelected = function(id) {};

  return api;
});