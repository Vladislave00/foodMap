<?php
    include('db.php');
    include('session.php');
    if(isset($_SESSION['login'])) {
        session_destroy();
    }
    header('Location: index.php');
?>