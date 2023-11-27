<?php
// Start the session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUsername = isset($_POST["newUsername"]) ? htmlspecialchars($_POST["newUsername"]) : "";
    $newPassword = isset($_POST["newPassword"]) ? htmlspecialchars($_POST["newPassword"]) : "";

    if (!empty($newUsername) && !empty($newPassword)) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $mysqli = mysqli_connect("mi-linux", "2349472", "52t0w1", "db2349472");

        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: " . $mysqli->connect_error;
            exit();
        }

        $checkUsernameQuery = "SELECT * FROM users WHERE username = '$newUsername'";
        $result = mysqli_query($mysqli, $checkUsernameQuery);

        if (mysqli_num_rows($result) > 0) {
            $error_message = "Username already exists. Please choose a different username.";
        } else {
            $insertUserQuery = "INSERT INTO users (username, password) VALUES ('$newUsername', '$hashedPassword')";

            if (mysqli_query($mysqli, $insertUserQuery)) {
                header("Location: index.php");
                exit();
            } else {
                $error_message = "Error registering user: " . mysqli_error($mysqli);
            }
        }

        mysqli_close($mysqli);
    } else {
        $error_message = "Please fill in all fields for registration.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register for an Account</title>
    <link rel="stylesheet" href="page1style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <h1>Register for an Account</h1>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="newUsername">New Username:</label>
        <input type="text" id="newUsername" name="newUsername" required>

        <label for="newPassword">New Password:</label>
        <input type="password" id="newPassword" name="newPassword" required>

        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="index.php">Login</a></p>

    <?php
    if (isset($error_message)) {
        echo '<div class="error-message">' . $error_message . '</div>';
    }
    ?>

</body>
</html>
