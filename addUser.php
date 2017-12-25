<?php
$conn = require './db.php';
$areFieldsPresented = require './areFieldsPresented.php';
$destructureAssocArray = require './destructureAssocArray.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Dodawanie Użytkownika</title>
</head>
<body>
  <header><h1>Dodawanie Użytkownika</h1></header>
  <section>
    <?php require 'menu.html'; ?>
    <main>
      <form method="POST" class="form-border center-column">
        Imię: <input type="text" name="imie">
        Nazwisko: <input type="text" name="nazwisko">
        Średnia: <input type="text" name="srednia">
        <input type="submit" name="sbm">
      </form>
      <div class="center">
        <?php
          $fields = ['imie', 'nazwisko', 'srednia'];
          if ($areFieldsPresented($_POST, 'sbm', ...$fields)){
            [$name, $surname, $avg] = $destructureAssocArray($_POST, ...$fields);

            $sql = "INSERT INTO baza (Imie, Nazwisko, Srednia) VALUES ('$name', '$surname', $avg)";

            if($conn->query($sql)){
              echo "Dodano użytkownika";
            } else {
              echo "blad ".$conn->error;
            }
          }
        ?>
      </div>
    </main>
  </section>
  <footer>
    <h3>Miłosz Wiśniewski</h3>
    </footer>
</body>
</html>
