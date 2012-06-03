nb.component('nb_common_form_nic_editor', function() {

  var that = this;

  setTimeout(function() {
    new nicEditor().panelInstance(that);
  }, 100)

});