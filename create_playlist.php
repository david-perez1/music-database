<?php 
include('connection.php');

session_start();

$playlistName = $_POST['playlistName'];
$playlistImage = $_POST['image'];  
$todayDate = date("Y-m-d");
$userID = $_SESSION['id'];

try {
    $sql = "INSERT INTO playlist (`PlaylistTitle`, `UserID`, `CreatedDate`, `image`) VALUES ('$playlistName', '$userID', '$todayDate', '$playlistImage')";
    $conn->query($sql);

    if ($conn->errno) {
        throw new Exception($conn->error);
    }

} catch (Exception $e) {
    $errorMessage = $e->getMessage();

    if (strpos($errorMessage, 'User already has 10 playlists') !== false) {
        echo "<script>alert('You cannot have more than 10 playlists!');</script>";
    } else {
        error_log("Error: " . $errorMessage, 3, "error_log.txt");

        echo "<script>alert('An error occurred. Please try again later.');</script>";
    }
}
?>
