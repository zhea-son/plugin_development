<?php

// For first line of defense (security)
if(!defined( 'ABSPATH' )){
    die( "You cannot be here!" );
}

if( ! class_exists( 'Shortcodes' ) ){

    class Shortcodes{

        private $save; // Property to initialize Save user data class
        private $filter; // Property to initialize Ajax filter and pagination class

        public function __construct(){

            $this->initialize();

            // register shortcode for user reviews display
            add_shortcode( 'reviews', array( $this, 'display_grid_template' ) );

            // register shortcode for review registration form display
            add_shortcode( 'registrationform', array( $this, 'display_form_template') );
    
        }

        /** 
         * Instantiate classes
        */
        public function initialize(){
            $this->save = new SaveData();
            $this->filter = new AjaxFilter();
        }
    
    
        /**
         * display template for html 
        */
        public function display_grid_template(){
    
            // data arguments for user query
            $args = array(
                'number' => 5 , 
                'meta_query' => array(
                    array(
                        'key' => 'user_review',
                        'compare' => 'EXISTS',
                    ),
                ) , 
            );
            
    
            $user_query = new WP_User_Query( $args );
    
            // display grid in frontend
            require_once MY_PLUGIN_PATH . '/templates/reviews-template.php';
    
        }

        public function display_form_template(){

            // display form in frontend
            require_once MY_PLUGIN_PATH . '/templates/user-registration-form.php';
    
        }


    }

}