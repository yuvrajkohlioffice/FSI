<?php
// 1. Include core system files
include_once "includes/classes.php";

// 2. Start Session (Required to show success/error messages)
session_start();

// 3. Display Alert Message if one exists in the session
// This handles the feedback loop from process.php
if (isset($_SESSION['message'])) {
    $msg = htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8');
    echo "<script>alert('$msg');</script>";
    unset($_SESSION['message']); // Clear message so it doesn't show again on refresh
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enquiry Feedback</title>
    
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    
    <style>
        .red { color: red; }
        .form-group { margin-bottom: 15px; }
        .form-control { width: 100%; padding: 8px; box-sizing: border-box; }
        /* Simple spacing helper */
        .tz-text { margin-bottom: 20px; }
    </style>

    <script type="text/javascript">
        // 5. Modern JavaScript Validation
        // We replaced the old "loop" method with cleaner "Regex" validation
        
        function validate(form) {
            var errorMessage = "";
            var errorCount = 0;
            
            // --- Helper: Trim whitespace ---
            var name = form.incidentName.value.trim();
            var address = form.incidentAddress.value.trim();
            var mobile = form.incidentMobile.value.trim();
            var email = form.incidentEmail.value.trim();
            var complaint = form.incidentComplaint.value.trim();

            // --- 1. Validate Name ---
            if (name === "") {
                errorCount++;
                errorMessage += errorCount + ". Enter Your Name.\n";
            }

            // --- 2. Validate Address ---
            if (address === "") {
                errorCount++;
                errorMessage += errorCount + ". Enter Address.\n";
            }

            // --- 3. Validate Mobile (10 Digits) ---
            // Checks if it is a number and length is 10
            if (mobile === "" || isNaN(mobile) || mobile.length !== 10) {
                errorCount++;
                errorMessage += errorCount + ". Enter a valid 10-digit Mobile No.\n";
            }

            // --- 4. Validate Email (Using Regex) ---
            var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            if (!emailPattern.test(email)) {
                errorCount++;
                errorMessage += errorCount + ". Enter a valid Email-ID.\n";
            }

            // --- 5. Validate Complaint ---
            if (complaint === "") {
                errorCount++;
                errorMessage += errorCount + ". Enter Complaint Details.\n";
            }

            // --- 6. Validate Google reCAPTCHA ---
            // We check if the response token exists
            var response = grecaptcha.getResponse();
            if (response.length === 0) {
                errorCount++;
                errorMessage += errorCount + ". Please check the 'I'm not a robot' box.\n";
            }

            // --- Final Decision ---
            if (errorMessage === "") {
                return true; // Submit the form
            } else {
                alert("Please correct the following errors:\n" + errorMessage);
                return false; // Stop submission
            }
        }
    </script>
</head>
<body>

<div class="container">
    
    <h1 class="title-large alt-font font-weight-400 position-relative top-minus3 tz-text">Enquiry / Feedback</h1>
    <p>Please fill the below form to give your Valuable Feedback<br/><br/></p>
    
    <form role="form" class="form-horizontal" method="post" action="process.php" onsubmit="return validate(this);" autocomplete="off">
        
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="name">Enter Your Name <span class="red">*</span></label>
                    <input class="form-control" name="incidentName" id="name" placeholder="Full Name" type="text" required>
                </div>
                <div class="col-md-6">
                    <label for="address">Enter Your Address <span class="red">*</span></label>
                    <textarea class="form-control" name="incidentAddress" id="address" placeholder="Full Address" rows="1" maxlength="100" required></textarea>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="mobile">Enter Your Mobile No. <span class="red">*</span></label>
                    <input class="form-control" name="incidentMobile" id="mobile" placeholder="10 Digit Mobile" type="tel" pattern="[0-9]{10}" maxlength="10" required>
                </div>
                <div class="col-md-6">
                    <label for="email">Enter Your Email Address <span class="red">*</span></label>
                    <input class="form-control" name="incidentEmail" id="email" placeholder="example@domain.com" type="email" required>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="message">Enter Your Feedback Below <span class="red">*</span></label>
                    <textarea class="form-control" name="incidentComplaint" id="message" placeholder="Describe your feedback here..." rows="5" maxlength="500" required></textarea>
                </div>
                
                <div class="col-md-6">
                    <label>Security Check <span class="red">*</span></label>
                    <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" name="submitButton" class="btn btn-primary btn-sm btn-home">SUBMIT FEEDBACK</button>
                </div>
            </div>
        </div>

    </form>
</div>

</body>
</html>