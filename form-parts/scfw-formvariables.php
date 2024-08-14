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

// Fetch the currently set allowed image categories
$allowed_categories = get_option('scfw_img_category_option', array_values($category_options_map));

$img_category = $allowed_categories[array_rand($allowed_categories)];
$img_option = rand(1, 5);

// Check for or create statistic records.
$successful_submissions = get_option('scfw_successful_submissions');
$blocked_submissions = get_option('scfw_blocked_submissions');
$recovered_from_failure = get_option('scfw_recovered_from_failure');
$failed_human_attempts = get_option('scfw_failed_human_attempts');
$failed_bot_attempts = get_option('scfw_failed_bot_attempts');
if ($successful_submissions === false) {
    add_option('scfw_successful_submissions', 0);
    $successful_submissions = 0;
}
if ($blocked_submissions === false) {
    add_option('scfw_blocked_submissions', 0);
    $blocked_submissions = 0;
}
if ($recovered_from_failure === false) {
    add_option('scfw_recovered_from_failure', 0);
    $recovered_from_failure = 0;
}
if ($failed_human_attempts === false) {
    add_option('scfw_failed_human_attempts', 0);
    $failed_human_attempts = 0;
}
if ($failed_bot_attempts === false) {
    add_option('scfw_failed_bot_attempts', 0);
    $failed_bot_attempts = 0;
}

// Start a session to count how many times a user has failed to submit the form, if any.
session_start();
if (!isset($_SESSION['scfw_form_failure_count'])) {
    $_SESSION['scfw_form_failure_count'] = 0;
}
$allowed_failure_count = get_option('scfw_response_fail_count') ? get_option('scfw_response_fail_count') : 2;
$failure_limit_reached = false;

// Submission Response Variables ---
$scfw_response_heading = get_option('scfw_response_heading') ? get_option('scfw_response_heading') : 'Thank you for your submission!';
$scfw_response_text = get_option('scfw_response_text') ? get_option('scfw_response_text') : 'We will reply to you as soon as possible.';
$scfw_response_redirect = get_option('scfw_response_redirect') ? get_option('scfw_response_redirect') : '';
$scfw_response_redirect_failed = get_option('scfw_response_redirect_failed') ? get_option('scfw_response_redirect_failed') : '';