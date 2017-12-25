<?php
$conn = @new mysqli("localhost", "root", "", "test");
$err = $conn->connect_error;

if($err) {
  die("Connection failed: ".$err);
}

return $conn;
