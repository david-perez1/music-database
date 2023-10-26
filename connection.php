<?php

$servername = "localhost";
$username = "root";
$password = "Decon_0213";
$dbname = "mydb";

$conn = new mysqli($servername, $username, $password, $dbname);

$connLoginMember = mysqli_connect($servername, $username, $password, $dbname);

$connMember = mysqli_connect($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!$connLoginMember) {
    echo ":(";
    die("Connection failed: " . mysqli_connect_error());
}

if (!$connMember) {
    die("Connection failed: " . mysqli_connect_error());
}

?>