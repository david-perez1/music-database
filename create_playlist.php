<?php 
include('navloggedin.php'); 
include('connection.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cougify</title>
</head>

<body class="background">
  <div class="mx-auto max-w-screen-xl px-6 py-12 font-sans md:px-12 md:py-20 lg:px-24 lg:py-0">
    <div class="items-center justify-center md:pl-64 md:pr-64 mx-auto md:mt-10">
      <?php if (isset($_SESSION['loggedin'])) {
        
        $playlistName = "My Playlist";
        if (isset($_GET['name'])) {
          $playlistName = $_GET['name'];
          echo htmlspecialchars($playlistName);
        }
        $userID = $_SESSION['id'];
        $todayDate = date("Y-m-d");

        $sql = "INSERT INTO playlist (`Playlist Title`, UserID, CreatedDate) VALUES ('$playlistName', '$userID', '$todayDate')";
        $conn->query($sql);

      } ?>
      
      <!-- <p class="home_paragraph">
      </p> -->
    </div>
    </div>
</body>

</html>