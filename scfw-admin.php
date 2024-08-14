<?php
defined( 'ABSPATH' ) || exit;

$category_options_map = [
    "Transportation" => 1,
    "Nature" => 2,
    "Travel" => 3,
    "Electronics" => 4,
    "Clothing" => 5,
    "Automobiles" => 6,
    "Religion" => 7,
    "Food" => 8,
    "Animals" => 9,
    "Gibberish" => 10
];

$inputs_array = [
    "Name" => "Name",
    "Email" => "Email",
    "Phone" => "Phone",
    "Business Name" => "Business Name",
    "Subject Line" => "Subject",
    "Real Person Test" => "Answer",
    "Message" => "Message"
];

// check if the form is submitted and if the request comes from the page itself
if(isset($_POST['submit']) && check_admin_referer('scfw_admin_update')) {
    $selected_options = isset($_POST['img_category']) ? $_POST['img_category'] : array();
    $to_email = isset($_POST['scfw_to_email']) ? sanitize_email($_POST['scfw_to_email']) : '';
    $cc_email = isset($_POST['scfw_cc_email']) ? $_POST['scfw_cc_email'] : '';
    $cc_email = sanitize_and_validate_emails($cc_email);
    $bcc_email = isset($_POST['scfw_bcc_email']) ? $_POST['scfw_bcc_email'] : '';
    $bcc_email = sanitize_and_validate_emails($bcc_email);
    $from_email = isset($_POST['scfw_from_email']) ? sanitize_email($_POST['scfw_from_email']) : '';
    $replyto_email = isset($_POST['scfw_replyto_email']) ? sanitize_email($_POST['scfw_replyto_email']) : '';

    // map selected options to corresponding integers
    $selected_values = array_map(function($option) use ($category_options_map) {
        return $category_options_map[$option];
    }, $selected_options);

    // update the options in the database
    update_option('scfw_img_category_option', $selected_values);
    update_option('scfw_to_email', $to_email);
    update_option('scfw_cc_email', $cc_email);
    update_option('scfw_bcc_email', $bcc_email);
    update_option('scfw_from_email', $from_email);
    update_option('scfw_replyto_email', $replyto_email);

    foreach ($inputs_array as $option => $value):
        $option_code = preg_replace('/[^a-zA-Z0-9 ]/', '', $option); // Remove special characters
        $option_code = str_replace(' ', '_', $option_code); // Replace spaces with underscores
        $option_code = strtolower($option_code); // Convert to lowercase

        update_option('scfw_' . $option_code . '_order', isset($_POST['scfw_' . $option_code . '_order']) ? intval($_POST['scfw_' . $option_code . '_order']) : 0);
        update_option('scfw_' . $option_code . '_name', isset($_POST['scfw_' . $option_code . '_label']) ? sanitize_text_field($_POST['scfw_' . $option_code . '_label']) : '');
        update_option('scfw_' . $option_code . '_placeholder', isset($_POST['scfw_' . $option_code . '_placeholder']) ? sanitize_text_field($_POST['scfw_' . $option_code . '_placeholder']) : '');
        update_option('scfw_' . $option_code . '_enabled', isset($_POST['scfw_' . $option_code . '_enabled']));
        update_option('scfw_' . $option_code . '_required', isset($_POST['scfw_' . $option_code . '_required']));
    endforeach;

    // update the security image color
    $color = isset($_POST['scfw_admin_securityimage_color']) ? sanitize_hex_color($_POST['scfw_admin_securityimage_color']) : '';
    update_option('scfw_securityimage_color', $color);

    // update the submit button color and text
    update_option('scfw_sendbutton_color', isset($_POST['scfw_admin_sendbutton_color']) ? sanitize_hex_color($_POST['scfw_admin_sendbutton_color']) : '');
    update_option('scfw_sendbutton_text_color', isset($_POST['scfw_admin_sendbutton_text_color']) ? sanitize_hex_color($_POST['scfw_admin_sendbutton_text_color']) : '');
    update_option('scfw_sendbutton_text', isset($_POST['scfw_admin_sendbutton_text']) ? sanitize_text_field($_POST['scfw_admin_sendbutton_text']) : 'Send Message');
    update_option('scfw_sendbutton_width', isset($_POST['scfw_admin_sendbutton_width']) ? intval($_POST['scfw_admin_sendbutton_width']) : '');

    // update the form submission response
    update_option('scfw_response_heading', isset($_POST['scfw_response_heading']) ? sanitize_text_field($_POST['scfw_response_heading']) : 'Thank you for your submission!');
    update_option('scfw_response_text', isset($_POST['scfw_response_text']) ? sanitize_text_field($_POST['scfw_response_text']) : 'We will reply as soon as possible.');
    update_option('scfw_response_redirect', isset($_POST['scfw_response_redirect']) ? esc_url($_POST['scfw_response_redirect']) : '');
    update_option('scfw_response_redirect_failed', isset($_POST['scfw_response_redirect_failed']) ? esc_url($_POST['scfw_response_redirect_failed']) : '');
    update_option('scfw_response_fail_count', isset($_POST['scfw_response_fail_count']) ? intval($_POST['scfw_response_fail_count']) : 2);
}

// fetch the currently set image categories
$current_img_categories = get_option('scfw_img_category_option', array_values($category_options_map));


?>

<h1>Secure Contact Forms for Wordpress</h1>

<form method="POST" action="" class="scfw-admin__form">
    <?php wp_nonce_field('scfw_admin_update'); ?>

    <p>To add a contact form to your site, use the shortcode <code>[scfw-form]</code> in a post or page.</p>

    <div class="scfw-admin_emails scfw-admin__section">
        <h2>Emails</h2>
        <p>Enter the email addresses that should receive the form submissions. The reply-to email is the fallback in case the contact doesn't submit a valid email.</p>
        <div class="flex-row">
            <label for="scfw_to_email">To Email:</label>
            <input type="text" name="scfw_to_email" value="<?php echo get_option('scfw_to_email'); ?>">
        </div>
        <div class="flex-row">
            <label for="scfw_from_email">From Email:</label>
            <input type="text" name="scfw_from_email" value="<?php echo get_option('scfw_from_email'); ?>">
        </div>
        <div class="flex-row">
            <label for="scfw_replyto_email">Reply-To Email:</label>
            <input type="text" name="scfw_replyto_email" value="<?php echo get_option('scfw_replyto_email'); ?>">
        </div>
        <div class="flex-row">
            <label for="scfw_cc_email">CC Recipients (Comma-separated):</label>
            <input type="text" name="scfw_cc_email" value="<?php echo get_option('scfw_cc_email'); ?>">
        </div>
        <div class="flex-row">
            <label for="scfw_bcc_email">BCC Recipients (Comma-separated):</label>
            <input type="text" name="scfw_bcc_email" value="<?php echo get_option('scfw_bcc_email'); ?>">
        </div>
    </div>

    <div class="scfw-admin_image-category scfw-admin__section">
        <h2>Image Categories</h2>
        <p>Randomly Show Images From These Image Categories:</p>
        <?php foreach ($category_options_map as $option => $value): ?>
            <input type="checkbox" id="<?php echo strtolower($option); ?>" name="img_category[]" value="<?php echo $option; ?>" <?php checked(in_array($value, $current_img_categories)); ?>>
            <label for="<?php echo strtolower($option); ?>"><?php echo $option; ?></label><br>
        <?php endforeach; ?>
    </div>

    <div class="scfw-admin_securityimage scfw-admin__section">
        <h2>Security Overlay Color</h2>
        <p>Select a color to overlay the security image:</p>
        <?php 
            $color = get_option('scfw_securityimage_color');
        ?>
        <div class="flex-row">
            <label class="scfw-admin_securityimage-label" for="scfw_admin_securityimage_color">Pick a Color</label>
            <input type="text" id="scfw_securityimage_color_picker" name="scfw_admin_securityimage_color" value="<?php echo $color; ?>" />
        </div>
    </div>

    <div class="scfw-admin_sendbutton scfw-admin__section">
        <h2>Submit Button</h2>
        <p>Specify the text and color for the submit button:</p>
        <?php 
            $bg_color = get_option('scfw_sendbutton_color');
            $text_color = get_option('scfw_sendbutton_text_color');
            $submit_placeholder = get_option('scfw_sendbutton_text') ? get_option('scfw_sendbutton_text') : "Send Message";
            $submit_width = get_option('scfw_sendbutton_width') ? get_option('scfw_sendbutton_width') : "";
        ?>
        <div class="flex-row">
            <label class="scfw-admin_sendbutton-color" for="scfw_admin_sendbutton_color">Background Color</label>
            <input type="text" id="scfw_sendbutton_color_picker" name="scfw_admin_sendbutton_color" value="<?php echo $bg_color; ?>" />
        </div>
        <div class="flex-row">
            <label class="scfw-admin_sendbutton_text-color" for="scfw_admin_sendbutton_text_color">Text Color</label>
            <input type="text" id="scfw_sendbutton_text_color_picker" name="scfw_admin_sendbutton_text_color" value="<?php echo $text_color; ?>" />
        </div>
        <div class="flex-row">
            <label for="scfw_admin_sendbutton_text">Text:</label>
            <input type="text" name="scfw_admin_sendbutton_text" value="<?php echo $submit_placeholder; ?>">
        </div>
        <div class="flex-row">
            <label for="scfw_admin_sendbutton_width">Max Width (in Pixels):</label>
            <input type="text" name="scfw_admin_sendbutton_width" value="<?php echo $submit_width; ?>">
        </div>
    </div>

    <div class="scfw-admin_inputs scfw-admin__section">
        <h2>Inputs</h2>
        <p>Modify the text, display, requirements, and order of the contact form inputs:</p>
        <?php foreach ($inputs_array as $option => $value):
            $option_code = preg_replace('/[^a-zA-Z0-9 ]/', '', $option); // Remove special characters
            $option_code = str_replace(' ', '_', $option_code); // Replace spaces with underscores
            $option_code = strtolower($option_code); // Convert to lowercase
            $index_position = array_search($option, array_keys($inputs_array));

            $order_value = get_option('scfw_' . $option_code . '_order', $index_position);

            // If there is a custom name or placeholder, use it, otherwise use the default
            $input_name = get_option('scfw_' . $option_code . '_name') ? get_option('scfw_' . $option_code . '_name') : $option;
            $input_placeholder = get_option('scfw_' . $option_code . '_placeholder') ? get_option('scfw_' . $option_code . '_placeholder') : $option;

            $option_enabled = get_option('scfw_' . $option_code . '_enabled', true);
            $option_required = get_option('scfw_' . $option_code . '_required', true);
            ?>
            <div class="flex-row" id="scfw-admin__<?php echo $option_code; ?>">
                <label><?php echo $option; ?></label>
                <div class="flex-row scfw-admin__order">
                    <label for="scfw_<?php echo $option_code; ?>_order">Order:</label>
                    <input type="number" min="0" max="6" name="scfw_<?php echo $option_code; ?>_order" value="<?php echo $order_value; ?>">
                </div>
                <div class="flex-row">
                    <label for="scfw_<?php echo $option_code; ?>_label">Label:</label>
                    <input type="text" name="scfw_<?php echo $option_code; ?>_label" value="<?php echo $input_name; ?>">
                </div>
                <div class="flex-row">
                    <label class="scfw-admin_placeholder-label" for="scfw_<?php echo $option_code; ?>_placeholder">Placeholder:</label>
                    <input type="text" name="scfw_<?php echo $option_code; ?>_placeholder" value="<?php echo $input_placeholder; ?>">
                </div>
                <div class="flex-row">
                    <label class="scfw-admin_checkbox-label" for="scfw_<?php echo $option_code; ?>_enabled">Enabled:</label>
                    <input type="checkbox" id="scfw_<?php echo $option_code; ?>_enabled" name="scfw_<?php echo $option_code; ?>_enabled" value="1" <?= $option_enabled ? 'checked' : ''; ?>>
                </div>
                <div class="flex-row">
                    <label class="scfw-admin_checkbox-label" for="scfw_<?php echo $option_code; ?>_required">Required:</label>
                    <input type="checkbox" id="scfw_<?php echo $option_code; ?>_required" name="scfw_<?php echo $option_code; ?>_required" value="1" <?= $option_required ? 'checked' : ''; ?>>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="scfw-admin_submission scfw-admin__section">
        <h2>Form Submission Response</h2>
        <p>Specify what should happen when the form is submitted, by default a thank you response will overlay the contact form. An optional thank you page can be redirected to:</p>
        <?php
            $response_heading = get_option('scfw_response_heading') ? get_option('scfw_response_heading') : "Thank you for your submission!";
            $response_text = get_option('scfw_response_text') ? get_option('scfw_response_text') : "We will reply as soon as possible.";
            $response_redirect = get_option('scfw_response_redirect') ? get_option('scfw_response_redirect') : '';
            $response_redirect_failed = get_option('scfw_response_redirect_failed') ? get_option('scfw_response_redirect_failed') : '';
            $response_fail_count = get_option('scfw_response_fail_count') ? get_option('scfw_response_fail_count') : 2;
        ?>
        <div class="flex-row">
            <label for="scfw_response_heading">Response Heading:</label>
            <input type="text" name="scfw_response_heading" value="<?php echo $response_heading; ?>">
        </div>
        <div class="flex-row">
            <label for="scfw_response_text">Response Text:</label>
            <input type="text" name="scfw_response_text" value="<?php echo $response_text; ?>">
        </div>
        <div class="flex-row">
            <label for="scfw_response_redirect">Redirect Link (Optional):</label>
            <input type="text" name="scfw_response_redirect" value="<?php echo $response_redirect; ?>">
        </div>
        <div class="flex-row">
            <label for="scfw_response_redirect_failed">Redirect Link for Failed Submissions (Optional):</label>
            <input type="text" name="scfw_response_redirect_failed" value="<?php echo $response_redirect_failed; ?>">
        </div>
        <div class="flex-row">
            <label for="scfw_response_fail_count">Number of Allowed Security Test Failures:</label>
            <input type="number" name="scfw_response_fail_count" value="<?php echo $response_fail_count; ?>" step="1" min="0" max="999">
        </div>
    </div>
    <div class="scfw-admin_statistics scfw-admin__section">
        <h2>Submission Statistics</h2>
        <p>Learn about how your contact form is performing:</p>
        <?php
            $successful_submissions = get_option('scfw_successful_submissions') ? get_option('scfw_successful_submissions') : 0;
            $blocked_submissions = get_option('scfw_blocked_submissions') ? get_option('scfw_blocked_submissions') : 0;
            $recovered_from_failure = get_option('scfw_recovered_from_failure') ? get_option('scfw_recovered_from_failure') : 0;
            $failed_human_attempts = get_option('scfw_failed_human_attempts') ? get_option('scfw_failed_human_attempts') : 0;
            $failed_bot_attempts = get_option('scfw_failed_bot_attempts') ? get_option('scfw_failed_bot_attempts') : 0;
        ?>
        <div class="flex-row">
            <span>Successful Submissions:</span>
            <span><?= $successful_submissions; ?></span>
        </div>
        <div class="flex-row">
            <span>Blocked Submissions:</span>
            <span><?= $blocked_submissions; ?></span>
        </div>
        <p>The recovered from failure metric tracks how many users successfully submitted the form after failing the security test at least once. Subtract this metric from successful submissions to find how many users passed the test on the first try.</p>
        <p>The failed attempts metric tracks how many failed attempts ultimately resulted in the submission being blocked vs how many security tests failed before getting it right and successfully submitting.</p>
        <div class="flex-row">
            <span>Recovered From Failure:</span>
            <span><?= $recovered_from_failure; ?></span>
        </div>
        <div class="flex-row">
            <span>Failed Human Attempts:</span>
            <span><?= $failed_human_attempts; ?></span>
        </div>
        <div class="flex-row">
            <span>Failed Bot Attempts:</span>
            <span><?= $failed_bot_attempts; ?></span>
        </div>
    </div>

    <?php submit_button('Save Changes', 'primary', 'submit'); ?>
</form>

