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
    $row = mysqli_fetch_assoc($result);

    $placeId = $row["id"];

    $query = "select id from users where login = '" . $_SESSION['login'] . "'";
    $result = mysqli_query($mysql, $query);
    $row1 = mysqli_fetch_assoc($result);
    $user_id = $row1['id'];

    echo $row["Name"];
    echo "<br>";
    echo $row["Address"];

    $result2 = mysqli_query($mysql, "SELECT * FROM feedbacks WHERE user_id = ". $user_id ."");

    $content = "";

    if (!$result2 || mysqli_num_rows($result2) == 0) {
        $content = "Отзывов пока нет, станьте первым!";
    } else {
        $content = "<table>";
        while ($page = mysqli_fetch_assoc($result2)) {
            $content .= "<td>
            ". $page['content'] ."</td> <td> ". $page['rating'] ."";
            $content .= "</td>";
        }
        $content .= "</table>";
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $rating = $_POST["rating"];

        $sql = "SELECT id FROM feedbacks WHERE user_id = " . $user_id . "";
        $result1 = mysqli_query($mysql, $sql);

        if (mysqli_num_rows($result1) > 0) {
            echo '<p>Вы уже оставляли отзыв</p>';
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

    if (isset($_SESSION['login'])) {
        echo "
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
        <label for=\"message\">Ваше сообщение</label><br>
        <textarea id=\"message\" name=\"message\"></textarea><br>
        <button type=\"submit\">Submit</button>
        </form>
        ";
    } else {
        echo '<p>Чтобы оставить отзыв необходимо авторизоваться</p>';
    }

    echo $content;

    ?>
</body>

</html>