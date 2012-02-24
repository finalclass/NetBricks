function(doc) {
  if (doc.type == '\\NetBricks\\Page\\Model\\PageWidgetType') {
    emit(doc._id, doc);
  }
};