<?php
include('connection.php');
include('navloggedin.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Search</title>
</head>
<body class="background">
    <h1 class="library-title">Music Search</h1>
    <div class="main-content">
        <form method="get" action="">
            <label for="query">Search:</label>
            <input type="text" id="query" name="query" required>
            <button class="create-playlist-button">Search</button>
        </form>
    </div>
    <div id="results">
        <?php
        
        function addSongToPlaylist($SongID, $PlaylistID){
            die();
            $sql = "INSERT INTO playlistsongs VALUES ($PlaylistID, $SongID)";
        }

        if (isset($_GET['query'])) {
            $query = mysqli_real_escape_string($con, $_GET['query']);
            $sql = "SELECT * FROM song WHERE SongTitle LIKE '%$query%' OR Genre LIKE '%$query%' OR artistName LIKE '%$query%'";
            $uid = $_SESSION['id'];
            $result = mysqli_query($con, $sql);

            $sql = "SELECT * FROM playlist WHERE playlist.UserID = $uid";
            $playlists = mysqli_query($con, $sql);

            if ($result) {
                $results = mysqli_fetch_all($result, MYSQLI_ASSOC);

                if (count($results) > 0) {
                    echo '<table>';
                    echo '<tr><th>Song ID</th><th>Title</th><th>Artist</th><th>Genre</th></tr>';
                    foreach ($results as $row) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['SongID']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['SongTitle']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['artistName']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Genre']) . "</td>";
                        echo "<td class='no-border-cell'>";
                        
                        echo "<div class='dropdown'>";

                        echo "<a href='#' class='add-to-playlist-link'><img src='images/green-plus-button.png' height='25px' width='25px' alt='Add to Playlist'></img></a>";

                        echo "<div class='dropdown-content'>";

                        foreach ($playlists as $playlist){
                            $playlistID = $playlist['PlaylistID'];
                            $songID = $row['SongID'];

                            echo "<a href='add_to_playlist.php?songID=" . $row['SongID'] . "&playlistID=" . $playlistID . "&query=" . urlencode($_GET['query']) . "'>" . $playlist['Playlist Title'] . "</a>";
                        }
                        
                        echo "</div></div>";
                        
                        echo "</td>";
                        echo "</tr>";
                    }
                    
                    echo '</table>';
                } else {
                    echo "<p>No results found</p>";
                }
            } else {
                echo "<p>Error executing query: " . htmlspecialchars(mysqli_error($con)) . "</p>";
            }
        }
        if (isset($_GET['popupMessage'])) {
            $popupMessage = htmlspecialchars($_GET['popupMessage']);
            echo "<script>alert('$popupMessage');</script>";
        }
        ?>
    </div>
</body>
</html>
