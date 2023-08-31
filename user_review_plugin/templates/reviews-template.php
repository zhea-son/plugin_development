<?php

    //check if user is logged in or is guest
    if(is_user_logged_in()){
?>


<!-- form for filtering data  -->
    <form id="filter_form">
        <table>
        <tr>
            <td>
                <select name="rating_filter">
                    <option value="0">Filter Rating</option>
                    <option value="1" <?php if(isset($filter)) selected($filter['rating_filter'], 1) ?>>1</option>
                    <option value="2" <?php if(isset($filter)) selected($filter['rating_filter'], 2) ?>>2</option>
                    <option value="3" <?php if(isset($filter)) selected($filter['rating_filter'], 3) ?>>3</option>
                    <option value="4" <?php if(isset($filter)) selected($filter['rating_filter'], 4) ?>>4</option>
                    <option value="5" <?php if(isset($filter)) selected($filter['rating_filter'], 5) ?>>5</option>
                </select>
            </td>
            <td>
                <div style="margin-top:10px;margin-left:50px;"><input type="checkbox" name="latest_filter"  <?php if(isset($filter['latest_filter'])) checked($filter['latest_filter'], 1) ?>/>Latest</div>
            </td>
            <td>
                <button type="submit" name="btnFilter" value="clicked">Apply</button>
            </td>
        </tr>
        </table>
    </form>

    <table>
        <thead>
            <th>SN</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Rating</th>
            <th>Review Description</th>
            <th>Registered</th>
        </thead>
        <tbody id="review-body">
            <?php if(empty($user_query->results)){

                // if there is not reviews stored
                echo '<tr><td colspan="5">No Reviews Yet.</td></tr>';

            }else{ ?>
            <?php 
                // get reviews according to users
                $i = 0;
                foreach($user_query->results as $user){ 
                    $fname = get_user_meta($user->ID, 'first_name', true);
                    $lname = get_user_meta($user->ID, 'last_name', true);
                    $review = get_user_meta($user->ID, 'user_review', true);
                    $rating = get_user_meta($user->ID, 'user_rating', true);  
                    $registered = new DateTime($user->user_registered); 
                    $i++;
                    
            ?>
            <tr><td><?php echo $i; ?></td>
            <td><?php echo esc_html($fname). ' ' .esc_html($lname); ?></td>
            <td><?php echo esc_html($user->user_email); ?></td>
            <td><?php echo esc_html($rating); ?></td>
            <td><?php echo esc_html($review); ?></td>
            <td><?php echo $registered->format('jS F, H:i'); ?></td></tr>


            <?php
                    }
                } 
            ?>
        </tbody>
    </table>

    <div class="pagination-content">
    <?php for($i=1; $i<=ceil($user_query->total_users / 5);$i++){ 
        echo '<a href="?page='.$i.'" class="pagination-link" >'.$i.' </a>';
        
    } ?>
    </div>

    <?php
    
        echo paginate_links( array(
            'format' => '?paged=%#%',
            'total' => ceil($user_query->total_users / 5),
            'paged' => $paged
        ) ); 
    ?>

    

        <?php        }else{ ?>
            <h3>Please Login First</h3>
            <a href="<?php echo home_url('/wp-login.php'); ?>">Click here!</a>

            <?php } ?>
