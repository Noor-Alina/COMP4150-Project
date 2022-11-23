<?php
session_start();
require_once 'database.php';

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
        <title>Student Home Page</title>
        <link rel="stylesheet" href="css/styles.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
            crossorigin="anonymous"></script>
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
                        <a class="nav-link active " href="student.php" role="tab" aria-selected="true">
                            Profile
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" href="student_advisor.php" aria-selected="false">
                            Advisor
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" href="student_leases.php" aria-selected="false">
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
        <main class="container py-4">
            <div class="row align-items-md-stretch">
                <div class="col-md-5">
                        <img src="images/profile.jpeg" class="img-fluid" alt="Profile image">
                </div>
                <!-- Student Profile -->
                <div class="col-md-7 p-5 mb-4 bg-light rounded-3">
                    <?php
                        $result = $connection->query("SELECT * FROM Student WHERE student_id=".$_SESSION['student']."");

                        while ($row = $result->fetch_assoc()) {
                            echo '<h1 class="display-5 text-center fw-bold pb-2">'.$row["student_fname"].' '.$row["student_lname"].'</h1>';
                        }
                    ?>
                    <table class="table table-borderless">
                        <tbody>
                            <?php
                                $result = $connection->query("SELECT * FROM Student WHERE student_id=".$_SESSION['student']."");

                                while($row = $result->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td class="fw-bold fs-4">Student ID</td>';
                                    echo '<td class="fs-4">'.$row["student_id"].'</td>';
                                    echo '</tr>';

                                    echo '<tr>';
                                    echo '<td class="fw-bold fs-4">Address</td>';
                                    echo '<td class="fs-4">'.$row["street"].' '.$row["city"].' '.$row["postal_code"].'</td>';
                                    echo '</tr>';

                                    echo '<tr>';
                                    echo '<td class="fw-bold fs-4">Birthday</td>';
                                    echo '<td class="fs-4">'.$row["DOB"].'</td>';
                                    echo '</tr>';

                                    echo '<tr>';
                                    echo '<td class="fw-bold fs-4">Gender</td>';
                                    echo '<td class="fs-4">'.$row["gender"].'</td>';
                                    echo '</tr>';

                                    echo '<tr>';
                                    echo '<td class="fw-bold fs-4">Nationality</td>';
                                    echo '<td class="fs-4">'.$row["nationality"].'</td>';
                                    echo '</tr>';

                                    echo '<tr>';
                                    echo '<td class="fw-bold fs-4">Degree</td>';
                                    echo '<td class="fs-4">'.$row["program"].' - '.$row["deg_category"].'</td>';
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row align-items-md-stretch">
                <!-- Lease Info -->
                <div class="col-md-6">
                    <div class="h-100 p-5 text-bg-dark rounded-3">
                        <h2>Leases</h2>
                        <?php
                            $result = $connection->query("SELECT current_status FROM Student WHERE student_id=".$_SESSION['student']."");
                            $row = $result->fetch_assoc();
                            if ($row['current_status'] = "placed") {
                                echo '<p class="pt-3 ">Student is currently placed in a room.</p>';
                            } else {
                                echo '<p class="">Student is not currently placed in a room.</p>';
                            }

                            $result_rent = $connection->query("SELECT (SELECT (SUM(sl.monthly_rent*(sl.lease_duration/30))) FROM Student s, student_lease_info sl, Invoice i, Receipt r WHERE s.student_id = '".$_SESSION['student']."' AND s.student_id = sl.student_id AND sl.lease_num = i.lease_num AND i.invoice_num = r.invoice_num) as total");

                            if ($row_rent = $result_rent->fetch_assoc()) {
                                if ($row_rent["total"] == null) {
                                    echo '<p class="pb-2">Student paid $0 in rent.</p>';
                                } else {
                                    $total = round(floatval($row_rent["total"]), 2);
                                    echo '<p class="pb-2">Student paid $' . $total . ' in rent.</p>';
                                }
                            }
                            
                        ?>
                        <a class="btn btn-outline-light p-2" href="student_leases.php" role="button">Leases</a>
                    </div>
                </div>
                <!-- Advisor Info -->
                <div class="col-md-6">
                    <div class="h-100 p-5 bg-light border rounded-3">
                        <h2>Advisor</h2>
                        <?php
                            $result = $connection->query("SELECT sa.advisor_fname, sa.advisor_lname, sa.job_pos FROM Staff_Advisor sa, Student s WHERE s.student_id=".$_SESSION['student']." AND s.advisor_id = sa.advisor_id");

                            while($row = $result->fetch_assoc()) {
                                echo '<table class="table table-borderless">';
                                echo '<tbody>';

                                echo '<tr>';
                                echo '<td class="fw-bold">Name</td>';
                                echo '<td>'.$row["advisor_fname"].' '.$row["advisor_lname"].'</td>';
                                echo '</tr>';

                                echo '<tr>';
                                echo '<td class="fw-bold">Position</td>';
                                echo '<td>'.$row["job_pos"].'</td>';
                                echo '</tr>';

                                echo '</table>';
                                echo '</tbody>';
                            }
                        ?>                        
                        <a class="btn btn-outline-secondary" href="student_advisor.php" role="button">Advisor Info</a>
                    </div>
                </div>
            </div>
        </main>

        <?php 
            include("templates/footer.php");
        ?>
    </body>

</html>