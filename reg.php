<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php include('header.php'); ?>
</head>

<body>
<form method="POST" action="">
    <div class="container col-3 p-5 my-5 border align-items-center justify-content-center" id="box">
        <h1>Регистрация</h1>
        <div class="field">
            <div class="lab"><label for="username">Логин</label></div>
            <input class="inputfield" type="text" name="username" id="username" required>
        </div>

        <div class="field">
            <div class="lab"><label for="username">Почта</label></div>
            <input class="inputfield" type="text" name="mail" id="mail" required>
        </div>

        <div class="field">
            <div class="lab"><label for="password">Пароль</label></div>
            <input class="inputfield" type="password" name="password" id="password" required>
        </div>
        <div><button type="submit">Подтвердить</button></div>
    </div>

    </form>
    </div>
    <div class="main_content">
        <!-- HTML форма для регистрации -->

            <?php
            include 'db.php';
            include 'session.php';



            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $username = $_POST["username"];
                $mail = $_POST["mail"];
                $password = $_POST["password"];

                // Проверка, что пароль и имя пользователя уникальны

                $sql = "SELECT * FROM users WHERE LOGIN = ?";
                $stmt = mysqli_prepare($mysql, $sql);
                mysqli_stmt_bind_param($stmt, 's', $username);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) > 0) {
                    echo '<p>Пользователь с таким никнеймом уже существует</p>';
                } else {
                    $sql = "INSERT INTO users (login, email, password) VALUES (?, ?, ?)";
                    $stmt = mysqli_prepare($mysql, $sql);
                    mysqli_stmt_bind_param($stmt, 'sss', $username, $mail, $password);
                    try {
                        if (mysqli_stmt_execute($stmt) === TRUE) {
                            header('Location: auth.php');
                        }
                    } catch (Exception $e) {
                        echo '<p>Error during registration.</p>';
                    }
                }
            }

            $mysql->close();
            ?>
</body>

</html>