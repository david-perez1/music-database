<?php
include('connection.php');
session_start();
$uid = $_SESSION['id'];
$sql = "SELECT * FROM playlist WHERE playlist.UserID = $uid";
$playlists = mysqli_query($con, $sql);

foreach ($playlists as $playlistData) {
    echo "<a href='#' onclick='showPlaylist(\"" . $playlistData["PlaylistID"] . "\")'><li>" . $playlistData['PlaylistTitle'] . "</li></a>";
}
?>
