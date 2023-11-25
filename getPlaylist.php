<?php
include('entities/Song.php');
include('entities/Playlist.php');
include('connection.php');

$playlistID = $_POST['playlistID'];
$playlist = new Playlist($con, $playlistID);

echo '<h1 class="playlist-title" style="text-align: left; font-size: 40px;">' . $playlist->getName() . '</h1>';
echo '<img src="' . $playlist->getImage() . '" alt="Playlist Image" style="width: 300px; height: 300px;">';
echo '<ul class="song-list">';
echo '<li>';
echo '<span class="song-title">Title</span>';
echo '<span class="song-artist">Artist</span>';
echo '<span class="song-duration">Duration</span>';
echo '<span class="song-rating-value">Rating Value</span>';
echo '</li>';

echo '<ul>';
if ($playlist->isEmpty()) {
    echo '<div class="items-center justify-center md:pl-64 md:pr-64 mx-auto md:mt-10"><p style="color: gray;">This playlist is empty.</p></div>';
} else {
    foreach ($playlist->getSongIds() as $sid) {
        $song = new Song($con, $sid);
        $formattedDuration = formatDuration($song->getDuration());
        $songID = $song->getSongID();
        $ratingQuery = mysqli_query($con, "SELECT RatingValue FROM rating_system WHERE SongID = '$songID'");

        if ($ratingQuery) {
            if (mysqli_num_rows($ratingQuery) > 0) {
                $ratingData = mysqli_fetch_assoc($ratingQuery);
                $rating = isset($ratingData['RatingValue']) ? $ratingData['RatingValue'] : null;
            } else {
                // Log a message or handle the case where no rows were returned
                error_log("No rows found for SongID: $songID in rating_system");
                $rating = null;
            }
        } else {
            // Log the MySQL error for debugging
            error_log("MySQL error: " . mysqli_error($con));
            $rating = null;
        }
        echo '<script src="queue.js"></script>';
        echo '<a ondblclick="updateSession(' . $song->getSongID() . ')">';
        echo '<li>';
        echo '<span class="song-title">' . $song->getTitle() . '</span>';
        echo '<span class="song-artist">' . $song->getArtistName() . '</span>';
        echo '<span class="song-duration">' . $formattedDuration . '</span>';
        echo '<span class="song-rating-value">' . $rating . '</span>';
        echo '<span class="image">' . $playlistImage . '</span>';
        echo '</a>';
        
    }

    // Add Rate A Song button
    echo "<li>";
    echo "<form method='get' action='rateASong.php'>";
    echo "<input type='hidden' name='playlistID' value='$playlistID'>";
    echo "<input type='submit' name='rateASong' value='Rate A Song'>";
    echo "</form>";
    echo "</li>";

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
