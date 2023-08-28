<?php

class CallBack{
    public function __construct(){


    }

    public function menu_page_callback(){
        add_menu_page("User Registration","User Registration", "manage_options","user-registration",array($this,'menu_page_display'),'',10);
    }
    public function menu_page_display(){
        require_once('template.php');
    }
    public function sanitize_callback($input){
        return sanitize_text_field($input);
    }
    public function register_settings_function(){
        register_setting('settings_group', 'settings', array($this, 'sanitize_callback'));
    }
    public function register_init_function(){
        $this->register_settings_function();

        add_settings_section('settings_index','New User', array($this, 'add_section'),'user-registration');

        $args = array('label_for' => 'first_name', 'class' => '');
        add_settings_field('first_name','First Name', array($this, 'add_field'),'user-registration','settings_index', $args);
    }
    public function add_section(){
        echo "This is user resgistration section";
    }
    public function add_field(){
        echo '<input type="text" placeholder="Enter First Name" id="first_name" name="first_name" >';
    }


}