<?php

    //check if user is logged in or is guest
    if( is_user_logged_in() ) {
?>

<style>

        a {
            display:inline;
        }


</style>

<!-- form for filtering data  -->
    <form id="filter_form">
        <table>
        <tr>
            <td>
                <select name="rating_filter" id="rating_filter">
                    <option value="0"><?php echo __("Filter Rating", 'user-review-plugin'); ?></option>
                    <option value="1" <?php if( isset( $filter ) ) selected( $filter['rating_filter'], 1 ); ?>>1</option>
                    <option value="2" <?php if( isset( $filter ) ) selected( $filter['rating_filter'], 2 ); ?>>2</option>
                    <option value="3" <?php if( isset( $filter ) ) selected( $filter['rating_filter'], 3 ); ?>>3</option>
                    <option value="4" <?php if( isset( $filter ) ) selected( $filter['rating_filter'], 4 ); ?>>4</option>
                    <option value="5" <?php if( isset( $filter ) ) selected( $filter['rating_filter'], 5 ); ?>>5</option>
                </select>
            </td>
            <td>
                <div style="margin-top:10px;margin-left:50px;"><input id="latest_filter" type="checkbox" name="latest_filter"  <?php if( isset( $filter['latest_filter'] ) ) checked( $filter['latest_filter'], 1 ); ?>/><?php echo __("Latest", 'user-review-plugin'); ?></div>
            </td>
            <td>
                <button name="btnFilter" id="btnFilter" value="clicked"><?php echo __("Apply", 'user-review-plugin'); ?></button>
            </td>
        </tr>
        </table>
    </form>

    <table>
        <thead>
            <th><?php echo __("SN", 'user-review-plugin'); ?></th>
            <th><?php echo __("Full Name", 'user-review-plugin'); ?></th>
            <th><?php echo __("Email", 'user-review-plugin'); ?></th>
            <th><?php echo __("Rating", 'user-review-plugin'); ?></th>
            <th><?php echo __("Review Description", 'user-review-plugin'); ?></th>
        </thead>
        <tbody id="review_body">
            <?php if( empty( $user_query->results ) ){

                // if there is not reviews stored
                echo '<tr><td colspan="5">No Reviews Yet.</td></tr>';

                }else{ 
                    
            ?>

            <?php 
                // get reviews according to users
                $i = 0;
                foreach( $user_query->results as $user ){ 
                    $fname = get_user_meta( $user->ID, 'first_name', true );
                    $lname = get_user_meta( $user->ID, 'last_name', true );
                    $review = get_user_meta( $user->ID, 'user_review', true );
                    $rating = get_user_meta( $user->ID, 'user_rating', true );  
                    $i++;
                    
            ?>
                <tr><td><?php echo $i; ?></td>
                <td><?php echo esc_html( $fname ). ' ' .esc_html( $lname ); ?></td>
                <td><?php echo esc_html( $user->user_email ); ?></td>
                <td><?php echo esc_html( $rating ); ?></td>
                <td><?php echo esc_html( $review ); ?></td>


            <?php
                    }
                } 
            ?>
        </tbody>
    </table>

    <div id="pagination-content">
        <?php
            for( $i=1; $i <= ceil( $user_query->total_users / 5 ); $i++ ){ 
                if( $i == 1 ){
                    echo '<a href="#" class="pagination-link" id="page_no_'. $i .'" data-page="'. $i .'" style="color:red;text-decoration:none;">'. $i .' </a>';
                }else{
                    echo '<a href="#" class="pagination-link" id="page_no_'. $i .'" data-page="'. $i .'">'. $i .' </a>';
                }
            
            } 
        ?>
    </div>

<?php       
    }else{ 
?>
        <h3>Please Login First</h3>
        <a href="<?php echo home_url( '/wp-login.php' ); ?>"><?php echo __("Click Here!", 'user-review-plugin') ?></a>

<?php } ?>
