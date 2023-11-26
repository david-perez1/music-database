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
            background-color: #333;
            color: #232323;
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
            background-color: #ff0000; 
            color: white;
            text-align: center;
            padding: 15px;
            margin-bottom: 20px;
        }

        .user-name {
            font-size: 36px;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 10px;
            text-align: center;
        }

        p, h2, label {
            color: #555;
        }

        textarea {
            color: #ffffff;
        }

        input[type="text"],
        textarea {
        color: #000000; /* Set the font color to black */
        background-color: #ecf0f1;
        border: 1px solid #bdc3c7;
        padding: 10px;
        margin-bottom: 10px;
        width: 100%;
        box-sizing: border-box;
        }


        input[type="submit"] {
            background-color: #2ecc71;
            color: white;
            padding: 12px;
            border: none;
            cursor: pointer;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="submit"]:hover {
            background-color: #27ae60;
        }

        .account-settings {
            margin-top: 20px;
            border-top: 1px solid #bdc3c7;
            padding-top: 20px;
            text-align: center; 
            color: #ffffff !important;
            font-size: 25px;
        }

        .delete-account-link {
            display: block;
            margin-top: 20px;
            text-align: center; 
            color: #ffffff;
        }

        .user-details {
            text-align: center;
            margin: 0 auto;
        }

        .artist-details {
         color: #ffffff;
        }

        label {
        font-weight: bold;
        color: #ffffff; 
        display: block; 
        text-align: center; 
        margin-bottom: 10px; 
        }


        .biography-section {
        color: #ffffff;
        }

        table {
            margin: 0 auto;
            text-align: left;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1 class="user-name"><?php echo $is_artist ? 'Artist Profile' : 'User Profile'; ?></h1>
    </div>

    <?php if (isset($_SESSION['id']) && $user_info): ?>
        <div class="user-name"><?php echo isset($user_info) ? htmlspecialchars($user_info['username']) : 'Guest'; ?></div>

        <?php if ($is_artist && $artist_info): ?>
    <!-- Artist Details -->
    <h2 style="color: #ffffff;">Artist Details</h2>
    <table>
        <tr>
            <td><strong>Artist Name:</strong></td>
            <td><?php echo htmlspecialchars($artist_info['ArtistName']); ?></td>
        </tr>
        <tr>
            <td><strong>Date of Birth:</strong></td>
            <td><?php echo htmlspecialchars($artist_info['DateOfBirth']); ?></td>
        </tr>
        <tr>
            <td><strong>Country:</strong></td>
            <td><?php echo htmlspecialchars($artist_info['Country']); ?></td>
        </tr>
        <tr>
            <td><strong>Biography:</strong></td>
            <td><?php echo htmlspecialchars($artist_info['Biography']); ?></td>
        </tr>
    </table>
    <a href="DeleteAccount.php" class="delete-account-link">Delete Account</a>

    <hr style="margin-top: 20px; margin-bottom: 20px; border-color: #ffffff;">

        <!-- Update Biography Form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="new_biography">Account Settings</label>
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

<?php else: ?>


            <!-- Regular User Details -->
            <div class="user-details">
                <table>
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