<!DOCTYPE html>
<html>
  <?php include "header.php"; //Contains header and styling ?> 
  <body>
    <h2>Tracking Link Generator</h2>
    <form action="create_link.php" method="post">
      <input type="hidden" name="code_creator" value="<?php echo $_SESSION['username']; ?>">
      <input type="submit" value="Create Link">
    </form>
    <table>
      <tr>
        <th>Code</th>
		<th>Opened</th>
        <th>Location</th>
      </tr>
      <?php
	  include "settings.php"; //Contains mysql connection files
      $username = $_SESSION['username']; 
 //     $query = "SELECT pageid, latitude, longitude FROM tracking_links WHERE code_creator='$username'"; 
      $query = "SELECT pageid, latitude, longitude, is_opened FROM tracking_links WHERE is_expired != '1'";
      $result = mysqli_query($conn, $query);
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['pageid'] . "</td>";
        echo "<td>" . $row['is_opened'] . "</td>";
        echo "<td><button onclick='showLocation(" . $row['latitude'] . "," . $row['longitude'] . ")'> Show on map</button></td>";
        echo "</tr>";
      }
      ?>
    </table>
    <div id="map"></div>
 <script>
    var map;
    var marker;
	askLocation();
function askLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showLocation);
  } else {
    alert("Geolocation is not supported by this browser.");
  }
}
function showLocation(position) {
  if (arguments.length === 2) {
    var lat = arguments[0];
    var lon = arguments[1];
  } else {
    var lat = position.coords.latitude;
    var lon = position.coords.longitude;
  }
  mapboxgl.accessToken = '<?php $mapboxapi?>;';
  map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [lon, lat],
    zoom: 14
  });
  marker = new mapboxgl.Marker({
    draggable: true
  })
    .setLngLat([lon, lat])
    .addTo(map);
}
  </script>
  </body>
</html>