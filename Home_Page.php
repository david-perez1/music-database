<?php include('navloggedin.php'); ?>

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
        echo "<p class='text-center text-white text-4xl font-bold tracking-tight sm:text-5xl md:mt-20'>Welcome back,</p><p class='text-center text-blue-500 text-4xl font-bold tracking-tight sm:text-5xl'>" . $_SESSION['name'] . "</p>";
      } ?>
      <p class="home_paragraph">
        Welcome to Cougify!
      </p>
      <!-- <p class="home_paragraph">
        Join the growing Oleum community and discover the convenience of obtaining quotes and reviewing your order
        history. From wellhead to market, Oleum has your back. Experience the future of oil management with Oleum today!
      </p> -->
    </div>
    </div>
</body>

</html>