<?php
// Include config file
require_once "config.php";

$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
$username = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter your username.";
    } else {
        $username = trim($_POST["username"]);
    }

    //new password
    if (empty(trim($_POST["new_password"]))) {
        $new_password_err = "Please enter the new password.";
    } elseif (strlen(trim($_POST["new_password"])) < 6) {
        $new_password_err = "Password must have at least 6 characters.";
    } else {
        $new_password = trim($_POST["new_password"]);
    }

    //confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm the password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($new_password_err) && ($new_password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before updating the database
    if (empty($new_password_err) && empty($confirm_password_err)) {
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE username = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $param_password, $param_username);

            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_username = $username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Password updated successfully. Redirect to login page
                header("location: login.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="bg-img">
        <div class="content">
            <header>Reset Password</header>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="field">
                    <span class="fa fa-user"></span>
                    <input type="text" class="form-control pass-key" name="username" required placeholder="Username">
                </div>
                <div class="field space">
                    <span class="fa fa-lock"></span>
                    <input type="password" class="form-control pass-key" name="new_password" required placeholder="New Password">
                </div>
                <div class="field space">
                    <span class="fa fa-lock"></span>
                    <input type="password" class="form-control pass-key" name="confirm_password" required placeholder="Confirm Password">
                </div>
                <div class="pass">
                  <a href=""> </a>
               </div>
                <div class="field">
                    <input type="submit" value="Submit">
                </div>
            </form>
            <?php if (!empty($new_password_err) || !empty($confirm_password_err)) : ?>
               <div class="error">
                   <?php echo $new_password_err; ?>
                   <?php echo $confirm_password_err; ?>
               </div>
            <?php endif; ?>
            <div class="signup">
                <a href="login.php" class="btn btn-link">Back to Login</a>
            </div>
        </div>
    </div>
</body>
</html>
