function(doc) {
  if (doc.type == '\\NetBricks\\Page\\Model\\Page') {
    emit(doc._id, doc);
  }
};