<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        width:50%;
        height:70%;
      }
      #floating-panel {
        position: absolute;
        top: 10px;
        left: 25%;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
        text-align: center;
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
      }
    </style>
  </head>
  <body>
    <div id="floating-panel">
       <input onclick="showMarkers();" type='button' value="Show All Markers">
    </div>
    <div id="map"></div>
	<div><input type="number" id="taille" onchange='change()'></div>
    <script>

  var mesMark = [];
  var map;
  var panel;
  var cercle;
  var tailleCercle=[];
  var monCercle;

  
function change(){
	var myLatLng1 = {lat: 44.566667, lng: 6.083333};
	monCercle = new google.maps.Circle(null);
	tailleCercle[0]=document.getElementById('taille').value*1;
	cercle ={
	map: map,
	center: myLatLng1,
	radius: tailleCercle[0]
  }
  monCercle = new google.maps.Circle(cercle);
}
function initMap() {

  var trajet1 = ['Gap','Valence','Toulouse','','','','Paris'];
  var trajet2 = ['Lyon','','','','','','Rennes'];
  var trajet3 = ['Marseille','','','','','','Paris'];
  var toutLesTrajets = [trajet1,trajet2,trajet3];
  map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: 46.797, lng: 2.544},
    zoom: 6
  });

  var myLatLng1 = {lat: 44.566667, lng: 6.083333};
	var myLatLng2 = {lat: 45.764043, lng: 4.835658999999964};
	var myLatLng3 = {lat: 43.296482, lng: 5.369779999999992};
	var tableau = [myLatLng1, myLatLng2, myLatLng3];
	
	
	for(let cpt=0; cpt < tableau.length;cpt++){

	  let infowindow = new google.maps.InfoWindow({
		  content: toutLesTrajets[cpt][0]
	  });
		mesMark[cpt] = new google.maps.Marker({
			position: tableau[cpt],
			map: map,
			title: ''
		 });
		mesMark[cpt].addListener('click', function() {
			map.setCenter(myLatLng1);
			infowindow.open(map, mesMark[cpt]);
      setMapOnAll(null,cpt);
      direction = new google.maps.DirectionsRenderer({
          map   : map, 
          panel : panel
      });
          origin      = toutLesTrajets[cpt][0]; // Le point départ
          destination =  toutLesTrajets[cpt][6]; // Le point d'arrivé
          var request = {
            origin      : origin,
            destination : destination,
			avoidHighways: true,
			waypoints: [
			  {
				location: 'Valence',
				stopover:true
			  },{
				location: 'Marseille',
				stopover:true
			  }],
            travelMode  : google.maps.DirectionsTravelMode.DRIVING // Type de transport
          }
          var directionsService = new google.maps.DirectionsService(); // Service de calcul d'itinéraire
          directionsService.route(request, function(response, status){ // Envoie de la requête pour calculer le parcours
            if(status == google.maps.DirectionsStatus.OK){
               direction.setDirections(response); // Trace l'itinéraire sur la carte et les différentes étapes du parcours
            }
          }); //http://code.google.com/intl/fr-FR/apis/maps/documentation/javascript/reference.html#DirectionsRequest
		});



    function setMapOnAll(map,cpt) {
      for (var i = 0; i < mesMark.length; i++) {
        if (i!=cpt){
          mesMark[i].setMap(map);
        }
      }
    }

	}
}


function showMarkers() {
  for (var i = 0; i < mesMark.length; i++) {
    mesMark[i].setMap(map);
  }
}




    </script>
    <script src="https://maps.googleapis.com/maps/api/js?signed_in=true&callback=initMap&key=AIzaSyBG7UMpAqWGL9dA_zbG3Safn8TqYI4x2hs"
        async defer></script>
  </body>
</html>