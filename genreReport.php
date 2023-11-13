<?php

// Include database connection
require 'connection.php';
include('Admin_Portal.php');

// Initialize filter
$filter = '';
$yearColumn = '';

// Check if the year filter is set
if (isset($_GET['year']) && !empty($_GET['year'])) {
    $year = $conn->real_escape_string($_GET['year']);
    $filter = "WHERE YEAR(ReleaseDate) = $year";
    $yearColumn = ", YEAR(ReleaseDate) AS Year";
}

// Check if the specific date filter is set
if (isset($_GET['releaseDate']) && !empty($_GET['releaseDate'])) {
    $date = $conn->real_escape_string($_GET['releaseDate']);
    $filter = "WHERE ReleaseDate = '$date'";
    $yearColumn = ", YEAR(ReleaseDate) AS Year";
}

// Check if the year range filter is set
if (isset($_GET['startYear'], $_GET['endYear']) && !empty($_GET['startYear']) && !empty($_GET['endYear'])) {
    $startYear = $conn->real_escape_string($_GET['startYear']);
    $endYear = $conn->real_escape_string($_GET['endYear']);
    $filter = "WHERE YEAR(ReleaseDate) BETWEEN $startYear AND $endYear";
    $yearColumn = ", YEAR(ReleaseDate) AS Year";
}

// Check if the date range filter is set
if (isset($_GET['startDate'], $_GET['endDate']) && !empty($_GET['startDate']) && !empty($_GET['endDate'])) {
    $startDate = $conn->real_escape_string($_GET['startDate']);
    $endDate = $conn->real_escape_string($_GET['endDate']);
    $filter = "WHERE ReleaseDate BETWEEN '$startDate' AND '$endDate'";
    $yearColumn = ", YEAR(ReleaseDate) AS Year";
}

// SQL query to get genres based on the filter
$sql = "SELECT genre, SUM(play_count) AS total_plays, YEAR(ReleaseDate) AS Year
        FROM song 
        $filter
        GROUP BY genre, YEAR(ReleaseDate)
        ORDER BY total_plays DESC
        LIMIT 10";

// Execute query
$result = $conn->query($sql); 


// Centered filter forms
echo '<div style="text-align: center; margin: auto;">';

// Year filter
echo '<form action="" method="get">
        <label for="year">Filter by Year:</label>
        <input type="number" id="year" name="year" min="1900" max="2099" step="1">
        <input type="submit" value="Filter by Year">
      </form>';

// Specific date filter
echo '<form action="" method="get">
        <label for="releaseDate">Filter by Release Date:</label>
        <input type="date" id="releaseDate" name="releaseDate">
        <input type="submit" value="Filter by Release Date">
      </form>';

// Year range filter
echo '<form action="" method="get">
        <label for="startYear">Start Year:</label>
        <input type="number" id="startYear" name="startYear" min="1900" max="2099" step="1">
        <label for="endYear">End Year:</label>
        <input type="number" id="endYear" name="endYear" min="1900" max="2099" step="1">
        <input type="submit" value="Filter by Year Range">
      </form>';

// Date range filter
echo '<form action="" method="get">
        <label for="startDate">Start Date:</label>
        <input type="date" id="startDate" name="startDate">
        <label for="endDate">End Date:</label>
        <input type="date" id="endDate" name="endDate">
        <input type="submit" value="Filter by Date Range">
      </form>';


echo '</div>';
// Start HTML table
echo '<table border="1" style="margin-top:100px;">';
echo '<tr><th>Genre</th><th>Total Plays</th><th>Year</th></tr>';

// Fetch and display each row
while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['genre']}</td><td>{$row['total_plays']}</td><td>{$row['Year']}</td></tr>";
}

echo '</table>';

// HTML forms for filtering


?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">

</html>
<link href="allWebApp.css" rel="stylesheet">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
</head>
