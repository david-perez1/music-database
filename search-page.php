<?php

include('connection.php');
include('navloggedin.php')
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Search</title>
</head>
<body class = "background">
    <h1 class = "library-title">Music Search</h1>
        <div class = "main-content">
            <form method="get" action="">
                <label for="query">Search:</label>
                <input type="text" id="query" name="query" required>
                <button class="create-playlist-button">Search</button>
            </form>
        </div>
    <div id="results">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "Decon_0213";
        $dbname = "music";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            if (isset($_GET['query'])) {
                $query = $_GET['query'];
                $stmt = $conn->prepare("SELECT * FROM song WHERE SongTitle LIKE :query OR Genre LIKE :query OR artistName LIKE :query");
                $stmt->execute(['query' => "%$query%"]);

                $results = $stmt->fetchAll();
                
                if ($results) {
                    foreach ($results as $row) {
                        echo "<p>Song ID: " . htmlspecialchars($row['SongID']) . " - Title: " . htmlspecialchars($row['SongTitle']) . " - Artist: " . htmlspecialchars($row['artistName']) . " - Genre: " . htmlspecialchars($row['Genre']) . "</p>";
                    }
                } else {
                    echo "<p>No results found</p>";
                }
            }

        } catch(PDOException $e) {
            echo "<p>Connection failed: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        ?>
    </div>
</body>
</html>
