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
    <title>User Registration</title>

    <style>
        .notification-content{
            background:teal;
            display:none;
            height:50px;
        }
        .notification-content p{
            color:white;
            font-size:15px;
            padding-top:10px;
            text-align:center;
            float:left;
        }
        .close-content{
            float:right;
        }
    </style>
    <script></script>
</head>
<body>

    <div class="notification-content">
        <p id="message"></p>
        <div class="close-content"><button>x</button></div>
    </div>


    <form method="post" id="register_form">
        <table>
            <tr>
                <td><label>Email</label></td>
                <td><input type="email" name="user_email" placeholder="username@gmail.com" /></td>
            </tr>
            <tr>
                <td><label>Password</label></td>
                <td><input type="password" name="user_password" placeholder="Password" /></td>
            </tr>
            <tr>
                <td><label>First Name</label></td>
                <td><input type="text" name="f_name" placeholder="First Name" /></td>
            </tr>
            <tr>
                <td><label>Last Name</label></td>
                <td><input type="text" name="l_name" placeholder="Last Name" /></td>
            </tr>
            <tr>
                <td><label>Review Product</label></td>
                <td><textarea rows="5" name="user_review" placeholder="Please give a review for our product" ></textarea></td>
            </tr>
            <tr>
                <td><label>Rating (star)</label></td>
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
                    <button role="submit" name="btnSubmit">Submit</button>
                </td>
            </tr>

        </table>
    </form>

    
</body>
</html>