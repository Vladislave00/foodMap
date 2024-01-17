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

    $result = mysqli_query($mysql, "SELECT * FROM `places` limit 3000");
    while ($row = mysqli_fetch_assoc($result)) {
        $ar[] = $row;
    }
    ?>
    <script type="text/javascript">
        ymaps.ready(init);
        var map;
        var cookCollection;
        var cafeCollection;
        var restCollection;
        var ffCollection;
        var barCollection;
        var dinerCollection;
        var snackCollection;
        var cafeteriaCollection;
        var buffetCollection;

        var clusterer;


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
            // map.behaviors.disable(['scrollZoom']); // отключаем скролл карты (опционально)

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
                    iconImageOffset: [-19, -30]
                });
                myCollection = new ymaps.GeoObjectCollection();
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
            // myGeoObjects.forEach((element) => clusterer.add(element));
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
    <div class="dropdown">
        <button class="btn btn-success dropdown-toggle" type="button" id="multiSelectDropdown" data-bs-toggle="dropdown" aria-expanded="false">
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
        <button id="filterBtn">Применить фильтр</button>
        <script>
            document.querySelector('#filterBtn').onclick = function() {
                update();
            }
        </script>
    </div>
    </div>


    <div class='container p-5 my-5 border align-items-center'>
        <div id="map" class="map"></div>
    </div>
</body>

</html>