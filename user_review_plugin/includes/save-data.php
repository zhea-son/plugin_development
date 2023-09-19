<?php

// For first line of defense (security)
if( ! defined('ABSPATH') ){
    die( __("You cannot be here!", 'user-review-plugin') );
}



class SaveData{

    // property to initialize notification message
    private $notiMessage = array();

    public function __construct() {

        $this->init_hooks();

        $this->save_user_data();

    }

    public function init_hooks() {
        
        //custom hooks to extract username and send email
        add_filter( 'extract_username_hook' , array( $this, 'extract_username_callback' ) );
        add_action( 'send_email_hook', array( $this, 'send_email_callback' ), 10, 2 );

        // action hook to enqueue scripts
        add_action( 'wp_enqueue_scripts', array( $this, 'show_notification' ) );
        
    }


    /** 
     * Enqeue and Localize script for notification
    */
    public function show_notification() {

        wp_enqueue_script( 'display-notification', PLUGIN_URL . '/assets/js/notification.js', ['jquery'], '1.0', true );

        wp_localize_script(
            'display-notification', 'objNot', $this->notiMessage
        );
    }

    
    /** 
     * process review registration form and store user data
    */
    public function save_user_data() {
        
        // check if user email field is empty
        if( isset( $_POST['btnSubmit'] ) && !empty( $_POST['user_email'] ) ) {
            
            // get user using user email
            $user = get_user_by( 'email', $_POST['user_email'] );
            
            // check if user already exists
            if($user)
            {
                $this->notiMessage['message'] = __("User already exists", 'user-review-plugin');
            }
            else
            {

                // extract username from extract_username_hook
                $username = apply_filters( 'extract_username_hook', $_POST['user_email'] );
                
                // if username extracted not empty and username extracted is not valid
                if( ! empty( $username ) && ( str_replace('_',' ', $username) != ' ') ) {
                    
                    // check if none of the fields are empty
                    if( ! empty( $_POST['user_password'] ) && ! empty( $_POST['f_name'] ) && ! empty( $_POST['l_name'] ) && ! empty( $_POST['user_review'] ) && ! empty( $_POST['rating'] ) )
                    {

                        // check nonce for registering action
                        if( check_admin_referer( 'user_review_nonce' ) ) {

                            // data arguments for user to be saved 
                            $data = array(
                                'user_pass' => sanitize_text_field( $_POST['user_password'] ),
                                'user_login' => sanitize_text_field( $username ),
                                'user_email' => sanitize_email( $_POST['user_email'] ),
                                'display_name' => sanitize_text_field( $username ),
                                'role' => sanitize_text_field( "subscriber" ),
                                'meta_input' => array(
                                    'first_name' => sanitize_text_field( $_POST['f_name'] ),
                                    'last_name' => sanitize_text_field( $_POST['l_name'] ),
                                    'user_review' => sanitize_textarea_field( $_POST['user_review'] ),
                                    'user_rating' => sanitize_text_field( $_POST['rating'] )
                                ),
                            );
                        }
                        
                        else {

                            // die if nonce is not verified for user registration action
                            wp_die( 'Nonce Verification Failed', 'Nonce Error' );
                        }
                            
                        // insert user
                        $saved = wp_insert_user( $data );
        
                        if( $saved ) {

                            // send mail 
                            do_action( 'send_email_hook' , $data['user_email'] , $data['user_login'] );

                            $this->notiMessage['message'] = __("User and Review Registered Successfully", 'user-review-plugin');
             
                            // redirect to reviews table page
                            wp_redirect( esc_url_raw( add_query_arg( array() ) ) );


                        }
                        
                        else {

                            $this->notiMessage['message'] = __("Error while storing User", 'user-review-plugin');
            
                        }

                    }

                    else
                    {
                        $this->notiMessage['message'] = __("Please enter all valid data.", 'user-review-plugin');
                    }
                }
                
                else {
                    $this->notiMessage['message'] = __("Please enter valid user email", 'user-review-plugin');
                }
            }
        }

        elseif ( isset( $_POST['btnSubmit'] ) && empty( $_POST['user_email'] ) ) {

            $this->notiMessage['message'] = __("Please enter user email", 'user-review-plugin');

        }
        
    }

    // Extract username from email function
    public function extract_username_callback( $email ) {

        // sanitize email
        $sanitized_email = sanitize_email( $email );

        // extract string before @ and replace .(dot) with _(underscore)
        $username = str_replace( '.', '_', strstr( $sanitized_email, '@', true ) );

        return $username;
    }

    public function send_email_callback( $email, $uname ) {

        $to = $email;
        $subject = __('User Registration Successful', 'user-review-plugin');
        $message = __('User has been successfully registered with Username: '. $uname. ' and the review has been stored.', 'user-review-plugin');

        // send mail to registered user
        wp_mail( $to, $subject, $message );
    }
    
    
}