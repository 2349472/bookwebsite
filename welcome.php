<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome</title>
  <link rel="stylesheet" href="page1style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

   
    <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
    <header>
	<nav>
      <ul id="welcome">
        <p><a href="page1.php">Your Library</a></p>
        <p><a href="page2.php">Log Out</a></p>
      </ul>
    </nav>
  </header>

</body>
</html>