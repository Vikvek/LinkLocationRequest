<?php
$yourpage = "localhost";
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tracker";
$mapboxapi = "<YOURMAPBOXAPIHERE>";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS `tracking_links` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `pageid` VARCHAR(7) NOT NULL COLLATE 'utf8mb4_General_ci',
  `code_creator` VARCHAR(255) NULL COLLATE 'utf8mb4_general_ci',
  `timestamp` DATETIME NOT NULL,
  `is_opened` TINYINT(1) NOT NULL DEFAULT '0',
  `is_expired` TINYINT(1) NOT NULL DEFAULT '0',
  `latitude` FLOAT(12) NULL DEFAULT NULL,
  `longitude` FLOAT(12) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `pageid` (`pageid`) USING BTREE
)
COLLATE='utf8mb4_General_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1
";

if ($conn->query($sql) === TRUE) {
  echo "Table tracking_links created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}

$expired_time = time() - 900; // 15 minutes ago
$stmt = $conn->prepare("UPDATE tracking_links SET is_expired = 1 WHERE timestamp < FROM_UNIXTIME(?)");
$stmt->bind_param("i", $expired_time);
$stmt->execute();

$conn->close();
?>
