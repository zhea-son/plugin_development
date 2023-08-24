<?php

class Callback{

    public function add_section(){
        echo 'This is custom section for settings'; 
    }
    public function add_field(){
        echo '<input type="text" name="first_name" value="'. esc_attr(get_option('first_name')).'" placeholder="Enter First Name"/>';
    }
    public function add_radio(){
        $options = array(
            'option1' => "Male",
            'option2' => "Female",
        ); 
        $current = get_option('gender');
        foreach($options as $key => $value){
            echo '<input type="radio" name="gender" value="' . esc_attr($value) . '" ' . checked($current, $value, false) . '/>'.$value;
        }
    }
    public function add_dropdown(){
        $options = array(
            'option1' => "Nepal",
            'option2' => "India",
            'option3' => "China",
        ); 
        $current = get_option('country');
        echo '<select name="country" >';
        foreach($options as $key => $value){
            echo '<option value="'.$value.'" '.selected($current, $value, false).'>'.$value.'</option>';
        }
        echo '</select>';
        
    }
    public function add_textarea(){
        echo '<textarea rows="3" name="description">'. esc_attr(get_option('description')).'</textarea>';
    }
    public function add_checkbox(){
        $current_value = get_option('adult');
        echo '<input type="checkbox" name="adult" value="1" ' . checked($current_value, 1, false) . '>';
    }
    public function sanitize_new_settings($input){
        return sanitize_text_field($input);

    }
    
}