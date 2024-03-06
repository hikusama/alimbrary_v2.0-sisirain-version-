<?php
// Start session
session_start();

// Check if the user is logged in and is an admin, if not then redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["user_type"] !== "admin") {
    header("location: login.php");
    exit;
}

// Include config file
require_once "config.php";

// Define SQL query to fetch return history data
$return_history_sql = "SELECT return_history.return_id, users.username, books.title, return_history.returned_date_time 
                        FROM return_history
                        JOIN users ON return_history.user_id = users.id
                        JOIN books ON return_history.book_id = books.book_id
                        ORDER BY return_history.returned_date_time DESC";

// Execute the query
$result = mysqli_query($conn, $return_history_sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Return History</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        h2 {
            margin-top: 0;
            margin-bottom: 20px;
            text-align: center;

        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
        }

        th {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }

        tbody tr:hover {
            background-color: #f2f2f2;
        }

        .btn-home {
            position: absolute;
            top: 20px;
            right: 20px;

            border-radius: 15px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2><i class="fa fa-book"></i> Return History</h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Return ID</th>
                    <th>User</th>
                    <th>Title</th>
                    <th>Date Returned</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through each row in the result set
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['return_id'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['title'] . "</td>";
                    echo "<td>" . $row['returned_date_time'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="welcomeadmin.php" class="btn btn-primary btn-home">Back to Home</a>

    </div>
</body>

</html>

<?php
// Close connection
mysqli_close($conn);
?>
