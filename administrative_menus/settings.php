<?php

function custom_settings_page() {
    ?>
    <div class="wrap">
        <h2>Custom Settings</h2>
        <form method="post" action="options.php">
            <?php
            settings_fields('custom-settings-group');
            do_settings_sections('custom-settings-page');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function custom_settings_init() {
    add_settings_section(
        'custom-settings-section', // Section ID
        'Custom Settings Section', // Section Title
        'custom_settings_section_callback', // Callback function to display section description
        'custom-settings-page' // Page slug where the section should be displayed
    );

    add_settings_field(
        'radio-field', // Field ID
        'Radio Field', // Field Label
        'radio_field_callback', // Callback function to display the field
        'custom-settings-page', // Page slug
        'custom-settings-section' // Section ID
    );

    add_settings_field(
        'checkbox-field', // Field ID
        'Checkbox Field', // Field Label
        'checkbox_field_callback', // Callback function to display the field
        'custom-settings-page', // Page slug
        'custom-settings-section' // Section ID
    );

    add_settings_field(
        'textarea-field', // Field ID
        'Textarea Field', // Field Label
        'textarea_field_callback', // Callback function to display the field
        'custom-settings-page', // Page slug
        'custom-settings-section' // Section ID
    );

    add_settings_field(
        'dropdown-field', // Field ID
        'Dropdown Field', // Field Label
        'dropdown_field_callback', // Callback function to display the field
        'custom-settings-page', // Page slug
        'custom-settings-section' // Section ID
    );

    register_setting('custom-settings-group', 'custom-settings-group');
}

function custom_settings_section_callback() {
    echo '<p>Section description goes here.</p>';
}

function radio_field_callback() {
    echo '<input type="radio" name="custom-settings-group[radio-field]" value="option1"> Option 1';
    echo '<input type="radio" name="custom-settings-group[radio-field]" value="option2"> Option 2';
}

function checkbox_field_callback() {
    echo '<input type="checkbox" name="custom-settings-group[checkbox-field]" value="1"> Check me';
}

function textarea_field_callback() {
    echo '<textarea name="custom-settings-group[textarea-field]" rows="5" cols="50"></textarea>';
}

function dropdown_field_callback() {
    $options = array(
        'option1' => 'Option 1',
        'option2' => 'Option 2',
        'option3' => 'Option 3',
    );
    echo '<select name="custom-settings-group[dropdown-field]">';
    foreach ($options as $value => $label) {
        echo '<option value="' . $value . '">' . $label . '</option>';
    }
    echo '</select>';
}

    add_action('admin_init', 'custom_settings_init');
add_action('admin_menu', function() {
    add_options_page('Custom Settings', 'Custom Settings', 'manage_options', 'custom-settings-page', 'custom_settings_page');
});
