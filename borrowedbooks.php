<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Borrowed Books</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
    <div class="container mt-5">
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

        // Query to retrieve borrowed books information excluding returned books
        $borrowed_books_sql = "SELECT borrowed_books.borrow_id, books.title, users.username, borrowed_books.borrow_date, borrowed_books.return_date 
                                FROM borrowed_books
                                JOIN books ON borrowed_books.book_id = books.book_id
                                JOIN users ON borrowed_books.user_id = users.id
                                WHERE borrowed_books.user_id = ? AND borrowed_books.borrow_id NOT IN (SELECT return_history.borrow_id FROM return_history WHERE status = 'returned')";

        if ($stmt = mysqli_prepare($conn, $borrowed_books_sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $_SESSION["id"]);

            // Execute the prepared statement
            mysqli_stmt_execute($stmt);

            // Store the result
            mysqli_stmt_store_result($stmt);

            // Check if there are borrowed books
            if (mysqli_stmt_num_rows($stmt) > 0) {
                // Bind result variables
                mysqli_stmt_bind_result($stmt, $borrow_id, $book_title, $username, $borrow_date, $return_date);

                // Start displaying borrowed books
                ?>
                <h2 class="float-start">Borrowed Books</h2>
                <div class="float-end">
                    <button class="btn btn-success text-light fw-bold"><i class="fa fa-user"></i> <?php echo htmlspecialchars($_SESSION["username"]); ?></button>
                    <a href="userwelcome.php" class="btn btn-primary"><i class="fa fa-home"></i> Back to Home</a>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">

                            <table class="table table-striped table-hover border-dark">
                                <thead>

                                    <tr>
                                        <th>Borrow ID</th>
                                        <th>Book Title</th>
                                        <th>Borrower</th>
                                        <th>Borrow Date</th>
                                        <th>Return Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Fetch records
                                    while (mysqli_stmt_fetch($stmt)) {
                                        echo "<tr>";
                                        echo "<td>" . $borrow_id . "</td>";
                                        echo "<td>" . $book_title . "</td>";
                                        echo "<td>" . $username . "</td>";
                                        echo "<td>" . $borrow_date . "</td>";
                                        echo "<td>" . $return_date . "</td>";
                                        echo "<td>";
                                        // Add the Return Book button with a link to return.php

                                        echo "<a href='return.php' class='btn btn-danger btn-sm text-light fw-bold'>Return Book</a>";
                                        echo "</td>";
                                        echo "</tr>";
                                        $_SESSION['idbuk'] = $borrow_id;
                                    }
                                    if(isset($_GET['prompt']) && $_GET['prompt'] === "success"){
                                        echo "<p style='color:red;' >Book Succesfully Delete...</p>";

                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                // Display message if there are no borrowed books or all books are returned
                echo "<div class='container mt-5'>";
                echo "<h2>No Borrowed Books</h2>";
                echo "<p class='lead'>You haven't borrowed any books yet or all borrowed books are returned.</p>";
                echo "<a href='userwelcome.php' class='btn btn-primary'><i class='fa fa-home'></i> Back to Home</a>";
                echo "</div>";

            }

            // Close statement
            mysqli_stmt_close($stmt);
        }

        // Close connection
        mysqli_close($conn);
        ?>
    </div>
</body>
</html>
