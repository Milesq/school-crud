<?php
$conn = @new mysqli("db", "root", "password", "my");
$err = $conn->connect_error;

if($err) {
  die("Connection failed: ".$err);
}

return $conn;
