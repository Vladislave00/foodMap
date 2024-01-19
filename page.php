<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://api-maps.yandex.ru/2.1/?apikey=8dc65ec0-6f21-4ce3-bfc7-7fc3d643289f&load=package.standard&lang=ru-RU" type="text/javascript"></script>
</head>

<body>
    <?php
    include('db.php');
    include('session.php');
    include('header.php');

    $result = mysqli_query($mysql, "SELECT * FROM places WHERE places.id=" . $_GET['id']);
    $rating = mysqli_query($mysql, "SELECT ROUND(avg(rating),2) as r FROM feedbacks WHERE place_id=" . $_GET['id']);
    $row = mysqli_fetch_assoc($result);
    $avgRating = mysqli_fetch_assoc($rating);
    $placeId = $row["id"];
    if (isset($_SESSION['login'])) {
        $query = "select id from users where login = '" . $_SESSION['login'] . "'";
        $result = mysqli_query($mysql, $query);
        $row1 = mysqli_fetch_assoc($result);
        $user_id = $row1['id'];
    }

    echo "<div class='container p-5 my-5 border align-items-center'>";
    echo "<h1>" . $row['Name'] . "</h1>";
    echo "<b><p>Средний рейтинг: " . $avgRating["r"] . "</p></b>";
    echo "<p>Адрес: " . $row["Address"] . "</p>";
    echo "<p>" . $row["PublicPhone"] . "</p>";
    echo "<p>Социальные скидки: " . $row["SocialPrivileges"] . "</p>";
    echo "</div>";
    $result2 = mysqli_query($mysql, "SELECT * FROM feedbacks JOIN users ON user_id=users.id WHERE place_id = " . $placeId . "");

    $content = "";

    if (!$result2 || mysqli_num_rows($result2) == 0) {
        $content = "Отзывов пока нет, станьте первым!";
    } else {
        while ($page = mysqli_fetch_assoc($result2)) {
            $content.="<div class=\"card\">
            <div class=\"card-header\">
            " . $page['login'] . "
            </div>
            <div class=\"card-body\">
              <blockquote class=\"blockquote mb-0\">
                <p>Оценка: " . $page['rating'] . "</p>
                <p>" . $page['content'] . "</p>
              </blockquote>
            </div>
          </div>";
        }
    }

    echo "<div class='container p-5 my-5 border align-items-center'>";
    if (isset($_SESSION['login'])) {
        echo "<h2>Написать отзыв:</h2>
        <form method=\"POST\" action=\"\">
        <div class=\"rating-area\">
            <input type=\"radio\" id=\"star-5\" name=\"rating\" value=\"5\">
            <label for=\"star-5\" title=\"Оценка «5»\"></label>	
            <input type=\"radio\" id=\"star-4\" name=\"rating\" value=\"4\">
            <label for=\"star-4\" title=\"Оценка «4»\"></label>    
            <input type=\"radio\" id=\"star-3\" name=\"rating\" value=\"3\">
            <label for=\"star-3\" title=\"Оценка «3»\"></label>  
            <input type=\"radio\" id=\"star-2\" name=\"rating\" value=\"2\">
            <label for=\"star-2\" title=\"Оценка «2»\"></label>    
            <input type=\"radio\" id=\"star-1\" name=\"rating\" value=\"1\">
            <label for=\"star-1\" title=\"Оценка «1»\"></label>
        </div>
        <textarea style=\"width:330px; height:150px;\" id=\"message\" name=\"message\"></textarea><br>
        <button type=\"submit\">Отправить</button>
        </form>
        ";
    } else {
        echo '<p>Чтобы оставить отзыв необходимо авторизоваться</p>';
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $rating = $_POST["rating"];

        $sql = "SELECT id FROM feedbacks WHERE user_id = " . $user_id. "";
        $result1 = mysqli_query($mysql, $sql);

        if (mysqli_num_rows($result1) > 0) {
            echo '<p>Вы уже оставляли отзыв на это заведение</p>';
        } else {
            $sql = "INSERT INTO feedbacks (place_id, user_id, rating, content) VALUES (" . $placeId . "," . $user_id . "," . $_POST["rating"] . ",'" . $_POST["message"] . "')";
            $stmt = mysqli_prepare($mysql, $sql);
            try {
                if (mysqli_stmt_execute($stmt) === TRUE) {
                    echo '<p>Отзыв оставлен. Спасибо!</p>';
                }
            } catch (Exception $e) {
                echo '<p>Ошибка при отправке отзыва :(</p>';
            }
        }
    }

    echo "</div";

    echo "<div class='container p-5 my-5 border align-items-center'>";
    echo "<h2>Отзывы: </h2>";
    echo $content;
    echo "</div";

    ?>
</body>

</html>