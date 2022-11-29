<?php
session_start();
require_once 'database.php';
require 'functions.php';

if (isset($_SESSION['advisor'])) {
    header("Location: advisor.php");
    exit();
} elseif (isset($_SESSION['staff'])) {
    header("Location: staff.php");
    exit();
} elseif (!isset($_SESSION['student'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Student Leases</title>
        <link rel="stylesheet" href="css/styles.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
            crossorigin="anonymous"></script>
    </head>

    <body class="d-flex flex-column align-content-stretch vh-100">
        <!-- Header -->
        <div class="container">
            <header class="d-flex flex-wrap justify-content-center py-3 mb-4">
                <!-- Logo -->
                <a href="index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                    <i class="bi bi-circle-fill dark-blue-text" style="font-size: 3rem;"></i>
                    <span class="fs-1 fw-bold dark-blue-text" style="padding-left: 0.5rem;">UWindsor HMS</span>
                </a>

                <!-- Tabs -->
                <ul class="nav nav-tabs my-auto ms-4 mb-3" >
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" href="student.php" role="tab" aria-selected="false">
                            Profile
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" href="student_advisor.php" aria-selected="false">
                            Advisor
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link  active" href="student_leases.php" aria-selected="true">
                            Leases
                        </a>
                    </li>
                </ul>  

                <!-- Logout Buttons -->
                <div class="my-auto ms-4">
                    <a class="btn btn-lg text-light dark-blue-bg" role="button" aria-expanded="false" href="logout.php">
                        Logout
                    </a>
                </div>
            </header>
        </div>
    
        <!-- Body -->
        <main class="container h-75 my-3">
            <div class="row justify-content-evenly h-75">
                <!-- Leases Column  -->
                <div class="card col-sm-3 my-2">
                    <div class=" text-center">
                        <h1 class="bg-light rounded-3 pt-2 pb-2 mt-2">Leases</h1>
                    </div>
                    <div class="list-group list-group-flush pb-5 pt-3">
                        <!-- Print this logged in user's leases -->
                        <?php
                            $result = $connection->query("SELECT * FROM Leases WHERE student_id=".$_SESSION['student']."");

                            while ($row = $result->fetch_assoc()) {
                                $dtime = new DateTime($row["date_of_entry"]);
                                $sem = semester($dtime);

                                echo '<a href="lease_info.php?lease_id='.$row["lease_num"].'" class="list-group-item list-group-item-action list-group-item-light d-flex justify-content-between">';
                                echo '<span>Lease #' . $row["lease_num"] . '</span> <span>' . $sem . '</span>';
                                echo '</a> ';
                            }
                        ?>
                    </div>
                </div>
                <!-- Invoices Column -->
                <div class="card col-sm-3 my-2">
                    <div class=" text-center">
                        <h1 class="bg-light rounded-3 pt-2 pb-2 mt-2">Invoices</h1>
                    </div>
                    <div class="list-group list-group-flush pb-5 pt-3">
                        <!-- Print this logged in invoices -->
                        <?php
                            $result = $connection->query("SELECT i.invoice_num, l.date_of_entry FROM Invoice i, Leases l WHERE l.student_id=".$_SESSION['student']." AND i.lease_num=l.lease_num");

                            while ($row = $result->fetch_assoc()) {
                                $dtime = new DateTime($row["date_of_entry"]);
                                $sem = semester($dtime);

                                echo '<a href="invoice_info.php?invoice_id='.$row["invoice_num"].'" class="list-group-item list-group-item-action list-group-item-light d-flex justify-content-between">';
                                echo '<span>Invoice #' . $row["invoice_num"] . '</span> <span>' . $sem . '</span>';
                                echo '</a> ';
                            }
                        ?>
                    </div>
                </div>
                <!-- Receipts Column -->
                <div class="card col-sm-3 my-2">
                    <div class=" text-center">
                        <h1 class="bg-light rounded-3 pt-2 pb-2 mt-2">Receipts</h1>
                    </div>
                    <div class="list-group list-group-flush pb-5 pt-3">
                        <!-- Print this logged in user's receipts -->
                        <?php
                            $result = $connection->query("SELECT r.receipt_num, l.date_of_entry FROM Invoice i, Leases l, Receipt r WHERE l.student_id=".$_SESSION['student']." AND l.lease_num=i.lease_num AND i.invoice_num=r.invoice_num");

                            while ($row = $result->fetch_assoc()) {
                                $dtime = new DateTime($row["date_of_entry"]);
                                $sem = semester($dtime);

                                echo '<a href="reciept_info.php?reciept_id='.$row["receipt_num"].'" class="list-group-item list-group-item-action list-group-item-light d-flex justify-content-between">';
                                echo '<span>Receipt #' . $row["receipt_num"] . '</span> <span>' . $sem . '</span>';
                                echo '</a> ';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </main>

        <?php 
            include("templates/footer.php");
        ?>

    </body>

</html>