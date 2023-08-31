<?php

// For first line of defense (security)
if(!defined('ABSPATH')){
    die("You cannot be here!");
}

class AjaxFilter{

    public $grid;
    public function __construct(){

        $this->init_hooks();

        require_once MY_PLUGIN_PATH . '/includes/grid-display.php';
        
        $this->grid = new GridDisplay();
        
    }

    public function init_hooks(){

        add_action('wp_enqueue_scripts', array($this, 'enqueue_ajax_filter_scripts'));

        add_action('wp_ajax_filter_user_reviews', array($this, 'process_filter_user_reviews'));
        add_action('wp_ajax_nopriv_filter_user_reviews', array($this, 'process_filter_user_reviews'));

        add_action('wp_ajax_process_pagination', array($this->grid, 'display_grid_template'));
        add_action('wp_ajax_nopriv_process_pagination', array($this->grid, 'display_grid_template'));

    }

    public function enqueue_ajax_filter_scripts(){
        wp_enqueue_script('custom-ajax-script', PLUGIN_URL . '/assets/js/main.js', [], '1.0', true);
        wp_localize_script('custom-ajax-script', 'ajaxObj', array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('reviews_nonce'),
            )
        );
    }

    public function process_filter_user_reviews(){
        if(isset($_POST['btnFilter'])){    
            echo json_encode($_POST);
        }
    }

    public function process_pagination(){
        


        require_once MY_PLUGIN_PATH.'/templates/reviews-template.php';

        echo json_encode(array('success' => true, 'user_query' => $user_query));
    }

}