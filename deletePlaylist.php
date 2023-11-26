<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deletePlaylist'])) {
    $playlistID = $_POST['playlistID'];

    

    $sql = "DELETE FROM playlistsongs WHERE PlaylistID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $playlistID);

    if ($stmt->execute()) {
        $sql = "DELETE FROM playlist WHERE PlaylistID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $playlistID);

    if ($stmt->execute()) {
        header('Location: my_library.php'); 
        exit();
    } else {
        
        echo "Error deleting playlist.";
    }
    } else {
        
        echo "Error deleting playlist.";
    }



    $stmt->close();
}


?>
