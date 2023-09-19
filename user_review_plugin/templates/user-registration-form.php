<?php

// For first line of defense (security)
if(!defined('ABSPATH')){
    die("You cannot be here!");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href= "<?php echo PLUGIN_URL; ?>/assets/css/main.css">
    
</head>
<body>

    <div class="notification-content">
        <p id="message">Oh my gwad</p>
        <div class="close-content"><button>x</button></div>
    </div>


    <form method="post" id="register_form">
        <table>
            <?php wp_nonce_field( 'user_review_nonce' ); ?>
            <tr>
                <td><label><?php echo __("Email", 'user-review-plugin') ?></label></td>
                <td><input type="email" name="user_email" placeholder="username@gmail.com" /></td>
            </tr>
            <tr>
                <td><label><?php echo __("Password", 'user-review-plugin') ?></label></td>
                <td><input type="password" name="user_password" placeholder="Password" /></td>
            </tr>
            <tr>
                <td><label><?php echo __("First Name", 'user-review-plugin') ?></label></td>
                <td><input type="text" name="f_name" placeholder="First Name" /></td>
            </tr>
            <tr>
                <td><label><?php echo __("Last Name", 'user-review-plugin') ?></label></td>
                <td><input type="text" name="l_name" placeholder="Last Name" /></td>
            </tr>
            <tr>
                <td><label><?php echo __("Review Product", 'user-review-plugin') ?></label></td>
                <td><textarea rows="5" name="user_review" placeholder="Please give a review for our product" ></textarea></td>
            </tr>
            <tr>
                <td><label><?php echo __("Rating", 'user-review-plugin') ?></label></td>
                <td>
                    <select name="rating">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <button role="submit" name="btnSubmit"><?php echo __("Submit", 'user-review-plugin') ?></button>
                </td>
            </tr>

        </table>
    </form>

    
</body>
</html>