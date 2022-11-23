<?php

// checking the request receive is a POST, if not we redirect it back to the login page.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: staff.php");
    exit();
}

// Checking if the POST request has all inputs.
if (!isset($_POST['type'], $_POST['id'], $_POST['student_id'], $_POST['duration'], $_POST['start_date'], $_POST['end_date'])) {
    $_SESSION['error'] = 'Unset inputs.';
    header("Location: staff.php");
    exit();
}

// include the database file so we can make a connection to the database.
require_once 'database.php';
session_start();

// sanitize all inputs
$type = $connection->real_escape_string($_POST['type']);
$id = $connection->real_escape_string($_POST['id']);
$student_id = $connection->real_escape_string($_POST['student_id']);
$duration = $connection->real_escape_string($_POST['duration']);
$start_date = $connection->real_escape_string($_POST['start_date']);
$end_date = $connection->real_escape_string($_POST['end_date']);

// if end date is before start date
if ($start_date > $end_date) {
    $_SESSION['error'] = 'End date cannot be before Start time';
    header("Location: staff.php");
    exit();
}

// checking if the inputs are empty
if (empty($type) || empty($id) || empty($student_id) || empty($duration) || empty($start_date) || empty($end_date)) {
    $_SESSION['error'] = 'Missing inputs.';
    header("Location: staff.php");
    exit();
}

// create random number for lease id
$new_lease_id = rand(0, 999999);

if ($type == "hall") {
    $result = $connection->query("INSERT INTO Leases VALUES('$new_lease_id','$id',NULL,'$student_id', '$duration', DATE '$start_date', DATE '$end_date')");
} else {
    $result = $connection->query("INSERT INTO Leases VALUES('$new_lease_id', NULL, '$id','$student_id', '$duration', DATE '$start_date', DATE '$end_date')");
}

$connection->query("UPDATE Student SET current_status='placed' WHERE student_id=$student_id");

$pay_due = date('Y-m-d', strtotime($start_date . ' + 3 months'));
$new_invoice_id = rand(0, 999999);

$month = intval(date('m', strtotime($start_date)));

if ($month < 5) {
    $sem = 'Winter';
} elseif ($month < 9) {
    $sem = 'Summer';
} else {
    $sem = 'Fall';
}

$result_invoice = $connection->query("INSERT INTO Invoice VALUES('$new_invoice_id', '$new_lease_id','$student_id', '$pay_due', '$sem')");

header("Location: staff.php");
exit();

?>
