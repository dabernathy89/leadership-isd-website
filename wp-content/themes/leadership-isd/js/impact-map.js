function initMap() {
    jQuery(document).ready(function($){
        $(document).trigger('map-ready');
    });
}

jQuery(document).ready(function($){
    var map;
    var infowindow;

    $(document).on('map-ready', function(){
        infowindow = new google.maps.InfoWindow();

        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 32.8205865, lng: -96.8714235},
            zoom: 8,
            scrollwheel: false,
        });

        map.data.loadGeoJson('/retrieve-impact-pins/');

        // When the user clicks, open an infowindow
        map.data.addListener('click', function(event) {
            var html = event.feature.getProperty("title");
            infowindow.setContent("<div style='width:200px; text-align: left;'>"+html+"</div>");
            infowindow.setPosition(event.feature.getGeometry().get());
            infowindow.setOptions({pixelOffset: new google.maps.Size(0,-30)});
            infowindow.open(map);
        });
    });

});