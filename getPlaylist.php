<?php
include('entities/Song.php');
include('entities/Playlist.php');
include('connection.php');

$playlistID = $_POST['playlistID'];
$playlist = new Playlist($con, $playlistID);

echo '<style>';
echo '.playlist-header { display: flex; align-items: center; }';
echo '.playlist-image { max-width: 300px; max-height: 300px; margin-right: 20px; }';
echo '.playlist-title { font-size: 40px; }';
echo '.song-table { width: 100%; margin: 50px 0; background-color: black; color: white; }';
echo '.song-table th, .song-table td { border: 1px solid #ddd; padding: 15px; text-align: left; }'; 
echo '.song-table th { background-color: #333; }';
echo '.song-table td { background-color: #222; }';
echo '.song-table tr:nth-child(even) { background-color: #111; }';
echo '.song-table th:nth-child(1), .song-table td:nth-child(1) { width: 50%; }'; // Adjusted width for the first column
echo '.song-table th:nth-child(2), .song-table td:nth-child(2) { width: 40%; }'; // Adjusted width for the second column
echo '.song-table th:nth-child(3), .song-table td:nth-child(3) { width: 30%; }'; // Adjusted width for the third column
echo '.song-table th:nth-child(4), .song-table td:nth-child(4) { width: 20%; }'; // Adjusted width for the fourth column
echo '</style>';


echo '<div class="playlist-header">';
echo '<img src="' . $playlist->getImage() . '" alt="Playlist Image" class="playlist-image">';
echo '<h1 class="playlist-title">' . $playlist->getName() . '</h1>';
echo '</div>';

echo '<table class="song-table">';
echo '<thead>';
echo '<tr>';
echo '<th>Title</th>';
echo '<th>Artist</th>';
echo '<th>Duration</th>';
echo '<th>Rating Value</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

if ($playlist->isEmpty()) {
    echo '<tr><td colspan="4" style="text-align: center;">This playlist is empty.</td></tr>';
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
        echo '<tr>';
        echo '<td>' . $song->getTitle() . '</td>';
        echo '<td>' . $song->getArtistName() . '</td>';
        echo '<td>' . $formattedDuration . '</td>';
        echo '<td>' . $rating . '</td>';
        echo '</tr>';
    }

    // Add Rate A Song button
    echo "<tr>";
    echo "<td colspan='4' style='text-align: center;'>";
    echo "<form method='get' action='rateASong.php'>";
    echo "<input type='hidden' name='playlistID' value='$playlistID'>";
    echo "<input type='submit' name='rateASong' value='Rate A Song'>";
    echo "</form>";
    echo "</td>";
    echo "</tr>";

    // Add Delete Playlist button
    echo "<tr>";
    echo "<td colspan='4' style='text-align: center;'>";
    echo "<form method='post' action='deletePlaylist.php'>";
    echo "<input type='hidden' name='playlistID' value='$playlistID'>";
    echo "<input type='submit' name='deletePlaylist' value='Delete Playlist'>";
    echo "</form>";
    echo "</td>";
    echo "</tr>";
}

echo '</tbody>';
echo '</table>';

function formatDuration($durationInSeconds)
{
    $minutes = floor($durationInSeconds / 60);
    $seconds = $durationInSeconds % 60;

    return sprintf('%02d:%02d', $minutes, $seconds);
}
?>
