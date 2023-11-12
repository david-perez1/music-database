
<?php
// Include the database connection from connection.php 
require 'connection.php'; // Using require ensures the file must be present
include('Admin_Portal.php');

// Check if connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// The SQL query to fetch top 10 Artists (based on play_count)
$sql = "SELECT artistName
FROM song
ORDER BY play_count DESC 
LIMIT 10";

// Execute the query
$result = $conn->query($sql);

// Check if query was successful
if (!$result) {
    die("Error: " . $conn->error);
}

// Start the HTML output
echo '<table border="1" style="margin-top:100px;">'; // You can add 'class' or 'id' attributes to style it with CSS
echo '<tr><th>Artist Name</th></tr>';
    
// Check if we have artists
if ($result->num_rows > 0) {
    // Fetch the results
    while ($song = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($song['artistName']) . '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="3">No artists found.</td></tr>';
}

// End the HTML table
echo '</table>';

// Close the connection
$conn->close();
?>