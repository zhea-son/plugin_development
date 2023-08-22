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
        $sn = $_POST['sn'];
        $query = "DELETE FROM notes WHERE sn = $sn";
        // echo $query;
        $result = mysqli_query($conn, $query);
        if($result)
        {
            echo 'success';

        }else{
          // echo "Unable to insert". mysqli_error($conn);
          echo 'failed';


        }  
      }
    }
       
      $conn->close()

?>