<?php
date_default_timezone_set("Africa/Lagos"); // Or your correct timezone
echo json_encode([
  "server_time" => date("c")
]);
?>