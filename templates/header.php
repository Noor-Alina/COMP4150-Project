<div class="container">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4">
        <a href="index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
            <i class="bi bi-circle-fill dark-blue-text" style="font-size: 3rem;"></i>
            <span class="fs-1 fw-bold dark-blue-text" style="padding-left: 0.5rem;">UWindsor HMS</span>
        </a>

        <?php
            // if the user is logged in we show the logout button, else we show the login buttons.
            if (isset($_SESSION['logged_in'])) {
                echo '<div class="my-auto ms-4">';
                echo '<a class="btn btn-lg text-light dark-blue-bg" role="button" aria-expanded="false" href="logout.php">';
                echo 'Logout';
                echo '</a>';
                echo '</div>';
            } else {
                echo '<div class="dropdown my-auto ms-4">';
                echo '<button class="btn btn-lg dropdown-toggle text-light dark-blue-bg" type="button" data-bs-toggle="dropdown" aria-expanded="false">';
                echo 'Login';
                echo '</button>';
                echo '<ul class="dropdown-menu">';
                echo '<li><a class="dropdown-item" href="login.php">Student</a></li>';
                echo '<li><a class="dropdown-item" href="login.php">Advisor</a></li>';
                echo '<li><a class="dropdown-item" href="login.php">Staff</a></li>';
                echo '</ul>';
                echo '</div>';
            }
        ?>

    </header>
</div>