<?php
require 'settings.php';

if (isset($_GET['code'])) {
  $code = $_GET['code'];

  $stmt = $conn->prepare("SELECT * FROM tracking_links WHERE pageid = ? AND is_expired = 0");
  if ($stmt) {
    $stmt->bind_param("s", $code);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
?>
<!DOCTYPE html>
<html>
<head>
  <title>Anna sijainti</title>
  <link href="style/style.css" rel="stylesheet" type="text/css" media="all"/>
</head>
<body>
<div class="main-content">
  <div class="logo-container">
    <img src="logo.png" alt=":3">
  </div>
  <div class="list">
    <ul>
      <li class="box">
		<center>
        <h1>Sijainti pyyntö</h1>
		</center>
      </li>
      <li class="box">
		<h2><u><color="red">Varoitus</color></u></h2>
        <p>Jos painat hyväksy nappia, sijaintisi nykyinen sijaintisi tallennetaan ja se näytetään linkin lähettäjälle</p>
		<p>Sijainnin pyytäjä: Null</p>
      </li>
      <form action="show_location.php?code=<?php echo $_GET['code']; ?>" method="post">
        <input class="green-button" type="submit" value="Hyväksy ehdot">
      </form>
    </ul>
  </div>
</div>
</body>
</html>
<?php
    } else {
      echo '<h2>Väärä koodi tai koodi on vanhentunut</h2>';
    }
    $stmt->close();
  } else {
  }
} else {
  echo '<h2>Koodia ei ole asetettu</h2>';
}
?>
