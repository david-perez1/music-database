<?php
// rateASong.php

include('connection.php');

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
            // Rating is a valid integer, you can now update the rating
    
            // Check if a rating already exists for the given SongID
            $existingRatingQuery = mysqli_query($con, "SELECT * FROM rating_system WHERE SongID = '$songID'");
            
            if ($existingRatingQuery) {
                if (mysqli_num_rows($existingRatingQuery) > 0) {
                    // Rating already exists, update the existing rating
                    $updateQuery = mysqli_query($con, "UPDATE rating_system SET RatingValue = '$ratingValue' WHERE SongID = '$songID'");
                } else {
                    // No rating exists, insert a new rating
                    $updateQuery = mysqli_query($con, "INSERT INTO rating_system (SongID, RatingValue) VALUES ('$songID', '$ratingValue')");
                }
    
                if ($updateQuery) {
                    // Rating updated successfully
                    echo "Rating updated successfully!";
                    // Redirect to my_library.php after successful rating update
                    header("Location: my_library.php");
                    exit();
                } else {
                    // Error updating rating
                    echo "Error updating rating: " . mysqli_error($con);
                }
            } else {
                // Error with the query
                echo "Error with the query: " . mysqli_error($con);
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
