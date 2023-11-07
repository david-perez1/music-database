<?php
include('connection.php');

    if (isset($_GET['songID']) && isset($_GET['playlistID'])) {

        $songID = $_GET['songID'];
        $playlistID = $_GET['playlistID'];

        $sql = "SELECT * FROM playlistsongs WHERE SongID = $songID AND PlaylistID = $playlistID";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            $errorMessage = "Song is already in the playlist.";
            header('Location: search-page.php?query=' . urlencode($_GET['query']) . '&error=' . urlencode($errorMessage));
            exit();
        }
        else {

            $sql = "INSERT INTO playlistsongs (PlaylistID, SongID) VALUES ($playlistID, $songID)";
            if (mysqli_query($con, $sql)) {
                header('Location: search-page.php?query=' . urlencode($_GET['query']));
                exit();

            } else {
                echo "Error adding song to the playlist: " . mysqli_error($con);
            }
        }
    } else {
        echo "Invalid parameters for adding the song to the playlist.";
    }

?>
