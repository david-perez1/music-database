<?php

include('connection.php');

if (!isset($_POST['username'], $_POST['password']) ) {
	exit('Please fill both the username and password fields!');
}

if ($stmt = $connLoginMember->prepare('SELECT member_ID, password FROM member WHERE username = ?')) {
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();
        if (password_verify($_POST['password'], $password)) {
            session_start();
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            $_SESSION['sid'] = session_id();
            $_SESSION['type'] = "member";
            header('Location: Home_Page.php');
        } else {
            echo 'Incorrect username and/or password!';
        }
    } else {
        echo 'Incorrect username and/or password!';
    }

    $stmt->close();
}
   
?>