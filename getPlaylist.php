<?php
include('entities/Song.php');
include('entities/Playlist.php');
include('connection.php');

$playlistID = $_POST['playlistID'];
$playlist = new Playlist($con, $playlistID);

echo '<h1 class="playlist-title">' . $playlist->getName() . '</h1>';

echo '<ul class="song-list">';
echo '<li>';
echo '<span class="song-title">Title</span>';
echo '<span class="song-artist">Artist</span>';
echo '<span class="song-duration">Duration</span>';
echo '</li>';

echo '<ul>';
if ($playlist->isEmpty()) {
    echo '<div class="items-center justify-center md:pl-64 md:pr-64 mx-auto md:mt-10"><p style="color: gray;">This playlist is empty.</p></div>';
} else {
    foreach ($playlist->getSongIds() as $sid) {
        $song = new Song($con, $sid);
        $formattedDuration = formatDuration($song->getDuration());

        echo '<script src="queue.js"></script>';
        echo '<a ondblclick="updateSession(' . $song->getSongID() . ')">';
        echo '<li>';
        echo '<span class="song-title">' . $song->getTitle() . '</span>';
        echo '<span class="song-artist">' . $song->getArtistName() . '</span>';
        echo '<span class="song-duration">' . $formattedDuration . '</span>';
        
        echo '</li>';
        echo '</a>';
        
    }

    // Add Delete Playlist button
    echo "<li>";
    echo "<form method='post' action='deletePlaylist.php'>";
    echo "<input type='hidden' name='playlistID' value='$playlistID'>";
    echo "<input type='submit' name='deletePlaylist' value='Delete Playlist'>";
    echo "</form>";
    echo "</li>";
}
echo '</ul>';

function formatDuration($durationInSeconds)
{
    $minutes = floor($durationInSeconds / 60);
    $seconds = $durationInSeconds % 60;

    return sprintf('%02d:%02d', $minutes, $seconds);
}
?>