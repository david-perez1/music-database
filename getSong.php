<?php
// Include the database connection file
include('connection.php');

// Retrieve the song ID from the GET request
$songID = $_GET['id'] ?? null;

if (!$songID) {
    die("No song ID provided.");
}

// Prepare the SQL query to fetch the song details by ID
$query = "SELECT FileData FROM song WHERE SongID = ?";

if ($stmt = $conn->prepare($query)) {
    // Bind the song ID to the query
    $stmt->bind_param("i", $songID);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $filePath = $row['FileData'];

            // Check if the file exists
            if (file_exists($filePath)) {
                // Set appropriate headers for file download
                header('Content-Description: File Transfer');
                header('Content-Type: audio/mpeg');
                header('Content-Disposition: attachment; filename="'.basename($filePath).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($filePath));
                flush(); // Flush system output buffer
                readfile($filePath);
                exit;
            } else {
                die("File not found.");
            }
        } else {
            die("No song found with the provided ID.");
        }
    } else {
        die("Error executing query: " . $conn->error);
    }

    $stmt->close();
} else {
    die("Error preparing query: " . $conn->error);
}
?>