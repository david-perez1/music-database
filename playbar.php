<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <style>
    body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .bottom-bar {
            background-color: #333; /* Set the background color of the bar */
            color: #fff; /* Set the text color */
            padding: 15px; /* Adjust padding as needed */
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
            z-index: 9999;
        }

        .center-buttons {
            align-self: center;
        }
        .center-buttons img {
            width: 40px; /* adjust as needed */
            height: 40px; /* adjust as needed */
        }

  </style>
</head>
<body>

  <!-- Your page content goes here -->

  <div class="bottom-bar">
    <div class="center-buttons">
      <button onclick="">
        <img src="images/skip_backward.svg" alt="Back">
      </button>
      <button onclick="playOrPauseSong()">
        <img src="images/play.svg" alt="Play">
      </button>
      <button onclick="playNextSong()">
        <img src="images/skip_forward.svg" alt="Skip">
      </button>
    </div>
  </div>

  <script src="queue.js"></script>

</body>
</html>



