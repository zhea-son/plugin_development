<?php

// For first line of defense (security)
if(!defined('ABSPATH')){
    die("You cannot be here!");
}

/*
 * Plugin Name:       User Review Plugin
 * Description:       Handle the basics with this plugin. Use [registrationform] for User and Review Registration. Use [reviews] to view reviews.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Ranjan Khanal TG
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       user-review-plugin
 * Domain Path:       /languages
 */

// If a class named UserReview doesn't exist, create one

if(!class_exists('UserReview')){

    class UserReview{

        private $form; 
        private $user; 
        private $grid; 
        private $ajax_filters; 
        private $notification; 

        public function __construct(){

            $this->init_hooks();

            $this->define_constants();

            $this->includes();


        }

        public function initialize(){
            $this->form = new FormDisplay();
            $this->user = new SaveData();
            $this->grid = new GridDisplay();
            $this->ajax_filters = new AjaxFilter();
            $this->notification = new Notification();
        }


        public function init_hooks(){
            add_action('init',array($this, 'initialize'));
            add_action('plugins_loaded',array($this, 'load_textdomain'));
        }

        private function define_constants(){

            define('MY_PLUGIN_PATH', dirname( __FILE__ ));
            define('PLUGIN_URL', plugins_url('',__FILE__));

        }

        private function includes(){

            require_once MY_PLUGIN_PATH . '/includes/form-display.php';
            require_once MY_PLUGIN_PATH . '/includes/save-data.php';
            require_once MY_PLUGIN_PATH . '/includes/grid-display.php';
            require_once MY_PLUGIN_PATH . '/includes/ajax-filter.php';
            require_once MY_PLUGIN_PATH . '/includes/show-notification.php';

        }

        public function load_textdomain(){
            load_plugin_textdomain('user-review-plugin', false, dirname(plugin_basename(__FILE__)) . '/languages/');
        }
       

    }

    new UserReview();

}