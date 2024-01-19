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
    include('header.php'); ?>
    <div class="container p-5 my-5 border align-items-center">
        <div class="row text-center">
            <h1>Сервис FoodiMap</h1>
        </div>
        <div class="row">
            <div class="col-4">
                <img src="icons\Лого.png" class="logo1">
            </div>
            <div class="col-8">
                <p>FoodiMap - это веб-приложение, которое позволяет пользователям искать места общественного питания на карте. Приложение предоставляет возможность поиска ресторанов, кафе, баров и других заведений. Пользователи могут просматривать различную информацию о заведениях, такую как адрес, скидки, номер телефона и так далее. Также можно оставлять просматривать отзывы на все заведения (чтобы оставить отзыв необходимо авторизоваться). FoodiMap будет вам отличным помощником, если вы ищете где перекусить.</p>
                <p><b>Как пользоваться: </b>На карте вы можете найти любое заведение в Москве. С помощью фильтра можно выбрать тип отображаемых заведений. Также, нажав на метку, вы можете перейти на страницу с информацией каждого заведения и просмотреть существующие отзывы или написать свой собственный.</p>
                <p>Данные взяты с портала открытых данных города Москва: <a href="https://data.mos.ru/opendata/1903?pageSize=10&pageIndex=0&isDynamic=false&version=1&release=155">Ссылка</a></p>
                <p>Контакты для обратной связи:</p>
                <p>Почта: foodimap@gmail.com</p>
            </div>
        </div>
    </div>
    <?php

    $result2 = mysqli_query($mysql, "SELECT * FROM feedbacks JOIN users ON user_id=users.id JOIN places on places.id=feedbacks.place_id order by date_time desc LIMIT 5");

    $content = "";
    while ($page = mysqli_fetch_assoc($result2)) {
        $content .= "<div class=\"card\">
            <div class=\"card-header\">
            " . $page['login'] . "  про <a href='page.php?id=" . $page["place_id"] . "'>" . $page['Name'] . "</a>
            </div>
            <div class=\"card-body\">
              <blockquote class=\"blockquote mb-0\">
                <p>Оценка: " . $page['rating'] . "</p>
                <p>" . $page['content'] . "</p>
              </blockquote>
            </div>
          </div>";
    }
    echo "<div class='container p-5 my-5 border align-items-center'>";
    echo "<h2>Последние отзывы: </h2>";
    echo $content;
    echo "</div>";


    $result = mysqli_query($mysql, "SELECT * FROM `places`");
    while ($row = mysqli_fetch_assoc($result)) {
        $ar[] = $row;
    }
    ?>
    <script type="text/javascript">
        ymaps.ready(init);
        var map;

        var clusterer;

        var myCollection;

        var myGeoObjects = {
            cafes: [],
            rests: [],
            ffs: [],
            bars: [],
            diners: [],
            snacks: [],
            cafeterias: [],
            buffets: [],
            cooks: []
        };

        function init() {
            map = new ymaps.Map("map", {
                center: [55.76, 37.64],
                zoom: 13
            }, {
                searchControlProvider: 'yandex#search'
            })
            clusterer = new ymaps.Clusterer({
                preset: 'islands#nightClusterIcons',
                clusterHideIconOnBalloonOpen: false,
                geoObjectHideIconOnBalloonOpen: false
            })

            map.controls.remove('geolocationControl'); // удаляем геолокацию
            map.controls.remove('searchControl'); // удаляем поиск
            map.controls.remove('trafficControl'); // удаляем контроль трафика
            map.controls.remove('typeSelector'); // удаляем тип
            map.controls.remove('fullscreenControl'); // удаляем кнопку перехода в полноэкранный режим
            map.controls.remove('zoomControl'); // удаляем контрол зуммирования
            map.controls.remove('rulerControl'); // удаляем контрол правил

            myCollection = new ymaps.GeoObjectCollection();

            <?php foreach ($ar as $row) : ?>
                switch ("<?php echo $row['TypeObject'] ?>") {
                    case 'кафе':
                        var imgHref = "icons/Кафе.svg";
                        break;
                    case 'ресторан':
                        var imgHref = "icons/Ресторан.svg";
                        break;
                    case 'Фастфуд':
                        var imgHref = "icons/Фастфуд.svg";
                        break;
                    case 'столовая':
                        var imgHref = "icons/Столовая.svg";
                        break;
                    case 'бар':
                        var imgHref = "icons/Бар.svg";
                        break;
                    case 'закусочная':
                        var imgHref = "icons/Закусочная.svg";
                        break;
                    case 'кулинария':
                        var imgHref = "icons/Магазин.svg";
                        break;
                    case 'кафетерий':
                        var imgHref = "icons/Кафетерий.svg";
                        break;
                    case 'буфет':
                        var imgHref = "icons/Буфет.svg";
                        break;
                    default:
                        var imgHref = "https://psv4.userapi.com/c237231/u329788026/docs/d19/603ee7d1c31c/location-pin.png?extra=68glGVi7EI34lvRNdegaRUBCiDCwEjqwMpXLGPcahqY0wRe4F0Uud08ZzHqM_xOVrCHcgJ0rF98x5m522rAnJ6oW_wD2X9UIEkrzBy0UGdBrGVd070kiuZ_LuQaRsbeHMcws6kuCQxk0hDvMPkU0dK-6Qw";
                }
                var myPlacemark = new ymaps.Placemark([
                    <?php echo $row['latitude']; ?>, <?php echo $row['longitude'] ?>
                ], {
                    balloonContentHeader: "<?php echo $row['Name'] ?>",
                    balloonContentBody: "<?php echo "<a href=page.php?id=" . $row["id"] . ">Перейти на страницу</a>" ?>",
                    hintContent: "<?php echo $row['Name'] ?>"
                }, {
                    iconLayout: 'default#image',
                    iconImageHref: imgHref,
                    iconImageSize: [30, 30],
                    iconImageOffset: [-20, -23]
                });

                switch ("<?php echo $row['TypeObject'] ?>") {
                    case 'кафе':
                        myCollection.add(myPlacemark);
                        myGeoObjects.cafes.push(myPlacemark);
                        break;
                    case 'ресторан':
                        myCollection.add(myPlacemark);
                        myGeoObjects.rests.push(myPlacemark);
                        break;
                    case 'Фастфуд':
                        myCollection.add(myPlacemark);
                        myGeoObjects.ffs.push(myPlacemark);
                        break;
                    case 'столовая':
                        myCollection.add(myPlacemark);
                        myGeoObjects.diners.push(myPlacemark);
                        break;
                    case 'бар':
                        myCollection.add(myPlacemark);
                        myGeoObjects.bars.push(myPlacemark);
                        break;
                    case 'закусочная':
                        myCollection.add(myPlacemark);
                        myGeoObjects.snacks.push(myPlacemark);
                        break;
                    case 'кулинария':
                        myCollection.add(myPlacemark);
                        myGeoObjects.cooks.push(myPlacemark);
                        break;
                    case 'кафетерий':
                        myCollection.add(myPlacemark);
                        myGeoObjects.cafeterias.push(myPlacemark);
                        break;
                    case 'буфет':
                        myCollection.add(myPlacemark);
                        myGeoObjects.buffets.push(myPlacemark);
                        break;
                    default:
                }

            <?php endforeach; ?>
            map.geoObjects.add(myCollection);
            for (var key in myGeoObjects) {
                if (myGeoObjects.hasOwnProperty(key)) {
                    clusterer.add(myGeoObjects[key])
                }
            }
            map.geoObjects.add(clusterer);

        }

        function update() {
            map.geoObjects.removeAll();
            map.geoObjects.add(myCollection);
            clusterer = new ymaps.Clusterer({
                preset: 'islands#nightClusterIcons',
                clusterHideIconOnBalloonOpen: false,
                geoObjectHideIconOnBalloonOpen: false
            })
            if (document.getElementById('cafeCB').checked) {
                clusterer.add(myGeoObjects['cafes']);
            }
            if (document.getElementById('restCB').checked) {
                clusterer.add(myGeoObjects['rests']);
            }
            if (document.getElementById('ffCB').checked) {
                clusterer.add(myGeoObjects['ffs']);
            }
            if (document.getElementById('barCB').checked) {
                clusterer.add(myGeoObjects['bars']);
            }
            if (document.getElementById('dinerCB').checked) {
                clusterer.add(myGeoObjects['diners']);
            }
            if (document.getElementById('cftCB').checked) {
                clusterer.add(myGeoObjects['cafeterias']);
            }
            if (document.getElementById('buffetCB').checked) {
                clusterer.add(myGeoObjects['buffets']);
            }
            if (document.getElementById('snackCB').checked) {
                clusterer.add(myGeoObjects['snacks']);
            }
            if (document.getElementById('cookCB').checked) {
                clusterer.add(myGeoObjects['cooks']);
            }
            map.geoObjects.add(clusterer);
        }
    </script>

    <div class='container p-5 my-5 border align-items-center'>
        <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" id="multiSelectDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Тип заведения
            </button>
            <ul class="dropdown-menu" aria-labelledby="multiSelectDropdown">
                <li>
                    <label>
                        <input type="checkbox" id="cafeCB" checked value="Кафе">
                        Кафе
                    </label>
                </li>
                <li>
                    <label>
                        <input type="checkbox" id="restCB" checked value="Ресторан">
                        Ресторан
                    </label>
                </li>
                <li>
                    <label>
                        <input type="checkbox" id="ffCB" checked value="Фастфуд">
                        Фастфуд
                    </label>
                </li>
                <li>
                    <label>
                        <input type="checkbox" id="barCB" checked value="Бар">
                        Бар
                    </label>
                </li>
                <li>
                    <label>
                        <input type="checkbox" id="dinerCB" checked value="Столовая">
                        Столовая
                    </label>
                </li>
                <li>
                    <label>
                        <input type="checkbox" id="cftCB" checked value="Кафетерий">
                        Кафетерий
                    </label>
                </li>
                <li>
                    <label>
                        <input type="checkbox" id="buffetCB" checked value="Буфет">
                        Буфет
                    </label>
                </li>
                <li>
                    <label>
                        <input type="checkbox" id="snackCB" checked value="Закусочная">
                        Закусочная
                    </label>
                </li>
                <li>
                    <label>
                        <input type="checkbox" id="cookCB" checked value="Кулинария">
                        Кулинария
                    </label>
                </li>
            </ul>
            <button class="btn" id="btn">Применить фильтр</button>
            <script>
                document.querySelector('#btn').onclick = function() {
                    update();
                }
            </script>
        </div>
        <div id="map" class="map"></div>
    </div>
    <div class='container p-5 my-5 align-items-center'>
        <h4>Легенда</h4>
        <img src="icons\Кафе.svg" class="icon" alt=""> - Кафе
        <img src="icons\Ресторан.svg" class="icon" alt=""> - Ресторан
        <img src="icons\Бар.svg" class="icon" alt=""> - Бар
        <img src="icons\Буфет.svg" class="icon" alt=""> - Буфет
        <img src="icons\Закусочная.svg" class="icon" alt=""> - Закусочная
        <img src="icons\Кафетерий.svg" class="icon" alt=""> - Кафетерий
        <img src="icons\Фастфуд.svg" class="icon" alt=""> - Фастфуд
        <img src="icons\Магазин.svg" class="icon" alt=""> - Кулинария
        <img src="icons\Столовая.svg" class="icon" alt=""> - Столовая
    </div>
</body>

</html>