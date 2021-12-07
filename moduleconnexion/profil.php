<?php
session_start();
$msg = "";
$bdd = new PDO("mysql:host=localhost;dbname=moduleconnexion", "root", "");
if ($_SESSION != true) {
   header('location: connexion.php ');
}
// si une session existe
if (isset($_SESSION['id'])) {
   $requet =  $bdd->prepare("SELLECT * FROM utilisateurs WHERE id = ? ");
   $requet->execute(array($_SESSION['id']));
   $user = $requet->fetch();

   //Si ma variable existe et qu'elle n'est pas vide et que elle est différente de la nouvelle valeur insérée
   if (isset($_POST['newlogin']) && !empty($_POST['newlogin']) && $_POST['newlogin'] != $user['login']) {

      $newlogin = htmlspecialchars($_POST['newlogin']);
      $insertpseudo = $bdd->prepare("UPDATE utilisateurs SET login = ? WHERE id = ?");
      $insertpseudo->execute(array($newlogin, $_SESSION['id']));
      header('Location: profil.php?id=' . $_SESSION['id']);
   }

   if (isset($_POST['newprenom']) && !empty($_POST['newprenom']) && $_POST['newprenom'] != $user['prenon']) {

      $newprenom = htmlspecialchars($_POST['newprenom']);
      $insertprenom = $bdd->prepare("UPDATE utilisateurs SET prenom = ? WHERE id = ?");
      $insertprenom->execute(array($newprenom, $_SESSION['id']));
      header('Location: profil.php?id=' . $_SESSION['id']);
   }

   if (isset($_POST['newnom']) && !empty($_POST['newnom']) && $_POST['newnom'] != $user['nom']) {

      $newnom = htmlspecialchars($_POST['newnom']);
      $insertnom = $bdd->prepare("UPDATE utilisateurs SET nom = ? WHERE id = ?");
      $insertnom->execute(array($newnom, $_SESSION['id']));
      header('Location: profil.php?id=' . $_SESSION['id']);
   }


   if (isset($_POST['newmdp1']) && !empty($_POST['newmdp1']) && isset($_POST['newmdp2']) && !empty($_POST['newmdp2'])) {
      $mdp1 = md5($_POST['newmdp1']);
      $mdp2 = md5($_POST['newmdp2']);
      if ($mdp1 == $mdp2) {

         $insertmdp = $bdd->prepare("UPDATE utilisateurs SET password = ? WHERE id = ?");
         $insertmdp->execute(array($mdp1, $_SESSION['id']));
         header('Location: profil.php?id=' . $_SESSION['id']);
      } else {
         $msg = 'vos deux mots de passes ne correspondent pas !';
      }
   }
}






?>

<html id="htmlprof">

<head>
   <title>TUTO PHP</title>
   <meta charset="utf-8">
   <link rel="stylesheet" href="style.css">
</head>

<body>
   <header id="headerprofil">
   <div>
      <h2 id="titremp">Edition de mon profil</h2>
      </header>
      <div class="conteneur">
         <div class="flexform">

            <form id="formp" method="POST" action="" enctype="multipart/form-data" >
               <label>Pseudo :</label> <br>
               <input type="text" name="newlogin" placeholder="Pseudo" value="<?php echo @$_SESSION['login']; ?>" /><br /><br />
               <label>Prenom :</label> <br>
               <input type="text" name="newprenom" placeholder="prenom" value="<?php echo @$_SESSION['prenom']; ?>" /><br /><br />
               <label>Nom :</label> <br>
               <input type="text" name="newnom" placeholder="prenom" value="<?php echo @$_SESSION['nom']; ?>" /><br /><br />
               <label>Mot de passe :</label> <br>
               <input type="password" name="newmdp1" placeholder="Mot de passe" /><br /><br />
               <label>Confirmation - mot de passe :</label> <br>
               <input type="password" name="newmdp2" placeholder="Confirmation du mot de passe" /><br /><br />
               <input id="input" type="submit" value="Update profil" /> <br>
            </form>
            <?php if (isset($msg)) {
               echo $msg;
            } ?>
         </div>
      </div>
   </div>
   <div>
      <footer id="stickyfooter">
         <p>Me contacter : dorian.di-russo@laplateforme.io</p>
      </footer>
   </div>
</body>

</html>