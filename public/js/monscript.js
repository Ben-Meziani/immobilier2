(function() {
    var placesAutocomplete = places({
      appId: 'pl78R985QT1Y',
      apiKey: '0dff740c1b94d2403d8b835b349cf90b',
      container: document.querySelector('#property_address')
    });
   
    var map = L.map('map-example-container', {
      scrollWheelZoom: false,
      zoomControl: false
    });
  
    var osmLayer = new L.TileLayer(
      'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        minZoom: 1,
        maxZoom: 13,
        attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
      }
    );
  
    var markers = [];
  
    map.setView(new L.LatLng(0, 0), 1);
    map.addLayer(osmLayer);
  
    placesAutocomplete.on('suggestions', handleOnSuggestions);
    placesAutocomplete.on('cursorchanged', handleOnCursorchanged);
    placesAutocomplete.on('change', handleOnChange);
    placesAutocomplete.on('clear', handleOnClear);
  
    function handleOnSuggestions(e) {
      markers.forEach(removeMarker);
      markers = [];
  
      if (e.suggestions.length === 0) {
        map.setView(new L.LatLng(0, 0), 1);
        return;
      }
  
      e.suggestions.forEach(addMarker);
      findBestZoom();
    }
  
    function handleOnChange(e) {
      markers
        .forEach(function(marker, markerIndex) {
          if (markerIndex === e.suggestionIndex) {
            markers = [marker];
            marker.setOpacity(1);
            findBestZoom();
          } else {
            removeMarker(marker);
          }
        });
      // tout se passe ici ! dans cette fonction
      // au moment où l'adresse est sélectionnée, dans la variable e tu retrouves e.city avec le nom de la ville et e.postCode avec le code postal
      // tu peux les prendre et les insérer dans tes deux autres input 
      console.log(e);
      var postCodeInput = document.querySelector("#property_postal_code");
      postCodeInput.value = e.suggestion.postcode;
      var cityInput = document.querySelector("#property_city");
      cityInput.value = e.suggestion.city;
    }
  
    function handleOnClear() {
      map.setView(new L.LatLng(0, 0), 1);
      markers.forEach(removeMarker);
    }
  
    function handleOnCursorchanged(e) {
      markers
        .forEach(function(marker, markerIndex) {
          if (markerIndex === e.suggestionIndex) {
            marker.setOpacity(1);
            marker.setZIndexOffset(1000);
          } else {
            marker.setZIndexOffset(0);
            marker.setOpacity(0.5);
          }
        });
    }
  
    function addMarker(suggestion) {
      var marker = L.marker(suggestion.latlng, {opacity: .4});
      marker.addTo(map);
      markers.push(marker);
    }
  
    function removeMarker(marker) {
      map.removeLayer(marker);
    }
  
    function findBestZoom() {
      var featureGroup = L.featureGroup(markers);
      map.fitBounds(featureGroup.getBounds().pad(0.5), {animate: false});
    }
  })();