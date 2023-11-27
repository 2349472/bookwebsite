<?php
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputUsername = isset($_POST["username"]) ? htmlspecialchars($_POST["username"]) : "";
    $inputPassword = isset($_POST["password"]) ? htmlspecialchars($_POST["password"]) : "";


    // Connecting to database
    $mysqli = new mysqli("mi-linux", "2349472", "52t0w1", "db2349472");

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $stmt = $mysqli->prepare("SELECT username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $inputUsername);
    $stmt->execute();
    $stmt->bind_result($username, $hashedPassword);
    $stmt->fetch();
    $stmt->close();

    if ($username && password_verify($inputPassword, $hashedPassword)) {
        $_SESSION['username'] = $username;

        if (isset($_POST["remember"])) {
            setcookie("remember_username", $username, time() + (7 * 24 * 3600), "/");
            setcookie("remember_password", $inputPassword, time() + (7 * 24 * 3600), "/");
        }

        header("Location: welcome.php");
        exit();
    } else {
        $error_message = "Invalid username or password. Please try again.";
    }

    $mysqli->close();
}

$isLoggedIn = isset($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="page1style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
 <h1>Log In to your Account</h1>
    <?php
    if ($isLoggedIn) {
        header("Location: welcome.php");
        exit();
    } else {
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo isset($_COOKIE['remember_username']) ? htmlspecialchars($_COOKIE['remember_username']) : ''; ?>" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" value="<?php echo isset($_COOKIE['remember_password']) ? htmlspecialchars($_COOKIE['remember_password']) : ''; ?>" required>
        <label><input type="checkbox" name="remember"> Remember Me</label>
        <button type="submit">Submit</button>
    </form>

    <p>Don't have an account? <a href="register.php">Register</a></p>

    <?php
    if (isset($error_message)) {
        echo '<div class="error-message">' . $error_message . '</div>';
    }
    }
    ?>

</body>
</html>
