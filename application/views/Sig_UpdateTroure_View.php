<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>SIG</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Import Mapbox GL JS -->
	
    <!-- <script src="https://api.tiles.mapbox.com/mapbox-gl-js/v2.8.1/mapbox-gl.js"></script> -->
	<script src="<?=base_url()?>assets/mapi/js/mapbox-gl.js"></script>
    <!-- <link
      href="https://api.tiles.mapbox.com/mapbox-gl-js/v2.8.1/mapbox-gl.css"
      rel="stylesheet"
    /> -->
    <link
      href="<?=base_url()?>assets/mapi/css/mapbox-gl.css"
      rel="stylesheet"
    />
    <!-- Import Mapbox GL Directions -->
    <!-- <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.0.2/mapbox-gl-directions.js"></script> -->

    <script src="<?=base_url()?>assets/mapi/js/mapbox-gl-directions.js"></script>

	<!-- <link
      rel="stylesheet"
      href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.0.2/mapbox-gl-directions.css"
      type="text/css"
    /> -->

	<link
      rel="stylesheet"
      href="<?=base_url()?>assets/mapi/css/mapbox-gl-directions.css"
      type="text/css"
    />	

    <!-- Import Turf & Polyline -->
    <!-- <script src="https://npmcdn.com/@turf/turf/turf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mapbox-polyline/1.1.1/polyline.js"></script> -->
     <script src="<?=base_url()?>assets/mapi/js/turf.min.js"></script>
    <script src="<?=base_url()?>assets/mapi/js/polyline.js"></script>

    <style>
      body {
        margin: 0;
        padding: 0;
        font-family: 'Open Sans', sans-serif;
      }

      #map {
        position: absolute;
        top: 50px;
        bottom: 0;
        width: 100%;
				height: 700px;
      }

      .sidebar {
        position: absolute;
        margin: 20px 20px 30px 20px;
        width: 25%;
        top: 50px;
        bottom: 0;
        padding: 20px;
        background-color: #ff9;
        overflow-y: scroll;
      }

      .card {
        font-size: small;
        border-bottom: solid #d3d3d3 2px;
        margin-bottom: 6px;
      }

      .card-header {
        font-weight: bold;
        padding: 6px;
      }

      .no-route {
        background-color: #d3d3d3;
        color: #f00;
      }

      .obstacle-found {
        background-color: #d3d3d3;
        color: #fff;
      }

      .route-found {
        background-color: #33a532;
        color: #fff;
      }

      .card-details {
        padding: 3px 6px;
      }
    </style>
	<link href="<?=base_url()?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  </head>

  <body>
	<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">
        SIG
			</a>
    </div>
  </div>
</nav>
    <div id="map"></div>
    <div class="sidebar">
	<span style="float:right"><a class="alert alert-info" href='<?= base_url('Sig_Updade')?>'>Quitter</a></span>
      <h1>Constant</h1>
	  
      <div id="reports"></div>
    </div>

    <script>
      mapboxgl.accessToken = 'pk.eyJ1IjoiY2Flc2FyMiIsImEiOiJjazNzaW5sNDcwNjBmM2NsZnF4N3dmdW1tIn0.-IuuEG4L2f33CQdxVic6Yw';
      const map = new mapboxgl.Map({
        container: 'map', // Specify the container ID
        style: 'mapbox://styles/mapbox/light-v10', // Specify which map style to use, 
        center: [29.36782,-3.36040], // Specify the starting position [lng, lat]
        zoom: 13 // Specify the starting zoom
      });

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



      const directions = new MapboxDirections({
        accessToken: mapboxgl.accessToken,
        unit: 'metric',
        profile: 'mapbox/driving',
        alternatives: false,
        geometries: 'geojson',
        controls: { instructions: false },
        flyTo: false
      });

      map.addControl(directions, 'top-right');
      map.scrollZoom.enable();

      const clearances = {
        type: 'FeatureCollection',
        features: [
          {
            type: 'Feature',
            geometry: {
              type: 'Point',
              coordinates: [-84.47426, 38.06673]
            },
            properties: {
              clearance: "13' 2"
            }
          },
          {
            type: 'Feature',
            geometry: {
              type: 'Point',
              coordinates: [-84.47208, 38.06694]
            },
            properties: {
              clearance: "13' 7"
            }
          },
          {
            type: 'Feature',
            geometry: {
              type: 'Point',
              coordinates: [-84.60485, 38.12184]
            },
            properties: {
              clearance: "13' 7"
            }
          },
          {
            type: 'Feature',
            geometry: {
              type: 'Point',
              coordinates: [-84.61905, 37.87504]
            },
            properties: {
              clearance: "12' 0"
            }
          },
          {
            type: 'Feature',
            geometry: {
              type: 'Point',
              coordinates: [-84.55946, 38.30213]
            },
            properties: {
              clearance: "13' 6"
            }
          },
          {
            type: 'Feature',
            geometry: {
              type: 'Point',
              coordinates: [-84.27235, 38.04954]
            },
            properties: {
              clearance: "13' 6"
            }
          },
          {
            type: 'Feature',
            geometry: {
              type: 'Point',
              coordinates: [-84.27264, 37.82917]
            },
            properties: {
              clearance: "11' 6"
            }
          }
        ]
      };

      const obstacle = turf.buffer(clearances, 0.25, { units: 'kilometers' });
      let bbox = [0, 0, 0, 0];
      let polygon = turf.bboxPolygon(bbox);

      map.on('load', () => {
        map.addLayer({
          id: 'clearances',
          type: 'fill',
          source: {
            type: 'geojson',
            data: obstacle
          },
          layout: {},
          paint: {
            'fill-color': '#f03b20',
            'fill-opacity': 0.5,
            'fill-outline-color': '#f03b20'
          }
        });

        map.addSource('theRoute', {
          type: 'geojson',
          data: {
            type: 'Feature'
          }
        });

        map.addLayer({
          id: 'theRoute',
          type: 'line',
          source: 'theRoute',
          layout: {
            'line-join': 'round',
            'line-cap': 'round'
          },
          paint: {
            'line-color': '#cccccc',
            'line-opacity': 0.5,
            'line-width': 13,
            'line-blur': 0.5
          }
        });

        // Source and layer for the bounding box
		//Source et couche pour la boîte englobante
        map.addSource('theBox', {
          type: 'geojson',
          data: {
            type: 'Feature'
          }
        });
        map.addLayer({
          id: 'theBox',
          type: 'fill',
          source: 'theBox',
          layout: {},
          paint: {
            'fill-color': '#FFC300',
            'fill-opacity': 0.5,
            'fill-outline-color': '#FFC300'
          }
        });
      });

      let counter = 0;
      const maxAttempts = 50;
      let emoji = '';
      let collision = '';
      let detail = '';
      const reports = document.getElementById('reports');

      function addCard(id, element, clear, detail) {
        const card = document.createElement('div');
        card.className = 'card';
        // Add the response to the individual report created above
        const heading = document.createElement('div');
        // Set the class type based on clear value
        heading.className =
          clear === true
            ? 'card-header route-found'
            : 'card-header obstacle-found';
        heading.innerHTML =
          id === 0
            ? `${emoji} Le parcours ${collision}`
            : `${emoji} Parcours ${id} ${collision}`;

        const details = document.createElement('div');
        details.className = 'card-details';
        details.innerHTML = `Cela ${detail} les obstacles.`;

        card.appendChild(heading);
        card.appendChild(details);
        element.insertBefore(card, element.firstChild);
      }

      function noRoutes(element) {
        const card = document.createElement('div');
        card.className = 'card';
        // Add the response to the individual report created above
        const heading = document.createElement('div');
        heading.className = 'card-header no-route';
        emoji = '🛑';
        heading.innerHTML = `${emoji} Fin de la recherche.`;

        // Add details to the individual report
        const details = document.createElement('div');
        details.className = 'card-details';
        details.innerHTML = `Aucun itinéraire clair trouvé en ${counter} essais.`;

        card.appendChild(heading);
        card.appendChild(details);
        element.insertBefore(card, element.firstChild);
      }

      directions.on('clear', () => {
        map.setLayoutProperty('theRoute', 'visibility', 'none');
        map.setLayoutProperty('theBox', 'visibility', 'none');

        counter = 0;
        reports.innerHTML = '';
      });

      directions.on('route', (event) => {
        // Hide the route and box by setting the opacity to zero
        map.setLayoutProperty('theRoute', 'visibility', 'none');
        map.setLayoutProperty('theBox', 'visibility', 'none');

        if (counter >= maxAttempts) {
          noRoutes(reports);
        } else {
          // Make each route visible
          for (const route of event.route) {
            // Make each route visible
            map.setLayoutProperty('theRoute', 'visibility', 'visible');
            map.setLayoutProperty('theBox', 'visibility', 'visible');

            // Get GeoJSON LineString feature of route
            const routeLine = polyline.toGeoJSON(route.geometry);

            // Create a bounding box around this route
            // The app will find a random point in the new bbox
            bbox = turf.bbox(routeLine);
            polygon = turf.bboxPolygon(bbox);

            // Update the data for the route
            // This will update the route line on the map
            map.getSource('theRoute').setData(routeLine);

            // Update the box
            map.getSource('theBox').setData(polygon);

            const clear = turf.booleanDisjoint(obstacle, routeLine);

            if (clear === true) {
              collision = 'ne croise aucun obstacle !';
              detail = `prend ${(route.duration / 60).toFixed(
                0
              )} minutes et évite`;
              emoji = '✔️';
              map.setPaintProperty('theRoute', 'line-color', '#74c476');
              // Hide the box
              map.setLayoutProperty('theBox', 'visibility', 'none');
              // Reset the counter
              counter = 0;
            } else {
              // Collision occurred, so increment the counter
              counter = counter + 1;
              // As the attempts increase, expand the search area
              // by a factor of the attempt count
              polygon = turf.transformScale(polygon, counter * 0.01);
              bbox = turf.bbox(polygon);
              collision = 'est mauvais.';
              detail = `prend ${(route.duration / 60).toFixed(
                0
              )} minutes et coups`;
              emoji = '⚠️';
              map.setPaintProperty('theRoute', 'line-color', '#de2d26');

              // Add a randomly selected waypoint to get a new route from the Directions API
              const randomWaypoint = turf.randomPoint(1, { bbox: bbox });
              directions.setWaypoint(
                0,
                randomWaypoint['features'][0].geometry.coordinates
              );
            }
            // Add a new report section to the sidebar
            addCard(counter, reports, clear, detail);
          }
        }
      });
    </script>
  </body>
</html>
