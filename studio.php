<?php
// Start the session or check if the session already started
// if (session_status() == PHP_SESSION_NONE) {
//     session_start();
// }

include('connection.php');
include('navloggedin.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in and the member_ID is set in the session
if (!isset($_SESSION['id'])) {
    // Redirect to the login page or display an error message if member_ID is not set
    die("User is not logged in. Please log in to upload a song.");
}

// Assign member_ID from the session to a variable
$artistID = $_SESSION['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["songToUpload"])) {
    $songTitle = $_POST['SongTitle'] ?? 'Unknown Title';  // Set a default value in case the input is empty
    $temp_song_file = $_FILES["songToUpload"]["tmp_name"];

    $genre = $_POST["Genre"] ?? null;
    $releaseDate = $_POST["ReleaseDate"] ?? null;
    $artistName = $_POST["artistName"] ?? null;

    $upload_directory = 'uploads/';
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0755, true)) {
            die("Failed to create upload directory: " . $upload_dir);
        }
    }

    if (!is_writable($upload_dir)) {
        die("Upload directory is not writable: " . $upload_dir);
    }
    $fileData = $upload_directory . basename($songTitle);

    if (move_uploaded_file($temp_song_file, $fileData)) {
        // Prepare an insert statement with ArtistID
        $insert_query = "INSERT INTO song (SongTitle, ReleaseDate, ArtistName, Genre, FileData, ArtistID) VALUES (?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($insert_query)) {
            // Bind the ArtistID along with other parameters
            $stmt->bind_param("sssssi", $songTitle, $releaseDate, $artistName, $genre, $fileData, $artistID);

            if ($stmt->execute()) {
                echo "Song uploaded and stored in the database successfully.";
            } else {
                echo "Error storing the song in the database: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error preparing the statement: " . $conn->error;
        }
    } else {
        echo "Song upload failed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Song - Your Music Library</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #ff0000; 
            background-image: url(C:\xampp\htdocs\music-database\images\musical-notes.png); 
            background-repeat: repeat;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
        }

        input {
            margin-bottom: 16px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="file"] {
            margin-bottom: 20px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
            border: none;
            padding: 12px;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Upload Song</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="songToUpload">Select song to upload:</label>
            <input type="file" name="songToUpload" id="songToUpload" accept=".mp3">
            
            <label for="SongTitle">Song Title:</label>
            <input type="text" name="SongTitle" required>
            
            <label for="Genre">Genre:</label>
            <input type="text" name="Genre">
            
            <label for="ReleaseDate">Release Date:</label>
            <input type="date" name="ReleaseDate">
            
            <label for="artistName">Artist Name:</label>
            <input type="text" name="artistName">
            
            <input type="submit" value="Upload Song" name="submit">
        </form>
    </div>

</body>

</html>
