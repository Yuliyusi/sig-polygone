<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>SIG</title>

    <!-- Bootstrap -->
    <link href="<?= base_url() ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/map/css/mapbox-gl.css" rel="stylesheet">
    <!-- for draw -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/map/css/mapbox-gl-draw.css" type="text/css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  <style type="text/css">
    #map { position: absolute; top: 10px; bottom: 0; width: 100%; height: 700px; }
  </style>
<style>
.calculation-box {
height: 75px;
width: 150px;
position: absolute;
bottom: 40px;
left: 10px;
background-color: rgba(255, 255, 255, 0.9);
padding: 15px;
text-align: center;
}
 
p {
font-family: 'Open Sans';
margin: 0;
font-size: 13px;
}
</style>
  </head>
  <body>
<div class="container">

    <div class="row">
    <div class="col-md-10" >
        <div id="map"></div>
        <div class="calculation-box">

        </div>

   </div>
    <div class="col-md-2">
    <div class="col-md-12">
     <div id="lng"></div>

     <hr>

        <p>Cliquez sur la carte pour dessiner un polygone.</p>
        <div id="calculated-area"></div> 
        <hr>
        <div id="polygone"></div>    
    </div>
    </div>
    </div>
</div>



    <!-- Map -->
<script src="<?= base_url() ?>assets/map/js/mapbox-gl.js"></script>

<!-- for draw -->
<script src="<?= base_url() ?>assets/map/js/turf.min.js"></script>
<script src="<?= base_url() ?>assets/map/js/mapbox-gl-draw.js"></script>

<script>
      // TO MAKE THE MAP APPEAR YOU MUST
      // ADD YOUR ACCESS TOKEN FROM
      // https://account.mapbox.com
    mapboxgl.accessToken = 'pk.eyJ1IjoiY2Flc2FyMiIsImEiOiJjazNzaW5sNDcwNjBmM2NsZnF4N3dmdW1tIn0.-IuuEG4L2f33CQdxVic6Yw';

    const map = new mapboxgl.Map({
    container: 'map', // container ID
    style: 'mapbox://styles/mapbox/streets-v11', // style URL
    center: [29.9256355062397, -3.4281480098738797], // starting position
    zoom: 9 // starting zoom
    });

    //initial marker
    const marker2 = new mapboxgl.Marker()
    .setLngLat([29.9256355062397, -3.4281480098738797])
    .addTo(map);

   //whrite lat and lon on event click
    map.on('click', (e) => {
    document.getElementById('lng').innerHTML ='<p><strong>Longitude</strong> <span>'+e.lngLat.lng+'</span></p><p><strong>Latitude</strong> <span>'+e.lngLat.lat+'</span></p>'  
 
     const marker1 = new mapboxgl.Marker()
     .setLngLat([e.lngLat.lng, e.lngLat.lat])
     .addTo(map);


    });


/**
 * Begin de la partie dessiner les polygone
 * */
    // Add geolocate control to the map.
    map.addControl(
    new mapboxgl.GeolocateControl({
    positionOptions: {
    enableHighAccuracy: true
    },
    // When active the map will receive updates to the device's location as it changes.
    trackUserLocation: true,
    // Draw an arrow next to the location dot to indicate which direction the device is heading.
    showUserHeading: true
    })
    );
    


    const draw = new MapboxDraw({
    displayControlsDefault: false,
    // Select which mapbox-gl-draw control buttons to add to the map.
    controls: {
    polygon: true,
    trash: true
    },
    // Set mapbox-gl-draw to draw by default.
    // The user does not have to click the polygon control button first.
    defaultMode: 'draw_polygon'
    });
    map.addControl(draw);
     
    map.on('draw.create', updateArea);
    map.on('draw.delete', updateArea);
    map.on('draw.update', updateArea);
     
    function updateArea(e) {
    const data = draw.getAll();
    //console.log();
    const polygone= document.getElementById('polygone');
    const answer = document.getElementById('calculated-area');
    if (data.features.length > 0) {
    const area = turf.area(data);
    // Restrict the area to 2 decimal points.
    const rounded_area = Math.round(area * 100) / 100;
    answer.innerHTML = `<br><p><strong>${rounded_area}</strong></p><p>mètres carrés</p>`;
    var pol='';
    for (let i = 0; i < data.features.length; i++) {

        //polygone.innerHTML = `${JSON.stringify(data.features[i].geometry.coordinates[0])}`
       pol=data.features[i].geometry.coordinates[0]


    }

    if (pol!='') {
        //envoi du point recuperer sur le controller
        $.post("<?= base_url('Sig/enregistrer_polygone_dessiner') ?>",
        {
            mypolygone:pol

        },
        function(data){
         polygone.innerHTML =data
        });  


    }
   

    } else {
    answer.innerHTML = '';
    if (e.type !== 'draw.delete')
    alert('Click the map to draw a polygon.');
    }
    }
/**
 * Fin de la partie dessin polygone
 * */

 /**
  * Debut parti affichage des dessin sur la carte
  * */
map.on('load', () => {
// Add a data source containing GeoJSON data.
map.addSource('maine', {
'type': 'geojson',
'data': {
'type': 'Feature',
'geometry': {
'type': 'Polygon',

// These coordinates outline Maine.
'coordinates': [

<?= $mes_polygon ?>

]
}
}
});
 

<?= $provinces ?>

map.addLayer({
'id': 'outline',
'type': 'line',
'source': 'maine',
'layout': {},
'paint': {
'line-color': '#000',
'line-width': 3
}
});








});

 /**
  * fin parti affichage des dessin sur la carte
  * */


</script>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?= base_url() ?>assets/bootstrap/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?= base_url() ?>assets/bootstrap/js/bootstrap.min.js"></script>

    <!-- <script src="https://unpkg.com/@turf/turf@6/turf.min.js"></script> -->
<!--     <script src="https://unpkg.com/@turf/turf@6/turf.min.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.2.2/mapbox-gl-draw.js"></script>
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.2.2/mapbox-gl-draw.css" type="text/css"> -->


  </body>
</html>


