<?php


/*
 * Plugin Name:       Add MetaBox 
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Add Metaboxes
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


 class Metabox{
    public function __construct(){
        add_action( 'add_meta_boxes', array($this, 'add_custom_box') );
        add_action( 'save_post', array($this, 'save_custom_data') );
    }
     public function add_custom_box() {
        $screens = ['post','comment'];
           add_meta_box(
               'post_custom_id',                 
               'Extra Fields MetaBox for Post',      
               array($this, 'custom_box_html'),  
               $screens,
           );
   }

   public function custom_box_html( $post ) {
    $location_value = get_post_meta($post->ID, 'location', true);
    $genre_value = get_post_meta($post->ID, 'genre', true);
    $process_value = get_post_meta($post->ID, 'process', true);
	?>
    
	<input type="text" name="location" placeholder="Enter location address" value="<?php echo $location_value ?>" /><br>
    <textarea name="process" rows="4" ><?php echo $process_value ?></textarea> <br>
	<select name="genre" id="genre" class="postbox">
		<option value="">-- Select Difficulty</option>
		<option value="easy"<?php selected( $genre_value, 'easy' ); ?>>Easy</option>
		<option value="difficult"<?php selected( $genre_value, 'difficult' ); ?>>Difficult</option>
	</select>
	<?php
}

public function save_custom_data( $post_id ){
    if(array_key_exists('location', $_POST) && array_key_exists('process', $_POST) && array_key_exists('genre', $_POST)){
        update_post_meta(
            $post_id,
            'location',
            $_POST['location']
        );
        update_post_meta(
            $post_id,
            'process',
            $_POST['process']
        );
        update_post_meta(
            $post_id,
            'genre',
            $_POST['genre']
        );
    }

}
 }


 $obj = new Metabox();
