<?php
// Assuming you have a database connection set up and it's included in this script.
include('connection.php');
// Function to call when a song is played
function incrementPlayCount($songId) {
    global $conn;
    // Database connection
    // $conn = /* Your database connection variable */;
    
    // SQL query to increment play coun
    $query = 'UPDATE song SET play_count = play_count + 1 WHERE SongID = ?';
    
    // Prepare statement
    if ($stmt = $conn->prepare($query)) {
        // Bind the SongID to the parameter in the SQL query
        $stmt->bind_param("i", $songId);
        
        // Execute the query
        $stmt->execute();
        
        // Check for successful update
        if ($stmt->affected_rows > 0) {
            echo "Play count incremented.";
        } else {
            echo "Song not found or no need to update play count.";
        }
        
        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if songId is provided in the POST data
    if (isset($_POST['songId'])) {
        // Call the function with the POSTed song ID
        incrementPlayCount($_POST['songId']);
    } else {
        // If no songId was provided, output an error message
        echo "Song ID not provided in request.";
    }
}

// Close the database connection
$conn->close();
// Example usage:
// incrementPlayCount(1); 
?>
