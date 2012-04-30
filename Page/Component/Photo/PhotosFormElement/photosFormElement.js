nb.component('nb_page_photo_form_element', function () {
  var $this = $(this);
  var that = this;
  var selectedPhotos = $.parseJSON($this.find('.data').text());
  var limit = $this.find('.data').data('limit');

  if (!limit) {
    limit = 0;
  }
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
        onOpen:modalWindow.onWindowOpen
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

  var viewModel = new Object();

  viewModel.selectedPhotos = ko.observableArray(selectedPhotos);

  viewModel.showAddButton = ko.dependentObservable(function () {
    if (limit == 0) {
      return true;
    }
    return limit > viewModel.selectedPhotos().length;
  });

  viewModel.removePhoto = function (me, event) {
    event.preventDefault();
    var indexOf = viewModel.selectedPhotos.indexOf(me);
    if (indexOf >= 0) {
      viewModel.selectedPhotos.splice(indexOf, 1);
    }
  };

  viewModel.addPhoto = function (id) {
    viewModel.selectedPhotos.push(id);
  };

  viewModel.openModalWindow = function (me, event) {
    event.preventDefault();
    modalWindow.open();
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