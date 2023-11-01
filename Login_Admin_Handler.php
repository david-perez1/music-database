<?php
    include('connection.php');

    

    // $username = $_POST['username'];
    // $password = $_POST['password'];

    if (!isset($_POST['username'], $_POST['password']) ) {
        // Could not get the data that should have been sent.
            exit('Please fill both the username and password fields!');
        }

    if ($stmt = $connLoginAdmin->prepare('SELECT admin_ID, password FROM admin WHERE username = ?')) {
        // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
            $stmt->bind_param('s', $_POST['username']);
            $stmt->execute();
            // Store the result so we can check if the account exists in the database.
            $stmt->store_result();
        
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id, $password);
                $stmt->fetch();
                // Account exists, now we verify the password.
                // Note: remember to use password_hash in your registration file to store the hashed passwords.
                if (password_verify($_POST['password'], $password)) {
                    // Verification success! User has logged-in!
                    // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
                    session_start();
                    session_regenerate_id();
                    $_SESSION['loggedin'] = TRUE;
                    $_SESSION['name'] = $_POST['username'];
                    $_SESSION['id'] = $id;
                    $_SESSION['type'] = "admin";
                    $_SESSION['sid'] = session_id();
                    
                    header('Location: Admin_Portal.php');
                } else {
                    // Incorrect password
                    echo 'Incorrect username and/or password!';
                }
            } else {
                // Incorrect username
                echo 'Incorrect username and/or password!';
            }
        
            $stmt->close();
        }
    /*
    $query = "SELECT * from admin where email_address= '$username' AND password='$password'"; 
    $result = mysqli_query($connLoginAdmin, $query); 
    if(mysqli_num_rows($result)==1){
        session_start(); 
        $_SESSION['auth'] = 'true';
        header("Location:login_Session.php");
    }
    else{
        echo "The username or password you entered is incorrect.";
    } 
    */
?>