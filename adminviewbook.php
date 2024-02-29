<?php
// Include config file
require_once "config.php";

// Initialize variables
$book_id = $title = $author = $isbn = $pub_year = $genre = $image_path = "";

// Check if book_id parameter is provided in the URL
if(isset($_GET["book_id"]) && !empty(trim($_GET["book_id"]))){
    // Prepare a select statement
    $sql = "SELECT * FROM books WHERE book_id = ?";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_book_id);
        
        // Set parameters
        $param_book_id = trim($_GET["book_id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field values
                $title = $row["title"];
                $author = $row["author"];
                $isbn = $row["isbn"];
                $pub_year = $row["pub_year"];
                $genre = $row["genre"];
                $image_path = $row["image_path"];
            } else{
                // URL doesn't contain valid book_id parameter, redirect to error page
                header("location: error.php");
                exit();
            }
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($conn);
} else{
    // URL doesn't contain book_id parameter, redirect to error page
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Book</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* Adjust styles for card layout */
        .card {
            margin-top: 20px;
            margin-bottom: 20px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Adjust styles for image */
        .book-image {
            max-width: 300px;
            height: auto;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="text-center">Book Details</h2>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <?php if(!empty($image_path)): ?>
                        <img src="<?php echo $image_path; ?>" class="book-image" alt="Book Image">
                    <?php else: ?>
                        <span>No image available</span>
                    <?php endif; ?>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Title</th>
                                <td><?php echo htmlspecialchars($title); ?></td>
                            </tr>
                            <tr>
                                <th>Author</th>
                                <td><?php echo htmlspecialchars($author); ?></td>
                            </tr>
                            <tr>
                                <th>ISBN</th>
                                <td><?php echo htmlspecialchars($isbn); ?></td>
                            </tr>
                            <tr>
                                <th>Publication Year</th>
                                <td><?php echo htmlspecialchars($pub_year); ?></td>
                            </tr>
                            <tr>
                                <th>Genre</th>
                                <td><?php echo htmlspecialchars($genre); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
            <a href="books.php" class="text-light"><button class="btn btn-secondary btn-md disabled" data-toggle="tooltip" data-placement="top" title="Back to Books">               
                            <i class="fa fa-arrow-left"></i>                    
                    </button></a>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
