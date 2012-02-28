function(doc) {
  if (doc.type == '\\NetBricks\\Page\\Document\\Page') {
    emit(doc._id, doc);
  }
};