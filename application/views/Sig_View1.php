<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8 />
<title>Geolocation</title>
    <!-- Bootstrap -->
<link href="<?= base_url() ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
<script src='https://api.mapbox.com/mapbox.js/v3.3.1/mapbox.js'></script>
<link href='https://api.mapbox.com/mapbox.js/v3.3.1/mapbox.css' rel='stylesheet' />
<style>
  body { margin:0; padding:0; }
#map { position: absolute; top: 10px; bottom: 0; width: 100%; height: 700px; }
</style>


<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-draw/v0.4.10/leaflet.draw.css' rel='stylesheet' />
<script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-draw/v0.4.10/leaflet.draw.js'></script>
<script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-geodesy/v0.1.0/leaflet-geodesy.js'></script>
</head>
<body>

<style>
pre.ui-coordinates {
  position:absolute;
  /*bottom:10px;*/
  /*left:10px;*/
  padding:5px 10px;
  background:rgba(0,0,0,0.5);
  color:#fff;
  font-size:11px;
  line-height:18px;
  border-radius:3px;
  }
</style>

<div class="col-md-12">
  <div class="col-md-9">

    <div id='map'></div>
  </div>  
  <div class="col-md-3" >
    <div class="col-md-12">
    <div class="col-md-6">
       <a href='#' id='geolocate' class='btn btn-info'>Localise moi</a>  
    </div>
    <div class="col-md-6">
       <a href='#' onclick="location.reload();" class='btn btn-success'>Actualiser la page</a>  
    </div>
    <div class="col-md-6">
        <pre id='coordinates' class='ui-coordinates'></pre> 
    </div>    
    </div>
    <div class="col-md-6" >
        <p  id="polygone_dessiner"></p>
    </div>
    <div class="col-md-6" >
        <p  id="polygone_dessiner_2"></p>
    </div>
  </div> 
</div>





<script>
L.mapbox.accessToken = 'pk.eyJ1IjoiY2Flc2FyMiIsImEiOiJjazNzaW5sNDcwNjBmM2NsZnF4N3dmdW1tIn0.-IuuEG4L2f33CQdxVic6Yw';
var geolocate = document.getElementById('geolocate');
var map = L.mapbox.map('map')
   .setView([-3.4281480098738797,29.9256355062397], 9)
  .addLayer(L.mapbox.styleLayer('mapbox://styles/mapbox/streets-v11'));

var myLayer = L.mapbox.featureLayer().addTo(map);

// This uses the HTML5 geolocation API, which is available on
// most mobile browsers and modern browsers, but not in Internet Explorer
//
// See this chart of compatibility for details:
// http://caniuse.com/#feat=geolocation
if (!navigator.geolocation) {
    geolocate.innerHTML = 'Geolocation is not available';
} else {
    geolocate.onclick = function (e) {
        e.preventDefault();
        e.stopPropagation();
        map.locate();
    };
}

// Une fois que nous avons une position, zoomez et centrez la carte dessus, et ajoutez un seul marqueur.
map.on('locationfound', function(e) {
    map.fitBounds(e.bounds);

    myLayer.setGeoJSON({
        type: 'Feature',
        geometry: {
            type: 'Point',
            coordinates: [e.latlng.lng, e.latlng.lat]
        },
        properties: {
            'title': 'Je suis ici!',
            'marker-color': '#ff8888',
            'marker-symbol': 'star'
        }
    });

    // Et masquer le bouton de géolocalisation
    //geolocate.parentNode.removeChild(geolocate);
});

// Si l'utilisateur choisit de ne pas autoriser sa position
// à partager, afficher un message d'erreur.
map.on('locationerror', function() {
    geolocate.innerHTML = 'La position n\'a pas pu être trouvée';
});
//affichage des donnees des provinces
<?= $limites ?>

var coordinates = document.getElementById('coordinates');

var marker = L.marker([-3.63677668537483, 29.273071289062504], {
    icon: L.mapbox.marker.icon({
      'marker-color': '#030303'
    }),
    draggable: true
}).addTo(map);

// chaque fois que le marqueur est déplacé, mettre à jour le conteneur de coordonnées
marker.on('dragend', ondragend);

var geocoder = L.mapbox.geocoder('mapbox.places');

// Définissez la coordonnée initiale du marqueur lors du chargement.
ondragend();

function ondragend() {
    var m = marker.getLatLng();


    
    
    geocoder.reverseQuery({lat: m.lat, lng: m.lng}, callback);

    function callback(err,data)
     {
      //console.log(data.features[0].text);
      // console.log(data.features[0].place_name+ '<br>Latitude: ' + m.lat + '<br />Longitude: ' + m.lng);
      coordinates.innerHTML =data.features[0].place_name+ '<br>Latitude: ' + m.lat + '<br />Longitude: ' + m.lng;
     
    }



}

//dessiner le polygone

var featureGroup = L.featureGroup().addTo(map);

var drawControl = new L.Control.Draw({
  edit: {
    featureGroup: featureGroup
  },
  draw: {
    polygon: true,
    polyline: false,
    rectangle: false,
    circle: false,
    marker: false
  }
}).addTo(map);

map.on('draw:created', showPolygonArea);
map.on('draw:edited', showPolygonAreaEdited);

function showPolygonAreaEdited(e) {
  e.layers.eachLayer(function(layer) {
    showPolygonArea({ layer: layer });
  });
}
function showPolygonArea(e) {

    // console.log(JSON.stringify(e.layer.editing.latlngs))
  featureGroup.clearLayers();
  featureGroup.addLayer(e.layer);
  e.layer.bindPopup((LGeo.area(e.layer) / 1000000).toFixed(2) + ' km<sup>2</sup>');
  e.layer.openPopup();

  document.getElementById('polygone_dessiner').innerHTML='Polygone('+(LGeo.area(e.layer) / 1000000).toFixed(2) + ' km<sup>2</sup>'+') <br>'+JSON.stringify(e.layer.editing.latlngs)
  var pol =JSON.stringify(e.layer.editing.latlngs)
          //envoi du point recuperer sur le controller
        $.post("<?= base_url('Sig/enregistrer_polygone_dessiner') ?>",
        {
            mypolygone:pol

        },
        function(data){

         document.getElementById('polygone_dessiner_2').innerHTML =data
         location.reload();
        // console.log(data)
        }); 

}
//drow a polygon



var latlngss = [
<?= $mes_polygon ?>
];
var polygon = L.polygon(latlngss, {color: 'red'}).addTo(map);

</script>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?= base_url() ?>assets/bootstrap/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?= base_url() ?>assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>