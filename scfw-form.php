<?php
defined( 'ABSPATH' ) || exit;
 

function scfw_form() {
    ob_start();

	// Initialize recorded statistic variables
	// Fetch the currently set allowed image categories and random image
	require_once dirname( __FILE__ ) . '/form-parts/scfw-formvariables.php';
?>
<span id="scfw_error_notice">Please fill out all of the required fields.</span>

<form method="POST" class="scfw-form" action="<?php the_permalink(); ?>"><?php

	// Load all of the form content, such as fields and inputs.
	require_once dirname( __FILE__ ) . '/form-parts/scfw-forminputs.php';

	if ( isset($_POST['submit']) && !empty($_POST['visitor_name']) ) {
		$emailValid = false;

		// Security Test ---
		// If the Antispam field is empty, continue with form validation.
		if ( empty($_POST['visitor_url']) ) {
			if ( !empty($_POST['visitor_images']) ){
				$securityArray = scfw_security_array();
				$POST_ImageCategory = explode(',', $_POST['visitor_option'])[0] - 1;
				$POST_ImageNumber = explode(',', $_POST['visitor_option'])[1];
				$POST_ImageNumber = $POST_ImageNumber - 1;

				$security_word = $securityArray[array_keys($securityArray)[$POST_ImageCategory]][$POST_ImageNumber];
	
				if(strtolower($_POST['visitor_images']) == strtolower($security_word)) {
					$emailValid = true;
				}
			}
		}

		// Send Email ---
		// If the email is valid, send the message.
		if ( $emailValid == true ) {
			require_once dirname( __FILE__ ) . '/form-parts/scfw-sendemail.php';
		} else {
			$_SESSION['scfw_form_failure_count']++;
		}

		// Failure Limit ---
		// If this submission reveals the failure count is too high, reset the count and block the submission.
		$failed_submission_count = $_SESSION['scfw_form_failure_count'];
		if ($failed_submission_count >= $allowed_failure_count) {
			$failure_limit_reached = true;
			$_SESSION['scfw_form_failure_count'] = 0;
		}

		// Submission Response ---
		// If the email is valid or the failure limit is reached, display the response message.
		// Otherwise, highlight the security test field and display an error message.
		require_once dirname( __FILE__ ) . '/form-parts/scfw-response.php';
	}

	// Load the javascript that always goes at the end of the form.
	require_once dirname( __FILE__ ) . '/form-parts/scfw-pagejavascript.php';

	?>
</form>

<?php
    return ob_get_clean();
}
