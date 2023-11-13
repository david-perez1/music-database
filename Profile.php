<?php
include('connection.php');
include('navloggedin.php');

// Function to sanitize input
function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Check for biography update submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_biography'])) {
    $newBiography = clean_input($_POST['new_biography']);

    // Replace with a prepared statement in a real application
    $updateBiographyQuery = "UPDATE artist SET Biography = ? WHERE UserID = ?";
    $stmt = mysqli_prepare($con, $updateBiographyQuery);
    $userId = $_SESSION['id'];
    mysqli_stmt_bind_param($stmt, 'si', $newBiography, $userId);

    if (mysqli_stmt_execute($stmt)) {
        $biographyUpdateSuccess = "Biography updated successfully!";
    } else {
        $biographyUpdateError = "Error updating biography: " . mysqli_error($con);
    }

    mysqli_stmt_close($stmt);
}

// Fetch artist biography
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];

    // Check if the user is an artist
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
    <style>
        body {
            background-color: #232323;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .background {
            background-color: #232323;
        }

        .user-name {
            font-size: 80px;
            font-weight: bold;
            color: white;
        }

        p {
            color: white;
        }

        h2 {
            color: white;
        }

        label {
            color: white;
        }

        textarea {
            color: black; /* Update the color if needed for visibility in the textarea */
        }

        input[type="text"],
        input[type="password"],
        textarea {
            background-color: #333;
            color: white;
            border: 1px solid white;
            padding: 8px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .account-settings {
            margin-top: 20px;
            border-top: 1px solid white;
            padding-top: 20px;
        }
    </style>
</head>
<body class="background">

<?php if (isset($_SESSION['id']) && $user_info): ?>
    
    <?php echo isset($user_info) ? '<span class="user-name" style="font-size: 80px; font-weight: bold;">' . htmlspecialchars($user_info['username']) . '</span>' : 'Guest'; ?></h1>

    <p>Email: <?php echo htmlspecialchars($user_info['email']); ?></p>

    <?php if ($is_artist && $artist_info): ?>
        <h2>Artist Details</h2>
        <p>Artist Name: <?php echo htmlspecialchars($artist_info['ArtistName']); ?></p>
        <p>Date of Birth: <?php echo htmlspecialchars($artist_info['DateOfBirth']); ?></p>
        <p>Country: <?php echo htmlspecialchars($artist_info['Country']); ?></p>

        <!-- Account Settings -->
        <div class="account-settings">
            <h2>Account Settings</h2>

            <!-- Update Biography Form -->
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="new_biography">Update Biography:</label><br>
                <textarea id="new_biography" name="new_biography" rows="4" cols="50"></textarea><br>
                <input type="submit" name="update_biography" value="Update Biography">
            </form>

            <?php if (isset($biographyUpdateSuccess)): ?>
                <p><?php echo $biographyUpdateSuccess; ?></p>
            <?php endif; ?>

            <?php if (isset($biographyUpdateError)): ?>
                <p><?php echo $biographyUpdateError; ?></p>
            <?php endif; ?>
        </div>

        <!-- Biography Section (only for artists) -->
        <h2>Biography</h2>
        <p><?php echo htmlspecialchars($artist_info['Biography']); ?></p>

    <?php else: ?>
        <p>Account Type: Regular user</p>

        <!-- Account Settings (for regular users) -->
        <div class="account-settings">
            <h2>Account Settings</h2>
            <!-- Add any additional settings for regular users here -->
        </div>

    <?php endif; ?>

    <!-- Delete Account Link -->
    <a href="DeleteAccount.php">Delete Account</a>

<?php else: ?>
    <!-- Display login form -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" name="login" value="Login">
    </form>

    <?php if (isset($login_error)): ?>
        <p><?php echo $login_error; ?></p>
    <?php endif; ?>
<?php endif; ?>

</body>
</html>
