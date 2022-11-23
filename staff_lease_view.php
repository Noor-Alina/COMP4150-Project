<?php
session_start();
require_once 'database.php';

if (isset($_SESSION['advisor'])) {
    header("Location: advisor.php");
    exit();
} elseif (isset($_SESSION['student'])) {
    header("Location: student.php");
    exit();
} elseif (!isset($_SESSION['staff'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Rooms List</title>
        <link rel="stylesheet" href="css/styles.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    </head>
   
    <body>
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
                        <a class="nav-link " href="staff.php" role="tab" aria-selected="false">
                            Profile
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" href="rooms.php" aria-selected="false">
                            Rooms
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
        <main class="container py-4">
            <!-- Lease info -->
            <div class="row align-items-md-stretch">
                <div class="col-md-5">
                    <img src="images/contract.jpeg" class="img-fluid" alt="Leases image">
                </div>
                <div class="col-md-7 p-5 mb-4 bg-light rounded-3">
                    <?php
                        echo '<h1 class="display-5 text-center fw-bold pb-2">Lease #'.$_GET['lease_id'].'</h1>';
                    ?>
                    <table class="table table-borderless">
                        <tbody>
                            <?php
                                $result = $connection->query("SELECT * FROM Leases WHERE lease_num=".$_GET['lease_id']."");
                                $row = $result->fetch_assoc();

                                echo '<tr>';
                                echo '<td class="fw-bold fs-4">Student ID</td>';
                                echo '<td class="fs-4">'.$row["student_id"].'</td>';
                                echo '</tr>';

                                if ($row["hall_place_num"] !== null) {
                                    $result_hall = $connection->query("SELECT hr.room_num, hr.monthly_rent, h.Hall_Name, h.street, h.city, h.postal_code, h.Hall_ph, h.Hall_manager FROM Leases l, Hall_rooms hr, Halls_of_Residence h WHERE l.lease_num=".$_GET['lease_id']." AND l.hall_place_num=hr.place_num AND hr.Hall_Name=h.Hall_Name");
                                    $row_hall = $result_hall->fetch_assoc();

                                    echo '<tr>';
                                    echo '<td class="fw-bold fs-4">Monthly Rent</td>';
                                    echo '<td class="fs-4">'.$row_hall["monthly_rent"].'</td>';
                                    echo '</tr>';

                                    echo '<tr>';
                                    echo '<td class="fw-bold fs-4">Room #</td>';
                                    echo '<td class="fs-4">'.$row_hall["room_num"].'</td>';
                                    echo '</tr>';

                                    echo '<tr>';
                                    echo '<td class="fw-bold fs-4">Hall</td>';
                                    echo '<td class="fs-4">'.$row_hall["Hall_Name"].'. '.$row_hall["street"].' '.$row_hall["city"].' '.$row_hall["postal_code"].'</td>';
                                    echo '</tr>';

                                    echo '<tr>';
                                    echo '<td class="fw-bold fs-4">Hall Phone #</td>';
                                    echo '<td class="fs-4">'.$row_hall["Hall_ph"].'</td>';
                                    echo '</tr>';

                                    echo '<tr>';
                                    echo '<td class="fw-bold fs-4">Hall Manager</td>';
                                    echo '<td class="fs-4">'.$row_hall["Hall_manager"].'</td>';
                                    echo '</tr>';

                                } else {
                                    $result_flat = $connection->query("SELECT fr.room_num, fr.monthly_rent, f.flat_num, f.street, f.city, f.postal_code, f.num_single_beds FROM Leases l, Flat_rooms fr, Flats f WHERE l.lease_num=".$_GET['lease_id']." AND l.flat_place_num=fr.place_num AND fr.flat_num=f.flat_num");
                                    $row_flat = $result_flat->fetch_assoc();

                                    echo '<tr>';
                                    echo '<td class="fw-bold fs-4">Monthly Rent</td>';
                                    echo '<td class="fs-4">'.$row_flat["monthly_rent"].'</td>';
                                    echo '</tr>';

                                    echo '<tr>';
                                    echo '<td class="fw-bold fs-4">Room #</td>';
                                    echo '<td class="fs-4">'.$row_flat["room_num"].'</td>';
                                    echo '</tr>';

                                    echo '<tr>';
                                    echo '<td class="fw-bold fs-4">Flat</td>';
                                    echo '<td class="fs-4">'.$row_flat["flat_num"].'. '.$row_flat["street"].' '.$row_flat["city"].' '.$row_flat["postal_code"].'</td>';
                                    echo '</tr>';

                                    echo '<tr>';
                                    echo '<td class="fw-bold fs-4">Bedrooms #</td>';
                                    echo '<td class="fs-4">'.$row_flat["num_single_beds"].'</td>';
                                    echo '</tr>';

                                }

                                    echo '<tr>';
                                    echo '<td class="fw-bold fs-4">Duration</td>';
                                    echo '<td class="fs-4">'.$row["lease_duration"].'</td>';
                                    echo '</tr>';

                                    echo '<tr>';
                                    echo '<td class="fw-bold fs-4">Dates</td>';
                                    echo '<td class="fs-4">'.$row["date_of_entry"].' to '.$row["date_of_exit"].'</td>';
                                    echo '</tr>';

                            ?>
                        </tbody>
                    </table>

                    <!-- Invoice button -->
                    <?php
                        // get invoice num
                        $result_invoice = $connection->query("SELECT * FROM Invoice WHERE lease_num=".$_GET['lease_id']."");

                        if ($row_invoice = $result_invoice->fetch_assoc()) {
                            $result_receipt = $connection->query("SELECT * FROM Receipt WHERE invoice_num=".$row_invoice["invoice_num"]."");

                            if ($row_receipt = $result_receipt->fetch_assoc()) {
                            } else {
                                echo '<a href="pay_invoice.php?invoice_id=' . $row_invoice["invoice_num"] . '" class="btn btn-primary btn-lg w-100" role="button">User Pay Invoice</a>';
                            }
                        }
                    ?>
                </div>
            </div>

            <!-- Inspections info -->
            <div class="row align-items-md-stretch">
                <?php
                    $result = $connection->query("SELECT l.hall_place_num, fi.flat_inspect_id, fi.DO_Inspection, fi.Satisfaction_cond, fi.comments, hs.Staff_name FROM Leases l, Flat_rooms fr, Flat_Inspections fi, Hostel_staff hs WHERE l.lease_num=".$_GET['lease_id']." AND l.flat_place_num=fr.place_num AND fr.flat_num=fi.flat_num AND fi.Staff_num=hs.Staff_num");

                    while($row = $result->fetch_assoc()) {
                        if ($row["hall_place_num"] == null) {
                            echo '<div class="col-md-6 mb-4">';
                            echo '<div class="h-100 p-5 bg-light border rounded-3">';
                            echo '<h2>Inspection #' . $row["flat_inspect_id"] . '</h2>';
                            
                            echo '<table class="table table-borderless">';
                            echo '<tbody>';

                            echo '<tr>';
                            echo '<td class="fw-bold">Inspector</td>';
                            echo '<td>'.$row["Staff_name"].'</td>';
                            echo '</tr>';

                            echo '<tr>';
                            echo '<td class="fw-bold">Date</td>';
                            echo '<td>'.$row["DO_Inspection"].'</td>';
                            echo '</tr>';

                            echo '<tr>';
                            echo '<td class="fw-bold">Satisfactory condition</td>';
                            echo '<td>'.$row["Satisfaction_cond"].'</td>';
                            echo '</tr>';

                            echo '<tr>';
                            echo '<td class="fw-bold">Comments</td>';
                            echo '<td>'.$row["comments"].'</td>';
                            echo '</tr>';

                            echo '</table>';
                            echo '</tbody>';

                            echo '</div>';
                            echo '</div>';
                        }
                    }
                ?>

            </div>
        </main>

        <?php 
            include("templates/footer.php");
        ?>

    </body>
</html>