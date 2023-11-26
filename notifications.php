<?php
// notifications.php - Fetches notifications and marks them as shown

include('connection.php');  // Include your database connection

function fetchNotifications($userId, $conn) {
    $notificationsQuery = "SELECT * FROM notifications WHERE member_ID = ? AND shown = 0";
    $stmt = $conn->prepare($notificationsQuery);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $notifications = $result->fetch_all(MYSQLI_ASSOC);

    // Mark these notifications as shown
    if (count($notifications) > 0) {
        $updateQuery = "UPDATE notifications SET shown = 1 WHERE member_ID = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param('i', $userId);
        $updateStmt->execute();
    }

    return $notifications;
}

// Check for a GET request with a 'userId'
if (isset($_GET['userId'])) {
    $userId = $_GET['userId'];
    $notifications = fetchNotifications($userId, $conn);
    echo json_encode($notifications);  // Return the notifications as JSON
} else {
    echo json_encode([]);  // Return an empty array if 'userId' is not set
}
?>
