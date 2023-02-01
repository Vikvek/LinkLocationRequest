<?php
require 'settings.php';

$code_creator = $_POST['code_creator'];
$pageid = generatePageId();

$stmt = $conn->prepare("INSERT INTO tracking_links (pageid, code_creator, timestamp) VALUES (?, ?, CURRENT_TIMESTAMP)");
if ($stmt) {
  $stmt->bind_param("ss", $pageid, $code_creator);
  if ($stmt->execute()) {
    echo "$yourpage/find.php?code=$pageid";
  } else {
    echo "Error executing the query: " . $stmt->error;
  }
} else {
  echo "Error preparing the statement: " . $conn->error;
}

function generatePageId() {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $characters_length = strlen($characters);
  $pageid = '';
  for ($i = 0; $i < 7; $i++) {
    $pageid .= $characters[mt_rand(0, $characters_length - 1)];
  }
  return $pageid;
}
?>