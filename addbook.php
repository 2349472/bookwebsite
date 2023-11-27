<?php
$mysqli = mysqli_connect("mi-linux", "2349472", "52t0w1", "db2349472");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookName = isset($_POST["bookName"]) ? htmlspecialchars($_POST["bookName"]) : "";
    $bookAuthor = isset($_POST["bookAuthor"]) ? htmlspecialchars($_POST["bookAuthor"]) : "";
    $bookGenre = isset($_POST["bookGenre"]) ? htmlspecialchars($_POST["bookGenre"]) : "";
    $bookRating = isset($_POST["bookRating"]) ? htmlspecialchars($_POST["bookRating"]) : "";
    $bookRelease = isset($_POST["bookRelease"]) ? htmlspecialchars($_POST["bookRelease"]) : "";
    $bookPrice = isset($_POST["bookPrice"]) ? htmlspecialchars($_POST["bookPrice"]) : "";


    $insertQuery = "INSERT INTO Books (bookName, bookAuthor, bookGenre, bookRating, bookRelease, bookPrice) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($insertQuery);
    $stmt->bind_param("ssssss", $bookName, $bookAuthor, $bookGenre, $bookRating, $bookRelease, $bookPrice);
    $stmt->execute();
    $stmt->close();
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <link rel="stylesheet" href="page1style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <h1>Add Book</h1>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="bookName">Book Name:</label>
        <input type="text" id="bookName" name="bookName" required>

        <label for="bookAuthor">Book Author:</label>
        <input type="text" id="bookAuthor" name="bookAuthor" required>

        <label for="bookGenre">Book Genre:</label>
        <input type="text" id="bookGenre" name="bookGenre" required>

        <label for="bookRating">Book Rating:</label>
        <input type="text" id="bookRating" name="bookRating" required>

        <label for="bookRelease">Book Release:</label>
        <input type="text" id="bookRelease" name="bookRelease" required>

        <label for="bookPrice">Book Price:</label>
        <input type="text" id="bookPrice" name="bookPrice" required>

        <button type="submit">Add Book</button>
		
    </form>

    <p><a href="page1.php">Go back to Your Library</a></p>

</body>
</html>
