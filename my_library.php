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
}

.container {
    display: flex;
    height: 100%; /* Set container height to 100% of the viewport height */
}

.sidebar {
    width: 200px;
    background-color: #333;
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
    margin: 0; /* Remove default margin on ul */
}

.sidebar li {
    cursor: pointer;
    transition: background-color 0.3s ease; /* Add a smooth transition effect */
    padding: 10px 0; /* Adjust padding for better spacing */
    line-height: 1.5; /* Adjust line height for better spacing */
    height: auto; /* Allow the height to adjust based on content */
    margin-bottom: 0; /* Remove the margin-bottom */
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
                    echo "<li>" . $playlistData['Playlist Title'] . "</li>";
                }
            ?>
            </ul>
        </div>
        <div class="content">
            <h2>Playlist Content</h2>
            <div id="playlist-content">
                <!-- Playlist content will be displayed here -->
            </div>
        </div>
    </div>
</body>
</html>
