<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
</head>
<body>
    <?php
        if(isset($error_message)){ 
    ?>
        <h1><?php echo $error_message ?></h1>
    <?php
        } else {
    ?>
        <h1>Hi There this is the error page.</h1>
    <?php 
        }
    ?>
</body>
</html>