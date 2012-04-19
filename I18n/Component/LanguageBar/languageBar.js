nb.component('nb_i18n_language_bar', function () {
  var that = this;
  var $this = $(this);
  var api;
  var $cb = $this.find('.nb_extended_combo_box');

  var $next = $this.find('.next_button');
  var $prev = $this.find('.prev_button');
  var selectedLanguage;

  function getCbApi() {
    return $cb.data('nb_extended_combo_box');
  }

  $cb.bind('change', function (event) {
    selectedLanguage = getCbApi().getSelectedItem().find('.one_language').data('language');
  });

  api = {

    /**
     *
     */
    init:function () {
      $next.click(api.nextLanguage);
      $prev.click(api.prevLanguage);
      $this.trigger('initialized');
    },

    /**
     *
     */
    nextLanguage:function () {
      var cbApi = getCbApi();
      var totalItems = cbApi.getTotalItems();
      var current = cbApi.getSelectedIndex();
      current = (current + 1) % totalItems;
      cbApi.setSelectedIndex(current);
    },

    /**
     *
     */
    prevLanguage:function () {
      var cbApi = getCbApi();
      var totalItems = cbApi.getTotalItems();
      var current = cbApi.getSelectedIndex();
      current = (current - 1) % totalItems;
      cbApi.setSelectedIndex(current);
    },

    /**
     *
     */
    getSelectedLanguage:function () {
      return selectedLanguage;
    },

    /**
     *
     * @param value
     */
    setSelectedLanguage:function (value) {
      var item = $cb.find('[data-language=' + value + ']').closest('li');
      getCbApi().setSelectedItem(item);
    }

  };

  return api;
});
