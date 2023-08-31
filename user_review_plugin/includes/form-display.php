<?php

// For first line of defense (security)
if(!defined('ABSPATH')){
    die("You cannot be here!");
}

class FormDisplay{

    public function __construct(){

        // register shortcode for use
        add_shortcode('registrationform', array($this, 'display_form_template'));

    }

    public function display_form_template(){

        // display form in frontend
        require_once MY_PLUGIN_PATH.'/templates/user-registration-form.php';

    }

}