<?php

// checking the request receive is a POST, if not we redirect it back to the login page.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit();
}

// Checking if the POST request has the username and password inputs.
if (!isset($_POST['username'], $_POST['password'])) {
    header("Location: login.php");
    exit();
}

// include the database file so we can make a connection to the database.
require_once 'database.php';
session_start();

// sanitize all inputs
$user = $connection->real_escape_string($_POST['username']);
$password = $connection->real_escape_string($_POST['password']);

// checking if the username or password inputs are empty
if (empty($user) || empty($password)) {
    $_SESSION['error'] = 'Missing inputs.';
    header("Location: login.php");
    exit();
}


// checking if the input username exists in either the staff, student, or advisor table
$result_advisor = $connection->query("SELECT * FROM Advisor_Login WHERE username='$user'");
$result_student = $connection->query("SELECT * FROM Student_Login WHERE username='$user'");
$result_staff   = $connection->query("SELECT * FROM Staff_Login WHERE username='$user'");
if ($result_advisor->num_rows <= 0 && $result_student->num_rows <= 0 && $result_staff->num_rows <= 0 ) {
    $_SESSION['error'] = 'User not found.';
    header("Location: login.php");
    exit();
}

//  Advisor login
if ($result_advisor->num_rows > 0) {
    $row = $result_advisor->fetch_assoc();

    // checking the password input matches the hashed password for the user in the database
    if ($password !== $row['password']) {
        $_SESSION['error'] = 'Invalid credentials.';
        header("Location: login.php");
        exit();
    }

    // set the id session variable so we track whether the user is logged in or not
    $_SESSION['advisor'] = $row['advisor_id'];
    $_SESSION['logged_in'] = 'yes';

    // redirect the user to the home page of the website
    header("Location: advisor.php");
    exit();
} 
// Student login
elseif ($result_student->num_rows > 0) {
    $row = $result_student->fetch_assoc();

    // checking the password input matches the hashed password for the user in the database
    if ($password !== $row['password']) {
        $_SESSION['error'] = 'Invalid credentials.';
        header("Location: login.php");
        exit();
    }

    // set the id session variable so we track whether the user is logged in or not
    $_SESSION['student'] = $row['student_id'];
    $_SESSION['logged_in'] = 'yes';

    // redirect the user to the home page of the website
    header("Location: student.php");
    exit();
} 
// Staff login
else {
    $row = $result_staff->fetch_assoc();

    // checking the password input matches the hashed password for the user in the database
    if ($password !== $row['password']) {
        $_SESSION['error'] = 'Invalid credentials.';
        header("Location: login.php");
        exit();
    }

    // set the id session variable so we track whether the user is logged in or not
    $_SESSION['staff'] = $row['Staff_num'];
    $_SESSION['logged_in'] = 'yes';

    // redirect the user to the home page of the website
    header("Location: staff.php");
    exit();
}

?>
