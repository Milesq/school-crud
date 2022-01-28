<?php
  $conn = require './db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Wyświetl Wszystkich Użytkowników</title>
</head>
<body>
  <header><h1>Wyświetl Wszystkich Użytkowników</h1></header>
  <section>
    <?php require 'menu.html'; ?>
    <main>
      <div class="center-border">
        <?php
        $result = $conn->query("SELECT * FROM baza");

        if($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            echo "ID: " . $row["ID"] . " Imie: " . $row["Imie"] . " Nazwisko: " . $row["Nazwisko"] . "Średnia: " . $row["Srednia"] ."<br>";
          }
        } else {
          echo "0 results";
        }

        $conn->close();
        ?>
      </div>
    </main>
  </section>
  <footer>
    <h3>Miłosz Wiśniewski</h3>
    </footer>
</body>
</html>
