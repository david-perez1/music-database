<?php

include('connection.php');
include('entities/Playlist.php');

session_start();

$pid = $_GET['playlistID'];
$playlist = new Playlist($con, $pid);

$songIds = array_map('intval', $playlist->getSongIds());

echo json_encode($songIds);
?>