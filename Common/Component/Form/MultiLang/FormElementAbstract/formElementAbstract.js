nb.component('multi_lang_form_element_container', function () {
  var $container = $(this);
  var $elements = $container.find('.multi_lang_form_element');
  var $languageBar = $container.find('.nb_i18n_language_bar');
  var $current = null;
  var isShiftDown = false;
  var api = new Object();
  var firstExecution = true;

  $languageBar.find('.prev_button').attr('title', 'CTRL + up');
  $languageBar.find('.next_button').attr('title', 'CTRL + down');

  $container.keydown(function (event) {
    if (event.ctrlKey && !event.altKey && !event.shiftKey) {
      if (event.which == 40) { //ctrl + down arrow
        $languageBar.data('nb_i18n_language_bar').nextLanguage();
        event.preventDefault();
      } else if (event.which == 38) { //ctrl + up arrow
        $languageBar.data('nb_i18n_language_bar').prevLanguage();
        event.preventDefault();
      }
    }
  });

  function showCorrectFormElement() {
      var $oldCurrent = $current;
      var langBarApi = $languageBar.data('nb_i18n_language_bar');
      if(!langBarApi) {
        return;
      }
      var langCode = $languageBar.data('nb_i18n_language_bar').getSelectedLanguage();
      $current = $container.find('.multi_lang_form_element_' + langCode);
      if($current.length == 0) {
        return;
      }

      function showCurrent() {
        var elem = $current.slideDown().find('input, textarea');
        if (!firstExecution) {
          elem.focus();
        }
        firstExecution = false;
      }

      if ($oldCurrent) {
        $oldCurrent.hide();
      }
      showCurrent();
  }

  $languageBar.bind('change', showCorrectFormElement);
  $languageBar.bind('ready', showCorrectFormElement);

  return api;
});