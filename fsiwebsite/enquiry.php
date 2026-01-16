<?php
	include_once "includes/classes.php";

	session_start();  // Start the session to access stored messages

	// Check if a message is set in the session
	if (isset($_SESSION['message'])) {
	    // Display the message
		echo '<script>alert("' . $_SESSION['message'] . '");</script>';

	    // Clear the message from the session after displaying it
	    unset($_SESSION['message']);
	}
?>
<style>
	.red{
		color:red;
	}
</style>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<script type="text/javascript">
	var whitespace = " \t\n\r";
	function isEmpty(s) {
		return ((s == null) || (s.length == 0));
	}
          
        function isWhitespace (s) {

		var i;

		// Is s empty?
		if (isEmpty(s)) return true;

		// Search through string's characters one by one
		// until we find a non-whitespace character.
		// When we do, return false; if we don't, return true.
		for (i = 0; i < s.length; i++)
		{
				// Check that current character isnt whitespace.
				var c = s.charAt(i);

				if (whitespace.indexOf(c) == -1) return false;
		}

		// All characters are whitespace.
		return true;
	}
	function isEmail (s) {

		// is s whitespace?
		if (isWhitespace(s)) return false;

		// there must be >= 1 character before @, so we
		// start looking at character position 1
		// (i.e. second character)
		var i = 1;
		var sLength = s.length;

		// look for @
		while ((i < sLength) && (s.charAt(i) != "@"))
		{ i++
		}

		if ((i >= sLength) || (s.charAt(i) != "@")) return false;
		else i += 2;

		// look for .
		while ((i < sLength) && (s.charAt(i) != "."))
		{ i++
		}

		// there must be at least one character after the .
		if ((i >= sLength - 1) || (s.charAt(i) != ".")) return false;
		else return true;
	}
	function validate(theform)
	{
		var errorMessage = "";
		var errorCount = 0;
		var stringLength = theform.upassword.value.length;
		if(theform.incidentName.value.replace(/^\s+|\s+$/g,"")=="")
		{
			errorCount++;
			errorMessage = errorMessage + errorCount + ". Enter Your Name.\n";
		}
		if(theform.incidentAddress.value.replace(/^\s+|\s+$/g,"")=="")
		{
			errorCount++;
			errorMessage = errorMessage + errorCount + ". Enter Address.\n";
		}
		if(theform.incidentMobile.value.replace(/^\s+|\s+$/g,"")=="")
		{
			errorCount++;
			errorMessage = errorMessage + errorCount + ". Enter Mobile No.\n";
		}	
		if(!isEmail(theform.incidentEmail.value)) 
    		{
			errorCount++;
			errorMessage = errorMessage + errorCount + ". Enter Correct Email-ID.\n";
		}
		if(theform.incidentComplaint.value.replace(/^\s+|\s+$/g,"")=="")
		{
			errorCount++;
			errorMessage = errorMessage + errorCount + ". Enter Complaint Details.\n";
		}
		if( errorMessage == "" )
			return true;
		else
		{
			alert( "Error: Please rectify following errors:\n" + errorMessage );
			return false;				
		}
	}
</script>
<h1 class="title-large alt-font font-weight-400  position-relative top-minus3 tz-text">Enquiry / Feedback</h1>
<p>Please fill the below form to give your Valuable Feedback<br/><br/></p>
<form role="form" class="form-horizontal" method="post" action="process.php" onsubmit="return validate(this);" autocomplete="off">
    <div class="form-group">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-md-6">
                    <label for="name">Enter Your Name <span class="red">*</span></label>
					<input class="form-control" name="incidentName"  id="name" placeholder="Name" type="text" required="" autocomplete="off">
                </div>
                <div class="col-md-6">
                    <label for="address">Enter Your Address <span class="red">*</span></label>
                    <textarea class="form-control"  name="incidentAddress" type="textarea" id="address" placeholder="Address" maxlength="70" rows="1" required="" autocomplete="off"></textarea>
                </div>																								
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-6">
            <label for="mobile">Enter Your Mobile No. <span class="red">*</span></label>
			<input class="form-control" name="incidentMobile" id="mobile" placeholder="Mobile" type="text" required="" autocomplete="off">
        </div>
		<div class="col-md-6">
		    <label for="email">Enter Your Email Address <span class="red">*</span></label>
			<input class="form-control" name="incidentEmail" id="email" placeholder="Email" type="email" required="" autocomplete="off">
		</div>
    </div>
    <div class="form-group">
        <div class="col-sm-6">
            <label for="message">Enter Your Feedback Below <span class="red">*</span></label>
			<textarea class="form-control" name="incidentComplaint" type="textarea" id="message" placeholder="Feedback Details" maxlength="70" autocomplete="off" rows="5" required=""></textarea>
		</div>
		<div class="col-sm-6">
		    <label for="captcha">Captcha</label>
			<input class="g-recaptcha" data-sitekey="6LembUErAAAAAIJtwEEIiG7fsJKmDxIefMlrGHhx" id="captcha" name="captcha">
		</div>
    </div>
	<div class="form-group">
		<div class="col-sm-12">
			<div class="row">
				<div class="col-md-6">
					<button type="submit" name="submitButton" class="btn btn-primary btn-sm btn-home">SUBMIT</button>
				</div>
			</div>
		</div>
	</div>
</form>
