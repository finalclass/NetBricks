nb.component('nb_extended_array_builder', function () {
  var that = this;
  var api = new Object();
  var comapnies = $.parseJSON($(that).find('.data').text())
    .filter(function (item) {
      return item.length > 0;
    });

  var ViewModel = function (items) {

    this.items = ko.observableArray(items);

    this.itemToAdd = ko.observable('');

    this.selectedOptions = ko.observableArray([]);

    this.removeSelected = function () {
      this.items.removeAll(this.selectedOptions());
    }.bind(this);

    this.addItem = function () {
      if (this.itemToAdd() != '') {
        this.items.push(this.itemToAdd()); // Adds the item. Writing to the "items" observableArray causes any associated UI to update.
        this.itemToAdd(''); // Clears the text box, because it's bound to the "itemToAdd" observable
      }
    }.bind(this);  // Ensure that "this" is always this view model

    this.removeItem = function (item) {
      this.items.remove(item);
    }.bind(this);

    this.editItem = function (item) {
      var pr = prompt('Set new name', item);
      if(pr === null) {
        return;
      }
      var indexOf = this.items.indexOf(item);
      this.items.splice(indexOf, 1, pr);
    }.bind(this);

    this.onInputKeyDown = function (me, event) {
      if (event.keyCode === 13) {
        this.addItem();
        return false;
      }
      return true;
  }.bind(this);
};

api.init = function () {
  ko.applyBindings(new ViewModel(comapnies), that);
};

return api;
})
;