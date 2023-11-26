<?php
require 'connection.php';
include('Admin_Portal.php');

$filter = '';
$yearColumn = '';
$minPlaysFilter = '';


if (isset($_GET['minPlays']) && $_GET['minPlays'] != '') {
    $minPlays = $conn->real_escape_string($_GET['minPlays']);
    $minPlaysFilter = "HAVING total_plays >= $minPlays";
}

if (isset($_GET['minPlays']) && $_GET['minPlays'] != '') {
    $minPlays = $conn->real_escape_string($_GET['minPlays']);
    $minPlaysFilter = "HAVING total_plays >= $minPlays";
}

if (isset($_GET['year']) && !empty($_GET['year'])) {
    $year = $conn->real_escape_string($_GET['year']);
    $filter = "WHERE YEAR(a.DateOfBirth) = $year";
}

if (isset($_GET['releaseDate']) && !empty($_GET['releaseDate'])) {
    $date = $conn->real_escape_string($_GET['releaseDate']);
    $filter = "WHERE ReleaseDate = '$date'";
}

if (isset($_GET['startYear'], $_GET['endYear']) && !empty($_GET['startYear']) && !empty($_GET['endYear'])) {
    $startYear = $conn->real_escape_string($_GET['startYear']);
    $endYear = $conn->real_escape_string($_GET['endYear']);
    $filter = "WHERE YEAR(a.DateOfBirth) BETWEEN $startYear AND $endYear";
}

if (isset($_GET['startDate'], $_GET['endDate']) && !empty($_GET['startDate']) && !empty($_GET['endDate'])) {
    $startDate = $conn->real_escape_string($_GET['startDate']);
    $endDate = $conn->real_escape_string($_GET['endDate']);
    $filter = "WHERE ReleaseDate BETWEEN '$startDate' AND '$endDate'";
}

if (isset($_GET['country']) && !empty($_GET['country'])) {
    $country = $conn->real_escape_string($_GET['country']);
    $filter .= ($filter ? " AND " : "WHERE ") . "a.Country = '$country'";
}

if (isset($_GET['combinedYear'], $_GET['combinedCountry']) && !empty($_GET['combinedYear']) && !empty($_GET['combinedCountry'])) {
    $combinedYear = $conn->real_escape_string($_GET['combinedYear']);
    $combinedCountry = $conn->real_escape_string($_GET['combinedCountry']);
    $filter = "WHERE YEAR(a.DateOfBirth) = $combinedYear AND a.Country = '$combinedCountry'";
}

$sql = "SELECT a.ArtistName, YEAR(a.DateOfBirth) AS BirthYear, a.Country, SUM(s.play_count) AS total_plays
        FROM artist a
        JOIN song s ON a.ArtistID = s.ArtistID
        $filter
        GROUP BY a.ArtistName, YEAR(a.DateOfBirth), a.Country
        $minPlaysFilter
        ORDER BY total_plays DESC
        LIMIT 10";

$result = $conn->query($sql); 

$countryQuery = "SELECT DISTINCT Country FROM artist ORDER BY Country";
$countryResult = $conn->query($countryQuery);

$countries = [];
while ($countryRow = $countryResult->fetch_assoc()) {
    $countries[] = $countryRow['Country'];
}

$yearQuery = "SELECT DISTINCT YEAR(DateOfBirth) AS Year FROM artist WHERE DateOfBirth IS NOT NULL ORDER BY Year";
$yearResult = $conn->query($yearQuery);

$years = [];
while ($yearRow = $yearResult->fetch_assoc()) {
    $years[] = $yearRow['Year'];
}

echo '<div class="filter-section">';

echo '<form action="" method="get" class="filter-form">
        <div class="year-range-filter">
            <label for="year" class="filter-label">Filter by Year:</label>
            <select id="year" name="year">
                <option value="">Select Year</option>';
foreach ($years as $year) {
    echo '<option value="'.htmlspecialchars($year).'">'.htmlspecialchars($year).'</option>';
}

echo '</select>
        <input type="submit" value="Filter by Year" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" style="width: 200px">
      </form>';


// // Specific date filter
// echo '<form action="" method="get" class="filter-form">
//         <label for="releaseDate" class="filter-label">Filter by Release Date:</label>
//         <input type="date" id="releaseDate" name="releaseDate">
//         <input type="submit" value="Filter by Release Date" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" style="width: 200px">
//       </form>';

echo '<form action="" method="get" class="filter-form">
        <div class="year-range-filter">
            <label for="startYear" class="filter-label">Start Year:</label>
            <select id="startYear" name="startYear">
                <option value="">Select Start Year</option>';
foreach ($years as $year) {
    echo '<option value="'.htmlspecialchars($year).'">'.htmlspecialchars($year).'</option>';
}
echo '</select>';




echo '<label for="endYear" class="filter-label">End Year:</label>
            <select id="endYear" name="endYear">
                <option value="">Select End Year</option>';
foreach ($years as $year) {
    echo '<option value="'.htmlspecialchars($year).'">'.htmlspecialchars($year).'</option>';
}
echo '</select>
            <input type="submit" value="Filter by Year Range" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" style="width: 200px">
        </div>
      </form>';

// Date range filter
// echo '<form action="" method="get" class="filter-form">
//         <label for="startDate" class="filter-label ">Start Date:</label>
//         <input type="date" id="startDate" name="startDate">
//         <label for="endDate" class="filter-label">End Date:</label>
//         <input type="date" id="endDate" name="endDate">
//         <input type="submit" value="Filter by Date Range"class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" style="width: 200px">
//       </form>';


echo '<label for="combinedCountry" class="filter-label">Filter by Country:</label>
            <select id="combinedCountry" name="combinedCountry">
                <option value="">Select Country</option>';
foreach ($countries as $country) {
    echo '<option value="'.htmlspecialchars($country).'">'.htmlspecialchars($country).'</option>';
}
echo '</select>
            <input type="submit" value="Filter by Country" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" style="width: 200px">
        </div>
      </form>';

echo '<form action="" method="get" class="filter-form">
        <div class="year-country-filter">
            <label for="combinedYear" class="filter-label">Year:</label>
            <select id="combinedYear" name="combinedYear">
                <option value="">Select Year</option>';
foreach ($years as $year) {
    echo '<option value="'.htmlspecialchars($year).'">'.htmlspecialchars($year).'</option>';
}
echo '</select>';

echo '<label for="combinedCountry" class="filter-label">Country:</label>
            <select id="combinedCountry" name="combinedCountry">
                <option value="">Select Country</option>';
foreach ($countries as $country) {
    echo '<option value="'.htmlspecialchars($country).'">'.htmlspecialchars($country).'</option>';
}
echo '</select>
            <input type="submit" value="Filter by Year and Country" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" style="width: 200px">
        </div>
      </form>';


echo '<form action="" method="get" class="filter-form">
        <label for="minPlays" class="filter-label">Minimum Total Plays:</label>
        <input type="number" id="minPlays" name="minPlays" min="0">
        <input type="submit" value="Filter by Minimum Plays" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" style="width: 200px">
      </form>';
echo '</div>';

echo '<table border="1" style="margin-top:25px;">';
echo '<tr><th>Artist Name</th><th>Date of Birth</th><th>Country</th><th>Total Plays</th></tr>';


while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['ArtistName']}</td><td>{$row['BirthYear']}</td><td>{$row['Country']}</td><td>{$row['total_plays']}</td></tr>";
}



echo '</table>';


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
