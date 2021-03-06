<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Recaptcha with Ajax demo</title>

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

<link href="http://codeseven.github.io/toastr/build/toastr.min.css" rel="stylesheet" type="text/css" />

<link href="css/styles.css" rel="stylesheet">

 <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>

<form action="" method="POST" id="leadform">
    <input type="text" id="name" name="name" value="" placeholder="Name">
    <input type="text" id="email" name="email" value="" placeholder="Email">
    <div><textarea type="text" id="message" name="message" placeholder="Message"></textarea></div>
    <div class="g-recaptcha" data-sitekey="your-client-key"></div>
    <input type="submit" name="submit" value="SUBMIT">
</form>

<div id="loader" class="col-md-12" style="display:none;">
  <img src="images/spinner.gif">
</div>              

<div class="col-md-12 text-center">
  <div id="result" class="alert alert-success" style="display:none;"></div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

<script src="http://codeseven.github.io/toastr/build/toastr.min.js"></script>

<script>
$(document).ready(function() {
	$("#leadform").submit(function(event) {
      $('#loader').show() ; // show the loader on init
	    /* Stop form from submitting normally */
	    event.preventDefault();
	    /* Get from elements values */
	    var name    = $('#name').val();
	    var email   = $('#email').val();
	    var message = $('#message').val();
	    var g_recaptcha_response  = $('#g-recaptcha-response').val();

	    /* Clear result div*/
	    $("#result").html('');
	    
        ajaxRequest = $.ajax({
            url: "process.php",
            type: "post",
            data: {name:name,email:email,message:message, g_recaptcha_response: g_recaptcha_response }
        });

        ajaxRequest.done(function (response, textStatus, jqXHR){
          if ( jqXHR.responseText == "Recaptcha is required" ) {
            toastr.error('Recaptcha is required', 'Error');
            $('#loader').hide() ;        
          }          

          else {                                
            toastr.success('Thanks for filling out our form!');
            $('#loader').hide() ;                
          }             
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
