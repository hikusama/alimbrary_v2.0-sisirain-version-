<?php
// Include config file
require_once "config.php";

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card-user {
            margin-bottom: 20px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .card-user .card-header {
            background-color: #007bff;
            color: #fff;
            border-bottom: none;
            border-radius: 15px 15px 0 0;
        }
        .card-user .card-body {
            padding: 20px;
        }
        .card-user .card-body h5 {
            font-size: 20px;
            margin-bottom: 10px;
            color: white;
        }
        .card-user .card-body p {
            font-size: 14px;
            margin-bottom: 5px;
            color: white;
        }
        .bg-admin {
            background-color: #007bff;
        }
        .bg-user {
            background-color: #28a745;
        }
        .text-admin {
            color: #007bff;
        }
        .text-user {
            color: #28a745;
        }
        .btn-back {
            background-color: #007bff;
            color: #fff;
            border-radius: 10px;
            padding: 10px 20px;
            text-decoration: none;
        }
        .btn-back:hover {
            background-color: #0056b3;
            color: #fff;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Users Dashboard</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php
                        // Query to retrieve users information
                        $sql = "SELECT id, username, created_at, user_type FROM users";

                        // Execute the query
                        $result = mysqli_query($conn, $sql);

                        // Check if the query was successful
                        if ($result) {
                            // Check if there are any rows returned
                            if (mysqli_num_rows($result) > 0) {
                                // Fetch rows and display data
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $cardColorClass = $row['user_type'] === 'admin' ? 'bg-admin text-admin' : 'bg-user text-user';
                                    echo '<div class="col-md-6">
                                            <div class="card '.$cardColorClass.' card-user">
                                                <div class="card-body">
                                                    <h5 class="card-title"><i class="fa fa-user"></i> '.$row['username'].'</h5>
                                                    <p class="card-text"><i class="fa fa-id-badge"></i> User ID: '.$row['id'].'</p>
                                                    <p class="card-text"><i class="fa fa-clock-o"></i> Joined: '.$row['created_at'].'</p>
                                                    <p class="card-text"><i class="fa fa-user-circle-o"></i> '.ucfirst($row['user_type']).'</p>
                                                </div>
                                            </div>
                                        </div>';
                                }
                            } else {
                                // No users found
                                echo '<p class="text-center">No users available.</p>';
                            }
                            // Free result set
                            mysqli_free_result($result);
                        } else {
                            // Query execution failed
                            echo '<p class="text-center">Error: ' . mysqli_error($conn) . '</p>';
                        }

                        // Close the connection
                        mysqli_close($conn);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-3">
        <div class="col-md-8">
            <a href="welcomeadmin.php" class="btn btn-back"><i class="fa fa-home"></i> Back to Home</a>
        </div>
    </div>
</div>

</body>
</html>
