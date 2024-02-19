<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$user_type = $username = $password = "";
$usertype_err = $username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, username, password, user_type FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $user_type);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["user_type"] = $user_type;

                            if ($user_type == "admin") {
                                header("location: welcome.php");
                            } else {
                                header("location: nothing.html");
                            }
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else {
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
//ALEM, AL-KHAZRE SALE
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            background-image: url('images/bg-img.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        .modal-title {
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        p {
            text-align: center;
        }
    </style>
</head>

<body>
    
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div>
            <h1 class="bg-warning text-light rounded">ALIMBRARY v2.0</h1>
            <div class="container d-flex justify-content-center align-items-center">
                <button type="button" class="btn btn-secondary font-weight-bold text-light" data-bs-toggle="modal" data-bs-target="#loginFormModal">
                    Click here to login
                </button>
            </div>
        </div>
    </div>

    <div class="modal fade" id="loginFormModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header ">
                    <div class="container">
                        <h3 class="text-center">Login</h3>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Please fill in your credentials to login.</p>

                    <?php
                    // Initialize variables to avoid PHP errors
                    $login_err = '';
                    $username = '';
                    $password_err = '';

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        // Check if username is empty
                        if (empty(trim($_POST["username"]))) {
                            $username_err = "Please enter username.";
                        } else {
                            $username = trim($_POST["username"]);
                        }

                        // Check if password is empty
                        if (empty(trim($_POST["password"]))) {
                            $password_err = "Please enter your password.";
                        } else {
                            $password = trim($_POST["password"]);
                        }

                        // Validate credentials
                        if (empty($username_err) && empty($password_err)) {
                            // Perform authentication here
                        } else {
                            // Display error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                    ?>

                    <?php if (!empty($login_err)) : ?>
                        <div class="alert alert-danger"><?php echo $login_err; ?></div>
                    <?php endif; ?>

                    <form id="loginForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($username); ?>">
                            <span class="invalid-feedback"><?php echo $username_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                            <span class="invalid-feedback"><?php echo $password_err; ?></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary btn-block" value="Login">
                        </div>
                        <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>

