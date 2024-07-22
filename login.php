<?php
session_start();
// If the user is already logged in, redirect them to the index page
if (isset($_SESSION["user"])) {
   header("Location: index.php");
   exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
        // Check if the login form is submitted
        if (isset($_POST["login"])) {
           $email = $_POST["email"];
           $password = $_POST["password"];
           
           // Include the database connection file
            require_once "database.php";
            
            // Prepare SQL query to fetch user with the given email
            $sql = "SELECT * FROM users WHERE email = ?";
            $stmt = mysqli_stmt_init($conn);
            
            // Check if the SQL statement can be prepared
            if (mysqli_stmt_prepare($stmt, $sql)) {
                // Bind parameters to the SQL query
                mysqli_stmt_bind_param($stmt, "s", $email);
                
                // Execute the query
                mysqli_stmt_execute($stmt);
                
                // Get the result of the query
                $result = mysqli_stmt_get_result($stmt);
                $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // If user exists, verify the password
                if ($user) {
                    if (password_verify($password, $user["password"])) {
                        // If password matches, start a session and set session variables
                        session_start();
                        $_SESSION["user"] = $user["full_name"];
                        
                        // Redirect to index page after successful login
                        header("Location: index.php");
                        exit();
                    } else {
                        // If password doesn't match, show an error message
                        echo "<div class='alert alert-danger'>Password does not match</div>";
                    }
                } else {
                    // If email doesn't exist, show an error message
                    echo "<div class='alert alert-danger'>Email does not match</div>";
                }
            } else {
                // If SQL statement can't be prepared, show an error message
                echo "<div class='alert alert-danger'>Something went wrong. Please try again later.</div>";
            }
        }
        ?>
        <!-- Login form -->
        <form action="login.php" method="post">
            <div class="form-group">
                <!-- Email input field -->
                <input type="email" placeholder="Enter Email:" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <!-- Password input field -->
                <input type="password" placeholder="Enter Password:" name="password" class="form-control" required>
            </div>
            <div class="form-btn">
                <!-- Login button -->
                <input type="submit" value="Login" name="login" class="btn btn-primary">
            </div>
        </form>
        <!-- Link to registration page -->
        <div>
            <p>Not registered yet? <a href="registration.php">Register Here</a></p>
        </div>
    </div>
</body>
</html>
