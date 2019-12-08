
    <div id="map" style="height:100%"></div>
    <script>
	function initMap() {
        var uluru = {lat: <?php echo $_GET['lat'] ?>, lng: <?php echo $_GET['lang'] ?>};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 20,
          center: uluru
        });
        var marker = new google.maps.Marker({
          position: uluru,
          map: map
        });
      }
	
  </script>
  <script async defer
			src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAvEepNSTSu72UOs_qCJwaP1lKiKtohkxc&callback=initMap">
			</script>
    <?php

?>