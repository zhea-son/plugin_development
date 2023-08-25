<?php

get_header();
while(have_posts()):
    the_post();

    echo '<h1>'. get_the_title(). '</h1>';
    the_content();

endwhile;

get_footer();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Page</title>
</head>
<body>
    
</body>
</html>