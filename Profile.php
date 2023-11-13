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
            background-color: #333; /* Light background color */
            color:#232323; /* Dark text color */ 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: #3498db; /* Header background color */
            color: white;
            text-align: center;
            padding: 15px;
            margin-bottom: 20px;
        }

        .user-name {
            font-size: 36px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
            text-align: center;
        }

        p, h2, label {
            color: #555; /* Slightly darker text color */
        }

        textarea {
            color: #333;
        }

        input[type="text"],
        textarea {
            background-color: #ecf0f1; /* Lighter background for input fields */
            color: #333;
            border: 1px solid #bdc3c7; /* Lighter border color */
            padding: 10px;
            margin-bottom: 10px;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #2ecc71; /* Submit button color */
            color: white;
            padding: 12px;
            border: none;
            cursor: pointer;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="submit"]:hover {
            background-color: #27ae60; /* Hover color for submit button */
        }

        .account-settings {
            margin-top: 20px;
            border-top: 1px solid #bdc3c7; /* Lighter border color */
            padding-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
<div class="header" style="background-color: #ff0000; /* Red color */">
    <h1 style="font-size: 36px; font-weight: bold; color: #ffffff;"><?php echo $is_artist ? 'Artist Profile' : 'User Profile'; ?></h1>
</div>


    <div class="account-settings" style="color: #ffffff;">
    <h2 style="font-size: 24px; color: #ffffff;">Account Settings</h2>
    <p style="font-size: 24px; color: #ffffff;">Update your account preferences below:</p>
    <!-- Add any additional settings for regular users here -->
</div>



        <!-- Additional account settings can be added here -->
    </div>
</div>

</body>
</html>


<?php if (isset($_SESSION['id']) && $user_info): ?>
    
    <?php echo isset($user_info) ? '<div style="text-align: center;"><span class="user-name" style="font-size: 80px; font-weight: bold; color: #ffffff;">' . htmlspecialchars($user_info['username']) . '</span></div>' : '<div style="text-align: center; color: #ffffff;">Guest</div>'; ?>


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

            <div class="user-details" style="text-align: center;">
        <table style="margin: 0 auto; text-align: left;">
            <tr>
                <th>Email:</th>
                <td><?php echo htmlspecialchars($user_info['email']); ?></td>
            </tr>
            <tr>
                <th>Account Type:</th>
                <td>Regular User</td>
            </tr>
        </table>

        

        <!-- Delete Account Link -->
        <a href="DeleteAccount.php" class="delete-account-link" style="display: block; margin-top: 20px; color: #ffffff;">Delete Account</a>
    </div>
<?php endif; ?>

>

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
