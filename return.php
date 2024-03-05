<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Return Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Return Confirmation</h2>
        <p>Are you sure you want to return this book?</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
            <input type="hidden" name="borrow_id" value="<?php echo isset($_GET['borrow_id']) ? $_GET['borrow_id'] : ''; ?>">
            <button type="submit" class="btn btn-success">Confirm</button>
            <a href="borrowedbooks.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <?php
    // Start session
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("location: login.php");
        exit;
    }

    // Include config file
    require_once "config.php";

    // Check if borrow_id is set in the URL
    if (isset($_GET["borrow_id"]) && !empty(trim($_GET["borrow_id"]))) {
        // Prepare a SQL statement to insert return information into return_history table
        $insert_return_sql = "INSERT INTO return_history (user_id, book_id, borrow_id, returned_date_time, status) VALUES (?, (SELECT book_id FROM borrowed_books WHERE borrow_id = ?), ?, CURRENT_TIMESTAMP, 'returned')";

        if ($stmt = mysqli_prepare($conn, $insert_return_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "iii", $param_user_id, $param_borrow_id, $param_borrow_id);

            // Set parameters
            $param_user_id = $_SESSION["id"];
            $param_borrow_id = trim($_GET["borrow_id"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Close statement
                mysqli_stmt_close($stmt);

                // Prepare a SQL statement to update the availability of the book to "Available"
                $update_book_sql = "UPDATE books SET availability = 'Available' WHERE book_id IN (SELECT book_id FROM borrowed_books WHERE borrow_id = ?)";

                if ($stmt2 = mysqli_prepare($conn, $update_book_sql)) {
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt2, "i", $param_borrow_id);

                    // Attempt to execute the prepared statement
                    if (mysqli_stmt_execute($stmt2)) {
                        // Redirect to the borrowed books page
                        header("location: borrowedbooks.php");
                        exit();
                    } else {
                        echo "Oops! Something went wrong. Please try again later.";
                    }

                    // Close statement
                    mysqli_stmt_close($stmt2);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close connection
        mysqli_close($conn);
    }
    ?>
</body>

</html>
