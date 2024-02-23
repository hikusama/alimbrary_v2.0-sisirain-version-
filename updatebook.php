<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$title = $author = $isbn = $pub_year = $genre = "";
$title_err = $author_err = $isbn_err = $pub_year_err = $genre_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["book_id"]) && !empty($_POST["book_id"])){
    // Get hidden input value
    $book_id = $_POST["book_id"];
    
    // Validate title
    $input_title = trim($_POST["title"]);
    if(empty($input_title)){
        $title_err = "Please enter an title.";     
    } else{
        $title = $input_title;
    }
    
    // Validate author
    $input_author = trim($_POST["author"]);
    if(empty($input_author)){
        $author_err = "Please enter an author.";     
    } else{
        $author = $input_author;
    }
    
    // Validate isbn
    $input_isbn = trim($_POST["isbn"]);
    if(empty($input_isbn)){
        $isbn_err = "Please enter an isbn.";     
    } else{
        $isbn = $input_isbn;
    }

    // Validate publication year
    $input_pub_year = trim($_POST["pub_year"]);
    if(empty($input_pub_year)){
        $pub_year_err = "Please enter a publication year.";     
    } else{
        $pub_year = $input_pub_year;
    }

    // Validate genre
    $input_genre = trim($_POST["genre"]);
    if(empty($input_genre)){
        $genre_err = "Please enter a genre.";     
    } else{
        $genre = $input_genre;
    }
    
    // Check input errors before inserting in database
    if(empty($title_err) && empty($author_err) && empty($isbn_err) && empty($pub_year_err) && empty($genre_err)){
        // Prepare an update statement
        $sql = "UPDATE books SET title=?, author=?, isbn=?, pub_year=?, genre=? WHERE book_id=?";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssi", $param_title, $param_author, $param_isbn, $param_pub_year, $param_genre, $param_id);
            
            // Set parameters
            $param_title = $title;
            $param_author = $author;
            $param_isbn = $isbn;
            $param_pub_year = $pub_year;
            $param_genre = $genre;
            $param_id = $book_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: books.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($conn);
} else{
    // Check existence of book_id parameter before processing further
    if(isset($_GET["book_id"]) && !empty(trim($_GET["book_id"]))){
        // Get URL parameter
        $book_id =  trim($_GET["book_id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM books WHERE book_id = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $book_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $title = $row["title"];
                    $author = $row["author"];
                    $isbn = $row["isbn"];
                    $pub_year = $row["pub_year"];
                    $genre = $row["genre"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($conn);
    }  else{
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
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Book</h2>
                    <p>Please edit the input values and submit to update the book.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $title; ?>">
                            <span class="invalid-feedback"><?php echo $title_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Author</label>
                            <input type="text" name="author" class="form-control <?php echo (!empty($author_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $author; ?>">
                            <span class="invalid-feedback"><?php echo $author_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>ISBN</label>
                            <input type="text" name="isbn" class="form-control <?php echo (!empty($isbn_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $isbn; ?>">
                            <span class="invalid-feedback"><?php echo $isbn_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Publication year</label>
                            <input type="text" name="pub_year" class="form-control <?php echo (!empty($pub_year_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $pub_year; ?>">
                            <span class="invalid-feedback"><?php echo $pub_year_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Genre</label>
                            <input type="text" name="genre" class="form-control <?php echo (!empty($genre_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $genre; ?>">
                            <span class="invalid-feedback"><?php echo $genre_err;?></span>
                        </div>
                        
                        <input type="hidden" name="book_id" value="<?php echo $book_id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="books.php" class="btn btn-secondary ml-2">Cancel</a>
                        
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
