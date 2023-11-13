<?php
// Include the database connection from connection.php
require 'connection.php'; // Using require ensures the file must be present
include('Admin_Portal.php');

// Check if connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize the filter
$filter = '';
$having = '';


// Check if the artist name filter is set
if (isset($_GET['artistName']) && !empty($_GET['artistName'])) {
    $artistName = $conn->real_escape_string($_GET['artistName']);
    $filter .= " AND artistName LIKE '%$artistName%'";
}

// Check if the song title filter is set
if (isset($_GET['songTitle']) && !empty($_GET['songTitle'])) {
    $songTitle = $conn->real_escape_string($_GET['songTitle']);
    $filter .= " AND SongTitle LIKE '%$songTitle%'";
}

// Check if the release year filter is set
if (isset($_GET['releaseYear']) && !empty($_GET['releaseYear'])) {
    $releaseYear = $conn->real_escape_string($_GET['releaseYear']);
    $filter .= " AND YEAR(ReleaseDate) = $releaseYear";
}


// Check if the minimum average rating filter is set
if (isset($_GET['minRating']) && $_GET['minRating'] !== '') {
    $minRating = $conn->real_escape_string($_GET['minRating']);
    $having = "HAVING AVG(RatingValue) >= $minRating";
}


// Filter By Year Range
if (isset($_GET['startYear']) && isset($_GET['endYear'])) {
    $startYear = $conn->real_escape_string($_GET['startYear']);
    $endYear = $conn->real_escape_string($_GET['endYear']);
    $filter .= " AND YEAR(ReleaseDate) BETWEEN $startYear AND $endYear";
}

// Filter by Date Range
if (isset($_GET['startDate']) && isset($_GET['endDate'])) {
    $startDate = $conn->real_escape_string($_GET['startDate']);
    $endDate = $conn->real_escape_string($_GET['endDate']);
    $filter .= " AND ReleaseDate BETWEEN '$startDate' AND '$endDate'";
}


// The SQL query
$sql = "SELECT SongTitle, artistName, AVG(RatingValue) AS AverageRating, YEAR(ReleaseDate) AS ReleaseYear
        FROM song
        JOIN rating_system ON song.SongID = rating_system.SongID
        WHERE 1=1 $filter
        GROUP BY song.SongID, artistName, SongTitle, YEAR(ReleaseDate)
        $having
        ORDER BY AverageRating DESC 
        LIMIT 10";


// Execute the query
$result = $conn->query($sql);

// Check if query was successful
if (!$result) {
    die("Error: " . $conn->error);
}
// Query to get unique years
$yearQuery = "SELECT DISTINCT YEAR(ReleaseDate) AS Year FROM song ORDER BY Year DESC";
$yearResult = $conn->query($yearQuery);

$years = [];
while ($row = $yearResult->fetch_assoc()) {
    $years[] = $row['Year'];
}


// HTML forms for filtering
echo '<div class="filter-section">';
echo '<form action="" method="get" class="filter-form">';
echo '<label for="artistName"class="filter-label">Filter by Artist Name:</label>';
echo '<input type="text" id="artistName" name="artistName">';
echo '<input type="submit" value="Filter" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" style="width: 200px">';
echo '</form>';

echo '<form action="" method="get" class="filter-form">';
echo '<label for="songTitle"class="filter-label">Filter by Song Title:</label>';
echo '<input type="text" id="songTitle" name="songTitle">';
echo '<input type="submit" value="Filter" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" style="width: 200px">';
echo '</form>';

echo '<form action="" method="get" class="filter-form">';
echo '<label for="releaseYear"class="filter-label">Filter by Release Year:</label>';
echo '<input type="number" id="releaseYear" name="releaseYear" min="1900" max="' . date("Y") . '">';
echo '<input type="submit" value="Filter" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" style="width: 200px">';
echo '</form>';

echo '<form action="" method="get" class="filter-form">';
echo '<label for="minRating"class="filter-label">Filter by Minimum Average Rating:</label>';
echo '<input type="number" step="0.1" id="minRating" name="minRating" min="0" max="5">';
echo '<input type="submit" value="Filter" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" style="width: 200px">';
echo '</form>';


// Year range filter
// Dropdowns for year range
echo '<form action="" method="get" class="filter-form">';
echo '<label for="startYear" class="filter-label">Start Year:</label>';
echo '<select name="startYear" id="startYear">';
echo '<option value="">Select Start Year</option>';
foreach ($years as $year) {
    echo "<option value='$year'>$year</option>";
}
echo '</select>';

// ... [Add other filters as needed]

echo '</div>';

// Start the HTML output
echo '<table border="1" style="margin-top:-20px;">';
echo '<tr><th>Song Title</th><th>Artist Name</th><th>Average Rating</th><th>Release Year</th></tr>';

// Check if we have songs
if ($result->num_rows > 0) {
    // Fetch the results
    while ($song = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($song['SongTitle']) . '</td>';
        echo '<td>' . htmlspecialchars($song['artistName']) . '</td>';
        echo '<td>' . htmlspecialchars($song['AverageRating']) . '</td>';
        echo '<td>' . htmlspecialchars($song['ReleaseYear']) . '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="4">No songs found.</td></tr>';
}

// End the HTML table
echo '</table>';

// Close the connection
$conn->close();
?>


?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">

</html>
<link href="allWebApp.css" rel="stylesheet">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Top 10</title>
</head>
