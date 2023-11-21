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
      background-color: #333;
      color: #fff;
      padding: 25px;
      text-align: center;
      position: fixed;
      bottom: 0;
      width: 100%;
      z-index: 9999;
      max-height: 80px;
      min-height: 80px; /* Set a minimum height to prevent the bar from collapsing */
    }

    .center-buttons {
      position: fixed;
      left: 50%;
      transform: translate(-50%, -20%);
    }

    .center-buttons img {
      width: 40px; /* adjust as needed */
      height: 40px; /* adjust as needed */
    }

    .currently-playing {
      float: left; /* Set the div to the left side */
      margin-right: 20px; /* Adjust margin as needed for spacing */
      margin-top: -10px;
      text-align: left;
    }

    #progressBar {
      position: fixed;
      left: 50%;
      bottom: 0.75%;
      transform: translate(-50%, 0%);
      width: 25%;
      height: 8px;
    }
  </style>
</head>
<body>

<!-- Your page content goes here -->

<div class="bottom-bar">
  <div class="currently-playing" id="currentlyPlayingElement"></div>
  <progress id="progressBar" value="0" max="100"></progress>
  <div class="center-buttons">
    <button onclick="prev()">
      <img src="images/skip_backward.svg" alt="Back">
    </button>
    <button onclick="playOrPauseSong()">
      <img id="playPauseImage" src="images/play.svg" alt="Play">
    </button>
    <button onclick="next()">
      <img src="images/skip_forward.svg" alt="Skip">
    </button>
  </div>
</div>

<script src="queue.js"></script>
</body>
</html>
