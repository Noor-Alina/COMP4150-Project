<?php
require_once 'database.php';
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
        <title>Login</title>
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

        <?php 
            include("templates/header.php");
        ?>

        <main>
            <div class="container-fluid h-custom">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-md-9 col-lg-6 col-xl-5">
                        <img src="images/login.jpeg" class="img-fluid" alt="Login image">
                    </div>
                    <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                        <form method="POST" action="login_check.php">
                            <h1 class="h3 mb-4 fw-normal text-center dark-blue-text">Login</h1>

                            <div class="form-floating mb-4">
                                <input type="text" class="form-control" id="floatingInput" placeholder="Username" name="username">
                                <label for="floatingInput">Username</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
                                <label for="floatingPassword">Password</label>
                            </div>

                            <button class="w-100 btn btn-lg btn-primary mb-4" type="submit">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        
        </main>
    
        <?php 
            include("templates/footer.php");
        ?>
    </body>
</html>