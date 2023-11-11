<?php
include('connection.php');
include('navloggedin.php');

if (!isset($_SESSION['id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit;
}

// Get the current user's ID
$userIdToDelete = $_SESSION['id'];

// Call the DeleteAccount procedure with the user's ID
$sql = "CALL DeleteAccount(?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $userIdToDelete);

if ($stmt->execute()) {
    // Account deleted successfully, you can also redirect the user to a confirmation page
    echo "Account deleted successfully!";
    header('Location: index.php'); // Redirect to login page if not logged in
    exit;
} else {
    echo "Error deleting account: " . $conn->error;
}

$stmt->close();
?>