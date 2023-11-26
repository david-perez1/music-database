<?php 
include('navloggedin.php'); 
// include('connection.php');
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <style>
        body {
            /* font-family: Arial, sans-serif; */
            background-color: #f6f6f6;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body class = "background">

    <!-- <div class="mx-auto max-w-screen-xl px-6 py-12 font-sans md:px-12 md:py-20 lg:px-24 lg:py-0"> -->
    

    <!-- <div class="top-strip">
        <div class="search-bar">
            <input type="text" placeholder="Search..." style="padding: 8px; border-radius: 5px; border: none;">
            <button type="submit" style="background-color: #e65c4e; color: white; border: none; padding: 10px 20px; font-size: 16px; border-radius: 5px; cursor: pointer;">Search</button>
        </div>
        <div class="home-button">
            <button>Home</button>
        </div>
    </div> -->

    <div class="main-content">
        <div class="library-section">
            <h2 class="library-title">My Library</h2>
            <button class="create-playlist-button" onclick="createPlaylist()">Make Playlist</button>
            <button class="upload-song-button" onclick="openFileUploader()">Upload Song</button>
        </div>
        <div class="playlist-section" id="playlistSection">
            
        </div>
    </div>

    

    <script>
        function createPlaylist() {
            var playlistName = prompt("Give your playlist a name:", "");
            if (playlistName != null && playlistName != "") {
                window.location.href = "create_playlist.php?name=" + playlistName;
            } else {
                console.log("Playlist name not provided");
            }
        }

        function openFileUploader() {
            var input = document.createElement('input');
            input.type = 'file';
            input.accept = '.mp4';
            input.onchange = function (event) {
                var file = event.target.files[0];
                if (file.type === "video/mp4") {
                    console.log("Uploading file:", file.name);
                } else {
                    alert("Please upload an MP4 file.");
                }
            };
            input.click();
        }
    </script>
    </div>
</body>


</html>
