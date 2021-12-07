<?php

session_start();
$serveur = "localhost";
$dbname = "moduleconnexion";
$user = "root";
$pass = "";
$message = "";

try {

  $log = new PDO("mysql:host=$serveur;dbname=$dbname", $user, $pass);
  $log->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  @$password = md5($_POST['password']);
  @$login = $_POST['login'];


  if (isset($_POST['submit'])) {
    if (empty($_POST["login"]) || empty($_POST["password"])) {
      $message = 'tout les champs sont requis';
    } else {
      $query = "SELECT * FROM utilisateurs WHERE login = :login AND password = :password";
      $statement = $log->prepare($query);
      $statement->execute(
        array(
          'login' => $login,
          'password' => $password
        )
      );

      $count = $statement->rowCount();
      if ($count == 1) {
        $resultat = $statement->fetch();
        $_SESSION["login"] = $resultat['login'];
        $_SESSION['nom'] = $resultat['nom'];
        $_SESSION['prenom'] = $resultat['prenom'];
        $_SESSION['password'] = $resultat['password'];
        $_SESSION['id'] = $resultat['id'];

        if ($_POST['login'] == 'admin') {
          header("location: admin.php");
        }
      } else {
        $message = 'erreur';
      }
    }
  }
}
// Erreurx
catch (PDOException $e) {
  echo 'Impossible de traiter les données. Erreur : ' . $e->getMessage();
}



// var_dump($_SESSION);


?>


<html id="html2">

<head>
  <link rel="stylesheet" href="style.css">
</head>

<body>
<div class="stickyf">
  <header id="headerc">
    <div class="flexa">
      <p> <a href="index.php"> Acceuil</a></p>
    </div>

    <?php
    if ($_SESSION == true) {
      echo  '<div class="flexb">
      <p> <a href="profil.php"> Modifier profil</a> </p>
    </div>';
    }
    ?>
  </header>





  <div class="container">
    <form id="formco" action="connexion.php" method="post">


      <label for="login"><b>Login</b></label> <br>
      <input type="text" placeholder="Enter Username" id="login" name="login"> <br>

      <label for="password"><b>Mot de passe</b></label> <br>
      <input type="password" placeholder="Enter Password" id="password" name="password"> <br> <br>

      <?php

      if ($_SESSION != true) {

        echo     '<input type="submit" name="submit" placeholder="Connexion"></input> <br>';
      }

      if ($_SESSION == true) {

        echo '<a href="logout.php">déconnexion</a>';
      }
      ?>

    </form>
  </div>
 
  <footer id="d">
  <p>Me contacter : dorian.di-russo@laplateforme.io</p>
  </footer>
  </div>
</body>

</html>


<?php



?>