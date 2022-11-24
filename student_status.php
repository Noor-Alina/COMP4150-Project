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
        <title>Staff Home Page</title>
        <link rel="stylesheet" href="css/styles.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    </head>
   
    <body class="d-flex flex-column align-content-stretch vh-100">
        <?php
           if (isset($_SESSION['error'])) {
                echo "<div class='alert alert-danger' role='alert'>";
                echo "{$_SESSION['error']}";
                echo '</div>';
                unset($_SESSION['error']); // clear the error in the $_SESSION array
            }
        ?>
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
                        <a class="nav-link" href="staff.php" role="tab" aria-selected="false">
                            Profile
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" href="rooms.php" aria-selected="false">
                            Rooms
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" href="student_status.php" aria-selected="true">
                            Students
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
            <div class="row align-items-md-stretch">
                <div class="col-md-5">
                    <img src="images/list.jpeg" class="img-fluid" alt="List image">
                </div>
                <!-- Student Profile -->
                <div class="col-md-7 p-5 mb-4 bg-light rounded-3">
                    <h1 class="display-5 text-center fw-bold pb-2">Students</h1>
                    <div class="list-group list-group-flush pb-5 pt-3">

                            <?php
                                 $result = $connection->query("SELECT * FROM Student");

                                while($row = $result->fetch_assoc()) {
                                    echo '<span class="list-group-item list-group-item-light d-flex justify-content-between">';
                                    echo '<span class="fs-4">'.$row["student_id"].'</span>';
                                    echo '<span class="fs-4">'.$row["student_lname"].'</span>';
                                    echo '<span class="fs-4">'.$row["student_fname"].'</span>';
                                    echo '<span class="fs-4">'.$row["current_status"].'</span>';
                                    if ($row["current_status"] == 'placed') {
                                        $result_lease = $connection->query("SELECT lease_num FROM Leases WHERE student_id=".$row["student_id"]."");
                                        $row_lease = $result_lease->fetch_assoc();
                                        echo '<a class="btn btn-outline-secondary" href="staff_lease_view.php?lease_id='.$row_lease["lease_num"].'" role="button">View Lease</a>';
                                    } else {
                                        echo '<a class="btn btn-outline-secondary" href="rooms.php" role="button">Rooms</a>';
                                    }
                                    echo '</span>';
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