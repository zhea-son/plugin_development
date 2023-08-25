<?php 

/*
 * Plugin Name:       Custom Taxonomies Example 
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Working with custom taxonomies
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

class CustomTaxonomy{

    public function __construct(){
        add_action('init', array($this, 'add_custom_taxonomy'));


    }

    public function add_custom_taxonomy(){
        $labels = array(
            'name' => __('Genres'),
            'singular_name'     => __( 'Genre'),
		 'search_items'      => __( 'Search Genres' ),
		 'all_items'         => __( 'All Genres' ),
		 'parent_item'       => __( 'Parent Genre' ),
		 'parent_item_colon' => __( 'Parent Genre:' ),
		 'edit_item'         => __( 'Edit Genre' ),
		 'update_item'       => __( 'Update Genre' ),
		 'add_new_item'      => __( 'Add New Genre' ),
		 'new_item_name'     => __( 'New Genre Name' ),
		 'menu_name'         => __( 'Genre' ),
        );

        $args=array(
            'labels' => $labels,
            'hierarchical' => false,
            'show_admin_column' => true,
            'show_ui'           => true,
            'public' => true,
        );

        register_taxonomy('genre', ['movie'], $args);
        print_r(get_terms(['taxonomy'=>'genre','hide_empty'=>false]));


        // register_taxonomy('fruit', ['movie'], $args);
    }


}

$obj = new CustomTaxonomy();
print_r(get_terms(['taxonomy' => 'genre']));
