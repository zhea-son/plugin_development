<?php

include 'db.php';

$obj = new DB();

if(isset($_POST['btnInsert'])){
    $obj->insert("notes",['title'=>$_POST['title'], 'description'=>$_POST['description']]);
}
// echo "Insert Result is : ";


if(isset($_POST['btnUpdate'])){
    // print_r($_POST);
   $obj->update("notes",['title'=>$_POST['titleEdit'], 'description'=>$_POST['descriptionEdit']], "sn =". $_POST['snEdit']);
}
// echo "Updated Result is : ";

if(isset($_GET['deleteid'])){
    $obj->delete("notes","sn =". $_GET['deleteid']);
}
// echo "Deleted Result is : ";


// $obj->select('notes', '*', null, null, null, null);
$obj->sql('SELECT * FROM notes');
$result = $obj->getResult();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index Page</title>
</head>
<body>
    <form action="index.php" method="POST">
    <table>
        <tr>
            <td><label>Title</label></td>
            <td><input type="text" name="title"></td>
        </tr>
        <tr>
        <td><label>Description</label></td>
        <td><textarea row="3" type="text" name="description"></textarea></td>
        <tr>
        <tr><td colspan="2"><button name="btnInsert" role="submit">Add Note</button></td></tr>
    </table>
    </form>
    
    <h1>Table is:</h1>
    <table border="1">
        <thead>
            <th>SN</th>
            <th>Title</th>
            <th>Description</th>
            <th>Actions</th>
        </thead>
        <tbody>
            <?php $index=0; if(!empty($result)){
                foreach($result as list("sn"=>$sn,"title"=>$title, "description"=>$description)){
            $index += 1;
            echo "<tr>
            <td>$sn</td>
                <td>$title</td>
                <td>$description</td>
                <td>
                <button class='btn btn-warning'><a href='/plugin_development/php_oop/update.php?updateid=".$sn."' class='text-light'>Update</button>
                <button class='btn btn-danger'><a href='index.php?deleteid=".$sn."' class='text-light'>Delete</a></button>
                </td>
            </tr>";}
            }
            ?>
        </tbody>
    </table>

    
</body>
</html>