nb.component('nb_page_photo_form_element', function () {
  var $this = $(this);
  var that = this;
  var selectedPhotos = $.parseJSON($this.find('.data.selected_photos').text());
  if (!selectedPhotos) {
    selectedPhotos = new Array();
  }

  /****************************************************************************
   * modalWindow
   *
   * @type {Object}
   */
  var modalWindow = {

    wnd:null,

    open:function () {
      $.window({
        title:"Select photo",
        width:600,
        height:500,
        onOpen: modalWindow.onWindowOpen
      });
    },

    onWindowOpen:function (wnd) {
      modalWindow.wnd = wnd;
      nb.loader('/NetBricks/Page/Component/Photo/PhotoSelector',
        modalWindow.onComponentLoaded);
    },

    onComponentLoaded:function (html, done) {
      modalWindow.wnd.setContent(html);
      var $container = modalWindow.wnd.getContainer();

      done($container);

      var selector = $container.find('.nb_page_photo_selector');
      var api = selector.data('nb_page_photo_selector');
      api.onPhotoSelected = modalWindow.onPhotoSelected;
    },

    onPhotoSelected:function (id) {
      viewModel.addPhoto(id);
      modalWindow.wnd.close();
    }

  };

  /****************************************************************************
   * viewModel
   *
   * @type {Object}
   */
  var viewModel = {

    selectedPhotos: ko.observableArray(selectedPhotos),

    removePhoto: function (me, event) {
      event.preventDefault();
      var indexOf = viewModel.selectedPhotos.indexOf(me);
      if (indexOf >= 0) {
        viewModel.selectedPhotos.splice(indexOf, 1);
      }
    },

    addPhoto: function (id) {
      viewModel.selectedPhotos.push(id);
    },

    openModalWindow: function (me, event) {
      event.preventDefault();
      modalWindow.open();
    }

  };

  /****************************************************************************
   * API
   */
  return {
    init:function () {
      ko.applyBindings(viewModel, that);
    }
  };

});