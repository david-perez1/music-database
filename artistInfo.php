<?php
include('connection.php'); // Include your database connection file

// Check if ArtistName is set in the URL
if (isset($_GET['artistName'])) {
    $artistName = $_GET['artistName'];

    // Fetch artist information from the database
    $sql = "SELECT ArtistName, Biography FROM artist WHERE ArtistName = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $artistName);
    $stmt->execute();
    $stmt->bind_result($artistName, $biography);

    // Fetch the result
    if ($stmt->fetch()) {
        // Output artist information
        echo "<h1>{$artistName}</h1>";
        echo "<p>{$biography}</p>";
    } else {
        // Handle case where artist is not found
        echo "Artist not found.";
    }

    // Close the statement
    $stmt->close();
} else {
    // Handle case where ArtistName is not set in the URL
    echo "Invalid request. Please provide an ArtistName.";
}
?>
