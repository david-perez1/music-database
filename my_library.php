<?php
  include('navloggedin.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Playlist Library</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    height: 100vh; /* Set body height to 100% of the viewport height */
    background-color: #171717;
    color: white;
}

.container {
    display: flex;
    height: 100%; /* Set container height to 100% of the viewport height */
}

.sidebar {
    width: 200px;
    background-color: #080808;
    color: #fff;
    padding: 20px;
    box-sizing: border-box;
    height: 100%; /* Set sidebar height to 100% of the viewport height */
    overflow-y: auto; /* Add a scrollbar if the content overflows */
}

.sidebar h2 {
    margin-bottom: 20px;
}

.sidebar ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar li {
    cursor: pointer;
    transition: background-color 0.3s ease;
    padding: 10px 0;
    line-height: 1.5;
    height: auto;
    margin-bottom: 0;
}

/* Hover effect */
.sidebar li:hover {
    background-color: #555;
}

.content {
    flex-grow: 1;
    padding: 20px;
    box-sizing: border-box;
}

.content h2 {
    margin-bottom: 20px;
}
.song-list li {
    cursor: auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    border-bottom: 1px solid #ccc;
    transition: background-color 0.3s ease;
}

.song-list li:last-child {
    border-bottom: none; /* Remove border for the last item */
}

.song-list li:hover {
    background-color: #999999;
}

.song-title {
    flex-grow: 1; /* Take up remaining space */
}

.song-duration {
    margin-left: 10px;
    color: #888;
}

.song-artist {
    text-align: center; /* Center the text */
    flex-grow: 6; /* Take up remaining space */
}


    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>Your Library</h2>
            <ul id="playlist">
            <?php
                include('connection.php');
                $uid = $_SESSION['id'];
                $sql = "SELECT * FROM playlist WHERE playlist.UserID = $uid";
                $playlists = mysqli_query($con, $sql);

                foreach ($playlists as $playlistData) {
                    // Wrap the entire <li> element in an anchor tag
                    echo "<a href='#' onclick='showPlaylist(\"" .$playlistData["PlaylistID"] . "\")'><li>" . $playlistData['Playlist Title'] . "</li></a>";
                }
                ?>
            </ul>
        </div>
        <div class="content">
            
            <div id="playlist-content">
                
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function showPlaylist(playlistID) {
            $.ajax({
                type: 'POST',
                url: 'getPlaylist.php',
                data: { playlistID: playlistID },
                success: function(response) {
                    $('#playlist-content').html(response);
                }
            });
        }
        function playSong(songTitle) {
            // Implement the logic to play the selected song
            alert('Playing: ' + songTitle);
        }
    </script>

</body>
</html>
