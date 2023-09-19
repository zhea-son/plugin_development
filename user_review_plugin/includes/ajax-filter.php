<?php

// For first line of defense (security)
if( ! defined( 'ABSPATH' )){
    die("You cannot be here!");
}

class AjaxFilter{

    public function __construct() {

        $this->init_hooks();

    }

    public function init_hooks() {

        // hook to append script
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_ajax_filter_scripts' ) );

        add_action( 'wp_ajax_process_filter_user_reviews', array( $this, 'process_filter_user_reviews' ) );
        // add_action('wp_ajax_nopriv_process_filter_user_reviews', array($this, 'process_filter_user_reviews'));

        add_action( 'wp_ajax_process_pagination', array( $this, 'process_pagination' ) );
        // add_action('wp_ajax_nopriv_process_pagination', array($this, 'process_pagination'));

    }


    /** 
     * calculate total pages when every reviews exist
     */ 
    public function calculate_total_pages() {

        // query for checking if user review exists in usermeta
        $user_query = new WP_User_Query( array( 
                    'number' => 5 , 
                    'meta_query' => array(
                        array(
                            'key' => 'user_review',
                            'compare' => 'EXISTS',
                        ),
                    ) ,
         ) );

        $total_pages = ceil( $user_query->total_users / 5 ) ;

        return $total_pages;
    }


    /** 
     * enqueue filtering and pagination script
    */ 
    public function enqueue_ajax_filter_scripts() { 

        wp_enqueue_script( 'custom-ajax-script', PLUGIN_URL . '/assets/js/main.js', ['jquery'], '1.0', true );
        wp_localize_script( 'custom-ajax-script', 'ajaxObj', array(
                'ajaxurl' => admin_url( 'admin-ajax.php' ),
            )
        );
        
    }

    /** 
     * process filtering  
    */
    public function process_filter_user_reviews() {

        // if latest filter is set
        if( sanitize_text_field( $_POST['checked'] ) == 'checked' ) {
 
            // if latest filter is set but rating filter is not selected
            if( sanitize_text_field( $_POST['rating'] ) == 0 ) {

                $filter = array(
                    'latest_filter' => 1,
                    'rating_filter' => 0,
                );

                $args = array(
                    'number' => 5 , 
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
            
            // if latest filter is set and rating filter is selected
            else {
                $filter = array(
                    'latest_filter' => 1,
                    'rating_filter' => sanitize_text_field( $_POST['rating'] ),
                );
                $args = array(
                    'number' => 5 , 
                    'meta_query' => array(
                        array(
                            'key' => 'user_rating',
                            'compare' => '=',
                            'value' => sanitize_text_field( $_POST['rating'] )
                        ),
                    ) , 
                    'orderby' => 'registered',
                    'order' => 'DESC'
                );
            }
        }
        
        // if latest filter is not set
        else{

            // if latest filter is not set and rating filter is not selected
            if( sanitize_text_field( $_POST['rating'] ) == 0 ) {

                $args = array(
                    'number' => 5 ,    
                    'meta_query' => array(
                        array(
                            'key' => 'user_review',
                            'compare' => 'EXISTS',
                        ),
                    ) , 
                );
                    
            }
            
            // if latest filter is not set and rating filter is selected
            else{

                $filter = array(
                    'latest_filter' => 0,
                    'rating_filter' => sanitize_text_field( $_POST['rating'] ),
                );

                $args = array(
                    'number' => 5 , 
                    'meta_query' => array(
                        array(
                            'key' => 'user_rating',
                            'compare' => '=',
                            'value' => sanitize_text_field( $_POST['rating'] )
                        ),
                    ) , 
                );
            }

        }

        $user_query = new WP_User_Query( $args );

        $template = '';

        // if no reviews exist
        if( empty( $user_query->results ) ){
            $template = __("No reviews yet");
        }
        
        // append the template
        else{
            $i = 0;
            foreach( $user_query->results as $user ){
                $fname = get_user_meta( $user->ID, 'first_name', true );
                    $lname = get_user_meta( $user->ID, 'last_name', true );
                    $review = get_user_meta( $user->ID, 'user_review', true );
                    $rrating = get_user_meta( $user->ID, 'user_rating', true );  
                    $i++;

                    $template .= '<tr><td>' . $i .'</td>
                        <td>' . esc_html( $fname ). ' ' . esc_html( $lname ) .'</td>
                        <td>' . esc_html( $user->user_email ) .'</td>
                        <td>' . esc_html( $rrating ) .'</td>
                        <td>' . esc_html( $review ) .'</td></tr>';
            }
            
        }
        
        // total number of pages for the filter applied
        $j = ceil( $user_query->total_users / 5 );
        
        wp_send_json( array(
            'template' => $template, // template for reviews table
            'pages' => $j, // total pages for query
            'total_pages' => sanitize_text_field( $this->calculate_total_pages() ),
            'active_page' => 1, // current page
        ));
        
        wp_die();

    }

    /** 
     * process pagination filtering
    */
    public function process_pagination(){

        // if latest filter is set
        if( sanitize_text_field( $_POST['checked'] ) == 'checked' ) {

            // if latest filter is set but rating filter is null
            if( sanitize_text_field( $_POST['rating'] ) == 0 ){

                $filter = array(
                    'latest_filter' => 1,
                    'rating_filter' => 0,
                );

                $args = array(
                    'number' => 5 ,
                    'paged' => sanitize_text_field( $_POST['page'] ), 
                    
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
            
            // if latest filter is set and rating filter is selected
            else{
                $filter = array(
                    'latest_filter' => 1,
                    'rating_filter' => sanitize_text_field( $_POST['rating'] ),
                );
                $args = array(
                    'number' => 5 ,
                    'paged' => sanitize_text_field( $_POST['page'] ), 
                    
                    'meta_query' => array(
                        array(
                            'key' => 'user_rating',
                            'compare' => '=',
                            'value' => sanitize_text_field( $_POST['rating'] )
                        ),
                    ) , 
                    'orderby' => 'registered',
                    'order' => 'DESC'
                );
            }
        }
        
        // if latest filter is not set
        else{

            // if button filter is applied, latest filter is not set and rating filter is null
            if( sanitize_text_field( $_POST['rating'] ) == 0 ){

                $filter = array(
                    'latest_filter' => 0,
                    'rating_filter' => 0,
                );

                $args = array(
                    'number' => 5 ,
                    'paged' => sanitize_text_field( $_POST['page'] ), 
                    
                    'meta_query' => array(
                        array(
                            'key' => 'user_review',
                            'compare' => 'EXISTS',
                        ),
                    ) , 
                );
                    
            }
            
            // if latest filter is not set and rating filter is selected
            else{

                $filter = array(
                    'latest_filter' => 0,
                    'rating_filter' => sanitize_text_field( $_POST['rating'] ),
                );

                $args = array(
                    'number' => 5 ,
                    'paged' => sanitize_text_field( $_POST['page'] ), 
                    
                    'meta_query' => array(
                        array(
                            'key' => 'user_rating',
                            'compare' => '=',
                            'value' => sanitize_text_field( $_POST['rating'] )
                        ),
                    ) , 
                    
                );
            }

        }

        $user_query = new WP_User_Query( $args );
        $template = '';

        // if no reviews exist
        if( empty( $user_query->results ) ) {
            $template = __("No reviews yet");
        }
        
        // append the template
        else {
            $i = 0; 
            foreach( $user_query->results as $user ) {
                $fname = get_user_meta( $user->ID, 'first_name', true );
                $lname = get_user_meta( $user->ID, 'last_name', true );
                $review = get_user_meta( $user->ID, 'user_review', true );
                $rrating = get_user_meta( $user->ID, 'user_rating', true );  
                $i++;

                $template .= '<tr><td>' . $i .'</td>
                    <td>' . esc_html( $fname ). ' ' .esc_html( $lname ) .'</td>
                    <td>' . esc_html( $user->user_email ) .'</td>
                    <td>' . esc_html( $rrating ) .'</td>
                    <td>' . esc_html( $review ) .'</td></tr>';
            }
    
        }
        $j = ceil( $user_query->total_users / 5 );
        
        wp_send_json( array(
            'template' => $template, // template for reviews table
            'pages' => $j, // total pages required for query
            'total_pages' => $this->calculate_total_pages(),
            'active_page' => (int) sanitize_text_field( $_POST['page'] ), // current page
        ));
        
        wp_die();
  
    }

}