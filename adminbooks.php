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

    // Generate and check ISBN
    do {
        // Generate a random number for the first part of the ISBN (9 digits)
        $random_number = mt_rand(100000000, 999999999);

        // Format the random number to match ISBN format (###-##########)
        $isbn = "978-" . $random_number;

        // Check if the generated ISBN already exists in the database
        $sql_check_isbn = "SELECT * FROM books WHERE isbn = ?";
        $stmt_check_isbn = mysqli_prepare($conn, $sql_check_isbn);
        mysqli_stmt_bind_param($stmt_check_isbn, "s", $isbn);
        mysqli_stmt_execute($stmt_check_isbn);
        $result_check_isbn = mysqli_stmt_get_result($stmt_check_isbn);
        $num_rows = mysqli_num_rows($result_check_isbn);
    } while ($num_rows > 0);

    // Validate title, author, isbn, publication year, and genre (you already have this code)

    // Check if file is uploaded without errors
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
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
                    // File uploaded successfully, now insert book data into the database
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
        $image_err = "No image file uploaded.";
    }

    // Free the result set and close the statement
    mysqli_free_result($result_check_isbn);
    mysqli_stmt_close($stmt_check_isbn);

    // Check input errors before inserting into database
    if (empty($title_err) && empty($author_err) && empty($isbn_err) && empty($pub_year_err) && empty($genre_err) && empty($image_err)) {
        // Check if any of the required fields are empty
        if (empty($title) || empty($author) || empty($isbn) || empty($pub_year) || empty($genre) || empty($image_path)) {
            // Redirect to landing page or any other appropriate action
            header("location: adminbooks.php");
            exit();
        }

        // Prepare an insert statement
        $sql = "INSERT INTO books (title, author, isbn, pub_year, genre, image_path, availability) VALUES (?, ?, ?, ?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssss", $param_title, $param_author, $param_isbn, $param_pub_year, $param_genre, $param_image_path, $param_availability);

            // Set parameters
            $param_title = $title;
            $param_author = $author;
            $param_isbn = $isbn;
            $param_pub_year = $pub_year;
            $param_genre = $genre;
            $param_image_path = $image_path;
            $param_availability = $availability; // New parameter for availability

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to landing page
                header("location: adminbooks.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }


        // Close statement
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books section</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        /* Fixed position for the header container */
        .header-container {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background-color: #fff;
            /* Adjust background color as needed */
            z-index: 1000;
            /* Ensure the header is above other content */
        }

        /* Margin to push content below the fixed header */
        body {
            margin-top: 70px;
            /* Adjust as needed based on header height */
        }

        /* Adjustments for the back-to-top button */
        #backToTopBtn {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 99;
            font-size: 18px;
            border: none;
            outline: none;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            cursor: pointer;
            border-radius: 50%;
        }

        #backToTopBtn:hover {
            background-color: rgba(0, 0, 0, 0.7);
        }

        label {
            font-weight: bold;
        }

        .form-control {
            border-radius: 5px;
        }

        /* Add custom styles for the modal */
        .modal-content {
            border-radius: 10px;
        }

        .modal-header {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-title {
            font-size: 20px;
        }

        .invalid-feedback {
            color: red;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>

<body>
    <div class="header-container bg-light">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-3 clearfix">
                        <h2 class="pull-left">Books</h2>
                        <a href="welcomeadmin.php" class="text-light">
                            <button class="btn btn-outline-dark btn-md pull-right disabled" data-toggle="tooltip" data-placement="top" title="Back to Dashboard">
                                <i class="fa fa-arrow-left" style="color: black;"></i>
                            </button>
                        </a>


                        <button type="button" class="btn btn-success btn-md pull-right mr-2" data-toggle="modal" data-target="#exampleModal" data-toggle="tooltip" data-placement="top" title="Add New Book">
                            <i class="fa fa-plus-circle"></i>
                        </button>

                        <button class="btn btn-secondary btn-md pull-right mr-2" type="button" id="refreshButton" data-toggle="tooltip" data-placement="top" title="Refresh">
                            <i class="fa fa-refresh"></i>
                        </button>

                        <button class="btn btn-outline-info btn-md pull-right mr-2" type="button" id="searchButton" data-toggle="tooltip" data-placement="top" title="Search">
                            <i class="fa fa-search"></i>
                        </button>

                        <input type="text" id="searchInput" class="form-control form-control-md pull-right mr-2" placeholder="Search books" style="width:200px;">


                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="text-center">
                        <h5 class="modal-title"><i class="fa fa-book"></i> Add Book</h5>
                    </div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $title; ?>">
                            <span class="invalid-feedback"><?php echo $title_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Author</label>
                            <input type="text" name="author" class="form-control <?php echo (!empty($author_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $author; ?>">
                            <span class="invalid-feedback"><?php echo $author_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>ISBN</label>
                            <input type="text" name="isbn" class="form-control <?php echo (!empty($isbn_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $isbn; ?>">
                            <span class="invalid-feedback"><?php echo $isbn_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Publication Year</label>
                            <input type="text" name="pub_year" class="form-control <?php echo (!empty($pub_year_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $pub_year; ?>">
                            <span class="invalid-feedback"><?php echo $pub_year_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Genre</label>
                            <input type="text" name="genre" class="form-control <?php echo (!empty($genre_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $genre; ?>">
                            <span class="invalid-feedback"><?php echo $genre_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Availability</label>
                            <select name="availability" class="form-control <?php echo (!empty($availability_err)) ? 'is-invalid' : ''; ?>">
                                <option value="Available">Available</option>
                                <option value="Not Available">Not Available</option>
                            </select>
                            <span class="invalid-feedback"><?php echo $availability_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="image" class="form-control-file <?php echo (!empty($image_err)) ? 'is-invalid' : ''; ?>">
                            <span class="invalid-feedback"><?php echo $image_err; ?></span>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-secondary ml-2" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="container-fluid">
        <div class="row">
            <div class="container">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
                    <?php
                    // Include config file
                    require_once "config.php";

                    // Attempt select query execution
                    $sql = "SELECT * FROM books";
                    if ($result = mysqli_query($conn, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                                echo '<div class="col mb-4">';
                                echo '<div class="card h-100 border-primary">';
                                echo '<div class="d-flex justify-content-center align-items-center mt-2" style="height: 240px;">';

                                // Display the image if image path exists
                                if (!empty($row['image_path'])) {
                                    echo '<img src="' . $row['image_path'] . '" alt="Book Image" style="max-height: 200px; max-width: 150px;">';
                                } else {
                                    echo '<span>No image available</span>';
                                }
                                echo '</div>';

                                echo '<div class="card-body d-flex flex-column">';
                                echo '<h5 class="card-title text-center">' . $row['title'] . '</h5>';
                                echo '<p class="card-text text-center">Author: ' . $row['author'] . '</p>';
                                echo '<p class="card-text text-center">ISBN: ' . $row['isbn'] . '</p>';
                                echo '<p class="card-text text-center">Publication Year: ' . $row['pub_year'] . '</p>';
                                echo '<p class="card-text text-center">Genre: ' . $row['genre'] . '</p>';
                                // Check availability and apply appropriate styling
                                $availability = $row['availability'];
                                $badgeClass = ($availability == 'Available') ? 'badge-warning' : 'badge-danger';
                                echo '<p class="card-text text-center">Availability: <span class="badge ' . $badgeClass . ' text-light">' . $availability . '</span></p>';

                                // Move the links to the bottom of the card
                                echo '<div class="mt-auto d-flex flex-row justify-content-center align-items-center bg-secondary rounded p-2 mx-auto" style="max-width: 120px;">';
                                echo '<a href="adminviewbook.php?book_id=' . $row['book_id'] . '" class="mr-3 text-light" title="View Record" data-toggle="tooltip"><span class="fa fa-eye fa-lg"></span></a>';
                                echo '<a href="updatebook.php?book_id=' . $row['book_id'] . '" class="mr-3 text-light" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil fa-lg"></span></a>';
                                echo '<a href="deletebook.php?book_id=' . $row['book_id'] . '" class="text-light" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash fa-lg"></span></a>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                            // Free result set
                            mysqli_free_result($result);
                        } else {
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else {
                        echo "Oops! Something went wrong. Please try again later.";
                    }

                    // Close connection
                    mysqli_close($conn);
                    ?>
                </div>
            </div>
        </div>
    </div>



    <button id="backToTopBtn" title="Go to top" style="height: 50px; width:50px;"><i class="fa fa-arrow-up"></i></button>



    <script>
        $(document).ready(function() {
            $("#searchButton").click(function() {
                var searchText = $("#searchInput").val().trim().toLowerCase(); // Remove leading and trailing spaces
                $(".card").each(function() {
                    var title = $(this).find(".card-title").text().toLowerCase();
                    var author = $(this).find(".card-text").eq(0).text().toLowerCase();
                    var isbn = $(this).find(".card-text").eq(1).text().toLowerCase();
                    var pubYear = $(this).find(".card-text").eq(2).text().toLowerCase();
                    var genre = $(this).find(".card-text").eq(3).text().toLowerCase();
                    if (title.indexOf(searchText) === -1 && author.indexOf(searchText) === -1 && isbn.indexOf(searchText) === -1 && pubYear.indexOf(searchText) === -1 && genre.indexOf(searchText) === -1) {
                        $(this).parent('.col').hide(); // Hide the entire card container
                    } else {
                        $(this).parent('.col').show(); // Show the entire card container
                    }
                });
            });

            // Refresh button click event
            $("#refreshButton").click(function() {
                location.reload(); // Reload the page
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Show or hide the button based on scroll position
            $(window).scroll(function() {
                if ($(this).scrollTop() > 100) {
                    $('#backToTopBtn').fadeIn();
                } else {
                    $('#backToTopBtn').fadeOut();
                }
            });

            // Scroll to top when button is clicked
            $('#backToTopBtn').click(function() {
                $('html, body').animate({
                    scrollTop: 0
                }, 'slow');
                return false;
            });
        });
    </script>
</body>

</html>