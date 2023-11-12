<?php
include('connection.php');

// Check if the necessary parameters are provided
if (isset($_GET['SongID']) && isset($_GET['RatingValue']) && isset($_GET['id'])) {
    // Get values from the GET parameters
    $songID = $_GET['SongID'];
    $ratingValue = $_GET['RatingValue'];
    $userID = $_GET['id'];

    // Get the current date
    $ratingDate = date('Y-m-d');

    // Prepare and execute the SQL statement to insert a new rating
    $sql = "INSERT INTO rating_system (UserID, SongID, RatingValue, RatingDate) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iiss', $userID, $songID, $ratingValue, $ratingDate);

    if ($stmt->execute()) {
        echo "Rating added successfully!";
    } else {
        echo "Error adding rating: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid parameters. Please provide SongID, RatingValue, and UserID.";
}
?>
