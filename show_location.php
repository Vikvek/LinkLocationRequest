<?php
require 'settings.php';

if (isset($_GET['code'])) {
  $code = $_GET['code'];

  if (isset($_POST['latitude']) && isset($_POST['longitude'])) {
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    $stmt = $conn->prepare("UPDATE tracking_links SET latitude = ?, longitude = ?, is_opened = 1 WHERE pageid = ? AND is_expired = 0");
    if ($stmt) {
      $stmt->bind_param("dds", $latitude, $longitude, $code);
      $stmt->execute();
      $stmt->close();
      header("Location: kiitos.php");
    } else {
    }
  }
}
?>
<html>
<head>
  <meta charset='utf-8' />
  <title>Show Location</title>
<script>
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        alert("Geolocation is not supported by this browser.");
    }
}

function showPosition(position) {
    // Save the latitude and longitude to variables
    var lat = position.coords.latitude;
    var long = position.coords.longitude;
    
    // Submit the form with the latitude and longitude
    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", "");
    
    var latitude = document.createElement("input");
    latitude.setAttribute("type", "hidden");
    latitude.setAttribute("name", "latitude");
    latitude.setAttribute("value", lat);
    form.appendChild(latitude);
    
    var longitude = document.createElement("input");
    longitude.setAttribute("type", "hidden");
    longitude.setAttribute("name", "longitude");
    longitude.setAttribute("value", long);
    form.appendChild(longitude);
    
    document.body.appendChild(form);
    form.submit();
}
</script>
</head>
<body onload="getLocation()">
  <?php
    if (isset($_GET['error']) && $_GET['error'] == 1) {
      echo '<button onclick="getLocation()">Allow Location Access</button>';
    }
  ?>
  <form id="form" action="" method="post">
    <input type="hidden" id="latitude" name="latitude" />
    <input type="hidden" id="longitude" name="longitude" />
  </form>
</body>
</html>