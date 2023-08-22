<?php

// $insert = false;

      // Connection to the Database
      $servername = "localhost";
      $username = "root";
      $password = "";
      $database = "todo_php";

      $conn = mysqli_connect($servername, $username,$password,$database);

      if(!$conn){
        die("Connection was not established". mysqli_connect_error());
      }else{
        if($_SERVER['REQUEST_METHOD'] == "POST"){
        $title = $_POST['title'];
        $description = $_POST['description'];
        $sn = $_POST['sn'];
        
        $query = "UPDATE notes SET title = '$title' , description = '$description' WHERE sn = $sn";
        $result = mysqli_query($conn, $query);

        if($result)
        {
            echo 'success';
        }else{
          echo "Unable to insert". mysqli_error($conn);
          // echo 'failed';
        }  
           
      }
    }
       
      $conn->close();


?>