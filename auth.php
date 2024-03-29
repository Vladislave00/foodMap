<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php include('header.php'); ?>
</head>

<body>
    <?php

    if (isset($_SESSION['login'])) echo '<h1>Вход уже был выполнен</h1>';
    else {
        echo '
            <div class="container col-3 p-5 my-5 border align-items-center justify-content-center">
            <h1>Авторизация</h1>
            <form action="auth.php" method="post" class="auth-form">
            <div class="auth-form__element">
            <label for="login">Введите логин</label>
            <input type="login" id="login" name="login">
            </div>
            <div class="auth-form__element">
            <label for="password">Введите пароль</label>
            <input type="password" id="password" name="password">
            </div>
            <button type="submit">Войти</button>
            </form>
            </div>';
    }
    ?>


</html>
<?php
include('session.php');
if (isset($_SESSION['login'])) {
    echo '<script language="javascript">';
    echo 'alert(' . $_SESSION['login'] . ')';
    echo '</script>';
}
if (isset($_POST['login'])) {

    include('db.php');
    $query = "SELECT password FROM users WHERE login = '%s'";
    $query = sprintf($query, mysqli_real_escape_string($mysql, $_POST['login']));
    $result = mysqli_query($mysql, $query);

    if (mysqli_num_rows($result) > 0) {
        if (mysqli_fetch_assoc($result)['password'] == $_POST['password']) {

            $query = sprintf($query, mysqli_real_escape_string($mysql, $_POST['login']));
            mysqli_query($mysql, $query);
            $_SESSION['login'] = $_POST['login'];
            header('Location: index.php');
            exit();
        } else {
            // echo '<script language="javascript">';
            echo '<p class="alert">Пароль неверный</p>';
            // echo '</script>';
        }
    } else {
        // echo '<script language="javascript">';
        echo '<p class="alert">Пользователь не найден</p>';
        // echo '</script>';
    }
}
echo "</body>";
?>

