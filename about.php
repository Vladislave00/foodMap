<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://api-maps.yandex.ru/2.1/?apikey=8dc65ec0-6f21-4ce3-bfc7-7fc3d643289f&load=package.standard&lang=ru-RU" type="text/javascript"></script>
</head>

<body>
    <?php
    include('db.php');
    include('session.php');
    include('header.php');
    ?>

    <div class="container p-5 my-5 border align-items-center">
        <div class="row text-center">
            <h1>Сервис FoodiMap</h1>
        </div>
        <div class="row">
            <div class="col-4">
                <img src="icons\Лого.png" class="logo1">
            </div>
            <div class="col-8">
                <p>FoodiMap - это веб-приложение, которое позволяет пользователям искать места общественного питания на карте. Приложение предоставляет возможность поиска ресторанов, кафе, баров и других заведений. Пользователи могут просматривать различную информацию о заведениях, такую как адрес, скидки, номер телефона и так далее. Также можно оставлять просматривать отзывы на все заведения. FoodiMap будет вам отличным помощником, если вы ищете где перекусить.</p>
                <p>Данные взяты с портала открытых данных города Москва: <a href="https://data.mos.ru/opendata/1903?pageSize=10&pageIndex=0&isDynamic=false&version=1&release=155">Ссылка</a></p>
                <p>Контакты для обратной связи:</p>
                <p>Почта: foodimap@gmail.com</p>
                <p>Телефон: +7-985-852-52-52</p>
            </div>
        </div>
    </div>
</body>

</html>