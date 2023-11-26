<?php 
include('connection.php');

session_start();

$playlistName = $_POST['playlistName'];
$playlistImage = $_POST['image'];  
$todayDate = date("Y-m-d");
$userID = $_SESSION['id'];

$sql = "INSERT INTO playlist (`PlaylistTitle`, `UserID`, `CreatedDate`, `image`) VALUES ('$playlistName', '$userID', '$todayDate', '$playlistImage')";
$conn->query($sql);

?>
