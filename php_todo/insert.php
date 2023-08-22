<?php

// $update = false;

      // Connection to the Database
      $servername = "localhost";
      $username = "root";
      $password = "";
      $database = "todo_php";

      $conn = mysqli_connect($servername, $username,$password,$database);

      if(!$conn){
        die("Connection was not established". mysqli_connect_error());
      }

      if($_SERVER['REQUEST_METHOD'] == "POST"){
        $title = $_POST['exampleFormControlInput1'];
        $description = $_POST['exampleFormControlTextarea1'];

        $query = "INSERT into notes(title,description) VALUES ('$title','$description')";
        $result = mysqli_query($conn, $query);

        if($result)
        {
          $insert = true;
        }else{
          // echo "Unable to insert". mysqli_error($conn);
          $insert = false;

        }      
      }

      header("Location: index.php");
        exit();

?>