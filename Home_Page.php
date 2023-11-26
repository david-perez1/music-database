<?php
include('navloggedin.php');
include('connection.php'); 
include('entities/Song.php');

// Assuming you have a session variable for the user ID
$uid = $_SESSION['id'];

// Fetch notifications for the logged-in user
$sql = "SELECT * FROM notification WHERE UserID = $uid";
$notificationResult = mysqli_query($con, $sql);

// Check if notifications were fetched successfully
if ($notificationResult) {
    $notifications = mysqli_fetch_all($notificationResult, MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cougify - Your Music Library</title>
  <style>

    .home_paragraph {
    font-size: 25px; 
    }
   
    .container {
      display: flex;
      justify-content: space-around;
      margin-top: 50px;
    }

    .container a {
      text-decoration: none;
      color: inherit; 
    }

    .container div {
      width: 300px;
      height: 300px;
      background-size: cover;
      background-position: center;
      border-radius: 10px;
      border: 1px solid #ccc; 
      margin: 10px; 
      transition: transform 0.3s; 
    }

    .container div:hover {
      transform: scale(1.1);
    }
  </style>
</head>

<body class="background">
  <div class="mx-auto max-w-screen-xl px-6 py-12 font-sans md:px-12 md:py-20 lg:px-24 lg:py-0">
    <div class="items-center justify-center md:pl-64 md:pr-64 mx-auto md:mt-10">
      <?php
      if (isset($_SESSION['loggedin'])) {
        echo "<p class='text-center text-white text-4xl font-bold tracking-tight sm:text-5xl md:mt-20'>Welcome back,</p><p class='text-center text-blue-500 text-4xl font-bold tracking-tight sm:text-5xl'>" . $_SESSION['name'] . "</p>";
      }
      ?>
      <p class="home_paragraph">
      Jump back in ...
    </p>
    </div>
    <div class="container">
      <a href="my_library.php">
        <div style="background-image: url('imageUploads/spongebobpic.jpeg');"></div>
      </a>
      <a href="my_library.php">
        <div style="background-image: url('imageUploads/edmpicture.jpeg');"></div>
      </a>
      <a href="my_library.php">
        <div style="background-image: url('imageUploads/oceanpic.jpeg');"></div>
      </a>
      <a href="my_library.php">
        <div style="background-image: url('imageUploads/djshaq.png');"></div>
      </a>
    </div>
    <?php
   // Display notifications
if (!empty($notifications)) {
  echo '<ul>';
  $combinedNotifications = '';

  foreach ($notifications as $notification) {
      $artistID = htmlspecialchars($notification['ArtistID']);
      $songID = htmlspecialchars($notification['SongID']);
      $userID = htmlspecialchars($notification['UserID']);

      $song = new Song($con, $songID);
      $combinedNotifications .= '<div class="notification-container">';
      $combinedNotifications .= '<p class="notification-title">&#x1F514; New Song Notification!</p>';
      $combinedNotifications .= '<p>We have a new song from Artist: <strong>' . $song->getArtistName() . '</strong>.</p>';
      $combinedNotifications .= '<p>Song: <strong>' . $song->getTitle() . '</strong></p>';
      $combinedNotifications .= '</div>';
  }

  echo '<div class="notification-box">' . $combinedNotifications . '</div>';
  echo '</ul>';
} else {
  echo '<p>No notifications</p>';
}

    ?>
  </div>
</body>

</html>
