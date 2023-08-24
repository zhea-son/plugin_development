<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Settings</title>
</head>
<body>
    <h1>Settings Page</h1>

    <p>This is the Settings Page</p>

    <form action="options.php" method="post">
        <?php settings_fields('new_settings_group') ?>
        <?php do_settings_sections('settings-page') ?>
        <?php submit_button(); ?>
    </form>
</body>
</html>