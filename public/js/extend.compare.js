// user_response, answer
function deepCompare(objectA, objectB) {
  // check member length
  if (objectA.length != objectB.length) {
    return false;
  }

  // check member
  for (var i = 0; i < objectA.length; i++) {
    var a = objectA[i];
    var b = objectB[i];

    if (a.members.length != b.members.length) {
      return false;
    } else {
      for (var j = 0; j < b.members.length; j++) {
        var bm = b.members[j];
        if ( a.members.indexOf(bm) == -1 ) {
          return false;
        }
      }
    }
  }

  return true;
}
