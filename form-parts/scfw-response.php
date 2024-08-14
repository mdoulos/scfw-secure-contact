<?php
defined( 'ABSPATH' ) || exit;

// Submission Response ---
// If the email is valid or the failure limit is reached, display the response message.
// Otherwise, highlight the security test field and display an error message.
if( $emailValid == true || $failure_limit_reached == true ) {

    if ( $emailValid == true ) {
        // Record successful submission
        $successful_submissions++;
        update_option('scfw_successful_submissions', $successful_submissions);

        // If the failure count is greater than 0, record the recovery and human attempts
        if ($failed_submission_count > 0) {
            $recovered_from_failure++;
            update_option('scfw_recovered_from_failure', $recovered_from_failure);

            $failed_human_attempts += $failed_submission_count;
            update_option('scfw_failed_human_attempts', $failed_human_attempts);

            $_SESSION['scfw_form_failure_count'] = 0;
        }
    } else {
        $blocked_submissions++;
        update_option('scfw_blocked_submissions', $blocked_submissions);

        $failed_bot_attempts += $allowed_failure_count;
        update_option('scfw_failed_bot_attempts', $failed_bot_attempts);
    }
    
    ?>
    <script>
        localStorage.removeItem('scfw_form_values');

        <?php 
        if ( $failure_limit_reached == true && $scfw_response_redirect_failed ) { ?>
            window.location.href = '<?= $scfw_response_redirect_failed; ?>';
        <?php 
        } elseif ( $failure_limit_reached == false && $scfw_response_redirect ) { ?>
            window.location.href = '<?= $scfw_response_redirect; ?>';
        <?php
        } ?>

        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }

        document.getElementById('scfw-submit').scrollIntoView();
    </script>

    <?php 
    if ( ($emailValid == true && !$scfw_response_redirect) || ($failure_limit_reached == true && !$scfw_response_redirect_failed)) { ?>
        <div class="scfw-response">
            <h3><?= $scfw_response_heading; ?></h3>
            <p><?= $scfw_response_text; ?></p>
        </div>
    <?php 
    } ?>
<?php 
} else { ?>
    <script>
        // Fill in the form with the previously saved values.
        let formValues = localStorage.getItem('scfw_form_values');
        if(formValues) {
            formValues = JSON.parse(formValues);
            for(let inputName in formValues) {
                let input = document.querySelector(`[name="${inputName}"]`);

                if(input) {
                    input.value = formValues[inputName];
                }
            }
        }

        // Highlight the security test field and display an error message.
        var visitorImages = document.getElementById('scfw-visitorimages');
        let errorNotice = document.getElementById("scfw_error_notice");

        visitorImages.classList.add('scfw-required-error');
        document.getElementById('scfw-submit').scrollIntoView();
        errorNotice.innerHTML = "Please review the required field and try again.";
        errorNotice.style.display = "block";
    </script>
<?php 
}