<?php

include 'db.php';

$obj = new DB();

$obj->select('notes', "*", null, "sn=".$_GET['updateid'], null, null);
$result = $obj->getResult();
$title = $result[0]['title'];
$description = $result[0]['description'];
$sn = $result[0]['sn'];
// echo $description;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="index.php" method="POST">
        <table>
            <tr>
                <td><label>Title</label></td>
                <td><input type="text" name="titleEdit" value=<?= $title ?>></td>
            </tr>
            <tr>
            <td><label>Description</label></td>
            <td><textarea row="3" type="text" name="descriptionEdit"><?php echo $description ?></textarea></td>
            <tr>
            <input type="hidden" name="snEdit" value=<?php echo $sn?>>
            <tr><td colspan="2"><button name="btnUpdate" role="submit">Add Note</button></td></tr>
        </table>
        </form>
</body>
</html>