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
// Check if the country filter is set
if (isset($_GET['country']) && !empty($_GET['country'])) {
    $country = $conn->real_escape_string($_GET['country']);
    // If other filters are already set, append with AND, otherwise start with WHERE
    $filter .= ($filter ? " AND " : "WHERE ") . "a.Country = '$country'";
}
// Combined year and country filter
if (isset($_GET['combinedYear'], $_GET['combinedCountry']) && !empty($_GET['combinedYear']) && !empty($_GET['combinedCountry'])) {
    $combinedYear = $conn->real_escape_string($_GET['combinedYear']);
    $combinedCountry = $conn->real_escape_string($_GET['combinedCountry']);
    $filter = "WHERE YEAR(ReleaseDate) = $combinedYear AND a.Country = '$combinedCountry'";
    $yearColumn = ", YEAR(ReleaseDate) AS Year";
}

// SQL query to get genres based on the filter
$sql = "SELECT s.genre, a.Country, SUM(s.play_count) AS total_plays, YEAR(s.ReleaseDate) AS Year
        FROM song s
        JOIN artist a ON s.ArtistID = a.ArtistID
        $filter
        GROUP BY s.genre, a.Country, YEAR(s.ReleaseDate)
        ORDER BY total_plays DESC
        LIMIT 10";


// Execute query
$result = $conn->query($sql); 


// Query to get unique years
$yearQuery = "SELECT DISTINCT YEAR(ReleaseDate) AS Year FROM song ORDER BY Year DESC";
$yearResult = $conn->query($yearQuery);

$years = [];
while ($row = $yearResult->fetch_assoc()) {
    $years[] = $row['Year'];
}


//for dropdown country
$countryQuery = "SELECT DISTINCT Country FROM artist ORDER BY Country";
$countryResult = $conn->query($countryQuery);

$countries = [];
while ($countryRow = $countryResult->fetch_assoc()) {
    $countries[] = $countryRow['Country'];
}


// Centered filter forms
// echo '<div style="text-align: center; margin: auto;">';
echo '<div class="filter-section">';


// Year filter
// echo '<form action="" method="get" class="filter-form">
//         <label for="year" class="filter-label">Filter by Year:</label>
//         <input type="number" id="year" name="year" min="1900" max="2099" step="1">
//         <input type="submit"  value="Filter by Year" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" style="width: 200px">
//       </form>';

// Dropdown for years
echo '<form action="" method="get" class="filter-form">';
echo '<label for="year" class="filter-label">Filter by Year:</label>';
echo '<select name="year" id="year">';
echo '<option value="">Select Year</option>';

// Loop to fetch years as options
while ($row = $yearResult->fetch_assoc()) {
    echo "<option value='{$row['Year']}'>{$row['Year']}</option>";
}

echo '</select>
        <input type="submit" value="Filter by Year" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" style="width: 200px">
      </form>';


// Specific date filter
echo '<form action="" method="get" class="filter-form">
        <label for="releaseDate" class="filter-label">Filter by Release Date:</label>
        <input type="date" id="releaseDate" name="releaseDate">
        <input type="submit" value="Filter by Release Date" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" style="width: 200px">
      </form>';

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

echo '<label for="endYear" class="filter-label">End Year:</label>';
echo '<select name="endYear" id="endYear">';
echo '<option value="">Select End Year</option>';
foreach ($years as $year) {
    echo "<option value='$year'>$year</option>";
}
echo '</select>
            <input type="submit" value="Filter by Year Range" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" style="width: 200px">
        </div>
      </form>';
// Date range filter
echo '<form action="" method="get" class="filter-form">
        <label for="startDate" class="filter-label ">Start Date:</label>
        <input type="date" id="startDate" name="startDate">
        <label for="endDate" class="filter-label">End Date:</label>
        <input type="date" id="endDate" name="endDate">
        <input type="submit" value="Filter by Date Range"class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" style="width: 200px">
      </form>';

// filter by country
echo '<form action="" method="get" class="filter-form">
        <label for="country" class="filter-label">Filter by Country:</label>
        <input type="text" id="country" name="country">
        <input type="submit" value="Filter by Country" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" style="width: 200px">
      </form>';

echo '<form action="" method="get" class="filter-form">
        <label for="combinedYear" class="filter-label">Year:</label>
        <input type="number" id="combinedYear" name="combinedYear" min="1900" max="2099" step="1">
        <label for="combinedCountry" class="filter-label">Country:</label>
        <input type="text" id="combinedCountry" name="combinedCountry">
        <input type="submit" value="Filter by Year and Country" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" style="width: 200px">
      </form>';

echo '</div>';
// Start HTML table
echo '<table border="1" style="margin-top:25px;">';
echo '<tr><th>Genre</th><th>Total Plays</th><th>Year</th><th>Country</th></tr>';

// Fetch and display each row
while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['genre']}</td><td>{$row['total_plays']}</td><td>{$row['Year']}</td><td>{$row['Country']}</td></tr>";
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
<title>Top 10</title>
</head>
