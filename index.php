<?php
session_start();
if (isset($_SESSION['student'])) {
    header("Location: student.php");
    exit();
} elseif (isset($_SESSION['advisor'])) {
    header("Location: advisor.php");
    exit();
} elseif (isset($_SESSION['staff'])) {
    header("Location: staff.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Main Page</title>
        <link rel="stylesheet" href="css/styles.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    </head>
   
    <body class="d-flex flex-column align-content-stretch vh-100">
        <?php 
            include("templates/header.php");
        ?>

        <main id="hero" class="d-flex pt-4 align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1">
                        <h1 class="display-4 lh-1 mb-3" style="color: #2B59A2;">UWindsor Hostel Management System</h1>
                        <p class="col-lg-11 lead text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi laoreet malesuada dui, vel congue metus malesuada ac. </p>

                    </div>
                    <div class="col-lg-7 order-1 order-lg-2 hero-img">
                        <img src="images/home.jpeg" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </main>
        
        <?php 
            include("templates/footer.php");
        ?>

    </body>

</html>