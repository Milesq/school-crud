<?php
$conn = require './db.php';
$msg = isset($_GET['deleted'])? 'user has been deleted succesfully :-)' : '';

function deleteUser($id) {
  global $conn;
  $sql = "delete from baza where ID=$id";
  $conn->query($sql);
}

if(isset($_POST['toRemove'])) {
  $id = $_POST['toRemove'];
  deleteUser($id);
  header('Location: ./deleteUser.php?deleted=true');
}

$result = $conn->query("SELECT * from baza");
$conn->close();

if($result->num_rows === 0) $msg .= "0 results";

$rows = array_map(function($row) {
  $ret = '';
  foreach ($row as $key => $value) {
    if ($key !== 'ID')
      $ret .= "$key: $value, ";
  }
  return $ret;
}, $result->fetch_all(MYSQLI_ASSOC));
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Usun uzytkownika</title>
</head>
<body>
  <header><h1>Wyświetl Wszystkich Użytkowników</h1></header>
  <section>
    <?php require 'menu.html'; ?>
    <main>
      <div class="center-column">
          <form method="POST">
            <input type="hidden" name="toRemove">
          </form>

        <div class="center-column">
          <?= $msg ?>

          <?php foreach ($rows as $key => $row): ?>
            <div class="user" data-id="<?= $key ?>">
              <svg class="trash" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M3 6v18h18v-18h-18zm5 14c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4-18v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.315c0 .901.73 2 1.631 2h5.712z"/></svg>
              <?= $row ?>
            </div>
          <?php endforeach; ?>
      </div>
    </div>
    </main>
  </section>
  <footer>
    <h3>Miłosz Wiśniewski</h3>
  </footer>

  <script defer>
    const deleteForm = document.forms[0];

    const deleteListener = id => () => {
      deleteForm.toRemove.value = id;
      deleteForm.submit();
    };

    document.querySelectorAll('.user')
      .forEach(el => {
        const { dataset: { id } } = el;

        el.addEventListener('click', deleteListener(id));
      });
  </script>
</body>
</html>
