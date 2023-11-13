<?php
// rateASong.php

include('connection.php');
session_start();
// Assume $userID is obtained from session or other means of user identification
// $userID = $_SESSION['UserID'] ; // Replace with actual user session variable or method to retrieve user ID
if (isset($_SESSION['id'])) {
    $userID = $_SESSION['id'];
}

// Check if PlaylistID is set
if (isset($_GET['playlistID'])) {
    $playlistID = $_GET['playlistID'];

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rateSong'])) {
        // Get the SongID and RatingValue from the form
        $songID = $_POST['songID'];
        $ratingValue = $_POST['ratingValue'];

        // Validate that the rating value is an integer
        if (filter_var($ratingValue, FILTER_VALIDATE_INT) !== false) {
            // Prepare a statement for the existing rating check
            $stmt = $con->prepare("SELECT * FROM rating_system WHERE SongID = ? AND UserID = ?");
            $stmt->bind_param("ii", $songID, $userID);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();

            if ($result) {
                if ($result->num_rows > 0) {
                    // Rating already exists, update the existing rating
                    $stmt = $con->prepare("UPDATE rating_system SET RatingValue = ? WHERE SongID = ? AND UserID = ?");
                    $stmt->bind_param("iii", $ratingValue, $songID, $userID);
                } else {
                    // No rating exists, insert a new rating
                    // Note: RatingID is auto-generated, no need to bind it
                    $stmt = $con->prepare("INSERT INTO rating_system (UserID, RatingValue, SongID) VALUES (?, ?, ?)");
                    $stmt->bind_param("iii", $userID, $ratingValue, $songID);
                }
                
                // Execute the update or insert
                $success = $stmt->execute();
                $stmt->close();

                if ($success) {
                    // Rating updated successfully
                    echo "Rating updated successfully!";
                    // Redirect to my_library.php after successful rating update
                    header("Location: my_library.php");
                    exit();
                } else {
                    // Error updating rating
                    echo "Error updating rating: " . $con->error;
                }
            } else {
                // Error with the query
                echo "Error with the query: " . $con->error;
            }
        } else {
            // Invalid rating value
            echo "Please enter a valid integer for the rating.";
        }
    } else {
        // Display the form to rate a song
        echo "<h2>Rate A Song</h2>";

        // Fetch the songs from the playlist for the user to choose
        $songsQuery = mysqli_query($con, "SELECT s.SongID, s.SongTitle FROM song s INNER JOIN playlistsongs ps ON s.SongID = ps.SongID WHERE ps.PlaylistID = '$playlistID'");
        $songs = mysqli_fetch_all($songsQuery, MYSQLI_ASSOC);

        echo "<form method='post' action='rateASong.php?playlistID=$playlistID'>";
        echo "Select a song to rate: <select name='songID'>";
        foreach ($songs as $song) {
            echo "<option value='" . $song['SongID'] . "'>" . $song['SongTitle'] . "</option>";
        }
        echo "</select><br>";

        echo "Enter a rating (an integer): <input type='text' name='ratingValue'><br>";
        echo "<input type='submit' name='rateSong' value='Rate Song'>";
        echo "</form>";
    }
} else {
    // PlaylistID not set
    echo "PlaylistID not provided.";
}
?>
