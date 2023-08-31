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

    public function display_grid_template(){


        $user_query = new WP_User();

        $paged = get_query_var('paged') ? absint( get_query_var('paged') ) : 1  ;
        

        // check if button filter is applied
        if(isset($_GET['btnFilter'])){
            $filter = [];


            // if button filter is applied and latest filter is also set
            if( isset( $_GET['latest_filter'] ) ){

                // if button filter and latest filter is set but rating filter is null
                if( sanitize_text_field($_GET['rating_filter']) == 0 ){

                    $filter = array(
                        'latest_filter' => 1,
                        'rating_filter' => 0,
                    );
    
                    $args = array(
                        'number' => 5 , 
                        'paged' => $paged , 
                        'meta_query' => array(
                            array(
                                'key' => 'user_review',
                                'compare' => 'EXISTS',
                            ),
                        ) , 
                        'orderby' => 'registered',
                        'order' => 'DESC'
                    );
                        
                }
                
                // if button filter and latest filter is set and rating filter is selected
                else{
                    $filter = array(
                        'latest_filter' => 1,
                        'rating_filter' => sanitize_text_field($_GET['rating_filter']),
                    );
                    $args = array(
                        'number' => 5 , 
                        'paged' => $paged , 
                        'meta_query' => array(
                            array(
                                'key' => 'user_rating',
                                'compare' => '=',
                                'value' => sanitize_text_field($_GET['rating_filter'])
                            ),
                        ) , 
                        'orderby' => 'registered',
                        'order' => 'DESC'
                    );
                }
            }
            
            // if button filter is applied but latest filter is not set
            else{

                // if button filter is applied, latest filter is not set and rating filter is null
                if( sanitize_text_field($_GET['rating_filter']) == 0 ){

                    $filter = array(
                        'latest_filter' => 0,
                        'rating_filter' => 0,
                    );
    
                    $args = array(
                        'number' => 5 , 
                        'paged' => $paged , 
                        'meta_query' => array(
                            array(
                                'key' => 'user_review',
                                'compare' => 'EXISTS',
                            ),
                        ) , 
                    );
                        
                }
                
                // if button filter is applied, latest filter is not set and rating filter is selected
                else{

                    $filter = array(
                        'latest_filter' => 0,
                        'rating_filter' => sanitize_text_field($_GET['rating_filter']),
                    );

                    $args = array(
                        'number' => 5 , 
                        'paged' => $paged , 
                        'meta_query' => array(
                            array(
                                'key' => 'user_rating',
                                'compare' => '=',
                                'value' => sanitize_text_field($_GET['rating_filter'])
                            ),
                        ) , 
                    );
                }

            }
        
        }
        
        // if there is no filter 
        else{
                $args = array(
                    'number' => 5 , 
                    'paged' => $paged , 
                    'meta_query' => array(
                        array(
                            'key' => 'user_review',
                            'compare' => 'EXISTS',
                        ),
                    ) , 
                );
        }

        $user_query = new WP_User_Query($args);

        // display grid in frontend
        require_once MY_PLUGIN_PATH.'/templates/reviews-template.php';

    }


}