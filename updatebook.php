<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>

<?php
// Include config file
require_once "config.php";

// Initialize variables
$title = $author = $isbn = $pub_year = $genre = $availability = "";
$title_err = $author_err = $isbn_err = $pub_year_err = $genre_err = $image_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and retrieve form data
    $title = trim($_POST["title"]);
    $author = trim($_POST["author"]);
    $isbn = trim($_POST["isbn"]);
    $pub_year = trim($_POST["pub_year"]);
    $genre = trim($_POST["genre"]);
    $availability = $_POST["availability"] ?? "";

    // Validate title, author, isbn, publication year, and genre (you already have this code)

    // Check if file is uploaded without errors (if an image is provided)
    if (!empty($_FILES["image"]["name"])) {
        if ($_FILES["image"]["error"] == 0) {
            // Process and move the uploaded file
            $target_dir = "uploads/"; // Directory where uploaded files will be stored
            $target_file = $target_dir . basename($_FILES["image"]["name"]); // Path of the uploaded file
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // File extension

            // Check if the file is an actual image or fake image
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                // Allow certain file formats
                if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") {
                    // Move the uploaded file to the specified directory
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                        // File uploaded successfully, now update book data in the database
                        $image_path = $target_file; // Get image path
                    } else {
                        $image_err = "Sorry, there was an error uploading your file.";
                    }
                } else {
                    $image_err = "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
                }
            } else {
                $image_err = "File is not an image.";
            }
        } else {
            $image_err = "Sorry, there was an error uploading your file.";
        }
    } else {
        // No image file uploaded, set image_path to null or retain the existing image_path if available
        if (!empty($_POST["current_image_path"])) {
            $image_path = $_POST["current_image_path"];
        }
    }

    // Check input errors before updating the database
    if (empty($title_err) && empty($author_err) && empty($isbn_err) && empty($pub_year_err) && empty($genre_err) && empty($image_err)) {
        // Prepare an update statement
        $sql = "UPDATE books SET title=?, author=?, isbn=?, pub_year=?, genre=?, availability=?, image_path=? WHERE book_id=?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssssi", $param_title, $param_author, $param_isbn, $param_pub_year, $param_genre, $param_availability, $param_image_path, $param_book_id);

            // Set parameters
            $param_title = $title;
            $param_author = $author;
            $param_isbn = $isbn;
            $param_pub_year = $pub_year;
            $param_genre = $genre;
            $param_availability = $availability; // Add this line to set the availability parameter
            $param_image_path = $image_path;
            $param_book_id = $_POST["book_id"];

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to the landing page
                header("location: adminbooks.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($conn);
} else {
    // Check existence of book_id parameter before processing further
    if (isset($_GET["book_id"]) && !empty(trim($_GET["book_id"]))) {
        // Get URL parameter
        $book_id =  trim($_GET["book_id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM books WHERE book_id = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_book_id);

            // Set parameters
            $param_book_id = $book_id;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) == 1) {
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field value
                    $title = $row["title"];
                    $author = $row["author"];
                    $isbn = $row["isbn"];
                    $pub_year = $row["pub_year"];
                    $genre = $row["genre"];
                    $availability = $row["availability"];
                    $image_path = $row["image_path"];

                } else {
                    // URL doesn't contain valid book_id parameter. Redirect to error page
                    header("location: error.php");
                    exit();
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);

        // Close connection
        mysqli_close($conn);
    } else {
        // URL doesn't contain book_id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Book</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>

    </style>
</head>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Book</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 500px;
            margin-top: 50px;
        }
        h2 {
            color: black;
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        label {
            font-weight: bold;
        }
        .form-control {
            border-radius: 5px;
        }
        .btn-success, .btn-secondary {
            border-radius: 5px;
        }
        .btn-success {           
            border: none;
        }
        .btn-secondary {           
            border: none;
        }
        .text-danger {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container mb-3">
        <h2>Update Book</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
            <input type="hidden" name="current_image_path" value="<?php echo $image_path; ?>">
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="<?php echo $title; ?>">
            </div>
            <div class="form-group">
                <label>Author</label>
                <input type="text" name="author" class="form-control" value="<?php echo $author; ?>">
            </div>
            <div class="form-group">
                <label>ISBN</label>
                <input type="text" name="isbn" class="form-control" value="<?php echo $isbn; ?>">
            </div>
            <div class="form-group">
                <label>Publication Year</label>
                <input type="text" name="pub_year" class="form-control" value="<?php echo $pub_year; ?>">
            </div>
            <div class="form-group">
                <label>Genre</label>
                <input type="text" name="genre" class="form-control" value="<?php echo $genre; ?>">
            </div>
            <div class="form-group">
                <label>Availability</label>
                <select name="availability" class="form-control">
                    <option value="Available" <?php if ($availability == 'Available') echo 'selected'; ?>>Available</option>
                    <option value="Not Available" <?php if ($availability == 'Not Available') echo 'selected'; ?>>Not Available</option>
                </select>
            </div>
            <div class="form-group">
                <label>Current Image</label>
                <?php if (!empty($image_path)) : ?>
                    <br>
                    <img src="<?php echo $image_path; ?>" alt="Current Image" style="max-width: 200px;">
                <?php else : ?>
                    <span>No image available</span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label>New Image</label>
                <input type="file" name="image" class="form-control-file">
                <span class="text-danger"><?php echo $image_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-success" value="Update">
                <a href="adminbooks.php" class="btn btn-secondary ml-2">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
