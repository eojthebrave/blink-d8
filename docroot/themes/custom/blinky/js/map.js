(function ($) {
    // Add basemap tiles and attribution.
    var baseLayer = L.tileLayer('http://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, &copy; <a href="http://cartodb.com/attributions">CartoDB</a>'
    });

    // Create map and set center and zoom.
    var map = L.map('map', {
        scrollWheelZoom: false,
        center: [22.56073, 114.3301],
        zoom: 9
    });

    L.Icon.Default.imagePath = '/themes/custom/blinky/images/leaflet';

    // Add points.
    function addDataToMap(data, map) {
        var dataLayer = L.geoJson(data, {
            onEachFeature: function(feature, layer) {
                var popupText = feature.properties.name;
                layer.bindPopup(popupText);
            }
        });
        dataLayer.addTo(map);
    }

    $.getJSON('/geopoints', function(data) {
        addDataToMap(data, map);
    });

    // Add basemap to map.
    map.addLayer(baseLayer);
})(jQuery);

