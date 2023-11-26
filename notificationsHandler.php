<?php
// Start PHP session at the beginning of the script
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications Page</title>
    <!-- Other head elements like CSS links go here -->
</head>
<body>

<!-- Content of your web page goes here -->

<!-- Notifications container where notifications will be displayed -->
<div id="notifications"></div>

<!-- Include your JavaScript files -->
<script src="path_to_your/notifications.js"></script>
<script type="text/javascript">
    // Check if the PHP session has a user ID set and pass it to the JavaScript file
    window.userIdFromPHP = <?php echo isset($_SESSION['id']) ? json_encode($_SESSION['id']) : "null"; ?>;
    // If the user is not logged in, you could redirect or display a message
    if (!window.userIdFromPHP) {
        console.error('No user is logged in.');
        // Redirect to login page or handle accordingly
        // window.location.href = 'login.php';
    }
</script>

</body>
</html>
