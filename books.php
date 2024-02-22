<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books section</title>
</head>

<body>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Dashboard</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <style>
            .modal-dialog {
                max-width: 400px;
                /* Adjust the width as needed */
            }

            .modal-content {
                width: 100%;
            }
        </style>
        <script>
            $(document).ready(function() {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    </head>

    <body>
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mt-5 mb-3 clearfix">
                            <h2 class="pull-left">Books</h2>
                            <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#exampleModal">Add new book &nbsp; <img src="images\plus-circle-svgrepo-com.svg" alt="" style="height: 20px; width:20px ;"></button>
                            <div class="modal fade" id="exampleModal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <title>Create book</title>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="close">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <?php
                                            // Include config file
                                            require_once "config.php";

                                            // Define variables and initialize with empty values
                                            $title = $author = $isbn = $pub_year = $genre = "";
                                            $title_err = $author_err = $isbn_err = $pub_year_err = $genre_err = "";

                                            // Processing form data when form is submitted
                                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                // Validate title
                                                $input_title = trim($_POST["title"]);
                                                if (empty($input_title)) {
                                                    $title_err = "Please enter a title.";
                                                } else {
                                                    $title = $input_title;
                                                }

                                                // Validate author
                                                $input_author = trim($_POST["author"]);
                                                if (empty($input_author)) {
                                                    $author_err = "Please enter an author.";
                                                } else {
                                                    $author = $input_author;
                                                }

                                                // Validate isbn
                                                $input_isbn = trim($_POST["isbn"]);
                                                if (empty($input_isbn)) {
                                                    $isbn_err = "Please enter the isbn.";
                                                } else {
                                                    $isbn = $input_isbn;
                                                }

                                                // Validate pub_year
                                                $input_pub_year = trim($_POST["pub_year"]);
                                                if (empty($input_pub_year)) {
                                                    $pub_year_err = "Please enter an pub_year.";
                                                } else {
                                                    $pub_year = $input_pub_year;
                                                }

                                                // Validate genre
                                                $input_genre = trim($_POST["genre"]);
                                                if (empty($input_genre)) {
                                                    $genre_err = "Please enter an genre.";
                                                } else {
                                                    $genre = $input_genre;
                                                }


                                                // Check input errors before inserting in database
                                                if (empty($title_err) && empty($author_err) && empty($isbn_err) && empty($pub_year_err) && empty($genre_err)) {
                                                    // Prepare an insert statement
                                                    $sql = "INSERT INTO books (title, author, isbn, pub_year, genre) VALUES (?, ?, ?, ?, ?)";

                                                    if ($stmt = mysqli_prepare($conn, $sql)) {
                                                        // Bind variables to the prepared statement as parameters
                                                        mysqli_stmt_bind_param($stmt, "sssss", $param_title, $param_author, $param_isbn, $param_pub_year, $param_genre);

                                                        // Set parameters
                                                        $param_title = $title;
                                                        $param_author = $author;
                                                        $param_isbn = $isbn;
                                                        $param_pub_year = $pub_year;
                                                        $param_genre = $genre;

                                                        // Attempt to execute the prepared statement
                                                        if (mysqli_stmt_execute($stmt)) {
                                                            // Records created successfully. Redirect to landing page
                                                            header("location: books.php");
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
                                            }
                                            ?>

                                            <div class="wrapper">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h2 class="mt-5">Create Book</h2>
                                                            <p>Please fill this form and submit to add Books record to the database.</p>
                                                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
                                                                    <label>Publication year</label>
                                                                    <input type="text" name="pub_year" class="form-control <?php echo (!empty($pub_year_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $pub_year; ?>">
                                                                    <span class="invalid-feedback"><?php echo $pub_year_err; ?></span>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Genre</label>
                                                                    <input type="text" name="genre" class="form-control <?php echo (!empty($genre_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $genre; ?>">
                                                                    <span class="invalid-feedback"><?php echo $genre_err; ?></span>
                                                                </div>
                                                                <input type="submit" class="btn btn-primary" value="Submit">
                                                                <a href="books.php" class="btn btn-secondary ml-2">Cancel</a>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container">
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
                    echo '<div class="card h-100">';
                    echo '<img src="images/7-hp-grandpre-refresh-deathlyhallows-sm.png" class="card-img-top" alt="..." style="height: 300px; width: 350px;">';
                    echo '<div class="card-body d-flex flex-column">';
                    echo '<h5 class="card-title">' . $row['title'] . '</h5>';
                    echo '<hr>';
                    echo '<p class="card-text flex-grow-1">Author: ' . $row['author'] . '</p>';
                    echo '<p class="card-text">ISBN: ' . $row['isbn'] . '</p>';
                    echo '<p class="card-text">Publication Year: ' . $row['pub_year'] . '</p>';
                    echo '<p class="card-text">Genre: ' . $row['genre'] . '</p>';
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


        <a href="welcome.php"><button>Back</button></a>
    </body>

    </html>
</body>

</html>