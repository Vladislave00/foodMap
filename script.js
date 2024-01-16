ymaps.ready(init);

function init() {
    var map = new ymaps.Map("map", {
        center: [55.76, 37.64],
        zoom: 10
    }, {
        searchControlProvider: 'yandex#search'
    })
    map.controls.remove('geolocationControl'); // удаляем геолокацию
    map.controls.remove('searchControl'); // удаляем поиск
    map.controls.remove('trafficControl'); // удаляем контроль трафика
    map.controls.remove('typeSelector'); // удаляем тип
    map.controls.remove('fullscreenControl'); // удаляем кнопку перехода в полноэкранный режим
    map.controls.remove('zoomControl'); // удаляем контрол зуммирования
    map.controls.remove('rulerControl'); // удаляем контрол правил
    // map.behaviors.disable(['scrollZoom']); // отключаем скролл карты (опционально)
    let placemark = new ymaps.Placemark([55.76, 37.64], {
        hintContent: "Хинт метки"
    }, {
        iconLayout: 'default#image',
        iconImageHref: 'https://psv4.userapi.com/c237231/u329788026/docs/d19/603ee7d1c31c/location-pin.png?extra=68glGVi7EI34lvRNdegaRUBCiDCwEjqwMpXLGPcahqY0wRe4F0Uud08ZzHqM_xOVrCHcgJ0rF98x5m522rAnJ6oW_wD2X9UIEkrzBy0UGdBrGVd070kiuZ_LuQaRsbeHMcws6kuCQxk0hDvMPkU0dK-6Qw',
        iconImageSize: [20, 20],
        iconImageOffset: [-10, -20]
    })
    map.geoObjects.add(placemark);

}
