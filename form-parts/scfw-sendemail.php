<?php
defined( 'ABSPATH' ) || exit;

// Validate To Email or set to Admin Email
$toEmail = get_option('scfw_to_email') ? get_option('scfw_to_email') : '';
if ( !filter_var($toEmail, FILTER_VALIDATE_EMAIL) ) {
    $toEmail = get_option('admin_email');
}

$fromEmail = get_option('scfw_from_email') ? get_option('scfw_from_email') : '';
$replyEmail = get_option('scfw_replyto_email') ? get_option('scfw_replyto_email') : '';
$visitorEmail = $_POST['visitor_email'];
$ccEmails = get_option('scfw_cc_email') ? get_option('scfw_cc_email') : '';
$bccEmails = get_option('scfw_bcc_email') ? get_option('scfw_bcc_email') : '';
$ccEmails = explode(', ', $ccEmails);
$bccEmails = explode(', ', $bccEmails);


// From
// Use the fromEmail if it is valid, otherwise use the toEmail.
if ( filter_var($fromEmail, FILTER_VALIDATE_EMAIL) ) {
    $fromEmail = filter_var($fromEmail, FILTER_SANITIZE_EMAIL);
} else {
    $fromEmail = $toEmail;
}
$headers[] = 'From: ' . $fromEmail;


// Reply-To
// Use the visitors email address as a reply-to if it is valid, otherwise use the default if it is set.
if ( !empty($visitorEmail) && filter_var($visitorEmail, FILTER_VALIDATE_EMAIL) ) {
    $replyEmail = filter_var($visitorEmail, FILTER_SANITIZE_EMAIL);
    $headers[] = 'Reply-To: ' . $replyEmail;
} elseif ( !empty($replyEmail) && filter_var($replyEmail, FILTER_VALIDATE_EMAIL) ) {
    $headers[] = 'Reply-To: ' . $replyEmail;
}


// CC and BCC
foreach( $ccEmails as $email ) {
    $headers[] = 'Cc: ' . $email;
}
foreach( $bccEmails as $email ) {
    $headers[] = 'Bcc: ' . $email;
}


// Subject Line
// Use the visitors subject line if it is valid.
if( !empty($_POST['visitor_subject']) ) { 
    $subjectLine = $_POST['visitor_subject'];
} else {
    $subjectLine = 'Contact Form Submission';
}


// Email Content
$emailContent = "New Message from Contact Form:
Name:  $_POST[visitor_name]
E-Mail: $_POST[visitor_email]
Subject: $_POST[visitor_subject]
Phone: $_POST[visitor_phone]
Business: $_POST[visitor_business]
Message: $_POST[visitor_message]
Real Person Test: $_POST[visitor_images]";


// Send the email
// Human Confirmed and Email Sent
wp_mail($toEmail, $subjectLine, $emailContent, $headers );