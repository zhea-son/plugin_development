<?php

require_once('callback.php');


class UserRegistration{
    private $callback;
    public function __construct(){
        $this->callback = new CallBack(); 
        add_action('admin_menu',array($this->callback,'menu_page_callback'));

        add_action('admin_init', array($this->callback, 'register_init_function'));

    }


    

}
