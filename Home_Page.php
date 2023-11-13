<?php include('navloggedin.php');
/* include('connection.php'); */ 
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
        <div style="background-image: url('spongebobpic.jpeg');"></div>
      </a>
      <a href="my_library.php">
        <div style="background-image: url('edmpicture.jpeg');"></div>
      </a>
      <a href="my_library.php">
        <div style="background-image: url('oceanpic.jpeg');"></div>
      </a>
      <a href="my_library.php">
        <div style="background-image: url('djpic.jpeg');"></div>
      </a>
    </div>
  </div>
</body>

</html>
