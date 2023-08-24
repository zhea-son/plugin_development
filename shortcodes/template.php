<?php



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shortcode</title>
</head>
<body>
    <form action="" method="post">
    <table border="1">
        <tr>
            <td><label>Email</label></td>
            <td><input type="email" name="email" placeholder="Enter your email"/></td>
        </tr>
        <tr>
            <td><label>Password</label></td>
            <td><input type="password" name="password" placeholder="Enter your password"/></td>
        </tr>
        <tr>
            <td><label>Username</label></td>
            <td><input type="username" name="username" placeholder="Enter your username"/></td>
        </tr>
        <tr>
            <td><label>Display Name</label></td>
            <td><input type="display_name" name="display_name" placeholder="Enter your display_name"/></td>
        </tr>
        <tr>
            <td><label>First Name</label></td>
            <td><input type="fname" name="fname" placeholder="Enter your fname"/></td>
        </tr>
        <tr>
            <td><label>Last Name</label></td>
            <td><input type="lname" name="lname" placeholder="Enter your lname"/></td>
        </tr>
        <tr>
            <td><label>Role</label></td>
            <td><select name="role">
                <option value="">Subscriber</option>
                <option value="">Editor</option>
                <option value="">Administrator</option>
            </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><button role="submit" name="btnSubmut">Submit</button></td>
        </tr>


    </table>
    </form>

</body>
</html>