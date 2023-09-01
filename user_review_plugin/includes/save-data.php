<?php

// For first line of defense (security)
if(!defined('ABSPATH')){
    die("You cannot be here!");
}



class SaveData{

    public function __construct(){


        $this->init_hooks();

        $this->save_user_data();

    }

    public function init_hooks(){
        
        //custom hooks to extract username and send email
        add_filter('extract_username_hook', array($this, 'extract_username_callback'));
        add_action('send_email_hook', array($this, 'send_email_callback'),10,2);
        
    }

    

    public function save_user_data(){
        
        // check if user email field is empty
        if(isset($_POST['btnSubmit']) && !empty($_POST['user_email'])){
            
            $user = get_user_by('email', $_POST['user_email']);
            
            if($user)
            {
                wp_enqueue_script('display-emailexists-notification',PLUGIN_URL . '/assets/js/notification.js', [], '1.0', true );
            }
            else
            {

                // extract username from hook
                $username = apply_filters('extract_username_hook', $_POST['user_email']);
                
                // if username extracted not empty and username extracted is not valid
                if(!empty($username) && (str_replace('_',' ', $username) != ' ')){
                    
                    // check if none of the fields are empty
                    if(!empty($_POST['user_password']) && !empty($_POST['f_name']) && !empty($_POST['l_name']) && !empty($_POST['user_review']) && !empty($_POST['rating']))
                    {

                        if(check_admin_referer('user_review_nonce')){

                            
                            $data = array(
                                'user_pass' => $_POST['user_password'],
                                'user_login' => $username,
                                'user_email' => sanitize_email($_POST['user_email']),
                                'display_name' => $username,
                                'role' => "subscriber",
                                'meta_input' => array(
                                    'first_name' => sanitize_text_field($_POST['f_name']),
                                    'last_name' => sanitize_text_field($_POST['l_name']),
                                    'user_review' => sanitize_textarea_field($_POST['user_review']),
                                    'user_rating' => $_POST['rating']
                                ),
                            );
                        }else{
                            wp_die('Nonce Verification Failed', 'Nonce Error');
                        }
                            
                        // insert user
                        $saved = wp_insert_user($data);
        
                        if($saved){

                            // send mail 
                            do_action('send_email_hook', $data['user_email'], $data['user_login']);

                            wp_enqueue_script('display-userregistered-notification',PLUGIN_URL . '/assets/js/notification.js', [], '1.0', true );
                            
                            // redirect to reviews table page
                            wp_redirect(esc_url_raw(add_query_arg(array())));


                        }
                        
                        else{
                            wp_enqueue_script('display-insertionerror-notification',PLUGIN_URL . '/assets/js/notification.js', [], '1.0', true );

                        }

                    }

                    else
                    {
                        wp_enqueue_script('display-nodata-notification',PLUGIN_URL . '/assets/js/notification.js', [], '1.0', true );
                        
                    }
                }
                
                else
                {
                    wp_enqueue_script('display-novalidemail-notification',PLUGIN_URL . '/assets/js/notification.js', [], '1.0', true );

                }
            }
        }

        elseif (isset($_POST['btnSubmit']) && empty($_POST['user_email'])){
            
            wp_enqueue_script('display-noemail-notification',PLUGIN_URL . '/assets/js/notification.js', [], '1.0', true );

        }
        
    }

    // Extract username from email function
    public function extract_username_callback($email){

        // sanitize email
        $sanitized_email = sanitize_email($email);

        // extract string before @ and replace .(dot) with _(underscore)
        $username = str_replace('.', '_', strstr($sanitized_email, '@', true));

        return $username;
    }

    public function send_email_callback($email, $uname){

        $to = $email;
        $subject = 'User Registration Successful';
        $message = 'User has been successfully registered with Username: '. $uname. ' and the review has been stored.';

        // send mail using wp_mail smtp
        wp_mail($to, $subject, $message);
    }
    
    
}