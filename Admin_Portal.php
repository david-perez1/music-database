<?php

include('connection.php');

session_start();

if (!isset($_SESSION['loggedin'])) {
  header('Location: index.php');
  exit;
}

$loggedIn = isset($_SESSION['user_id']);

$navbarOpen = false;
function setNavbarOpen($value)
{
  global $navbarOpen;
  $navbarOpen = $value;
}
?>
<link href="allWebApp.css" rel="stylesheet">

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const navbarToggle = document.querySelector(".feather-menu");
    const mobileNav = document.getElementById("example-navbar-danger");

    let navbarOpen = false;

    navbarToggle.addEventListener("click", function () {
      navbarOpen = !navbarOpen;
      mobileNav.style.display = navbarOpen ? "block" : "none";
    });
  });
</script>

<!-- <!Doctype html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta charset="utf-8">
    <title>Cougify</title>
    <link href="allWebApp.css" rel="stylesheet" >
 
</head>

<body class = "background">
    <nav class="navtop">
        <div>
            <h1>Cougify</h1>
        </div>
    </nav>
    <div class="content update">
        <div class="parent">
            <div class="category-container">
                <div class="portal-category">
                    <div class="category-image">
                        <img src="attractions.png">
                    </div>
                    <div class="category-info">
                        <h2 class="category-name">Attraction Report</h2>
                        <p class="category-description"></p>
                        <a href="attractionReport.html"><button class="visit-link">Click Here</button></a>
                    </div>
                </div>
                
                
            </div>
        </div>
    </div>
</body> -->
<body class = "background">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" type="image/x-icon" href="Music header.ico">
    <div>

    <nav class="bg-gray-100">
        <div class="max-w-6xl mx-auto px-4">
        <div class="flex justify-between">

            <div class="flex space-x-4">
            <!-- logo -->
            <div>
                <a href="Admin_portal.php" class="flex items-center py-5 px-2 text-gray-700 hover:text-gray-900">
                <svg class="h-6 w-6 mr-1 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
                <span class="font-bold">Cougify</span>
                </a>
            </div>

            <!-- primary nav -->
            <div class="hidden md:flex items-center space-x-1">
                <a href="GenreReport.php" class="py-5 px-3 text-gray-700 hover:text-gray-900">Top 10 Genres</a>
                <a href="viewedReport.php" class="py-5 px-3 text-gray-700 hover:text-gray-900">Top 10 Viewed Songs</a>
                <a href="25Artists.php" class="py-5 px-3 text-gray-700 hover:text-gray-900">Top 25 Artists</a>
                <!-- <a href="PlayBar-Anneka.php?title=SongTitle" class="py-5 px-3 text-gray-700 hover:text-gray-900">Top 10 Rated Songs</a> -->
                <a href="ratedReport.php" class="py-5 px-3 text-gray-700 hover:text-gray-900">Top 10 Rated Songs</a>




            </div>
            </div>

            <!-- secondary nav -->
            <div class="hidden md:flex items-center space-x-1">
            <a href="Logout_Member.php"
                class="py-2 px-3 bg-yellow-400 hover:bg-yellow-300 text-yellow-900 hover:text-yellow-800 rounded transition duration-300">Sign out</a>
            </div>

            <!-- mobile button goes here -->
            <div class="md:hidden flex items-center">
            <button class="mobile-menu-button">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            </div>

        </div>
        </div>

        <!-- mobile menu -->
        <div class="mobile-menu hidden md:hidden">
        <a href="search-page.php" class="block py-2 px-4 text-sm hover:bg-gray-200">Search</a>
        <a href="create_playlist.php" class="block py-2 px-4 text-sm hover:bg-gray-200">Create Playlist</a>
        <a href="Logout_Member.php" class="block bg-yellow-300 py-2 px-4 text-sm hover:bg-gray-200">Sign Out</a>
        </div>
    </nav>

    <script>
        // grab everything we need
        const btn = document.querySelector("button.mobile-menu-button");
        const menu = document.querySelector(".mobile-menu");

        // add event listeners
        btn.addEventListener("click", () => {
        menu.classList.toggle("hidden");
        });
    </script>
</body>
