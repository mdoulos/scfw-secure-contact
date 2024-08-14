<?php
defined( 'ABSPATH' ) || exit;

class Secure_Contact_Form_Plugin {
            
    public function __construct() {
        add_action( 'plugins_loaded', array( $this, 'load_scfw_plugin') );
    }

    // load the plugin's required files
    public function load_scfw_plugin() {
        require_once dirname(__FILE__).'/scfw-form.php';
        require_once dirname(__FILE__).'/scfw-functions.php';
    }
}

new Secure_Contact_Form_Plugin();