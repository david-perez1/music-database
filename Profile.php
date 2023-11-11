<?php
// session_start(); // Start the session

include('connection.php'); // Make sure this path is correct for your connection file
include('navloggedin.php');

// Function to sanitize input
function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Check for login submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = clean_input($_POST['username']);
    $password = clean_input($_POST['password']); // Password should be hashed in a real application

    // Replace with a prepared statement in a real application
    $login_query = "SELECT member_ID FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($con, $login_query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['id'] = $user['member_ID']; // Set the user ID in the session
        // Redirect to the profile page
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $login_error = "Invalid username or password.";
    }
}

// If user is logged in, fetch their profile information
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];

    // Determine if the user is an artist
    $artist_query = "SELECT ArtistName, DateOfBirth, Country, Biography FROM artist WHERE UserID = ?";
    $stmt = mysqli_prepare($con, $artist_query);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $artist_result = mysqli_stmt_get_result($stmt);
    $is_artist = mysqli_num_rows($artist_result) > 0;
    $artist_info = $is_artist ? mysqli_fetch_assoc($artist_result) : null;

    // Fetch user data
    $user_query = "SELECT email, username FROM users WHERE member_ID = ?";
    $stmt = mysqli_prepare($con, $user_query);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user_info = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $is_artist ? 'Artist Profile' : 'User Profile'; ?></title>
    <!-- Add your styles here -->
</head>
<body class = "background">

<?php if (isset($_SESSION['id']) && $user_info): ?>
    <h1>Welcome, <?php echo htmlspecialchars($user_info['username']); ?></h1>
    <p>Email: <?php echo htmlspecialchars($user_info['email']); ?></p>
    
    <?php if ($is_artist && $artist_info): ?>
        <h2>Artist Details</h2>
        <p>Artist Name: <?php echo htmlspecialchars($artist_info['ArtistName']); ?></p>
        <p>Date of Birth: <?php echo htmlspecialchars($artist_info['DateOfBirth']); ?></p>
        <p>Country: <?php echo htmlspecialchars($artist_info['Country']); ?></p>
        <p>Biography: <?php echo htmlspecialchars($artist_info['Biography']); ?></p>
    <?php else: ?>
        <p>This is a regular user profile.</p>
    <?php endif; ?>

    <a href="DeleteAccount.php">Delete Account</a>
<?php else: ?>
    <!-- Display login form -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" name="login" value="Login">
    </form>
    <?php if (isset($login_error)): ?>
        <p><?php echo $login_error; ?></p>
    <?php endif; ?>
<?php endif; ?>

</body>
</html>