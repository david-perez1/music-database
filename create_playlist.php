<?php 
include('navloggedin.php'); 
// include('connection.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <link href="allWebApp.css" rel="stylesheet">
  <style>
    body {
      background-color: light black; 
    }

    h2 {
      font-family: 'Bangers', sans-serif; 
      font-size: 80px;
      font-weight: normal; 
      text-align: center;
      color: white;
    }

    .playlist-container {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .playlist-item {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
      padding: 10px;
      background-color: white;
      border-radius: 20px;
    }

    .playlist-image {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      margin-left: 10px;
    }
  </style>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cougify</title>
</head>

<body>
  <div class="mx-auto max-w-screen-xl px-6 py-12 font-sans md:px-12 md:py-20 lg:px-24 lg:py-0">
    <div class="items-center justify-center md:pl-64 md:pr-64 mx-auto md:mt-10">
      <h2>My Library</h2>

      <div class="playlist-container">
        <?php 
        if (isset($_SESSION['loggedin'])) {
          // Hard coded playlists for now 
          $samplePlaylists = array(
            array("name" => "Road Trip Mix", "image" => "pawprint.jpeg"),
            array("name" => "Chill Vibes", "image" => "pawprint.jpeg"),
            array("name" => "Workout Jams", "image" => "pawprint.jpeg")
           
          );

          foreach ($samplePlaylists as $playlist) {
            echo '<div class="playlist-item">';
            echo '<div class="playlist-bubble">' . htmlspecialchars($playlist["name"]) . '</div>';
            echo '<img class="playlist-image" src="' . $playlist["image"] . '" alt="' . $playlist["name"] . '">';
            echo '</div>';
          }
        }
        ?>
      </div>
    </div>
  </div>
</body>

</html>
