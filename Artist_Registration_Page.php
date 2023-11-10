<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    include('connection.php');

    // Collect and sanitize input data
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Consider hashing this password
    $artistName = mysqli_real_escape_string($conn, $_POST['artistName']);
    $bio = mysqli_real_escape_string($conn, $_POST['bio']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);

    // SQL to insert user into 'users' table
    // $user_query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
    // mysqli_query($conn, $user_query);

    // Assuming you get the user_id as last inserted ID
    // $user_id = mysqli_insert_id($conn);

    // SQL to insert artist into 'artist' table
    // $artist_query = "INSERT INTO artist (name, bio, genre, user_id) VALUES ('$artistName', '$bio', '$genre', '$user_id')";
    // mysqli_query($conn, $artist_query);

    // Check for errors and give appropriate message
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Artist Registration</title>
    <link href="allWebApp.css" rel="stylesheet">
    <!-- Add any additional styles if needed -->
</head>
<body>
<section class="background-radial-gradient md:overflow-hidden">
    <style>
        .background-radial-gradient {
        background-color: rgb(141, 0, 0);
        background-blend-mode: lighten;
        height: 100%;
        margin: 0;
        padding: 0;
        background-image: url('cougarloginpage.jpeg');
        background-position: center 20%; 
        background-size: 1000px 1000px; /* Ensures the image covers the entire viewport */ 
        background-repeat: no-repeat; 
        }

        @media (min-width: 768px) {

        }
    </style>
    <div class="px-6 py-12 text-center md:px-12 lg:py-24 lg:text-left h-screen flex items-center justify-center">
        <div class="w-100 mx-auto text-neutral-800 sm:max-w-2xl md:max-w-3xl lg:max-w-5xl xl:max-w-7xl">
            <div class="grid items-center">
                <div class="relative mb-12 lg:mb-0">
                    <div class="bg-blue-200 backdrop-blur-[25px] backdrop-saturate-[200%] block rounded-lg px-6 py-12 md:px-12">
                        <form action="Create_Artist_Handler_Member.php" method="POST">
                            <h1 class="my-6 text-3xl font-bold text-center">Artist Registration</h1>

                            <button class="mb-6 bg-blue-600 inline-block w-full rounded bg-primary px-6 pt-2.5 pb-2 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]">Register</button>
                            <!-- User registration fields -->
                            <input type="text" name="username" placeholder="Username" required class="block w-full p-4 text-lg rounded-sm">
                            <input type="email" name="email" placeholder="Email" required class="block w-full p-4 text-lg rounded-sm">
                            <input type="password" name="password" placeholder="Password" required class="block w-full p-4 text-lg rounded-sm">

                            <!-- Artist specific fields -->
                            <input type="text" name="artistName" placeholder="Artist Name" required class="block w-full p-4 text-lg rounded-sm">
                            <textarea name="bio" placeholder="Bio" class="block w-full p-4 text-lg rounded-sm"></textarea>
                            <input type="text" name="Country" placeholder="Country" required class="block w-full p-4 text-lg rounded-sm">

                            <button type="submit" class="mb-6 bg-blue-600 ...">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>