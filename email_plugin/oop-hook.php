<?php

require_once('send-email-hook.php');
/*
 * Plugin Name:       Add Menu Plugin1
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Add Menu and Submenu and demonstrate the use of hooks, actions and filters
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Ranjan Khanal
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       custom-menu-page
 * Domain Path:       /languages
 */

class EmailSetup{
    function __construct(){
        add_action('admin_menu', array($this, 'add_menu'));
        add_filter('custom_email_content_filter', array($this, 'modify_email_content'));
        add_action('custom_email_content_action',  array($this, 'display_post_content'),10,2);

    }
    function add_menu(){
        add_menu_page("Test Email","Test Email","manage_options","test-email",array($this, 'add_contents'),"dashicons-email",26);
        add_submenu_page("test-email","Send Email","Send Email","manage_options","test-email",array($this, 'add_contents'),"dashicons-email-alt2");
        add_submenu_page("test-email","Send Content","Send Content","manage_options","send-content",array($this, 'add_contents2'),"dashicons-email-alt2");
    }

     function add_contents(){
        echo '<h1>This is inside SubMenu</h1>';
        echo '<form method="post">
        <table border="1">
            <tr><td><label>Email Subject</label></td><td><input type="text" name="subject"></td></tr>
            <tr><td><label>Email Content</label></td><td><input type="text" name="content"></td></tr>
            <tr><td><label>Send To</label></td><td><input type="email" name="send"></td></tr>
            <tr><td colspan="2"><button type="submit" name="sendTo">Send</button></td></tr>
            </table>
        </form>';

        if(isset($_POST['sendTo'])){
            if(!empty($_POST['content']) && !empty($_POST['subject']) && !empty($_POST['send'])){
            $email_content = apply_filters('custom_email_content_filter', $_POST['content']);
            $post_args = array(
                'post_title'   => $_POST['subject'],
                'post_content' => $email_content,
                'post_status'  => 'publish',
                'post_type'    => 'post', // You can change the post type if needed
            );
            $post_id = wp_insert_post($post_args);
            if($post_id){
                echo 'Post inserted with ID:'. $post_id . '<br>';
            }

            do_action('custom_email_content_action', $post_id, $_POST['send']);
            do_action('custom_email_send_action', $post_id, $_POST['send']);
        
            }else{
                echo '<h3>Something is wrong</h3>';
            }
        }
 }

 function add_contents2(){
    echo '<h1>This is inside SubMenu2</h1>';
 }

 function display_post_content($id, $email){
    if($id){
        $single_post = get_post($id);
        
        if ($single_post) {
            // Now you can access various properties of the post
            $post_title = $single_post->post_title;
            $post_content = $single_post->post_content;

            // You can do further processing with the retrieved post data
            echo 'Post Title: ' . $post_title . '<br>';
            echo 'Post Content: ' . $post_content . '<br>';
            echo 'Email is: '.$email.' <br>';
        } else {
            echo 'Post not found';
        }
    }else{
        echo 'Error creating/updating post.';
    }
 }

 function modify_email_content($content) {
    $modified_content = 'Modified: ' . $content;
    return $modified_content;
}
}

$obj = new EmailSetup();






