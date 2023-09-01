<?php

// For first line of defense (security)
if(!defined('ABSPATH')){
    die("You cannot be here!");
}

class GridDisplay{

    public function __construct(){

        // register shortcode for user reviews display
        add_shortcode('reviews', array($this, 'display_grid_template'));


    }


    // display template for html 
    public function display_grid_template(){

                    $args = array(
                        'number' => 5 , 
                        'meta_query' => array(
                            array(
                                'key' => 'user_review',
                                'compare' => 'EXISTS',
                            ),
                        ) , 
                    );
        

        $user_query = new WP_User_Query($args);



        // display grid in frontend
        require_once MY_PLUGIN_PATH.'/templates/reviews-template.php';

    }


}