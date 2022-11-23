<?php

// checking the request receive is a POST, if not we redirect it back to the login page.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: staff.php");
    exit();
}

// Checking if the POST request has all inputs.
if (!isset($_POST['invoice_id'], $_POST['pay_method'], $_POST['pay_date'], $_POST['first_remind_date'], $_POST['second_remind_date'])) {
    $_SESSION['error'] = 'Unset inputs.';
    header("Location: staff.php");
    exit();
}

// include the database file so we can make a connection to the database.
require_once 'database.php';
session_start();

// sanitize all inputs
$invoice_id = $connection->real_escape_string($_POST['invoice_id']);
$pay_method = $connection->real_escape_string($_POST['pay_method']);
$pay_date = $connection->real_escape_string($_POST['pay_date']);
$first_remind_date = $connection->real_escape_string($_POST['first_remind_date']);
$second_remind_date = $connection->real_escape_string($_POST['second_remind_date']);

// checking if the inputs are empty
if (empty($invoice_id) || empty($pay_method) || empty($pay_date)) {
    $_SESSION['error'] = 'Missing inputs.';
    header("Location: staff.php");
    exit();
} elseif (empty($first_remind_date)) {
    $first_remind_date = NULL;
} elseif (empty($second_remind_date)) {
    $second_remind_date = NULL;
}

// create receipt id
$new_receipt_id = rand(0, 999999);

$result_receipt = $connection->query("INSERT INTO Receipt VALUES('$new_receipt_id', '$invoice_id', '$pay_date', '$pay_method', NULLIF('$first_remind_date', ''), NULLIF('$second_remind_date', ''))");

header("Location: staff.php");
exit();

?>
