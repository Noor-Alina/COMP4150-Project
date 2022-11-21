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
                <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
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
                        <a class="nav-link active" href="rooms.php" aria-selected="true">
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
    
        <div class="row justify-content-around">
                <!-- Display Flat Rooms -->
                <?php
                    $result = $connection->query("SELECT fr.place_num, fr.room_num, fr.monthly_rent, f.flat_num, f.street, f.city, f.postal_code, f.num_single_beds  FROM Flat_rooms fr, Flats f WHERE fr.flat_num=f.flat_num");

                    while($row = $result->fetch_assoc()) {
                            echo '<div class="col-md-5 mb-4">';
                            echo '<div class="h-100 p-5 bg-light border rounded-3">';
                            echo '<h2>Room #' . $row["place_num"] . '</h2>';
                            
                            echo '<table class="table table-borderless">';
                            echo '<tbody>';

                            echo '<tr>';
                            echo '<td class="fw-bold">Flat Number</td>';
                            echo '<td>'.$row["flat_num"].'</td>';
                            echo '</tr>';

                            echo '<tr>';
                            echo '<td class="fw-bold">Address</td>';
                            echo '<td>'.$row["street"].' '.$row["city"].' '.$row["postal_code"].' '.'</td>';
                            echo '</tr>';

                            echo '<tr>';
                            echo '<td class="fw-bold">Num of Single Bedrooms</td>';
                            echo '<td>'.$row["num_single_beds"].'</td>';
                            echo '</tr>';

                            echo '<tr>';
                            echo '<td class="fw-bold">Room Number</td>';
                            echo '<td>'.$row["room_num"].'</td>';
                            echo '</tr>';

                            echo '<tr>';
                            echo '<td class="fw-bold">Monthly Rent</td>';
                            echo '<td>$'.$row["monthly_rent"].'</td>';
                            echo '</tr>';

                            echo '</table>';
                            echo '</tbody>';

                            $result_lease = $connection->query("SELECT * FROM Leases WHERE flat_place_num=".$row["place_num"]."");

                            if ($row_lease = $result_lease->fetch_assoc()) {
                                echo '<a class="btn btn-outline-secondary" href="staff_lease_view.php?lease_id='.$row_lease["lease_num"].'" role="button">View Lease</a>';
                            } else {
                                echo '<a class="btn btn-outline-secondary" href="create_lease.php?type=flat&id='.$row["place_num"].'" role="button">Create Lease</a>';
                            }

                            echo '<a class="btn btn-outline-secondary mx-4" href="create_inspection.php?flat_num='.$row["flat_num"].'" role="button">Add Inspection</a>';


                            echo '</div>';
                            echo '</div>';
                    }
                ?>

                <!-- Display Hall Rooms -->
                <?php
                    $result = $connection->query("SELECT hr.Place_num, hr.room_num, hr.monthly_rent, h.Hall_Name, h.street, h.city, h.postal_code, h.Hall_manager  FROM Hall_rooms hr, Halls_of_Residence h WHERE hr.Hall_Name=h.Hall_Name");

                    while($row = $result->fetch_assoc()) {
                            echo '<div class="col-md-5 mb-4">';
                            echo '<div class="h-100 p-5 bg-light border rounded-3">';
                            echo '<h2>Room #' . $row["Place_num"] . '</h2>';
                            
                            echo '<table class="table table-borderless">';
                            echo '<tbody>';

                            echo '<tr>';
                            echo '<td class="fw-bold">Hall Name</td>';
                            echo '<td>'.$row["Hall_Name"].'</td>';
                            echo '</tr>';

                            echo '<tr>';
                            echo '<td class="fw-bold">Address</td>';
                            echo '<td>'.$row["street"].' '.$row["city"].' '.$row["postal_code"].' '.'</td>';
                            echo '</tr>';

                            echo '<tr>';
                            echo '<td class="fw-bold">Hall Manager</td>';
                            echo '<td>'.$row["Hall_manager"].'</td>';
                            echo '</tr>';

                            echo '<tr>';
                            echo '<td class="fw-bold">Room Number</td>';
                            echo '<td>'.$row["room_num"].'</td>';
                            echo '</tr>';

                            echo '<tr>';
                            echo '<td class="fw-bold">Monthly Rent</td>';
                            echo '<td>$'.$row["monthly_rent"].'</td>';
                            echo '</tr>';

                            echo '</table>';
                            echo '</tbody>';

                            $result_lease = $connection->query("SELECT * FROM Leases WHERE hall_place_num=".$row["Place_num"]."");

                            if ($row_lease = $result_lease->fetch_assoc()) {
                                echo '<a class="btn btn-outline-secondary" href="staff_lease_view.php?lease_id='.$row_lease["lease_num"].'" role="button">View Lease</a>';
                            } else {
                                echo '<a class="btn btn-outline-secondary" href="create_lease.php?type=hall&id='.$row["Place_num"].'" role="button">Create Lease</a>';
                            }
                            
                            echo '</div>';
                            echo '</div>';
                    }
                ?>
            </div>

    </body>
</html>