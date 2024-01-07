<?php

//session start
session_start();

   $insert=false;
   $update=false;
   $delete=false;
//connecting to DB
$servername = "localhost";
$usernmae = "root";
$password = "";
$dbname= "harry";

//creating connection
$conn= mysqli_connect($servername, $usernmae, $password,$dbname);

//connection 
if(!$conn){
    die ("Sorry We could not connect : ". mysqli_connect_error());
}
if(isset($_GET['delete'])){
  $srno= $_GET['delete'];
  $delete=true;
  //deleting rec from database
$sql= "DELETE FROM notes WHERE `notes`.`srno` = '$srno'";
$result= mysqli_query($conn, $sql);

}

if($_SERVER['REQUEST_METHOD']=='POST'){
if(isset($_POST['srnoEdit'])){
//update the record
$srno= $_POST["srnoEdit"];
$title= $_POST['title'];
$description = $_POST['description'];
// insert query
$sql = "UPDATE `notes` SET `title` = '$title', `description` = '$description' WHERE `notes`.`srno` = '$srno'";
$result= mysqli_query($conn, $sql);
if ($result){
  $update=true;
}
else{
 
}
}

else{
  $title= $_POST['title'];
  $description = $_POST['description'];
  // insert query
  $sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description')";
  $result= mysqli_query($conn, $sql);

  if($result){
    $insert=true;
  }
}
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
        <title>iNotes - Project - PHP CRUD </title>
      
    </head>

<body>
<!-- Edit Modal -->
<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/CRUD/index.php" method="post">
      <div class="modal-body">
        <input type="hidden" name="srnoEdit" id="srnoEdit">
            <div class="form-group ">
                <label for="title">Note Title</label>
                <input type="text" class="form-control" id="titleEdit" name="title" aria-describedby="emailHelp"
                    placeholder="Enter Title">
            </div>

            <div class="form-group">
                <label for="desc">Note Description</label>
                <textarea class="form-control" id="descriptionEdit" name="description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
          <div class="modal-footer d-block mr-auto">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="Submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
    </div>
  </div>
</div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#"><img src="/CRUD/crud.png" alt="CRUD" style="height: 45px;"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">

                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Contact us</a>
                </li>
            </ul>

            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <?php    
    if($insert){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Congratulation!</strong> You inserted Data Successfully.
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>&times;</span>
      </button>
      </div>";
    }
    ?>

<?php    
    if($update){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Congratulation!</strong> You updated Data Successfully.
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>&times;</span>
      </button>
      </div>";
    }
    ?>

<?php    
    if($delete){
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Congratulation!</strong> You deleted Data Successfully.
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>&times;</span>
      </button>
      </div>";
    }
    ?>

<div class="container my-4">
        <h2>Add a Note &hearts;</h2>
        <form action="/CRUD/index.php" method="post">
            <div class="form-group ">
                <label for="title">Note-Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp"
                    placeholder="Enter Title">
            </div>

            <div class="form-group">
                <label for="desc">Note Description</label>
                <textarea class="form-control" id="desc" name="description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <div class="container my-4" >
    </div>

    <table class="table" id="myTable">
  <thead>
    <tr>
      <th scope="col">Sr. No</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
  <?php
  //   echo $row['srno']." Title ". $row['title']."Description is ". $row['description']." on dated ". $row['tstamp'];
  $sql="SELECT * FROM `notes`";
  $result= mysqli_query($conn,$sql);
  $srno=0;
  while($row = mysqli_fetch_assoc($result)){
      $srno=$srno+1;
      echo "<tr>
      <th scope='row'=1>".$srno."</th>
      <td>". $row['title']."</td>
      <td>". $row['description']."</td>
      <td>  <button class='edit btn btn-sm btn-primary' id=".$row['srno'].">Edit</button> / <button class='delete btn btn-sm btn-primary' id=d".$row['srno'].">Delete</button></td>
      </tr>";
    }
 
    ?>
  
  </tbody> 
</table>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    
    <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>let table = new DataTable('#myTable');
    </script> 
     <script>
            edits =document.getElementsByClassName('edit');
            Array.from(edits).forEach((element)=>{
              element.addEventListener("click",(e)=>{
                console.log("edit ",);
                tr=e.target.parentNode.parentNode;
                title=tr.getElementsByTagName("td")[0].innerText;
                description= tr.getElementsByTagName("td")[1].innerText;
                console.log(title,description);
                titleEdit.value=title;
                descriptionEdit.value=description;
                srnoEdit.value=e.target.id;
                console.log(e.target.id)
                $('#editModal').modal('toggle')
              
              })
            })

            deletes =document.getElementsByClassName('delete');
            Array.from(deletes).forEach((element)=>{
              element.addEventListener("click",(e)=>{
                console.log("edit ",);
                srno=e.target.id.substr(1);
                window.location = `/CRUD/index.php?delete=${srno}`;
                if(confirm("Are You Sure to DELETE this note")){
                  console.log("yes")
                }
                else{
                  console.log("no");
                }
              
              })
            })
            session_unset();
            session_destroy();
        </script>
</body>

</html>