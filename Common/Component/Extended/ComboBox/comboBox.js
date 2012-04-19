nb.component('nb_extended_combo_box', function () {
  var that = this;
  var $that = $(this);
  var $ddl = $that.find('.nb_extended_combo_box_ddl');
  var isOpen = false;
  var $selected;
  var api;

  function onBodyClick(event) {
    var parents = $(event.target).parents();
    for (var i in parents) {
      if (parents.hasOwnProperty(i) && parents[i] == $that.get(0)) {
        return; //is child of $that
      }
    }
    api.close();
  }

  function onElementMouseSelect(event) {
    api.setSelectedItem(event.currentTarget);
  }

  $that.click(function () {
    if (api.getIsOpen()) {
      api.close();
    } else {
      api.open();
    }
  });

  api = {

    /**
     *
     */
    init:function () {
      api.setSelectedIndex(0);
    },

    /**
     *
     * @param $item
     */
    setSelectedItem:function ($item) {
      $item = $($item); //make sure we got jQuery element
      api.setSelectedIndex($item.index());
      return that;
    },

    /**
     *
     */
    getFirstItem:function () {
      return $ddl.find('li.combo_item:first');
    },

    /**
     *
     */
    getTotalItems:function () {
      return $ddl.find('li.combo_item').length;
    },

    /**
     *
     */
    getSelectedItem:function () {
      return $ddl.find('li.combo_item:nth-child(' + (api.getSelectedIndex() + 1).toString() + ')');
    },

    /**
     *
     * @param index
     */
    setSelectedIndex:function (index) {
      $that.trigger('before_change.nb_extended_combo_box', index);
      $that.trigger('before_combo_change.nb_extended_combo_box', index);

      $that.find('li.combo_item').removeClass('selected');
      $selected = $ddl.find('li.combo_item').eq(index);
      $selected.addClass('selected');
      $that.find('li.combo_item').not($selected).slideUp(function () {
        $selected.slideDown();
      });
      $that.trigger('change', index);
      $that.trigger('combo_change', index);
    },

    /**
     *
     */
    getSelectedIndex:function () {
      return $selected.index();
    },

    /**
     *
     */
    open:function () {
      $('body').not($that).bind('click', onBodyClick);
      $ddl.find('li.combo_item').bind('click', onElementMouseSelect);
      $ddl.addClass('absolute');
      $ddl.find('li.combo_item').slideDown();
      isOpen = true;
    },

    /**
     *
     */
    close:function () {
      $('body').not($that).unbind('click', onBodyClick);
      $ddl.find('li.combo_item').unbind('click', onElementMouseSelect);
      $ddl.removeClass('absolute');
      $ddl.find('li.combo_item').not($selected).slideUp();
      isOpen = false;
    },

    /**
     *
     */
    getIsOpen:function () {
      return isOpen;
    }

  };

  return api;
});
