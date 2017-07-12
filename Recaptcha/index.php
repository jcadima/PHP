<?php include 'config.php'  ; ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title></title>

 <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>

<form action="" method="POST" id="leadform">
    <input type="text" id="name" name="name" value="" placeholder="Name">
    <input type="text" id="email" name="email" value="" placeholder="Email">
    <div><textarea type="text" id="message" name="message" placeholder="Message"></textarea></div>
    <div class="g-recaptcha" data-sitekey="6LeT7h8UAAAAALq7qjy90QTcjphFpAtfkg9tzEcT"></div>
    <input type="submit" name="submit" value="SUBMIT">
</form>

<div id="result" style="display:none;"></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

<script>
$(document).ready(function() {
	$("#leadform").submit(function(event) {
	    /* Stop form from submitting normally */
	    event.preventDefault();
	    /* Get from elements values */
	    var name = $('#name').val();
	    var email = $('#email').val();
	    var message = $('#message').val();
	    var g_recaptcha_response  = $('#g-recaptcha-response').val();

	    /* Clear result div*/
	    $("#result").html('');
	    
        ajaxRequest = $.ajax({
            url: "process_ajax.php",
            type: "post",
            data: {name:name,email:email,message:message, g_recaptcha_response: g_recaptcha_response }
        });

        /*  request cab be abort by ajaxRequest.abort() */

        ajaxRequest.done(function (response, textStatus, jqXHR){
          // show successfully for submit message
          console.log("SUCCESS") ;
          $('#result').show() ;
          $("#result").html(response);
        });

        /* On failure of request this function will be called  */
        ajaxRequest.fail(function (response){
        // show error
        console.log("ERROR") ;
        $("#result").html('Error found trying to submit the form: ' + respone );
        });

	});

}); // end document ready
</script>

</body>

</html>
