<?php  

/*
 * Plugin Name: HELLO WORLD
 * Description: This is my first plugin to get started.
 * Version:     1.10.3
 * Author:      Ranjan Khanal
 * License:     GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// Remove the admin bar from the front end
add_filter( 'show_admin_bar', '__return_false' );

// Display welcome message 
add_action('wp_body_open', 'hello_user');

function hello_user(){
    echo "<h2 class='ok'>Hello User! This is the ". get_bloginfo('name'). "</h2>";
}

// Add css to the message
add_action('wp_print_styles', 'add_css');

function add_css(){
    echo '<style>
        h2.ok{color:#fff,margin:auto;text-align:center;background:orange;}
    </style>';
}

