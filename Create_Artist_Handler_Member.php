<?php

include('connection.php');

if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
    exit('Please complete the registration form!');
}

if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
    exit('Please complete the registration form!');
}

if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']) == 0) {
    exit('Username is not valid!');
}

if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
    exit('Password must be between 5 and 20 characters long!');
}

$email = $_POST['email'];

// Validate the email ends with @cougarnet.uh.edu
if (substr($email, -17) !== '@cougarnet.uh.edu') {
    exit('Email must end with @cougarnet.uh.edu');
}

// Check if username or email already exists
if ($stmt = $connMember->prepare('SELECT member_ID FROM users WHERE username = ? OR email = ?')) {
    $stmt->bind_param('ss', $_POST['username'], $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        exit('Username or Email exists, please choose another!');
    } 
}

// Insert new user
if ($stmt = $connMember->prepare('INSERT INTO users (username, password, email) VALUES (?, ?, ?)')){
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt->bind_param('sss', $_POST['username'], $password, $email);
    if ($stmt->execute()) {
        // Retrieve the last insert ID
        $user_id = $connMember->insert_id;

        // Prepare to insert artist details into 'artist' table
        if ($stmt = $conn->prepare('INSERT INTO artist (UserID, ArtistName, Biography, Country) VALUES (?, ?, ?, ?)')) {
            $stmt->bind_param('isss', $user_id, $_POST['artistName'], $_POST['bio'], $_POST['country']);
            if (!$stmt->execute()) {
                // This will print any SQL error for artist insertion
                echo "Artist Insert Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            // This will print an error if the statement couldn't be prepared
            echo "Prepare failed for artist insertion: (" . $conn->errno . ") " . $conn->error;
        }

        // Redirect only after all operations are complete
        header('Location: index.php?registration=success');
    } else {
        exit('Could not prepare statement for user insertion!');
    }
} else {
    exit('Could not prepare statement for user insertion!');
}

$stmt->close();
$connMember->close();

