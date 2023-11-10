<?php
include('navloggedin.php');
include('connection.php');
include('entities/Playlist.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cougify</title>
    <style>
        .different-color {
            background-color: #9c0202;
            height: 100%;
            width: 25%;
            position: absolute;
            left: 0;
            text-align: center;
        }

        .library-background {
            background-color: #800000;
            height: 100%;
        }

        .centered-list {
            display: inline-block;
            text-align: left;
            color: white;
        }

        .playlist-box {
            border: 2px solid white;
            padding: 100%;
            margin-bottom: 20px;
            border-radius: 0px;
           
        }
    </style>
</head>

<body>
    <div class="library-background">
        <div class="different-color">
            <ul class="centered-list">
                <?php
                $uid = $_SESSION['id'];
                $sql = "SELECT * FROM playlist WHERE playlist.UserID = $uid";
                $playlists = mysqli_query($con, $sql);

                foreach ($playlists as $playlistData) {
                    echo "<div class='playlist-box'><li>" . $playlistData['Playlist Title'] . "</li></div>";
                }

                ?>
            </ul>
        </div>
    </div>
</body>

</html>
