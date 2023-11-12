<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Viewed Report</title>
    <style>
        /* Add your CSS styles here */
        table {
            margin-top: 100px;
            border-collapse: collapse; /* Optional: for better border appearance */
        }
        th, td {
            border: 1px solid black;
            padding: 8px; /* Optional: for padding inside cells */
        }
    </style>
</head>
<body>

<?php

// Include database connection
require 'connection.php';
include('Admin_Portal.php');

// SQL query to get top 10 genres by play_count 
$sql = "SELECT genre, SUM(play_count) AS total_plays 
        FROM song
        GROUP BY genre
        ORDER BY total_plays DESC
        LIMIT 10";

// Execute query
$result = $conn->query($sql); 

// Start HTML table
echo '<table border="1" style="margin-top:100px;">'; // You can add 'class' or 'id' attributes to style it with CSS
echo '<tr><th>Genre</th><th>Total Plays</th></tr>';

// Output results
while ($row = $result->fetch_assoc()) {
  echo '<tr>';
  echo '<td>' . $row['genre'] . '</td>';
  echo '<td>' . $row['total_plays'] . '</td>';
  echo '</tr>';
}

// End table
echo '</table>';

// Close connection
$conn->close();

?>

</body>
</html>
