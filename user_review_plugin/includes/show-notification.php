<?php

class Notification{
    public function __construct(){

        add_action('wp_enqueue_scripts', array($this, 'show_notification'));

    }

    public function show_notification(){

        wp_localize_script('display-noemail-notification', 'objNot', array(
            'message' => "No Email Set",
        ));
        wp_localize_script('display-nodata-notification', 'objNot', array(
            'message' => "Please enter all vaid data",
        ));
        
        wp_localize_script('display-emailexists-notification', 'objNot', array(
            'message' => "Email already exists, please enter other email",
        ));
        wp_localize_script('display-novalidemail-notification', 'objNot', array(
            'message' => "Email and Username not valid",
        ));
        wp_localize_script('display-userregistered-notification', 'objNot', array(
            'message' => "User Registered and Review Stored",
        ));
        wp_localize_script('display-insertionerror-notification', 'objNot', array(
            'message' => "Error while storing in databse",
        ));
        
    }

}

?>