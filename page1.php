<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];

$mysqli = mysqli_connect("mi-linux", "2349472", "52t0w1", "db2349472");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}


$recordsPerPage = 8;
$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start = ($current_page - 1) * $recordsPerPage;

if (isset($_GET['search'])) {
    $searchTerm = '%' . $_GET['search'] . '%';

    $query = "SELECT bookId, bookName, bookAuthor, bookGenre, bookRating, bookRelease, bookPrice 
              FROM Books 
              WHERE bookName LIKE ? OR 
                    bookAuthor LIKE ? OR 
                    bookGenre LIKE ? OR 
                    bookRating LIKE ? OR 
                    bookRelease LIKE ? OR 
                    bookPrice LIKE ?
              LIMIT ?, ?";
    
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('ssssssii', $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $start, $recordsPerPage);
} else {
    $query = "SELECT bookId, bookName, bookAuthor, bookGenre, bookRating, bookRelease, bookPrice 
              FROM Books 
              LIMIT ?, ?";
    
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('ii', $start, $recordsPerPage);
}

$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Site</title>
    <link rel="stylesheet" href="page1style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <h1>Your Library</h1>
	
    <form action="page1.php" method="get">
        <label for="search">Search:</label>
        <input type="text" id="search" name="search" placeholder="Enter book information">
        <button type="submit">Search</button>
    </form>

    <table border="2">
        <tr>
            <th>Book ID</th>
            <th>Book Name</th>
            <th>Book Author</th>
            <th>Book Genre</th>
            <th>Book Rating</th>
            <th>Book Release</th>
            <th>Book Price</th>
            <th>Action</th>
        </tr>

        <?php
        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                    <td>' . $row['bookId'] . '</td>
                    <td>' . $row['bookName'] . '</td>
                    <td>' . $row['bookAuthor'] . '</td>
                    <td>' . $row['bookGenre'] . '</td>
                    <td>' . $row['bookRating'] . '</td>
                    <td>' . $row['bookRelease'] . '</td>
                    <td>' . $row['bookPrice'] . '</td>
                    <td>
                        <a href="deletebook.php?id=' . $row['bookId'] . '" onclick="return confirm(\'Are you sure you want to delete this book?\')">Delete</a>
                    </td>
                </tr>';
        }
        ?>

    </table>
	
    <?php
    $query = "SELECT COUNT(*) as total FROM Books";
    $result = $mysqli->query($query);
    $row = $result->fetch_assoc();
    $totalRecords = $row['total'];

    $totalPages = ceil($totalRecords / $recordsPerPage);

    echo '<div class="pagination">';
    for ($i = 1; $i <= $totalPages; $i++) {
        echo '<a href="?page=' . $i . '">' . $i . '</a>';
    }
    echo '</div>';

    $mysqli->close();
    ?>
<p><a href="addbook.php">Add a new book</a></p>
<p><a href="filter.html">Filter books</a></p>
<header>
	<nav>
        <p><a href="page2.php">Log Out</a></p>
    </nav>
  </header>


</body>
</html>
