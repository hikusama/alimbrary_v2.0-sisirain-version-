<?php
// Check existence of id parameter before processing further
if(isset($_GET["book_id"]) && !empty(trim($_GET["book_id"]))){
    // Include config file
    require_once "config.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM books WHERE book_id = ?";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["book_id"]);
        
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
                // URL doesn't contain valid id parameter. Redirect to error page
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
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
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
                    <h1 class="mt-5 mb-3">View Book</h1>
                    <div class="form-group">
                        <label>Title</label>
                        <p><b><?php echo $row["title"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Author</label>
                        <p><b><?php echo $row["author"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>ISBN</label>
                        <p><b><?php echo $row["isbn"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Publication year</label>
                        <p><b><?php echo $row["pub_year"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Genre</label>
                        <p><b><?php echo $row["genre"]; ?></b></p>
                    </div>
                    <p><a href="books.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>