<?php
include('connection.php');

if (isset($_GET['songID']) && isset($_GET['playlistID'])) {

    $songID = $_GET['songID'];
    $playlistID = $_GET['playlistID'];

    $sql = "SELECT * FROM playlistsongs WHERE SongID = $songID AND PlaylistID = $playlistID";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        $errorMessage = "Song is already in the playlist.";
        header('Location: search-page.php?query=' . urlencode($_GET['query']) . '&popupMessage=' . urlencode($errorMessage));
        exit();
    } else {

        $sql = "INSERT INTO playlistsongs (PlaylistID, SongID) VALUES ($playlistID, $songID)";

        try {
            if (mysqli_query($con, $sql)) {
                $message = "Successfully added to playlist.";
                header('Location: search-page.php?query=' . urlencode($_GET['query']) . '&popupMessage=' . urlencode($message));
                exit();
            } else {
                $error = mysqli_error($con);

                if (strpos($error, "Playlist duration exceeds 5 minutes") !== false) {
                    $errorMessage = "Error: Playlist duration exceeds 5 minutes.";
                } else {
                    $errorMessage = "Error adding song to the playlist: " . $error;
                }

                throw new mysqli_sql_exception($errorMessage);
            }
        } catch (mysqli_sql_exception $e) {
            $errorMessage = $e->getMessage();
            header('Location: search-page.php?query=' . urlencode($_GET['query']) . '&popupMessage=' . urlencode($errorMessage));
            exit();
        }
    }
} else {
    echo "Invalid parameters for adding the song to the playlist.";
}
?>
