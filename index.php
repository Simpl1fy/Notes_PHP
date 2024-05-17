<!-- Connecting to Database -->
<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

$conn = mysqli_connect($servername, $username, $password, $database);

if(!$conn) {
    echo "Connection was not succesful -->" . mysqli_connect_error();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="//cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
</head>
<body>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel">Edit Note</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form action="/Note-Taker/index.php" method="post">
                <input type="hidden" name="uidEdit"  id="uidEdit">
                <div class="mb-3">
                    <label for="noteHeadingEdit" class="form-label">Note Heading</label>
                    <input type="text" class="form-control" id="titleEdit" name="titleEdit">
                </div>
                <div class="mb-3">
                    <label for="notedescriptionEdit" class="form-label">Note Description</label>
                    <input type="text" class="form-control" id="descEdit" name="descEdit">
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
            </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Note Taker</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                </li>
            </ul>
            </div>
        </div>
    </nav>

    <!-- Adding the main form -->
    <?php
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['uidEdit'])){
            $uid = $_POST['uidEdit'];
            $title = $_POST['titleEdit'];   
            $description = $_POST['descEdit'];

            $sql = "UPDATE `note_table` SET `title` = '$title', `description` = '$description' WHERE `note_table`.`uid` = '$uid'";
            $result = mysqli_query($conn, $sql);

            if(!$result) {
                echo "Failed --> " .mysqli_error($conn);
            }
        } else {
            $title = $_POST['title'];
            $desc = $_POST['desc'];
            $sql = "INSERT INTO `note_table` (`title`, `description`) VALUES ('$title', '$desc')";
            $result = mysqli_query($conn, $sql);

            if($result) {
                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Success!</strong> Your note has been saved.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
            } else {
                echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>Failed!</strong> Your note was not saved. error " . mysqli_error($conn) ."
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
            }
        }
    }
    ?>


    <div class="container">
        <form class="mt-3" action="/Note-Taker/index.php" method="post">
            <h3 class="my-3">Add Note</h3>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Note Heading</label>
                <input type="text" class="form-control" id="exampleInputheading" name="title">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Note Description</label>
                <textarea  class="form-control" id="note-desc" name="desc" rows="5"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <div class="container">
        <h4 class="my-3">Notes</h4>
        <table class="table" id="myTable">
            <thead>
                <tr>
                <th scope="col">U. Id</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
                <tbody>
                        <?php
                        $sql = "SELECT * FROM `note_table`";
                        $result = mysqli_query($conn, $sql);
                        $sno = 0;
                        while($row = mysqli_fetch_assoc($result)) {
                            $sno = $sno + 1;
                            echo "
                            <tr>
                                <th scope='row'>" . $sno ."</th>
                                <td>" .$row["title"] ."</td>
                                <td>" .$row["description"] ."</td>
                                <td> <button type='button' class='edit btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#editModal' id=". $row["uid"] .">Edit</button>  <button type='button' class='btn btn-sm btn-danger'>Delete</button> </td>
                            </tr>";     
                        }
                        ?>
                </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script
			  src="https://code.jquery.com/jquery-3.7.1.js"
			  integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
			  crossorigin="anonymous"></script>
    
    <script src="//cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
    <script>
        let table = new DataTable('#myTable');
    </script>
    
    <script src="scripts/script.js"></script>
</body>
</html>