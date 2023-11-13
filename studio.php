<?php
// Start the session or check if the session already started
// if (session_status() == PHP_SESSION_NONE) {
//     session_start();
// }

include('connection.php');
include('navloggedin.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

function getMP3Duration($file_path) {
    require_once 'entities/getID3/getID3-1.9.23/getid3/getid3.php';

    $getID3 = new getID3;
    $file_info = $getID3->analyze($file_path);

    return isset($file_info['playtime_seconds']) ? $file_info['playtime_seconds'] : null;
}

// Check if user is logged in and the UserID is set in the session
if(!isset($_SESSION['id'])) {
    // Redirect to login page or display an error message if UserID is not set
    die("User is not logged in. Please log in to upload a song.");
}

// Assign UserID from session to a variable
$userID = $_SESSION['id'];

// Fetch the ArtistID based on the UserID
$artistIDQuery = "SELECT ArtistID FROM artist WHERE UserID = ?";
if ($stmt = $conn->prepare($artistIDQuery)) {
    $stmt->bind_param("i", $userID);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $artistID = $row['ArtistID'];  // Now you have the correct ArtistID
        } else {
            $error_message = "<div class='error-message'>Only Artist's are allowed to upload songs.</div>";
            // Use echo to output the error message and exit to stop script execution
            // echo $error_message;
            // exit;
        }
    } else {
        die("Error executing query to find artist ID: " . $conn->error);
    }
    $stmt->close();
} else {
    die("Error preparing the query to find artist ID: " . $conn->error);
}

// Proceed with file upload if ArtistID is found
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["songToUpload"])) {
    $songTitle = $_POST['SongTitle'] ?? 'Unknown Title';  // Set a default value in case the input is empty
    $temp_song_file = $_FILES["songToUpload"]["tmp_name"];

    $genre = $_POST["Genre"] ?? null;
    $releaseDate = $_POST["ReleaseDate"] ?? null;
    $artistName = $_POST["artistName"] ?? null;

    $upload_directory = 'uploads/';
    if (!is_dir($upload_directory)) {
        if (!mkdir($upload_directory, 0755, true)) {
            die("Failed to create upload directory: " . $upload_directory);
        }
    }

    if (!is_writable($upload_directory)) {
        die("Upload directory is not writable: " . $upload_directory);
    }

    $fileData = $upload_directory . basename($_FILES["songToUpload"]["name"]);

    if (move_uploaded_file($temp_song_file, $fileData)) {
        // Get the duration of the uploaded MP3 file
        $duration = getMP3Duration($fileData);

        // Prepare an insert statement with ArtistID and Duration
        $insert_query = "INSERT INTO song (SongTitle, ReleaseDate, ArtistName, Genre, FileData, ArtistID, Duration) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        if ($stmt = $conn->prepare($insert_query)) {
            // Bind the ArtistID, Duration, and other parameters
            $stmt->bind_param("sssssid", $songTitle, $releaseDate, $artistName, $genre, $fileData, $artistID, $duration);

            if ($stmt->execute()) {
                echo '<div style="text-align: center; margin-top: 20px; padding: 10px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px; width: 50%; margin-left: auto; margin-right: auto;">
            Song uploaded and stored in the database successfully.
          </div>';
            } else {
                echo '<div style="text-align: center; margin-top: 20px; padding: 10px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; width: 50%; margin-left: auto; margin-right: auto;">
            Error storing the song in the database: ' . htmlspecialchars($stmt->error) . '
          </div>';
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
    <!-- Your head content, like title, link to CSS, etc. -->
</head>
<body class="background">
    <?php if (isset($error_message)): ?>
            <div class='error-message'><?php echo $error_message;exit; ?></div>
        
    <?php endif; ?>
<!-- Center the form on the page -->
    <div style="width: 100%; display: flex; justify-content: center; align-items: center;">
        <form action="" method="post" enctype="multipart/form-data">
            <table align="center">
                <tr>
                    <td>Select song to upload:</td>
                    <td><input type="file" name="songToUpload" id="songToUpload" accept=".mp3"></td>
                </tr>
                <tr>
                    <td>Song Title:</td>
                    <td><input type="text" name="SongTitle" required></td>
                </tr>
                <tr>
                    <td>Genre:</td>
                    <td><input type="text" name="Genre"></td>
                </tr>
                <tr>
                    <td>Release Date:</td>
                    <td><input type="date" name="ReleaseDate"></td>
                </tr>
                <tr>
                    <td>Artist Name:</td>
                    <td><input type="text" name="artistName"></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;"><input type="submit" value="Upload Song" name="submit"></td>
                </tr>
            </table>
        </form>
    </div>

<!-- Rest of your body content -->

</body>
</html>
