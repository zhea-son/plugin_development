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

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>PHP Todo</title>

    
  </head>
  <body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Navbar</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
          <a class="nav-link" href="#">Features</a>
          <a class="nav-link" href="#">Pricing</a>
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </div>
      </div>
    </div>
  </nav>

  <div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your notes has been inserted succesfully.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>

    <h1 class="text-center">TODO App</h1>

    <div class="container">
      <form action="/plugin_development/php_todo/insert.php" method="post">
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Title</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" name="exampleFormControlInput1" placeholder="Enter TODO">
      </div>
      <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Description</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" name="exampleFormControlTextarea1" rows="3" placeholder="Add a Note"></textarea>
      </div>
      <button class="btn btn-primary" type="submit">Add Note</button>
    </form>

    <!-- <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">1</th>
          <td>Mark</td>
          <td>Otto</td>
          <td><button class="btn btn-primary">Edit</button>
            <button class="btn btn-danger">Delete</button></td>
        </tr>
        <tr>
          <th scope="row">2</th>
          <td>Jacob</td>
          <td>Thornton</td>
          <td><button class="btn btn-primary">Edit</button>
            <button class="btn btn-danger">Delete</button></td>
        </tr>
        <tr>
          <th scope="row">3</th>
          <td>Larry</td>
          <td>the Bird</td>
          <td><button class="btn btn-primary">Edit</button>
            <button class="btn btn-danger">Delete</button></td>
        </tr>
      </tbody>
    </table> -->

    </div>

    <div class="container">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
      <?php

      $query = "Select * from notes";
      $result = mysqli_query($conn,$query);
      $sn =0;
      while($row = mysqli_fetch_assoc($result)){
        $sn = $sn+1;
        echo "<tr>";
        echo "<td>" . $row['sn'] . "</td>";
        echo "<td>" . $row['title'] . "</td>";
        echo "<td>" . $row['description'] . "</td>";
        echo "<td><button class='edit btn btn-primary' data-bs-toggle='modal' data-bs-target='#exampleModal'>Edit</button>
        <button onclick='deleteNote(".$row['sn'].")' class='btn btn-danger'>Delete</button></td>";
        echo "</tr>";

      }

      ?>
      </tbody>
    </table>

    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Note</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
          <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Title</label>
        <input type="text" class="form-control" id="titleEdit" name="titleEdit" placeholder="Enter TODO">
      </div>
      <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Description</label>
        <textarea class="form-control" id="desc" name="desc" rows="3" placeholder="Add a Note"></textarea>
      </div>
      <input type="hidden" name="sn" id="sn">

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="editNote()">Save changes</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->

    <script type="text/javascript">
      function editNote(){
        var title = $('#titleEdit').val();
        var description = $('#desc').val();
        var sn = $('#sn').val();
         $.ajax({
          url: "edit.php",
          type: "post",
          data: {
            title: title,
            description: description,
            sn: sn,
          },
          success:function(response){
            window.location.href = "index.php";
          }
         });

      }

    </script>

    <script>
      function deleteNote(id){
        var id = 
        $.ajax({
          url:"delete.php",
          type:"post",
          data:{
            sn:id,
          },
          success:function(response){
            if (response === 'success') {
          
            // Redirect to index.php
            window.location.href = "index.php";
            }
          }
        });
      }

    </script>

<script>
      edits = document.getElementsByClassName('edit');
      Array.from(edits).forEach((element)=>{
        element.addEventListener("click", (e)=>{
          console.log("edit", e.target.parentNode.parentNode);
          tr = e.target.parentNode.parentNode;
          title = tr.getElementsByTagName("td")[1].innerText;
          description = tr.getElementsByTagName("td")[2].innerText;
          desc.value = description;
          titleEdit.value = title;
          sn.value = tr.getElementsByTagName("td")[0].innerText;
          // $('#exampleModal').modal('toggle');
        })
      })

    </script>
  </body>
</html>