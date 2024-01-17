<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://api-maps.yandex.ru/2.1/?apikey=8dc65ec0-6f21-4ce3-bfc7-7fc3d643289f&load=package.standard&lang=ru-RU" type="text/javascript"></script>
    <!-- <script src="script.js"></script> -->
</head>

<body>
    <?php
    include('db.php');
    include('session.php');
    include('header.php');

    $result = mysqli_query($mysql, "SELECT * FROM `places` limit 3000");
    while ($row = mysqli_fetch_assoc($result)) {
        $ar[] = $row;
    }
    ?>
    <script type="text/javascript">
        ymaps.ready(init);

        function init() {
            var map = new ymaps.Map("map", {
                center: [55.76, 37.64],
                zoom: 10
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
            // map.behaviors.disable(['scrollZoom']); // отключаем скролл карты (опционально)

            var myCollection = new ymaps.GeoObjectCollection();
            myGeoObjects = [];

            <?php foreach ($ar as $row) : ?>
                switch ("<?php echo $row['TypeObject'] ?>") {
                    case 'кафе':
                        var imgHref = "icons/Кафе.svg";
                        break;
                    case 'ресторан':
                        var imgHref = "icons/Ресторан.svg";
                        break;
                    case 'фастфуд':
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
                    iconImageOffset: [-19, -30]
                });
                myCollection.add(myPlacemark);
                myGeoObjects.push(myPlacemark);
            <?php endforeach; ?>

            map.geoObjects.add(myCollection);
            clusterer.add(myGeoObjects);
            map.geoObjects.add(clusterer);
        }
    </script>
    <div id="map" class="map"></div>
</body>

</html>