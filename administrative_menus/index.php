<?php

require_once('Callback.php');

/*
 * Plugin Name:       Administrative Menus and Settings API
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Add Menu and Sub Menus with use of Settings API
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

 class Menus{
    public $callback;
    public function __construct(){
        add_action('admin_menu', array($this, 'create_top_menu'));

        //Register Settings

        // Register Section
        add_action('admin_init', array($this, 'init_function'));
        
        $this->callback = new Callback();
        // container of all the fields to print 
        

        // Register Fields

        // Declare your custom field
    }

    public function create_top_menu(){
        add_menu_page(
            "Movie",
            "Movie",
            "manage_options",
            "dashboard-page",
            array($this, 'add_dashboard_page'),
            '',
            10
        );
        add_submenu_page("dashboard-page", "Dashboard", "Dashboard", "manage_options", "dashboard-page", array($this, 'add_dashboard_page'));
        add_submenu_page("dashboard-page", "Settings", "Settings", "manage_options", "settings-page", array($this, 'add_settings_page'));
    }

    public function add_movie_page(){
        
        echo '<table>
        <form action="" method="post">
            <label>Enter Page Name</label>
            <input type="text" name="page_name">
            <button name="btnInsert" role="submit">Add</button>
            </form>
        </table>';
    }
    public function add_dashboard_page(){
        echo '<h2>This is Dashboard Page</h2>';    
        echo bloginfo('name');

    }
    public function add_settings_page(){
        require_once('view.php');
    }

    public function register_custom_settings(){
        register_setting('new_settings_group','first_name',array($this->callback, 'sanitize_new_settings'));
        register_setting('new_settings_group','gender',array($this->callback, 'sanitize_new_settings'));
        register_setting('new_settings_group','description',array($this->callback, 'sanitize_new_settings'));
        register_setting('new_settings_group','country',array($this->callback, 'sanitize_new_settings'));
        register_setting('new_settings_group','adult',array($this->callback, 'sanitize_new_settings'));
        
    }

    public function init_function(){
        $this->register_custom_settings();
        add_settings_section('settings_index','New Settings', array($this->callback, 'add_section'),'settings-page');

        $args = array('label_for' => 'first_name', 'class' => '');
        add_settings_field('first_name','First Name', array($this->callback, 'add_field'),'settings-page','settings_index', $args);
        $args = array('label_for' => 'Gender', 'class' => '');
        add_settings_field('gender','Gender', array($this->callback, 'add_radio'),'settings-page','settings_index', $args);
    
        $args = array('label_for' => 'Over 18', 'class' => '');
        add_settings_field('adult','Over 18', array($this->callback, 'add_checkbox'),'settings-page','settings_index', $args);
    
        $args = array('label_for' => 'Description', 'class' => '');
        add_settings_field('description','Description', array($this->callback, 'add_textarea'),'settings-page','settings_index', $args);
    
        $args = array('label_for' => 'Country', 'class' => '');
        add_settings_field('country','Country', array($this->callback, 'add_dropdown'),'settings-page','settings_index', $args);
    
        
    
    
    }
    
    
 }

 $obj = new Menus();
