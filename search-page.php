<?php
include('connection.php');
include('navloggedin.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Search</title>
</head>
<body class="background">
    <h1 class="library-title">Music Search</h1>
    <div class="main-content">
        <form method="get" action="">
            <label for="query">Search:</label>
            <input type="text" id="query" name="query" required>
            <button class="create-playlist-button">Search</button>
        </form>
    </div>
    <div id="results">
        <?php
        if (isset($_GET['query'])) {
            $query = mysqli_real_escape_string($con, $_GET['query']);
            $sql = "SELECT * FROM song WHERE SongTitle LIKE '%$query%' OR Genre LIKE '%$query%' OR artistName LIKE '%$query%'";
            
            $result = mysqli_query($con, $sql);

            if ($result) {
                $results = mysqli_fetch_all($result, MYSQLI_ASSOC);

                if (count($results) > 0) {
                    foreach ($results as $row) {
                        echo "<p>Song ID: " . htmlspecialchars($row['SongID']) . " - Title: " . htmlspecialchars($row['SongTitle']) . " - Artist: " . htmlspecialchars($row['artistName']) . " - Genre: " . htmlspecialchars($row['Genre']) . "</p>";
                    }
                } else {
                    echo "<p>No results found</p>";
                }
            } else {
                echo "<p>Error executing query: " . htmlspecialchars(mysqli_error($con)) . "</p>";
            }
        }
        ?>
    </div>
</body>
</html>
