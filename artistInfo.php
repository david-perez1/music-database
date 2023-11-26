<?php
include('connection.php'); 


if (isset($_GET['artistName'])) {
    $artistName = $_GET['artistName'];

    $sql = "SELECT ArtistName, Biography FROM artist WHERE ArtistName = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $artistName);
    $stmt->execute();
    $stmt->bind_result($artistName, $biography);

    
    if ($stmt->fetch()) {
        
        echo "<h1>{$artistName}</h1>";
        echo "<p>{$biography}</p>";
    } else {
        
        echo "Artist not found.";
    }

   
    $stmt->close();
} else {
    
    echo "Invalid request. Please provide an ArtistName.";
}
?>
