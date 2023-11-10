<?php
// Start the session or check if the session already started
// if (session_status() == PHP_SESSION_NONE) {
//     session_start();
// }

include('connection.php');
include('navloggedin.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in and the member_ID is set in the session
if(!isset($_SESSION['id'])) {
    // Redirect to login page or display an error message if member_ID is not set
    die("User is not logged in. Please log in to upload a song.");
}

// Assign member_ID from session to a variable
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
<html>
<head>
    <!-- Your head content -->
</head>
<body class="background">

<form action="" method="post" enctype="multipart/form-data">
    Select song to upload:
    <input type="file" name="songToUpload" id="songToUpload" accept=".mp3"><br>
    Song Title: <input type="text" name="SongTitle" required><br>
    Genre: <input type="text" name="Genre"><br>
    Release Date: <input type="date" name="ReleaseDate"><br>
    Artist Name: <input type="text" name="artistName"><br>
    
    <input type="submit" value="Upload Song" name="submit">
</form>

<!-- Rest of your body content -->

</body>
</html>
