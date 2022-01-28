<?php
$conn = require './db.php';
$result = $conn->query("SELECT * from baza");
$conn->close();
$data = json_encode($result->fetch_all(MYSQLI_ASSOC));
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
      <div id="app" class="center-column"></div>
      <script type="text/x-template" id="main-template">
        <div class="center-column">
            <User
              v-for="(user, i) in users"
              :key="i"
              @save="save({...$event, id: user.ID})"
              :name="user.Imie"
              :surname="user.Nazwisko"
              :avg="user.Srednia"
              class="user" />
        </div>
      </script>
    </main>
  </section>
  <footer>
    <h3>Miłosz Wiśniewski</h3>
  </footer>

  <script type="text/x-template" id="user-template">
    <div v-if="edit">
      <SaveBox @click="toggle" />
      <input v-model="user.name" />
      <input v-model="user.surname" />
      <input v-model="user.avg" />
    </div>
    <div v-else>
      <EditBox @click="toggle" />
      {{ user.name }}
      {{ user.surname }}
      {{ user.avg }}
    </div>
  </script>

  <script src="https://unpkg.com/vue@next"></script>
  <script>
    function objToFormData(obj) {
      const formData = new FormData();

      for (const key in obj) {
          formData.append(key, obj[key]);
      }

      return formData;
    }

    const User = {
      template: '#user-template',
      props: {
        name: String,
        surname: String,
        avg: String,
      },
      setup(props, { emit }) {
        const edit = Vue.ref(false);
        const user = Vue.reactive({
          name: props.name,
          surname: props.surname,
          avg: props.avg,
        });

        function toggle() {
          edit.value = !edit.value;
        }

        Vue.watch(edit, edit => {
          if (!edit) emit('save', {...user});
        });

        return {
          edit,
          user,
          toggle,
        };
      },
    };

    const App = {
      template: '#main-template',
      data: () => ({
        users: <?= $data ?>,
      }),
      methods: {
        async save(user) {
          const data = objToFormData(user);
          console.log(data);

          await fetch('./update.php', {
            method: 'POST',
            body: data,
          });

          alert('User saved');
        },
      },
      components: {
        User,
      },
    };

    Vue
      .createApp(App)
      .component('EditBox', { template: '<svg class="edit-box" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M18 14.45v6.55h-16v-12h6.743l1.978-2h-10.721v16h20v-10.573l-2 2.023zm1.473-10.615l1.707 1.707-9.281 9.378-2.23.472.512-2.169 9.292-9.388zm-.008-2.835l-11.104 11.216-1.361 5.784 5.898-1.248 11.103-11.218-4.536-4.534z"/></svg>' })
      .component('SaveBox', { template: '<svg class="save-box" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M22 2v22h-20v-22h3c1.23 0 2.181-1.084 3-2h8c.82.916 1.771 2 3 2h3zm-11 1c0 .552.448 1 1 1 .553 0 1-.448 1-1s-.447-1-1-1c-.552 0-1 .448-1 1zm9 1h-4l-2 2h-3.897l-2.103-2h-4v18h16v-18zm-13 9.729l.855-.791c1 .484 1.635.852 2.76 1.654 2.113-2.399 3.511-3.616 6.106-5.231l.279.64c-2.141 1.869-3.709 3.949-5.967 7.999-1.393-1.64-2.322-2.686-4.033-4.271z"/></svg>' })
      .mount('#app');
  </script>
</body>
</html>
