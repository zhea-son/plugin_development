<?php 

/*
 * Plugin Name:       Custom Post Type Example 
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Build Movie Custom Post Type
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

class CPT{
    public function __construct()
    {
        add_action('init', array($this, 'create_custom_post_type'));
        add_action( 'add_meta_boxes', array($this, 'add_custom_box') );
        add_action( 'save_post', array($this, 'save_custom_data') );
    }

    public function create_custom_post_type(){
        $args = array(
			'labels'      => array(
				'name'          => __('Movies'),
				'singular_name' => __('Movie'),
				'menu_name' => __('Movie'),
				'name_admin_bar' => __('Movie'),
				'add_new' => __('Add Movie'),
				'add_new_item' => __('Add New Movie'),
				'new_item' => __('New Movie'),
				'edit_item' => __('Edit Movie'),
				'view_item' => __('View Movie'),
				'all_items' => __('All Movies'),
				'search_items' => __('Search Movies'),
                'parent_item_colon' => '' ,
				'not_found' => __('Movie not Found'),
                'not_found_in_trash' => '',
			),
				'public'      => true,
				'has_archive' => true,
		
	);
        register_post_type('movie', $args);
    }

    public function add_custom_box() {
           add_meta_box(
               'post_custom_id',                 
               'Extra Fields MetaBox for Movie',      
               array($this, 'custom_box_html'),  
               'movie',
               'normal',
           );
   }

   public function custom_box_html( $post ) {
    $date_value = get_post_meta($post->ID, 'date', true);
    $director_value = get_post_meta($post->ID, 'director', true);
    $cast_value = get_post_meta($post->ID, 'cast', true);
	?>
    
	<input type="text" name="date" placeholder="Enter date" value="<?php echo $date_value ?>" /><br>
	<input type="text" name="director" placeholder="Enter director" value="<?php echo $director_value ?>" /><br>
	<input type="text" name="cast" placeholder="Enter cast" value="<?php echo $cast_value ?>" /><br>
    
	<?php
}

public function save_custom_data( $post_id ){
    if(array_key_exists('date', $_POST) && array_key_exists('cast', $_POST) && array_key_exists('director', $_POST)){
        update_post_meta(
            $post_id,
            'date',
            $_POST['date']
        );
        update_post_meta(
            $post_id,
            'cast',
            $_POST['cast']
        );
        update_post_meta(
            $post_id,
            'director',
            $_POST['director']
        );
    }

}
}

$obj = new CPT();