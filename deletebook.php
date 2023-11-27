<?php
$mysqli = mysqli_connect("mi-linux", "2349472", "52t0w1", "db2349472");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $bookId = intval($_GET['id']);

    $deleteQuery = "DELETE FROM Books WHERE bookID = ?";
    $stmt = $mysqli->prepare($deleteQuery);
    $stmt->bind_param("i", $bookId);
    $stmt->execute();
    $stmt->close();
}

$mysqli->close();

header("Location: page1.php");
exit();
?>
