<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrow History</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .card-header {
            background-color: white;
            color: black;
            border-radius: 15px 15px 0 0;
        }

        .card-body {
            padding: 20px;
        }

        .table {
            background-color: #fff;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }
    </style>
</head>

<body>


    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-end">
                        <h2 class="header-title">Borrow History</h2>
                            <a href="welcomeadmin.php" class="btn btn-primary"><i class="fa fa-home"></i> Back to Home</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <?php
                            // Include config file
                            require_once "config.php";

                            // Function to show borrow history
                            function showBorrowHistory($conn)
                            {
                                // Query to retrieve all borrow history information with book title
                                $sql = "SELECT borrowed_books.borrow_id, borrowed_books.borrow_date, borrowed_books.return_date, users.id, users.username, books.title 
                                        FROM borrowed_books 
                                        INNER JOIN users ON borrowed_books.user_id = users.id
                                        INNER JOIN books ON borrowed_books.book_id = books.book_id
                                        LEFT JOIN return_history ON borrowed_books.borrow_id = return_history.borrow_id
                                        ORDER BY borrowed_books.borrow_id DESC";

                                // Execute the query
                                $result = mysqli_query($conn, $sql);

                                // Check if the query was successful
                                if ($result && mysqli_num_rows($result) > 0) {
                                    // Display borrow history information in a table
                                    echo '<table class="table table-bordered table-striped">
                                            <thead class="bg-primary text-light">
                                                <tr>
                                                    <th class="text-center">Borrow ID</th>
                                                    <th class="text-center">User ID</th>
                                                    <th class="text-center">Username</th>
                                                    <th class="text-center">Book Title</th>
                                                    <th class="text-center">Borrow Date</th>
                                                    <th class="text-center">Return Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>';

                                    // Fetch rows and display data
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<tr>
                                                <td class="text-center">' . $row['borrow_id'] . '</td>
                                                <td class="text-center">' . $row['id'] . '</td>
                                                <td>' . $row['username'] . '</td>
                                                <td>' . $row['title'] . '</td>
                                                <td class="text-center">' . $row['borrow_date'] . '</td>
                                                <td class="text-center">' . ($row['return_date'] ? $row['return_date'] : 'Not returned') . '</td>
                                            </tr>';
                                    }
                                    echo '</tbody></table>';
                                } else {
                                    // No borrow history found
                                    echo '<p class="text-center">No borrow history available.</p>';
                                }
                                // Free result set
                                mysqli_free_result($result);
                            }

                            // Call the function to display borrow history
                            showBorrowHistory($conn);

                            // Close the connection
                            mysqli_close($conn);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>