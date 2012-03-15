$(function () {

  $('.nb_i18n_language_bar').each(function () {
    var that = this;
    var $this = $(this);
    var api = new Object();
    var $cb = $this.find('.nb_extended_combo_box');

    var $next = $this.find('.next_button');
    var $prev = $this.find('.prev_button');
    var selectedLanguage;

    function init() {
      $this.data('nb_i18n_language_bar', api);
      $next.click(api.nextLanguage);
      $prev.click(api.prevLanguage);
      $this.trigger('initialized');
    }

    function getCbApi() {
      return $cb.data('nb_extended_combo_box');
    }

    $cb.bind('change', function (event) {
      //event.stopPropagation();
      selectedLanguage = getCbApi().getSelectedItem().find('.one_language').data('language');
      //$this.trigger('change');
    });

    api.nextLanguage = function () {
      var cbApi = getCbApi();
      var totalItems = cbApi.getTotalItems();
      var current = cbApi.getSelectedIndex();
      current = (current + 1) % totalItems;
      cbApi.setSelectedIndex(current);
    };

    api.prevLanguage = function () {
      var cbApi = getCbApi();
      var totalItems = cbApi.getTotalItems();
      var current = cbApi.getSelectedIndex();
      current = (current - 1) % totalItems;
      cbApi.setSelectedIndex(current);
    };

    api.getSelectedLanguage = function () {
      return selectedLanguage;
    };

    api.setSelectedLanguage = function (value) {
      var item = $cb.find('[data-language=' + value + ']').closest('li');
      getCbApi().setSelectedItem(item);
    };

    init();
  });


});