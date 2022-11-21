<?php

// checking the request receive is a POST, if not we redirect it back to the login page.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: staff.php");
    exit();
}

// Checking if the POST request has all inputs.
if (!isset($_POST['flat_num'], $_POST['staff_id'], $_POST['cond'], $_POST['comments'], $_POST['inspect_date'])) {
    $_SESSION['error'] = 'Unset inputs.';
    header("Location: staff.php");
    exit();
}

// include the database file so we can make a connection to the database.
require_once 'database.php';
session_start();

// sanitize all inputs
$flat_num = $connection->real_escape_string($_POST['flat_num']);
$staff_id = $connection->real_escape_string($_POST['staff_id']);
$cond = $connection->real_escape_string($_POST['cond']);
$comments = $connection->real_escape_string($_POST['comments']);
$inspect_date = $connection->real_escape_string($_POST['inspect_date']);

// checking if the inputs are empty
if (empty($flat_num) || empty($staff_id) || empty($cond) || empty($comments) || empty($inspect_date)) {
    $_SESSION['error'] = 'Missing inputs.';
    header("Location: staff.php");
    exit();
}

$new_inspect_id = rand(0, 999999);
$result_invoice = $connection->query("INSERT INTO Flat_Inspections VALUES('$new_inspect_id', DATE '$inspect_date', '$cond','$comments', '$staff_id', '$flat_num')");

// $_SESSION['error'] = 'Missing inputs.';
header("Location: staff.php");
exit();

?>
