<header class="p-3 bg-dark text-white">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li>
                    <a href="index.php"><img src="icons\Лого.png" class="logo"></a>
                </li>
            </ul>

            <div class="text-end">
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <?php
                    if (!isset($_SESSION['login'])) {
                        echo '<li><a href="auth.php" class="nav-link px-2 text-white">Вход</a></li>';
                        echo '<li><a href="reg.php" class="nav-link px-2 text-white">Регистрация</a></li>';
                    } else {
                        echo '<li><a class="nav-link px-2 text-white">Пользователь: ' . $_SESSION['login'] . '</a></li>';
                        echo '<li><a href="logout.php" class="nav-link px-2 text-white">Выход</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</header>