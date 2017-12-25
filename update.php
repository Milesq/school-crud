<?php
$areFieldsPresented = require './areFieldsPresented.php';
$destructureAssocArray = require './destructureAssocArray.php';
$query = require './db.php';

$fields = ['id', 'name', 'surname', 'avg'];

if (!$areFieldsPresented($_POST, ...$fields)) {
  http_response_code(400);
  die("Bad Request - missing $key field");
}

[$id, $name, $surname, $avg] = $destructureAssocArray($_POST, ...$fields);

$query->query("UPDATE baza SET Imie='$name', Nazwisko='$surname', Srednia=$avg WHERE ID=$id");
