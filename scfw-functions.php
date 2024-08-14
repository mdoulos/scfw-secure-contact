<?php
defined( 'ABSPATH' ) || exit;

// Add the admin menu link.
add_action('admin_menu', 'add_scfw_admin_menu_link');
function add_scfw_admin_menu_link() {
    add_menu_page(
        'Secure Contact Forms',        // page title
        'Secure Contact',              // menu title
        'manage_options',              // capability
        'secure_contact',              // menu slug
        'scfw_admin_page',              // function that outputs content to page
        'dashicons-email',             // icon url
        99                             // position
    );
}

// Add the shortcodes for the forms.
add_action( 'init', 'register_scfw_shortcodes');
function register_scfw_shortcodes() {
	add_shortcode('scfw-form', 'scfw_form');
}

// Enqueue styles for the admin area.
add_action( 'admin_enqueue_scripts', 'enqueue_scfw_custom_admin_styles' );
function enqueue_scfw_custom_admin_styles() {
    wp_enqueue_style( 'scfw-admin-styles', plugin_dir_url( __FILE__ ) . '/css/scfw-admin-styles.css' );
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'scfw-colorpicker', plugins_url('js/scfw-colorpicker.js', __FILE__), array('wp-color-picker'), false, true );
}

// Enqueue styles for the front end.
add_action( 'wp_enqueue_scripts', 'enqueue_scfw_custom_styles' );
function enqueue_scfw_custom_styles() {
	wp_enqueue_style( 'scfw-frontend-styles', plugin_dir_url( __FILE__ ) . '/css/scfw-frontend-styles.css' );
}

// Output the content for the main admin page of the plugin.
function scfw_admin_page(){
    require_once('scfw-admin.php');
}

// The word that the user inputs on the front end in an attempt to match the security image, is checked against this list.
function scfw_security_array() {
    $security_words = [
        "Transportation" => ["roads", "equip", "trucks", "cargo", "drive"],
        "Nature" => ["nature", "grass", "plants", "leaves", "branch"],
        "Travel" => ["planes", "beach", "resort", "travel", "scenic"],
        "Electronics" => ["remote", "mouse", "screen", "digital", "pixels"],
        "Clothing" => ["shirts", "fabric", "hanger", "sheets", "outfit"],
        "Automobiles" => ["wheel", "steer", "mirror", "engine", "handle"],
        "Religion" => ["prayer", "divine", "faith", "devote", "glory"],
        "Food" => ["lunch", "dinner", "meals", "napkin", "taste"],
        "Animals" => ["furry", "claws", "snout", "burrow", "hatch"],
        "Gibberish" => ["rwyged", "wbeqaz", "oputyr", "nulrvc", "ilozsx"]
    ];
    return $security_words;
}

// Will sanitize the email addresses inputted in the admin form and return a string of valid email addresses.
function sanitize_and_validate_emails($email_list) {
    $emails = explode(',', $email_list); // Split the string into individual emails
    $valid_emails = [];

    foreach ($emails as $email) {
        $email = trim($email); // Remove any surrounding whitespace
        $sanitized_email = filter_var($email, FILTER_SANITIZE_EMAIL); // Sanitize email
        if (filter_var($sanitized_email, FILTER_VALIDATE_EMAIL)) { // Validate email
            $valid_emails[] = $sanitized_email;
        }
    }

    return implode(', ', $valid_emails); // Reconstruct the list of validated emails
}
