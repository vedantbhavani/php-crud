<?php
$insert = false;
$update = false;
$deleted = false;
$servername = "localhost";
$username = "root";
$password = "";
$database = "vsdata";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("<br>Sorry we are connecting to fail: ");
} else {
    if (isset($_GET['delete'])) {
        $sno = $_GET['delete'];
        $sql = "DELETE FROM notes WHERE `sno` = $sno";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $deleted = true;
        }
    }
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['snoEdit'])) {
            $title = $_POST['titleEdit'];
            $description = $_POST['descriptionEdit'];
            $sno = $_POST['snoEdit'];

            $sql = "UPDATE `notes` SET `title` = '$title', `description` = '$description' WHERE `notes`.`sno` = $sno ";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $update = true;
            }
        } else {
            $title = $_POST['title'];
            $description = $_POST['description'];
            

            $sql = "INSERT INTO `notes` (`title`, `description`, `Date-Time`) VALUES ('$title', '$description', current_timestamp())";
            $result =  mysqli_query($conn, $sql);
            if ($result) {
                $insert = true;
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Project-01 CRUD with php </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Launch a modal -->
    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Edit the Note</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="/php-crud/index.php">
                    <div class="modal-body">
                        <input type="hidden" name="snoEdit" id="snoEdit">
                        <div class="mb-3">
                            <label for="titleEdit" class="form-label">Notes Title</label>
                            <input type="text" name="titleEdit" placeholder="Enter Title" class="form-control" id="titleEdit"
                                aria-describedby="emailHelp" />
                        </div>
                        <div class="mb-3">
                            <label for="descriptionEdit" class="form-label">Notes Description</label>
                            <textarea class="form-control" id="descriptionEdit" placeholder="Enter Description" name="descriptionEdit"
                                rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Finish modal -->
    <!-- Navbar start -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">VS-Notes</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <?php
    if ($insert) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success : </strong> Your entry will be added successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    if ($update) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success : </strong> Your entry will be updated successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    if ($deleted) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success : </strong> Your entry will be deleted successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    ?>
    <!-- Form start here -->
    <div class="container mt-3" style="width: 65%">
        <h2 class="text-center">Welcome to the VS-Notes</h2>
        <form method="post" action="/php-crud/index.php">
            <div class="mb-3">
                <label for="title" class="form-label">Notes Title</label>
                <input type="text" name="title" placeholder="Enter Title" class="form-control" id="title"
                    aria-describedby="emailHelp" />
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Notes Description</label>
                <textarea class="form-control" id="description" placeholder="Enter Description" name="description"
                    rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Data</button>
        </form>

        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Title</th>
                    <th scope="col">Desc</th>
                    <th colspan="2" scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $snumber = 1;
                $sql = "SELECT * FROM `notes`";
                $result =  mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>
                    <th scope="row">' . $snumber . '</th>
                    <td>' . $row["title"] . '</td>
                    <td>' . $row["description"] . '</td>
                    <td><button id="' . $row["sno"] . '" class="edit btn btn-sm btn-primary">Edit</button></td>
                    <td><button id="d' . $row["sno"] . '" class="delete btn btn-sm btn-primary">Delete</button></td>
                    </tr>';
                    $snumber += 1;
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>
<script>
    let edits = document.getElementsByClassName('edit')
    Array.from(edits).forEach((element) => {
        element.addEventListener("click", (e) => {
            let tablerow = e.target.parentNode.parentNode;
            let title = tablerow.getElementsByTagName('td')[0].innerText
            let description = tablerow.getElementsByTagName('td')[1].innerText
            console.log(title, description);
            titleEdit.value = title;
            descriptionEdit.value = description;
            snoEdit.value = e.target.id
            console.log(e.target.id);
            $('#editModal').modal('toggle')
        })
    })

    let deletes = document.getElementsByClassName('delete')
    Array.from(deletes).forEach((element) => {
        element.addEventListener("click", (e) => {
            sno = e.target.id.substr(1, );
            if (confirm("Are you sure want to delete this note ?")) {
                console.log("yes");
                window.location = `/php-crud/index.php?delete=${sno}`
            } else {
                console.log("no");
            }
        })
    })
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</html>