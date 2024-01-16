<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">


</head>

<body>

    <?php include("header.php") ?>

    <div class="main_content">
        <!-- HTML форма для регистрации -->
        <form method="POST" action="">

            <?php
            include 'db.php';
            include 'session.php';



            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $username = $_POST["username"];
                $login = $_POST["login"];
                $password = $_POST["password"];

                // Проверка, что пароль и имя пользователя уникальны

                $sql = "SELECT * FROM users WHERE LOGIN = ?";
                $stmt = mysqli_prepare($mysql, $sql);
                mysqli_stmt_bind_param($stmt, 's', $login);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) > 0) {
                    echo '<p>A user with the same name already exists.</p>';
                } else {
                    $sql = "INSERT INTO users (login, email, password) VALUES (?, ?, ?)";
                    $stmt = mysqli_prepare($mysql, $sql);
                    mysqli_stmt_bind_param($stmt, 'sss', $username, $login, $password);
                    try {
                        if (mysqli_stmt_execute($stmt) === TRUE) {
                            echo '<p>Registration completed successfully.</p>';
                        }
                    } catch (Exception $e) {
                        echo '<p>Error during registration.</p>';
                    }
                }
            }

            $mysql->close();
            ?>

            <h1>Registration</h1>

            <div id="box">
                <div class="field">
                    <div class="lab"><label for="username">Username</label></div>
                    <input class="inputfield" type="text" name="username" id="username" required>
                </div>

                <div class="field">
                    <div class="lab"><label for="username">Email</label></div>
                    <input class="inputfield" type="text" name="login" id="login" required>
                </div>

                <div class="field">
                    <div class="lab"><label for="password">Password</label></div>
                    <input class="inputfield" type="password" name="password" id="password" required>
                </div>
            </div>

            <div><button type="submit">Submit</button></div>

        </form>
    </div>
</body>

</html>