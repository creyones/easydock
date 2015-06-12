
// function to send emails via Mandrill
Parse.Cloud.define("sendMail", function(request, response) {
  var Mandrill = require('mandrill');
  Mandrill.initialize('PUvh_jdztJvZHlkRBv2Smg');

  Mandrill.sendEmail({
    message: {
      text: request.params.text,
      subject: request.params.subject,
      from_email: request.params.fromEmail,
      from_name: request.params.fromName,
      to: [
        {
          email: request.params.toEmail,
          name: request.params.toName
        }
      ]
    },
    async: true
  },{
    success: function(httpResponse) {
      console.log(httpResponse);
      response.success("Email sent!");
    },
    error: function(httpResponse) {
      console.error(httpResponse);
      response.error("Uh oh, something went wrong");
    }
  });
});
