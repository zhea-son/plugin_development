<?php

/*
 * Plugin Name:       Shortcode Form Redirection
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Redirect the submission form implementing shortcode template
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


 class ShortCode{
    public function __construct()
    {
        add_action('init', array($this, 'show_init'));
        add_action('user_save_data', array($this, 'save_data'));
        add_shortcode('greetings', 'show_greetings');

    }

    function show_init(){
        function show_greetings($atts){
            $atts = shortcode_atts(array(
                'redirect_after_registration' => '',
            ), $atts);
            if(isset($_POST['btnSubmit'])){
                do_action('user_save_data', $_POST);
            }
            return '
            <form action="" method="post">
        <table border="1">
            <tr>
                <td><label>Email</label></td>
                <td><input type="email" name="email" placeholder="Enter your email"/></td>
            </tr>
            <tr>
                <td><label>Password</label></td>
                <td><input type="password" name="password" placeholder="Enter your password"/></td>
            </tr>
            <tr>
                <td><label>Username</label></td>
                <td><input type="text" name="username" placeholder="Enter your username"/></td>
            </tr>
            <tr>
                <td><label>Display Name</label></td>
                <td><input type="text" name="display_name" placeholder="Enter your display_name"/></td>
            </tr>
            <tr>
                <td><label>First Name</label></td>
                <td><input type="text" name="fname" placeholder="Enter your fname"/></td>
            </tr>
            <tr>
                <td><label>Last Name</label></td>
                <td><input type="text" name="lname" placeholder="Enter your lname"/></td>
            </tr>
            <tr>
                <td><label>Role</label></td>
                <td><select name="role">
                    <option value="subscriber">Subscriber</option>
                    <option value="editor">Editor</option>
                    <option value="administrator">Administrator</option>
                </select>
                </td>
            </tr>
            <tr>
                <td colspan="2"><button role="submit" name="btnSubmit">Submit</button></td>
            </tr>
    
    
        </table>
        </form>';
        }
     }

     function save_data($args){
        $data = array(
            'user_pass' => $args['password'],
            'user_login' => $args['display_name'],
            'user_email' => $args['email'],
            'display_name' => $args['display_name'],
            'role' => $args['role'],
            'meta_input' => array(
                'first_name' => $args['fname'],
                'last_name' => $args['lname'],
            ),
        );
        $saved = wp_insert_user($data);
        if($saved){
            echo "Data saved successfully";
        }else{
            echo "Data saving unsuccessful";
        }
     }

 }

 $obj = new ShortCode();
