<?php
include('entities/Song.php');
include('connection.php');

$songID = $_GET['id'] ?? null;

if (!$songID) {
    die("No song ID provided.");
}

$song = new Song($con, $songID);

$songInfo = array(
    'title' => $song->getTitle(),
    'artistName' => $song->getArtistName(),
    'duration' => $song->getDuration()
);

header('Content-Type: application/json');

echo json_encode($songInfo);
?>
