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
            height: 100vh;
            background-color: #171717;
            color: white;
        }

        .container {
            display: flex;
            height: 100%;
        }

        .sidebar {
            width: 200px;
            background-color: #080808;
            color: #fff;
            padding: 20px;
            box-sizing: border-box;
            height: 100%;
            overflow-y: auto;
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
            border-bottom: none;
        }

        .song-list li:hover {
            background-color: #999999;
        }

        .song-title {
            flex-grow: 1;
        }

        .song-duration {
            margin-left: 10px;
            color: #888;
        }

        .song-artist {
            text-align: center;
            flex-grow: 6;
        }

        .add-button {
            position: absolute;
            top: 80px;
            left: 125px;
            background-color: darkred;
            color: #ffffff;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
        }

        .add-button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <h2 style="display: flex; align-items: center;">Your Library
                <button class="add-button" onclick="handleAddPlaylist()">+</button>
            </h2>
            <ul id="playlist">
                <?php
                include('connection.php');
                $uid = $_SESSION['id'];
                $sql = "SELECT * FROM playlist WHERE playlist.UserID = $uid";
                $playlists = mysqli_query($con, $sql);

                foreach ($playlists as $playlistData) {
                    echo "<a href='#' onclick='showPlaylist(\"" . $playlistData["PlaylistID"] . "\")'><li>" . $playlistData['Playlist Title'] . "</li></a>";
                }
                ?>
            </ul>
            <button class="add-button" onclick="handleAddPlaylist()">+</button>
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
                success: function (response) {
                    $('#playlist-content').html(response);
                }
            });
        }

        function handleAddPlaylist() {
            var playlistName = prompt("Give your playlist a name:", "");
            if (playlistName != null && playlistName != "") {
                $.ajax({
                    type: 'POST',
                    url: 'create_playlist.php',
                    data: { playlistName: playlistName },
                    success: function (response) {
                        $('#playlist-content').html(response);

                        $.ajax({
                            type: 'GET',
                            url: 'getPlaylists.php',
                            success: function (playlistResponse) {
                                $('#playlist').html(playlistResponse);
                            }
                        });
                    }
                });
            } else {
                console.log("Playlist name not provided");
            }
        }

        function playSong(songTitle) {
            // TODO: Implement the logic to play the selected song
            alert('Playing: ' + songTitle);
        }


    </script>

</body>

</html>