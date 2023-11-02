<?php

$servername = "music.mysql.database.azure.com";
$username = "david";
$password = "Decon_0213";
$dbname = "music";
$port = 3306;

$con = mysqli_init();
mysqli_ssl_set($con, NULL, NULL, "DigiCertGlobalRootCA.crt.pem", NULL, NULL);
mysqli_real_connect($con, $servername, $username, $password, $dbname, $port, MYSQLI_CLIENT_SSL);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$conn = $con;

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$connLoginMember = $conn;
$connMember = $conn;
$connLoginAdmin = $conn;

?>
