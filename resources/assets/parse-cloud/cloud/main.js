
// Use Parse.Cloud.define to define as many cloud functions as you want.
// For example:
Parse.Cloud.define('deleteUser', function(request, response) {
  Parse.Cloud.useMasterKey();
  var query = new Parse.Query(Parse.User);
  query.equalTo("objectId", request.params.objectId);
  query.find({
    success: function(results) {
      results[0].destroy();
      console.log("User deleted");
      response.success("User has been succesfully deleted");
    },
    error: function() {
      console.error("User not deleted");
      response.error("User not deleted");
    }
  });
});
