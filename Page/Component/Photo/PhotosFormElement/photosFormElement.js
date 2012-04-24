nb.component('nb_page_photo_form_element', function () {
  var $this = $(this);
  var that = this;
  var api = new Object();
  var selectedPhotos = $.parseJSON($this.find('.data.selected_photos').text());
  if(!selectedPhotos) {
    selectedPhotos = new Array();
  }

  var ViewModel = function (selectedPhotos) {
    var that = this;
    this.selectedPhotos = ko.observableArray(selectedPhotos);

    this.removePhoto = function (me, event) {
      event.preventDefault();
      var indexOf = this.selectedPhotos.indexOf(me);
      if (indexOf >= 0) {
        this.selectedPhotos.splice(indexOf, 1);
      }
    }.bind(this);

    this.addPhoto = function(id) {
      this.selectedPhotos.push(id);
    }.bind(this);

    this.openModalWindow = function (me, event) {
      event.preventDefault();
      $.window({
        title:"Select photo",
        onOpen:function (wnd) {
          nb.loader(
            '/NetBricks/Page/Component/Photo/PhotoSelector',
            function (html) {
              wnd.setContent(html);
            },
            function (html) {
              var selector = wnd.getContainer().find('.nb_page_photo_selector');
              var api = selector.data('nb_page_photo_selector');
              api.onPhotoSelected = function(id) {
                that.addPhoto(id);
                wnd.close();
              }
            });
        },
        onShow:function (wnd) {

        }
      });
    }.bind(this);

  };

  api.init = function () {
    ko.applyBindings(new ViewModel(selectedPhotos), that);
  };

  return api;
});