$(function () {
  $('.nb_extended_combo_box').each(function () {
    var that = this;
    var $that = $(this);
    var $ddl = $that.find('.nb_extended_combo_box_ddl');
    var isOpen = false;
    var $selected;
    var api = new Object();

    $that.data('nb_extended_combo_box', api);

    function init() {
      api.setSelectedIndex(0);
    }

    api.setSelectedItem = function($item) {
      $item = $($item); //make sure we got jQuery element
      api.setSelectedIndex($item.index());
      return that;
    };

    api.getFirstItem = function() {
      return $ddl.find('li.combo_item:first');
    };

    api.getTotalItems = function() {
      return $ddl.find('li.combo_item').length;
    };

    api.getSelectedItem = function() {
      return $ddl.find('li.combo_item:nth-child(' + (api.getSelectedIndex() + 1).toString() + ')');
    };

    api.setSelectedIndex = function (index) {
      $that.trigger('before_change', index);

      $that.find('li.combo_item').removeClass('selected');
      $selected = $ddl.find('li.combo_item').eq(index);
      $selected.addClass('selected');
      $that.find('li.combo_item').not($selected).slideUp(function () {
            $selected.slideDown();
        });
      $that.trigger('change', index);
    };

    api.getSelectedIndex = function () {
      return $selected.index();
    };

    api.open = function () {
      $('body').not($that).bind('click', onBodyClick);
      $ddl.find('li.combo_item').bind('click', onElementMouseSelect);
      $ddl.addClass('absolute');
      $ddl.find('li.combo_item').slideDown();
      isOpen = true;
    };

    api.close = function () {
      $('body').not($that).unbind('click', onBodyClick);
      $ddl.find('li.combo_item').unbind('click', onElementMouseSelect);
      $ddl.removeClass('absolute');
      $ddl.find('li.combo_item').not($selected).slideUp();
      isOpen = false;
    };

    api.getIsOpen = function () {
      return isOpen;
    };

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

    init();

  });
});