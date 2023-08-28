<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Development</title>
</head>
<body>
    <h1>User Registration</h1>
    <form action="options.php" method="post">
        <?php settings_fields('settings_group') ?>
        <?php do_settings_sections('user-registration') ?>
        <?php submit_button(); ?>
    </form>

    <script>

        
    </script>
</body>
</html>