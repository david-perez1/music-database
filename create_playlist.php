<?php 
include('connection.php');

session_start();

$playlistName = $_POST['playlistName'];
$todayDate = date("Y-m-d");
$userID = $_SESSION['id'];
$sql = "INSERT INTO playlist (`Playlist Title`, UserID, CreatedDate) VALUES ('$playlistName', '$userID', '$todayDate')";
$conn->query($sql);
?>